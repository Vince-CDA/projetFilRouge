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
/*-----------------------------------------------
|   Mon code JS custom
-----------------------------------------------*/
  $('.modal-header .close,.modal-bouton').on('click', function(){


    $(".modal").hide();


  });

  if($('.modal-body p').html().length){

    $(".modal").show();

  };

  let editor;
/* WYSYWYG */

ClassicEditor
  .create( document.querySelector( '#editor' ), {
    ckfinder: {
			uploadUrl: './js/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',
    },
    resizeOptions: [
      {
          name: 'imageResize:original',
          label: 'Original',
          value: null
      },
      {
          name: 'imageResize:50',
          label: '50%',
          value: '50'
      },
      {
          name: 'imageResize:75',
          label: '75%',
          value: '75'
      }
  ],
  heading: {
    options: [
        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
        {
            model: 'headingFancy',
            view: {
                name: 'h2',
                classes: 'fancy'
            },
            title: 'Heading 2 (fancy)',
            class: 'ck-heading_heading2_fancy',

            // It needs to be converted before the standard 'heading2'.
            converterPriority: 'high'
        }
    ]
},
  toolbar: [
    'heading',
    'alignment',
    'Styles','Format','Font','FontSize',
    '/',
    'Bold','Italic','Underline','StrikeThrough','-','Undo','Redo','-','Cut','Copy','Paste','Find','Replace','-','Outdent','Indent','-','Print',
    '/',
    'NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock',
    'Image','Table','-','Link','Flash','Smiley','TextColor','BGColor','Source',
    'imageStyle:alignLeft', 'imageStyle:alignCenter', 'imageStyle:alignRight',
    '|',
    'imageUpload',
    'imageStyle:full',
    'imageStyle:side',
    '|',
    'imageTextAlternative',
    'imageTextAlternative',
    'headings', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote',
],
  } )
  .then( e => editor = e)
	.catch( error => {
		console.error( error );
  } );
  

  
  $('#publier').on('click', function(){

    console.log('btn wysiwyg ready !');
    var test = editor.getData(); 
    var title = $('input[name=title]').val();
    var description = encodeURI(test)
    //methode Ajax
    var request = $.ajax({
        url: "./libs/methode_ajax.php",
        method: "POST",
        data: { informations : 1, title:title, description : description },
        dataType: "html" //ou JSON
    });
    //reussite reponse 200 - Inclu le fait que vous avez pas les permissions requisent
    request.done(function( msg ) {
        //console.log(msg);
        //afichage de la modal ave
        $('.modal-body p').html(msg);

        $('')

        $(".modal").show();
        //$( "#log" ).html( msg );
    });

    //erreur 404 ou 500 - le serveur ne repond pas, erreur PHP ?
    request.fail(function( jqXHR, textStatus ) {
        console.log( "Request failed: " + textStatus );
    });



});