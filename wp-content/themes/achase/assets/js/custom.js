jQuery(window).resize(function () {
  jQuery(".properties-slider .matchHeight").matchHeight({
    property: "height",
  });
});

// Document Ready
jQuery(document).ready(function () {
  jQuery(".news_contect_banner .skip-banner").click(function () {
    var scroll_value = jQuery(this)
      .parents(".news_contect_banner")
      .outerHeight();
    scroll_value = scroll_value + 20;
    jQuery("html, body").animate({ scrollTop: scroll_value + "px" }, 0);
  });
  jQuery(".our_services_banner .skip-banner").click(function () {
    var scroll_value = jQuery(this)
      .parents(".our_services_banner")
      .outerHeight();
    scroll_value = scroll_value + 20;
    jQuery("html, body").animate({ scrollTop: scroll_value + "px" }, 0);
  });
  jQuery(".propertie-banner .skip-banner").click(function () {
    var scroll_value = jQuery(this).parents(".propertie-banner").outerHeight();
    scroll_value = scroll_value + 20;
    jQuery("html, body").animate({ scrollTop: scroll_value + "px" }, 0);
  });
  jQuery(".home-banner .skip-banner").click(function () {
    var scroll_value = jQuery(this).parents(".home-banner").outerHeight();
    scroll_value = scroll_value + 20;
    jQuery("html, body").animate({ scrollTop: scroll_value + "px" }, 0);
  });
  jQuery(".availability_description").hide();
  jQuery("#overview").addClass("active");
  jQuery("#availability").click(function (e) {
    jQuery(".overview_description").fadeOut();
    jQuery(".availability_description").fadeIn();
    jQuery(this).addClass("active");
    jQuery("#overview").removeClass("active");
    jQuery("#brochures").removeClass("active");
    jQuery(".share-icon").removeClass("active");
  });
  jQuery("#overview").click(function (e) {
    jQuery(".availability_description").fadeOut();
    jQuery(".overview_description").fadeIn();
    jQuery(this).addClass("active");
    jQuery("#availability").removeClass("active");
    jQuery("#brochures").removeClass("active");
    jQuery(".share-icon").removeClass("active");
  });
  jQuery("#brochures").click(function (e) {
    jQuery(this).addClass("active");
    jQuery("#availability").removeClass("active");
    jQuery("#overview").removeClass("active");
    jQuery(".share-icon").removeClass("active");
    jQuery(".availability_description").fadeOut();
    jQuery(".overview_description").fadeIn();
  });
  jQuery(".share-icon").click(function (e) {
    jQuery(this).addClass("active");
    jQuery("#availability").removeClass("active");
    jQuery("#overview").removeClass("active");
    jQuery("#brochures").removeClass("active");
    jQuery(".availability_description").fadeOut();
    jQuery(".overview_description").fadeIn();
  });
  eqheight();
  jQuery(".search-input").keypress(function (e) {
    var key = e.which;
    if (key == 13) {
      jQuery(".search-btn").click();
      return false;
    }
  });

  jQuery(".floor-btn").click(function (e) {
    if (jQuery(this).next(".floorplan-view").is(":visible")) {
      jQuery(".floorplan-view").slideUp();
      e.stopPropagation();
    } else {
      jQuery(".floorplan-view").slideDown();
      e.stopPropagation();
    }
  });
  jQuery("body").click(function () {
    jQuery(".floorplan-view").slideUp();
  });
  //if cookie hasn't been set...
  if (document.cookie.indexOf("ModalShown=true") < 0) {
    jQuery("#cookie_bar").modal("show");
    //Modal has been shown, now set a cookie so it never comes back
    jQuery("#cookie_bar .cookie-btn").click(function () {
      jQuery("#cookie_bar").modal("hide");
      document.cookie =
        "ModalShown=true; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/";
    });
  }
  jQuery("#cookie_bar .cookie-btn").click(function () {
    jQuery("#cookie_bar").modal("hide");
    document.cookie =
      "ModalShown=true; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/";
  });

  if (jQuery("body").hasClass("logged-in")) {
    jQuery("li.beforelogin").hide();
    jQuery("li.afterlogin").show();
  } else {
    jQuery("li.afterlogin").hide();
    jQuery("li.beforelogin").show();
  }

  if (jQuery(".error-banner").length) {
    var errorbanner_height = jQuery(window).height();
    jQuery(".error-banner").css("height", errorbanner_height + "px");
  }
  //Navbar Sticky
  var scroll = jQuery(window).scrollTop();
  if (scroll >= 50) {
    jQuery(".navbar").addClass("navbar-sticky");
  } else {
    jQuery(".navbar").removeClass("navbar-sticky");
  }
  jQuery(window).scroll(function () {
    var scroll = jQuery(window).scrollTop();

    if (scroll >= 50) {
      jQuery(".navbar").addClass("navbar-sticky");
    } else {
      jQuery(".navbar").removeClass("navbar-sticky");
    }
  });

  var bred_scroll = jQuery(window).scrollTop();
  if (bred_scroll >= 50) {
    jQuery(".top_breadcrumb").addClass("breadcrumb_sticky");
  } else {
    jQuery(".top_breadcrumb").removeClass("breadcrumb_sticky");
  }
  jQuery(window).scroll(function () {
    var bred_scroll = jQuery(window).scrollTop();

    if (bred_scroll >= 50) {
      jQuery(".top_breadcrumb").addClass("breadcrumb_sticky");
    } else {
      jQuery(".top_breadcrumb").removeClass("breadcrumb_sticky");
    }
  });

  var lastScrollTop = 0;
  jQuery(window).scroll(function (event) {
    var st = jQuery(this).scrollTop();
    if (st > lastScrollTop) {
      jQuery(".navbar").removeClass("navbar-sticky");
      jQuery(".top_breadcrumb").removeClass("breadcrumb_sticky");
      jQuery("body").removeClass("mainNav-sticky");
      jQuery(".header").addClass("top-sticky");
    } else {
      jQuery(".navbar").addClass("navbar-sticky");
      jQuery(".top_breadcrumb").addClass("breadcrumb_sticky");
      jQuery("body").addClass("mainNav-sticky");
      jQuery(".header").removeClass("top-sticky");
    }
    lastScrollTop = st;

    if (st < 50) {
      jQuery(".navbar").removeClass("navbar-sticky");
      jQuery(".top_breadcrumb").removeClass("breadcrumb_sticky");
      jQuery(".header").removeClass("top-sticky");
    }

    if (st > 250) {
      jQuery("#BackToTop").addClass("on");
    } else {
      jQuery("#BackToTop").removeClass("on");
    }
  });
  var $status = jQuery(".pagingInfo");
  var $slickElement = jQuery(".list_properties_slider");

  $slickElement.on(
    "init reInit afterChange",
    function (event, slick, currentSlide, nextSlide) {
      var i = (currentSlide ? currentSlide : 0) + 1;

      $status.html(
        "<span class='first'>" +
          i +
          "</span> <b>/</b> <span class='last'>" +
          slick.slideCount +
          "</span>"
      );
    }
  );

  jQuery(".list_properties_slider").slick({
    dots: false,
    infinite: true,
    arrows: true,
    centerMode: true,
    centerPadding: "94px",
    speed: 300,
    slidesToShow: 2,
    slidesToScroll: 1,
    prevArrow:
      '<button class="slick-prev" aria-label="Previous" type="button"><span>previous</span></button>',
    nextArrow:
      '<button class="slick-next" aria-label="Next" type="button"><span>NEXT</span></button>',
    responsive: [
      {
        breakpoint: 1199,
        settings: {
          centerPadding: "79px",
        },
      },
      {
        breakpoint: 991,
        settings: {
          centerPadding: "70px",
          slidesToShow: 1,
        },
      },
      {
        breakpoint: 767,
        settings: {
          centerPadding: "69px",
          slidesToShow: 1,
          dots: true,
        },
      },
      {
        breakpoint: 639,
        settings: {
          centerPadding: "68px",
          slidesToShow: 1,
          dots: true,
        },
      },
      {
        breakpoint: 479,
        settings: {
          centerPadding: "0px",
          slidesToShow: 1,
          dots: true,
        },
      },
    ],
  });
  jQuery(".closely_slider").slick({
    dots: false,
    infinite: true,
    arrows: true,
    centerMode: true,
    centerPadding: "0px",
    speed: 300,
    slidesToShow: 1,
    slidesToScroll: 1,
    responsive: [
      {
        breakpoint: 767,
        settings: {
          dots: true,
        },
      },
    ],
  });
  jQuery(".awards-slider .list").slick({
    dots: false,
    infinite: false,
    speed: 300,
    slidesToShow: 4,
    slidesToScroll: 1,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
          infinite: true,
          dots: false,
        },
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
        },
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        },
      },
      // You can unslick at a given breakpoint now by adding:
      // settings: "unslick"
      // instead of a settings object
    ],
  });

  var lastScrollTop = 0;
  jQuery(window).scroll(function (event) {
    var st = jQuery(this).scrollTop();
    if (st > lastScrollTop) {
      jQuery(".navbar").removeClass("navbar-sticky");
      jQuery(".header").addClass("top-sticky");
    } else {
      jQuery(".navbar").addClass("navbar-sticky");
      jQuery(".header").removeClass("top-sticky");
    }
    lastScrollTop = st;

    if (st < 50) {
      jQuery(".navbar").removeClass("navbar-sticky");

      jQuery(".header").removeClass("top-sticky");
    }

    if (st > 250) {
      jQuery("#BackToTop").addClass("on");
    } else {
      jQuery("#BackToTop").removeClass("on");
    }
  });

  // Menu
  jQuery(".menu-icon").click(function () {
    jQuery("body").toggleClass("has-overlay");
  });
  jQuery(".search-icon").click(function () {
    jQuery("body").toggleClass("search-modal-open");
    setTimeout(function () {
      jQuery(".input-holder input").focus();
      temp = jQuery(".input-holder input").val();
      jQuery(".input-holder input").val("");
      jQuery(".input-holder input").val(temp);
      jQuery(".input-holder input").focus();
    }, 500);
  });
  jQuery(".refine-search").click(function () {
    jQuery("body").toggleClass("search-modal-open");
    setTimeout(function () {
      jQuery(".input-holder input").focus();
      temp = jQuery(".input-holder input").val();
      jQuery(".input-holder input").val("");
      jQuery(".input-holder input").val(temp);
      jQuery(".input-holder input").focus();
    }, 500);
  });
  jQuery(".search-modal button.close").click(function () {
    jQuery("body").toggleClass("search-modal-open");
  });
  jQuery(".header .search-box .close").click(function () {
    jQuery("body").toggleClass("search-modal-open");
  });
  jQuery(".close-menu").click(function () {
    jQuery("body").toggleClass("has-overlay");
  });
  jQuery(".site-overlay").click(function () {
    jQuery("body").toggleClass("has-overlay");
  });
  jQuery(".search-button").click(function () {
    jQuery("body").toggleClass("search-modal-open");
  });
  jQuery(".search-button").click(function () {
    jQuery("body").removeClass("has-overlay");
  });
  jQuery(".search-icon").click(function () {
    jQuery("body").removeClass("has-overlay");
  });
  jQuery(".menu-icon").click(function () {
    jQuery("body").removeClass("search-modal-open");
  });

  jQuery(".top_breadcrumb ul.menu li a").click(function () {
    jQuery("body").toggleClass("search-modal-open");
  });
  jQuery(".mobile-filter-row .wrap .filter-btn a").click(function () {
    jQuery("body").toggleClass("search-modal-open");
  });

  // Nav Arrow
  jQuery(".nav ul.mainMenu li.sub-menu").each(function () {
    jQuery(this)
      .children("a")
      .after("<span class='arrow'><i class='fa fa-angle-down'></i></span>");
  });
  jQuery(".nav ul li.sub-menu .arrow").click(function () {
    if (jQuery(this).next().is(":visible")) {
      jQuery(this).children(".fa").removeClass("fa-angle-up");
      jQuery(this).children(".fa").addClass("fa-angle-down");
      jQuery(this).next().slideUp();
    } else {
      jQuery(".nav ul li.sub-menu .arrow .fa").removeClass("fa-angle-up");
      jQuery(".nav ul li.sub-menu .arrow .fa").addClass("fa-angle-down");
      jQuery(".nav ul li.sub-menu .arrow").next().slideUp();
      jQuery(this).children(".fa").removeClass("fa-angle-down");
      jQuery(this).children(".fa").addClass("fa-angle-up");
      jQuery(this).next().slideDown();
    }
  });

  // Search Arrow
  jQuery(".filter-col .form-group").each(function () {
    jQuery(this)
      .children(".label")
      .after("<span class='arrow'><i class='fa fa-angle-down'></i></span>");
  });
  jQuery(".filter-col .form-group .arrow").click(function () {
    if (jQuery(this).next().is(":visible")) {
      jQuery(this).children(".fa").removeClass("fa-angle-up");
      jQuery(this).children(".fa").addClass("fa-angle-down");
      jQuery(this).next().slideUp();
    } else {
      jQuery(".filter-col .form-group .arrow .fa").removeClass("fa-angle-up");
      jQuery(".filter-col .form-group .arrow .fa").addClass("fa-angle-down");
      jQuery(".filter-col.price-filter .arrow .fa").removeClass("fa-angle-up");
      jQuery(".filter-col.price-filter .arrow .fa").addClass("fa-angle-down");
      jQuery(".filter-col .form-group .arrow").next().slideUp();
      jQuery(".filter-col.price-filter .arrow").next().slideUp();
      jQuery(this).children(".fa").removeClass("fa-angle-down");
      jQuery(this).children(".fa").addClass("fa-angle-up");
      jQuery(this).next().slideDown();
    }
  });
  jQuery(".filter-col.price-filter").each(function () {
    jQuery(this)
      .children(".price-label")
      .after("<span class='arrow'><i class='fa fa-angle-down'></i></span>");
  });
  jQuery(".filter-col.price-filter .arrow").click(function () {
    if (jQuery(this).next().is(":visible")) {
      jQuery(this).children(".fa").removeClass("fa-angle-up");
      jQuery(this).children(".fa").addClass("fa-angle-down");
      jQuery(this).next().slideUp();
    } else {
      jQuery(".filter-col.price-filter .arrow .fa").removeClass("fa-angle-up");
      jQuery(".filter-col.price-filter .arrow .fa").addClass("fa-angle-down");
      jQuery(".filter-col .form-group .arrow .fa").removeClass("fa-angle-up");
      jQuery(".filter-col .form-group .arrow .fa").addClass("fa-angle-down");
      jQuery(".filter-col.price-filter .arrow").next().slideUp();
      jQuery(".filter-col .form-group .arrow").next().slideUp();
      jQuery(this).children(".fa").removeClass("fa-angle-down");
      jQuery(this).children(".fa").addClass("fa-angle-up");
      jQuery(this).next().slideDown();
    }
  });

  // Match Height
  jQuery(".matchHeight").matchHeight({
    property: "height",
  });
  jQuery(".review_details p").matchHeight({
    property: "height",
  });
  /* jQuery('.page-saved-properties .properties-content').matchHeight({
        property: 'height'
      });*/

  // Search filter Mobile
  jQuery(".filter").click(function () {
    jQuery("body").toggleClass("mobile-filter");
  });

  jQuery(".filter-close").click(function () {
    jQuery("body").toggleClass("mobile-filter");
  });
  new WOW().init();
  // Slider
  jQuery(".properties-slider").slick({
    dots: false,
    infinite: true,
    arrows: true,
    speed: 300,
    slidesToShow: 1,
    slidesToScroll: 1,
    prevArrow:
      '<button class="slick-prev" aria-label="Previous" type="button"><span>previous</span></button>',
    nextArrow:
      '<button class="slick-next" aria-label="Next" type="button"><span>NEXT</span></button>',
    adaptiveHeight: true,
  });
  jQuery(".footer_review_slider").slick({
    dots: false,
    infinite: true,
    arrows: true,
    speed: 300,
    slidesToShow: 1,
    slidesToScroll: 1,
    prevArrow:
      '<button class="slick-prev" aria-label="Previous" type="button"><span>previous</span></button>',
    nextArrow:
      '<button class="slick-next" aria-label="Next" type="button"><span>NEXT</span></button>',
  });
  jQuery(function () {
    jQuery("button.close").click(function () {
      jQuery("#searchModal").modal("hide");
    });
  });

  /*--16-04-2021--*/
  jQuery(".dropdown-btn").click(function () {
    jQuery(".dropdown-list").slideToggle();
    jQuery(".dropdown-btn").toggleClass("active");
  });
  /*--16-04-2021--*/

  // 18-05-2022 start
  if (window.matchMedia("(max-width: 767px)").matches) {
    jQuery(".filter-col.price-filter.max").click(function () {
      jQuery(".form-group.max-grp").show();
      // jQuery('.max .select-price .form-group').hide();
    });
    jQuery(".min .price-label").text(function () {
      return jQuery(this).text().replace("Price Min", "Price Minimum");
    });
    jQuery(".max .price-label").text(function () {
      return jQuery(this).text().replace("Price Max", "Price Maximum");
    });
    jQuery(".mob-min").text(function () {
      return jQuery(this).text().replace("no min", "no minimum");
    });
    jQuery(".mob-max").text(function () {
      return jQuery(this).text().replace("no max", "no maximum");
    });
  }

  // 18-05-2022 end

  jQuery(
    ".search-filter .filter-row.active-row .price-filter .rent"
  ).selectpicker("hide");
  jQuery(".filter-col.price-filter.min").hide();

  jQuery(".advanced-search-btn").click(function () {
    jQuery(".filter-col.price-filter.min").toggle();

    jQuery(".search-wrapper").toggleClass("advanced-search-active");

    jQuery(this).toggleClass("active");
    var s = jQuery(this);
    var originaltext = s.text();
    jQuery(".advanced-search-btn").text("Advanced search");
    s.text(originaltext);
    s.html(
      s.text() == "Advanced search" ? "Compact Search" : "Advanced search"
    );
    if (jQuery(".search-wrapper").hasClass("advanced-search-active")) {
      if (
        jQuery(
          ".search-wrapper.advanced-search-active input[type='radio'][name='dp']:checked"
        ).val() == "letting"
      ) {
        jQuery(".area-list ul li").each(function (index) {
          var _href = jQuery(this).children("a").attr("href");
          var new_href = _href.replace("?dpt=sale", "?dpt=letting");
          jQuery(this).children("a").attr("href", new_href);
        });
        jQuery(
          ".search-wrapper.advanced-search-active .filter-row.hide.Furnishing-col"
        ).addClass("show");
        jQuery(
          ".search-wrapper .filter-row.active-row input[type='radio'][name='dp'][value='letting']"
        ).attr("checked", true);
        jQuery(
          ".search-wrapper .filter-row.active-row input[type='radio'][name='dp'][value='letting']"
        )
          .parent()
          .addClass("checked");
        jQuery(
          ".search-wrapper.advanced-search-active .first-row.hide .price-filter .rent"
        ).selectpicker("show");
        jQuery(
          ".search-wrapper.advanced-search-active .first-row.hide .price-filter .sales"
        ).selectpicker("hide");
      } else {
        jQuery(".area-list ul li").each(function (index) {
          var _href = jQuery(this).children("a").attr("href");
          var new_href = _href.replace("?dpt=letting", "?dpt=sale");
          jQuery(this).children("a").attr("href", new_href);
        });

        jQuery(
          ".search-wrapper .filter-row.active-row input[type='radio'][name='dp'][value='sale']"
        ).attr("checked", true);
        jQuery(
          ".search-wrapper .filter-row.active-row input[type='radio'][name='dp'][value='sale']"
        )
          .parent()
          .addClass("checked");
        jQuery(
          ".search-wrapper.advanced-search-active .first-row.hide .price-filter .rent"
        ).selectpicker("hide");
        jQuery(
          ".search-wrapper.advanced-search-active .first-row.hide .price-filter .sales"
        ).selectpicker("show");
      }
    } else {
      jQuery(".search-wrapper .filter-row.hide.Furnishing-col").removeClass(
        "show"
      );
    }
  });

  jQuery("#date_picker").attr("readonly", true);
  jQuery("#date_picker").datepicker({
    altFormat: "dd/mm/yy",
    dateFormat: "dd/mm/yy",
    changeMonth: true,
    changeYear: true,
  });
  jQuery(".viewing-form form .selectpicker").selectpicker({
    dropupAuto: false,
  });

  jQuery(".contactform form .selectpicker").selectpicker({
    dropupAuto: false,
  });
  jQuery(".sortby-dropdown .selectpicker").selectpicker({
    dropupAuto: false,
  });

  // declare variable
  var scrollTop = jQuery(".scrollTop");
  var toTop = jQuery("#back_to_top");

  jQuery(window).scroll(function () {
    // declare variable
    var topPos = jQuery(this).scrollTop();

    // if user scrolls down - show scroll to top button
    if (topPos > 100) {
      jQuery(scrollTop).css("opacity", "1");
    } else {
      jQuery(scrollTop).css("opacity", "0");
    }
  }); // scroll END
  //Click event to scroll to top

  jQuery(".scrollTop").on("click", function () {
    jQuery("html, body").animate(
      {
        scrollTop: 0,
      },
      100
    );
    return false;
  }); // click() scroll top EMD

  jQuery(".journal-list").cubeportfolio({
    filters: "#js-filters-lightbox-gallery1, #js-filters-lightbox-gallery2",
    loadMore: "#js-loadMore-lightbox-gallery",
    loadMoreAction: "click",
    layoutMode: "grid",

    gapHorizontal: 0,
    gapVertical: 0,
    gridAdjustment: "responsive",

    // singlePageInline
    singlePageInlineDelegate: ".cbp-singlePageInline",
    singlePageInlinePosition: "below",
    singlePageInlineInFocus: true,
    singlePageInlineCallback: function (url, element) {
      // to update singlePageInline content use the following method: this.updateSinglePageInline(yourContent)
      var t = this;

      jQuery
        .ajax({
          url: url,
          type: "GET",
          dataType: "html",
          timeout: 30000,
        })
        .done(function (result) {
          t.updateSinglePageInline(result);
          contentBg();
        })
        .fail(function () {
          t.updateSinglePageInline("AJAX Error! Please refresh the page!");
        });
    },
  });
  eqheight();

  jQuery("#autocomplete").typeahead({
    autoSelect: false,
    minLength: 2,
    order: "asc",
    source: function (search_term, result) {
      jQuery.ajax({
        url: ast_var.admin_ajax,
        data:
          "action=property_title_autocomplete&search_term=" +
          search_term +
          "&dpt=" +
          jQuery("input[type='hidden'][name='dpt']").val(),
        dataType: "json",
        type: "POST",
        action: "property_title_autocomplete",
        success: function (data) {
          result(
            jQuery.map(data, function (item) {
              return item;
            })
          );
        },
      });
    },
  });
  jQuery("input[type='radio'][name='dp']").click(function () {
    if (jQuery(".search-wrapper").hasClass("advanced-search-active")) {
      if (jQuery(this).val() == "letting") {
        jQuery("input[type='radio'][name='dp']:not(:checked)")
          .parent()
          .removeClass("checked");
        jQuery("input[type='radio'][name='dp']:not(:checked)").attr(
          "checked",
          false
        );
        jQuery("input[type='radio'][name='dp']:checked")
          .parent()
          .addClass("checked");
        jQuery("input[type='radio'][name='dp']:checked").attr("checked", true);
        jQuery(
          ".search-wrapper.advanced-search-active .filter-row.hide.Furnishing-col"
        ).addClass("show");
        jQuery(
          ".search-wrapper .filter-row.active-row input[type='radio'][name='dp'][value='letting']"
        ).attr("checked", true);
        jQuery(
          ".search-wrapper .filter-row.active-row input[type='radio'][name='dp'][value='letting']"
        )
          .parent()
          .addClass("checked");
        jQuery(
          ".search-wrapper .first-row.hide .price-filter .rent"
        ).selectpicker("show");
        jQuery(
          ".search-wrapper .first-row.hide .price-filter .sales"
        ).selectpicker("hide");

        jQuery(".area-list ul li").each(function (index) {
          var _href = jQuery(this).children("a").attr("href");
          var new_href = _href.replace("?dpt=sale", "?dpt=letting");
          jQuery(this).children("a").attr("href", new_href);
        });
      } else {
        jQuery(
          ".search-wrapper.advanced-search-active .filter-row.hide input[type='radio'][name='dp'][value='sale']"
        ).prop("checked", true);
        jQuery("input[type='radio'][name='dp']:not(:checked)")
          .parent()
          .removeClass("checked");
        jQuery("input[type='radio'][name='dp']:not(:checked)").attr(
          "checked",
          false
        );
        jQuery("input[type='radio'][name='dp']:checked")
          .parent()
          .addClass("checked");
        jQuery(
          ".search-wrapper.advanced-search-active .filter-row.hide.Furnishing-col"
        ).removeClass("show");

        jQuery(
          ".search-wrapper .filter-row.active-row input[type='radio'][name='dp'][value='sale']"
        ).attr("checked", true);
        jQuery(
          ".search-wrapper .filter-row.active-row input[type='radio'][name='dp'][value='sale']"
        )
          .parent()
          .addClass("checked");
        jQuery(
          ".search-wrapper .first-row.hide .price-filter .rent"
        ).selectpicker("hide");
        jQuery(
          ".search-wrapper .first-row.hide .price-filter .sales"
        ).selectpicker("show");

        jQuery(".area-list ul li").each(function (index) {
          var _href = jQuery(this).children("a").attr("href");
          var new_href = _href.replace("?dpt=letting", "?dpt=sale");
          jQuery(this).children("a").attr("href", new_href);
        });
      }
    } else {
      jQuery("input[type='radio'][name='dp']:not(:checked)")
        .parent()
        .removeClass("checked");
      jQuery("input[type='radio'][name='dp']:not(:checked)").attr(
        "checked",
        false
      );
      jQuery("input[type='radio'][name='dp']:checked")
        .parent()
        .addClass("checked");
      jQuery("input[type='radio'][name='dp']:checked").attr("checked", true);

      if (jQuery(this).prop("checked") && jQuery(this).val() == "letting") {
        jQuery(
          ".search-wrapper .filter-row.hide input[type='radio'][name='dp'][value='letting']"
        ).attr("checked", true);
        jQuery(
          ".search-wrapper .filter-row.hide input[type='radio'][name='dp'][value='letting']"
        )
          .parent()
          .addClass("checked");
        jQuery(".search-wrapper .filter-row .price-filter .rent").selectpicker(
          "show"
        );
        jQuery(".search-wrapper .filter-row .price-filter .sales").selectpicker(
          "hide"
        );

        jQuery(".area-list ul li").each(function (index) {
          var _href = jQuery(this).children("a").attr("href");
          var new_href = _href.replace("?dpt=sale", "?dpt=letting");
          jQuery(this).children("a").attr("href", new_href);
        });
      } else {
        jQuery(
          ".search-wrapper .filter-row.hide input[type='radio'][name='dp'][value='sale']"
        ).attr("checked", true);
        jQuery(
          ".search-wrapper .filter-row.hide input[type='radio'][name='dp'][value='sale']"
        )
          .parent()
          .addClass("checked");
        jQuery(".search-wrapper .filter-row .price-filter .rent").selectpicker(
          "hide"
        );
        jQuery(".search-wrapper .filter-row .price-filter .sales").selectpicker(
          "show"
        );

        jQuery(".area-list ul li").each(function (index) {
          var _href = jQuery(this).children("a").attr("href");
          var new_href = _href.replace("?dpt=letting", "?dpt=sale");
          jQuery(this).children("a").attr("href", new_href);
        });
      }
    }
  });

  /* Property Pet Friendly */
  jQuery(".property_pet input[type='radio'][name='petfriendly']").click(
    function () {
      jQuery(this).prop("checked", false);
      jQuery(this).parent().toggleClass("checked");

      if (jQuery(this).parent().hasClass("checked")) {
        jQuery(this).prop("checked", true);
        jQuery(document)
          .find(
            ".property_pet input:not(:checked)[type='radio'][name='petfriendly']"
          )
          .parent()
          .removeClass("checked");
      }
    }
  );

  /* Property Sold */
  jQuery("input[type='radio'][name='sold']").click(function () {
    jQuery("input[type='radio'][name='sold']:not(:checked)")
      .parent()
      .removeClass("checked");
    jQuery("input[type='radio'][name='sold']:checked")
      .parent()
      .addClass("checked");
  });

  /* Property Sold */
  jQuery("input[type='radio'][name='sq_ft']").click(function () {
    if (jQuery(this).val() == "sq_ft") {
      jQuery(".property-size.sq_m").addClass("hidem");
      jQuery(".property-size.sq_m").removeClass("showm");
      jQuery(".property-size.sq_ft").addClass("showft");
      jQuery(".property-size.sq_ft").removeClass("hideft");
    } else if (jQuery(this).val() == "m2") {
      jQuery(".property-size.sq_m").addClass("showm");
      jQuery(".property-size.sq_m").removeClass("hidem");
      jQuery(".property-size.sq_ft").addClass("hideft");
      jQuery(".property-size.sq_ft").removeClass("showft");
    }

    jQuery("input[type='radio'][name='sq_ft']:not(:checked)")
      .parent()
      .removeClass("checked");
    jQuery("input[type='radio'][name='sq_ft']:checked")
      .parent()
      .addClass("checked");
  });

  jQuery(".selectbeds.selectpicker").on("change", function () {
    jQuery(".selectbeds.selectpicker").selectpicker("val", jQuery(this).val());
  });
  jQuery(".maxprice.selectpicker").on("change", function () {
    jQuery(".maxprice.selectpicker").selectpicker("val", jQuery(this).val());
  });
  jQuery(".maxprice.selectpicker").on("shown.bs.select", function (e) {
    if (
      jQuery(
        ".search-wrapper.advanced-search-active input[type='radio'][name='dp']:checked"
      ).val() == "letting"
    ) {
      jQuery(
        ".search-wrapper .filter-row.first-row .dropdown-menu.inner.show .rent_option"
      ).show();
    }
    if (
      jQuery(
        ".search-wrapper .filter-row input[type='radio'][name='dp']:checked"
      ).val() == "letting"
    ) {
      jQuery(
        ".search-wrapper .filter-row .dropdown-menu.inner.show .rent_option"
      ).show();
    }
  });

  jQuery(".minprice.selectpicker").on("shown.bs.select", function (e) {
    if (
      jQuery(
        ".search-wrapper.advanced-search-active input[type='radio'][name='dp']:checked"
      ).val() == "letting"
    ) {
      jQuery(
        ".search-wrapper .filter-row.first-row .dropdown-menu.inner.show .rent_option"
      ).show();
    }
    if (
      jQuery(
        ".search-wrapper .filter-row input[type='radio'][name='dp']:checked"
      ).val() == "letting"
    ) {
      jQuery(
        ".search-wrapper .filter-row .dropdown-menu.inner.show .rent_option"
      ).show();
    }
  });

  var empty_area = "";
  jQuery("#autocomplete").keyup(function () {
    empty_area = jQuery(this).val();
    //   console.log(empty_area);
  });

  jQuery("#sortbyprice.selectpicker").on("change", function (e) {
    var price = jQuery(this).val();
    var dp = jQuery("input[type='radio'][name='dp']:checked").val();
    var bedroom = jQuery(".selectbeds :selected").val();
    var maxprice = jQuery(".maxprice :selected").val();
    var minprice = jQuery(".minprice :selected").val();
    var sold = jQuery("input[type='radio'][name='sold']:checked").val();
    var perfridy = jQuery(
      "input[type='radio'][name='petfriendly']:checked"
    ).val();
    var display_style = jQuery("input[type='hidden'][name='map_style']").val();
    var cur_conveter = jQuery("input[type='hidden'][name='cur']").val();

    if (empty_area == "") {
      var area_name = "";
    } else {
      if (jQuery("input[type='text'][name='area_search']").val() != "") {
        var area_name = jQuery("input[type='text'][name='area_search']").val();
      } else {
        var area_name = jQuery(
          "input[type='hidden'][name='property_area']"
        ).val();
      }
    }

    if (jQuery("input[type='radio'][name='sq_ft']:checked").val() == "m2") {
      var psq_m = jQuery(".property-size.sq_m :selected").val();
    } else {
      var psq_m = "";
    }

    if (jQuery("input[type='radio'][name='sq_ft']:checked").val() == "sq_ft") {
      var psq_ft = jQuery(".property-size.sq_ft :selected").val();
    } else {
      var psq_ft = "";
    }
    var furnishing = [];

    jQuery("input[type='checkbox'][name='furnishing[]']:checked").each(
      function () {
        pamity.push(jQuery(this).val());
      }
    );

    var pamity = [];
    jQuery("input[type='checkbox'][name='pamity[]']:checked").each(function () {
      pamity.push(jQuery(this).val());
    });

    var p_area = [];

    jQuery("input[type='checkbox'][name='pareas[]']:checked").each(function () {
      p_area.push(jQuery(this).val());
    });

    var pstyle = [];
    jQuery("input[type='checkbox'][name='pstyle[]']:checked").each(function () {
      pstyle.push(jQuery(this).val());
    });

    var prtage = [];
    jQuery("input[type='checkbox'][name='prtage[]']:checked").each(function () {
      prtage.push(jQuery(this).val());
    });

    var property_search_url = ast_var.property_search_url;

    const search_param = new URLSearchParams();

    if (dp != "") {
      search_param.set("dpt", dp);
    }
    if (bedroom != "" && bedroom != undefined) {
      search_param.set("bed", bedroom);
    }

    if (minprice != "" && minprice != undefined) {
      search_param.set("minp", minprice);
    }
    if (maxprice != "" && maxprice != undefined) {
      search_param.set("maxp", maxprice);
    }

    if (psq_ft != "" && psq_ft != undefined) {
      search_param.set("psq_ft", psq_ft);
    }
    if (psq_m != "" && psq_m != undefined) {
      search_param.set("psq_m", psq_m);
    }

    if (pstyle != undefined && pstyle != "") {
      search_param.set("ptype", pstyle);
    }
    if (prtage != undefined && prtage != "") {
      search_param.set("ptage", prtage);
    }

    if (furnishing != undefined && furnishing != "" && dp == "letting") {
      search_param.set("pfun", furnishing);
    }
    if (perfridy != undefined && perfridy != "" && dp == "letting") {
      search_param.set("petfdy", perfridy);
    }
    if (sold != "" && sold != undefined) {
      search_param.set("pstus", sold);
    }
    if (area_name != "" && area_name != undefined) {
      search_param.set("parea", area_name);
    }
    if (pamity != "" && pamity != undefined) {
      search_param.set("pamty", pamity);
    }
    if (p_area != "" && p_area != undefined) {
      search_param.set("area", p_area);
    }
    if (display_style != undefined && display_style != "") {
      search_param.set("style", display_style);
    }
    if (cur_conveter != undefined && cur_conveter != "") {
      search_param.set("cur", cur_conveter);
    }
    if (price != "" && price != undefined) {
      search_param.set("srtbyprice", price);
    }

    window.location.href = property_search_url + "?" + search_param;
  });

  jQuery("li.currency a").on("click", function () {
    var currency = jQuery(this).attr("id");

    var dp = jQuery("input[type='radio'][name='dp']:checked").val();
    var bedroom = jQuery(".selectbeds :selected").val();
    var maxprice = jQuery(".maxprice :selected").val();
    var minprice = jQuery(".minprice :selected").val();
    var furnishing = jQuery(
      "input[type='radio'][name='furnishing']:checked"
    ).val();
    var sold = jQuery("input[type='radio'][name='sold']:checked").val();
    var perfridy = jQuery(
      "input[type='radio'][name='petfriendly']:checked"
    ).val();
    var pamity = [];
    var p_area = [];
    var price_order = jQuery("#sortbyprice:visible :selected").val();
    var display_style = jQuery("input[type='hidden'][name='map_style']").val();

    if (jQuery("input[type='text'][name='area_search']").val() != "") {
      var area_name = jQuery("input[type='text'][name='area_search']").val();
    } else {
      var area_name = jQuery(
        "input[type='hidden'][name='property_area']"
      ).val();
    }

    if (jQuery("input[type='radio'][name='sq_ft']:checked").val() == "m2") {
      var psq_m = jQuery(".property-size.sq_m :selected").val();
    } else {
      var psq_m = "";
    }

    if (jQuery("input[type='radio'][name='sq_ft']:checked").val() == "sq_ft") {
      var psq_ft = jQuery(".property-size.sq_ft :selected").val();
    } else {
      var psq_ft = "";
    }

    var furnishing = [];

    jQuery("input[type='checkbox'][name='furnishing[]']:checked").each(
      function () {
        furnishing.push(jQuery(this).val());
      }
    );

    var pamity = [];
    jQuery("input[type='checkbox'][name='pamity[]']:checked").each(function () {
      pamity.push(jQuery(this).val());
    });

    var p_area = [];
    jQuery("input[type='checkbox'][name='pareas[]']:checked").each(function () {
      p_area.push(jQuery(this).val());
    });

    var prtage = [];
    jQuery("input[type='checkbox'][name='prtage[]']:checked").each(function () {
      prtage.push(jQuery(this).val());
    });

    var pstyle = [];
    jQuery("input[type='checkbox'][name='pstyle[]']:checked").each(function () {
      pstyle.push(jQuery(this).val());
    });

    // alert(ptype);

    var property_search_url = ast_var.property_search_url;

    const search_param = new URLSearchParams();

    if (dp != "") {
      search_param.set("dpt", dp);
    }
    if (bedroom != "" || bedroom != undefined) {
      search_param.set("bed", bedroom);
    }

    if (minprice != "" && minprice != undefined) {
      search_param.set("minp", minprice);
    }
    if (maxprice != "" && maxprice != undefined) {
      search_param.set("maxp", maxprice);
    }

    if (psq_ft != "" && psq_ft != undefined) {
      search_param.set("psq_ft", psq_ft);
    }
    if (psq_m != "" && psq_m != undefined) {
      search_param.set("psq_m", psq_m);
    }

    if (pstyle != undefined && pstyle != "") {
      search_param.set("ptype", pstyle);
    }
    if (prtage != undefined && prtage != "") {
      search_param.set("ptage", prtage);
    }

    if (furnishing != undefined && furnishing != "" && dp == "letting") {
      search_param.set("pfun", furnishing);
    }
    if (perfridy != undefined && perfridy != "" && dp == "letting") {
      search_param.set("petfdy", perfridy);
    }
    if (sold != "" && sold != undefined) {
      search_param.set("pstus", sold);
    }
    if (area_name != "" && area_name != undefined) {
      search_param.set("parea", area_name);
    }
    if (pamity != "" && pamity != undefined) {
      search_param.set("pamty", pamity);
    }
    if (p_area != "" && p_area != undefined) {
      search_param.set("area", p_area);
    }
    if (display_style != undefined && display_style != "") {
      search_param.set("style", display_style);
    }
    if (currency != "GBP" && currency != undefined) {
      search_param.set("cur", currency);
    }
    if (price_order != undefined && price_order != "") {
      search_param.set("srtbyprice", price_order);
    }

    window.location.href = property_search_url + "?" + search_param;
  });

  jQuery(".search-btn").on("click", function () {
    var dp = jQuery("input[type='radio'][name='dp']:checked").val();
    var bedroom = jQuery(".selectbeds :selected").val();
    var maxprice = jQuery(".maxprice :selected").val();
    var minprice = jQuery(".minprice :selected").val();
    var perfridy = jQuery("input[type='radio'][name='sq_ft']:checked").val();
    if (jQuery("input[type='radio'][name='sq_ft']:checked").val() == "m2") {
      var psq_m = jQuery(".property-size.sq_m :selected").val();
    } else {
      var psq_m = "";
    }

    if (jQuery("input[type='radio'][name='sq_ft']:checked").val() == "sq_ft") {
      var psq_ft = jQuery(".property-size.sq_ft :selected").val();
    } else {
      var psq_ft = "";
    }

    var sold = jQuery("input[type='radio'][name='sold']:checked").val();
    var perfridy = jQuery(
      "input[type='radio'][name='petfriendly']:checked"
    ).val();
    if (empty_area == "") {
      var area_name = "";
    } else {
      if (jQuery("input[type='text'][name='area_search']").val() != "") {
        var area_name = jQuery("input[type='text'][name='area_search']").val();
      } else {
        var area_name = jQuery(
          "input[type='hidden'][name='property_area']"
        ).val();
      }
    }

    var display_style = jQuery("input[type='hidden'][name='map_style']").val();
    var cur_conveter = jQuery("input[type='hidden'][name='cur']").val();
    var price_order = jQuery("#sortbyprice:visible :selected").val();

    var furnishing = [];

    jQuery("input[type='checkbox'][name='furnishing[]']:checked").each(
      function () {
        furnishing.push(jQuery(this).val());
      }
    );

    var pamity = [];
    jQuery("input[type='checkbox'][name='pamity[]']:checked").each(function () {
      pamity.push(jQuery(this).val());
    });

    var p_area = [];
    jQuery("input[type='checkbox'][name='pareas[]']:checked").each(function () {
      p_area.push(jQuery(this).val());
    });

    var prtage = [];
    jQuery("input[type='checkbox'][name='prtage[]']:checked").each(function () {
      prtage.push(jQuery(this).val());
    });

    var pstyle = [];
    jQuery("input[type='checkbox'][name='pstyle[]']:checked").each(function () {
      pstyle.push(jQuery(this).val());
    });

    var property_search_url = ast_var.property_search_url;

    const search_param = new URLSearchParams();

    if (dp != "") {
      search_param.set("dpt", dp);
    }
    if (bedroom != undefined && bedroom != "") {
      search_param.set("bed", bedroom);
    }

    if (minprice != undefined && minprice != "") {
      search_param.set("minp", minprice);
    }
    if (maxprice != undefined && maxprice != "") {
      search_param.set("maxp", maxprice);
    }

    if (psq_ft != undefined && psq_ft != "") {
      search_param.set("psq_ft", psq_ft);
    }
    if (psq_m != undefined && psq_m != "") {
      search_param.set("psq_m", psq_m);
    }
    if (pstyle != undefined && pstyle != "") {
      search_param.set("ptype", pstyle);
    }
    if (prtage != undefined && prtage != "") {
      search_param.set("ptage", prtage);
    }

    if (furnishing != undefined && dp == "letting") {
      search_param.set("pfun", furnishing);
    }
    if (perfridy != undefined && dp == "letting") {
      search_param.set("petfdy", perfridy);
    }
    if (sold != undefined && sold != "") {
      search_param.set("pstus", sold);
    }
    if (area_name != "" && area_name != undefined) {
      search_param.set("parea", area_name);
    }
    if (pamity != undefined && pamity != "") {
      search_param.set("pamty", pamity);
    }
    if (p_area != undefined && p_area != "") {
      search_param.set("area", p_area);
    }
    if (display_style != undefined && display_style != "") {
      search_param.set("style", display_style);
    }
    if (cur_conveter != undefined && cur_conveter != "") {
      search_param.set("cur", cur_conveter);
    }
    if (price_order != undefined && price_order != "") {
      search_param.set("srtbyprice", price_order);
    }
    if (dp == "letting" || dp == "sale") {
      search_param.set("srtbyprice", "high");
    }

    window.location.href = property_search_url + "?" + search_param;
  });

  jQuery(".mapsearch , .gridsearch").on("click", function () {
    var style = jQuery(this).attr("id");
    var dp = jQuery("input[type='radio'][name='dp']:checked").val();
    var bedroom = jQuery(".selectbeds :selected").val();
    var maxprice = jQuery(".maxprice :selected").val();
    var minprice = jQuery(".minprice :selected").val();
    var sold = jQuery("input[type='radio'][name='sold']:checked").val();

    var perfridy = jQuery(
      "input[type='radio'][name='petfriendly']:checked"
    ).val();
    if (jQuery("input[type='text'][name='area_search']").val() != "") {
      var area_name = jQuery("input[type='text'][name='area_search']").val();
    } else {
      var area_name = jQuery(
        "input[type='hidden'][name='property_area']"
      ).val();
    }

    var price_order = jQuery("#sortbyprice:visible :selected").val();
    var cur_conveter = jQuery("input[type='hidden'][name='cur']").val();

    var furnishing = [];

    jQuery("input[type='checkbox'][name='furnishing[]']:checked").each(
      function () {
        furnishing.push(jQuery(this).val());
      }
    );

    var pamity = [];
    jQuery("input[type='checkbox'][name='pamity[]']:checked").each(function () {
      pamity.push(jQuery(this).val());
    });

    var p_area = [];
    jQuery("input[type='checkbox'][name='pareas[]']:checked").each(function () {
      p_area.push(jQuery(this).val());
    });

    var prtage = [];
    jQuery("input[type='checkbox'][name='prtage[]']:checked").each(function () {
      prtage.push(jQuery(this).val());
    });

    var pstyle = [];
    jQuery("input[type='checkbox'][name='pstyle[]']:checked").each(function () {
      pstyle.push(jQuery(this).val());
    });

    if (jQuery("input[type='radio'][name='sq_ft']:checked").val() == "m2") {
      var psq_m = jQuery(".property-size.sq_m :selected").val();
    } else {
      var psq_m = "";
    }

    if (jQuery("input[type='radio'][name='sq_ft']:checked").val() == "sq_ft") {
      var psq_ft = jQuery(".property-size.sq_ft :selected").val();
    } else {
      var psq_ft = "";
    }

    var property_search_url = ast_var.property_search_url;

    const search_param = new URLSearchParams();

    if (dp != "") {
      search_param.set("dpt", dp);
    }
    if (bedroom != "" && bedroom != undefined) {
      search_param.set("bed", bedroom);
    }

    if (minprice != "" && minprice != undefined) {
      search_param.set("minp", minprice);
    }
    if (maxprice != "" && maxprice != undefined) {
      search_param.set("maxp", maxprice);
    }

    if (psq_ft != "" && psq_ft != undefined) {
      search_param.set("psq_ft", psq_ft);
    }
    if (psq_m != "" && psq_m != undefined) {
      search_param.set("psq_m", psq_m);
    }

    if (pstyle != undefined && pstyle != "") {
      search_param.set("ptype", pstyle);
    }
    if (prtage != undefined && prtage != "") {
      search_param.set("ptage", prtage);
    }

    if (furnishing != undefined && furnishing != "" && dp == "letting") {
      search_param.set("pfun", furnishing);
    }
    if (perfridy != undefined && perfridy != "" && dp == "letting") {
      search_param.set("petfdy", perfridy);
    }
    if (sold != "" && sold != undefined) {
      search_param.set("pstus", sold);
    }
    if (area_name != "" && area_name != undefined) {
      search_param.set("parea", area_name);
    }
    if (pamity != "" && pamity != undefined) {
      search_param.set("pamty", pamity);
    }
    if (p_area != "" && p_area != undefined) {
      search_param.set("area", p_area);
    }
    if (style != "grid" && style != undefined) {
      search_param.set("style", style);
    }
    if (cur_conveter != undefined && cur_conveter != "") {
      search_param.set("cur", cur_conveter);
    }
    if (price_order != undefined && price_order != "") {
      search_param.set("srtbyprice", price_order);
    }
    window.location.href = property_search_url + "?" + search_param;
  });

  if (jQuery("ul.page-numbers li a").is(".prev")) {
    jQuery("ul.page-numbers li a.prev").parent().addClass("prev-list");
  }
  if (jQuery("ul.page-numbers li a").is(".next")) {
    jQuery("ul.page-numbers li a.next").parent().addClass("next-list");
  }

  /* Saved Properties*/
  jQuery(".container , .map-search-block").on("click", ".heart", function () {
    var property_saved_id = jQuery(this).attr("date-attr");
    var property_user_id = jQuery(this).attr("data-id");
    var $this = jQuery(this);

    if (property_user_id == "") {
      window.location.href = ast_var.login_url;
    } else {
      if ($this.hasClass("active")) {
        var alreadysaved = 1;
      } else {
        var alreadysaved = 0;
      }
      var datas =
        "psaved_id=" +
        property_saved_id +
        "&puser_id=" +
        property_user_id +
        "&saved_prperty_nonce=" +
        ast_var.saved_prperty_nonce +
        "&alreadysaved=" +
        alreadysaved +
        "&action=fn_Saved_Properties";

      jQuery.ajax({
        type: "post",
        url: ast_var.admin_ajax,
        data: datas,
        dataType: "json",
        success: function (response) {
          if (response.code == 1) {
            $this.parent().addClass("faved");
            $this.addClass("active");
            $this.children("img.saved_img").show();
            $this.children("img.default_img").hide();

            /*var src = $this.children('img').attr('src').replace("save_icon.svg","unsave_icon.svg");
                        $this.children('img').attr('src', src);*/
          } else if (response.code == 2) {
            $this.parent().removeClass("faved");
            $this.removeClass("active");
            /*var src = $this.children('img').attr('src').replace("unsave_icon.svg","save_icon.svg");
                        $this.children('img').attr('src', src);*/
            $this.children("img.saved_img").hide();
            $this.children("img.default_img").show();
          }
        },
      });
    }
  });
  jQuery(".container").on("click", ".alert_status", function () {
    var id = jQuery(this).attr("id");
    var alert_status = jQuery(this).attr("data-id");
    var user_id = jQuery("#user_id").val();
    var $alert = jQuery(this);
    var datas =
      "id=" +
      id +
      "&user_id=" +
      user_id +
      "&alert_status=" +
      alert_status +
      "&saved_search_nonce=" +
      ast_var.saved_search_nonce +
      "&action=fn_Saved_Search_Email_Alert";

    jQuery.ajax({
      type: "post",
      url: ast_var.admin_ajax,
      data: datas,
      dataType: "json",
      success: function (response) {
        if (response.code == 1) {
          $alert.children("span").text(response.alert_status);
          $alert.attr("data-id", response.alert_value);
        } else if (response.code == 0) {
          alert(response.alert);
        }
      },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
      },
    });
  });

  jQuery(".add_alert").on("click", function () {
    jQuery("#saved_search_confirmation").modal("show");
  });
  jQuery("#saved_search").on("click", function () {
    jQuery("#saved_search_confirmation").modal("hide");
    var property_user_id = jQuery(".add_alert").attr("id");
    if (property_user_id == "") {
      window.location.href = ast_var.login_url;
    } else {
      var search_url = window.location.href;

      var datas =
        "search_url=" +
        search_url +
        "&puser_id=" +
        property_user_id +
        "&saved_search_nonce=" +
        ast_var.saved_search_nonce +
        "&action=fn_Saved_Search_Criteria";

      jQuery.ajax({
        type: "post",
        url: ast_var.admin_ajax,
        data: datas,
        dataType: "json",
        success: function (response) {
          if (response.code == 1) {
            jQuery("#saved_search_sucess").modal("show");
          } else if (response.code == 0) {
            jQuery("#saved_search_error").modal("show");
          }
        },
        error: function (xhr, ajaxOptions, thrownError) {
          jQuery("#saved_search_error").modal("show");
        },
      });
    }
  });
  //jQuery(".submit-loder").hide();
  jQuery(".container").on("click", ".delete_alert", function () {
    var search_id = jQuery(this).attr("id");
    var user_id = jQuery("#user_id").val();
    var $this = jQuery(this);
    var datas =
      "search_id=" +
      search_id +
      "&user_id=" +
      user_id +
      "&saved_search_nonce=" +
      ast_var.saved_search_nonce +
      "&action=fn_Delete_Search_Criteria";

    jQuery.ajax({
      type: "post",
      url: ast_var.admin_ajax,
      data: datas,
      dataType: "json",
      beforeSend: function () {
        jQuery(".submit-loder").show();
      },
      success: function (response) {
        if (response.code == 1) {
          jQuery(".search-creatia-block").html(response.res_data).fadeIn();
        } else {
          jQuery(".saved-alert").html(response.alert);
          jQuery(".saved-alert").addClass("alert-danger");
        }
      },
      complete: function () {
        jQuery(".submit-loder").hide();
      },
    });
  });

  jQuery(".container").on("click", ".remove", function () {
    var property_saved_id = jQuery(this).attr("id");
    var property_user_id = jQuery(this).attr("data-id");
    var $this = jQuery(this);
    var datas =
      "psaved_id=" +
      property_saved_id +
      "&puser_id=" +
      property_user_id +
      "&saved_prperty_nonce=" +
      ast_var.saved_prperty_nonce +
      "&action=fn_Removed_Saved_Properties";

    jQuery.ajax({
      type: "post",
      url: ast_var.admin_ajax,
      data: datas,
      dataType: "json",
      beforeSend: function () {
        jQuery(".submit-loder").show();
      },
      success: function (response) {
        if (response.code == 1) {
          jQuery(".properties-row .row").html(response.res_data).fadeIn();
        } else {
          $(".saved-alert").html(response.alert);
          $(".saved-alert").addClass("alert-danger");
        }
      },
      complete: function () {
        jQuery(".submit-loder").hide();
      },
    });
  });

  jQuery(".google-review-blocks .col-sm-4").slice(0, 3).show();

  jQuery(".review_btn").on("click", function (e) {
    e.preventDefault();
    jQuery(".google-review-blocks .col-sm-4:hidden").slice(0, 4).slideDown();
    if (jQuery(".google-review-blocks .col-sm-4:hidden").length == 0) {
      jQuery("#load").fadeOut("slow");
    }
    jQuery("html,body").animate(
      {
        scrollTop: jQuery(".review_btn").offset().top - 400,
      },
      1500
    );
  });

  var $min = jQuery(".selectpicker.minprice");
  var $max = jQuery(".selectpicker.maxprice");

  $min.add($max).change(function () {
    var $this = "#" + jQuery(this).attr("id");
    //alert(jQuery($this).val());
    var minVal = parseInt($min.val(), 10);
    var maxVal = parseInt($max.val(), 10);
    var bothHaveValues = !isNaN(minVal) && !isNaN(maxVal);
    if (bothHaveValues) {
      if (minVal > maxVal) {
        alert("Minimum price should be less than maximum");
        jQuery($this + " option").prop("selected", false);
      } else if (maxVal < minVal) {
        alert("Maximum price should be greater than minimum");
        jQuery($this + " option").prop("selected", false);
      }
    }
  });
  jQuery(".masonry-dropbtn").click(function () {
    jQuery(".button-group").slideToggle();
    jQuery(".masonry-dropbtn").toggleClass("active");
  });

  jQuery(
    ".the-journal.journallist-section .masonry .button-group .button"
  ).click(function () {
    var btntext = jQuery(this).text();
    jQuery(".masonry-dropbtn").text(btntext);
    jQuery(".button-group").slideUp();
  });

  jQuery("#get_in_touch").click(function () {
    jQuery("html,body").animate(
      {
        scrollTop: jQuery(".contactform-section").offset().top,
      },
      1500
    );
  });
});
if (window.location.href == ast_var.valuation_url) {
  jQuery(document).ready(function () {
    var right_value = jQuery(".valuation-fullrow .container").offset().left;
    right_value = right_value + 30;
    jQuery(".valuation-formcol").css("margin-left", "-" + right_value + "px");
    jQuery(".valuation-formcol").css("padding-left", right_value + "px");

    jQuery(".property_style .wpcf7-list-item").each(function (n) {
      jQuery(this).addClass("radio-col");
      jQuery(this)
        .children("span")
        .wrap("<label for='one'" + n + "></label>");
      // alert(jQuery(this).children('span').attr("class"));
    });
    jQuery(".property_conduct .wpcf7-list-item").each(function (n) {
      jQuery(this).addClass("radio-col");
      jQuery(this)
        .children("span")
        .wrap("<label for='one'" + n + "></label>");
      // alert(jQuery(this).children('span').attr("class"));
    });
  });
  jQuery(window).resize(function () {
    var right_value = jQuery(".valuation-fullrow .container").offset().left;
    right_value = right_value + 30;
    jQuery(".valuation-formcol").css("margin-left", "-" + right_value + "px");
    jQuery(".valuation-formcol").css("padding-left", right_value + "px");
  });

  jQuery(window).scroll(function () {
    if (jQuery(window).width() > 767) {
      var scroll_value = jQuery(window).scrollTop();
      var bg_offset_value1 = jQuery(".review-section").offset().top;
      if (
        jQuery(".review-section .review-content .review-rightimg").length > 0
      ) {
        var translate_value =
          ((bg_offset_value1 - scroll_value) / jQuery(window).height()) * 20;
        jQuery(".review-section .review-content .review-rightimg").css({
          transform: "translateY(" + translate_value + "%)" + "translateZ(0px)",
        });
      }
    }
  });
}
if (ast_var.single_areas == 1) {
  jQuery(document).ready(function () {
    var right_value = jQuery(".content-section .container").offset().left;
    right_value = right_value + 30;
    jQuery(".content-fullcolumn").css("margin-left", "-" + right_value + "px");
    jQuery(".content-fullcolumn").css("padding-left", right_value + "px");

    var right_values = jQuery(".content-section .container").offset().left;
    right_values = right_values + 45;
    jQuery(".image-col").css("margin-right", "-" + right_values + "px");
  });

  jQuery(window).resize(function () {
    var right_value = jQuery(".content-section .container").offset().left;
    right_value = right_value + 30;
    jQuery(".content-fullcolumn").css("margin-left", "-" + right_value + "px");
    jQuery(".content-fullcolumn").css("padding-left", right_value + "px");

    var right_values = jQuery(".content-section .container").offset().left;
    right_values = right_values + 45;
    jQuery(".image-col").css("margin-right", "-" + right_values + "px");
  });

  jQuery(window).scroll(function () {
    if (jQuery(window).width() > 767) {
      var scroll_value = jQuery(window).scrollTop();
      var bg_offset_value1 = jQuery(".content-section").offset().top;
      if (jQuery(".content-section .whitebg-row .rightimage").length > 0) {
        var translate_value =
          ((bg_offset_value1 - scroll_value) / jQuery(window).height()) * 20;
        jQuery(".content-section .whitebg-row .rightimage").css({
          transform: "translateY(" + translate_value + "%)" + "translateZ(0px)",
        });
      }
    }
  });
}
jQuery(window)
  .on("load", function () {
    eqheight();
  })
  .resize(function () {
    eqheight();
  });

