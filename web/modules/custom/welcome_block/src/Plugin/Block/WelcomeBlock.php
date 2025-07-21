<?php

/**
 * @file 
 * A block plugin made extending the BlockBase class.
 * This block has welcome statement with the user role mentioned as well.
 */

namespace Drupal\welcome_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a welcome!! block.
 *
 * @Block(
 *   id = "welcome_block_plugin_welcome",
 *   admin_label = @Translation("Welcome"),
 *   category = @Translation("Custom"),
 * )
 */
class WelcomeBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  /**
   * Constructs a new WelcomeBlock instance.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Session\AccountInterface $current_user
   *   The current logged-in user.
   */
  public function __construct (array $configuration , $plugin_id, $plugin_definition, AccountInterface $current_user) {
    parent::__construct($configuration, 
    $plugin_id , $plugin_definition);
    $this->currentUser = $current_user;
  }
  
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container , array $configuration , $plugin_id , $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_user')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $roles = $this->currentUser->getRoles();
    $formatted_role = [];
    if (!empty($roles)) {
      foreach ($roles as $role) {
        $formatted_role[] = ucfirst(str_replace('_' , ' ', $role));
      }
      $primary_role = implode(',' , $formatted_role);
    }
    else {
      $primary_role = 'User';
    }
    return [
      '#markup' => $this->t('Welcome @role', ['@role' => $primary_role] ),
    ];  
  }
}
