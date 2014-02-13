(function ($) {

  $('body').on('click', '.add-new-url', function (e) {
    e.preventDefault();
    var $this = $(this)
      , $ul = $this.next()
      , tmpl = $('<div>' + $('#url-page-list-template').html() + '</div>')
      , $li = $('<li />')
      , size = $ul.find('li').size() + 1;

    tmpl.find('.url-page-tmpl-link').attr('name', 'url-page[' + size + '][link]');
    tmpl.find('.url-page-tmpl-transition').attr('name', 'url-page[' + size + '][transition]');

    $li.html(tmpl);
    $ul.append($li);
  });

  $('body').on('click', '.url-page-list-delete', function (e) {
    e.preventDefault();
    $(this).parent().slideUp('slow', function () {
      $(this).remove();
    });
  });

}(window.jQuery));