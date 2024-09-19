<?php 

    require '../../vendor/autoload.php'; // Include PHPMailer autoload
    include('../../config/dbconnection/databaseconfig.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST["AddContract"])) {
        try {
            $leaseTerms = $_POST['LeaseTerm'];
            $concourse_id=$_POST["concourse_id"];
            $space_id=$_POST["space_id"];
            $tenant_id=$_POST["tenant_id"];
            $status=$_POST["approval_status"];

            if($status=='approved'){
                  // Contract Start
                $currentdate = date('y-m-d');
                $contractStart = date('y-m-d', strtotime($currentdate . '+2 days'));
                
                // Calculate contract end (1 year from start)
                $contractEnd =  date("Y-m-d", strtotime($contractStart . '+1 year'));
                $sendingdate =  date("Y-m-d", strtotime($contractEnd . '-1 month'));

                $sqlinsert = "UPDATE tbl_spaces SET status = 0 WHERE space_id=$space_id";
                $stmt1 = $con->prepare($sqlinsert);
                $stmt1->execute();
                
                $sql1 = "SELECT space_id, space_name, first_name, email FROM tbl_spaces a left join tbl_user b on a.tenant_id=b.user_id where a.space_id=$space_id";
                $result1 = $con->query($sql1);

                if ($result1->num_rows == 1) {
                    $row1 = $result1->fetch_assoc();         
                    $spaceName = $row1['space_name'];  
                    $tenantName = $row1['first_name'];  
                    $tenantEmail = $row1['email'];  
                }
        
                $sqlinsert = "INSERT INTO tbl_contract (concourse_id, contract_start, contract_end, endofcontract_sendingdate, space_id, tenant_id) VALUES ($concourse_id, '$contractStart', '$contractEnd', '$sendingdate',$space_id, $tenant_id)";
                $stmt1 = $con->prepare($sqlinsert);
                if ($stmt1->execute()) {

                    sendEmailToTenant($tenantEmail, $tenantName, $status, $spaceName);
                    echo json_encode(['success' => true, 'message' => 'Contract Added. ' . $tenantEmail]);
                }
                else{
                    echo json_encode(['success' => false, 'message' => $stmt1->error, 'err_status' => $err_status]);
                }
            }
            else{
                $sqlinsertU = "UPDATE tbl_spaces SET status = 1 WHERE space_id=$space_id";
                $stmtU = $con->prepare($sqlinsertU);
                $stmtU->execute();
                echo json_encode(['success' => true, 'message' => 'Contract Dissaproved.']);
            }   
        } catch(Exception $e){
            echo json_encode(['success' => false, 'message' => $e, 'err_status' => $err_status]);
        }
    }

function sendEmailToTenant($email, $tenantName, $status, $spaceName)
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
        $mail->addAddress($email); // User's email address
        $mail->isHTML(true);
        $mail->Subject = 'Application Status Update';
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
                    <h1>Application Status Update</h1>
                    <p>Dear $tenantName,</p>
                    <p>Your space application for space $spaceName is $status.</p>
                    <p>Regards,<br>Your Landlord</p>
                </div>
            </body>
            </html>
        ";

        $mail->send();

        echo json_encode(['success' => true, 'message' => 'Contract Emailed']);
    } catch(Exception $e){
        $error = $mail->ErrorInfo;
        echo json_encode(['success' => false, 'message' => $error]);
    }
}
?>