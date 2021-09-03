<?php
/**
 * Plugin Name:       mytheme-blocks
 * Description:       Example block written with ESNext standard and JSX support – build step required.
 * Requires at least: 5.8
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       mytheme-blocks
 *
 * @package           create-block
 */


declare(strict_types=1);

if ( ! defined('ABSPATH') ) {
    exit;
}

function mytheme_blocks_categories( $categories, $post ){
    return array_merge(
        $categories, 
        array(
            array(
                'slug' => 'mytheme-category',
                'title'=> __('My Theme Category', 'mytheme-blocks'),
                'icon' => 'wordpress'
            )
        )
    );
}
add_filter('block_categories','mytheme_blocks_categories',10,2);

function mytheme_blocks_register_block_type(string $block, array $options = []): void 
{
    register_block_type(
        'mytheme-blocks/' . $block, 
        array_merge(
            [
                'editor_script' => 'mytheme-blocks-editor-script',
                'editor_style' => 'mytheme-blocks-editor-style',
                'script' => 'mytheme-blocks-script',
                'style' => 'mytheme-blocks-style'
            ], 
            $options
        )
    );
}


function mytheme_block_register(): void
{

    wp_register_script(
        'mytheme-blocks-editor-script',
        plugins_url(
            'dist/editor.js', 
            __FILE__
        ),
        [
            'wp-blocks',
            'wp-i18n',
            'wp-element',
            'wp-editor',
            'wp-components'
        ]
    );

    wp_register_script(
        'mytheme-blocks-script',
        plugins_url(
            'dist/script.js', 
            __FILE__
        ),
        ['jquery']
    );

    wp_register_style(
        'mytheme-blocks-editor-style',
        plugins_url(
            'dist/editor.css', 
            __FILE__
        ),
        [
            'wp-edit-blocks'
        ]
    );

    wp_register_style(
        'mytheme-blocks-style',
        plugins_url(
            'dist/style.css', 
            __FILE__
        ),
        []
    );

    mytheme_blocks_register_block_type('firstblock');
    mytheme_blocks_register_block_type('secondblock');

}

add_action('init', 'mytheme_block_register');