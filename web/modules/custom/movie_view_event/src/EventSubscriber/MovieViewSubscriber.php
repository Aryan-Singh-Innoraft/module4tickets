<?php

namespace Drupal\movie_view_event\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\movie_view_event\Event\MovieViewEvent;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * An event subscriber that compares movie budget and adds a message.
 */
class MovieViewSubscriber implements EventSubscriberInterface {

  /**
   * Stores configFactory service to access configuration settings.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructs the subscriber and injects config factory service.
   *
   * @param Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   A config factory service.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
  }

  /**
   * Specifies the event to which this subscriber listens to.
   *
   * @return array
   *   An array mapping event names to method names.
   */
  public static function getSubscribedEvents() {
    return [
      MovieViewEvent::EVENT_NAME => 'onMovieView',
    ];
  }

  /**
   * This is the code that runs when a custom event is dispatched.
   *
   * Compares the movie price with the budget to add a message.
   *
   * @param \Drupal\movie_view_event\Event\MovieViewEvent $event
   *   The event object containing the node and messages.
   */
  public function onMovieView(MovieViewEvent $event) {
    $node = $event->getNode();
    $budget = (float) $this->configFactory->get('movie_menu.settings')->get('budget_friendly_amount');
    $price = (float) $node->get('field_movie_price')->value;
    if ($price < $budget) {
      $event->addMessage('The movie is under budget');
    }
    elseif ($price > $budget) {
      $event->addMessage('The movie is over budget');
    }
    else {
      $event->addMessage('The movie is within budget');
    }
  }

}
