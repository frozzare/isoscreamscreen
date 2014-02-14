jQuery(function ($) {

  $('body').on('click', '.add-new-url', function (e) {
    e.preventDefault();
    var $this = $(this)
      , $ul = $this.next()
      , tmpl = $('<div>' + $('#url-page-list-template').html() + '</div>')
      , $li = $('<li />')
      , size = $ul.find('li').size() + 1;

    tmpl.find('.url-page-tmpl-link').attr('name', 'url-page[' + size + '][link]');
    tmpl.find('.url-page-tmpl-transition').attr('name', 'url-page[' + size + '][transition]');
    tmpl.find('.url-page-tmpl-template').attr('name', 'url-page[' + size + '][template]');
    tmpl.find('.url-page-tmpl-bgurl').attr('name', 'url-page[' + size + '][bgUrl]');
    tmpl.find('.url-page-tmpl-timer').attr('name', 'url-page[' + size + '][timer]');
    tmpl.find('.url-page-tmpl-timer').attr('name', 'url-page[' + size + '][title]');

    $li.html(tmpl);
    $ul.append($li);
  });

  $('body').on('click', '.url-page-list-delete', function (e) {
    e.preventDefault();
    $(this).parent().slideUp('slow', function () {
      $(this).remove();
    });
  });

  var orig =  wp.media.editor.send.attachment;

  $('body').on('click', '.mediauploader', function (e) {
    e.preventDefault();
    var button = $(this),
      target = button.prev();
    wp.media.editor.send.attachment = function(props, attachment) {
      $(target).val(attachment.url);
    };
    wp.media.editor.open(button);
  });


});