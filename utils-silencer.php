<?php
/**
 *  * Silencer
 *
 * @package       stutz-medien/utils-silencer
 * @author        Stutz Medien
 *
 * @wordpress-plugin
 * Plugin Name:   Silencer
 * Plugin URI:    https://github.com/Stutz-Medien/Silencer
 * Description:   Surpresses all comments on your WordPress site.
 * Version:       1.2.1
 * Author:        Stutz Medien
 * Author URI:    https://stutz-medien.ch/
 * Text Domain:   acf
 * Domain Path:   /lang
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SILENCER_VERSION', '1.2.1' );

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) :
	require_once __DIR__ . '/vendor/autoload.php';
endif;

if ( class_exists( 'Utils\\Plugins\\Silencer' ) ) :
	$silencer = new Utils\Plugins\Silencer();
	$silencer->register();
endif;
