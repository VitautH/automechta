$(document).ready(function(){
    var phone;
    function windowSize(){
        if ($(window).width() <= '992'){
            phone = true;
        } else {
             phone = false;
        }
    }
    $(window).on('load resize',windowSize);
    $('#private-cars-tab').click(function(){
        $.ajax({
            type: "GET",
            url: 'site/carousel?type=PrivateCars',
            beforeSend: function () {
                $('.loader').fadeIn( 200, "linear" );
                $('.slide').fadeOut( 200, "linear" );
                $('#private-cars').css('height','425px');
            },
            success: function (response) {
                $('#private-cars').empty();
              $('#private-cars').append(response);
                $('#carousel-PrivateCars').slick({
                    dots: true,
                    arrows: false,
                    infinite: true,
                    speed: 300,
                    slidesToShow: 4,
                    slidesToScroll: 4,
                    adaptiveHeight: false,
                    responsive: [
                        {
                            breakpoint: 768,
                            settings: {
                                dots: false,
                                arrows: true,
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                centerMode: true,
                                variableWidth: true
                            }
                        },
                        {
                            breakpoint: 992,
                            settings: {
                                dots: false,
                                arrows: true,
                                slidesToShow: 2,
                                slidesToScroll: 2,
                                centerMode: true,
                                variableWidth: true
                            }
                        }
                    ]
                });
                $('.loader').fadeOut( 200, "linear" );
                if (phone === false) {
                    $('.slide').fadeIn(200, "linear");
                }
            },
            error:
                function (response) {

                }
        });

    })
    $('#company-cars-tab').click(function(){
        $.ajax({
            type: "GET",
            url: 'site/carousel?type=CompanyCars',
            beforeSend: function () {
                $('#company-cars').css('height','425px');
                $('.loader').fadeIn( 200, "linear" );
                $('.slide').fadeOut( 200, "linear" );
            },
            success: function (response) {
                $('#company-cars').empty();
                $('#company-cars').append(response);
                $('#carousel-CompanyCars').slick({
                    dots: true,
                    arrows: false,
                    infinite: true,
                    speed: 300,
                    slidesToShow: 4,
                    slidesToScroll: 4,
                    adaptiveHeight: false,
                    responsive: [
                        {
                            breakpoint: 768,
                            settings: {
                                dots: false,
                                arrows: true,
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                centerMode: true,
                                variableWidth: true
                            }
                        },
                        {
                            breakpoint: 992,
                            settings: {
                                dots: false,
                                arrows: true,
                                slidesToShow: 2,
                                slidesToScroll: 2,
                                centerMode: true,
                                variableWidth: true
                            }
                        }
                    ]
                });
                $('.loader').fadeOut( 200, "linear" );
                if (phone === false) {
                    $('.slide').fadeIn(200, "linear");
                }
            },
            error:
                function (response) {

                }
        });

    })
    $('#moto-tab').click(function(){
        $.ajax({
            type: "GET",
            url: 'site/carousel?type=Motos',
            beforeSend: function () {
                $('.loader').fadeIn( 200, "linear" );
                $('.slide').fadeOut( 200, "linear" );
                $('#moto').css('height','425px');

            },
            success: function (response) {
                $('#moto').empty();
                $('#moto').append(response);
                $('#carousel-Motos').slick({
                    dots: true,
                    arrows: false,
                    infinite: true,
                    speed: 300,
                    slidesToShow: 4,
                    slidesToScroll: 4,
                    adaptiveHeight: false,
                    responsive: [
                        {
                            breakpoint: 768,
                            settings: {
                                dots: false,
                                arrows: true,
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                centerMode: true,
                                variableWidth: true
                            }
                        },
                        {
                            breakpoint: 992,
                            settings: {
                                dots: false,
                                arrows: true,
                                slidesToShow: 2,
                                slidesToScroll: 2,
                                centerMode: true,
                                variableWidth: true
                            }
                        }
                    ]
                });
                $('.loader').fadeOut( 200, "linear" );
                if (phone === false) {
                    $('.slide').fadeIn(200, "linear");
                }
            },
            error:
                function (response) {

                }
        });

    })
    $('#boat-tab').click(function(){
        $.ajax({
            type: "GET",
            url: 'site/carousel?type=Boat',
            beforeSend: function () {
                $('.loader').fadeIn( 200, "linear" );
                $('.slide').fadeOut( 200, "linear" );
                $('#boat').css('height','425px');

            },
            success: function (response) {
                $('#boat').empty();
                $('#boat').append(response);
                $('#carousel-Boat').slick({
                    dots: true,
                    arrows: false,
                    infinite: true,
                    speed: 300,
                    slidesToShow: 4,
                    slidesToScroll: 4,
                    adaptiveHeight: false,
                    responsive: [
                        {
                            breakpoint: 768,
                            settings: {
                                dots: false,
                                arrows: true,
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                centerMode: true,
                                variableWidth: true
                            }
                        },
                        {
                            breakpoint: 992,
                            settings: {
                                dots: false,
                                arrows: true,
                                slidesToShow: 2,
                                slidesToScroll: 2,
                                centerMode: true,
                                variableWidth: true
                            }
                        }
                    ]
                });
               $('.loader').fadeOut( 200, "linear" );
                if (phone === false) {
                    $('.slide').fadeIn(200, "linear");
                }
            },
            error:
                function (response) {

                }
        });

    })
})