<?php
namespace Drupal\welcome_block\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for Welcome block routes.
 */
class WelcomeBlockController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function welcome() {

    $block = \Drupal::service('plugin.manager.block')->createInstance('welcome_block_plugin_welcome' , []);

    return $block->build();
    
  }

}
