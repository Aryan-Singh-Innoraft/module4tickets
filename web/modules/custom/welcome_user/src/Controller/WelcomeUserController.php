<?php 

namespace Drupal\welcome_user\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\welcome_user\Service\CurrentUserService;

/**
 * The controller that provides a user welcome page.
 * Using a service here to get the username.
 * Fetches the username and displays it.
 */
class WelcomeUserController extends ControllerBase {

  /**
   * Name of current user.
   * 
   *  @var \Drupal\welcome_user\Service\CurrentUserService
   */
  protected $currUser;

  /**
   * Constructs the WelcomeUserControlller object. 
   *  
   * @param Drupal\welcome_user\Service\CurrentUserService $current_user
   *  A custom service that provides user's information.
   */
  public function __construct(CurrentUserService $current_user) {
    $this->currUser = $current_user;
  }                                                                                                                                       
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('welcome_user.my_service')
    );
  }

  /**
   * Says hello to the current user.
   * 
   * @return array
   *  A render array containing greeting message and cache details.
   */
  public function helloUser() {
    return[
      '#markup' => $this->t('Hello @name' , ['@name' => $this->currUser->getUserName()]),
      '#cache' => [
        'contexts' => ['user'],
      ],
    ];
  }
}
