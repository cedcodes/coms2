<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

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
$user_type = $_SESSION["usertype"];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['requirements'])) {

    if (!empty($_POST['requirements']) && ($_POST['requirements'] == "retrieve_file")) {

        $sql = "SELECT * FROM `tbl_requirements_list`";

        $result = mysqli_query($con, $sql);

        while ($row = mysqli_fetch_assoc($result)) {

            $request_result = array(
                "req_name" => $row['req_name'],
                "date_added" => $row['date_added'],
                "req_id" => $row['requirement_id']
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
    } else if (!empty($_POST['requirements']) && ($_POST['requirements'] == "new_file")) {

        $req_name = $_POST['req_name'];

        $sql = "INSERT INTO `tbl_requirements_list`(`req_name`) 
                             VALUES ('$req_name')";

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
    } else if (!empty($_POST['requirements']) && ($_POST['requirements'] == "delete_file")) {

        $req_id = $_POST['req_id'];

        $DeleteConcourse = "DELETE FROM `tbl_requirements_list` WHERE requirement_id = $req_id;";

        $SQLResult = $con->query($DeleteConcourse);

        if ($SQLResult) {

            $newConcourseResult = array(
                "code" => 200,
                "updateResult" => $SQLResult
            );

            array_push($request_data, $newConcourseResult);

            $newConcourseStatus = array(
                'status_code' => 200,
                'status_message' => 'Successfully Deleted'
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