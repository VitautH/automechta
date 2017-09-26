/**
 * Helper for build language form.
 */
define(['context', 'messages'], function (context, messages) {
    'use strict';

    return function (category, message) {
        if (messages[category] && messages[category][message]) {
            return messages[category][message];
        }
        return message
    }
});