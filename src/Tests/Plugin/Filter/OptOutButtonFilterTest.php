<?php

/**
 * @file
 * Contains \Drupal\acquia_lift\Tests\Plugin\Filter\OptOutButtonFilterTest.
 */

namespace Drupal\acquia_lift\Tests\Plugin\Filter;

use Drupal\filter\Entity\FilterFormat;
use Drupal\simpletest\WebTestBase;

/**
 * Test Acquia Lift Opt-Out Button Filter.
 *
 * @group Acquia Lift
 */
class OptOutButtonFilterTest extends WebTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['node', 'taxonomy', 'acquia_lift', 'ckeditor'];

  /**
   * Token used as placeholder for Acquia Lift Opt-Out Button
   *
   * @var string
   */
  protected static $optOutButtonToken = '[acquia_lift:optout_button]';

  /**
   * The test user.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $webUser;

  /**
   * The test user.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $adminUser;

  /**
   * setUp tests
   */
  protected function setUp() {
    parent::setUp();

    // create a page content type.
    $this->drupalCreateContentType(array(
      'type' => 'page',
      'name' => 'Basic page'
    ));

    // create a text format and enable the filter_acquia_lift_optout_button filter.
    $formatCustom = FilterFormat::create(array(
      'format' => 'custom_format',
      'name' => 'Custom format',
      'filters' => array(
        'filter_acquia_lift_optout_button' => array(
          'status' => 1,
        ),
      ),
    ));
    $formatCustom->save();

    // create a full html format
    $formatFullHtml = FilterFormat::create(array(
      'format' => 'full_html',
      'name' => 'Full HTML format',
    ));
    $formatFullHtml->save();

    // create users with required permissions
    $this->webUser = $this->drupalCreateUser(array('access content'));

    $this->adminUser = $this->drupalCreateUser(array_keys($this->container->get('user.permissions')
      ->getPermissions()));
  }

  /**
   * Test Filtering options:
   * - with OptOut Filter enabled and with placeholder
   * - with OptOut Filter enabled and without placeholder
   * - without OptOut Filter
   */
  public function testFilter() {
    $this->drupalLogin($this->webUser);

    $nodeContent = 'Test Content.' . static::$optOutButtonToken . 'End of Test Content.';
    $nodeSettings = array();
    $nodeSettings['type'] = 'page';
    $nodeSettings['title'] = 'Test Filter';

    /* Test with enabled Filter */
    $nodeSettings['body'] = array(
      array(
        'value' => $nodeContent,
        'format' => 'custom_format',
      )
    );
    $node = $this->drupalCreateNode($nodeSettings);
    $this->drupalGet('node/' . $node->id());

    $this->assertText('Acquia Lift is Opted-', 'Content from Twig template should be used instead of placeholder.');
    $this->assertNoText(static::$optOutButtonToken, 'Placeholder does not appear in the output when filter is successful.');

    /* Test without Filter */
    $nodeSettings['body'] = array(
      array(
        'value' => $nodeContent,
        'format' => 'full_html',
      )
    );
    $node = $this->drupalCreateNode($nodeSettings);
    $this->drupalGet('node/' . $node->id());

    $this->assertNoText('Acquia Lift is Opted-', 'Content from Twig template should not be used.');
    $this->assertText(static::$optOutButtonToken, 'Placeholder appears in the output, because filtering is not enabled.');

    /* Test with enabled Filter - without Token */
    $nodeContent = 'Test Content. End of Test Content.';
    $nodeSettings['body'] = array(
      array(
        'value' => $nodeContent,
        'format' => 'custom_format',
      )
    );
    $node = $this->drupalCreateNode($nodeSettings);
    $this->drupalGet('node/' . $node->id());

    $this->assertNoText('Acquia Lift is Opted-', 'Content from Twig template should not be used.');
    $this->assertText($nodeContent, 'Content should be unchanged in output.');
  }

  /**
   * test does Filter option is displayed in text format configuration page
   */
  public function testFilterOption() {
    $this->drupalLogin($this->adminUser);

    $this->drupalGet('admin/config/content/formats/manage/plain_text');

    // check existence of checkbox: filters[filter_acquia_lift_optout_button][status]
    $this->assertFieldByName('filters[filter_acquia_lift_optout_button][status]');
  }

}