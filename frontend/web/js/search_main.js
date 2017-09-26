$(document).ready(function() {
    $("#year_form").hide();
    $("#price_form").hide();
    $("#complaint_block").hide();
$("#year").click(function () {
    $("#year_form").slideToggle( "fast", function() {
    });

})
    $("#price").click(function () {
        $("#price_form").slideToggle( "fast", function() {
        });
    })
    $("#complaint_to").click(function () {
        $("#complaint_block").slideToggle( "fast", function() {
        });
    })
});