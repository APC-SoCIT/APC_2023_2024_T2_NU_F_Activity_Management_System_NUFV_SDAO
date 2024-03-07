<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sname = "localhost:3307";
    $uname = "root";
    $password = "";
    $db_name = "sarf";

    $usersDBHost = "localhost:3307";
    $usersDBUser = "root";
    $usersDBPassword = "";
    $usersDBName = "nu_accountsdb";

    $conn = mysqli_connect($sname, $uname, $password, $db_name);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    mysqli_select_db($conn, $usersDBName);

    $user_email = $_SESSION['email'];
    $getUserIDQuery = "SELECT id FROM studentaccounts WHERE email = '$user_email'";
    $result = $conn->query($getUserIDQuery);

   
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['id'];
    
    }
    $sqlGetPageOneDetails = "SELECT activity_types, amount FROM sarf.sarf_requests WHERE user_id = '$user_id'";
    $resultPageOne = $conn->query($sqlGetPageOneDetails);
    $rowResultPageOne = $resultPageOne->fetch_assoc();
    $activityTypes = $rowResultPageOne['activity_types'];
    $amount = $rowResultPageOne['amount'];

    $facilitiesRequirements = isset($_POST["Facilities_Requirements"]) ? implode(", ", $_POST["Facilities_Requirements"]) : "";
    $remarksFacilities = isset($_POST["facitxt"]) ? $_POST["facitxt"] : "";
    $classnum = isset($_POST["classnum"]) ? $_POST["classnum"] : "";
    $otherfaci = isset($_POST["otherfaci"]) ? $_POST["otherfaci"] : "";
    $learningResourceCenter = isset($_POST["Learning_Resource_Center"]) ? implode(", ", $_POST["Learning_Resource_Center"]) : "";
    $remarksLearningResourceCenterTables = isset($_POST["remarks_tables"]) ? $_POST["remarks_tables"] : "";
    $remarksLearningResourceCenterChairs = isset($_POST["remarks_chairs"]) ? $_POST["remarks_chairs"] : "";
    $hotelManagement = isset($_POST["Hotel_Management"]) ? implode(", ", $_POST["Hotel_Management"]) : "";
    $itso = isset($_POST["ITSO"]) ? implode(", ", $_POST["ITSO"]) : "";
    $itsother = isset($_POST["itso_other"]) ? $_POST["itso_other"] : "";
    $othersIndicate = isset($_POST["others_indicate"]) ? $_POST["others_indicate"] : "";

    if($activityTypes == 'Internal (within the campus)' && $amount <= 5000.00){
        $insertED = 'none';
    } else{
        $insertED = 'pending';
    }

    if($amount <= 2000.00){
        $insertSAD = 'none';
    } else {
        $insertSAD = 'pending';
    }

    if (empty($facilitiesRequirements) && empty($classnum) && empty($otherfaci)){
        $facilitiesRequirements = 'none';
        $insertFR = 'none';
    }
    else{
        $insertFR = 'pending';
    }

    if (empty($learningResourceCenter) && empty($remarksLearningResourceCenterTables) && empty($remarksLearningResourceCenterChairs)) {
        $learningResourceCenter = 'none';
        $insertLRC = 'none';
    }
    else{
        $insertLRC = 'pending';
    }

    if (empty($hotelManagement)) {
        $hotelManagement = 'none';
        $insertHM = 'none';
    }
    else{
        $insertHM = 'pending';
    }

    if (empty($itso) && empty($itsother) && empty($othersIndicate)) {
        $itso = 'none';
        $insertItso = 'none';
    }
    else{
        $insertItso = 'pending';
    }


    $sql = "INSERT INTO $db_name.student_activity_requests (facilities_requirements, remarks_facilities, classnum, otherfaci, learning_resource_center, remarks_tables, remarks_chairs, hotel_management, itso, itso_other, others_indicate, user_id)
            VALUES ('$facilitiesRequirements', '$remarksFacilities', '$classnum', '$otherfaci', '$learningResourceCenter', '$remarksLearningResourceCenterTables', '$remarksLearningResourceCenterChairs', '$hotelManagement', '$itso', '$itsother', '$othersIndicate', '$user_id')";

    $sqlStatus = "INSERT INTO sarf.status_of_requests (user_id, org_adviser, cd, prog_chair, sdao, fmo, itso, lrc, hm, asd, sad, ed) VALUES ('$user_id', 'pending', 'pending', 'pending', 'pending', '$insertFR', '$insertItso', '$insertLRC', '$insertHM', 'pending', '$insertSAD', '$insertED')";

    $result = $conn->query($sql);
    
    $resultSqlStatus = $conn->query($sqlStatus);


    if ($result === TRUE && $resultSqlStatus) {
        $_SESSION['form_submitted'] = true;
        header("Location: StudentProposal.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
