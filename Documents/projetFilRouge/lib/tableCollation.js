/**
 * tableCollation
 * Inspired from: https://github.com/johnpolacek/stacktable.js/
 *
 * jQuery plugin for stacking tables on small screens
 * Requires jQuery version 1.7 or above
 *
 */
(function ($) {
  $.fn.tableCollation = function (options) {
    var $tables = this,
      defaults = {},
      settings = $.extend({}, defaults, options);

    return $tables.each(function () {
      var $table = $(this);
      var $caption = $table.find(">caption").clone();
      var num_cols = $table.find('>thead>tr,>tbody>tr,>tfoot>tr').eq(0).find('>td,>th').length;
      var col_i = 1;

      while (col_i < num_cols) {

        var $stackcolumns = $('<table class="table stacktable d-lg-none"></table>');
        if (typeof settings.myClass !== 'undefined') $stackcolumns.addClass(settings.myClass);
        $table.addClass('stacktable d-none d-lg-table');

        var th = $('<thead></thead>');
        var tb = $('<tbody></tbody>');

        var lastindex = $table.find('>thead>tr,>tbody>tr,>tfoot>tr').length - 1;

        $table.find('>thead>tr,>tbody>tr,>tfoot>tr').each(function (index, item) {
          var tem = $('<tr></tr>');

          var first = $(this).find('>td,>th').eq(0).clone().addClass("st-key");
          var target = col_i;

          var second = $(this).find('>td,>th').eq(target).clone().addClass("st-val").removeAttr("colspan");

          if (index === 0) {
            second.attr('colspan', 2);
            tem.append(second);
            th.append(tem);
          } else if (index === lastindex) {
            second.attr('colspan', 2);
            tem.append(second);
            tb.append(tem);
          }
          else {
            tem.append(first, second);
            tb.append(tem);
          }
        });

        $stackcolumns.append($(th));
        $stackcolumns.append($(tb));
        $stackcolumns.prepend($caption);
        $table.before($stackcolumns);

        ++col_i;
      }
    });
  };
}(jQuery));
