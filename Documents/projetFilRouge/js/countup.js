'use strict';
/*-----------------------------------------------
|   Count Up
-----------------------------------------------*/

Utils.$document.ready(function () {
  var $counters = $('[data-countup]');

  if ($counters.length) {
    $counters.each(function (index, value) {
      var $counter = $(value);
      var counter = $counter.data('countup');

      var toAlphanumeric = function toAlphanumeric(num) {
        var number = num;
        var abbreviations = {
          k: 1000,
          m: 1000000,
          b: 1000000000,
          t: 1000000000000
        };

        if (num < abbreviations.m) {
          number = (num / abbreviations.k).toFixed(1) + 'k';
        } else if (num < abbreviations.b) {
          number = (num / abbreviations.m).toFixed(1) + 'm';
        } else if (num < abbreviations.t) {
          number = (num / abbreviations.b).toFixed(1) + 'b';
        } else {
          number = (num / abbreviations.t).toFixed(1) + 't';
        }

        return number;
      };

      var toComma = function toComma(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
      };

      var toSpace = function toSpace(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
      };

      var playCountUpTriggered = false;

      var countUP = function countUP() {
        if (Utils.isScrolledIntoView(value) && !playCountUpTriggered) {
          if (!playCountUpTriggered) {
            $({
              countNum: 0
            }).animate({
              countNum: counter.count
            }, {
              duration: 3000,
              easing: 'linear',
              step: function step() {
                $counter.text(Math.floor(this.countNum));
              },
              complete: function complete() {
                switch (counter.format) {
                  case 'comma':
                    $counter.text(toComma(this.countNum));
                    break;

                  case 'space':
                    $counter.text(toSpace(this.countNum));
                    break;

                  case 'alphanumeric':
                    $counter.text(toAlphanumeric(this.countNum));
                    break;

                  default:
                    $counter.text(this.countNum);
                }
              }
            });
            playCountUpTriggered = true;
          }
        }

        return playCountUpTriggered;
      };

      countUP();
      Utils.$window.scroll(function () {
        countUP();
      });
    });
  }
});