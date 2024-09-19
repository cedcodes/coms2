<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include('../../../config/dbconnection/databaseconfig.php');

header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");

session_name("user_session");
session_start();

//
$notification = array();
$notifData = array();
$request_status = array();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['notif'])) {

    $user_id = $_SESSION["user_id"];

    if (!empty($_POST['notif']) && ($_POST['notif'] == "retrieve_notif")) {
        
        $result = mysqli_query(
            $con,
            "SELECT * FROM `tbl_notification` WHERE (user_id = $user_id OR notif_to_all = 1) AND is_shown = 1 ORDER BY date_added, is_read ASC;"
        );

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {

                $notifresult = array(
                    "id" => $row['notif_id'],
                    "notifheader" => $row['notif_title'],
                    "notifdetails" => $row['notif_details'],
                    "isRead" => $row['is_read'],
                    "notifType" => $row["notif_type"],
                    "notifDate" => $row['date_added']
                );
                array_push($notifData, $notifresult);
            }

            //
            $notifstatus = array(
                'status_code' => 200,
                'status_message' => 'Record Found!'
            );

            array_push($request_status, $notifstatus);

            $finalresponse = array(
                'notifData' => $notifData,
                'notifResponse' => $request_status
            );

            array_push($notification, $finalresponse);

            response($notification);
        } else {

            //
            $notifstatus = array(
                'status_code' => 404,
                'status_message' => 'No Record Found!'
            );

            array_push($request_status, $notifstatus);

            $finalresponse = array(
                'notifData' => null,
                'notifResponse' => $request_status
            );

            array_push($notification, $finalresponse);

            response($notification);
        }
    } 
    
    else if (!empty($_POST['notif']) && ($_POST['notif'] == "read_notif")) {
        $readType = $_POST['readType'];

        if ($readType == 0) {
            $notifID = $_POST['notifID'];
            $SetNotifIsRead = "UPDATE `tbl_notification` SET is_read = 1 WHERE notif_id = '$notifID'";
            $updateResult = $con->query($SetNotifIsRead);

            if ($updateResult) {

                $notifresult = array(
                    "code" => 200,
                    "updateResult" => $updateResult
                );

                array_push($notifData, $notifresult);

                $notifstatus = array(
                    'status_code' => 200,
                    'status_message' => $updateResult
                );

                array_push($request_status, $notifstatus);

                $finalresponse = array(
                    'notifData' => $notifData,
                    'notifResponse' => $request_status
                );

                array_push($notification, $finalresponse);

                response($notification);

            } else {
                $notifstatus = array(
                    'status_code' => 400,
                    'status_message' => 'Invalid Request!'
                );

                array_push($request_status, $notifstatus);

                $finalresponse = array(
                    'notifData' => null,
                    'notifResponse' => $request_status
                );

                array_push($notification, $finalresponse);

                response($notification);
            }
        }
        else{
            $SetNotifIsRead = "UPDATE `tbl_notification` SET is_read = 1 WHERE user_id = '$user_id'";
            $updateResult = $con->query($SetNotifIsRead);

            if ($updateResult) {

                $notifresult = array(
                    "code" => 200,
                    "updateResult" => $updateResult
                );

                array_push($notifData, $notifresult);

                $notifstatus = array(
                    'status_code' => 200,
                    'status_message' => $updateResult
                );

                array_push($request_status, $notifstatus);

                $finalresponse = array(
                    'notifData' => $notifData,
                    'notifResponse' => $request_status
                );

                array_push($notification, $finalresponse);

                response($notification);

            } else {
                $notifstatus = array(
                    'status_code' => 400,
                    'status_message' => 'Invalid Request!'
                );

                array_push($request_status, $notifstatus);

                $finalresponse = array(
                    'notifData' => null,
                    'notifResponse' => $request_status
                );

                array_push($notification, $finalresponse);

                response($notification);
            }
        }
    }

    else if (!empty($_POST['notif']) && ($_POST['notif'] == "remove_notif")) {
        $removeType = $_POST['$removeType'];

        if ($removeType == 0) {
            $notifID = $_POST['notifID'];
            $SetNotifIsRead = "UPDATE `tbl_notification` SET is_shown = 0, is_read = 1 WHERE notif_id = '$notifID'";
            $updateResult = $con->query($SetNotifIsRead);

            if ($updateResult) {

                $notifresult = array(
                    "code" => 200,
                    "updateResult" => $updateResult
                );

                array_push($notifData, $notifresult);

                $notifstatus = array(
                    'status_code' => 200,
                    'status_message' => $updateResult
                );

                array_push($request_status, $notifstatus);

                $finalresponse = array(
                    'notifData' => $notifData,
                    'notifResponse' => $request_status
                );

                array_push($notification, $finalresponse);

                response($notification);

            } else {
                $notifstatus = array(
                    'status_code' => 400,
                    'status_message' => 'Invalid Request!'
                );

                array_push($request_status, $notifstatus);

                $finalresponse = array(
                    'notifData' => null,
                    'notifResponse' => $request_status
                );

                array_push($notification, $finalresponse);

                response($notification);
            }
        }
        else{
            $SetNotifIsRead = "UPDATE `tbl_notification` SET is_shown = 0, is_read = 1 WHERE user_id = '$user_id'";
            $updateResult = $con->query($SetNotifIsRead);

            if ($updateResult) {

                $notifresult = array(
                    "code" => 200,
                    "updateResult" => $updateResult
                );

                array_push($notifData, $notifresult);

                $notifstatus = array(
                    'status_code' => 200,
                    'status_message' => $updateResult
                );

                array_push($request_status, $notifstatus);

                $finalresponse = array(
                    'notifData' => $notifData,
                    'notifResponse' => $request_status
                );

                array_push($notification, $finalresponse);

                response($notification);

            } else {
                $notifstatus = array(
                    'status_code' => 400,
                    'status_message' => 'Invalid Request!'
                );

                array_push($request_status, $notifstatus);

                $finalresponse = array(
                    'notifData' => null,
                    'notifResponse' => $request_status
                );

                array_push($notification, $finalresponse);

                response($notification);
            }
        }
    }

} else {
    //
    $notifstatus = array(
        'status_code' => 400,
        'status_message' => 'Invalid Request!'
    );

    array_push($request_status, $notifstatus);

    $finalresponse = array(
        'notifData' => null,
        'notifResponse' => $request_status
    );

    array_push($notification, $finalresponse);

    response($notification);

}

function response($dataresult)
{
    $json_response = json_encode($dataresult);
    echo $json_response;
}

?>