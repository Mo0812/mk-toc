<?php
/**
 * Created by PhpStorm.
 * User: mkanzler
 * Date: 02.08.17
 * Time: 17:14
 */

function mk_toc_mce_scripts() {
    wp_enqueue_style('custom_tinymce_plugin', plugins_url( '../css/mk-toc-mce.css', __FILE__ ) );
}
add_action('admin_enqueue_scripts', 'mk_toc_mce_scripts');

function mk_toc_tinymce_add_button() {
    global $typenow;

    //todo: Posttypes ein- oder ausschließen.
    if(!in_array($typenow, array( 'post'))) {
        return;
    }

    add_filter( 'mce_external_plugins', 'mk_toc_tinymce_plugin' );
    add_filter( 'mce_buttons', 'mk_toc_tinymce_button' );
}
add_action( 'admin_head', 'mk_toc_tinymce_add_button' );

function mk_toc_tinymce_plugin( $plugin_array ) {

    $plugin_array['mk_toc'] = plugins_url( '../js/mk-toc-tinymce-button.js', __FILE__ );
    return $plugin_array;
}

function mk_toc_tinymce_button( $buttons ) {

    array_push( $buttons, 'mk_toc_sc_button_key' );
    return $buttons;
}