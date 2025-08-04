<?php

namespace Drupal\movie_view_event\Event;

use Drupal\Component\EventDispatcher\Event;
use Drupal\node\NodeInterface;

/**
 * A custom event that carries movie node and budget message to be displayed.
 */
class MovieViewEvent extends Event {

  /**
   * The name of the event that will be used by dispatchers and subscribers.
   */
  public const EVENT_NAME = 'movie_view_event.movie_view';

  /**
   * Stores messages received from the subscribers.
   *
   * @var string
   */
  protected $message;

  /**
   * This is the movie node object being viewed.
   *
   * @var Drupal\node\NodeInterface
   */
  protected $node;

  /**
   * Constructs a custom event and initialzes the node with the viewed node.
   *
   * @param \Drupal\node\NodeInterface $node
   *   The current being viewed.
   */
  public function __construct(NodeInterface $node) {
    $this->node = $node;
  }

  /**
   * A function that returns the movie node being used.
   *
   * @return Drupal\node\NodeInterface
   *   Returns the node that is being viewed.
   */
  public function getNode() {
    return $this->node;
  }

  /**
   * A function that adds a message to the messages list from subscribers.
   *
   * @param string $message
   *   A movie-budget message for displaying on movie node page.
   */
  public function addMessage(string $message) {
    $this->message = $message;
  }

  /**
   * A function that provides messages to be displayed on movie node page.
   *
   * @return array
   *   Returns an array of messages to be displayed on movie node page.
   */
  public function getMessages() {
    return $this->message;
  }

}
