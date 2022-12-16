<?php
/**
 * Plugin Name:     Work With Us Plugin
 * Description:     Plugin di test per valutazione collaborazione con Il Post
 * Version:         0.1
 * Author:          Luigi Briganti, Il Post
 * License:         GPL-2.0-or-later
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:     wwup
 *
 * @package         wwup
 */

/**
 * Registers all block assets so that they can be enqueued through the block editor
 * in the corresponding context.
 *
 * @see https://developer.wordpress.org/block-editor/tutorials/block-tutorial/applying-styles-with-stylesheets/
 */

defined('ABSPATH') or die(__('Nice try', 'wwup'));
define('PLUGIN_FILE_URL', __FILE__);
define( 'PLUGIN_PATH', plugin_dir_path(__FILE__) );

$dir = dirname( __FILE__ );

add_action( 'init', 'wwup_plugin_textdomain' );

function wwup_plugin_textdomain(){
	load_plugin_textdomain('wwup', false, dirname( plugin_basename(__FILE__) ) .'/languages' );
}

/**
 * Scripts
 */

function admin_register_scripts(){
	wp_enqueue_style('mdi', 'https://cdn.jsdelivr.net/npm/@mdi/font@6.9.96/css/materialdesignicons.min.css');
    wp_enqueue_script( 'swal',  '//cdn.jsdelivr.net/npm/sweetalert2@11', array(), date('Ymd', time()), true );
    if($tinyMCE = get_option('wwup_tiny_mce_api_key')):
        wp_enqueue_script('tinyMCE', "//cdn.tiny.cloud/1/$tinyMCE/tinymce/6/tinymce.min.js", date('Ymd', time()), true);
    endif;
	wp_enqueue_script( 'wwup_scripts',  plugins_url('resources/js/scripts.js', __FILE__), array(), date('Ymd', time()), true );

    wp_localize_script(
		'wwup_scripts',
		'wwup',
		[
			'ajaxurl' => admin_url('admin-ajax.php'),
			'adminurl' => admin_url('admin.php'),
		]
	);
}

add_action('admin_enqueue_scripts', 'admin_register_scripts');

/**
 * Includes
 */

require_once plugin_dir_path( __FILE__ ) . 'includes/layouts/settings.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/actions/forms.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/actions/hooks.php';

function wwup_register_menu_page(){
    add_submenu_page(
        'options-general.php',
        __( 'Call to action', 'wwup' ),
        __('Call to action', 'wwup'),
        'administrator',
        'wwup-calltoaction',
        'wwup_layout',
        999
    );
}

add_action( 'admin_menu', 'wwup_register_menu_page');
