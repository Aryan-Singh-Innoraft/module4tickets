<?php

namespace Drupal\award_movie_tracker\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\award_movie_tracker\Entity\AwardMovieTracker;

/**
 * Form that helps add a movie in awarded movies list.
 *
 * It extends EntityForm, that provides basic form-building utilities.
 */
class AwardMovieTrackerForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state): array {

    $form = parent::form($form, $form_state);
    /** @var \Drupal\award_movie_tracker\Entity\AwardMovieTracker $entity */
    $entity = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Movie name'),
      '#maxlength' => 255,
      '#default_value' => $entity->label(),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $entity->id(),
      '#machine_name' => [
        'exists' => [AwardMovieTracker::class, 'load'],
      ],
      '#disabled' => !$entity->isNew(),
    ];

    $form['year'] = [
      '#type' => 'number',
      '#title' => $this->t('Year'),
      '#default_value' => $entity->getYear(),
      '#required' => TRUE,
    ];

    $form['award'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Award'),
      '#maxlength' => 255,
      '#default_value' => $entity->getAward(),
      '#required' => TRUE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    /** @var \Drupal\award_movie_tracker\Entity\AwardMovieTracker $entity */
    $entity = $this->getEntity();
    $entity->setAward($form_state->getValue('award'));
    $entity->setYear((int) $form_state->getValue('year'));
    $entity->set('label', $form_state->getValue('label'));
    $entity->save();
    parent::submitForm($form, $form_state);
  }

}
