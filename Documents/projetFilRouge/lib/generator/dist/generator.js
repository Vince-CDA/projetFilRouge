"use strict";

/*-----------------------------------------------
|   Generator
-----------------------------------------------*/
var TARGET_SORT_ARRAY = ['navigation', 'header', 'features', 'content', 'team', 'cta', 'gallery', 'forms', 'partners', 'testimonials', 'pricing', 'contact', 'footer'];
var ACTIVE_ITEM = TARGET_SORT_ARRAY[1];
$(document).ready(function () {
  /*-----------------------------------------------
  |   Draggable Container Content
  -----------------------------------------------*/
  var dragableItems = $('#dragable-items');
  var sortableContainerContent = "";

  var sortableItemHTML = function sortableItemHTML(key) {
    var n = 1;
    var sortableContainerItemContent = "";

    while (n <= blocksObject[key]) {
      sortableContainerItemContent += "\n        <div class='draggable-item " + (key === ACTIVE_ITEM ? key : key + " d-none") + "'>\n          <p class='section-id'>" + key + "-" + n + "</p>\n          <img src='./assets/images/screenshots/blocks/" + key + "-" + n + ".jpg', alt=" + key + ">\n          <div class='btn-group btn-group-action'>\n              <a href='blocks/" + key + "-" + n + ".html' target='_blank' class='btn btn-secondary btn-xs btn-capsule'>\n                <span class='fas fa-browser mr-2' data-fa-transform='grow-5'></span>\n                View\n              </a>\n              <div class='btn btn-secondary btn-xs btn-capsule remove'>\n                <span class='fas fa-trash mr-2' data-fa-transform='grow-5'></span>\n                Remove " + key + "-" + n++ + "\n              </div>\n            </div>\n        </div>\n      ";
    }

    return sortableContainerItemContent;
  };
  /*-----------------------------------------------
  |   Menu Content
  -----------------------------------------------*/
  // const reducer = (obj) => Object.values(obj).reduce((a, b) => a + b); // Add all values of any object


  var reducerAlternative = function reducerAlternative(obj, total) {
    if (total === void 0) {
      total = 0;
    }

    Object.keys(obj).map(function (key) {
      return total += blocksObject[key];
    });
    return total;
  };

  var menuContent = "<a class=\"d-block mb-4 px-4\" href=\"index.html\"><img src=\"./assets/images/slick-logo.svg\" width=\"40\" alt=\"logo\" /></a><div class=\"menu-item\">Show all (" + reducerAlternative(blocksObject) + ")</div>";

  var menuItemHTML = function menuItemHTML(key) {
    return "<div class='menu-item " + (key === ACTIVE_ITEM ? 'active' : '') + "' data-filter=" + key + " href='#'>" + key + " (" + blocksObject[key] + ")</div>";
  };

  var generatorMenu = $('#generator-menu');
  /*-----------------------------------------------
  |   Populate Sortable and Menu Content and Push
  -----------------------------------------------*/

  TARGET_SORT_ARRAY.map(function (key) {
    menuContent += menuItemHTML(key);
    sortableContainerContent += sortableItemHTML(key);
  });
  dragableItems.html(sortableContainerContent);
  generatorMenu.html(menuContent);
  draggableAndSortable();
});
/*-----------------------------------------------
|   Export HTML
-----------------------------------------------*/

