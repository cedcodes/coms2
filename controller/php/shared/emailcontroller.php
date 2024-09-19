<?php
// error_reporting(E_ALL);
// ini_set("display_errors", 1);

session_name("user_session");
session_start();

require '../../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include('../../../config/dbconnection/databaseconfig.php');

header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");

//
$user_id = $_SESSION["user_id"];
$user_type = $_SESSION["usertype"];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email'])) {
    if (!empty($_POST['email']) && ($_POST['email'] == "sent_email_application")) {
        $tenant = $_POST['tenant'];
        $tenant_email = $_POST['tenant_email'];
        $owner = $_POST['owner'];
        $owner_email = $_POST['owner_email'];
        $conName = $_POST['conName'];
        $conAddress = $_POST['conAddress'];
        $meetdate = $_POST['meetdate'];
        $meettime = $_POST['meettime'];
        $office_address = $_POST['office_address'];
        $emailSubject = $_POST['emailSubject'];
        $is_approved = $_POST['is_approved'];

        $emailContents = $is_approved == '1' ? getEmailContents(array('tenant' => $tenant, 'conAddress' => $conAddress, 'conName' => $conName, 'meetdate' => $meetdate, 'meettime' => $meettime, 'office_address' => $office_address, 'owner' => $owner, 'owner_email' => $owner_email), $is_approved, 'space_application') :
            getEmailContents(array('tenant' => $tenant, 'conAddress' => $conAddress, 'office_address' => $office_address, 'owner' => $owner, 'owner_email' => $owner_email), $is_approved, 'space_application');


        SendEmail($tenant_email, $tenant, $emailSubject, $emailContents);
    } else if (!empty($_POST['email']) && ($_POST['email'] == "new_application_alert")) {

        $spaceName = $_POST['spaceName'];
        $owner = $_POST['owner'];
        $owner_email = $_POST['owner_email'];
        $emailSubject = "New Space Application";

        $sql = "SELECT * FROM tbl_user WHERE user_id = $user_id LIMIT 1;";

        $result = mysqli_query($con, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            $tenant = $row['first_name'];
            $emailContents = getEmailContents(array('tenant' => $tenant, 'spaceName' => $spaceName), 0, 'space_alert_owner');
            echo $owner_email . $owner . $emailSubject;
            SendEmail($owner_email, $owner, $emailSubject, $emailContents);

        }




    }
}

function SendEmail($sentToEmail, $sentToName, $emailSubject, $emailContents)
{

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
        $mail->addAddress($sentToEmail, $sentToName);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $emailSubject;
        $mail->Body = $emailContents;

        $mail->send();

        echo 'Email Sent';
    } catch (Exception $e) {
        $error = $mail->ErrorInfo;
        echo $error . ' - '; // Email sending failed
    }
}

function getEmailContents(array $vars, $is_approved, $module)
{
    extract($vars);

    if ($is_approved == 1 && $module == "space_application") {
        ob_start();
        include '../../../assets/email/spaceturnover_email.html.php';
        return ob_get_contents();
    } else if ($is_approved == 3 && $module == "space_application") {
        ob_start();
        include '../../../assets/email/onhold_email.html.php';
        return ob_get_contents();
    } else if($module == "space_alert_owner"){
        ob_start();
        include '../../../assets/email/space_alert_owner.html.php';
        return ob_get_contents();
    }

}

?>