<?php
/*
Plugin Name: Divine Button Styles
Plugin URI:
Description: Plugin to set button styles with box shadows
Version: 1.0
Requires at least: 5.5
Requires PHP: 7.3
Author: Ilene Johnson
Author URI: https://ikjweb.com
License: GPLv2 or later
Text Domain: divine_button_styles


Divine Button Styles is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Divine Button Styles is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Divine Button Styles. If not, see {URI to Plugin License}.
 */


namespace DIVINE_buttons\main;

if (!defined('WPINC')) {
    die;
}



add_action('after_setup_theme', 'DIVINE_buttons\\main\\divine_register_block_styles');

function divine_register_block_styles()
{
    register_block_style(
        'core/button',
        array(
   'name'         => 'button-box-shadow',
   'label'        => __('Box Shadow Lower Right', 'divine_button_styles'),
 
)
    );
    register_block_style(
        'core/button',
        array(
   'name'         => 'button-box-shadow-ul',
   'label'        => __('Box Shadow Upper Left', 'divine_button_styles'),
 
)
    );
    register_block_style(
        'core/button',
        array(
   'name'         => 'button-box-shadow-blur',
   'label'        => __('Box Shadow Blur', 'divine_button_styles'),
 
)
    );
    register_block_style(
        'core/button',
        array(
   'name'         => 'button-box-shadow-blur-inside',
   'label'        => __('Box Shadow Blur Inside', 'divine_button_styles'),
 
)
    );
    register_block_style(
        'core/button',
        array(
   'name'         => 'button-box-shadow-blur-lr',
   'label'        => __('Box Shadow Blur Lower Right', 'divine_button_styles'),
 
)
    );
    register_block_style(
        'core/button',
        array(
   'name'         => 'button-box-shadow-bottom-shadow',
   'label'        => __('Box Shadow Bottom Shadow', 'divine_button_styles'),
 
)
    );
}

add_action('enqueue_block_editor_assets', 'DIVINE_buttons\\main\\register_editor_assets', 100);

function register_editor_assets()
{
    wp_enqueue_style(
        'my-editor',
        plugin_dir_url(__FILE__) . 'divine-style.css',
        [ 'wp-edit-blocks' ],
        ''
    );
}

add_action('wp_enqueue_scripts', 'DIVINE_buttons\\main\\register_front_assets', 99);

function register_front_assets()
{
    wp_enqueue_style('my-style', plugin_dir_url(__FILE__) . 'divine-style.css', []);
}
add_action('wp_head', 'DIVINE_buttons\\main\\output_gutenberg_palette');
add_action('admin_head', 'DIVINE_buttons\\main\\output_gutenberg_palette');

function output_gutenberg_palette()
{
    // abort if in Admin but not inside Gutenberg editor
    if (is_admin()) {
        global $current_screen;
        $in_editor = method_exists($current_screen, 'is_block_editor') &&
      $current_screen->is_block_editor();
        if (!$in_editor) {
            return;
        }
    }

    $palette = get_theme_support('editor-color-palette');
    if (!$palette) {
        return;
    } // abort if no palette
   
    // format styles
    $styles = ":root .has-background { background-color: var(--bgColor); }
  :root .has-text-color { color: var(--textColor); } ";

    foreach ($palette[0] as $name => $value) {
        $slug = $value['slug'];
        $color = $value['color'];

        $styles .= ".has-{$slug}-background-color { --bgColor: {$color}; } ";
        $styles .= ".has-{$slug}-color { --textColor: {$color}; } ";
    }

    echo "<style> $styles </style>";
}
