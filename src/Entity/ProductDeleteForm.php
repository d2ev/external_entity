<?php

namespace Drupal\external_entity\Entity;

use Drupal\Core\Entity\EntityDeleteForm;
use Drupal\Core\Form\FormStateInterface;

class ProductDeleteForm extends EntityDeleteForm  {
  public function buildForm(array $form, FormStateInterface $form_state) {
    return parent::buildForm($form, $form_state);
  }
}
