<?php
// error_reporting(E_ALL);
// ini_set("display_errors", 1);

session_name("user_session");
session_start();

include('../../config/dbconnection/databaseconfig.php');

header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");

//
$response_data = array();
$request_data = array();
$request_status = array();
$user_id = $_SESSION["user_id"];
$usertype = $_SESSION["usertype"];


if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['space_action'])) {
    $con_id = $_POST['con_id'];

    if (!empty($_POST['space_action']) && ($_POST['space_action'] == "new_space")) {

        $space_action = $_POST['space_action'];
        $owner_id = $user_id;
        $coordx = $_POST['coordx'];
        $coordx2 = $_POST['coordx2'];
        $coordy = $_POST['coordy'];
        $coordy2 = $_POST['coordy2'];
        $spacename = $_POST['spacename'];
        $spaceprice = $_POST['spaceprice'];
        $spacewidth = $_POST['spacewidth'];
        $spacelength = $_POST['spacelength'];


        $sql = "INSERT INTO `tbl_spaces`(`con_id`, `owner_id`, `space_name`, `space_width`, `space_length`, `space_coord_x`, `space_coord_y`, `space_coord_x2`, `space_coord_y2`, `space_price`) 
                VALUES ($con_id, $owner_id, '$spacename', $spacewidth, $spacelength, $coordx, $coordy, $coordx2, $coordy2, $spaceprice);";

        $SQLResult = $con->query($sql);

        if ($SQLResult) {
            $newConcourseResult = array(
                "code" => 200,
                "updateResult" => $SQLResult
            );

            array_push($request_data, $newConcourseResult);

            $newConcourseStatus = array(
                'status_code' => 200,
                'status_message' => 'Successfully Added'
            );

            array_push($request_status, $newConcourseStatus);

            $finalresponse = array(
                'request_data' => $request_data,
                'request_status' => $request_status
            );

            array_push($response_data, $finalresponse);

            response($response_data);

        } else {
            $newConcourseStatus = array(
                'status_code' => 400,
                'status_message' => 'Invalid Request!'
            );

            array_push($request_status, $newConcourseStatus);

            $finalresponse = array(
                'request_data' => null,
                'request_status' => $request_status
            );

            array_push($response_data, $finalresponse);

            response($response_data);
        }
    } else if (!empty($_POST['space_action']) && ($_POST['space_action'] == "retrieve_space")) {


        $sql = "SELECT * FROM `tbl_spaces` a left join tbl_user b on a.tenant_id=b.user_id WHERE con_id = $con_id;";

        $result = mysqli_query($con, $sql);

        while ($row = mysqli_fetch_assoc($result)) {

            $request_result = array(
                "space_id" => $row['space_id'],
                "con_id" => $row['con_id'],
                "tenant_id" => $row['tenant_id'],
                "tenant_name" => $row['first_name'] . ' ' .  $row['last_name'] == ' ' ? 'None' : $row['first_name'] . ' ' .  $row['last_name'] ,
                "owner_id" => $row['owner_id'],
                "owner_first_name" => $row['first_name'],
                "owner_email" => $row['email'],
                "space_name" => $row['space_name'],
                "space_status" => $row["status"],
                "space_width" => $row["space_width"],
                "space_length" => $row["space_length"],
                "space_area" => $row['space_area'],
                "space_dimension" => $row['space_dimension'],
                "space_coord_x" => $row['space_coord_x'],
                "space_coord_y" => $row['space_coord_y'],
                "space_coord_x2" => $row['space_coord_x2'],
                "space_coord_y2" => $row['space_coord_y2'],
                "space_price" => $row['space_price']
            );
            array_push($request_data, $request_result);
        }

        if (mysqli_num_rows($result) > 0) {

            //
            $request_status_code = array(
                'status_code' => 200,
                'status_message' => 'Record Found!'
            );

            array_push($request_status, $request_status_code);

            $finalresponse = array(
                'request_data' => $request_data,
                'request_status' => $request_status
            );

            array_push($response_data, $finalresponse);

            response($response_data);
        } else {

            //
            $request_status_code = array(
                'status_code' => 404,
                'status_message' => 'No Record Found!'
            );

            array_push($request_status, $request_status_code);

            $finalresponse = array(
                'request_data' => $request_data,
                'request_status' => $request_status
            );

            array_push($response_data, $finalresponse);

            response($response_data);
        }
    } else if (!empty($_POST['space_action']) && ($_POST['space_action'] == "retrieve_conlayout")) {

        $sql = "SELECT * FROM `tbl_concourse` WHERE con_id = $con_id LIMIT 1;";

        $result = mysqli_query($con, $sql);

        while ($row = mysqli_fetch_assoc($result)) {

            $request_result = array(
                "con_layout" => $row['con_layout'],
                "con_rate" => $row['con_rate'],
            );
            array_push($request_data, $request_result);
        }

        if (mysqli_num_rows($result) > 0) {

            //
            $request_status_code = array(
                'status_code' => 200,
                'status_message' => 'Record Found!'
            );

            array_push($request_status, $request_status_code);

            $finalresponse = array(
                'request_data' => $request_data,
                'request_status' => $request_status
            );

            array_push($response_data, $finalresponse);

            response($response_data);
        } else {

            //
            $request_status_code = array(
                'status_code' => 404,
                'status_message' => 'No Record Found!'
            );

            array_push($request_status, $request_status_code);

            $finalresponse = array(
                'request_data' => $request_data,
                'request_status' => $request_status
            );

            array_push($response_data, $finalresponse);

            response($response_data);
        }
    } else if (!empty($_POST['space_action']) && ($_POST['space_action'] == "submit_application")) {

        $space_id = $_POST['space_id'];
        $leaseTerms = $_POST['leaseTerms'];
        $application_type = $_POST['application_type'];
        $applicant_remarks = $_POST['applicant_remarks'];


        $sql = "INSERT INTO `tbl_tenant_application` (`tenant_id`, `con_id`, `space_id`, `owner_id`, `lease_terms`, `applicant_remarks`, `application_type`, `date_added`)
                VALUES ('$user_id', '$con_id', '$space_id', '0', '$leaseTerms', '$applicant_remarks', $application_type, current_timestamp());";
        $SQLResult = $con->query($sql);


        if ($SQLResult) {

            $sql = "SELECT * FROM `tbl_tenant_application` WHERE con_id = $con_id AND tenant_id = $user_id AND space_id = $space_id 
                    ORDER BY application_id DESC LIMIT 1;";

            $result = mysqli_query($con, $sql);

            while ($row = mysqli_fetch_assoc($result)) {

                $request_result = array(
                    "code" => 200,
                    "application_id" => $row['application_id']
                );
                array_push($request_data, $request_result);
            }

            $newConcourseStatus = array(
                'status_code' => 200,
                'status_message' => 'Successfully Added'
            );

            array_push($request_status, $newConcourseStatus);

            $finalresponse = array(
                'request_data' => $request_data,
                'request_status' => $request_status
            );

            array_push($response_data, $finalresponse);

            response($response_data);

        } else {
            $newConcourseStatus = array(
                'status_code' => 400,
                'status_message' => 'Invalid Request!'
            );

            array_push($request_status, $newConcourseStatus);

            $finalresponse = array(
                'request_data' => null,
                'request_status' => $request_status
            );

            array_push($response_data, $finalresponse);

            response($response_data);
        }
    } else if (!empty($_POST['space_action']) && ($_POST['space_action'] == "upload_requirements")) {

        $application_id = $_POST['application_id'];
        $requirement_id = $_POST['requirement_id'];
        $req_file = $_FILES['req_file'];
        $req_file_name = $req_file['name'];
        $req_file_tmp = $req_file['tmp_name'];
        $req_file_extension = pathinfo($req_file_name, PATHINFO_EXTENSION);
        $req_file_filename = uniqid("file") . '_app' . $application_id . '.' . $req_file_extension;

        $upload_req_file = $_FILES['req_file']['error'] === UPLOAD_ERR_OK ? UploadImage($req_file_filename, $req_file_tmp, "upload_requirements") : false;
        $upload_req_file = $upload_req_file ? "Upload Successfully" : "Failed to Upload";

        if ($upload_req_file != "Failed to Upload") {
            $sql = "INSERT INTO `tbl_requirements_file` (`requirement_id`, `application_id`, `file_name`, `status`, `date_added`)
            VALUES ('$requirement_id', '$application_id', '$req_file_filename', '0', current_timestamp());";
            $SQLResult = $con->query($sql);


            if ($SQLResult) {
                $newConcourseResult = array(
                    "code" => 200,
                    "updateResult" => $SQLResult
                );

                array_push($request_data, $newConcourseResult);

                $newConcourseStatus = array(
                    'status_code' => 200,
                    'status_message' => 'Successfully Added'
                );

                array_push($request_status, $newConcourseStatus);

                $finalresponse = array(
                    'request_data' => $request_data,
                    'request_status' => $request_status
                );

                array_push($response_data, $finalresponse);

                response($response_data);

            } else {
                $newConcourseStatus = array(
                    'status_code' => 400,
                    'status_message' => 'Invalid Request!'
                );

                array_push($request_status, $newConcourseStatus);

                $finalresponse = array(
                    'request_data' => null,
                    'request_status' => $request_status
                );

                array_push($response_data, $finalresponse);

                response($response_data);
            }
        } else {
            $newConcourseStatus = array(
                'status_code' => 400,
                'status_message' => 'Invalid Request!'
            );

            array_push($request_status, $newConcourseStatus);

            $finalresponse = array(
                'request_data' => null,
                'request_status' => $request_status
            );

            array_push($response_data, $finalresponse);

            response($response_data);
        }

    } else if (!empty($_POST['space_action']) && ($_POST['space_action'] == "view_space")) {

        $space_id = $_POST['space_id'];
        $sql = "SELECT A.*, CONCAT(B.first_name,' ',B.last_name) AS fullname FROM `tbl_spaces` A 
                INNER JOIN `tbl_user` B 
                ON A.owner_id = B.user_id
                WHERE A.con_id = $con_id AND A.space_id = $space_id;";

        $result = mysqli_query($con, $sql);

        while ($row = mysqli_fetch_assoc($result)) {

            $request_result = array(
                "space_id" => $row['space_id'],
                "con_id" => $row['con_id'],
                "tenant_id" => $row['tenant_id'],
                "owner_id" => $row['owner_id'],
                "owner_name" => $row['fullname'],
                "space_name" => $row['space_name'],
                "space_status" => $row["status"],
                "space_width" => $row["space_width"],
                "space_length" => $row["space_length"],
                "space_area" => $row['space_area'],
                "space_dimension" => $row['space_dimension'],
                "space_coord_x" => $row['space_coord_x'],
                "space_coord_y" => $row['space_coord_y'],
                "space_coord_x2" => $row['space_coord_x2'],
                "space_coord_y2" => $row['space_coord_y2'],
                "space_price" => $row['space_price']
            );
            array_push($request_data, $request_result);
        }

        if (mysqli_num_rows($result) > 0) {

            //
            $request_status_code = array(
                'status_code' => 200,
                'status_message' => 'Record Found!'
            );

            array_push($request_status, $request_status_code);

            $finalresponse = array(
                'request_data' => $request_data,
                'request_status' => $request_status
            );

            array_push($response_data, $finalresponse);

            response($response_data);
        } else {

            //
            $request_status_code = array(
                'status_code' => 404,
                'status_message' => 'No Record Found!'
            );

            array_push($request_status, $request_status_code);

            $finalresponse = array(
                'request_data' => $request_data,
                'request_status' => $request_status
            );

            array_push($response_data, $finalresponse);

            response($response_data);
        }
    } else if (!empty($_POST['space_action']) && ($_POST['space_action'] == "notify_me")) {

        $space_id = $_POST['space_id'];
        $con_id = $_POST['con_id'];


        $sql = "INSERT INTO `tbl_alert_notif`(`user_id`, `alert_message`, `space_id`, `con_id`, `alert_type`, `is_alerted`) 
                VALUES ($user_id, '', '$space_id', $con_id, 1, 0);";

        $SQLResult = $con->query($sql);

        if ($SQLResult) {
            $newConcourseResult = array(
                "code" => 200,
                "updateResult" => $SQLResult
            );

            array_push($request_data, $newConcourseResult);

            $newConcourseStatus = array(
                'status_code' => 200,
                'status_message' => 'Successfully Added'
            );

            array_push($request_status, $newConcourseStatus);

            $finalresponse = array(
                'request_data' => $request_data,
                'request_status' => $request_status
            );

            array_push($response_data, $finalresponse);

            response($response_data);

        } else {
            $newConcourseStatus = array(
                'status_code' => 400,
                'status_message' => 'Invalid Request!'
            );

            array_push($request_status, $newConcourseStatus);

            $finalresponse = array(
                'request_data' => null,
                'request_status' => $request_status
            );

            array_push($response_data, $finalresponse);

            response($response_data);
        }
    } else if (!empty($_POST['space_action']) && ($_POST['space_action'] == "delete_space")) {

        $space_id = $_POST['space_id'];

        $DeleteConcourse = "DELETE FROM `tbl_spaces` WHERE space_id = $space_id;";

        $SQLResult = $con->query($DeleteConcourse);

        if ($SQLResult) {

            $newConcourseResult = array(
                "code" => 200,
                "updateResult" => $SQLResult
            );

            array_push($request_data, $newConcourseResult);

            $newConcourseStatus = array(
                'status_code' => 200,
                'status_message' => 'Successfully Added'
            );

            array_push($request_status, $newConcourseStatus);

            $finalresponse = array(
                'request_data' => $request_data,
                'request_status' => $request_status
            );

            array_push($response_data, $finalresponse);

            response($response_data);

        } else {
            $newConcourseStatus = array(
                'status_code' => 400,
                'status_message' => 'Invalid Request!'
            );

            array_push($request_status, $newConcourseStatus);

            $finalresponse = array(
                'request_data' => null,
                'request_status' => $request_status
            );

            array_push($response_data, $finalresponse);

            response($response_data);
        }
    }

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['requirements'])) {
    if (!empty($_POST['requirements']) && ($_POST['requirements'] == "get_req")) {

        $sql = "SELECT * FROM `tbl_requirements_list`";

        $result = mysqli_query($con, $sql);

        while ($row = mysqli_fetch_assoc($result)) {

            $request_result = array(
                "requirement_id" => $row['requirement_id'],
                "req_name" => $row['req_name']
            );
            array_push($request_data, $request_result);
        }

        if (mysqli_num_rows($result) > 0) {

            //
            $request_status_code = array(
                'status_code' => 200,
                'status_message' => 'Record Found!'
            );

            array_push($request_status, $request_status_code);

            $finalresponse = array(
                'request_data' => $request_data,
                'request_status' => $request_status
            );

            array_push($response_data, $finalresponse);

            response($response_data);
        } else {

            //
            $request_status_code = array(
                'status_code' => 404,
                'status_message' => 'No Record Found!'
            );

            array_push($request_status, $request_status_code);

            $finalresponse = array(
                'request_data' => $request_data,
                'request_status' => $request_status
            );

            array_push($response_data, $finalresponse);

            response($response_data);
        }
    }
}

function response($dataresult)
{
    $json_response = json_encode($dataresult);
    echo $json_response;
}

function UploadImage($image_filename, $image_tmp, $dir)
{
    $upload_directory = dirname(__DIR__, 2) . '/uploads/' . $dir . '/'; // Define your upload directory path
    $upload_path = $upload_directory . $image_filename;
    $upload_response = move_uploaded_file($image_tmp, $upload_path);

    return $upload_response;
}

?>