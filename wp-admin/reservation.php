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
if(empty($_REQUEST["json_strict"])){
    require_once( ABSPATH . 'wp-admin/admin-header.php' );
}

global $wpdb;   //global DB object
$wpdb->show_errors();
//$wpdb->hide_errors();

$page = 1;
$show_all = false;
if(!empty($_REQUEST["page"])) {
    $page = (int) $_REQUEST["page"];
}
if(!empty($_REQUEST["show_all"]) && $_REQUEST["show_all"]=="yes") {
    $show_all = true;
}
//build sql-query
$sql = "SELECT * FROM wp_reservations";
if ($show_all == false)
    $sql .= " where date >= CURDATE()";

$sql .= " order by date";   //order by

$results = $wpdb->get_results( $sql, OBJECT );
//print_r($results);

if(!empty($_REQUEST["json_strict"])) {
    exit(json_encode($results));
}
?>
<style>

</style>
    <div class="wrap">
        <div class="container">
            <h1>Reservations</h1>
            <a id="show_all" href="show_all=true" style="position: relative;float: right;top: -20px;">Show all Reservations</a>

            <table class="wp-list-table widefat fixed striped pages">
                <thead>
                    <tr>
                        <th class="manage-column" width="5%">#</th>
                        <th class="manage-column" width="18%">Name</th>
                        <th class="manage-column" width="23%">Email</th>
                        <th class="manage-column" width="14%">Date</th>
                        <th class="manage-column" width="8%">Time</th>
                        <th class="manage-column" width="8%">Party Size</th>
                        <th class="manage-column" width="12%">Action</th>
                    </tr>
                </thead>
                <tbody id="table_content">
                <?php
                $count = 1;
                    foreach ($results as $row) {
                        $date_f = new DateTime($row->date);
                        echo "<tr>
                                <td>".$count++."</td>
                                <td>".$row->name."</td>
                                <td>".$row->email."</td>
                                <td>".$date_f->format('D M j Y')."</td>
                                <td>".$row->time."</td>
                                <td>".$row->party_size."</td>
                                <td><a href='reservation.php?type=del&id=".$row->id."'><img src='images/delete-icon.png'></a></td>
                            </tr>";
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>

<script>
    (function($) {
        $(document).ready(function(){
            $(".container").on("click", "#show_all",function(e){
                e.preventDefault();
                var this_ref = $(this);
                if((this_ref.attr("href")) == "show_all=true"){
                    $.ajax({
                        url: "reservation.php",
                        method: "POST",
                        data: {
                            show_all : "yes",
                            json_strict: "yes"
                        },
                        dataType: "json"
                    }).done(function(data){
                        var output = "";
                        var counter = 1;
                        data.forEach(function(item, index){
//                            console.log("item",item);
                            var formatted_date = new Date(item.date);
                            output += "<tr>";
                            output += "<td>"+counter+"</td>";
                            output += "<td>"+item.name+"</td>";
                            output += "<td>"+item.email+"</td>";
                            output += "<td>"+formatted_date.toDateString()+"</td>";
                            output += "<td>"+item.time+"</td>";
                            output += "<td>"+item.party_size+"</td>";
                            output += "<td><a href='reservation.php?type=del&id="+item.id+"'><img src='images/delete-icon.png'></a></td>";
                            output += "</tr>";
                            counter++;
                        });
                        $("#table_content").html(output);
                        this_ref.attr("href", "show_all=false");
                        this_ref.text("Hide Past Reservations");
                    });
                } else if((this_ref.attr("href")) == "show_all=false"){
                    $.ajax({
                        url: "reservation.php",
                        method: "POST",
                        data: {
                            show_all : "no",
                            json_strict: "yes"
                        },
                        dataType: "json"
                    }).done(function(data){
                        var output = "";
                        var counter = 1;
                        data.forEach(function(item, index){
                            var formatted_date = new Date(item.date);
                            output += "<tr>";
                            output += "<td>"+counter+"</td>";
                            output += "<td>"+item.name+"</td>";
                            output += "<td>"+item.email+"</td>";
                            output += "<td>"+formatted_date.toDateString()+"</td>";
                            output += "<td>"+item.time+"</td>";
                            output += "<td>"+item.party_size+"</td>";
                            output += "<td><a href='reservation.php?type=del&id="+item.id+"'><img src='images/delete-icon.png'></a></td>";
                            output += "</tr>";
                            counter++;
                        });
                        $("#table_content").html(output);
                        this_ref.attr("href", "show_all=true");
                        this_ref.text("Show all Reservations");
                    });
                }
            });
        });
    })(jQuery)
</script>

<?php
include( ABSPATH . 'wp-admin/admin-footer.php' );
