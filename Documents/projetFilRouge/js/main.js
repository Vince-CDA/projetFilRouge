"use strict";


/*-----------------------------------------------
|   Pre-loader
-----------------------------------------------*/
$.holdReady(true);
$($('main section')[0]).imagesLoaded({
  background: '.background-holder'
}, function () {
  $.holdReady(false);
});
Utils.$document.ready(function () {
  var $preloader = $('#preloader');
  $preloader.addClass('loaded');
  setTimeout(function () {
    $preloader.remove();
  }, 800);
});
/*-----------------------------------------------
|   Documentation and Component Navigation
-----------------------------------------------*/

Utils.$document.ready(function () {
  var $componentNav = $('#components-nav');

  if ($componentNav.length) {
    var loc = window.location.href;

    var _loc$split = loc.split('#');

    loc = _loc$split[0];
    var location = loc.split('/');
    var url = location[location.length - 2] + "/" + location.pop();
    var urls = $componentNav.children('li').children('a');

    for (var i = 0, max = urls.length; i < max; i += 1) {
      var dom = urls[i].href.split('/');
      var domURL = dom[dom.length - 2] + "/" + dom.pop();

      if (domURL === url) {
        var $targetedElement = $(urls[i]);
        $targetedElement.removeClass('color-5');
        $targetedElement.addClass('fw-700');
        break;
      }
    }
  }
});
/*-----------------------------------------------
|   Table collation
-----------------------------------------------*/

Utils.$document.ready(function () {
  var $tableCollation = $('.table-collation');

  if ($tableCollation.length) {
    $tableCollation.each(function () {
      var $this = $(this);
      $this.tableCollation({
        /* myClass:'table-responsive' */
      });
    });
  }
});
/*-----------------------------------------------
|   Nav burger Panel
-----------------------------------------------*/

Utils.$document.ready(function () {
  var znavContainer = $('.znav-container');
  var navBurger = $('.nav-burger');
  var navBurgerPanel = $('.nav-burger-panel');
  navBurgerPanel.css({
    top: znavContainer.height(),
    height: "calc(100vh - " + znavContainer.height() + "px)"
  });
  navBurger.click(function () {
    navBurgerPanel.toggleClass('nav-burger-panel-collapsed');
    navBurger.toggleClass('is-active');
  });
});
/*-----------------------------------------------
|   Top navigation opacity on scroll
-----------------------------------------------*/

Utils.$document.ready(function () {
  var backgroundOnScrollTransparent = $('.background-on-scroll-transparent');
  backgroundOnScrollTransparent.css({
    backgroundColor: 'rgba(0, 0, 0, 0)',
    transition: 'background-color 0.3s ease-in-out'
  });

  if (backgroundOnScrollTransparent.length) {
    var windowHeight = Utils.$window.height();
    Utils.$window.scroll(function () {
      var scrollTop = Utils.$window.scrollTop();
      var alpha = scrollTop / windowHeight * 2;
      alpha >= 1 && (alpha = 1);
      backgroundOnScrollTransparent.css({
        'background-color': "rgba(0, 0, 0, " + alpha + ")"
      });
    }); // Top navigation background toggle on mobile

    backgroundOnScrollTransparent.on('show.bs.collapse hide.bs.collapse', function () {
      return backgroundOnScrollTransparent.toggleClass('background-black');
    });
  }
});
/*-----------------------------------------------
|   Shuffle
-----------------------------------------------*/

Utils.$document.ready(function () {
  var filterContainer = $('.filter-container');
  var filterMenu = $('.filter-menu');

  if (filterMenu.length) {
    var shuffleInstance = new Shuffle(filterContainer, {
      itemSelector: '.filter-item'
    });
    shuffleInstance.filter('header');
    filterMenu.on('click', '.item', function (e) {
      var $this = $(e.target);
      var filterValue = $this.data('filter');
      $this.siblings().removeClass('active');
      $this.addClass('active');
      shuffleInstance.filter(filterValue);
    });
  }
});