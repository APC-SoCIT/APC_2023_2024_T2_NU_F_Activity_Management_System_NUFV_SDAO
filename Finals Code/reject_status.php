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

    $sqlDeleteStatusOfRequests = "DELETE FROM sarf.status_of_requests WHERE user_id = $userId";
    $resultDeleteStatusOfRequests = $conn->query($sqlDeleteStatusOfRequests);

    $sqlDeleteSarfRequests = "DELETE FROM sarf.sarf_requests WHERE user_id = $userId";
    $resultDeleteSarfRequests = $conn->query($sqlDeleteSarfRequests);

    $sqlDeleteStudentActivityRequests = "DELETE FROM sarf.student_activity_requests WHERE user_id = $userId";
    $resultDeleteStudentActivityRequests = $conn->query($sqlDeleteStudentActivityRequests);

    $sqlDeleteStatusResponse = "DELETE FROM sarf.status_response WHERE user_id = $userId";
    $resultDeleteStatusResponse = $conn->query($sqlDeleteStatusResponse);

    if (!$resultDeleteStatusOfRequests && !$resultDeleteSarfRequests && !$resultDeleteStudentActivityRequests && !$resultDeleteStatusResponse) {
        die("Query failed: " . $conn->error);
    }

    $conn->close();
}

