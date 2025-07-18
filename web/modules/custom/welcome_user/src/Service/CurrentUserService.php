<?php 
namespace Drupal\welcome_user\Service;
use Drupal\Core\Session\AccountProxyInterface;

class CurrentUserService {
  protected $currentUser;

  public function __construct(AccountProxyInterface $currentUser) {
    $this->currentUser = $currentUser;
  }

  public function getUserName() {
    return $this->currentUser->getDisplayName();
  }
}
?>
