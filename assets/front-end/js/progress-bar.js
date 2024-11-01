/**
 * @param $scope The Widget wrapper element as a jQuery element
 * @param $ The jQuery alias
 */

$(window).on("elementor/frontend/init", function () {
  elementorFrontend.hooks.addAction(
    "frontend/element_ready/unlockafe-progress-bar.default",
    function ($scope) {
      // progress bar
      const charts = document.querySelectorAll(".unlockafe-pie-chart");
      const observer = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              const chart = entry.target;
              const percent = chart.getAttribute("data-percent");
              const foregroundCircle = chart.querySelector(".foreground");
              const circumference = 2 * Math.PI * 14;
              const offset = circumference - (percent / 100) * circumference;

              foregroundCircle.style.strokeDashoffset = offset;

              observer.unobserve(chart);
            }
          });
        },
        { threshold: 0.5 }
      );

      charts.forEach((chart) => {
        observer.observe(chart);
      });
    }
  );
});
