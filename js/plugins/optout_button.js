/**
 * @file
 * Add handlers for Acquia Lift Opt-Out/In button.
 */

jQuery(function () {
  var optedOut = typeof jQuery.cookie("tc_dnt") !== "undefined",
    acquiaLiftOpt = jQuery('.acquia-lift-optout'),
    textBox = jQuery('.acquia-lift-optout__text-box'),
    toggleButton = jQuery('.acquia-lift-optout__button-wrapper');

  /**
   * Set/unset DoNotTrack flag for Acquia Lift -> if _tcaq is available.
   */
  var toggleOpt = function () {
    if (typeof _tcaq === 'undefined') {
      return;
    }

    if (optedOut) {
      _tcaq.push(["setDoNotTrack", false]);
    }
    else {
      _tcaq.push(["setDoNotTrack", true]);
    }

    // Set new state.
    optedOut = !optedOut;

    // Adjust layout (flip class states)
    textBox.toggleClass('hidden');
    acquiaLiftOpt.toggleClass('acquia-lift-optout--enabled');
  };

  // Register events on click.
  toggleButton.click(toggleOpt);
});
