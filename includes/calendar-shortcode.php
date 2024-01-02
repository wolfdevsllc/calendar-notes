<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

function create_calendar( $atts ) {
    $atts = shortcode_atts( array(
        'year' => date('Y'),
        'calendar_id' => ''
    ), $atts, 'view-calendar' );

    $year = $atts['year'];
    $calendar_id = $atts['calendar_id'];

    ob_start();
    wp_enqueue_style( 'calendar-style', plugins_url( 'assets/css/calendar.css', dirname( __FILE__ ) ), array(), filemtime( plugin_dir_path( dirname( __FILE__ ) ) . 'assets/css/calendar.css' ) );
    $months = array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' );
    $month_count = count( $months );
    $calendar = '<div class="calendar-wrap">';
    for ( $i = 0; $i < $month_count; $i++ ) {
        $calendar .= '<div class="month-printable" id="month-printable-' . $i . '">';
        $calendar .= '<div class="month"><h2 class="month-name">' . $months[$i] . '</h2>';
        $calendar .= '<table class="calendar">';
        $calendar .= '<tr class="calendar-row">';
        $calendar .= '<td class="calendar-day-head">Sun</td>';
        $calendar .= '<td class="calendar-day-head">Mon</td>';
        $calendar .= '<td class="calendar-day-head">Tue</td>';
        $calendar .= '<td class="calendar-day-head">Wed</td>';
        $calendar .= '<td class="calendar-day-head">Thu</td>';
        $calendar .= '<td class="calendar-day-head">Fri</td>';
        $calendar .= '<td class="calendar-day-head">Sat</td>';
        $calendar .= '</tr>';
        $calendar .= '<tr class="calendar-row">';
        $day_count = 1;
        $days_in_month = date( 't', mktime( 0, 0, 0, $i + 1, 1, $year ) );
        for ( $j = 0; $j < $days_in_month; $j++ ) {
            $day_of_week = date( 'w', mktime( 0, 0, 0, $i + 1, $j + 1, $year ) );
            if ( $day_of_week == 0 ) {
                $calendar .= '</tr><tr class="calendar-row">';
            }

            if ( $day_of_week != 0 && $day_count <= 1 ) {
                for ( $k = 0; $k < $day_of_week; $k++ ) {
                    $calendar .= '<td class="calendar-day-np">&nbsp;</td>';
                }
            }

            // make date in YYYY-MM-DD format
            $date = date( 'Y-m-d', mktime( 0, 0, 0, $i + 1, $j + 1, $year ) );

            // today in YYYY-MM-DD format
            $today = date( 'Y-m-d', strtotime( 'today' ) );

            // get the notes
            $notes = get_field('calendar_notes', $calendar_id);
            $notes_for_the_day = '';
            if( $notes ) {
                foreach( $notes as $note ) {
                    if( $note['date'] == $date ) {
                        $notes_for_the_day .= '<li>' . $note['note'] . '</li>';
                    }
                }
            }

            if ( $today == $date ) {
                $calendar .= '<td class="calendar-day today ' . $day_of_week . ' ' . $j . '" style="background:var(--primary, #673AB7); color:#fff"><div class="date-content"><div class="date-text">' . ( $j + 1 ) . '</div>'. '<ul class="date-notes">' . $notes_for_the_day . '</ul>'. '</div></td>';
            } else {
                $calendar .= '<td class="calendar-day '.$day_of_week.' '. $j.'"><div class="date-content"><div class="date-text">' . ( $j + 1 ) . '</div><ul class="date-notes">'.$notes_for_the_day.'</ul></div></td>';
            }

            if ( $day_count == $days_in_month ) {
                // add empty cells to the end of the calendar
                $remaining_days = 6 - $day_of_week;
                for ( $l = 0; $l < $remaining_days; $l++ ) {
                    $calendar .= '<td class="calendar-day-np">&nbsp;</td>';
                }
            }

            $day_count++;
        }
        $calendar .= '</tr>';
        $calendar .= '</table></div>';
        $calendar .= '<button class="print-button" onclick="printMonth(' . $i . ')">Print this month</button>';
        $calendar .= '</div>';
    }

    echo $calendar. '</div>';
    $calendar_print_css = plugins_url( 'assets/css/calendar-print.css', dirname( __FILE__ ) ). '?v=' . filemtime( plugin_dir_path( dirname( __FILE__ ) ) . 'assets/css/calendar-print.css' );
    echo '<script>
        function printMonth(monthIndex) {
            var monthPrintable = document.getElementById("month-printable-" + monthIndex);
            var printWindow = window.open("", "_blank");
            printWindow.document.write("<html><head><title>Print calendar</title>");
            var linkElement = printWindow.document.createElement("link");
            linkElement.setAttribute("rel", "stylesheet");
            linkElement.setAttribute("type", "text/css");
            linkElement.setAttribute("href", "'. $calendar_print_css .'");
            linkElement.onload = function() {
                printWindow.document.write("</head><body>");
                printWindow.document.write(monthPrintable.innerHTML);
                printWindow.document.write("</body></html>");
                printWindow.document.close();
                printWindow.print();
            }
            printWindow.document.head.appendChild(linkElement);
        }
        </script>';

    return ob_get_clean();
}

add_shortcode( 'view-calendar', 'create_calendar' );