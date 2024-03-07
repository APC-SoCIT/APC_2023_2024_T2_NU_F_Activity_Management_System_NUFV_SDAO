<?php
session_start();

if (isset($_POST['org'])) {
    $org = $_POST['org'];

    $sname = "localhost:3307";
    $uname = "root";
    $password = "";
    $db_name = "sarf";

    $conn = new mysqli($sname, $uname, $password, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sqlUserId = "SELECT user_id FROM sarf_requests WHERE program_organization = '$org'";
    $resultUserId = $conn->query($sqlUserId);

    if (!$resultUserId) {
        die("Query failed: " . $conn->error);
    }

    $rowUserId = $resultUserId->fetch_assoc();
    $userId = $rowUserId['user_id'];

    // Use the actual user ID value in the update query
    $sqlOrgAdvStatus = "UPDATE sarf.status_of_requests SET org_adviser = 'approved' WHERE user_id = $userId";
    $resultOrgAdv = $conn->query($sqlOrgAdvStatus);

    if (!$resultOrgAdv) {
        die("Query failed: " . $conn->error);
    }


    $sqlinsertDtResponse = "UPDATE sarf.status_response SET oa_dt_response = NOW() WHERE user_id = $userId";
    if ($conn->query($sqlinsertDtResponse) === TRUE) {
        echo "Record inserted successfully";
    } else {
        echo "Error: " . $sqlinsertDtResponse . "<br>" . $conn->error;
    }

    $conn->close();
}

