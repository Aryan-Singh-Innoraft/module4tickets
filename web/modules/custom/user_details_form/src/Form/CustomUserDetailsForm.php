<?php

namespace Drupal\user_details_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a custom form for collecting user details.
 */
class CustomUserDetailsForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return "custom_user_details_form";
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['username'] = [
      '#type' => 'textfield',
      '#title' => 'Username',
      '#required' => TRUE
    ];
    $form['usermail'] = [
      '#type' => 'email',
      '#title' => 'Email',
    ];
    $form['gender'] = [
      '#type' => 'select',
      '#title' => 'Gender',
      '#options' => [
        'male' => 'Male',
        'female' => 'Female'
      ]
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Submit',
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (strlen($form_state->getValue('username')) < 6) {
      $form_state->setErrorByname('username', "Please make sure your username length is more than 5.");
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    \Drupal::messenger()->addMessage("User details submitted  succesfully");
  }
}
