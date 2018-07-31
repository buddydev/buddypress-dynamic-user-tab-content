<?php
/**
 * Dynamic User Tab Shortcode
 *
 * @package    BuddyPres Dynamic User Tab Content
 * @copyright  Copyright (c) 2018, Brajesh Singh
 * @license    https://www.gnu.org/licenses/gpl.html GNU Public License
 * @author     Brajesh Singh
 * @since      1.0.0
 */

// Do not allow direct access over web.
defined( 'ABSPATH' ) || exit;

/**
 * Shortcode.
 */
class BP_Dynamic_User_Tab_Content_Shortcode {
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
		add_shortcode( 'bp_dynamic_user_tab_content', array( $this, 'shortcode' ) );
	}

	/**
	 * Shortcode
	 *
	 * @param array  $atts shortcode attributes.
	 * @param string $content In our case, it won't have any value.
	 *
	 * @return string
	 */
	public function shortcode( $atts, $content = '' ) {

		$atts = shortcode_atts( array(
			'user_id' => bp_displayed_user_id(),
			'type'    => '',
		), $atts );
		$type = isset( $atts['type'] ) ? $atts['type'] : '';

		// type and user id must be specified.
		if ( empty( $type ) || empty( $atts['user_id'] ) ) {
			return $content;
		}
		// should we check if the user exists? let us leave it for now.
		// Query content.
		$query = new WP_Query( array(
			'author'                 => $atts['user_id'],
			'post_type'              => bp_dynamic_user_tab_content_get_post_type(),
			'tax_query'              => array(
				array(
					'taxonomy' => bp_dynamic_user_tab_content_get_taxonomy(),
					'field'    => 'slug',
					'terms'    => $type,
				),
			),
			'posts_per_page'         => 1,
			'update_post_term_cache' => false,
		) );

		$post_content = '';

		if ( $query->have_posts() ) {
			$query->the_post();
			$post = get_post( get_the_ID() );

			$post_content = apply_filters( 'the_content', $post->post_content, $post->ID );
			wp_reset_postdata();
		}

		return $post_content;
	}
}

BP_Dynamic_User_Tab_Content_Shortcode::boot();
