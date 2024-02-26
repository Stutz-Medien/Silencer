<?php
/**
 * WordPress Theme Feature: Silencer
 *
 * @since   1.0
 * @package stutz-medien/utils-silencer
 * @link    https://github.com/Stutz-Medien/andromeda-pro-extension
 * @license https://www.gnu.org/licenses/gpl-3.0 GPL-3.0
 */

namespace Utils\Plugins;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Silencer {

	public function register() {
		add_action( 'admin_init', [ $this, 'disable_comments_post_types_support' ] );
		add_filter( 'comments_open', [ $this, 'disable_comments_status' ], 20, 2 );
		add_filter( 'pings_open', [ $this, 'disable_comments_status' ], 20, 2 );
		add_filter( 'comments_array', [ $this, 'disable_comments_hide_existing_comments' ], 10, 2 );
		add_action( 'admin_menu', [ $this, 'disable_comments_admin_menu' ] );
		add_action( 'admin_init', [ $this, 'disable_comments_admin_menu_redirect' ] );
		add_action( 'admin_init', [ $this, 'disable_comments_dashboard' ] );
		add_action( 'wp_before_admin_bar_render', [ $this, 'disable_comments_admin_bar' ] );
	}

	public function disable_comments_post_types_support() {
		$post_types = get_post_types();

		foreach ( $post_types as $post_type ) {
			if ( post_type_supports( $post_type, 'comments' ) ) {
				remove_post_type_support( $post_type, 'comments' );
				remove_post_type_support( $post_type, 'trackbacks' );
			}
		}
	}

	public function disable_comments_status() {
		return false;
	}

	public function disable_comments_hide_existing_comments( $comments ) {
		$comments = array();
		return $comments;
	}

	public function disable_comments_admin_menu() {
		remove_menu_page( 'edit-comments.php' );
	}

	public function disable_comments_admin_menu_redirect() {
		global $pagenow;
		if ( 'edit-comments.php' === $pagenow ) {
			wp_safe_redirect( admin_url() );
			exit;
		}
	}

	public function disable_comments_dashboard() {
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	}

	public function disable_comments_admin_bar() {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu( 'comments' );
	}
}
