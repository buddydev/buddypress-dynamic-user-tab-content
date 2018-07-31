<?php
/**
 * Helper Functions.
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
 * Get the post type for Dynamic Tab.
 *
 * @return string
 */
function bp_dynamic_user_tab_content_get_post_type() {
	return 'bpdutc_content';
}

/**
 * Get the content type taxonomy name.
 *
 * @return string
 */
function bp_dynamic_user_tab_content_get_taxonomy() {
	return 'bpdutc_content_type';
}