Utils.$document.ready(function () {
  var btnView = $('#btn-view');
  var btnCode = $('#btn-code');
  var btnExport = $('#btn-export');
  var btnCopy = $('#btn-copy');
  var btnDownload = $('#btn-download');
  var dropZone = $('#drop-zone');
  var browser = $('.browser');

  var copyToClipboard = function copyToClipboard(str) {
    var el = document.createElement('textarea');
    el.value = str;
    document.body.appendChild(el);
    el.select();
    document.execCommand('copy');
    document.body.removeChild(el);
  };

  var splittedSkeleton = buildingBlocks['skeleton'].split('</main>');

  var html = function html() {
    var listOfIds = [];
    $(dropZone.find('img')).each(function (index, value) {
      return listOfIds.push($(value).attr('src').split('blocks/')[1].split('.')[0]);
    });
    var section = '';

    for (var key in listOfIds) {
      section += buildingBlocks[listOfIds[key++]];
    }

    return {
      sections: section,
      html: "" + splittedSkeleton[0] + section + "</main>" + splittedSkeleton[1]
    };
  };

  btnExport.on('click', function () {
    $('#blocks-stock').html("\n      <pre>\n        <code class='language-html'>" + escapeHTML(html_beautify(html().html, {
      indent_size: 2,
      indent_with_tabs: false
    })) + "</code>\n      </pre>\n    ");
    Prism.highlightAll();
    btnView.removeClass('d-none');
    btnCode.addClass('d-none');
  });
  btnCode.on('click', function () {
    btnView.toggleClass('d-none');
    btnCode.toggleClass('d-none');
    $('#blocks-stock').html("\n      <pre>\n        <code class='language-html'>" + escapeHTML(html_beautify(html().html, {
      indent_size: 2,
      indent_with_tabs: false
    })) + "</code>\n      </pre>\n    ");
    Prism.highlightAll();
  });
  btnView.on('click', function () {
    btnView.toggleClass('d-none');
    btnCode.toggleClass('d-none');
    $('#blocks-stock').html("" + html_beautify(html().sections, {
      indent_size: 2,
      indent_with_tabs: false
    }));
  });
  /*-----------------------------------------------
  |   Handle Copy Button
  -----------------------------------------------*/
  // Deprecated Event Listener
  // browser.on('DOMSubtreeModified', '#drop-zone', () => {
  //   btnCopy.children('span.text').html('copy');
  //   btnCopy.removeAttr('disabled');
  // });
  // Alternative Approach

  var target = document.getElementById('drop-zone'); // Create an observer instance

  var observer = new MutationObserver(function (mutations) {
    mutations.forEach(function (mutation) {
      var newNodes = mutation.addedNodes; // DOM NodeList

      if (newNodes !== null) {
        // If there are new nodes added or changed
        btnCopy.children('span.text').html('copy');
        btnCopy.removeAttr('disabled');
      }
    });
  }); // Configuration of the observer:

  var config = {
    attributes: true,
    childList: true,
    characterData: true
  }; // Pass in the target node, as well as the observer options

  observer.observe(target, config);
  btnCopy.on('click', function () {
    btnCopy.children('span.text').html('copied to clipboard');
    btnCopy.children('svg').toggleClass('d-none');
    btnCopy.attr('disabled', true);
    $('#blocks-stock').select();
    copyToClipboard("" + html_beautify(html().html, {
      indent_size: 2,
      indent_with_tabs: false
    }));
  });
  btnDownload.on('click', function () {
    btnDownload.attr('href', "data:text/plain;charset=utf-8, " + encodeURIComponent(html_beautify(html().html, {
      indent_size: 2,
      indent_with_tabs: false
    })));
    btnDownload.attr('download', ($('#file-name').val() || 'untitled') + ".html");
  });
  /*-----------------------------------------------
  |   Destroy Item
  -----------------------------------------------*/

  browser.on('click', function (e) {
    var clickedDOM = $(e.target);

    if (clickedDOM.hasClass('remove') || clickedDOM.parents().hasClass('remove')) {
      clickedDOM.parents('.draggable-item').remove();
      var counter = browser.find('.draggable-item').length;
      counter || dropZone.addClass('browser-intro-text-wrapper');
    }
  });
});
/*-----------------------------------------------
|   Draggable and Sortable
-----------------------------------------------*/

