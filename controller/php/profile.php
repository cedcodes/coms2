<?php 
session_name("user_session");
session_start();

include('../../config/dbconnection/databaseconfig.php');


$user_id = $_SESSION["user_id"];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST["profileview"])) {
    $sql = "SELECT * FROM tbl_user WHERE user_id = '$user_id'";
    $result = $con->query($sql);
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        $arr_rows = array();	
        $arr_rows['usertype'] = $row['acct_type'];
        $arr_rows['username'] = $row['username'];
        $arr_rows['email'] = $row['email']; 
        $arr_rows['contact_no'] = $row['contact_no'];
        $arr_rows['date_added'] = $row['date_added'];
        $arr_rows['first_name'] = $row['first_name'];
        $arr_rows['middle_name'] = $row['middle_name'];
        $arr_rows['last_name'] = $row['last_name'];
        $arr_rows['address'] = $row['address'];
        $arr_rows['gender'] = $row['gender'];
        $arr_rows['birthdate'] = $row['birthdate'];
        $arr_rows['profile_img'] = $row['profile_img'];

        $records[] = $arr_rows;
        $output = array(			
            "data"	=> 	$records
        );
        
        echo json_encode(['success' => true, 'data' => $output]);
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST["profilesavechanges"])) {

     $username     = $_POST["username"];
     $email        = $_POST["email"];
     $contact_no   = $_POST["contact_no"];
     $first_name   = $_POST["first_name"];
     $last_name    = $_POST["last_name"];
     $address      = $_POST["address"];
     $gender       = $_POST["gender"];
     $birthdate    = $_POST["birthdate"];
    
    try{
        $sql = "UPDATE tbl_user SET username=?, email=?, contact_no=?, first_name=?, last_name=?, address=?, gender=?, birthdate=? WHERE user_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sssssssss", $username, $email, $contact_no, $first_name, $last_name, $address, $gender, $birthdate, $user_id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Your changes has been saved.']);
        }
    }
    catch (Exception $e){
        echo json_encode(['error'=>'Caught exception: ',  $e->getMessage(), "\n"]);
    }	
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST["profileChangePhoto"])) {

    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === 0) {

        $profileImage = $_FILES['profileImage'];
        $profileImage_tmp = $profileImage['tmp_name'];
        $profileImage_name = $profileImage['name'];
        $profileimage_extension   = pathinfo($profileImage_name, PATHINFO_EXTENSION);
        $profileImage_filename = uniqid("IMG_ProfileImage_") . '.' . $profileimage_extension;
        $upload_directory = dirname(__DIR__, 2) . '/assets/uploads/user/'; // Define your upload directory path
        $upload_path = $upload_directory . $profileImage_filename;
        move_uploaded_file($profileImage_tmp , $upload_path); 

        if (!is_dir($upload_path)) {
            echo json_encode(['success' => true, 'message' => 'Image: '. $upload_path]);

            $sql = "UPDATE tbl_user SET profile_img=? WHERE user_id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ss", $profileImage_filename, $user_id);
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