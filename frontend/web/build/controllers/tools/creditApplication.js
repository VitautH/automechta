define(['jquery', 'application', 'maskedinput'], function ($, applicatione) {
    'use strict';

    if ($('#creditapplication-phone').length) {
        $('#creditapplication-phone').mask("+375 (99) 999-99-99");
    }
    if ($('#creditapplication-dob').length) {
        $('#creditapplication-dob').mask("99/99/9999");
    }
    var selectedAuto = getCookie('automechta_selected_auto_for_credit');
    $('#creditapplication-product').val(selectedAuto);


    function getCookie(name) {
	  var matches = document.cookie.match(new RegExp(
	    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
	  ));
	  return matches ? decodeURIComponent(matches[1]) : undefined;
	}
});
