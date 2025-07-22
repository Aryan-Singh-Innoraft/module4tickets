<?php

namespace Drupal\rgb_color_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a field widget that provides a textfield for the user to add
 * the hexcode for color.
 *
 * @FieldWidget(
 *   id = "hex_value",
 *   label = @Translation("Hex value"),
 *   field_types = {
 *     "rgb_color"
 *   },
 * )
 */
class HexValueWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array {
    $element['value'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Hex Value'),
      '#default_value' => $items[$delta]->value ?? NULL,
      '#size' => 7,
      '#maxlength' => 7,
      '#description' => $this->t('Enter a 6-digit hex color code, e.g., #ff0000.'),
    ];
    return $element;
  }
}
