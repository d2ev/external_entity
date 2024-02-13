<?php

namespace Drupal\external_entity\Services;

interface FakeStoreAPIInterface {
  public function getProducts($ids = NULL);
  public function getProduct($id);
  public function createProduct($product);
  public function updateProduct($id, $product);
  public function deleteProduct($id);
}
