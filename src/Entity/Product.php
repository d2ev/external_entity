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
 *   additional = {
 *     "properties" = {
 *       "title" = {"lable" = "Title", "type" = "string", "viewModes" = {"full", "teaser"}},
 *       "price" = {"lable" = "Price", "type" = "decimal", "viewModes" = {"full", "teaser"} },
 *       "category" = {"lable" = "Category", "type" = "string", "viewModes" = {"full", "teaser"}},
 *       "description" = {"lable" = "Description", "type" = "string", "viewModes" = {"full", "teaser"}},
 *       "image" = {"lable" = "Image", "type" = "image", "viewModes" = {"full", "teaser"}},
 *       "rate" = {"lable" = "Rate", "type" = "decimal", "viewModes" = {"full", "teaser"}, "composite" = TRUE},
 *       "count" = {"lable" = "Count", "type" = "integer", "viewModes" = {"full", "teaser"}, "composite" = TRUE},
 *     },
 *     "compositeProperties" = {
 *       "rating" = {"lable" = "Rating", "properties" = {"rate", "count"}, "viewModes" = {"full", "teaser"}},
 *     },
 *   }
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

  public function get($key) {
    return $this->{$key};
  }

  /**
   * {@inheritdoc}
   */
  public function isNew(): bool {
    return empty($this->id());
  }
}