function eqheight() {
  setTimeout(function () {
    equalheight(
      ".properties-row .savedproperties-col .properties-content .address"
    );
  }, 200);
}

equalheight = function (container) {
  if (jQuery(window).width() > 767) {
    var currentTallest = 0,
      currentRowStart = 0,
      rowDivs = [],
      $el,
      topPosition = 0;

    jQuery(container).each(function () {
      $el = jQuery(this);
      jQuery($el).height("auto");
      topPostion = $el.offset().top;
      if (currentRowStart !== topPostion) {
        for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
          rowDivs[currentDiv].innerHeight(currentTallest);
        }
        rowDivs.length = 0; // empty the array
        currentRowStart = topPostion;
        currentTallest = $el.innerHeight();
        rowDivs.push($el);
      } else {
        rowDivs.push($el);
        currentTallest =
          currentTallest < $el.innerHeight()
            ? $el.innerHeight()
            : currentTallest;
      }
      for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
        rowDivs[currentDiv].innerHeight(currentTallest);
      }
    });
  } else {
    jQuery(container).height("auto");
  }
};

/*--19-04-2021 Start--*/
jQuery(document).ready(function () {
  toggleQuickBox();
});

/*jQuery(window).on('load', function(){ 
  setTimeout(removeLoader, 2000); //wait for page load PLUS two seconds.
});
function removeLoader(){
    jQuery( "#loadingDiv" ).fadeOut(500, function() {
      // fadeOut complete. Remove the loading div
      jQuery( "#loadingDiv" ).remove(); //makes page more lightweight 
  });  
}*/

