define(['application', 'jquery', 'list'], function (application, $, list) {
    var $changePasswordToggle = $('[name="change_password"]')

    new list({
        $list : $('.js-roles-list')
    });

    togglePasswordBlock();
    $changePasswordToggle.on('change', function () {
        togglePasswordBlock();
    });

    function togglePasswordBlock()
    {
        if ($('.js-password-block').find('.is-invalid').length > 0) {
            $changePasswordToggle.prop('checked', true);
        } else {
            if (!$changePasswordToggle.is(':checked')) {
                $('.js-password-block input[type="password"]').val('');
            }
        }

        $('.js-password-block').toggle($changePasswordToggle.is(':checked'));
    }

    $('.js-password-block input[type="password"]').on('change', function () {
        $('#user_form').yiiActiveForm('validateAttribute', 'user-password_repeat');
        $('#user_form').yiiActiveForm('validateAttribute', 'user-password_raw');
    });
});