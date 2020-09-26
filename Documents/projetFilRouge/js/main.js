
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
if($('#editor').length) {
Utils.$document.ready(function () {

  ClassicEditor

  .create( document.querySelector( '#editor' ), {
    ckfinder: {
			uploadUrl: './js/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',
    },
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
    'alignment:left', 'alignment:right', 'alignment:center', 'alignment:justify', 'alignment',,
    'Styles','Format','Font','FontSize',
    'Bold','Italic','Underline','StrikeThrough','-','Undo','Redo','-','Cut','Copy','Paste','Find','Replace','-','Outdent','Indent','-','Print',
    '/',
    'NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock',
    'Image','Table','-','Link','Flash','Smiley','TextColor','BGColor','Source',
    'imageStyle:alignLeft', 'imageStyle:alignCenter', 'imageStyle:alignRight',
    '|',
    'imageUpload',
    '|',
    'imageTextAlternative',
    'imageTextAlternative',
    'headings', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote',
],
image: {
  // Configure the available styles.
  styles: [
      'alignLeft', 'alignCenter', 'alignRight'
  ],

  // Configure the available image resize options.
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

  // You need to configure the image toolbar, too, so it shows the new style
  // buttons as well as the resize buttons.

}
  } )
  .then( e => editor = e)
	.catch( error => {
		console.error( error );
  } );
}
)};

  $('#publier').on('click', function(){

    console.log('btn wysiwyg ready !');
    var test = editor.getData(); 
    var description = test;
    var title = $('input[name=title]').val();
    var publier = $('input[name=diffusion]').is(':checked') === true ? '1' : '0'; 
    //methode Ajax
    var request = $.ajax({
        url: "./libs/methode_ajax.php",
        method: "POST",
        data: { informations : 1, title:title, description : description, fichier : $('figure img').attr('src'), publier : publier},
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
      window.setTimeout("location=('./page-news')",2000);

    });

    //erreur 404 ou 500 - le serveur ne repond pas, erreur PHP ?
    request.fail(function( jqXHR, textStatus ) {
        console.log( "Request failed: " + textStatus );
    });



});

$('#editer').on('click', function(){

  console.log('btn wysiwyg ready !');
  var test = editor.getData(); 
  var description = test;
  var title = $('input[name=title]').val();
  var id = $('input[name=id]').val();
  var publier = $('input[name=diffusion]').is(':checked') === true ? '1' : '0'; 
  //methode Ajax
  var request = $.ajax({
      url: "./libs/methode_ajax.php",
      method: "POST",
      data: { informations : 2, title:title, description : description, id : id, fichier : $('figure img').attr('src'), publier : publier},
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
      window.setTimeout("location=('./page-newscontent-'+$('input[name=id]').val())",2000);

  });

  //erreur 404 ou 500 - le serveur ne repond pas, erreur PHP ?
  request.fail(function( jqXHR, textStatus ) {
      console.log( "Request failed: " + textStatus );
  });



});

$('#ajoutactivite').on('click', function(){

  console.log('btn wysiwyg ready !');
  var test = editor.getData(); 
  var intituleactivite = $('input[name=IntituleActivite]').val();
  var publier = $('input[name=diffusion]').is(':checked') === true ? '1' : '0'; 
  var description = test;
  var ddebut = $('input[name=DDebut]').val();
  var dfin = $('input[name=DFin]').val();
  var dlimite = $('input[name=DLimite]').val();
  var tarifadherent = $('input[name=TarifAdherent]').val();
  var tarifinvite = $('input[name=TarifInvite]').val();
  var idadherent = $('input[name=IdAdherent]').val();
  var idtype = $( "#IdType" ).val();
  
  //methode Ajax
  var request = $.ajax({
      url: "./libs/methode_ajax.php",
      method: "POST",
      data: { 
              informations : 3,
              intituleactivite : intituleactivite,
              ddebut : ddebut,
              dfin : dfin,
              description : description,
              tarifadherent : tarifadherent,
              tarifinvite : tarifinvite,
              dlimite : dlimite,
              idadherent : idadherent,
              idtype : idtype,
              fichier : $('figure img').attr('src'),
              publier : publier
            },
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
      window.setTimeout("location=('./page-activites')",2000);

  });

  //erreur 404 ou 500 - le serveur ne repond pas, erreur PHP ?
  request.fail(function( jqXHR, textStatus ) {
      console.log( "Request failed: " + textStatus );
  });



});

