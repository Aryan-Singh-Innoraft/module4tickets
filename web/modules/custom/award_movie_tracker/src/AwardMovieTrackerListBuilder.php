<?php

namespace Drupal\award_movie_tracker;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;

/**
 * Provides a listing of award movie trackers.
 */
class AwardMovieTrackerListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader(): array {
    $header['label'] = $this->t('Movie Title');
    $header['year'] = $this->t('Year');
    $header['award'] = $this->t('Award');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\award_movie_tracker\Entity\AwardMovieTracker $entity */
    $row['label'] = $entity->label();
    $row['year'] = $entity->getYear();
    $row['award'] = $entity->getAward();
    return $row + parent::buildRow($entity);
  }

}
