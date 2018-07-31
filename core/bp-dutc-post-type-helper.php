<?php
/**
 * Content type registration.
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
 * Helps Registering Post type and taxonomy.
 */
class BP_Dynamic_User_Tab_Content_Post_Type_Helper {

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
		add_action( 'init', array( $this, 'register' ) );
	}

	/**
	 * Register post type and taxonomy.
	 */
	public function register() {

		$post_type = bp_dynamic_user_tab_content_get_post_type();
		$taxonomy  = bp_dynamic_user_tab_content_get_taxonomy();

		register_post_type( $post_type, array(
			'label'  => __( 'User Tab Content', 'buddypress-dynamic-user-tab-content' ),
			'labels' => array(
				'name'          => __( 'Tab Contents', 'buddypress-dynamic-user-tab-content' ),
				'singular_name' => __( 'Tab Content', 'buddypress-dynamic-user-tab-content' ),
				'menu_name'     => __( 'User Tab Content', 'buddypress-dynamic-user-tab-content' ),
				'all_items'     => __( 'Tab Contents', 'buddypress-dynamic-user-tab-content' ),
			),
			'public'        => false,
			'show_ui'       => true,
			'show_in_menu'  => true,
			'menu_position' => 70,
			'taxonomies'    => array( $taxonomy ),
			'supports'      => array( 'title', 'editor', 'author' ),
		) );


		register_taxonomy( $taxonomy, $post_type, array(
			'hierarchical'      => true,
			'labels'            => array(
				'name'              => _x( 'Type', 'taxonomy general name', 'buddypress-dynamic-user-tab-content' ),
				'singular_name'     => _x( 'Type', 'taxonomy singular name', 'buddypress-dynamic-user-tab-content' ),
				'search_items'      => __( 'Search Types', 'buddypress-dynamic-user-tab-content' ),
				'all_items'         => __( 'All types', 'buddypress-dynamic-user-tab-content' ),
				'parent_item'       => __( 'Parent type', 'buddypress-dynamic-user-tab-content' ),
				'parent_item_colon' => __( 'Parent Type:', 'buddypress-dynamic-user-tab-content' ),
				'edit_item'         => __( 'Edit Type', 'buddypress-dynamic-user-tab-content' ),
				'update_item'       => __( 'Update Type', 'buddypress-dynamic-user-tab-content' ),
				'add_new_item'      => __( 'Add New Type', 'buddypress-dynamic-user-tab-content' ),
				'new_item_name'     => __( 'New Type Name', 'buddypress-dynamic-user-tab-content' ),
				'menu_name'         => __( 'Type', 'buddypress-dynamic-user-tab-content' ),
			),
			'public'            => false,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => false,
		) );
	}
}

BP_Dynamic_User_Tab_Content_Post_Type_Helper::boot();
