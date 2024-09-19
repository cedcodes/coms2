<?php

session_name("user_session");
session_start();

include('../../config/dbconnection/databaseconfig.php');

header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../vendor/autoload.php';

$response_data = array();
$request_data = array();
$request_status = array();
$user_id = $_SESSION["user_id"];
$user_type = $_SESSION["usertype"];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['tenant'])) {

    if (!empty($_POST['tenant']) && ($_POST['tenant'] == "retrieve_tenant")) {

        $sql = "SELECT ID, CONCAT(B.first_name, ' ', B.last_name) AS tenant, 
                       C.space_name, D.con_name, 
                       A.date_added AS 'startdate',
                       C.space_id, A.tenant_id, A.is_active
                FROM `tbl_tenant` A
                INNER JOIN tbl_user B
                ON A.tenant_id = B.user_id
                INNER JOIN tbl_spaces C
                ON A.space_id = C.space_id
                INNER JOIN tbl_concourse D
                ON A.con_id = D.con_id
                WHERE A.owner_id = $user_id;";

        $result = mysqli_query($con, $sql);

        while ($row = mysqli_fetch_assoc($result)) {

            $request_result = array(
                "tenant_id" => $row['tenant_id'],
                "tenant" => $row['tenant'],
                "con_name" => $row['con_name'],
                "space_name" => $row['space_name'],
                "startdate" => $row['startdate'],
                "rentstatus" => $row['is_active'] ? 'ACTIVE' : 'ENDED',
                "space_id" => $row['space_id']
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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST["vwContract"])) {
    $space_id = $_POST["space_id"];
    $tenant_id = $_POST["tenant_id"];
    try{
        $sql = "SELECT a.*, b.space_name FROM tbl_contract a left join tbl_spaces b on a.space_id=b.space_id WHERE a.space_id = '$space_id' and a.tenant_id=$tenant_id order by contract_id desc limit 1";
        $result = $con->query($sql);      
        $arr_rows = array();	

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();         
            $arr_rows['contract_start'] = $row['contract_start'];  
            $arr_rows['contract_end'] = $row['contract_end'];  
            $arr_rows['lease_terms'] = $row['lease_terms'];  
            $arr_rows['space_name'] = $row['space_name'];  
        }
    
        $records[] = $arr_rows;
        $output = array(			
            "data"	=> 	$records
        );
        
        echo json_encode(['success' => true, 'data' => $output]);
    } catch(Exception $e){
        echo json_encode(['success' => false, 'message' => $e]);
    }        
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST["vwContractTerminate"])) {
    $space_id = $_POST["space_id"];
    $tenant_id = $_POST["tenant_id"];
    try{
        $sqlinsert = "UPDATE tbl_tenant SET is_active=0, date_modified=NOW() WHERE space_id=$space_id and tenant_id=$tenant_id and is_active=1";
        // $con->query($sql);
        $stmt1 = $con->prepare($sqlinsert);

        $sqlinsert2 = "UPDATE tbl_spaces SET status=0 WHERE space_id=$space_id";
        // $con->query($sql);
        $stmt2 = $con->prepare($sqlinsert2);
        $stmt2->execute();

        $sql1 = "SELECT a.space_id, space_name, first_name, email FROM tbl_spaces a left join tbl_user b on a.tenant_id=b.user_id where a.space_id=$space_id";
        $result1 = $con->query($sql1);

        if ($result1->num_rows == 1) {
            $row1 = $result1->fetch_assoc();         
            $spaceName = $row1['space_name'];  
            $tenantName = $row1['first_name'];  
            $tenantEmail = $row1['email'];   
        } 

        if ($stmt1->execute()) {
            sendEmailToTenant($tenantEmail,$tenantName,$spaceName);
        }
    } catch(Exception $e){
        echo json_encode(['success' => false, 'message' => $e]);
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

function sendEmailToTenant($email, $tenantName, $spaceName)
{

    $currentdate = date('Y-m-d');
    $contractStart = date('Y-m-d', strtotime($currentdate . '+7 days'));

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com'; // Your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'noreply-coms@comsystem.tech'; // Your Gmail email address
        $mail->Password = '123!@#Coms'; // Your Gmail password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom('noreply-coms@comsystem.tech', 'Concessionaire Monitoring Operation System');
        $mail->addAddress($email); // User's email address
        $mail->isHTML(true);
        $mail->Subject = 'Notice of Lease Termination';
        $mail->Body = "
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <style>
                    body {
                        font-family: 'Arial', sans-serif;
                        background-color: #f4f4f4;
                        color: #333;
                        padding: 20px;
                        margin: 0;
                    }

                    .container {
                        max-width: 600px;
                        margin: 0 auto;
                        background-color: #fff;
                        padding: 20px;
                        border-radius: 8px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    }

                    h1 {
                        color: #3498db;
                    }

                    p {
                        margin-bottom: 20px;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h1>Notice of Lease Termination</h1>
                    <p>Dear $tenantName,</p>
                    <p>I hope this message finds you well.</p>
                    <p>It is with regret that we must inform you of the decision to terminate your lease agreement on Space ($spaceName). After careful consideration and review of the circumstances, we have determined that termination of the lease agreement is necessary.</p>
                    <p>The termination is effective as of $contractStart</p>
                    <p>As per the terms of the lease agreement, we kindly request that you vacate the premises by the termination date specified above. Please ensure that all personal belongings are removed from the space.</p>
                    <p>If you have any questions or require further clarification regarding this matter, please do not hesitate to contact us.</p>
                    <p>Regards,<br>Your Landlord</p>
                </div>
            </body>
            </html>
        ";

        $mail->send();

        echo json_encode(['success' => true, 'message' => 'Contract Emailed: ' . $email]);
    } catch(Exception $e){
        $error = $mail->ErrorInfo;
        echo json_encode(['success' => false, 'message' => $error]);
    }
}

?>