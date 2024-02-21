<?php

namespace Drupal\external_entity\Entity;

use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Entity\EntityDisplayRepositoryInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityRepositoryInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\EntityViewBuilder;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Theme\Registry;
use Drupal\qm_core\SiteSettingsInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ProductViewBuilder extends EntityViewBuilder  {
  /**
   * The type of entities for which this view builder is instantiated.
   *
   * @var string
   */
  protected $entityTypeId;

  /**
   * Information about the entity type.
   *
   * @var \Drupal\Core\Entity\EntityTypeInterface
   */
  protected $entityType;

  /**
   * The entity repository service.
   *
   * @var \Drupal\Core\Entity\EntityRepositoryInterface
   */
  protected $entityRepository;

  /**
   * The entity display repository.
   *
   * @var \Drupal\Core\Entity\EntityDisplayRepositoryInterface
   */
  protected $entityDisplayRepository;

  /**
   * The cache bin used to store the render cache.
   *
   * @var string
   */
  protected $cacheBin = 'render';

  /**
   * The language manager.
   *
   * @var \Drupal\Core\Language\LanguageManagerInterface
   */
  protected $languageManager;

  /**
   * The theme registry.
   *
   * @var \Drupal\Core\Theme\Registry
   */
  protected $themeRegistry;

  /**
   * The EntityViewDisplay objects created for individual field rendering.
   *
   * @var \Drupal\Core\Entity\Display\EntityViewDisplayInterface[]
   *
   * @see \Drupal\Core\Entity\EntityViewBuilder::getSingleFieldDisplay()
   */
  protected $singleFieldDisplays;


  protected $entityTypeManager;
  /**
   * @var \Drupal\qm_core\SiteSettingsInterface $siteSettings;
   */
  public SiteSettingsInterface $siteSettings;

  /**
   * Constructs a new EntityViewBuilder.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   *   The entity type definition.
   * @param \Drupal\Core\Entity\EntityRepositoryInterface $entity_repository
   *   The entity repository service.
   * @param \Drupal\Core\Language\LanguageManagerInterface $language_manager
   *   The language manager.
   * @param \Drupal\Core\Theme\Registry $theme_registry
   *   The theme registry.
   * @param \Drupal\Core\Entity\EntityDisplayRepositoryInterface $entity_display_repository
   *   The entity display repository.
   */
  public function __construct(
    EntityTypeInterface $entity_type,
    EntityRepositoryInterface $entity_repository,
    LanguageManagerInterface $language_manager,
    Registry $theme_registry,
    EntityDisplayRepositoryInterface $entity_display_repository,
    EntityTypeManagerInterface $entityTypeManager,
  ) {
    parent::__construct($entity_type,  $entity_repository,  $language_manager,  $theme_registry,  $entity_display_repository);
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type) {
    return new static(
      $entity_type,
      $container->get('entity.repository'),
      $container->get('language_manager'),
      $container->get('theme.registry'),
      $container->get('entity_display.repository'),
      $container->get('entity_type.manager'),
    );
  }

  /**
   * @inerhitDoc
   */
  protected function getBuildDefaults(EntityInterface $entity, $view_mode) {
    $build = parent::getBuildDefaults($entity, $view_mode);
    $properties = $this->entityTypeManager->getDefinition('product')->get('properties');
    $compositeProperties = $this->entityTypeManager->getDefinition('product')->get('compositeProperties');
    $build['productDetails'] = [
      '#type' => 'table',
      '#header' => ['', ''],
      '#empty' => t('No data available.'),
      '#rows' => [],
    ];
    foreach ($properties as $key => $property) {
      if (in_array($view_mode, $property['viewModes']) && !$property['composite']) {
        $build['productDetails']['#rows'][] = [
          [
            'data' => [
              '#markup' => $property['lable'],
            ],
          ],
          [
            'data' => [
              '#markup' => $entity->get($key),
            ],
          ],
        ];
      }
    }
    foreach ($compositeProperties as $key => $compositeProperty) {
      if (in_array($view_mode, $compositeProperty['viewModes'])) {
        $data = [];
        foreach ($compositeProperty['properties'] as $property) {
          $data[] = $properties[$property]['lable'] .":" . $entity->get($key)->{$property};
        }
        $build['productDetails']['#rows'][] = [
          [
            'data' => [
              '#markup' => $compositeProperty['lable'],
            ],
          ],
          [
            'data' => [
              '#markup' => implode('<br>', $data),
            ],
          ],
        ];
      }
    }
    return $build;
  }
}
