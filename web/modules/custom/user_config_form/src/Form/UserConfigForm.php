<?php

namespace Drupal\user_config_form\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a config form for user details.
 */
class UserConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'user_config_form';
  }
  
  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames()  {
    return ['user_config_form.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('user_config_form.settings');

    $form['full_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Full Name'),
      '#default_value' => $config->get('full_name'),
      '#required' => TRUE,
    ];

    $form['phone_number'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Phone Number'),
      '#default_value' => $config->get('phone_number'),
      '#required' => TRUE,
    ];
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email ID'),
      '#default_value' => $config->get('email'),
      '#required' => TRUE,
    ];
    $selected_gender = $form_state->getValue('gender');
    if ($selected_gender === NULL) {
      $selected_gender = $config->get('gender');
    }
    $form['gender'] = [
      '#type' => 'select',
      '#title' => $this->t('Gender'),
      '#options' => [
        'male' => $this->t('Male'),
        'female' => $this->t('Female'),
        'other' => $this->t('Other'),
      ],
      '#default_value' => $selected_gender,
      '#name' => 'gender',
      '#ajax' => [
        'callback' => '::ajaxGenderCallback',
        'wrapper' => 'gender-other-wrapper',
        'event' => 'change',
      ],

    ];

    $form['gender_wrapper'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'gender-other-wrapper'],
    ];
    if ($form_state->getValue('gender') === 'other') {
      $form['gender_wrapper']['gender_other'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Please specify'),
      ];
    }
    return parent::buildForm($form, $form_state) + $form;
  }

  /**
   * AJAX callback for the gender field wrapper.
   * 
   * @param array $form
   *   The full form array.
   * @param FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   A renderable array representing a section of the form.
   */
  public function  ajaxGenderCallback(array &$form, FormStateInterface $form_state) {
    return $form['gender_wrapper'];
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $phone = trim($form_state->getValue('phone_number'));

    if (!preg_match('/^[6-9][0-9]{9}$/', $phone)) {
      $form_state->setErrorByName('phone_number', $this->t('Enter a valid 10-digit Indian mobile number.'));
    }

    $email = $form_state->getValue('email');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $form_state->setErrorByName('email', $this->t('Please a valid email address.'));
    }

    if (strtolower(substr($email, -4)) !== '.com') {
      $form_state->setErrorByName('email', $this->t('Only .com email addresses are allowed.'));
    }

    $public_domains = ['gmail.com', 'yahoo.com', 'outlook.com'];
    $domain = substr(strrchr($email, "@"), 1);
    if (!in_array(strtolower($domain), $public_domains)) {
      $form_state->setErrorByName('email', $this->t('Only ppublic domains like Gmail,Yahoo,Outlook are allowed.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->configFactory->getEditable('user_config_form.settings')
      ->set('full_name', $form_state->getValue('full_name'))
      ->set('phone_number', $form_state->getValue('phone_number'))
      ->set('email', $form_state->getValue('email'))
      ->set('gender', $form_state->getValue('gender'))
      ->set('gender_other', $form_state->getValue('gender_other'))
      ->save();

    parent::submitForm($form, $form_state);
    \Drupal::messenger()->addStatus($this->t('Settings saved successfully.'));
  }
}
