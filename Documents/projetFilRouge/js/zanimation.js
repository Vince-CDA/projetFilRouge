"use strict";

/*-----------------------------------------------
|   Global Functions
-----------------------------------------------*/

/*
global TimelineMax, TweenMax, CustomEase
*/
CustomEase.create('CubicBezier', '.77,0,.18,1');

var filterBlur = function filterBlur() {
  var blur = 'blur(5px)';

  if (Detector.iPadiPhoneFirefox || Detector.macFirefox) {
    blur = 'blur(0px)';
  }

  return blur;
};

var zanimationEffects = {
  default: {
    from: {
      opacity: 0,
      y: 70
    },
    to: {
      opacity: 1,
      y: 0
    },
    ease: 'CubicBezier',
    duration: 0.8,
    delay: 0
  },
  'slide-down': {
    from: {
      opacity: 0,
      y: -70
    },
    to: {
      opacity: 1,
      y: 0
    },
    ease: 'CubicBezier',
    duration: 0.8,
    delay: 0
  },
  'slide-left': {
    from: {
      opacity: 0,
      x: 70
    },
    to: {
      opacity: 1,
      x: 0
    },
    ease: 'CubicBezier',
    duration: 0.8,
    delay: 0
  },
  'slide-right': {
    from: {
      opacity: 0,
      x: -70
    },
    to: {
      opacity: 1,
      x: 0
    },
    ease: 'CubicBezier',
    duration: 0.8,
    delay: 0
  },
  'zoom-in': {
    from: {
      scale: 0.9,
      opacity: 0,
      filter: filterBlur()
    },
    to: {
      scale: 1,
      opacity: 1,
      filter: 'blur(0px)'
    },
    delay: 0,
    ease: 'CubicBezier',
    duration: 0.8
  },
  'zoom-out': {
    from: {
      scale: 1.1,
      opacity: 1,
      filter: filterBlur()
    },
    to: {
      scale: 1,
      opacity: 1,
      filter: 'blur(0px)'
    },
    delay: 0,
    ease: 'CubicBezier',
    duration: 0.8
  },
  'zoom-out-slide-right': {
    from: {
      scale: 1.1,
      opacity: 1,
      x: -70,
      filter: filterBlur()
    },
    to: {
      scale: 1,
      opacity: 1,
      x: 0,
      filter: 'blur(0px)'
    },
    delay: 0,
    ease: 'CubicBezier',
    duration: 0.8
  },
  'zoom-out-slide-left': {
    from: {
      scale: 1.1,
      opacity: 1,
      x: 70,
      filter: filterBlur()
    },
    to: {
      scale: 1,
      opacity: 1,
      x: 0,
      filter: 'blur(0px)'
    },
    delay: 0,
    ease: 'CubicBezier',
    duration: 0.8
  },
  'blur-in': {
    from: {
      opacity: 0,
      filter: filterBlur()
    },
    to: {
      opacity: 1,
      filter: 'blur(0px)'
    },
    delay: 0,
    ease: 'CubicBezier',
    duration: 0.8
  }
};

if (Utils.isRTL()) {
  Object.keys(zanimationEffects).forEach(function (key) {
    if (zanimationEffects[key].from.x) {
      zanimationEffects[key].from.x = -zanimationEffects[key].from.x;
    }
  });
}

var breakPointConst = Utils.getCurrentScreanBreakpoint();
/*-----------------------------------------------
|   Zanimation
-----------------------------------------------*/

