<?php

namespace Drupal\movie_menu\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * A config form that helps in storing a budget-friendly movie amount.
 *
 * It extends the ConfigFormBase that provides basic utility functions.
 */
class BudgetFriendlyMovieAmount extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'movie_menu_budget_friendly_movie_amount';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return ['movie_menu.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form['budget_friendly_amount'] = [
      '#type' => 'number',
      '#title' => $this->t('Budget Friendly Amount'),
      '#default_value' => $this->config('movie_menu.settings')->get('budget_friendly_amount'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->config('movie_menu.settings')
      ->set('budget_friendly_amount', $form_state->getValue('budget_friendly_amount'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
