<?php

namespace Drupal\external_entity\Services;

use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

class FakeStoreAPI implements FakeStoreAPIInterface {

  /**
   * @var \GuzzleHttp\ClientInterface $httpClient
   */
  protected $httpClient;

  /**
   * @var \Drupal\Core\Logger\LoggerChannelFactoryInterface $logger
   */
  protected $logger;
  protected string $endPoint = 'https://fakestoreapi.com/products';
  public function __construct(
    ClientInterface $http_client,
    LoggerChannelFactoryInterface $logger,
  ) {
    $this->httpClient = $http_client;
    $this->logger = $logger->get('fakestore');
  }

  public function getProducts($ids = NULL) {
    $entities = [];
    try {
      if (empty($ids)) {
        $response = $this->httpClient->request('GET', $this->endPoint);
        if ($response->getStatusCode() != 200) {
          $this->logger->error('FakeStore api service is not available.');
        }
        $entities = json_decode($response->getBody()->getContents());
      }
      else {
        foreach ($ids as $id) {
          $entities[]  = $this->getProduct($id);
        }
      }
    }
    catch (GuzzleException $e) {
      $this->logger->error($e->getMessage());
    }

    return $entities;
  }

  public function getProduct($id) {
    $entity = NULL;
    try {
      $response = $this->httpClient->request('GET', $this->endPoint . '/' . $id);
      if ($response->getStatusCode() != 200) {
        $this->logger->error('FakeStore api service is not available.');
      }
      else {
        $entity = json_decode($response->getBody()->getContents());
      }

    }
    catch (GuzzleException $e) {
      $this->logger->error($e->getMessage());
    }

    return $entity;
  }

  public function getProductIds() {
    $ids = [];
    try {
      $response = $this->httpClient->request('GET', $this->endPoint);
      if ($response->getStatusCode() != 200) {
        $this->logger->error('FakeStore api service is not available.');
      }
      else {
        $entities = json_decode($response->getBody()->getContents());
        foreach ($entities as $entity) {
          $ids[] = $entity->id;
        }
      }
    }
    catch (GuzzleException $e) {
      $this->logger->error($e->getMessage());
    }

    return $ids;
  }

  public function createProduct($product) {
    // TODO: Implement createProduct() method.
  }

  public function updateProduct($id, $product) {
    // TODO: Implement updateProduct() method.
  }

  public function deleteProduct($id) {
    // TODO: Implement deleteProduct() method.
  }

}
