<?php
/**
 * Plugin Name: MK Table of Contents Plugin
 * Plugin URI:
 * Description: Adds a TOC to a post via shortcode.
 * Version: 1.0
 * Author: Moritz Kanzler
 * Author URI: http://moritzkanzler.de
 * License: GPLv3
 */

function mk_toc_register_sources() {
    $topOffset = 120;
    $smooth = 0;

    wp_register_style('mk_toc_css', plugins_url('mk-toc.css', __FILE__));
    wp_register_script('mk_toc_js', plugins_url('mk-toc.js', __FILE__));

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

/**** TOC PLUGIN ****/
function mk_toc_shortcode() {
    global $post;
    $str = $post->post_content;
    $output = "";

    $dom = new DOMDocument();
    $dom->loadHTML($str);

    $header_raw_arr = array();
    array_push($header_raw_arr, $dom->getElementsByTagName('h2'));
    array_push($header_raw_arr, $dom->getElementsByTagName('h3'));
    array_push($header_raw_arr, $dom->getElementsByTagName('h4'));
    array_push($header_raw_arr, $dom->getElementsByTagName('h5'));

    $header_arr = array();
    foreach ($header_raw_arr as $header_list) {
        foreach($header_list as $header) {
            $header_arr[$header->getLineNo()] = $header;
            //$h_anchor = $header->appendChild($dom->createElement('a'));
            //$h_anchor->setAttributeNode(new DOMAttr('name', sanitize_key($header->nodeValue)));
        }
    }

    /*$changed_content = $dom->saveHTML();

    wp_update_post(array(
            'ID' => $post->ID,
            'post_content' => $changed_content
    ));*/

    ksort($header_arr);

    $output.='<ul class="mk-toc-list">';
    foreach($header_arr as $header) {
        $key = parseHeading($header->nodeValue);
        $output .= "<li><a href='#$key' class='mk-toc mk-toc-$header->nodeName'>$header->nodeValue</a></li>";

    }
    $output.='</ul>';


    return "TOC for ".$post->ID.'<br />'.$output;
}
add_shortcode('toc', 'mk_toc_shortcode');

function parseHeading($str) {
    $str = strtolower($str);
    $p_str = preg_replace('/[^a-z0-9\s]+/', '', $str);
    return preg_replace('/[_\s]/', '-', $p_str);
}