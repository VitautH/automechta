/**
 * Helper for build language form.
 */
define(['jquery'], function ($) {
    'use strict';

    var tabsContainerSelector = '.js-i18n-tabs',
        tabsPanelSelector = '.mdl-tabs__panel',
        tabsButtonSelector = '.mdl-tabs__tab';

    return {
        initForm : function ($form) {
            var $tabsContainer = $form.find(tabsContainerSelector),
                $errorFields,
                $tabsPanel,
                $tabButton,
                $input;

            $form.on('afterValidateAttribute', function (event, attribute, messages) {
                $input = $form.find(attribute.input);
                $tabsPanel = $input.closest(tabsPanelSelector);
                $tabButton = $tabsContainer.find('[href="#' + $tabsPanel.attr('id') + '"]');

                if (messages.length) {
                    $tabButton.addClass('is-invalid');
                } else {
                    $errorFields = $tabsPanel.find('.is-invalid').not($input);
                    if ($errorFields.length === 0) {
                        $tabButton.removeClass('is-invalid');
                    }
                }
            });
        }
    }
});