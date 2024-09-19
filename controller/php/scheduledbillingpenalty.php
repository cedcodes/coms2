<?php 
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    session_name("user_session");
    session_start();


    include('../../config/dbconnection/databaseconfig.php');
    
    require '../../vendor/autoload.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    $user_id = $_SESSION["user_id"];

    try{
        $unpaidbilling = "SELECT *, ROUND(DATEDIFF(CURDATE(),due_date)/7,0) as 'Weeks', first_name FROM `tbl_billings_2` a left join tbl_user b on a.tenant_id=b.user_id WHERE paymentstatus='unpaid' and isnotified=0";
        $unpaidbillingResult = mysqli_query($con, $unpaidbilling);
        
        if ($unpaidbillingResult && mysqli_num_rows($unpaidbillingResult) > 0) {
            while ($Data = mysqli_fetch_assoc($unpaidbillingResult)) {
                if ($Data["Weeks"] > 0)
                {
                    $new_total_with_penalty= $Data["amount"] + (50 * $Data["Weeks"]);
                    $billId =  $Data["bill_id"]; 
                    $tenant_id =  $Data["tenant_id"]; 
                    $penaltyamount = (50 * $Data["Weeks"]);
                    $first_name = $Data["first_name"];
                    $tenantemail = $Data["email"];
                    echo $Data["due_date"];
                    echo ' | ';
                    echo $Data["Weeks"];
                    echo ' | ';
                    echo $new_total_with_penalty; 
                    echo '<br/>';

                    $notiftitle='Notice on Late Payment';
                    $notif_details='We hope this message finds you well. We regret to inform you that we have noted a delay in your recent rental payment. As per the terms outlined in your lease agreement, late payments incur a penalty charge. Unfortunately, your payment was received after the due date, resulting in a late fee of 50 pesos for every week delayed being applied to your account. Thank you for your attention to this matter.';
                    
                    $InsertNotifQuery = "INSERT INTO tbl_notification(user_id, notif_title, notif_details,notif_type) VALUES($tenant_id, '$notiftitle','$notif_details', 1)";
                    $insertResult = $con->query($InsertNotifQuery);

                    $updateSpaceStatusQuery = "UPDATE tbl_billings_2 SET penaltyamount=$penaltyamount, isnotified=1 where bill_id= $billId";
                    $updateResult = $con->query($updateSpaceStatusQuery);

                    
    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = 'smtp.hostinger.com'; // Your SMTP server
                    $mail->SMTPAuth = true;
                    $mail->Username = 'noreply-coms@comsystem.tech'; // Your Gmail email address
                    $mail->Password = '123!@#Coms'; // Your Gmail password
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;
                    $mail->setFrom('noreply-coms@comsystem.tech', 'Concessionaire Monitoring Operation System');
                    $mail->addAddress($tenantemail, $first_name);
                    
                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Notice on Late Payment';
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
                                <h1>Notice on Late Payment</h1>
                                <p>Dear $first_name,</p>
                                <p>We hope this message finds you well. We regret to inform you that we have noted a delay in your recent rental payment. As per the terms outlined in your lease agreement, late payments incur a penalty charge. Unfortunately, your payment was received after the due date, resulting in a late fee of 50 pesos for every week delayed being applied to your account. Thank you for your attention to this matter.</p>
                                <p>Thank you,<br>Your Landlord</p>
                            </div>
                        </body>
                        </html>
                    ";
        
                    $mail->send();
                }
            }
        }
    }
    catch (Exception $e){
    echo json_encode(['error'=>'Caught exception: ',  $e->getMessage(), "\n"]);
    }		
    echo 'penalty list';

$checkUnsentEmails = "SELECT a.space_id, contract_id, first_name as tenantname, email, space_name, contract_end
                        FROM `tbl_contract` a left join tbl_user b on a.tenant_id=b.user_id
                        left join tbl_spaces c on a.space_id=c.space_id
                        WHERE eoc_sentemailstatus=0 and email is not null and endofcontract_sendingdate = CURDATE()";

$UnsentEmailsResult = mysqli_query($con, $checkUnsentEmails);

if ($UnsentEmailsResult && mysqli_num_rows($UnsentEmailsResult) > 0) {
    while ($Data = mysqli_fetch_assoc($UnsentEmailsResult)) {
    $tenantName = $Data["tenantname"];
    $tenantEmail= $Data["email"];
    $spaceName = $Data["space_name"];
    $contractenddate = $Data["contract_end"];
    $contractid = $Data["contract_id"];

    echo 'Unsent emails';
    echo $tenantEmail;
    $updateSpaceStatusQuery = "UPDATE tbl_contract SET eoc_sentemailstatus = 1 and contract_id= $contractid";
    $updateResult = $con->query($updateSpaceStatusQuery);

    print_r( 'EMAIL SENT');
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
            $mail->addAddress($tenantEmail, $tenantName);
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Upcoming Contract End';
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
                        <h1>Contract End Notification</h1>
                        <p>Dear $tenantName,</p>
                        <p>Your contract for space $spaceName is ending soon. We wanted to remind you that the contract is scheduled to end on $contractenddate.</p>
                        <p>Please make necessary arrangements or contact us if you have any questions.</p>
                        <p>Thank you,<br>Your Landlord</p>
                    </div>
                </body>
                </html>
            ";

            $mail->send();

            echo 'End of Contract Emailed.';
        } catch (Exception $e) {
            $error = $mail->ErrorInfo;
            echo $error; // Email sending failed
        }
    }
}
?>