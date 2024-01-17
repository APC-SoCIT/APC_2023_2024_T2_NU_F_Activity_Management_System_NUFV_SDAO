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


    $sql = "INSERT INTO $db_name.student_activity_requests (facilities_requirements, remarks_facilities, classnum, otherfaci, learning_resource_center, remarks_tables, remarks_chairs, hotel_management, itso, itso_other, others_indicate, user_id)
            VALUES ('$facilitiesRequirements', '$remarksFacilities', '$classnum', '$otherfaci', '$learningResourceCenter', '$remarksLearningResourceCenterTables', '$remarksLearningResourceCenterChairs', '$hotelManagement', '$itso', '$itsother', '$othersIndicate', '$user_id')";

    $result = $conn->query($sql);

    if ($result === TRUE) {
        echo "Form Submitted Successfully"; 
        header("Location: StudSarfpage.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>