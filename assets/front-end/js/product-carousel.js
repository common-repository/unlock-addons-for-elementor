/**
 * @param $scope The Widget wrapper element as a jQuery element
 * @param $ The jQuery alias
 */

$(window).on("elementor/frontend/init", function () {
  elementorFrontend.hooks.addAction(
    "frontend/element_ready/unlockafe-product-carousel.default",
    function ($scope) {
      /* Team Slide*/
      var productCount =
        $scope.find(".unlockafe-product-slide-wrap").data("product-count") || 4;

      var swiper = new Swiper(".unlockafe-product-slide", {
        spaceBetween: 24,
        loop: false,
        breakpoints: {
          320: {
            slidesPerView: Math.min(productCount, 1),
          },
          480: {
            slidesPerView: Math.min(productCount, 1),
          },
          768: {
            slidesPerView: Math.min(productCount, 2),
          },
          992: {
            slidesPerView: Math.min(productCount, 3),
          },
          1200: {
            slidesPerView: Math.min(productCount, 4),
          },
        },
        navigation: {
          nextEl: ".unlockafe-product-button-next",
          prevEl: ".unlockafe-product-button-prev",
        },
        pagination: {
          el: ".unlockafe-pagination",
          clickable: true,
        },
      }); /* End Team Slide*/
      /* Team Slide*/
      var teamSlider = new Swiper(".unlockafe-team-slide", {
        spaceBetween: 24,
        loop: false,
        breakpoints: {
          320: {
            slidesPerView: Math.min(productCount, 1),
          },
          480: {
            slidesPerView: Math.min(productCount, 1),
          },
          768: {
            slidesPerView: Math.min(productCount, 2),
          },
          992: {
            slidesPerView: Math.min(productCount, 3),
          },
          1200: {
            slidesPerView: Math.min(productCount, 4),
          },
        },
        navigation: {
          nextEl: ".unlockafe-team-button-next",
          prevEl: ".unlockafe-team-button-prev",
        },
        pagination: {
          el: ".unlockafe-pagination",
          clickable: true,
        },
      }); /* End Team Slide*/
    }
  );
});
