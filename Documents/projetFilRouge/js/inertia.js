'use strict';
/*-----------------------------------------------
|   Inertia
-----------------------------------------------*/

function _extends() { _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return _extends.apply(this, arguments); }

(function triggeringInertia($) {
  $.fn.inertia = function () {
    var element = this;
    var offset = element.offset().top;
    var winHeight = Utils.$window.height();

    var controller = _extends({
      weight: 1,
      y: 0,
      ease: 'Expo.easeOut',
      duration: 2,
      delay: 0
    }, this.data('inertia'));

    controller.constant = controller.weight * 100 / winHeight;
    element.css({
      transform: "translateY(" + controller.y + "px)"
    });
    var baseY = controller.y || 0;

    var inertia = function inertia(y) {
      return TweenMax.to(element, controller.duration, {
        y: baseY + y,
        ease: controller.ease
      }).delay(controller.delay).pause();
    };

    var triggeringInertia = function triggeringInertia() {
      controller.y = controller.constant * (offset - Utils.$window.scrollTop());
      inertia(controller.y).play();
    };
    /*-----------------------------------------------
    |   Triggering inertia
    -----------------------------------------------*/


    triggeringInertia();
    Utils.$window.on('scroll', function () {
      // Utils.isScrolledIntoView(element) && triggeringInertia();
      // console.debug(`${Utils.$window.height()} + ${Utils.$window.scrollTop()} = ${Utils.$window.height() + Utils.$window.scrollTop()} [${offset}]`);
      if (offset <= Utils.$window.height() + Utils.$window.scrollTop()) triggeringInertia();
    });
  };
})(jQuery);
/*-----------------------------------------------
|   Initiate Inertia
-----------------------------------------------*/


Utils.$document.ready(function () {
  if (!Detector.isPuppeteer) {
    var elements = $('[data-inertia]');
    elements.each(function (index, element) {
      $(element).inertia();
    });
  }
});