$('#updateactivite').on('click', function(){

  console.log('btn wysiwyg ready !');
  var test = editor.getData(); 
  var intituleactivite = $('input[name=IntituleActivite]').val();
  var publier = $('input[name=diffusion]').is(':checked') === true ? '1' : '0'; 
  var description = test;
  var ddebut = $('input[name=DDebut]').val();
  var dfin = $('input[name=DFin]').val();
  var dlimite = $('input[name=DLimite]').val();
  var tarifadherent = $('input[name=TarifAdherent]').val();
  var tarifinvite = $('input[name=TarifInvite]').val();
  var idadherent = $('input[name=IdAdherent]').val();
  var id = $('input[name=id]').val();
  var idtype = $( "#IdType" ).val();
  
  //methode Ajax
  var request = $.ajax({
      url: "./libs/methode_ajax.php",
      method: "POST",
      data: { 
              informations : 4,
              intituleactivite : intituleactivite,
              ddebut : ddebut,
              dfin : dfin,
              description : description,
              tarifadherent : tarifadherent,
              tarifinvite : tarifinvite,
              dlimite : dlimite,
              idadherent : idadherent,
              idtype : idtype,
              fichier : $('figure img').attr('src'),
              publier : publier,
              id : id
            },
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
      window.setTimeout("location=('./page-activitecontent-'+$('input[name=id]').val());",2000);

  });

  //erreur 404 ou 500 - le serveur ne repond pas, erreur PHP ?
  request.fail(function( jqXHR, textStatus ) {
      console.log( "Request failed: " + textStatus );
  });



});


$("[data-fancybox]").fancybox();

// On initialise la latitude et la longitude de Paris (centre de la carte)
var lat = 44.10018;
var lon = 3.05301;
var macarte = null;

if($("#map").length){
// Fonction d'initialisation qui s'exécute lorsque le DOM est chargé
initMap(lat, lon, macarte); 

}

// Fonction d'initialisation de la carte
function initMap(lat, lon, macarte) {
  // Créer l'objet "macarte" et l'insèrer dans l'élément HTML qui a l'ID "map"
  macarte = L.map('map').setView([lat, lon], 11);
  // Leaflet ne récupère pas les cartes (tiles) sur un serveur par défaut. Nous devons lui préciser où nous souhaitons les récupérer. Ici, openstreetmap.fr
  L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
      // Il est toujours bien de laisser le lien vers la source des données
      attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
      minZoom: 12,
      maxZoom: 20,
  }).addTo(macarte);
var marker = L.marker([lat, lon]).addTo(macarte);



}
var onloadCallback = function() {
};

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#blah').attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}

$("#imgInp").change(function() {
  readURL(this);
});

var err = '';
//Methode Ajax version JSON
$('#modalbouton').on('click', function() {

  if(document.getElementById("changerpassword").checkValidity()) {
    var data = new FormData(document.getElementById("changerpassword"));

    $.ajax({
      url: "./libs/methode_ajax.php",
      data: {action:"changerpassword", data: JSON.stringify(Object.fromEntries(data))},
      method: "POST",
      dataType: "json"
    }).then( function(data) {

      if(data.deco == '1') {

        decoreco();
      }
      $('.modal .modal-body p').remove();
      $('.modal .modal-body').html(data.data);
      $('.modal .btn').html(data.btn);
      $('.modal-titre').remove();
      $('.modal-header').html('<h5 class="modal-title">'+data.titre+'</h5>');
      $(".modal").show();

    }).catch(err => console.error(err))
    $('.modal .modal-body p').remove();
      $('.modal .modal-body').html('<p>Une erreur est survenue :'+err+'</p>');
      $('.modal .btn').html(data.btn);
      $('.modal-titre').remove();
      $('.modal-header').html('<h5 class="modal-title">'+data.titre+'</h5>');
      $(".modal").show();
    return false;
  }

})
var MaFenetre;
function decoreco () {
 MaFenetre = window.open("./index.php?deconnexion=1", "width=10", "height=10");

 window.setTimeout("MaFenetre.close()",200);

 window.setTimeout("location=('./page-connexion')",300);
}