jQuery(window).load(function () {
  setTimeout(function () {
    // filter functions
    var filterFns = {
      // show if number is greater than 50
      numberGreaterThan50: function () {
        var number = jQuery(this).find(".number").text();
        return parseInt(number, 10) > 50;
      },
      // show if name ends with -ium
      ium: function () {
        var name = jQuery(this).find(".name").text();
        return name.match(/iumjQuery/);
      },
    };
    // bind filter button click

    // change is-checked class on buttons
    jQuery(".button-group").each(function (i, buttonGroup) {
      var $buttonGroup = jQuery(buttonGroup);
      $buttonGroup.on("click", "button", function () {
        $buttonGroup.find(".is-checked").removeClass("is-checked");
        jQuery(this).addClass("is-checked");
      });
    });
  }, 200);
});

/*share toggle*/
function toggleQuickBox() {
  jQuery(document).click(function (e) {
    if (jQuery(e.target).closest(".share-icon, .share-toggle").length == 0) {
      if (jQuery(".share-toggle").is(":visible")) {
        jQuery(".share-toggle").slideUp();
      }
    }
  });
  jQuery(".share-icon").click(function () {
    if (jQuery(this).next(".share-toggle").is(":visible")) {
      jQuery(this).next().slideUp();
    } else {
      jQuery(".share-toggle").slideUp();
      jQuery(this).next().slideDown();
    }
  });

  jQuery(".share-close").click(function () {
    jQuery(".share-toggle").slideUp();
  });
}

