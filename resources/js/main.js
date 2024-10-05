// jquery
import $ from 'jquery';

// magnific popup
import 'magnific-popup';
import 'magnific-popup/dist/magnific-popup.css';

// swiper slider
import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';
import 'swiper/swiper-bundle.css';


(function() {

  'use strict';

  // preloader
  $(window).on('load', function() {
    $('.loader').fadeOut('slow');
  });

  // smooth scroll
  $("a").on("click", function(event) {

      if (this.hash !== "") {
          event.preventDefault();

          var hash = this.hash;

          $("html, body").animate({

              scrollTop: $(hash).offset().top - 50

          }, 850);

      }

  });


  // magnific popup
  $('.gallery').each(function() { // the containers for all your galleries
      $(this).magnificPopup({
          delegate: '.popup-image', // the selector for portfolio item
          type: 'image',
          gallery: {
              enabled: true
          },
      });
  });

  // swiper slider
  $(document).ready(function () {
    var swiper = new Swiper(".mySwiper", {
      modules: [Navigation, Pagination],
      slidesPerView: 1,
      spaceBetween: 30,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      navigation: {
        nextEl: ".swiper-button-next.next-slide",
        prevEl: ".swiper-button-prev.prev-slide"
      },
      breakpoints: {
        0: {
          slidesPerView: 1,
        },
        768: {
          slidesPerView: 1,
        },
        780: {
          slidesPerView: 1,
        }
      }
    });

  });

  // hide navbar on click
  $('.navbar-nav>li>a').on('click', function(){
      $('.navbar-collapse').collapse('hide');
  });

  // navbar on scroll
  $(window).on("scroll", function() {

      var onScroll = $(this).scrollTop();

      if( onScroll > 50) {
          $(".navbar").addClass("navbar-fixed");
      }
      else {
          $(".navbar").removeClass("navbar-fixed");
      }

  });

})();