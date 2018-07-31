<?php
/**
 * Admin Metabox.
 *
 * @package    BuddyPress Dynamic User Tab Content
 * @copyright  Copyright (c) 2018, Brajesh Singh
 * @license    https://www.gnu.org/licenses/gpl.html GNU Public License
 * @author     Brajesh Singh
 * @since      1.0.0
 */

// Do not allow direct access over web.
defined( 'ABSPATH' ) || exit;

/**
 * Helps with admin.
 */
class BP_Dynamic_User_Tab_Content_Admin_Helper {

	/**
	 * Boot the class.
	 */
	public static function boot() {
		$self = new self();
		$self->setup();
	}

	/**
	 * Setup hooks.
	 */
	private function setup() {
		add_action( 'add_meta_boxes', array( $this, 'register_meta_boxes' ), 10, 2 );
	}

	/**
	 * Register shortcode metabox.
	 *
	 * @param string  $post_type post type.
	 * @param WP_Post $post post object.
	 */
	public function register_meta_boxes( $post_type, $post ) {

		$tab_post_type = bp_dynamic_user_tab_content_get_post_type();
		if ( $tab_post_type != $post_type ) {
			return;
		}

		// Author Override.
		add_meta_box( 'authordiv', __( 'Author', 'buddypress-dynamic-user-tab-content' ), array(
			$this,
			'author_metabox_override',
		), $tab_post_type, 'normal', 'high' );

		// shortcode info.
		add_meta_box( 'bp-dynamic-user-tab-content-shortcode', __( 'Tab Info', 'buddypress-dynamic-user-tab-content' ), array(
			$this,
			'display_tab_info',
		), $tab_post_type, 'advanced', 'high' );

	}

	/**
	 * Author Metbox override to list all users.
	 *
	 * @param WP_Post $post post object.
	 */
	public function author_metabox_override( $post ) {
		?>
        <label class="screen-reader-text" for="post_author_override"><?php _e( 'Author', 'buddypress-dynamic-user-tab-content' ); ?></label>
		<?php
		wp_dropdown_users( array(
			'name'             => 'post_author_override',
			'selected'         => empty( $post->ID ) ? 0 : $post->post_author,
			'include_selected' => true,
		) );
	}

	/**
	 * Display Metabox.
	 *
	 * @param WP_Post $post post object.
	 */
	public function display_tab_info( $post ) {
		$tax   = bp_dynamic_user_tab_content_get_taxonomy();
		$terms = get_the_terms( $post, $tax );

		if ( empty( $terms ) ) :?>
            <div class="bp-dynamic-user-tab-content-notice">
                <p><?php _e( 'Please make sure to assign a content type to the post.', 'buddypress-dynamic-user-tab-content' ); ?></p>
            </div>
		<?php else :
			$term = array_pop( $terms )
			?>
            <div class="bp-dynamic-user-tab-content-info">
                <p><?php _e( "This post will be visible on a user's profile when the following shortcode is used.", 'buddypress-dynamic-user-tab-content' ); ?></p>
            </div>
            <div class="bp-dynamic-user-tab-content-shortcode-text">
                <span>[bp_dynamic_user_tab_content type="<?php echo $term->slug ?>"]</span>
            </div>
		<?php endif; ?>
        <style type="text/css">

            .bp-dynamic-user-tab-content-notice {
                background: #925640;
                color: #fff;
                padding: 10px;
            }

            .bp-dynamic-user-tab-content-notice p {

            }

            .bp-dynamic-user-tab-content-shortcode-text {
                padding: 10px;
                background: #FFBC39;
            }

            .bp-dynamic-user-tab-content-shortcode-text span {
            }
        </style>
		<?php
	}


}

BP_Dynamic_User_Tab_Content_Admin_Helper::boot();
