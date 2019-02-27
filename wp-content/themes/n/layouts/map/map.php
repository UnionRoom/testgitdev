<?php
global $layout_count;

$location = get_sub_field('map');
$css_class = get_sub_field('css_class');
$gmaps_api_key = acf_get_setting('google_api_key');
$js_var = get_sub_field('js_var');
if( ! $js_var )
    $js_var = 'slider_' . $layout_count;

wp_enqueue_script( 'gmaps', 'https://maps.googleapis.com/maps/api/js?key=' . $gmaps_api_key, array(), '1.0', TRUE );

?>

<!-- Map -->
<section class="section section--map<?php echo ($css_class) ? ' ' . $css_class : ''; ?>">
    <div class="map map--standard" id="map_<?php echo $layout_count; ?>" data-latlng="<?php echo $location['lat']; ?>,<?php echo $location['lng']; ?>" data-js-var="<?php echo $js_var; ?>"></div>
</section>