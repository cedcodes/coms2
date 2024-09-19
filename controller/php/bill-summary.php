<?php 
    session_name("user_session");
    session_start();
    require '../../vendor/autoload.php'; // Include PHPMailer autoload
    include('../../config/dbconnection/databaseconfig.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    $user_id = $_SESSION["user_id"];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST["billamount"])) {
        try{
            $ClickedSpace=!empty($_POST["ClickedSpace"]) ? $_POST["ClickedSpace"] : '';

            $sql = "SELECT * FROM tbl_billing_setup WHERE UserID = '$user_id' and billing_code='WB-RATE' ORDER BY date_added DESC LIMIT 1;";
            $result = $con->query($sql);      
            $arr_rows = array();	

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();         
                $arr_rows['txtWaterAmount'] = $row['amount'];  
            }

            $sql1 = "SELECT * FROM tbl_billing_setup WHERE UserID = '$user_id' and billing_code='EB-RATE'  ORDER BY date_added DESC LIMIT 1;";
            $result1 = $con->query($sql1);

            if ($result1->num_rows == 1) {
                $row1 = $result1->fetch_assoc();         
                $arr_rows['txtElectricAmount'] = $row1['amount'];  
            }

            $sql2 = "SELECT * FROM tbl_billing_setup WHERE UserID = '$user_id' and billing_code='PROVSP-RATE'  ORDER BY date_added DESC LIMIT 1;";
            $result2 = $con->query($sql2);

            if ($result2->num_rows == 1) {
                $row2 = $result2->fetch_assoc();         
                $arr_rows['txtProvPricePerMeter'] = $row2['amount'];  
            }

            $sql2 = "SELECT * FROM tbl_billing_setup WHERE UserID = '$user_id' and billing_code='MNLSP-RATE'  ORDER BY date_added DESC LIMIT 1;";
            $result2 = $con->query($sql2);

            if ($result2->num_rows == 1) {
                $row2 = $result2->fetch_assoc();         
                $arr_rows['txtMNLPricePerMeter'] = $row2['amount'];  
            }

            if($ClickedSpace != ''){
                $sql3 = "SELECT space_price FROM tbl_spaces WHERE space_id='$ClickedSpace'";
                $result3 = $con->query($sql3);
    
                if ($result3->num_rows == 1) {
                    $row3 = $result3->fetch_assoc();         
                    $arr_rows['space_price'] = $row3['space_price'];  
                }
            }
           
        
            $records[] = $arr_rows;
            $output = array(			
                "data"	=> 	$records
            );
            
            echo json_encode(['success' => true, 'data' => $output]);
        } catch(Exception $e){
            echo json_encode(['success' => false, 'message' => $e, 'err_status' => $err_status]);
        }        
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST["selected_space_bill"])) {
        $bill_id = $_POST["bill_id"];
        try{
            $sql = "SELECT * FROM tbl_billings_2 WHERE bill_id = '$bill_id'";
            $result = $con->query($sql);      
            $arr_rows = array();	

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();         
                $arr_rows['amount'] = $row['amount'];  
                $arr_rows['paymentstatus'] = $row['paymentstatus'];  
                $arr_rows['receipt_img'] = $row['receipt_img'];  
            }
        
            $records[] = $arr_rows;
            $output = array(			
                "data"	=> 	$records
            );
            
            echo json_encode(['success' => true, 'data' => $output]);
        } catch(Exception $e){
            echo json_encode(['success' => false, 'message' => $e, 'err_status' => $err_status]);
        }        
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST["getQR"])) {
        try{
            $sql = "SELECT * FROM tbl_paymentmaster";
            $result = $con->query($sql);      
            $arr_rows = array();	

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();         
                $arr_rows['account_no'] = $row['account_no'];  
                $arr_rows['payment_qr'] = $row['payment_qr'];   
            }
        
            $records[] = $arr_rows;
            $output = array(			
                "data"	=> 	$records
            );
            
            echo json_encode(['success' => true, 'data' => $output]);
        } catch(Exception $e){
            echo json_encode(['success' => false, 'message' => $e, 'err_status' => $err_status]);
        }        
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST["viewbillsummary"])) {
        $user_type =$_SESSION['usertype'];

        $user_typeCon= $user_type == 'Tenant' ? 'tenant_id' : 'owner_id';

        try{
            $sql = "select a.tenant_id, CONCAT(first_name, ' ', last_name) as tenant_name,space_name, a.space_id, sum(total) as total, MAX(paymentstatus) as paymentstatus from tbl_billings_2 a
            LEFT JOIN tbl_user u on a.tenant_id=u.user_id 
            LEFT JOIN tbl_spaces b on a.space_id=b.space_id
            WHERE paymentstatus='unpaid' and a.$user_typeCon='$user_id'
                        group by space_id,tenant_id,space_name;";
            $result = mysqli_query($con, $sql);
            $arr_rows = array();	
            $records = array();

            while ($row = mysqli_fetch_assoc($result)) {
                $arr_rows = array(
                    "space_name" => $row['space_name'],
                    "tenant_name" => $row['tenant_name'],
                    "total" => $row['total'],
                    "space_id" => $row['space_id'],
                );
                array_push($records, $arr_rows);
            }
        
            $output = array(			
                "data"	=> 	$records
            );        
            echo json_encode(['success' => true, 'data' => $output, 'usertype' => $user_typeCon]);
        } catch(Exception $e){
            echo json_encode(['success' => false, 'message' => $e, 'err_status' => $err_status]);
        }     
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST["viewprevbilling"])) {
        $space_id=$_POST["space_id"];  
        $user_type =$_SESSION['usertype'];
        $user_typeCon= $user_type == 'Tenant' ? 'tenant_id' : 'owner_id';

        try{
            $sql = "select a.*, CONCAT(first_name, ' ', last_name) as 'tenant_name' from tbl_billings_2 a left join tbl_user b on a.tenant_id=b.user_id where space_id='$space_id' and $user_typeCon='$user_id' ORDER BY due_date DESC;";
            $result = mysqli_query($con, $sql);

            $result = $con->query($sql);      
            $arr_rows = array();	
            $records = array();
            
            while ($row = mysqli_fetch_assoc($result)) {
                $arr_rows = array(
                    "space_id" => $row['space_id'],
                    "tenant_name" => $row['tenant_name'],
                    "billtype" => $row['billtype'],
                    "amount" => $row['amount'],
                    "total" => $row['total'],
                    "penaltyamount" => $row['penaltyamount'],
                    "due_date"=> $row['due_date'],
                    "payment_status" => $row['paymentstatus'],
                    "bill_id" => $row['bill_id']
                );
                array_push($records, $arr_rows);
            }
        
           
            $output = array(			
                "data"	=> 	$records
            );        
            echo json_encode(['success' => true, 'data' => $output]);
        } catch(Exception $e){
            echo json_encode(['success' => false, 'message' => $e, 'err_status' => $err_status]);
        }     
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST["saveNewBilling"])) {

        $newElectricAmount     = $_POST["newElectricAmount"];
        $newWaterAmount        = $_POST["newWaterAmount"];
        $newProvSpacePrice        = $_POST["newProvSpacePrice"];
        $newMnlSpacePrice        = $_POST["newMnlSpacePrice"];
       
        try {
            $sqlinsert = "INSERT INTO tbl_billing_setup (billing_code,billing_name,amount,UserID) VALUES ('WB-RATE','Water Bill Rate',$newWaterAmount,$user_id), ('EB-RATE','Electricity Bill Rate',$newElectricAmount,$user_id) , ('PROVSP-RATE','Provincial Rate', $newProvSpacePrice,$user_id)  , ('MNLSP-RATE','Manila Rate', $newMnlSpacePrice,$user_id)";
            // $con->query($sql);
            $stmt1 = $con->prepare($sqlinsert);

            if ($stmt1->execute()) {
                echo json_encode(['success' => true, 'message' => 'New Billing Setup has been saved.']);
            }
            else{
                echo json_encode(['success' => false, 'message' => $stmt1->error, 'err_status' => $err_status]);
            }

        } catch(Exception $e){
            echo json_encode(['success' => false, 'message' => $e, 'err_status' => $err_status]);
        }
   }

   if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST["saveNewUtilityBill"])) {

        $newBillType     = $_POST["newBillType"];
        $newElectricAmount     = $_POST["newElectricAmount"];
        $newWaterAmount        = $_POST["newWaterAmount"];
        $space_id        = $_POST["space_id"];
        $curdate = date('Y-m-d H:i:s');
   
        try {
            $sqlinsert = "INSERT INTO tbl_billings_2 (space_id,tenant_id,owner_id,billtype,amount,due_date,paymentstatus, created_at)
             select a.space_id, b.tenant_id, a.owner_id, 'UtilityBill-Electricity', $newElectricAmount,DATE_ADD(CURDATE(), INTERVAL 1 month),'unpaid', CURDATE() from tbl_spaces a 
             left join tbl_tenant b on a.space_id=b.space_id where a.space_id=$space_id UNION ALL
             select  a.space_id, b.tenant_id, a.owner_id, 'UtilityBill-Water', $newWaterAmount,DATE_ADD(CURDATE(), INTERVAL 1 month),'unpaid', CURDATE() from tbl_spaces a
             left join tbl_tenant b on a.space_id=b.space_id
             where a.space_id=$space_id UNION ALL 
             select  a.space_id, b.tenant_id, a.owner_id, 'Rent', space_price,DATE_ADD(CURDATE(), INTERVAL 1 month),'unpaid',CURDATE() from tbl_spaces a
             left join tbl_tenant b on a.space_id=b.space_id
             where a.space_id=$space_id 
             ";
            // $con->query($sql);
            $stmt1 = $con->prepare($sqlinsert);

            if ($stmt1->execute()) {
                $sql1 = "SELECT a.space_id, space_name, first_name, last_name, email,space_price, tenant_id FROM tbl_spaces a left join tbl_user b on a.tenant_id=b.user_id where space_id=$space_id";
                $result1 = $con->query($sql1);

                if ($result1->num_rows == 1) {
                    $row1 = $result1->fetch_assoc();         
                    $spaceName = $row1['space_name'];  
                    $tenantName = $row1['first_name'] . ' '. $row1['last_name'];  
                    $tenantEmail = $row1['email'];  
                    $spaceprice = $row1['space_price'];  
                    $tenant_id = $row1['tenant_id'];  
                }

                $notiftitle='Space Billing Update';
                $notif_details= 'Hi '.$tenantName .',  A new billing has been added to your account for the current rental period! The bill reflects the amount due for your continued occupancy at Space (Test 1)';
                
                $InsertNotifQuery = "INSERT INTO tbl_notification(user_id, notif_title, notif_details,notif_type) VALUES( $tenant_id, '$notiftitle','$notif_details', 1)";
                $insertResult = $con->query($InsertNotifQuery);

                sendBillingEmail($tenantEmail, $tenantName, $spaceName, $newElectricAmount,$newWaterAmount , $spaceprice);

                echo json_encode(['success' => true, 'message' => 'Billing for this Space has been saved.'  ]);
            }
            else{
                echo json_encode(['success' => false, 'message' => $stmt1->error, 'err_status' => $err_status]);
            }

        } catch(Exception $e){
            echo json_encode(['success' => false, 'message' => $e, 'err_status' => $err_status]);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST["saveNewSpaceBill"])) {

        $newBillType     = $_POST["newBillType"];
        $newAmount        = $_POST["newAmount"];
        $dueDate        = $_POST["newDueDate"];
        $space_id        = $_POST["space_id"];
   
        try {
            $sqlinsert = "INSERT INTO tbl_billings_2 (space_id,tenant_id,owner_id,billtype,amount,due_date,paymentstatus) select space_id, tenant_id, owner_id, '$newBillType', $newAmount,'$dueDate','unpaid' from tbl_spaces where space_id=$space_id";
            // $con->query($sql);
            $stmt1 = $con->prepare($sqlinsert);

            if ($stmt1->execute()) {
                echo json_encode(['success' => true, 'message' => 'Billing for this Space has been saved.'  ]);
            }
            else{
                echo json_encode(['success' => false, 'message' => $stmt1->error, 'err_status' => $err_status]);
            }

        } catch(Exception $e){
            echo json_encode(['success' => false, 'message' => $e, 'err_status' => $err_status]);
        }
    }
    

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST["saveUpdateSpaceBill"])) {

        $updBillAmount     = $_POST["updBillAmount"];
        $updPaymentStatus        = $_POST["updPaymentStatus"];
        $bill_id        = $_POST["bill_id"];
   
        try {
            $sqlinsert = "UPDATE tbl_billings_2 SET amount=$updBillAmount,paymentstatus='$updPaymentStatus', on_update=NOW() WHERE bill_id=$bill_id";
            // $con->query($sql);
            $stmt1 = $con->prepare($sqlinsert);

            if ($stmt1->execute()) {
                echo json_encode(['success' => true, 'message' => 'Billing for this Space has been saved.'  ]);

                $sql1 = "SELECT a.space_id, space_name, first_name, last_name, email, billtype,total FROM tbl_billings_2 a left join tbl_user b on a.tenant_id=b.user_id left join tbl_spaces c on a.space_id=c.space_id where a.bill_id=$bill_id";
                $result1 = $con->query($sql1);

                if ($result1->num_rows == 1) {
                    $row1 = $result1->fetch_assoc();         
                    $spaceName = $row1['space_name'];  
                    $tenantName = $row1['first_name'] . ' '. $row1['last_name'];  
                    $tenantEmail = $row1['email'];  
                    $billtype = $row1['billtype'];  
                    $amount = $row1['total'];  
                }

                $notiftitle='Space Payment Update';
                $notif_details= 'Hi '.$tenantName .'! Your payment for Space ('. $spaceName .') - '.$billtype.' has been reviewed. Your billing status has been updated to '. $updPaymentStatus;
                
                $InsertNotifQuery = "INSERT INTO tbl_notification(user_id, notif_title, notif_details,notif_type) SELECT tenant_id, '$notiftitle','$notif_details', 1 FROM tbl_billings_2 where bill_id = $bill_id";
                $insertResult = $con->query($InsertNotifQuery);

                sendEmailToTenant($tenantEmail, $tenantName, $updPaymentStatus, $spaceName, $billtype, $bill_id,$amount );
            }
            else{
                echo json_encode(['success' => false, 'message' => $stmt1->error, 'err_status' => $err_status]);
            }

        } catch(Exception $e){
            echo json_encode(['success' => false, 'message' => $e, 'err_status' => $err_status]);
        }
    }


    function sendEmailToTenant($email, $tenantName, $status, $spaceName,  $billtype, $billid, $amount )
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
            $mail->Subject = 'Space Payment Update';
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
                        <h1>Space Payment Update</h1>
                        <p>Dear $tenantName,</p>
                        <p>Your payment receipt for Space ($spaceName) has been reviewed! The status of your billing has been updated to $status.</p>
                        <p>BillID: $billid <br/>
                        BillType: $billtype <br/>
                        Amount: $amount </p>
                        <p>Regards,<br>COMS - automated</p>
                    </div>
                </body>
                </html>
            ";
    
            $mail->send();
    
            // echo json_encode(['success' => true, 'message' => 'Space Payment Update Emailed']);
        } catch(Exception $e){
            $error = $mail->ErrorInfo;
            echo json_encode(['success' => false, 'message' => $error]);
        }
    }

    
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST["profileSelectPhoto"])) {

    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === 0) {
        $bill_id=$_POST["bill_id"];
        $profileImage = $_FILES['profileImage'];
        $profileImage_tmp = $profileImage['tmp_name'];
        $profileImage_name = $profileImage['name'];
        $profileimage_extension   = pathinfo($profileImage_name, PATHINFO_EXTENSION);
        $profileImage_filename = uniqid("IMG_ReceiptImage_") . '.' . $profileimage_extension;
        $upload_directory = dirname(__DIR__, 2) . '/assets/uploads/receipt/'; // Define your upload directory path
        $upload_path = $upload_directory . $profileImage_filename;
        move_uploaded_file($profileImage_tmp , $upload_path); 

        if (!is_dir($upload_path)) {
            echo json_encode(['success' => true, 'message' => 'Image: '. $upload_path]);

            $sql = "UPDATE tbl_billings_2 SET receipt_img=? WHERE bill_id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ss", $profileImage_filename, $bill_id);
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Image: '. $profileImage_tmp]);

                $sql1 = "SELECT a.space_id, space_name, first_name, email, billtype, total FROM tbl_billings_2 a left join tbl_user b on a.owner_id=b.user_id left join tbl_spaces c on a.space_id=c.space_id where a.bill_id=$bill_id";
                $result1 = $con->query($sql1);

                if ($result1->num_rows == 1) {
                    $row1 = $result1->fetch_assoc();         
                    $spaceName = $row1['space_name'];  
                    $tenantName = $row1['first_name'];  
                    $tenantEmail = $row1['email'];  
                    $total = $row1['total'];  
                    $billtype = $row1['billtype'];  
                }

                $notiftitle='Space Payment Update';
                $notif_details= $_SESSION["first_name"]. ' ' .$_SESSION["last_name"]  . ' has uploaded their payment receipt for Space ('.$spaceName.') - '.$billtype.'.';
                
                $InsertNotifQuery = "INSERT INTO tbl_notification(user_id, notif_title, notif_details,notif_type) SELECT owner_id, '$notiftitle','$notif_details', 1 FROM tbl_billings_2 where bill_id = $bill_id";
                $insertResult = $con->query($InsertNotifQuery);

                sendEmailToOwner($tenantEmail, $_SESSION["first_name"], $spaceName, $tenantName, $billtype, $bill_id, $total);
            }
        }
    } else {
        $imagePath = 'Err';
        echo json_encode(['success' => false, 'message' => 'Image: '. $imagePath]);
    }
}


