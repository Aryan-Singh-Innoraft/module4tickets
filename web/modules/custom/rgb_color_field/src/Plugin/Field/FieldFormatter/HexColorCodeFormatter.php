<?php

namespace Drupal\rgb_color_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin formatter that displays a static hex code with the same 
 * text color.
 *
 * @FieldFormatter(
 *   id = "rgb_hex_code_formatter",
 *   label = @Translation("Hex Color Code"),
 *   field_types = {"rgb_color"},
 * )
 */  
final class HexColorCodeFormatter extends FormatterBase {
  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];
    foreach ($items as $delta => $item) {
      $hex = $item->value;
      $element[$delta] = [
        '#type' => 'inline_template',
        '#template' => '<span style="color: {{ color}}"> {{ color }} </span>',
        '#context' => ['color' => $hex],
      ];
    }
    return $element;
  }
}
