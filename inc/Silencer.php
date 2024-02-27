<?php
/**
 * WordPress Theme Feature: Silencer
 *
 * @since   1.0
 * @package stutz-medien/utils-silencer
 * @link    https://github.com/Stutz-Medien/Silencer
 * @license MIT
 */

namespace Utils\Plugins;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Silencer {
	const COMMENT_PAGE = 'edit-comments.php';

	/**
	 * Register hooks
	 *
	 * @return void
	 */
	public function register() {
		add_action( 'admin_init', [ $this, 'disable_comments_post_types_support' ] );
		add_filter( 'comments_open', [ $this, 'disable_comments_status' ], 20, 2 );
		add_filter( 'pings_open', [ $this, 'disable_comments_status' ], 20, 2 );
		add_filter( 'comments_array', [ $this, 'disable_comments_hide_existing_comments' ], 10, 2 );
		add_action( 'admin_menu', [ $this, 'disable_comments_admin_menu' ] );
		add_action( 'admin_init', [ $this, 'disable_comments_admin_menu_redirect' ] );
		add_action( 'admin_init', [ $this, 'disable_comments_dashboard' ] );
		add_action( 'wp_before_admin_bar_render', [ $this, 'disable_comments_admin_bar' ] );
		add_action( 'init', [ $this, 'disable_comments_on_media_attachments' ] );
	}

	/**
	 * Removes support for comments and trackbacks from post types
	 *
	 * @return void
	 */
	public function disable_comments_post_types_support() {
		$post_types = get_post_types();

		foreach ( $post_types as $post_type ) {
			if ( post_type_supports( $post_type, 'comments' ) ) {
				remove_post_type_support( $post_type, 'comments' );
				remove_post_type_support( $post_type, 'trackbacks' );
			}
		}
	}

	/**
	 * Close comments on the front-end
	 *
	 * @return bool
	 */
	public function disable_comments_status() {
		return false;
	}

	/**
	 * Hide existing comments
	 *
	 * @return array
	 */
	public function disable_comments_hide_existing_comments( $comments ) {
		$comments = array();
		return $comments;
	}

	/**
	 * Removes comments page in menu
	 *
	 * @return void
	 */
	public function disable_comments_admin_menu() {
		remove_menu_page( self::COMMENT_PAGE );
	}

	/**
	 * Redirect any user trying to access comments page
	 *
	 * @return void
	 */
	public function disable_comments_admin_menu_redirect() {
		global $pagenow;
		if ( self::COMMENT_PAGE === $pagenow ) {
			wp_safe_redirect( admin_url() );
			exit;
		}
	}

	/**
	 * Removes comments metabox from dashboard
	 *
	 * @return void
	 */
	public function disable_comments_dashboard() {
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	}

	/**
	 * Removes comments links from admin bar
	 *
	 * @return void
	 */
	public function disable_comments_admin_bar() {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu( 'comments' );
	}

	/**
	 * Removes comments from media attachments
	 *
	 * @return void
	 */
	public function disable_comments_on_media_attachments() {
		add_filter(
			'comments_open',
			function ( $open, $post_id ) {
				$post = get_post( $post_id );
				if ( null === $post ) {
					return false;
				}

				if ( 'attachment' === $post->post_type ) {
					return false;
				}

				return $open;
			},
			10,
			2
		);
	}
}
