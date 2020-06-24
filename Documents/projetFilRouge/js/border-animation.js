"use strict";

function _extends() { _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return _extends.apply(this, arguments); }

/*-----------------------------------------------
|   Border Animation
-----------------------------------------------*/
Utils.$document.ready(function () {
  var borders = $('[data-animation-border]');

  if (borders.length) {
    borders.each(function (index, value) {
      var border = $(value);
      border.css({
        position: 'relative'
      });
      border.prepend("<div class='border-tr'></div>");
      border.append("<div class='border-bl'></div>");
      var borderTR = border.children('.border-tr');
      var borderBL = border.children('.border-bl');
      var options = {
        duration: 1,
        delay: 0,
        ease: 'CubicBezier',
        width: '3px'
      };

      var controller = _extends(options, border.data('animation-border'));

      var duration = controller.duration / 4;
      var borderTimeline = new TimelineMax({});
      var css = {
        top: 0,
        left: 0,
        position: 'absolute',
        borderRadius: "" + (controller.radius ? controller.radius : '0px'),
        background: "" + (controller.color ? controller.color : 'linear-gradient(120deg, #EE7752, #E73C7E, #23A6D5, #23D5AB)'),
        backgroundSize: '400% 400%',
        animation: 'Gradient 10s ease infinite',
        clipPath: "polygon(0% 100%, 0% 100%, 0% " + controller.width + ", calc(100% - " + controller.width + ") " + controller.width + ", calc(100% - " + controller.width + ") 100%, 0% 100%, " + controller.width + " 100%, 100% 100%, 100% 0%, 0% 0%)"
      };
      /*-----------------------------------------------
      |  TODO: Push this keyframe and remove from css
      |  @keyframes Gradient {
      |    0% { background-position: 0% 50%; }
      |    50% { background-position: 100% 50%; }
      |    100% { background-position: 0% 50%; }
      |  }
      -----------------------------------------------*/

      /*-----------------------------------------------
      |   Border Animation Profile
      -----------------------------------------------*/

      borderTR.css(css);

      switch (controller.animation) {
        case 'collapse':
          borderTR.css(_extends(css, {
            left: 'auto',
            right: 0
          }));
          borderBL.css(_extends(css, {
            top: 'auto',
            right: 'auto',
            bottom: 0,
            left: 0,
            clipPath: "polygon(0% 100%, " + controller.width + " 100%, " + controller.width + " 0%, 100% 0%, 100% calc(100% - " + controller.width + "), 0% calc(100% - " + controller.width + "), " + controller.width + " 100%, 100% 100%, 100% 0%, 0% 0%)"
          }));
          borderTimeline.fromTo(borderTR, controller.duration, {
            width: controller.width
          }, {
            width: '100%',
            ease: controller.ease
          }).fromTo(borderTR, controller.duration, {
            height: controller.width
          }, {
            height: '100%',
            ease: controller.ease
          }, "-=" + controller.duration).fromTo(borderBL, controller.duration, {
            height: controller.width
          }, {
            height: '100%',
            ease: controller.ease
          }, "-=" + controller.duration).fromTo(borderBL, controller.duration, {
            width: controller.width
          }, {
            width: '100%',
            ease: controller.ease
          }, "-=" + controller.duration).delay(controller.delay).pause();
          break;

        case 'circular':
          borderBL.css(_extends(css, {
            top: 'auto',
            left: 'auto',
            bottom: 0,
            right: 0,
            clipPath: "polygon(0% 100%, " + controller.width + " 100%, " + controller.width + " 0%, 100% 0%, 100% calc(100% - " + controller.width + "), 0% calc(100% - " + controller.width + "), " + controller.width + " 100%, 100% 100%, 100% 0%, 0% 0%)"
          }));
          borderTimeline.fromTo(borderTR, duration, {
            width: controller.width
          }, {
            width: '100%',
            ease: controller.ease
          }).fromTo(borderTR, duration, {
            height: controller.width
          }, {
            height: '100%',
            ease: controller.ease
          }).fromTo(borderBL, duration, {
            width: controller.width
          }, {
            width: '100%',
            ease: controller.ease
          }).fromTo(borderBL, duration, {
            height: controller.width
          }, {
            height: '100%',
            ease: controller.ease
          }).delay(controller.delay).pause();
          break;

        default:
          borderBL.css(_extends(css, {
            clipPath: "polygon(0% 100%, " + controller.width + " 100%, " + controller.width + " 0%, 100% 0%, 100% calc(100% - " + controller.width + "), 0% calc(100% - " + controller.width + "), " + controller.width + " 100%, 100% 100%, 100% 0%, 0% 0%)"
          }));
          duration *= 2;
          borderTimeline.fromTo(borderTR, duration, {
            width: controller.width
          }, {
            width: '100%',
            ease: controller.ease
          }).fromTo(borderTR, duration, {
            height: controller.width
          }, {
            height: '100%',
            ease: controller.ease
          }).fromTo(borderBL, duration, {
            height: controller.width
          }, {
            height: '100%',
            ease: controller.ease
          }, "-=" + duration * 2).fromTo(borderBL, duration, {
            width: controller.width
          }, {
            width: '100%',
            ease: controller.ease
          }, "-=" + duration).delay(controller.delay).pause();
          break;
      }
      /*-----------------------------------------------
      |   Triggering Border Animation
      -----------------------------------------------*/


      Utils.$window.on('load scroll', function () {
        if (Utils.isScrolledIntoView(border)) {
          borderTimeline.play();
          border.removeAttr('data-animation-border');
        }
      });
    });
  }
});