<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);


include('../../config/dbconnection/databaseconfig.php');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $sql = "SELECT A.*, C.first_name, B.space_name, B.status 
                    FROM `tbl_alert_notif` A 
                    INNER JOIN tbl_user C ON A.user_id = C.user_id 
                    LEFT JOIN tbl_spaces B ON A.space_id = B.space_id WHERE A.is_alerted = 0;";

    $result = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_assoc($result)) {

        if ($row['status'] == 0) {
            $vspaceName = $row['space_name'];
            $valertMessage = $row['alert_message'];
            $vuserid = $row['user_id'];
            $valertID = $row['alert_id'];

            $sql = "INSERT INTO tbl_notification(
                    user_id, 
                    notif_title, 
                    notif_details, 
                    date_added,
                    notif_type
                    )
                    VALUES(
                    $vuserid,
                    CONCAT('$vspaceName',' is now Available'),
                    '$valertMessage',
                    CURRENT_TIMESTAMP(), 1
                    );";

            $SQLResult = $con->query($sql);

            if ($SQLResult) {
                echo "Successfully Added" . $SQLResult;

                $sql2 = "UPDATE `tbl_alert_notif` SET is_alerted = 1 WHERE alert_id = $valertID;";
                $con->query($sql2);
            }
        }

        // $request_result = array(
        //     "space_id" => $row['space_id'],
        //     "con_id" => $row['con_id'],
        //     "tenant_id" => $row['tenant_id'],
        //     "owner_id" => $row['owner_id'],
        //     "space_name" => $row['space_name'],
        //     "space_status" => $row["status"],
        //     "space_width" => $row["space_width"],
        //     "space_length" => $row["space_length"],
        //     "space_area" => $row['space_area'],
        //     "space_dimension" => $row['space_dimension'],
        //     "space_coord_x" => $row['space_coord_x'],
        //     "space_coord_y" => $row['space_coord_y'],
        //     "space_coord_x2" => $row['space_coord_x2'],
        //     "space_coord_y2" => $row['space_coord_y2'],
        //     "space_price" => $row['space_price']
        // );
    }
}

?>