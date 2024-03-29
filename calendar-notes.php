<?php
/**
 * Plugin Name: Calendar Notes
 * Plugin URI:  https://github.com/wolfdevsllc/calendar-notes
 * Description: Easily add notes to your calendar
 * Version:     1.0.0
 * Author:      WolfDevs
 * Author URI:  https://wolfdevs.com
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Requires at least: 4.9
 * Requires PHP: 5.2.4
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define constants

define( 'CALENDAR_NOTES_VERSION', '1.0.0' );
define( 'CALENDAR_NOTES_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CALENDAR_NOTES_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Add Calendar Custom Post Type
require_once CALENDAR_NOTES_PLUGIN_DIR . 'includes/calendar-post-type.php';

// Check if ACF is installed, if not show admin notice and deactivate plugin
if ( ! class_exists( 'acf_pro' ) ) {
    add_action( 'admin_notices', 'calendar_notes_acf_notice' );
    function calendar_notes_acf_notice() {
        ?>
        <div class="notice notice-error is-dismissible">
            <p><?php _e( 'Calendar Notes requires Advanced Custom Fields Pro to be installed and activated.', 'calendar-notes' ); ?></p>
        </div>
        <?php
        deactivate_plugins( plugin_basename( __FILE__ ) );
    }
    return;
}

// Add Calendar Custom Fields
require_once CALENDAR_NOTES_PLUGIN_DIR . 'includes/calendar-custom-fields.php';

// Create Calendar Shortcode
require_once CALENDAR_NOTES_PLUGIN_DIR . 'includes/calendar-shortcode.php';

// Filter the post content of calendar notes
function calendar_notes_filter_content( $content ) {
    if ( is_singular( 'calendar' ) ) {
        $content = create_calendar( get_the_ID() );
    }
    return $content;
}

add_filter( 'the_content', 'calendar_notes_filter_content' );

// On plugin activation flush rewrite rules
function calendar_notes_rewrite_flush() {
    calendar_notes_register_post_type();
    flush_rewrite_rules();
}