if (jQuery(".thankyou-banner").length) {
  var thankyoubanner_height = jQuery(window).height();
  jQuery(".thankyou-banner").css("height", thankyoubanner_height + "px");
}

jQuery(window).resize(function () {
  if (jQuery(".thankyou-banner").length) {
    var thankyoubanner_height = jQuery(window).height();
    jQuery(".thankyou-banner").css("height", thankyoubanner_height + "px");
  }
  if (jQuery(".error-banner").length) {
    var errorbanner_height = jQuery(window).height();
    jQuery(".error-banner").css("height", errorbanner_height + "px");
    //$(".error-banner .container").css("height", errorbanner_height + "px");
  }
});
function Copy() {
  var Url = document.getElementById("url");
  Url.value = window.location.href;
  Url.select();
  document.execCommand("copy");
}

/*--19-04-2021 End--*/

jQuery(window)
  .on("load", function () {
    eqheight();
  })
  .resize(function () {
    eqheight();
  });

function eqheight() {
  setTimeout(function () {
    equalheight(".the-journal .journal-block h3");
  }, 300);
}

equalheight = function (container) {
  if (jQuery(window).width() > 767) {
    var currentTallest = 0,
      currentRowStart = 0,
      rowDivs = new Array(),
      $el,
      topPosition = 0;
    jQuery(container).each(function () {
      $el = jQuery(this);
      jQuery($el).height("auto");
      topPostion = $el.offset().top;
      if (currentRowStart != topPostion) {
        for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
          rowDivs[currentDiv].innerHeight(currentTallest);
        }
        rowDivs.length = 0; // empty the array
        currentRowStart = topPostion;
        currentTallest = $el.innerHeight();
        rowDivs.push($el);
      } else {
        rowDivs.push($el);
        currentTallest =
          currentTallest < $el.innerHeight()
            ? $el.innerHeight()
            : currentTallest;
      }
      for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
        rowDivs[currentDiv].innerHeight(currentTallest);
      }
    });
  } else {
    jQuery(container).height("auto");
  }
};

jQuery(document).ready(function () {
  //filter
  var buy = jQuery(".filter-menu").find("label:nth-child(1) input#radio1");
  var rent = jQuery(".filter-menu").find("label:nth-child(2) input#radio2");
  // var isChecked = jQuery(buy).prop('checked');

  var inputd = jQuery(".search-filter").find(".filter-row .isl");
  jQuery(buy).on("click", function () {
    inputd.text("Recent Sales");
  });
  jQuery(rent).on("click", function () {
    inputd.text("Recently Let");
  });
});
