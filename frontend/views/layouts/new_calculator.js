define(['jquery', 'application', 'accrue'], function ($, application, accrue) {
    'use strict';
    $('#showCalculator').click(function(e){
        e.preventDefault();
        $( ".calculator-block" ).toggle(1, function() {
            // Animation complete.
        } );
    })
        $("#term").change(function () {
            calculation();
        })
        $("#prepayment").change(function () {
            calculation();
        })
    $("#rate").change(function () {
        calculation();
    })
    $("#term-mobile").change(function () {
        calculationMobile();
    })
    $("#prepayment-mobile").change(function () {
        calculationMobile();
    })
    $("#rate-mobile").change(function () {
        calculationMobile();
    })
    $('.js-loan-mobile').on('submit', function (e) {
        e.preventDefault();
        calculationMobile();
    });
        $('.js-loan').on('submit', function (e) {
            e.preventDefault();
            calculation();
        });
        function calculation() {
            var term = $('.js-loan').find('[name="term"]').val();
            var prepayment = $('.js-loan').find('[name="prepayment"]').val();
            var amount = $('.js-loan').find('[name="price"]').val();
            if (prepayment !== amount) {
                amount = amount - prepayment;
            }
            var rate = $('.js-loan').find('[name="rate"]').val();
            $(".calculator-loan").find('.term').val(term);
            $(".calculator-loan").find('.amount').val(amount);
            $(".calculator-loan").find('.rate').val(rate).trigger('change');
            var totalPayments = $(".calculator-loan").find('.total_payments').text();
            var paymentAmount = $(".calculator-loan").find('.payment_amount').text();
            $('.js-loan-results').find('.js-total-payments').text(totalPayments);
            var paymentAmountFormatted = paymentAmount.replace(/(.+)\.\d+/, '$1');
            paymentAmountFormatted = parseInt(paymentAmountFormatted.replace(/,/g, ''), 10);
            paymentAmountFormatted = paymentAmountFormatted.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
            if (prepayment === amount) {
                paymentAmountFormatted = 0;
            }

            if (isNaN(paymentAmountFormatted)){
                paymentAmountFormatted = 0;
            }
            
            $('.js-loan-results').find('.js-per-month').text((paymentAmountFormatted+" "));
        }

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
            response_basic: '<p class="payment_amount">%payment_amount%</p>' +
            '<p class="num_payments">%num_payments%</p>' +
            '<p class="total_payments">%total_payments%</p>' +
            '<p class="total_interest">%total_interest%</p>'
        });

        $('.js-loan').submit();

    function calculationMobile() {
        var term = $('.js-loan-mobile').find('[name="term"]').val();
        var prepayment = $('.js-loan-mobile').find('[name="prepayment"]').val();
        var amount = $('.js-loan-mobile').find('[name="price"]').val();
        if (prepayment !== amount) {
            amount = amount - prepayment;
        }
        var rate = $('.js-loan-mobile').find('[name="rate"]').val();
        $(".calculator-loan-mobile").find('.term').val(term);
        $(".calculator-loan-mobile").find('.amount').val(amount);
        $(".calculator-loan-mobile").find('.rate').val(rate).trigger('change');
        var totalPayments = $(".calculator-loan-mobile").find('.total_payments').text();
        var paymentAmount = $(".calculator-loan-mobile").find('.payment_amount').text();
        $('.js-loan-results-mobile').find('.js-total-payments-mobile').text(totalPayments);
        var paymentAmountFormatted = paymentAmount.replace(/(.+)\.\d+/, '$1');
        paymentAmountFormatted = parseInt(paymentAmountFormatted.replace(/,/g, ''), 10);
        paymentAmountFormatted = paymentAmountFormatted.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        if (prepayment === amount) {
            paymentAmountFormatted = 0;
        }

        if (isNaN(paymentAmountFormatted)){
            paymentAmountFormatted = 0;
        }

        $('.js-loan-results-mobile').find('.js-per-month-mobile').text((paymentAmountFormatted+" "));
    }
    $(".calculator-loan-mobile").accrue({
        mode: "basic",
        operation: "keyup",
        default_values: {
            amount: $('.js-loan-mobile').find('[name="price"]').val(),
            rate: $('.js-loan-mobile').find('[name="rate"]').val(),
            term: $('.js-loan-mobile').find('[name="term"]').val(),
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
        response_basic: '<p class="payment_amount">%payment_amount%</p>' +
        '<p class="num_payments">%num_payments%</p>' +
        '<p class="total_payments">%total_payments%</p>' +
        '<p class="total_interest">%total_interest%</p>'
    });

    $('.js-loan-mobile').submit();
    });