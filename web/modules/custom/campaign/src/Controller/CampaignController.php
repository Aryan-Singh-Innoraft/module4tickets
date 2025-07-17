<?php 
namespace Drupal\campaign\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;

/**
 * Manages the campaign page output.
 */
class CampaignController extends ControllerBase {

  /**
   * Displays the dynmaic id passed to it.
   * 
   * @param int $id
   *  The dynamic campaign ID passed via the route.
   *
   * @return array
   *  A render array containing the formatted message.
   */
  public function dynamicId(int $id) {
    return [
      '#markup' => $this->t('This is campaign number: @id', ['@id' => $id])
    ];
  }

  /**
   * Checks access based on the user's role.
   * 
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user account to check access for.
   * 
   * @return Drupal\Core\Access\AccessResult
   *   Allowed if the user is an administrator, otherwise denied.
   */
  public function checkAccess(AccountInterface $account) {
    return AccessResult::allowedIf(in_array('administrator' , $account->getRoles()));
  }
}
?>
