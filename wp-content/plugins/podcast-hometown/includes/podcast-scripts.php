<?php

// add scripts
function add_scripts() {
    // add css file
    wp_enqueue_style('main-style', plugins_url(). '/podcast-hometown/css/style.css');
    // add js file
    // wp_enqueue_script('main-script', plugins_url(). '/podcast-hometown/js/index.js');
}

add_action('wp_enqueue_scripts', 'add_scripts');