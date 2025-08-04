<?php

namespace Drupal\award_movie_tracker\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the award movie tracker entity type.
 *
 * @ConfigEntityType(
 *   id = "award_movie_tracker",
 *   label = @Translation("Award movie tracker"),
 *   handlers = {
 *     "list_builder" = "Drupal\award_movie_tracker\AwardMovieTrackerListBuilder",
 *     "form" = {
 *       "add" = "Drupal\award_movie_tracker\Form\AwardMovieTrackerForm",
 *       "edit" = "Drupal\award_movie_tracker\Form\AwardMovieTrackerForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *   },
 *   config_prefix = "award_movie",
 *   admin_permission = "administer_award_movie_tracker",
 *   links = {
 *     "collection" = "/admin/structure/award-movie-tracker",
 *     "add-form" = "/admin/structure/award-movie-tracker/add",
 *     "edit-form" = "/admin/structure/award-movie-tracker/{award_movie_tracker}",
 *     "delete-form" = "/admin/structure/award-movie-tracker/{award_movie_tracker}/delete",
 *   },
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "year",
 *     "award",
 *   },
 * )
 */
class AwardMovieTracker extends ConfigEntityBase {

  /**
   * Unique identifier for the entity.
   */
  protected string $id;

  /**
   * The label or title of the entity.
   */
  protected string $label;

  /**
   * The name of the award received by a movie.
   */
  protected string $award = '';

  /**
   * The year in which the award was received.
   */
  protected int $year = 0;

  /**
   * Returns the award name.
   *
   * @return string
   *   Award name of type string.
   */
  public function getAward() {
    return $this->award;
  }

  /**
   * Returns the year value.
   *
   * @return string
   *   A int value of award receiving year.
   */
  public function getYear() {
    return $this->year;
  }

  /**
   * Sets the award name.
   *
   * @param string $award
   *   Award value to be stored.
   */
  public function setAward(string $award) {
    $this->award = $award;
  }

  /**
   * Sets the year value.
   *
   * @param int $year
   *   Value of award receiving year.
   */
  public function setYear(int $year) {
    $this->year = $year;
  }

}
