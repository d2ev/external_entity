<?php

namespace Drupal\external_entity\Entity;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

class ProductForm extends EntityForm {
  public function form(array $form, FormStateInterface $form_state) {
    return parent::form($form, $form_state);
  }
}
