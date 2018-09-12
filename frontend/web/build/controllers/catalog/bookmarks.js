 $(document).ready(function() {
     function addBookmarks(action) {

         var productId = $(action).data('product');
         $.ajax({
             url: '/bookmarks/add?id=' + productId,
             type: 'GET',
             success: function (data) {
                 $('a[data-product="' + data['id'] + '"]').attr('title', 'Удалить из закладок').attr('id', 'delete-bookmarks').removeClass('add-to-favorite').addClass('in-favorite');
             }
         });
     };


        function deleteBookmarks(action) {
    var productId = $(action).data('product');
    $.ajax({
        url: '/bookmarks/delete?id=' + productId,
        type: 'GET',
        success: function (data) {
            $('[data-product="' + data['id'] + '"]').attr('title', 'Добавить в закладки').attr('id', 'add-bookmarks').removeClass('in-favorite').addClass('add-to-favorite');
        }
    });

};

$('a.bookmarks').on('click', function (e) {
    e.preventDefault();
    var action = $(this).attr('id');

    switch (action) {
        case 'delete-bookmarks':
            deleteBookmarks(this);
            break;

        case 'add-bookmarks':
            addBookmarks(this);
            break;

    }
});
 });
