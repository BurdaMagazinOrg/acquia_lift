<?php

namespace Drupal\acquia_lift\Plugin\Filter;

use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;

/**
 * @Filter(
 *   id = "filter_acquia_lift_optout_button",
 *   title = @Translation("Acquia Lift Opt-Out"),
 *   description = @Translation("Content filter for Acquia Lift Opt-Out/In (Do Not Track) button"),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_MARKUP_LANGUAGE,
 * )
 */
class OptOutButtonFilter extends FilterBase {

  /**
   * generates rendering array for placeholder defined in process method
   * 
   * @return array
   */
  public static function renderOptOutButton() {
    // get current do-not-track status
    $request = \Drupal::getContainer()
      ->get('request_stack')
      ->getCurrentRequest();
    $optOuted = !empty($request->cookies->get('tc_dnt'));

    return array(
      '#theme' => 'optout_button',
      '#opt_outed' => $optOuted,
    );
  }

  /**
   * prepare placeholder for rendering of optout button content
   * 
   * @param string $text
   * @param string $langcode
   *
   * @return \Drupal\filter\FilterProcessResult
   */
  public function process($text, $langcode) {
    $filteredResult = new FilterProcessResult($text);

    $placeholder = $filteredResult->createPlaceholder(get_class() . '::renderOptOutButton', array());
    $newText = str_replace('[acquia_lift:optout_button]', $placeholder, $text);
    $filteredResult->setProcessedText($newText);

    $filteredResult->addAttachments([
      'library' => array('acquia_lift/optopt_button'),
    ]);

    return $filteredResult;
  }
}