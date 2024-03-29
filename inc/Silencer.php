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
		add_action( 'wp_before_admin_bar_render', [ $this, 'disable_comments_admin_bar' ] );
		add_action( 'init', [ $this, 'disable_comments_on_media_attachments' ] );
		add_action( 'admin_init', 'send_frame_options_header', 10, 0 );

		$hide_settings = get_option( 'hide_settings' );

		if ( '1' === $hide_settings ) {
			add_action( 'admin_menu', [ $this, 'disable_comments_admin_menu' ] );
			add_action( 'admin_init', [ $this, 'disable_comments_admin_menu_redirect' ] );
			add_action( 'wp_dashboard_setup', [ $this, 'disable_comments_dashboard' ] );
			add_action( 'admin_head', [ $this, 'hide_comments_from_activity_widget' ] );
		}

		add_action( 'admin_menu', [ $this, 'create_settings_page' ] );
		add_action( 'admin_init', [ $this, 'register_settings' ] );
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
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' ); // Recent Comments
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

	/**
	 * Hide comments options from dashboard
	 *
	 * @return void
	 */
	public function hide_comments_from_activity_widget() {
		echo '
		<style>
		.comment-count, #latest-comments {
			display: none;
		}

		#published-posts {
			border-bottom: none;
		}
		</style>
		';
	}

	/**
	 * Register settings page
	 *
	 * @return void
	 */
	public function create_settings_page() {
		add_submenu_page(
			'options-general.php',
			'Silencer Options',
			'Silencer',
			'manage_options',
			'silencer-options',
			array( $this, 'silencer_options_page' )
		);
	}

	/**
	 * Register settings
	 *
	 * @return void
	 */
	public function register_settings() {
		register_setting(
			'silencer-settings-group',
			'hide_settings',
			array(
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => 'none',
			)
		);
	}

	/**
	 * Create settings page
	 *
	 * @return void
	 */
	public function silencer_options_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$this->process_form();

		$this->display_form();
	}

	/**
	 * Process form
	 *
	 * @return void
	 */
	private function process_form() {
		if ( isset( $_POST['hide_settings'] ) ) {
			if ( ! check_admin_referer( 'update-options' ) ) {
				wp_die( 'Nonce verification failed' );
			}

			$hide_settings = isset( $_POST['hide_settings'] ) ? 1 : 0;
			update_option( 'hide_settings', $hide_settings );
		}
	}

	/**
	 * Display form
	 *
	 * @return void
	 */
	private function display_form() {
		echo '<div class="wrap">';
		echo '<h1>' . esc_html( get_admin_page_title() ) . '</h1>';
		echo '<form method="post" action="options.php">';
		wp_nonce_field( 'update-options' );

		settings_fields( 'silencer-settings-group' );

		do_settings_sections( 'silencer-options' );

		$hide_settings = get_option( 'hide_settings' );

		echo '<table class="form-table">';
		echo '<tr valign="top">';
		echo '<th scope="row">Hide Comment Options</th>';
		echo '<td><input type="checkbox" id="hide_settings" name="hide_settings" value="1" ' . checked( 1, $hide_settings, false ) . ' /></td>';
		echo '</tr>';
		echo '</table>';

		submit_button( 'Save Settings' );

		echo '</form>';
		echo '</div>';
	}
}
