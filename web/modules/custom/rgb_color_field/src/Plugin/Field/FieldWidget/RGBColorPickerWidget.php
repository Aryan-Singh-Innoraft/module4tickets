<?php

namespace Drupal\rgb_color_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * A field widget that provides a color picker for the user to pick colors.
 *
 * @FieldWidget(
 *   id = "rgb_color_picker_widget",
 *   label = @Translation("Color Picker"),
 *   field_types = {
 *     "rgb_color"
 *   },
 * )
 */
class RGBColorPickerWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array {
    $element['value'] = [
      '#type' => 'color',
      '#title' => $this->t('Pick your color'),
      '#default_value' => $items[$delta]->value ?? '#000000',
    ];
    return $element;
  }

}