(function zanimation($) {
  /*-----------------------------------------------
  |   Get Controller
  -----------------------------------------------*/
  var controllerZanim;

  var getController = function getController(el) {
    var $this = $(el);
    var options = {};
    var controller = {};
    $.each($this, function (index, value) {
      if (value.hasAttribute("data-zanim-" + breakPointConst.currentScrean)) {
        controllerZanim = "zanim-" + breakPointConst.currentScrean;
      } else {
        /*-----------------------------------------------
        |   Set the mobile first Animation
        -----------------------------------------------*/
        var animationBreakpoints = [];
        $.each(value.attributes, function (i, attribute) {
          if (attribute.name !== 'data-zanim-trigger' && (Detector.isIE || Detector.isIE11 || Detector.isEdge ? attribute.name.match('^data-zanim-') : attribute.name.startsWith('data-zanim-'))) {
            var breakPoint = Utils.breakpoints[attribute.name.split('data-zanim-')[1]];

            if (breakPoint < breakPointConst.currentBreakpoint) {
              animationBreakpoints.push({
                name: attribute.name.split('data-zanim-')[1],
                size: breakPoint
              });
            }
          }

          return i;
        });
        controllerZanim = undefined;

        if (animationBreakpoints.length !== 0) {
          animationBreakpoints = animationBreakpoints.sort(function (a, b) {
            return a.size - b.size;
          });
          var activeBreakpoint = animationBreakpoints.pop();
          controllerZanim = "zanim-" + activeBreakpoint.name;
        }
      }

      return index;
    });
    controller = $.extend(true, {}, options, $this.data(controllerZanim));

    if (!(controllerZanim === undefined)) {
      if ($this.data(controllerZanim).animation) {
        options = zanimationEffects[$this.data(controllerZanim).animation];
      } else {
        options = zanimationEffects.default;
      }
    }

    if (controllerZanim === undefined) {
      options = {
        delay: 0,
        duration: 0,
        ease: 'Expo.easeOut',
        from: {},
        to: {}
      };
    }
    /*-----------------------------------------------
    |   populating the controller
    -----------------------------------------------*/


    controller.delay || (controller.delay = options.delay);
    controller.duration || (controller.duration = options.duration);
    controller.from || (controller.from = options.from);
    controller.to || (controller.to = options.to);
    controller.ease && (controller.to.ease = controller.ease) && controller.to.ease || (controller.to.ease = options.ease);
    return controller;
  };
  /*-----------------------------------------------
  |   End of Get Controller
  -----------------------------------------------*/


  jQuery.fn.zanimation = function zanim(callback) {
    var $this = $(this);
    /*-----------------------------------------------
    |   For Timeline
    -----------------------------------------------*/

    var zanimTimeline = $this.data('zanim-timeline');

    if (zanimTimeline) {
      var timeline = new TimelineMax(zanimTimeline);
      var timelineElements = $this.find('[data-zanim-xs], [data-zanim-sm], [data-zanim-md], [data-zanim-lg], [data-zanim-xl]');
      timelineElements.map(function (index, value) {
        var controller = getController(value);
        timeline.fromTo($(value), controller.duration, controller.from, controller.to, controller.delay).pause();
        return index;
      });
      $this.imagesLoaded(function () {
        return callback(timeline);
      });
    } else if (!$this.parents('[data-zanim-timeline]').length) {
      /*-----------------------------------------------
      |   For single elements outside timeline
      -----------------------------------------------*/
      var controller = getController($this);
      callback(TweenMax.fromTo($this, controller.duration, controller.from, controller.to).delay(controller.delay).pause());
    }

    callback(new TimelineMax());
  };
})(jQuery);
/*-----------------------------------------------
|   Triggering zanimation when the element enters in the view
-----------------------------------------------*/


(function triggeringZanimation($) {
  var triggerZanimation = function triggerZanimation($this) {
    if (Utils.isScrolledIntoView($this) && $this.attr('data-zanim-trigger') === 'scroll') {
      $this.zanimation(function (animation) {
        return animation.play();
      });
      if (!$this.data('zanim-repeat')) $this.removeAttr('data-zanim-trigger');
    }
  };

  Utils.$document.ready(function () {
    /*-----------------------------------------------
    |   Playing zanimation for scroll triggers
    -----------------------------------------------*/
    $("*[data-zanim-trigger = 'scroll']").map(function (index, value) {
      triggerZanimation($(value));
      Utils.$window.on('scroll', function () {
        triggerZanimation($(value));
      });
      return index;
    });
  });
})(jQuery);