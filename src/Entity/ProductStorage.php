<?php

namespace Drupal\external_entity\Entity;

use Drupal\Core\Cache\MemoryCache\MemoryCacheInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityStorageBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\external_entity\Services\FakeStoreAPIInterface;

class ProductStorage extends EntityStorageBase {

  /**
   * @var \Drupal\external_entity\Services\FakeStoreAPIInterface $fakeStoreAPI
   */
  protected $fakeStoreAPI;
  public function __construct(
    EntityTypeInterface $entity_type,
    MemoryCacheInterface $memory_cache,
    FakeStoreAPIInterface $fakeStoreAPI
  ) {
    parent::__construct($entity_type, $memory_cache);
    $this->fakeStoreAPI = $fakeStoreAPI;
  }

  public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type) {
    return new static(
      $entity_type,
      $container->get('entity.memory_cache'),
      $container->get('external_entity.fakestorapi'),
    );
  }

  protected function doLoadMultiple(array $ids = NULL) {
    $entities = $this->fakeStoreAPI->getProducts($ids);
    return $this->mapFromStorageRecords($entities);
  }

  protected function has($id, EntityInterface $entity) {
    // TODO: Implement has() method.
  }

  protected function doDelete($entities) {
    // TODO: Implement doDelete() method.
  }

  protected function doSave($id, EntityInterface $entity) {
    // TODO: Implement doSave() method.
  }

  protected function getQueryServiceName() {
    // TODO: Implement getQueryServiceName() method.
  }

  public function loadRevision($revision_id) {
    // TODO: Implement loadRevision() method.
  }

  public function deleteRevision($revision_id) {
    // TODO: Implement deleteRevision() method.
  }

  public function getProductIds() {
    return $this->fakeStoreAPI->getProductIds();
  }

}
