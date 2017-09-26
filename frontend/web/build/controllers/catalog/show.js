define(['jquery', 'application', 'accrue', 'accounting'], function ($, application, accrue, accounting) {
    'use strict';

    $('.js-loan').on('submit', function (e) {
        e.preventDefault();

        var $price = $('.js-loan').find('[name="price"]');

        var term = $('.js-loan').find('[name="term"]').val();
        var amount = $price.val();
        var rate = $('.js-loan').find('[name="rate"]').val();

        $price.val(accounting.formatMoney(amount, '', 0));


        $(".calculator-loan").find('.term').val(term);
        $(".calculator-loan").find('.amount').val(amount);
        $(".calculator-loan").find('.rate').val(rate).trigger('change');
        var totalPayments = $(".calculator-loan").find('.total_payments').text();
        var paymentAmount = $(".calculator-loan").find('.payment_amount').text();
        $('.js-loan-results').find('.js-total-payments').text(totalPayments);
        var paymentAmountFormatted = paymentAmount.replace(/(.+)\.\d+/,'$1');
        paymentAmountFormatted = parseInt(paymentAmountFormatted.replace(/,/g,''), 10);
        paymentAmountFormatted = paymentAmountFormatted.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        $('.js-loan-results').find('.js-per-month').text((paymentAmountFormatted));
    });


    $(".calculator-loan").accrue({
        mode: "basic",
        operation: "keyup",
        default_values: {
            amount: $('.js-loan').find('[name="price"]').val(),
            rate: $('.js-loan').find('[name="rate"]').val(),
            term: $('.js-loan').find('[name="term"]').val(),
        },
        field_titles: {
            amount: "Loan Amount",
            rate: "Rate (APR)",
            rate_compare: "Comparison Rate",
            term: "Term"
        },
        button_label: "Calculate",
        field_comments: {
            amount: "",
            rate: "",
            rate_compare: "",
            term: "Format: 12m, 36m, 3y, 7y"
        },
        response_basic:
        '<p class="payment_amount">%payment_amount%</p>'+
        '<p class="num_payments">%num_payments%</p>'+
        '<p class="total_payments">%total_payments%</p>'+
        '<p class="total_interest">%total_interest%</p>'
    });

    $('.btn-credit').on('click',function(){
        var name = $('.b-detail__head-title h1').text();

        setCookie('automechta_selected_auto_for_credit',document.title+' ('+window.location.href +')',{domain:'.automechta.by',path:'/',expires:60*60*24*31});
    })

    $('.js-loan').submit();


    function setCookie(name, value, options) {
      options = options || {};

      var expires = options.expires;

      if (typeof expires == "number" && expires) {
        var d = new Date();
        d.setTime(d.getTime() + expires * 1000);
        expires = options.expires = d;
      }
      if (expires && expires.toUTCString) {
        options.expires = expires.toUTCString();
      }

      value = encodeURIComponent(value);

      var updatedCookie = name + "=" + value;

      for (var propName in options) {
        updatedCookie += "; " + propName;
        var propValue = options[propName];
        if (propValue !== true) {
          updatedCookie += "=" + propValue;
        }
      }

      document.cookie = updatedCookie;
    }
});
