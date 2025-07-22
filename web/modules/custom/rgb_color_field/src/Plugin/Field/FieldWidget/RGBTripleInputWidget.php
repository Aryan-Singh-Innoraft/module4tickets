<?php

namespace Drupal\rgb_color_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a field widget that takes input for r,g and b separately 
 * between 0-255 and saves it as a hex value.
 *
 * @FieldWidget(
 *   id = "rgb_triple_widget",
 *   label = @Translation("RGB inputs"),
 *   field_types = {
 *    "rgb_color"
 *   },
 * )
 */
class RGBTripleInputWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array {
    $default = $items[$delta]->value?? '#000000';
    $r = hexdec(substr($default, 1, 2)); 
    $g = hexdec(substr($default, 3, 2)); 
    $b = hexdec(substr($default, 5, 2)); 
    $element['r'] = [
      '#type' => 'number',
      '#title' => $this->t('Red'),
      '#default_value' => $r,
      '#min' => 0,
      '#max' => 255,
    ];
     $element['g'] = [
      '#type' => 'number',
      '#title' => $this->t('Green'),
      '#default_value' => $g,
      '#min' => 0,
      '#max' => 255,
    ];
    $element['b'] = [
      '#type' => 'number',
      '#title' => $this->t('Blue'),
      '#default_value' => $b,
      '#min' => 0,
      '#max' => 255,
    ];
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    foreach($values as &$value) {
      $value['value'] = sprintf("#%02x%02x%02x", $value['r'], $value['g'], $value['b']);
    }
    return $values;
  }
}
