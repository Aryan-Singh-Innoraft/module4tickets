<?php

namespace Drupal\rgb_color_field\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Defines a field type to store hex codes for colors.
 *
 * @FieldType(
 *   id = "rgb_color",
 *   label = @Translation("RGB Color Item"),
 *   description = @Translation("Stores a color in rgb hex format."),
 *   default_widget = "rgb_color_picker_widget",
 *   default_formatter = "hex_code_background_formatter",
 * )
 */
class RgbColorItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('value')->getValue();
    return $value === NULL || $value === '';
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {
    $properties['value'] = DataDefinition::create('string')
      ->setLabel(t('Hex Color'))
      ->setRequired(TRUE);
    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition): array {
    return [
      'columns' => [
        'value' => [
          'type' => 'varchar',
          'title' => 'Enter your color',
          'length' => 7,
        ],
      ],
    ];
  }

}
