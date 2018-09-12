$( document ).ready(function() {
$('.more').on('click',function(e){
e.preventDefault();
var id =  $(this).attr('id');
var url = $(this).data('url');
 $.ajax({
 url:url,
 type: 'GET',
success: function(data) {

    var buffer="";
var result = JSON.parse(data);

    $.each(result, function(index, item){

            buffer+=" <tr><td><a href='/catalog/"+item.maker_slug+"/"+item.model_slug+"/"+item.modification_id+"'>"+item.modification_name+"</a></td><td> "+item.modification_yearFrom+" - "+item.modification_yearTo+"</td><td>"+item.modification_engine+" </td> <td>"+item.modification_drive_unit+"</td></tr>";
    });
    $('#block-'+id).after('<div class="table-responsive table-sublist"><table class="sublist table" id="list_'+id+'"><thead><tr><td>Модификация</td><td>Год выпуска:</td><td>Двигатель</td><td>Привод</td></tr></thead><tbody>'+buffer+'</tbody></table></div><div class="clearList btn m-btn" data-clear="'+id+'">Скрыть</div>');
    $('#'+id).hide();
    $('#block-'+id).hide();
             }
         });
});
});
$(document).on('click','.clearList', function(){
    var id =  $(this).data('clear');
    $('#list_'+id).hide();
    $(this).hide();
    $('#'+id).show();
});

$(document).on('click','.country-active', function(){
    var to =  $(this).data('to');
    $(this).removeClass('country-active');
    $(this).addClass('country-hidden');
    $(this).find('.fas').removeClass('fa-chevron-up');
    $(this).find('.fas').addClass('fa-chevron-down');
    $('#'+to+'').addClass('hidden');

});

$(document).on('click','.country-hidden', function(){
    var to =  $(this).data('to');
    $(this).removeClass('country-hidden');
    $(this).addClass('country-active');
    $(this).find('.fas').removeClass('fa-chevron-down');
    $(this).find('.fas').addClass('fa-chevron-up');
    $('#'+to+'').removeClass('hidden');
});


$(document).on('click','.thumb-image', function(e){
e.preventDefault();
var groupgallery = $(this).data('groupgallery');
var image =  $(this).css('background-image');
var fullimage = $(this).data('image');
    $("div[data-groupgallery='"+groupgallery+"']").each(function() {
        $(this).css("border","none");
    });

    $(this).css("border","1px solid #db4544");
$('#main-image-'+groupgallery).css("background-image",image);
    $('#main-fullimage-'+groupgallery).attr('href', fullimage);
});