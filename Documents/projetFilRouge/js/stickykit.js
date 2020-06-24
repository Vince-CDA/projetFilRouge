'use strict';
/*-----------------------------------------------
|   Sticky Kit
-----------------------------------------------*/

Utils.$document.ready(function () {
  var stickyKit = $('.sticky-kit');

  if (stickyKit.length) {
    stickyKit.each(function (index, value) {
      $(value).stick_in_parent();
    });
  }
});