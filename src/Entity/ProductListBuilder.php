<?php

namespace Drupal\external_entity\Entity;

use Drupal\Component\Utility\Html;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

class ProductListBuilder extends EntityListBuilder {
  public function render() {
    $build['table'] = [
      '#type' => 'table',
      '#header' => $this->buildHeader(),
      '#title' => $this->t('Products'),
      '#rows' => [],
      '#empty' => $this->t('There are no @label yet.', ['@label' => $this->entityType->getPluralLabel()]),
      '#cache' => [
        'contexts' => $this->entityType->getListCacheContexts(),
        'tags' => $this->entityType->getListCacheTags(),
      ],
    ];
    foreach ($this->load() as $entity) {
      if ($row = $this->buildRow($entity)) {
        $build['table']['#rows'][$entity->id()] = $row;
      }
    }

    // Only add the pager if a limit is specified.
    if ($this->limit) {
      $build['pager'] = [
        '#type' => 'pager',
      ];
    }
    return $build;
  }

  public function buildHeader() {
    $row['id'] = $this->t('ID');
    $row['title'] = $this->t('Title');
    $row['price'] = $this->t('Price');
    $row['category'] = $this->t('Category');
    $row['operations'] = $this->t('Operations');
    return $row;
  }

  public function buildRow(EntityInterface $entity) {
    $row['id'] = $entity->id();
    $row['title'] = Link::fromTextAndUrl(Html::escape($entity->label()),$entity->toUrl())->toString();
    $row['price'] = $entity->get('price');
    $row['category'] = $entity->get('category');
    $row['operations']['data'] = $this->buildOperations($entity);
    return $row;
  }

  protected function getEntityIds() {
    return $this->getStorage()->getProductIds();
  }
}
