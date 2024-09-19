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
$user_type = $_SESSION["usertype"];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['concourse'])) {

    if (!empty($_POST['concourse']) && ($_POST['concourse'] == "new_concourse")) {

        $conLat = $_POST['conLat'];
        $conLong = $_POST['conLong'];

        $conAddress = $_POST['conAddress'];
        $conRate = $_POST['conRate'];
        $conName = $_POST['conName'];
        $owner_id = $user_id;

        $con_image_file = $_FILES['conImage'];
        $con_image_name = $con_image_file['name'];
        $con_image_tmp = $con_image_file['tmp_name'];
        $con_image_extension = pathinfo($con_image_name, PATHINFO_EXTENSION);
        $con_image_filename = uniqid("IMG_ConcourseImg_") . '.' . $con_image_extension;


        $con_layout_file = $_FILES['conLayout'];
        $con_layout_name = $con_layout_file['name'];
        $con_layout_tmp = $con_layout_file['tmp_name'];
        $con_layout_extension = pathinfo($con_layout_name, PATHINFO_EXTENSION);
        $con_layout_filename = uniqid("IMG_SpaceLayout_") . '.' . $con_layout_extension;

        $upload_conImg_res = $_FILES['conImage']['error'] === UPLOAD_ERR_OK ? UploadImage($con_image_filename, $con_image_tmp, "con_image") : false;
        $upload_conLayout_res = $_FILES['conLayout']['error'] === UPLOAD_ERR_OK ? UploadImage($con_layout_filename, $con_layout_tmp, "con_layout") : false;
        $upload_conImg_res = $upload_conImg_res ? "Upload Successfully" : "Failed to Upload";
        $upload_conLayout_res = $upload_conLayout_res ? "Upload Successfully" : "Failed to Upload";


        $AddNewConcourse = "INSERT INTO `tbl_concourse`(`owner_id`, `con_name`, `con_layout`, `con_image`, `con_lat`, `con_long`, `con_address`, `con_rate`) 
                            VALUES ('$owner_id','$conName','$con_layout_filename','$con_image_filename',$conLat,$conLong,'$conAddress', $conRate)";

        $AddNewConcourse2 = "INSERT INTO `tbl_concourse`(`owner_id`, `con_name`, `con_layout`, `con_image`, `con_address`, `con_rate`) 
                             VALUES ('$owner_id','$conName','$con_layout_filename','$con_image_filename','$conAddress', $conRate)";

        $sqlquery = $conLat == 0 && $conLong == 0 ? $AddNewConcourse2 : $AddNewConcourse;
        $SQLResult = $con->query($sqlquery);

        if ($SQLResult) {
            $newConcourseResult = array(
                "code" => 200,
                "updateResult" => $SQLResult,
                "uploadImage_con_name" => $upload_conImg_res,
                "uploadImage_lay_name" => $upload_conLayout_res,
                "uploadImage_con_tmp" => $con_image_tmp,
                "uploadImage_lay_tmp" => $con_layout_tmp,
                "uploadImage_con_file" => $con_image_file,
                "uploadImage_lay_file" => $con_layout_file
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
    } else if (!empty($_POST['concourse']) && ($_POST['concourse'] == "retrieve_concourse")) {


        $owner_id = $user_id;

        $sql_owner = "SELECT MAX(A.owner_id) AS 'owner_id', A.con_image, A.con_layout, A.con_name, A.con_id, A.con_address, A.con_lat, A.con_long, COUNT(B.space_id) AS 'avl_space'\n"
            . "FROM tbl_concourse A\n"
            . "LEFT JOIN tbl_spaces B\n"
            . "ON A.con_id = B.con_id AND A.owner_id = B.owner_id\n"
            . "WHERE A.owner_id = $owner_id\n"
            . "GROUP BY A.con_name, A.con_id, A.con_address, A.con_lat, A.con_long, A.con_image, A.con_layout;";

        $sql_non_owner = "SELECT MAX(A.owner_id) AS 'owner_id', A.con_image, A.con_layout, A.con_name, A.con_id, A.con_address, A.con_lat, A.con_long, COUNT(B.space_id) AS 'avl_space'\n"
            . "FROM tbl_concourse A\n"
            . "LEFT JOIN tbl_spaces B\n"
            . "ON A.con_id = B.con_id AND A.owner_id = B.owner_id\n"
            . "GROUP BY A.con_name, A.con_id, A.con_address, A.con_lat, A.con_long, A.con_image, A.con_layout;";

        $sql = $user_type == "Owner" ? $sql_owner : $sql_non_owner;

        $result = mysqli_query($con, $sql);

        while ($row = mysqli_fetch_assoc($result)) {

            $request_result = array(
                "con_id" => $row['con_id'],
                "owner_id" => $row['owner_id'],
                "con_name" => $row['con_name'],
                "con_layout" => $row['con_layout'],
                "con_image" => $row["con_image"],
                "con_lat" => $row["con_lat"],
                "con_long" => $row["con_long"],
                "con_address" => $row['con_address'],
                "avl_space" => $row['avl_space']
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
    } else if (!empty($_POST['concourse']) && ($_POST['concourse'] == "read_concourse")) {

        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $con_id = $_POST['con_id'];

        $sqlquery = $con_id == null ? "SELECT * FROM `tbl_concourse` WHERE con_lat = $latitude AND con_long = $longitude LIMIT 1;"
            : "SELECT * FROM `tbl_concourse` WHERE con_id = $con_id LIMIT 1;";

        $result = mysqli_query($con, $sqlquery);

        while ($row = mysqli_fetch_assoc($result)) {

            $request_result = array(
                "con_id" => $row['con_id'],
                "owner_id" => $row['owner_id'],
                "con_name" => $row['con_name'],
                "con_layout" => $row['con_layout'],
                "con_image" => $row["con_image"],
                "con_lat" => $row["con_lat"],
                "con_long" => $row["con_long"],
                "con_address" => $row['con_address'],
                "con_rate" => $row['con_rate']
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
    } else if (!empty($_POST['concourse']) && ($_POST['concourse'] == "delete_concourse")) {

        $con_id = $_POST['con_id'];

        $DeleteConcourse = "DELETE FROM `tbl_concourse` WHERE con_id = $con_id;";

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
    } else if (!empty($_POST['concourse']) && ($_POST['concourse'] == "update_concourse")) {

        $conLat = $_POST['conLat'];
        $conLong = $_POST['conLong'];

        $conAddress = $_POST['conAddress'];
        $conRate = $_POST['conRate'];
        $conName = $_POST['conName'];
        $owner_id = $user_id;
        $conID = $_POST['conID'];

        $con_image_file = $_FILES['conImage'];
        $con_image_name = $con_image_file['name'];
        $con_image_tmp = $con_image_file['tmp_name'];
        $con_image_extension = pathinfo($con_image_name, PATHINFO_EXTENSION);
        $con_image_filename = uniqid("IMG_ConcourseImg_") . '.' . $con_image_extension;


        $con_layout_file = $_FILES['conLayout'];
        $con_layout_name = $con_layout_file['name'];
        $con_layout_tmp = $con_layout_file['tmp_name'];
        $con_layout_extension = pathinfo($con_layout_name, PATHINFO_EXTENSION);
        $con_layout_filename = uniqid("IMG_SpaceLayout_") . '.' . $con_layout_extension;

        $upload_conImg_res = $_FILES['conImage']['error'] === UPLOAD_ERR_OK ? UploadImage($con_image_filename, $con_image_tmp, "con_image") : false;
        $upload_conLayout_res = $_FILES['conLayout']['error'] === UPLOAD_ERR_OK ? UploadImage($con_layout_filename, $con_layout_tmp, "con_layout") : false;


        $con_image_tobesaved = $upload_conImg_res ? "'" . $con_image_filename . "'" : "`con_image`";
        $con_layout_tobesaved = $upload_conLayout_res ? "'" . $con_layout_filename . "'" : "`con_layout`";

        $UpdateConcourse = "UPDATE `tbl_concourse` SET `con_name`='$conName',
                                                       `con_layout`= $con_layout_tobesaved,
                                                       `con_image`= $con_image_tobesaved,
                                                       `con_lat`='$conLat',
                                                       `con_long`='$conLong',
                                                       `con_address`='$conAddress',
                                                       `con_rate` = $conRate,
                                                       `date_modified`= null
                                                        WHERE `con_id` = '$conID' AND owner_id = '$owner_id'";

        $SQLResult = $con->query($UpdateConcourse);

        if ($SQLResult) {
            $newConcourseResult = array(
                "code" => 200,
                "updateResult" => $SQLResult,
                "uploadImage_con" => $upload_conImg_res,
                "uploadImage_lay" => $upload_conLayout_res,
                "con_image_tmp" => $con_image_tmp,
                "con_image_extension" => $con_image_extension
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
    } else if (!empty($_POST['concourse']) && ($_POST['concourse'] == "get_rate")) {

        $sqlquery = "select * from ( SELECT billing_name,billing_code,amount FROM tbl_billing_setup WHERE billing_code IN ('PROVSP-RATE') and UserID=$user_id ORDER BY ID DESC LIMIT 1) a union select * from ( SELECT billing_name,billing_code,amount FROM tbl_billing_setup WHERE billing_code IN ('MNLSP-RATE') and UserID=$user_id ORDER BY ID DESC LIMIT 1) b";

        $result = mysqli_query($con, $sqlquery);

        while ($row = mysqli_fetch_assoc($result)) {

            $request_result = array(
                "billing_name" => $row['billing_name'],
                "billing_code" => $row['billing_code'],
                "amount" => $row['amount']
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