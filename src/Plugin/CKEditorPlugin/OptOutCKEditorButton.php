<?php

namespace Drupal\acquia_lift\Plugin\CKEditorPlugin;

use Drupal\ckeditor\CKEditorPluginBase;
use Drupal\editor\Entity\Editor;

/**
 * Defines the Acquia Lift Opt-Out Button plugin for CKEditor.
 *
 * @CKEditorPlugin(
 *   id = "AcquiaLiftOptOutCKEditorButton",
 *   label = @Translation("Acquia Lift Opt-Out")
 * )
 */
class OptOutCKEditorButton extends CKEditorPluginBase {

  /**
   * {@inheritdoc}
   */
  public function getButtons() {
    return array(
      'AcquiaLiftOptOutCKEditorButton' => array(
        'label' => t('Acquia Lift Opt-Out'),
        'image' => drupal_get_path('module', 'acquia_lift') . '/js/plugins/optout_ckeditor_button/images/acquia-lift-icon.png',
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFile() {
    return drupal_get_path('module', 'acquia_lift') . '/js/plugins/optout_ckeditor_button/plugin.js';
  }

  /**
   * {@inheritdoc}
   */
  public function isInternal() {
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function getDependencies(Editor $editor) {
    return array();
  }

  /**
   * {@inheritdoc}
   */
  public function getLibraries(Editor $editor) {
    return array();
  }

  /**
   * {@inheritdoc}
   */
  public function getConfig(Editor $editor) {
    return array();
  }

}
