$(document).ready(function () {

    $("ul.sorter li").each(function(){
        var sort = $(this).find('a').data('sort');
        var linksort = $(this).find('a');
        switch (sort){
            case '-price':
                $(linksort).append( "<i class='fas fa-angle-down'></i>" );
                break;
            case '-created_at':
                $(linksort).append( "<i class='fas fa-angle-down'></i>" );
                break;
            case '-year':
                $(linksort).append( "<i class='fas fa-angle-down'></i>" );
                break;
            case '-alphabet':
                $(linksort).append( "<i class='fas fa-angle-down'></i>" );
                break;
            case 'price':
                $(linksort).append( "<i class='fas fa-angle-up'></i>" );
                break;
            case 'created_at':
                $(linksort).append( "<i class='fas fa-angle-up'></i>" );
                break;
            case 'year':
                $(linksort).append( "<i class='fas fa-angle-up'></i>" );
                break;
            case 'alphabet':
                $(linksort).append( "<i class='fas fa-angle-up'></i>" );
                break;
        }
    });
})