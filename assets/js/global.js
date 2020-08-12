(function () {
  // Toggle navigation
  let toggle = document.getElementsByClassName("nav-toggle")[0];

  toggle.addEventListener("click", function () {
    toggle.classList.toggle("active");

    let mmw = document.getElementsByClassName("mobile-menu-wrapper")[0];
    if (mmw.style.display == "block") {
      mmw.style.display = "none";
    } else {
      mmw.style.display = "block";
    }
    mmw.classList.toggle("visible");

    let body = document.getElementsByTagName("body")[0];
    body.classList.toggle("mobile-menu-visible");
    body.classList.toggle("lock-scroll");
  });

  // Hide navigation on resize
  window.addEventListener("resize", function () {
    var winWidth = window.innerWidth;
    if (winWidth > 1000) {
      let body = document.getElementsByTagName("body")[0];
      body.classList.remove("mobile-menu-visible", "lock-scroll");

      let mmw = document.getElementsByClassName("mobile-menu-wrapper")[0];
      mmw.style.display = "none";
    }
  });
})(); // IIFE
