<?php

namespace Drupal\external_entity\Entity;

use Drupal\Core\Entity\EntityBase;

/**
 * @EntityType(
 *   id = "product",
 *   label = @Translation("Product"),
 *   label_collection = @Translation("Products"),
 *   handlers = {
 *     "view_builder" = "Drupal\external_entity\Entity\ProductViewBuilder",
 *     "list_builder" = "Drupal\external_entity\Entity\ProductListBuilder",
 *     "views_data" = "Drupal\external_entity\Entity\ProductViewsData",
 *     "access" = "Drupal\external_entity\Entity\ProductAccessControlHandler",
 *     "form" = {
 *       "default" = "Drupal\external_entity\Entity\ProductForm",
 *       "add" = "Drupal\external_entity\Entity\ProductForm",
 *       "edit" = "Drupal\external_entity\Entity\ProductForm",
 *       "delete" = "Drupal\external_entity\Entity\ProductDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\external_entity\Entity\ProductHtmlRouteProvider",
 *     },
 *     "storage" = "Drupal\external_entity\Entity\ProductStorage",
 *   },
 *   admin_permission = "administer products",
 *   entity_keys = {
 *     "id" = "id"
 *   },
 *   links = {
 *     "canonical" = "/product/{product}",
 *     "edit-form" = "/product/{product}/edit",
 *     "delete-form" = "/product/{product}/delete",
 *     "collection" = "/products"
 *   },
 *   additional = {}
 * )
 */
class Product extends EntityBase {
  public function __construct($values, $entity_type) {
    $values = (array) $values;
    parent::__construct($values, $entity_type);
  }

  public function isTranslatable() {
    return FALSE;
  }

  public function isRevisionable() {
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function id() {
    // Map to your unique id.
    return $this->id ?? NULL;
  }

  /**
   * @inheritDoc
   */
  public function label() {
    return $this->title ?? NULL;
  }

  public function set($key, $value) {
    $this->{$key} = $value;
  }

  /**
   * {@inheritdoc}
   */
  public function isNew(): bool {
    return empty($this->id());
  }
}
