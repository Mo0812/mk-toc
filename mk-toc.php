<?php
/**
 * Plugin Name: MK Table of Contents Plugin (dev)
 * Plugin URI: http://blog.moritzkanzler.de/portfolio/mk-table-of-contents/
 * Description: Adds a TOC to a post via shortcode.
 * Version: 2.2
 * Author: Moritz Kanzler
 * Author URI: http://moritzkanzler.de
 * License: GPLv2 or later
 * Text Domain: mk_toc
 * Domain Path: /lang
 */

include("php/mk-toc-shortcode.php");
include("php/mk-toc-settings.php");
include("php/mk-toc-tinymce-addon.php");

function mk_toc_register_sources() {
    $topOffset = get_option( 'mk_toc_top_offset', 0);
    $smooth = get_option('mk_toc_smooth', 0);

    wp_register_style('mk_toc_css', plugins_url('css/mk-toc.css', __FILE__));
    wp_register_script('mk_toc_js', plugins_url('js/mk-toc.js', __FILE__));

    wp_localize_script('mk_toc_js', 'mk_toc_jsvar', array(
        'topOffset' => $topOffset,
        'smooth' => $smooth,
    ));
}
add_action('init', 'mk_toc_register_sources');

function mk_toc_enqueue_sources() {
    wp_enqueue_style('mk_toc_css');
    wp_enqueue_script('mk_toc_js');
}
add_action('wp_enqueue_scripts', 'mk_toc_enqueue_sources');

function mk_toc_load_plugin_textdomain() {
    load_plugin_textdomain( 'mk_toc', false, basename( dirname( __FILE__ ) ) . '/lang/' );
}
add_action( 'plugins_loaded', 'mk_toc_load_plugin_textdomain' );
