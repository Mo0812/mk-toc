<?php
/**
 * Created by PhpStorm.
 * User: mkanzler
 * Date: 02.08.17
 * Time: 17:23
 */

function mk_toc_shortcode($args) {
    global $post;
    $output = '<nav class="mk-toc mk-toc-nav">';

    if(isset($args['title']) && is_string($args['title']) && $args['title'] != "") {
        $output .= '<p class="mk-toc mk-toc-heading">'.$args['title'].'</p>';
    } else if(get_option('mk_toc_default_heading', "") != "") {
        $output .= '<p class="mk-toc mk-toc-heading">'.get_option('mk_toc_default_heading').'</p>';
    }

    $level_begin = 0;
    if(isset($args['level_begin']) && $args['level_begin'] != "") {
        $level_begin = $args['level_begin'];
    }

    $level_end = 0;
    if(isset($args['level_end']) && $args['level_end'] != "") {
        $level_end = $args['level_end'];
    }

    if($level_end == 0) {
        $level_end = 5;
    } else if($level_begin > $level_end) {
        $level_end = $level_begin;
    }

    $output .= mk_toc_parse_post_content($post->post_content, $level_begin, $level_end);
    $output .= '</nav>';

    return $output;
}
add_shortcode('toc', 'mk_toc_shortcode');

function mk_toc_parse_post_content($str, $level_begin, $level_end) {
    $dom = new DOMDocument();
    $dom->loadHTML($str);

    $header_raw_arr = array();
    switch($level_begin) {
        case 0:
        case 1:
        case 2:
            array_push($header_raw_arr, $dom->getElementsByTagName('h2'));
            if($level_end == 2) {
                break;
            }
        case 3:
            array_push($header_raw_arr, $dom->getElementsByTagName('h3'));
            if($level_end == 3) {
                break;
            }
        case 4:
            array_push($header_raw_arr, $dom->getElementsByTagName('h4'));
            if($level_end == 4) {
                break;
            }
        case 5:
            array_push($header_raw_arr, $dom->getElementsByTagName('h5'));
            if($level_end == 5) {
                break;
            }
    }

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
        $output .= "<li><a href='#$key' class='mk-toc mk-toc-anchor-link mk-toc-$header->nodeName'>".utf8_decode($header->nodeValue)."</a></li>";

    }
    $output.='</ul>';

    return $output;
}

function parseHeading($str) {
    $str = strtolower($str);
    $p_str = preg_replace('/[^a-z0-9\s]+/', '', $str);
    return preg_replace('/[_\s]/', '-', $p_str);
}