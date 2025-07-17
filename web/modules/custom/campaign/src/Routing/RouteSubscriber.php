<?php 
namespace Drupal\campaign\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Alters existing routes.
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    if( $route = $collection->get('campaign.user_campaign')) {
      $route->setPath('/campaign/value/{id}');
      $route->setRequirement('_role' , 'administrator');
    }
  }
}
?>
