
<?php

session_name("user_session");
session_start();

include('../../config/dbconnection/databaseconfig.php');

$user_id = $_SESSION["user_id"];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST["create_accountant"])) {

    $username = $_POST["susername"];
    $password = $_POST["spassword"];
    $semail = $_POST["semail"];
    $firstname = $_POST["sfirstname"];
    $lastname = $_POST["slastname"];
    $birthday = $_POST["birthday"];
    $usertype = $_POST["susertype"];
    $otp = "";
    $expiration_time="";
    $is_verified = 1;

    $error = '';
    $err_status = '';
    $checkEmailQuery = "SELECT email, is_verified FROM tbl_user WHERE email = '$semail'";
    $result = $con->query($checkEmailQuery);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc(); 
        $error = 'Email is already registered. Please use a different email';
        $err_status = 'existing_email_verified';       
    }

    $sqlQuery = "SELECT * FROM `tbl_user` WHERE username = ?";

    $stmt =  $con->prepare($sqlQuery);
	$stmt->bind_param("s", $username);
	$stmt->execute();
    $result2 = $stmt->get_result();
    if($result2 && $result2->num_rows > 0){
        $error = 'Username is already taken';
    }

    if(empty($error)) { 
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        try {
            $sql = "INSERT INTO tbl_user (username, email, password, otp_code, otp_expiration, acct_type, first_name,last_name, birthdate, is_verified) VALUES (?,?,?,?,?,?,?,?,?,?)";
            // $con->query($sql);
            $stmt1 = $con->prepare($sql);
            $stmt1->bind_param("ssssssssss", $username, $semail, $hashedPassword, $otp, $expiration_time, $usertype, $firstname, $lastname, $birthday, $is_verified);

            if ($stmt1->execute()) {
                echo json_encode(['success' => true, 'message' => 'Account has been created.']);
            }
            else{
                echo json_encode(['success' => false, 'message' => $stmt1->error, 'err_status' => $err_status]);
            }

        } catch(Exception $e){
            echo json_encode(['success' => false, 'message' => $e, 'err_status' => $err_status]);
        }
    }
    else { 
        echo json_encode(['success' => false, 'message' => $error, 'err_status' => $err_status]);
    } 
}
?>

