<?php 
session_name("user_session");
session_start();

include('../../config/dbconnection/databaseconfig.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../vendor/autoload.php';

$userArray = array();
$userData = array();
$request_status = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST["login"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $sqlQuery = "SELECT * FROM `tbl_user` WHERE username = ?";

    $stmt =  $con->prepare($sqlQuery);
	// $password = md5($this->password);
	$stmt->bind_param("s", $username);
	$stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        if(!$row['is_verified']){
            echo json_encode(['success' => false, 'message' => 'Please verify your email', 'is_verified' => $row['is_verified'], 'unverified' => 'existing_email_unverified', 'email' => $row['email']]);
        }
        else if (password_verify($password, $row['password']) && $row['is_verified']) {

            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['last_name'] = $row['last_name'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['usertype'] = $row['acct_type'];
            $_SESSION['is_verified'] = $row['is_verified'];
            $_SESSION['email'] = $row['email'];

            echo json_encode(['success' => true, 'usertype' => $row['acct_type'], 'is_verified' => $row['is_verified']]);
        }
        else{
            echo json_encode(['success' => false, 'message' => 'Invalid Password', 'is_verified' => $row['is_verified'] == null ? 0 : $row['is_verified'] , 'email' => $row['email']]);
        }
    }
    else{
        echo json_encode(['success' => false, 'message' => 'Invalid User', 'is_verified' => 0]);
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST["userTypeAccess"])) {
    $user_type =$_SESSION['usertype'];
    echo json_encode(['success' => true, 'user_type' => $user_type]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST["signout"])) {
    session_destroy(); 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST["signup"])) {

    $username = $_POST["susername"];
    $password = $_POST["spassword"];
    $semail = $_POST["semail"];
    $firstname = $_POST["sfirstname"];
    $lastname = $_POST["slastname"];
    $birthday = $_POST["birthday"];
    $usertype = $_POST["susertype"];
    $isverified = $_POST["signup"] != 1 ? 0 : $_POST["signup"];
    $img_profile = 'IMG_ProfileImage_65dc0d6fb04e4.jpeg';
    $error = '';
    $err_status = '';
    $checkEmailQuery = "SELECT email, is_verified FROM tbl_user WHERE email = '$semail'";
    $result = $con->query($checkEmailQuery);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['is_verified'] == 0) {      
            $error = 'Please complete your registration by verifying your email';
            $err_status = 'existing_email_unverified';
        }else{
            $error = 'Email is already registered. Please use a different email';
            $err_status = 'existing_email_verified';
        }
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

        // Generate OTP
        $otp_str = str_shuffle('0123456789');
        $otp = substr($otp_str, 0, 5);

        // Generate Activation Code
        $act_str = rand(100000, 10000000);
        $activation_code = str_shuffle('abcdefghijklmno' . $act_str);

        // Insert data into the database
        $expiration_time = date("Y-m-d H:i:s", strtotime('+3 minutes'));
        $created_at = date("Y-m-d H:i:s");

        try {
            $sql = "INSERT INTO tbl_user (username, email, password, otp_code, otp_expiration, acct_type, first_name,last_name, birthdate,profile_img,is_verified) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
            // $con->query($sql);
            $stmt1 = $con->prepare($sql);
            $stmt1->bind_param("sssssssssss", $username, $semail, $hashedPassword, $otp, $expiration_time, $usertype, $firstname, $lastname, $birthday,$img_profile,$isverified);

            if ($stmt1->execute()) {
                echo json_encode(['success' => true, 'message' => 'Your OTP has been sent to your email.']);
            }
            else{
                echo json_encode(['success' => false, 'message' => $stmt1->error, 'err_status' => $err_status]);
            }

        } catch(Exception $e){
            echo json_encode(['success' => false, 'message' => $e, 'err_status' => $err_status]);
        }

        if( $isverified != 1){
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.hostinger.com'; // Your SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'noreply-coms@comsystem.tech'; // Your Gmail email address
                $mail->Password = '123!@#Coms'; // Your Gmail password
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
    
                $mail->setFrom('noreply-coms@comsystem.tech', 'Concessionaire Monitoring Operation System');
                $mail->addAddress($semail); // User's email address
                $mail->isHTML(true);
                $mail->Subject = 'Email Verification';
                $mail->Body = 'Your OTP is: ' . $otp;
    
                $mail->send();
    
               
            } catch (Exception $e) {
                $error = $mail->ErrorInfo;
                echo json_encode(['success' => false, 'message' => $error, 'err_status' => $err_status]);
            } 
        }
        // Send OTP to the user's email      
    } 
    else { 
        echo json_encode(['success' => false, 'message' => $error, 'err_status' => $err_status]);
    } 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST["verify_otp"])) {

    $otpcode = $_POST["otpcode"];
    $otpemail = $_POST["otpemail"];

    $sqlQuery = "SELECT * FROM `tbl_user` WHERE email = ?";

    $stmt =  $con->prepare($sqlQuery);
	// $password = md5($this->password);
	$stmt->bind_param("s", $otpemail);
	$stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        
        $user = $result->fetch_assoc();
        $expiration_time = strtotime($user['otp_expiration']);

        if ($expiration_time > time()) {
        // Inside the if (verifyOTP($con, $email, $otp)) block
            if (verifyOTP($con, $otpemail, $otpcode)) {

                $sql = "UPDATE tbl_user SET is_verified = 1 WHERE email = ?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("s", $otpemail);
                $stmt->execute();

                $errstatus=true;
                $errorMessage = "Registration successful! You can now log in.";
                $otpstatus= "verified";
            }
            else {
                $errstatus=false;
                $errorMessage = "Invalid OTP. Please try again.";
                $otpstatus= "invalid";
            }
        } else {
            $errstatus=false;
            $errorMessage = "The OTP has expired. Please click 'Resend OTP' for a new one.";
            $otpstatus= "expired";
        }
    } else {
        $errstatus=false;
        $errorMessage = "User not found.";
        $otpstatus= "invalid";
    }
    echo json_encode(['success' => $errstatus, 'message' => $errorMessage, 'otpstatus' => $otpstatus]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST["resend_otp"])) {
    $email = $_POST['otpemail'];

    // Check if the email exists in the database
    $sql = "SELECT * FROM tbl_user WHERE email = '$email'";
    $result = $con->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $email = $row['email'];

        // Generate a new OTP
        $new_otp = str_shuffle('0123456789');
        $new_otp = substr($new_otp, 0, 5);
        $expiration_time = date("Y-m-d H:i:s", strtotime('+3 minutes'));

        // Update the OTP in the database
        $update_sql = "UPDATE tbl_user SET otp_code = '$new_otp',otp_expiration='$expiration_time' WHERE email = '$email'";
        $con->query($update_sql);
        // Send OTP to the user's email
        $mail = new PHPMailer(true);
        try {
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
            $mail->Subject = 'Email Verification';
            $mail->Body = 'Your OTP is: ' . $new_otp;

            $mail->send();

            echo json_encode(['success' => true, 'message' => 'New OTP sent to email']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $mail->ErrorInfo]);
        }
    } else {
        $error_message = "Email not found in our records. Please sign up first.";
        echo json_encode(['success' => false, 'message' => $errorMessage]);
    }
}

function verifyOTP($con, $otpemail, $otpcode)
{
    $sql = "SELECT * FROM tbl_user WHERE email = ? AND otp_code = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ss", $otpemail, $otpcode);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $sql = "UPDATE tbl_user SET is_verified = 1 WHERE email = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $otpemail);
        $stmt->execute();
        return true;
    }
    else{
        return false;
    }
}

?>
