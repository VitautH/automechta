$(document).ready(function(){
    var ScreenWidth = screen.width;
    if (ScreenWidth < 3000) {
        $('.brands').readmore({
            speed: 75,
            maxHeight: 200,
            moreLink: '<a class="catalog-show-all" href="#">Показать все</a>',
            lessLink: '<a class="catalog-show-all" href="#">Спрятать</a>',
        });
    }

    $('#open-filter').click(function () {
        $('#filter').addClass('open-filter');
        $('html, body').css('overflow', 'hidden');
    });

    $('#close-filter').click(function () {
        $('#filter').removeClass('open-filter');
        $('html, body').css('overflow', 'auto');
    });

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
      case 'price':
          $(linksort).append( "<i class='fas fa-angle-up'></i>" );
          break;
      case 'created_at':
          $(linksort).append( "<i class='fas fa-angle-up'></i>" );
          break;
      case 'year':
          $(linksort).append( "<i class='fas fa-angle-up'></i>" );
          break;
  }
    });

    $('a.dollar').click(function (e) {
        e.preventDefault();
    });
    
});