<?php

namespace Drupal\events_dashboard\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Provides a taxonomy term field and its details.
 */
class TaxonomyTermForm extends FormBase {

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The id of the taxonomy term.
   *
   * @var int
   */
  protected $id;

  /**
   * The uuid of the taxonomy term.
   *
   * @var string
   */
  protected $uuid;

  /**
   * Constructor that constructs an object with required db connection.
   */
  public function __construct(Connection $database, EntityTypeManagerInterface $entity_type_manager) {
    $this->database = $database;
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database'),
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'taxonomy_term_input';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {

    $form['term_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Taxonomy term name'),
      '#required' => TRUE,
    ];
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Search'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $term_name = $form_state->getValue('term_name');
    $this->id = $this->termName($term_name);
    if (empty($this->id)) {
      $this->messenger()->addError($this->t('No term found with the name @name', [
        '@name' => $term_name,
      ]));
      return;
    }
    $this->uuid = $this->termUuid($term_name);

    $query = $this->database->select('node_field_data', 'n');
    $query->fields('n', ['nid', 'title']);
    $query->innerJoin('node__field_event_type', 'nfet', 'n.nid = nfet.entity_id');
    $query->condition('n.type', 'events');
    $query->condition('nfet.field_event_type_target_id', $this->id);
    $details = $query->execute()->fetchAll();
    foreach ($details as $detail) {
      $node_storage = $this->entityTypeManager->getStorage('node');
      $node = $node_storage->load($detail->nid);
      $url = $node->toUrl()->toString();
      $display_title = $detail->title;
      $output[] = $display_title . '(' . $url . ')';
    }
    $titles_urls = implode(',', $output);
    $this->messenger()->addStatus($this->t('Term ID:@id ,
      Term UUID: @uuid, 
      Nodes: @nodes', ['@id' => $this->id, '@uuid' => $this->uuid, '@nodes' => $titles_urls]));
  }

  /**
   * This method queries into the db and gets the term id.
   *
   * @param string $term_name
   *   This is the term name fetched from the form input field.
   */
  public function termName(string $term_name) {
    $query = $this->database->select('taxonomy_term_field_data', 'ttd');
    $query->fields('ttd', ['tid']);
    $query->condition('ttd.name', $term_name);
    $tid = $query->execute()->fetch();
    $id = $tid->tid;
    return $id;
  }

  /**
   * This method queries into the db and gets the term uuid.
   *
   * @param string $term_name
   *   This is the term name fetched from the form input field.
   */
  public function termUuid($term_name) {
    $query = $this->database->select('taxonomy_term_data', 'ttd');
    $query->fields('ttd', ['uuid']);
    $query->condition('ttd.tid', $this->id);
    $uuid = $query->execute()->fetch();
    $uuidm = $uuid->uuid;
    return $uuidm;
  }

}
