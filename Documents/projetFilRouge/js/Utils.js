'use strict';
/*-----------------------------------------------
|   Utilities
-----------------------------------------------*/

var Utils = {
  $window: $(window),
  $document: $(document),
  $html: $('html'),
  $body: $('body'),
  $main: $('main'),
  isRTL: function isRTL() {
    return this.$html.attr('dir') === 'rtl';
  },
  location: window.location,
  nua: navigator.userAgent,
  breakpoints: {
    xs: 0,
    sm: 576,
    md: 768,
    lg: 992,
    xl: 1200
  },
  offset: function offset(element) {
    var rect = element.getBoundingClientRect();
    var scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;
    var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    return {
      top: rect.top + scrollTop,
      left: rect.left + scrollLeft
    };
  },
  isScrolledIntoViewJS: function isScrolledIntoViewJS(element) {
    var windowHeight = window.innerHeight;
    var elemTop = this.offset(element).top;
    var elemHeight = element.offsetHeight;
    var windowScrollTop = window.scrollY;
    return elemTop <= windowScrollTop + windowHeight && windowScrollTop <= elemTop + elemHeight;
  },
  isScrolledIntoView: function isScrolledIntoView(el) {
    var $el = $(el);
    var windowHeight = this.$window.height();
    var elemTop = $el.offset().top;
    var elemHeight = $el.height();
    var windowScrollTop = this.$window.scrollTop();
    return elemTop <= windowScrollTop + windowHeight && windowScrollTop <= elemTop + elemHeight;
  },
  getCurrentScreanBreakpoint: function getCurrentScreanBreakpoint() {
    var _this = this;

    var currentScrean = '';
    var windowWidth = this.$window.width();
    $.each(this.breakpoints, function (index, value) {
      if (windowWidth >= value) {
        currentScrean = index;
      } else if (windowWidth >= _this.breakpoints.xl) {
        currentScrean = 'xl';
      }
    });
    return {
      currentScrean: currentScrean,
      currentBreakpoint: this.breakpoints[currentScrean]
    };
  }
};