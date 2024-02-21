<?php

namespace Drupal\external_entity\Entity;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ProductForm extends EntityForm {
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);
    $properties = $this->entityTypeManager->getDefinition('product')->get('properties');
    $compositeProperties = $this->entityTypeManager->getDefinition('product')->get('compositeProperties');
    $entity = $this->entity;
    foreach ($properties as $name => $property) {
      if ($property['type'] == 'string') {
        $form[$name] = [
          '#type' => 'textfield',
          '#title' => $property['lable'],
          '#default_value' => $entity->get($name),
          '#required' => $property['required'],
        ];
      }
    }

    return $form;
  }
}
