///////////////////////// Global variables /////////////////////////////
var date = new Date();
var month = date.getMonth();
var day = date.getDate();
var hour = date.getHours();
var lang = document.getElementById("var-in-js").getAttribute("lang");
var imag = '';



/////////////////////////// Switch flag //////////////////////////////////
function img() {
  var image = document.getElementById("change-lang");
  image.classList.toggle('lang-ru');
  image.classList.toggle('lang-en');
  if (lang == "ru") {
      document.location.href='index.php?lang=en';
      $('.cb').addClass('cb-en');
      $('.cb').removeClass('cb-ru');
  } else {
      document.location.href='index.php?lang=ru';
      $('.cb').removeClass('cb-en');
      $('.cb').addClass('cb-ru');
  }
}


  
//////////// Change image at New Year whether to change theme////////////
function ny() {
  setInterval(() => {
    setTimeout(function() {
        document.getElementById('presentation').style.backgroundImage = 'url('+ imag +')';
    }, 0);
    setTimeout(function() {
        document.getElementById('presentation').style.backgroundImage = 'url(img/confetti-2.gif)';
    }, 3000);
  }, 6000);
}
///////////////////////////// Presentation at New Year ////////////////////
function change_img_ny() {
  if (lang == "ru") {
    if (month == 11) {
        if (day >= 20) {
            $('#presentation').addClass('presentation');
            $('.content-item-none').addClass('content-item');
            $('.content-item').removeClass('content-item-none');
            if (hour>=20 || hour<8) {
                imag = 'img/123-12.png';
            }
            else {
                imag = 'img/123-8.jpeg';
            }
            ny();
        }
    }
    if (month == 0) {
        if (day <= 10) {
            $('#presentation').addClass('presentation');
            $('.content-item-none').addClass('content-item');
            $('.content-item').removeClass('content-item-none');
            if (hour>=20 || hour<8) {
                imag = 'img/123-12.png';
            }
            else {
                imag = 'img/123-8.jpeg';
            }
            ny();
        }
    }
  };
};



$(document).ready(function() {

  ///////////////////////// menu for phone /////////////////////////

    $('.open-button').click(function() 
    {
        if(!$('.button').hasClass('open-done'))
        {
            //$('nav').addClass('menu');
            $('.menu-button').addClass('open-done');
            $('.menu-block-1').addClass('open-done');
            setTimeout(function(){$('.menu-block-2').addClass('open-done')}, 100);
            setTimeout(function(){$('nav').addClass('menu')}, 400);
            setTimeout(function(){$('.menu-link-1').addClass('open-done')}, 600);
            setTimeout(function(){$('.menu-link-2').addClass('open-done')}, 700);
            setTimeout(function(){$('.menu-link-3').addClass('open-done')}, 800);
        }
        else
        {
            //$('nav').removeClass('menu');
            $('.menu-button').removeClass('open-done');
            $('.menu-link-1').removeClass('open-done');
            setTimeout(function(){$('.menu-link-2').removeClass('open-done')}, 100);
            setTimeout(function(){$('.menu-link-3').removeClass('open-done')}, 200);
            setTimeout(function(){$('nav').removeClass('menu')}, 400);
            setTimeout(function(){$('.menu-block-1').removeClass('open-done')}, 700);
            setTimeout(function(){$('.menu-block-2').removeClass('open-done')}, 500);
        }
    }); 



  
});



///////////The theme of the website(depending on the time) ////////////////
$(window).on('load', function() {
  if (hour>=20 || hour<8) {
      document.getElementById("style").href="css/night.css";
      $("#theme").addClass("light");
      $("#theme-2").addClass("light");
  } else {
      $("#theme").addClass("black");
      $("#theme-2").addClass("black");
  }
});
///////////The theme of the website(when the button is clicked) ////////////////
function theme() {
  var themes = document.getElementById("theme");
  var themesm = document.getElementById("theme-2");
  themes.classList.toggle('light');
  themes.classList.toggle('black');
  themesm.classList.toggle("light");
  themesm.classList.toggle("black");
  if (themes.classList.contains('light') == true) {
      document.getElementById("style").href="css/night.css";
      imag = 'img/123-12.png';
  } else {
      document.getElementById("style").href="css/day.css";
      imag = 'img/123-8.jpeg';
  }
  change_img_ny();
}   



/////////////////////////// writing on a pencil ////////////////////////
$(window).on('load', function(){
  if (lang == "ru") {
      document.getElementById("langstyle").href="css/index_ru.css";
  };
  $('.cb').addClass('cb-' + lang);
});



// Progress Scroll
var ProgressScroll = function () {
    var s = void 0;
  
    return {
      settings: function settings() {
        return {
          top: $('.progress-top'),
          right: $('.progress-right'),
          bottom: $('.progress-bottom'),
          left: $('.progress-left'),
          windowHeight: $(window).height(),
          windowWidth: $(window).width(),
          scrollHeight: $(document).height() - $(window).height(),
          progressTotal: $(window).height() * 2 + $(window).width() * 2,
          scrollPosition: $(document).scrollTop()
        };
      },
      init: function init() {
        s = this.settings();
        this.bindEvents();
      },
      bindEvents: function bindEvents() {
        $(window).on('scroll', this.onScroll);
        $(window).on('resize', this.onResize);
  
        this.progress();
      },
      onScroll: function onScroll() {
        s.scrollPosition = $(document).scrollTop();
  
        ProgressScroll.requestTick();
      },
      onResize: function onResize() {
        s.windowHeight = $(window).height();
        s.windowWidth = $(window).width();
        s.scrollHeight = $(document).height() - s.windowHeight;
        s.progressTotal = s.windowHeight * 2 + s.windowWidth * 2;
  
        ProgressScroll.requestTick();
      },
      requestTick: function requestTick() {
        requestAnimationFrame(this.progress);
      },
      progress: function progress() {
        var percentage = s.scrollPosition / s.scrollHeight;
        var width = s.windowWidth / s.progressTotal;
        var height = s.windowHeight / s.progressTotal;
  
        s.top.css('width', percentage / width * 100 + '%');
        s.right.css('height', (percentage - width) / height * 100 + '%');
        s.bottom.css('width', (percentage - width - height) / width * 100 + '%');
        s.left.css('height', (percentage - width - height - width) / height * 100 + '%');
      }
    };
  }();
  
  // Init
  $(function () {
    ProgressScroll.init();
  });