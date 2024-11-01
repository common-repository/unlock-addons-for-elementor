/**
 * @param $scope The Widget wrapper element as a jQuery element
 * @param $ The jQuery alias
 */

$(window).on("elementor/frontend/init", function () {
  elementorFrontend.hooks.addAction(
    "frontend/element_ready/unlockafe-blog-grid.default",
    function ($scope) {
      // pricing table tabs
    }
  );
});
