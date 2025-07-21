<?php 

namespace Drupal\welcome_user\Service;

use Drupal\Core\Session\AccountProxyInterface;

/**
 * Service to provide information about the current user.
 */
class CurrentUserService {

  /**
   * The current user object.
   * 
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * Constructs a new CurrentUser object.
   * 
   * @param \Drupal\Core\Session\AccountProxyInterface $currentUser
   *  Initializing the current user with the injected object.
   */
  public function __construct(AccountProxyInterface $currentUser) {
    $this->currentUser = $currentUser;
  }

  /**
   * Returns the display name of the current user.
   * 
   * @return string
   *   The display name of the current user.
   */
  public function getUserName() {
    return $this->currentUser->getDisplayName();
  }
}

