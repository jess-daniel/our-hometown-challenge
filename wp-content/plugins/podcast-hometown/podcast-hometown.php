 <?php
/**
 * Plugin Name:       Podcast Hometown
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Podcast data scraper
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Michael J. Daniel
 * Author URI:        https://michaeljdaniel.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

if(!defined('ABSPATH')) {
    exit;
}

// load scripts
require_once(plugin_dir_path(__FILE__).'includes/podcast-scripts.php');

// load class
require_once(plugin_dir_path(__FILE__).'includes/podcast-class.php');

// register widget
function register_podcast(){
    register_widget('Podcast_Widget');
}

add_action('widgets_init', 'register_podcast');
