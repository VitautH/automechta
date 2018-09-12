jQuery(function($) {
    if ($('#creditapplication-phone').length) {
        $('#creditapplication-phone').mask("+375 (99) 999-99-99");
    }

    $('#form-credit-application').submit(function (e) {
        e.preventDefault();

       var form_data = $(this).serialize();
       var action = $(this).attr('action');
        $.ajax({
            url:action,
            method:"POST",
            data:form_data,

            success:function(response) {
                if (response['status'] === 'success'){
                    $('#form-credit-application').find("input[type=text], textarea").val("");

                    $('#form-credit-application').after('<span class="credit-application-success">Заявка отправлена!</span>');
                }
            },
            error:function(){
                alert("Произошла ошибка!");
            }

        });

    });
});