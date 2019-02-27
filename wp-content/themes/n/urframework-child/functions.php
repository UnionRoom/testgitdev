<?php

// Set gmaps key - default is urdev.co.uk key
function urframework_acf_init_child() {
    acf_update_setting('google_api_key', 'AIzaSyATr_lTvLb_tflJIK9hOSK8nMSbkmtzMVE');
}
add_action('acf/init', 'urframework_acf_init_child');