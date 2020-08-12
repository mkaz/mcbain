/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and
 * then make any necessary changes to the page using jQuery.
 */

(function ($) {
  // Site Name
  wp.customize("blogname", function (value) {
    value.bind(function (newval) {
      $(".site-name").text(newval);
    });
  });

  // Header background color
  wp.customize("mcbain_accent_color", function (value) {
    value.bind(function (newval) {
      var oldColor = $(".site-header").css("background-color");
      $(".site-header").css("background-color", newval);
      $(".mobile-menu-wrapper").css("background-color", newval);
      $(".mobile-search.active").css("background-color", newval);
    });
  });

  // Dark sidebar text
  wp.customize("mcbain_dark_sidebar_text", function (value) {
    value.bind(function (newval) {
      if (newval == true) {
        $("body").addClass("dark");
      } else {
        $("body").removeClass("dark");
      }
    });
  });

  // Hide social
  wp.customize("mcbain_hide_social", function (value) {
    value.bind(function (newval) {
      if (newval == true) {
        $("body").addClass("hide-social");
      } else {
        $("body").removeClass("hide-social");
      }
    });
  });

  // Capitalized post preview dates
  wp.customize("mcbain_preview_date_lowercase", function (value) {
    value.bind(function (newval) {
      if (newval == true) {
        $(".post-preview time").css("text-transform", "lowercase");
      } else {
        $(".post-preview time").css("text-transform", "capitalize");
      }
    });
  });
})(jQuery);
