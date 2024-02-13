<?php

namespace Drupal\external_entity\Entity;

use Drupal\Core\Entity\EntityListBuilder;

class ProductListBuilder extends EntityListBuilder {
  public function render() {
    $build = parent::render();
    return $build;
  }

  protected function getEntityIds() {
    return $this->getStorage()->getProductIds();
  }
}
