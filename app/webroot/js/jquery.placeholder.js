(function($) {

  $.fn.placeholder = function(color) {
    var test = document.createElement('input');
    if (!('placeholder' in test)) {
      var color = color || '#a9a9a9';

      var $input_fields = $(this).filter('input[type=text]');

      $input_fields.each(function() {
        var el = $(this);
        if ( el.attr('placeholder') && (! el.val()) ) {
          el
            .val(el.attr('placeholder'))
            .css('color', color)
            .closest('form').bind('submit.placeholder', function () {
              if (el.val() === el.attr('placeholder')) {
                el.val('');
              }
              return true;
            });
        }
      });

      $input_fields.focus(function() {
        input_value = $(this).val();

        if (input_value == '' || input_value == $(this).attr('placeholder')) {
          $(this)
            .val('')
            .css('color', '');
        }
      });

      $input_fields.blur(function() {
        if ($(this).val() == '') {
          $(this)
            .val($(this).attr('placeholder'))
            .css('color', color);
        }
      });
    }
  };

})(jQuery);