function sendEmailToOwner($email, $tenantName, $spaceName, $owner, $billtype, $billid, $total)
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
        $mail->Subject = 'Space Payment Update';
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
                    <h1>Space Payment Update</h1>
                    <p>Dear $owner,</p>
                    <p>$tenantName has uploaded their payment receipt for Space ($spaceName)!</p>
                    <p>BillID: $billid <br/>
                    BillType: $billtype <br/>
                    Amount: $total
                    </p>
                    <p>Regards,<br>COMS - automated</p>
                </div>
            </body>
            </html>
        ";

        $mail->send();

        // echo json_encode(['success' => true, 'message' => 'Space Payment Update Emailed']);
    } catch(Exception $e){
        $error = $mail->ErrorInfo;
        echo json_encode(['success' => false, 'message' => $error]);
    }
}


function sendBillingEmail($email, $tenantName, $spacename, $newElectricAmount,$newWaterAmount , $spaceprice)
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
        $mail->Subject = 'Space Billing Update';
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
                    <h1>Space Billing Update</h1>
                    <p>Dear $tenantName,</p>
                    <p>A new billing has been added to your account for the current rental period! The bill reflects
                    the amount due for your continued occupancy at Space ($spacename)</p>
                   
                    Electric Bill: $newElectricAmount
                    <br/>
                    Water Bill: $newWaterAmount
                    <br/>
                    Rent Bill: $spaceprice
                    </p>
                    <p>Thank you for your attention to this matter, and we appreciate your continued residency with us.</p>
                    <p>Regards,<br>COMS - automated</p>
                </div>
            </body>
            </html>
        ";

        $mail->send();

        // echo json_encode(['success' => true, 'message' => 'Space Payment Update Emailed']);
    } catch(Exception $e){
        $error = $mail->ErrorInfo;
        echo json_encode(['success' => false, 'message' => $error]);
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST["QRUpload"])) {

    if (isset($_FILES['QRImage']) && $_FILES['QRImage']['error'] === 0) {
        $account_no=$_POST["account_no"];
        $profileImage = $_FILES['QRImage'];
        $profileImage_tmp = $profileImage['tmp_name'];
        $profileImage_name = $profileImage['name'];
        $profileimage_extension   = pathinfo($profileImage_name, PATHINFO_EXTENSION);
        $profileImage_filename = uniqid("IMG_QRImage_") . '.' . $profileimage_extension;
        $upload_directory = dirname(__DIR__, 2) . '/assets/uploads/receipt/'; // Define your upload directory path
        $upload_path = $upload_directory . $profileImage_filename;
        $payment_id = 1;
        move_uploaded_file($profileImage_tmp , $upload_path); 

        if (!is_dir($upload_path)) {
            echo json_encode(['success' => true, 'message' => 'Image: '. $upload_path]);

            $sql = "UPDATE tbl_paymentmaster SET account_no=?, payment_qr=? WHERE payment_id=?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ssi", $account_no, $profileImage_filename, $payment_id);
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Image: '. $profileImage_tmp]);
            }
        }
    } else {
        $imagePath = 'Err';
        echo json_encode(['success' => false, 'message' => 'Image: '. $imagePath]);
    }
}

?>