/**
 * Defines the CKEditor plugin for Acquia Lift Opt-Out Button plugin
 */
CKEDITOR.plugins.add('AcquiaLiftOptOutCKEditorButton', {
    requires: ['button'],
    init: function (editor) {
        editor.addCommand('addOptOutButton', {
            exec: function (editor) {
                editor.insertHtml('[acquia_lift:optout_button]');
            }
        });

        // Add buttons.
        if (editor.ui.addButton) {
            editor.ui.addButton('AcquiaLiftOptOutCKEditorButton', {
                label: Drupal.t('Acquia Lift Opt-Out'),
                command: 'addOptOutButton',
                icon: this.path + '/images/acquia-lift-icon.png'
            });
        }
    }
});
