/**
 * @param $scope The Widget wrapper element as a jQuery element
 * @param $ The jQuery alias
 */

$(window).on("elementor/frontend/init", function () {
  elementorFrontend.hooks.addAction(
    "frontend/element_ready/unlockafe-product-grid.default",
    function ($scope) {
      // pricing table tabs

      /* Product gallery-item activation Start */
      document
        .querySelectorAll(".product-thumbnail-gallery .gallery-item")
        .forEach((item) => {
          item.addEventListener("mouseover", () => {
            item.classList.add("active");
          });

          item.addEventListener("mouseout", () => {
            item.classList.remove("active");
          });
        });

      /* Product gallery-item activation End */

      /* Product gallery-item Dot & activation start */

      const products = document.querySelectorAll(".product");

      if (products) {
        products.forEach((product) => {
          const galleryItems = product.querySelectorAll(".gallery-item");
          const dotsContainer = product.querySelector(".hover-gallery-dots");

          if (dotsContainer && galleryItems?.length) {
            // Create dots dynamically using template literals and insertAdjacentHTML
            galleryItems.forEach((item, index) => {
              const dotHTML = `<span class="dot ${
                index === 0 ? "active" : ""
              }"></span>`;
              dotsContainer.insertAdjacentHTML("beforeend", dotHTML);

              // Add hover event to each gallery item
              item.addEventListener("mouseenter", function () {
                // Remove 'active' class from all dots
                dotsContainer
                  .querySelectorAll(".dot")
                  .forEach((dot) => dot.classList.remove("active"));

                // Add 'active' class to the corresponding dot
                dotsContainer
                  .querySelectorAll(".dot")
                  [index].classList.add("active");
              });

              // Add mouse leave event to reset to the first dot
              item.addEventListener("mouseleave", function () {
                // Remove 'active' class from all dots
                dotsContainer
                  .querySelectorAll(".dot")
                  .forEach((dot) => dot.classList.remove("active"));

                // Re-add 'active' class to the first dot
                dotsContainer
                  .querySelectorAll(".dot")[0]
                  .classList.add("active");
              });
            });
          }
        });
      }
      // Product gallery-item Dot & activation end

      // added_margin on product-content-fade Start
      if (products.length > 0) {
        products.forEach((product) => {
          const footerDetails = product.querySelector(
            ".product-footer-details"
          );
          const contentFade = product.querySelector(".product-content-fade");

          if (footerDetails && contentFade) {
            const footerDetailsHeight = footerDetails.offsetHeight;

            product.addEventListener("mouseover", () => {
              contentFade.style.marginBottom = `-${footerDetailsHeight + 30}px`;
            });

            product.addEventListener("mouseout", () => {
              contentFade.style.marginBottom = `0`;
            });
          }
        });
      }
      // added_margin on product-content-fade end

      // added_to_cart toggle active Start
      const addToCartLinks = document.querySelectorAll(".add_to_cart_link");

      if (addToCartLinks) {
        addToCartLinks.forEach((addToCartLink) => {
          addToCartLink.addEventListener("click", function (event) {
            event.preventDefault();

            const productContainer = addToCartLink.closest(
              ".product-cart-buttons"
            );
            const addedToCartLink =
              productContainer.querySelector(".added_to_cart");

            if (
              addedToCartLink &&
              addedToCartLink.classList.contains("hidden")
            ) {
              addToCartLink.classList.add("loading");

              setTimeout(() => {
                addedToCartLink.classList.remove("hidden");
                addToCartLink.classList.remove("loading");
              }, 1000);
            }
          });
        });
      }
    }
  );
});

jQuery(document).ready(function ($) {
  $(".add_to_cart_button").on("click", function (e) {
    e.preventDefault();
    var $this = $(this);
    var $productCartButtons = $this.closest(".product-cart-buttons");
    var $addedToCartButton = $productCartButtons.find(".added_to_cart");
    setTimeout(function () {
      $this.fadeOut(300, function () {
        $addedToCartButton.removeClass("hidden").fadeIn(300);
      });
    }, 500);
  });
  $(".added_to_cart").on("click", function () {
    window.location.href = $(this).attr("href");
  });
});
