<?php

namespace Drupal\rgb_color_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin formatter that displays a static hex code with same background color.
 *
 * @FieldFormatter(
 *   id = "hex_code_background_formatter",
 *   label = @Translation("Hex Code Background"),
 *   field_types = {"rgb_color"},
 * )
 */
class HexCodeBackgroundFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $element = [];
    foreach ($items as $delta => $item) {
      $hex = $item->value;
      $element[$delta] = [
        '#type' => 'inline_template',
        '#template' => '<span style="background-color: {{ color}}"> {{ color }} </span>',
        '#context' => ['color' => $hex],
      ];
    }
    return $element;
  }

}
