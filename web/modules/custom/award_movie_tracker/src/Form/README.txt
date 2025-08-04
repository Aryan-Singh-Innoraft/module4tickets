<?php

namespace Drupal\award_movie\Form;

use Drupal\Core\Entity\EntityConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * A class that deletes the node after confirmation.
 */
class AwardMovieDeleteForm extends EntityConfirmFormBase {

  /**
   * A method that asks for user confirmation.
   *
   * @return string
   *   Returns a confirmation message.
   */
  public function getQuestion() {
    return $this->t('Are you sure you want to delete %label?', ['%label' => $this->entity->label()]);
  }

  /**
   * Returns the URL to redirect to when the delete action is cancelled.
   *
   * This typically points to the list  page of the configuration entity.
   *
   * @return \Drupal\Core\Url
   *   The URL of the entity collection/list page.
   */
  public function getCancelUrl() {
    return $this->entity->toUrl('collection');
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->entity->delete();
    $this->messenger()->addMessage($this->t('Deleted %label.', ['%label' => $this->entity->label()]));
    $form_state->setRedirectUrl($this->getCancelUrl());
  }

}












add 



