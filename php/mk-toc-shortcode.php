<?php
/**
 * Created by PhpStorm.
 * User: mkanzler
 * Date: 02.08.17
 * Time: 17:23
 */

function mk_toc_shortcode($args) {
    global $post;
    $output = "";

    if(isset($args['title']) && is_string($args['title']) && $args['title'] != "") {
        $output .= '<p class="mk-toc mk-toc-headline">'.$args['title'].'</p>';
    }

    $output.= mk_toc_parse_post_content($post->post_content);

    return $output;
}
add_shortcode('toc', 'mk_toc_shortcode');

function mk_toc_parse_post_content($str) {
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
        }
    }

    ksort($header_arr);

    $output='<ul class="mk-toc mk-toc-list">';
    foreach($header_arr as $header) {
        $key = parseHeading($header->nodeValue);
        $output .= "<li><a href='#$key' class='mk-toc mk-toc-$header->nodeName'>$header->nodeValue</a></li>";

    }
    $output.='</ul>';

    return $output;
}

function parseHeading($str) {
    $str = strtolower($str);
    $p_str = preg_replace('/[^a-z0-9\s]+/', '', $str);
    return preg_replace('/[_\s]/', '-', $p_str);
}