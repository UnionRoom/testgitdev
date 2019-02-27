// Global namespace variable
var sitevars = {};

jQuery(document).ready(function ($) {

    $("html:first").removeClass("no-js");

    //Pagination AJAX
    var ajax_pagination_request = false;
    $('body').on('click touchend', '.ur-load-more-link', function (e) {
        if (ajax_pagination_request) {
            return;
        }else {
            e.preventDefault();
            var url = this.href;
            var pageNo = $(this).attr('data-current');
            var pageType = $(this).attr('data-page-type');
            var nextPage = $(this).attr('data-next');
            var ppp = $(this).attr('data-ppp');
            var hover_text = $(this).attr('data-js-hover');
            var button_text = $(this).text();

            $.ajax({
                type: 'post',
                url: '/wp-admin/admin-ajax.php',
                data: {
                    action: 'ur_load_more',
                    pageNo: pageNo,
                    ppp: ppp,
                    nextPage: nextPage,
                    pageType: pageType,
                },
                beforeSend: function () {
                    ajax_pagination_request = true;
                    $('.ur-load-more-link').text(hover_text);
                },
                success: function (response) {
                    $('.ur-load-more').remove();
                    $('.load-more-container').append(response);
                    $('.ur-load-more-link').text(button_text);
                    if ((history.pushState) && (url !== '')) {
                        history.pushState(null, null, url);
                    }
                    ajax_pagination_request = false;
                }
            });
        }
    });

    // #Testimonials #Slider
    if ($('.testimonials--standard').length) {
        $('.testimonials--standard').each(function () {
            var js_var = $(this).data('js-var');
            create_testimonials_standard('.testimonials--standard[data-js-var="' + js_var + '"]', js_var);
        });
    }

    // #Map
    if ($('.map--standard').length) {
        $('.map--standard').each(function () {
            var map_id = $(this).attr('id');
            var latlng = $(this).data('latlng').split(',');
            var js_var = $(this).data('js-var');

            create_map_standard(map_id, latlng, js_var);
        });
    }
});

function create_testimonials_standard(slider_class, slider_var) {
    var slider = $(slider_class).royalSlider({
        slidesSpacing: 0,
        sliderTouch: false,
        addActiveClass: true,
        arrowsNav: false,
        loop: true,
        arrowsNavAutoHide: false,
        controlNavigation: 'none',
        autoScaleSlider: false,
        imageScaleMode: 'none',
        imageAlignCenter: false,
        imageScalePadding: 0,
        autoHeight: true
    }).data('royalSlider');

    sitevars[slider_var] = slider;
}

function create_map_standard(map_id, latlng, map_var) {
    var myStyles = [{
        featureType: "poi",
        elementType: "labels",
        stylers: [{visibility: "off"}]
    }];

    var mapOptions = {
        zoom: 14,
        backgroundColor: '#eeeeee',
        center: new google.maps.LatLng(latlng[0], latlng[1]),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        styles: myStyles,
        panControl: false,
        streetViewControl: false,
        mapTypeControl: false,
        zoomControl: true,
        scrollwheel: false
    };
    var map = new google.maps.Map(document.getElementById(map_id), mapOptions);

    var image = {
        url: theme_url + '/img/marker.png', // url
    };

    var marker = new google.maps.Marker({
        map: map,
        position: new google.maps.LatLng(latlng[0], latlng[1]),
        icon: image
    });

    sitevars[map_var] = map;
}