<?php 
namespace Drupal\welcome_user\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * The controller that greets user.
 */
class WelcomeUserController extends ControllerBase {

  /**
   * Says hello to the current user.
   * 
   * @return array
   *  A render array containing greeting message and cache details.
   */
  public function helloUser() {
    $current_user = \Drupal::currentuser();
    $username = $current_user->isAuthenticated() ? $current_user->getDisplayName() : 'Guest';

    return[
      '#markup' => $this->t('Hello @name' , ['@name' => $username]),
      '#cache' => ['max-age' => 0,],
    ];
  }
}
?>
