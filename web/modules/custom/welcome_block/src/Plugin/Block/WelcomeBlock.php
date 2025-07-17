<?php

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
   * @var AccountInterface
   */
  protected $current_user;

  public function __construct (array $configuration , $plugin_id, $plugin_definition, AccountInterface $current_user) {
    parent::__construct($configuration, 
    $plugin_id , $plugin_definition);
    $this->current_user = $current_user;
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
    $roles = $this->current_user->getRoles();
    $formatted_roles = [];
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
