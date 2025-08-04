<?php

namespace Drupal\movie_view_event\EventSubscriber;

use Drupal\movie_view_event\Event\MovieViewEvent;
use Drupal\node\NodeInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Helps in displatching the custom event to which all subscribers react.
 */
class MovieViewDispatcher {

  /**
   * Stores injected event-dispatcher-service to dispatch events in the class.
   *
   * @var Symfony\Component\EventDispatcher\EventDispatcherInterface
   */
  protected $eventDispatcher;

  /**
   * Constructs the dispatcher and injects event dispatcher service.
   *
   * @param Symfony\Component\EventDispatcher\EventDispatcherInterface $event_dispatcher
   *   An event dispatcher.
   */
  public function __construct(EventDispatcherInterface $event_dispatcher) {
    $this->eventDispatcher = $event_dispatcher;
  }

  /**
   * Used to inject event dispatcher service.
   *
   * @param Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The service container.
   *
   * @return static
   *   A new instance of this class with required dependencies injected.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('event_dispatcher')
    );
  }

  /**
   * Dispatches a custom event and build the content for movie node.
   *
   * @param \Drupal\node\NodeInterface $node
   *   The particular node being viewed.
   * @param array &$build
   *   A render array that stores content for node.
   */
  public function onNodeView(NodeInterface $node, array &$build) {
    if ($node->getType() !== 'movie') {
      return;
    }

    $event = new MovieViewEvent($node);
    $this->eventDispatcher->dispatch($event, MovieViewEvent::EVENT_NAME);
    $message = $event->getMessages();
    $build['movie_budget_message'] = [
      '#markup' => '<div>Movie budget:' . $message . '</div>',
      '#weight' => -10,
    ];
  }

}
