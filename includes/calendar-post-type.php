<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Calendar Post Type
 *
 * Registers the Calendar post type.
 *
 * @package Calendar Notes
 * @since 1.0.0
 */

/**
 * Register Calendar post type.
 *
 * @since 1.0.0
 */

function calendar_post_type() {
    $labels = array(
        'name'                => __( 'Calendar', 'calendar-notes' ),
        'singular_name'       => __( 'Calendar', 'calendar-notes' ),
        'menu_name'           => __( 'Calendar', 'calendar-notes' ),
        'parent_item_colon'   => __( 'Parent Calendar:', 'calendar-notes' ),
        'all_items'           => __( 'All Calendars', 'calendar-notes' ),
        'view_item'           => __( 'View Calendar', 'calendar-notes' ),
        'add_new_item'        => __( 'Add New Calendar', 'calendar-notes' ),
        'add_new'             => __( 'Add New', 'calendar-notes' ),
        'edit_item'           => __( 'Edit Calendar', 'calendar-notes' ),
        'update_item'         => __( 'Update Calendar', 'calendar-notes' ),
        'search_items'        => __( 'Search Calendars', 'calendar-notes' ),
        'not_found'           => __( 'Not found', 'calendar-notes' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'calendar-notes' ),
    );

    $args = array(
        'label'               => __( 'calendar', 'calendar-notes' ),
        'description'         => __( 'Calendar Notes', 'calendar-notes' ),
        'labels'              => $labels,
        'supports'            => array( 'title' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => false,
        'show_in_admin_bar'   => true,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-calendar-alt',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
    );

    register_post_type( 'calendar', $args );

}

add_action( 'init', 'calendar_post_type', 0 );
