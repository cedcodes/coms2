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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['space_app'])) {

    if (!empty($_POST['space_app']) && ($_POST['space_app'] == "retrieve_application")) {

        $sql1 = "SELECT A.application_id, D.con_name, D.con_address, C.space_name, A.space_id, A.con_id, A.application_type,
                    CONCAT(B.first_name, ' ', B.last_name) AS 'tenant', 
                    CONCAT(E.first_name, ' ', E.last_name) AS 'owner',
                    B.email AS 'tenant_email',
                    E.email AS 'owner_email',
                    B.profile_img,
                    A.lease_terms, A.applicant_remarks, A.date_added, A.application_status, A.is_approved,
                    (SELECT COUNT(*) FROM tbl_requirements_list G WHERE G.requirement_id NOT IN (SELECT F.requirement_id FROM tbl_requirements_file F WHERE F.application_id = A.application_id )) AS 'rem_req'
                 FROM `tbl_tenant_application` A
                 INNER JOIN tbl_user B
                 ON A.tenant_id = B.user_id
                 INNER JOIN tbl_spaces C
                 ON A.space_id = C.space_id
                 INNER JOIN tbl_concourse D
                 ON A.con_id = D.con_id
                 INNER JOIN tbl_user E
                 ON D.owner_id = E.user_id
                 WHERE A.owner_id = $user_id AND A.is_approved = 0;";

        $sql2 = "SELECT A.application_id, D.con_name, D.con_address, C.space_name, A.space_id, A.con_id, A.application_type,
                    CONCAT(B.first_name, ' ', B.last_name) AS 'tenant', 
                    CONCAT(E.first_name, ' ', E.last_name) AS 'owner',
                    B.email AS 'tenant_email',
                    E.email AS 'owner_email',
                    B.profile_img,
                    A.lease_terms, A.applicant_remarks, A.date_added, A.application_status, A.is_approved,
                    (SELECT COUNT(*) FROM tbl_requirements_list G WHERE G.requirement_id NOT IN (SELECT F.requirement_id FROM tbl_requirements_file F WHERE F.application_id = A.application_id )) AS 'rem_req'
                 FROM `tbl_tenant_application` A
                 INNER JOIN tbl_user B
                 ON A.tenant_id = B.user_id
                 INNER JOIN tbl_spaces C
                 ON A.space_id = C.space_id
                 INNER JOIN tbl_concourse D
                 ON A.con_id = D.con_id
                 INNER JOIN tbl_user E
                 ON D.owner_id = E.user_id
                 WHERE A.tenant_id = '$user_id';";

        $sqlqry = $user_type == "Owner" ? $sql1 : $sql2;

        $result = mysqli_query($con, $sqlqry);

        while ($row = mysqli_fetch_assoc($result)) {

            $request_result = array(
                "application_id" => $row['application_id'],
                "application_type" => $row['application_type'],
                "con_name" => $row['con_name'],
                "con_id" => $row['con_id'],
                "con_address" => $row['con_address'],
                "space_name" => $row['space_name'],
                "space_id" => $row['space_id'],
                "tenant" => $row['tenant'],
                "tenant_email" => $row['tenant_email'],
                "owner" => $row['owner'],
                "owner_email" => $row['owner_email'],
                "profile_img" => $row['profile_img'],
                "lease_terms" => $row['lease_terms'],
                "applicant_remarks" => $row['applicant_remarks'],
                "date_added" => $row['date_added'],
                "application_status" => $row['application_status'],
                "rem_req" => $row['rem_req'],
                "is_approved" => $row['is_approved']
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
    } else if (!empty($_POST['space_app']) && ($_POST['space_app'] == "retrieve_reqfiles")) {
        $application_id = $_POST['application_id'];
        $req_ret_mode = $_POST['req_ret_mode'];

        $sql1 = "SELECT B.requirement_id, A.application_id, A.file_name, B.req_name
                    FROM tbl_requirements_list B
                    LEFT JOIN tbl_requirements_file A
                    ON A.requirement_id = B.requirement_id
                    WHERE A.application_id = $application_id
                UNION ALL
                SELECT requirement_id, null, null, req_name
                    FROM tbl_requirements_list
                    WHERE requirement_id NOT IN (SELECT requirement_id FROM tbl_requirements_file WHERE application_id = $application_id);";
        
        $sql2 = "SELECT requirement_id, $application_id AS 'application_id', req_name, '' as file_name
                    FROM tbl_requirements_list
                    WHERE requirement_id NOT IN (SELECT requirement_id FROM tbl_requirements_file WHERE application_id = $application_id);";
        
        $sql = $req_ret_mode == 1 ? $sql1 : $sql2;

        $result = mysqli_query($con, $sql);

        while ($row = mysqli_fetch_assoc($result)) {

            $request_result = array(
                "application_id" => $row['application_id'],
                "requirement_id" => $row['requirement_id'],
                "file_name" => $row['file_name'],
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
    } else if (!empty($_POST['space_app']) && ($_POST['space_app'] == "action_application")) {

        $application_id = $_POST['application_id'];
        $is_approved = $_POST['is_approved'];
        $application_status = $_POST['application_status'];
        $owner_remarks = !empty($_POST['owner_remarks']) ? $_POST['owner_remarks'] : '';



        $actionApplication = $user_type == "Owner"  ? "UPDATE `tbl_tenant_application` SET `is_approved` = $is_approved,
                                                       `application_status`= '$application_status',
                                                       `owner_remarks`= '$owner_remarks'
                                                        WHERE `application_id` = '$application_id'" :
                                                      "UPDATE `tbl_tenant_application` SET `is_approved` = $is_approved,
                                                        `application_status`= '$application_status'
                                                         WHERE `application_id` = '$application_id'";

        $SQLResult = $con->query($actionApplication);

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
    } else if (!empty($_POST['space_app']) && ($_POST['space_app'] == "retrieve_contract")) {
        $space_id = $_POST['space_id'];

        $sql = "SELECT A.contract_id, A.contract_start, A.contract_end, A.lease_terms, B.space_name, C.con_name 
                    FROM `tbl_contract` A
                    INNER JOIN `tbl_spaces` B
                    ON A.space_id = B.space_id
                    INNER JOIN `tbl_concourse` C
                    ON B.con_id = C.con_id
                    WHERE A.tenant_id = $user_id AND A.space_id = $space_id ORDER BY A.contract_id DESC LIMIT 1";
        

        $result = mysqli_query($con, $sql);

        while ($row = mysqli_fetch_assoc($result)) {

            $request_result = array(
                "contract_id" => $row['contract_id'],
                "contract_start" => $row['contract_start'],
                "contract_end" => $row['contract_end'],
                "lease_terms" => $row['lease_terms'],
                "con_name" => $row['con_name'],
                "space_name" => $row['space_name']
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