<?php

namespace Drupal\events_dashboard\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Connection;

/**
 * Runs queries and returns responses for Events dashboard.
 */
class EventsDashboardController extends ControllerBase {

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * Constructor that constructs an object with required db connection.
   */
  public function __construct(Connection $database) {
    $this->database = $database;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
    $container->get('database')
    );
  }

  /**
   * This method includes all queries to retrieve all event details.
   *
   * @return array
   *   Returns render array containing tables for the events dashboard.
   */
  public function dashboard() {
    $yearly_result = $this->getYearlyEvents();
    $yearly_rows = [];
    foreach ($yearly_result as $record) {
      $yearly_rows[] = [
        'data' => [$record->event_year, $record->total],
      ];
    }

    $quarterly_result = $this->getQuarterlyEvents();
    $quarterly_rows = [];
    foreach ($quarterly_result as $record) {
      $quarterly_rows[] = [
        'data' => [$record->event_year, 'Q' . $record->event_quarter, $record->total],
      ];
    }

    $events_result = $this->getEventsTypeCount();
    $events_rows = [];
    foreach ($events_result as $record) {
      $events_rows[] = [
        'data' => [$record->name, $record->total],
      ];
    }

    $build['quarterly'] = [
      '#type' => 'table',
      '#caption' => 'Events per quarter',
      '#header' => ['Year', 'Ouarter', 'Event Count'],
      '#rows' => $quarterly_rows,
    ];

    $build['yearly'] = [
      '#type' => 'table',
      '#caption' => 'Events per year',
      '#header' => ['Year', 'Event Count'],
      '#rows' => $yearly_rows,
    ];

    $build['events'] = [
      '#type' => 'table',
      '#caption' => 'Events per type',
      '#header' => ['Event type', 'Event Count'],
      '#rows' => $events_rows,
    ];
    return $build;
  }

  /**
   * This method runs query and retrieves the yearly count of events.
   *
   * @return \stdClass[]
   *   Returns an array of objects where each object represents a row of table.
   */
  public function getYearlyEvents() {
    $query = $this->database->select('node_field_data', 'n');
    $query->addExpression('EXTRACT(YEAR from nfd.field_date_value)', 'event_year');
    $query->addExpression('COUNT(n.nid)', 'total');
    $query->innerJoin('node__field_date', 'nfd', 'n.nid = nfd.entity_id');
    $query->condition('n.type', 'events');
    $query->groupBy('event_year');
    return $query->execute()->fetchAll();
  }

  /**
   * This method runs query and retrieves the quaterly count of events.
   *
   * @return \stdClass[]
   *   Returns an array of objects where each object represents a row of table.
   */
  private function getQuarterlyEvents() {
    $query = $this->database->select('node_field_data', 'n');
    $query->addExpression('EXTRACT(YEAR from nfd.field_date_value)', 'event_year');
    $query->addExpression('EXTRACT(QUARTER from nfd.field_date_value)', 'event_quarter');
    $query->addExpression('COUNT(n.nid)', 'total');
    $query->innerJoin('node__field_date', 'nfd', 'n.nid = nfd.entity_id');
    $query->condition('n.type', 'events');
    $query->groupBy('event_year');
    $query->groupBy('event_quarter');
    return $query->execute()->fetchAll();
  }

  /**
   * This method runs query and retrieves the count of events per event type.
   *
   * @return \stdClass[]
   *   Returns an array of objects where each object represents a row of table.
   */
  private function getEventsTypeCount() {
    $query = $this->database->select('node_field_data', 'n');
    $query->innerJoin('node__field_event_type', 'nfet', 'n.nid = nfet.entity_id');
    $query->innerJoin('taxonomy_term_field_data', 'ttfd', 'nfet.field_event_type_target_id = ttfd.tid');
    $query->fields('ttfd', ['name']);
    $query->addExpression('COUNT(n.nid)', 'total');
    $query->condition('n.type', 'events');
    $query->groupBy('ttfd.tid');
    $query->groupBy('ttfd.name');
    return $query->execute()->fetchAll();
  }

}
