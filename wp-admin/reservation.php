<?php
/**
 * Created by PhpStorm.
 * User: niketpathak
 * Date: 31/07/16
 * Time: 01:42
 */

/** WordPress Administration Bootstrap */
require_once( dirname( __FILE__ ) . '/admin.php' );
/* left menu-Admin panel */
require_once( ABSPATH . 'wp-admin/admin-header.php' );

global $wpdb;   //global DB object
$wpdb->show_errors();
//$wpdb->hide_errors();

$results = $wpdb->get_results( 'SELECT * FROM wp_reservations', OBJECT );
//print_r($results);
?>
    <div class="wrap">
        <div class="container">
            <h1>Reservations</h1>

            <table class="wp-list-table widefat fixed striped pages">
                <thead>
                    <tr>
                        <th class="manage-column">#</th>
                        <th class="manage-column">Name</th>
                        <th class="manage-column">Email</th>
                        <th class="manage-column">Date</th>
                        <th class="manage-column">Time</th>
                        <th class="manage-column">Party Size</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $count = 1;
                    foreach ($results as $row) {
                        echo "<tr>
                                <td>".$count++."</td>
                                <td>".$row->name."</td>
                                <td>".$row->email."</td>
                                <td>".$row->date."</td>
                                <td>".$row->time."</td>
                                <td>".$row->party_size."</td>
                            </tr>";
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>

<?php
include( ABSPATH . 'wp-admin/admin-footer.php' );
