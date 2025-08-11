<?php

namespace Drupal\events_dashboard\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for Events dashboard routes.
 */
class TaxonomyTermController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function __invoke(): array {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

}
