<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class Calendar_Custom_Fields {
    public function add_repeater_field() {
        acf_add_local_field_group(array(
            'key' => 'group_5e9b3b3b3b3b3',
            'title' => 'Calendar Notes',
            'fields' => array(
                array(
                    'key' => 'field_5e9b3b3b3b3b1',
                    'label' => 'Calendar Notes',
                    'name' => 'calendar_notes',
                    'type' => 'repeater',
                    'instructions' => 'Add notes to the calendar',
                    'collapsed' => 'field_5e9b3b3b3b3b1',
                    'layout' => 'block',
                    'min' => 1,
                    'button_label' => 'Add Note',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_5e9b3b3b3b3b2',
                            'label' => 'Date',
                            'name' => 'date',
                            'type' => 'date_picker',
                            'required' => 1,
                            'display_format' => 'F j, Y',
                            'return_format' => 'Y-m-d',
                            'first_day' => 1,
                        ),
                        array(
                            'key' => 'field_5e9b3b3b3b3b3',
                            'label' => 'Note',
                            'name' => 'note',
                            'type' => 'textarea',
                            'required' => 1,
                            'rows' => 4,
                            'new_lines' => 'br',
                        ),
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'calendar',
                    ),
                ),
            ),
        ));
    }
}

$calendar_custom_fields = new Calendar_Custom_Fields();
$calendar_custom_fields->add_repeater_field();