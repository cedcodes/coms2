<?php 
    session_name("user_session");
    session_start();

    include('../../config/dbconnection/databaseconfig.php');
    $user_id = $_SESSION["user_id"];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST["dashboardfigures"])) {
    
        try{
            $sql = "SELECT * FROM (SELECT COUNT(*) AS Total FROM `tbl_spaces` where owner_id=$user_id) A
            CROSS JOIN (SELECT COUNT(*) AS TotalOccupied FROM `tbl_spaces`  WHERE status=2 and  owner_id=$user_id) B 
            CROSS JOIN (SELECT COUNT(*) AS TotalReserved FROM `tbl_spaces` WHERE status=1 and owner_id=$user_id) C 
            CROSS JOIN (SELECT COUNT(*) AS TotalAvailable FROM `tbl_spaces` WHERE status=0 and  owner_id=$user_id) D
            CROSS JOIN (SELECT COUNT(*) AS NewApplication FROM `tbl_tenant_application` WHERE is_approved=0 and  owner_id=$user_id) E 
            CROSS JOIN (SELECT IFNULL(SUM(IFNULL(Total,0)),0) AS TotalBilling FROM `tbl_billings_2` WHERE paymentstatus='unpaid' and  owner_id=$user_id) F
            CROSS JOIN (SELECT IFNULL(SUM(IFNULL(Total,0)),0) AS TotalBillingE FROM `tbl_billings_2` WHERE paymentstatus='unpaid'  and  owner_id=$user_id and billtype='UtilityBill-Electricity') G
            CROSS JOIN (SELECT IFNULL(SUM(IFNULL(Total,0)),0) AS TotalBillingW FROM `tbl_billings_2` WHERE paymentstatus='unpaid'  and  owner_id=$user_id and billtype='UtilityBill-Water') H
            CROSS JOIN (SELECT IFNULL(SUM(IFNULL(Total,0)),0) AS TotalBillingR FROM `tbl_billings_2` WHERE paymentstatus='unpaid'  and  owner_id=$user_id and billtype='Rent') I
            CROSS JOIN (SELECT IFNULL(SUM(IFNULL(Total,0)),0) AS TotalBillingS FROM `tbl_billings_2` WHERE paymentstatus='unpaid'  and  owner_id=$user_id and billtype='SecurityDeposit') J;";
            $result = $con->query($sql);      
            $arr_rows = array();	

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();         
                $arr_rows['Total'] = $row['Total'];  
                $arr_rows['TotalOccupied'] = $row['TotalOccupied'];  
                $arr_rows['TotalReserved'] = $row['TotalReserved'];  
                $arr_rows['TotalAvailable'] = $row['TotalAvailable'];  
                $arr_rows['NewApplication'] = $row['NewApplication'];  
                $arr_rows['TotalBilling'] = $row['TotalBilling'];  
                $arr_rows['TotalBillingE'] = $row['TotalBillingE'];  
                $arr_rows['TotalBillingW'] = $row['TotalBillingW'];  
                $arr_rows['TotalBillingR'] = $row['TotalBillingR'];  
                $arr_rows['TotalBillingS'] = $row['TotalBillingS'];  
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

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST["viewbillperconcourse"])) {
        try{
            $sql = "SELECT con_name,billtype, SUM(Total) AS TotalBilling FROM `tbl_billings_2` a LEFT JOIN tbl_spaces b on a.space_id=b.space_id left join tbl_concourse c on b.con_id=c.con_id WHERE paymentstatus='unpaid' and a.owner_id=$user_id GROUP BY billtype, con_name order by con_name, billtype;";
            $result = mysqli_query($con, $sql);
            $arr_rows = array();	
            $records = array();

            while ($row = mysqli_fetch_assoc($result)) {
                $arr_rows = array(
                    "con_name" => $row['con_name'],
                    "billtype" => $row['billtype'],
                    "TotalBilling" => $row['TotalBilling'],
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


?>

