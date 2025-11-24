(function ($) {
  "use strict";

  var initPreloader = function () {
    $(document).ready(function () {
      var Body = $('body');
      Body.addClass('preloader-site');
    });
    $(window).on('load', function () {
      $('.preloader').fadeOut();
      $('body').removeClass('preloader-site');
    });
  }

  // init Chocolat light box
  var initChocolat = function () {
    Chocolat(document.querySelectorAll('.image-link'), {
      imageSize: 'contain',
      loop: true,
    })
  }

  // init Statistics Counter
  var initStatisticsCounter = function () {
    const statisticNumbers = document.querySelectorAll('.statistic-number');
    
    const animateNumber = (element, target, duration = 2000) => {
      const start = 0;
      const increment = target / (duration / 16);
      let current = start;
      
      const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
          current = target;
          clearInterval(timer);
        }
        
        // Formatta il numero per mantenere K, M, etc.
        const originalText = element.getAttribute('data-original');
        if (originalText.includes('K')) {
          element.textContent = Math.floor(current) + 'K';
        } else if (originalText.includes('M')) {
          element.textContent = Math.floor(current) + 'M';
        } else {
          element.textContent = Math.floor(current);
        }
      }, 16);
    };

    // Observer per attivare l'animazione quando la sezione è visibile
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const element = entry.target;
          const target = parseInt(element.getAttribute('data-target'));
          animateNumber(element, target);
          observer.unobserve(element);
        }
      });
    }, { threshold: 0.5 });

    statisticNumbers.forEach(number => {
      const originalText = number.textContent;
      number.setAttribute('data-original', originalText);
      number.setAttribute('data-target', originalText.replace(/[^\d]/g, ''));
      number.textContent = '0';
      observer.observe(number);
    });
  }

  $(document).ready(function () {
    // Isotope Initialization
    var $container = $('.isotope-container').isotope({
      itemSelector: '.item',
      layoutMode: 'masonry',
    });

    // Filter items on button click
    $('.filter-button').click(function () {
      var filterValue = $(this).attr('data-filter');
      if (filterValue === '*') {
        $container.isotope({ filter: '*' });
      } else {
        $container.isotope({ filter: filterValue });
      }
      $('.filter-button').removeClass('active');
      $(this).addClass('active');
    });

    // Video Modal
    var $videoSrc;
    $('.play-btn').click(function () {
      $videoSrc = $(this).data("src");
    });

    $('#myModal').on('shown.bs.modal', function (e) {
      $("#video").attr('src', $videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0");
    })

    $('#myModal').on('hide.bs.modal', function (e) {
      $("#video").attr('src', $videoSrc);
    })

    // Swiper Initialization
    var sliderSwiper = new Swiper(".slider", {
      effect: "fade",
      fadeEffect: {
        crossFade: true
      },
      autoplay: {
        delay: 5000,
        disableOnInteraction: false,
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      loop: true,
      speed: 1000,
      on: {
        slideChange: function () {
          // Add subtle animation to content
          const activeSlide = this.slides[this.activeIndex];
          const content = activeSlide.querySelector('.row');
          if (content) {
            content.style.opacity = '0';
            content.style.transform = 'translateY(30px)';
            setTimeout(() => {
              content.style.transition = 'all 0.6s ease';
              content.style.opacity = '1';
              content.style.transform = 'translateY(0)';
            }, 100);
          }
          
          // Add subtle animation to fixed booking form
          const bookingForm = document.querySelector('.fixed-booking-form');
          if (bookingForm) {
            bookingForm.style.transform = 'translateY(-50%) scale(0.98)';
            setTimeout(() => {
              bookingForm.style.transition = 'all 0.4s ease';
              bookingForm.style.transform = 'translateY(-50%) scale(1)';
            }, 200);
          }
        }
      }
    });

    var roomSwiper = new Swiper(".room-swiper", {
      slidesPerView: 3,
      spaceBetween: 20,
      pagination: {
        el: ".room-pagination",
        clickable: true,
      },
      breakpoints: {
        0: {
          slidesPerView: 1,
        },
        1024: {
          slidesPerView: 2,
        },
        1280: {
          slidesPerView: 3,
        },
      },
    });

    // Gallery Swiper
    if (document.querySelector(".gallery-swiper")) {
      // Inizializza prima le thumbnail
      var galleryThumbnailsSwiper = null;
      if (document.querySelector(".gallery-thumbnails-swiper")) {
        galleryThumbnailsSwiper = new Swiper(".gallery-thumbnails-swiper", {
          spaceBetween: 10,
          slidesPerView: 'auto',
          freeMode: true,
          watchSlidesProgress: true,
          breakpoints: {
            0: {
              slidesPerView: 3,
            },
            576: {
              slidesPerView: 4,
            },
            768: {
              slidesPerView: 5,
            },
            992: {
              slidesPerView: 6,
            },
          },
        });
      }
      
      // Inizializza la gallery principale con collegamento alle thumbnail
      var gallerySwiper = new Swiper(".gallery-swiper", {
        effect: "slide",
        slidesPerView: 1,
        spaceBetween: 30,
        loop: false, // Disabilitato per permettere la sincronizzazione corretta con le thumbnail
        autoplay: {
          delay: 3000,
          disableOnInteraction: false,
        },
        navigation: {
          nextEl: ".gallery-button-next",
          prevEl: ".gallery-button-prev",
        },
        thumbs: galleryThumbnailsSwiper ? {
          swiper: galleryThumbnailsSwiper,
        } : undefined,
      });
      
      // Aggiungi event listener per i click sulle thumbnail (fallback se thumbs non funziona)
      if (galleryThumbnailsSwiper) {
        const thumbnailSlides = document.querySelectorAll('.gallery-thumbnail-wrapper');
        thumbnailSlides.forEach((thumbnail, index) => {
          thumbnail.style.cursor = 'pointer';
          thumbnail.addEventListener('click', function(e) {
            e.preventDefault();
            gallerySwiper.slideTo(index);
            // Aggiorna anche la thumbnail attiva
            galleryThumbnailsSwiper.slideTo(index);
          });
        });
      }
      
      console.log("Gallery Swiper initialized");
    }

    var thumbSlider = new Swiper(".product-thumbnail-slider", {
      autoplay: true,
      loop: true,
      spaceBetween: 8,
      slidesPerView: 4,
      freeMode: true,
      watchSlidesProgress: true,
    });

    var largeSlider = new Swiper(".product-large-slider", {
      autoplay: true,
      loop: true,
      spaceBetween: 10,
      effect: 'fade',
      thumbs: {
        swiper: thumbSlider,
      },
    });

    // Preloader
    initPreloader();

    // Chocolat
    initChocolat();

    // Statistics Counter
    initStatisticsCounter();

    // Animate on Scroll
    AOS.init({
      duration: 1000,
      once: true,
    });

    // DateTimePicker - Disabled for native HTML5 date inputs
    // new DateTimePickerComponent.DatePicker('checkin-date');
    // new DateTimePickerComponent.DatePicker('checkout-date');
  });
})(jQuery);