var draggableAndSortable = function draggableAndSortable() {
  var dropZone = $('#drop-zone');
  var draggableItemsCollection = $('.draggable-item');
  $('#generator-menu').on('click', '.menu-item', function () {
    $('.menu-item').removeClass('active');
    $(this).toggleClass('active');
    var filter = this.dataset.filter || '*';
    var draggableItems = document.getElementById('dragable-items');
    var filteredItems = filter !== '*' && draggableItems.querySelectorAll("." + filter);
    var allItems = draggableItems.querySelectorAll('.draggable-item');

    if (filter !== '*') {
      Object.keys(allItems).map(function (el) {
        return allItems[el].classList.add('d-none');
      });
      Object.keys(filteredItems).map(function (el) {
        return filteredItems[el].classList.remove('d-none');
      });
    } else {
      Object.keys(allItems).map(function (el) {
        return allItems[el].classList.remove('d-none');
      });
    }
  });
  /*-----------------------------------------------
  |   Draggable
  -----------------------------------------------*/

  draggableItemsCollection.each(function (item, value) {
    $(value).draggable({
      cancel: "a.ui-icon",
      revert: true,
      helper: "clone",
      cursor: "move",
      revertDuration: 0,
      connectToSortable: '#drop-zone',
      start: function start(event, ui) {
        dropZone.removeClass('browser-intro-text-wrapper');
      },
      stop: function stop(event, ui) {
        $('.ui-draggable-dragging').removeClass('mb-3');
      }
    });
  });
  /*-----------------------------------------------
  |   Sortable
  -----------------------------------------------*/

  dropZone.sortable({
    accept: "#dragable-items .draggable-item",
    activeClass: "ui-state-highlight",
    placeholder: 'sort-placer',
    drop: function drop(event, ui) {
      // clone item to retain in original "list"
      var $item = ui.draggable.clone();
      $(this).addClass('has-drop').html($item);
    }
  });
};
/*-----------------------------------------------
|   Prism Colorization
-----------------------------------------------*/


var escape = document.createElement('textarea');

function escapeHTML(html) {
  escape.textContent = html;
  return escape.innerHTML;
}
/*-----------------------------------------------
|   Alert Window
-----------------------------------------------*/


Utils.$document.ready(function () {
  var warning = function warning() {
    if (window.location.href.includes('file://')) return "<h2 class='color-white mb-0'>Bummer! We need http/https protocol to run the system.</h2><a href=\"https://prium.github.io/slick/generator.html\" class=\"btn btn-white mt-6\">Please Use the online Generator</a>";
    if (Detector.isIE11 || Detector.isNewerIE || Detector.isOlderIE || Detector.isAncientIE) return "<h2 class='color-white mb-0'>Generator does not support Internet Explorer.</h2>";
    if (Detector.isMobile) return "<h2 class='color-white mb-0'>Generator isn't available in this device! Please try with your computer.</h2>";
    return "<h2 class='color-white mb-0'>Please try with larger screen.</h2>";
  };

  $('body').append("<div class='alert-window p-4 p-sm-6'>" + warning() + "</div>");

  var rem2px = function rem2px(rem) {
    return rem * window.getComputedStyle(document.body, null).getPropertyValue('font-size').split('px')[0];
  };

  var checkValidity = function checkValidity() {
    $('.nano-content').css({
      height: Utils.$window.height()
    });
    var alertWindow = $('.alert-window');
    var main = $('main');

    if (window.location.href.includes('file://') || Detector.isMobile || Detector.isIE11 || Detector.isNewerIE || Detector.isOlderIE || Detector.isAncientIE || Utils.$window.width() < rem2px(66)) {
      alertWindow.addClass('d-flex');
      alertWindow.removeClass('d-none');
      main.addClass('d-none');
    } else {
      alertWindow.addClass('d-none');
      alertWindow.removeClass('d-flex');
      main.removeClass('d-none');
    }
  };

  checkValidity();
  Utils.$window.on('resize', function () {
    checkValidity();
  });
});