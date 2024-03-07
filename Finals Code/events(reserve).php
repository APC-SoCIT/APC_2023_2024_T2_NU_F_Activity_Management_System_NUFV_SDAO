<?php
include('db_conn2.php');

$query = $conn->query("SELECT * FROM sarf_requests ORDER BY id");

if (!$query) {
    die("Query failed: " . $conn->error);
}

$events = array();
while ($row = $query->fetch_object()) {

    $events[] = array(
        'id' => $row->id,
        'title' => $row->activity_title,  // Corrected field name
        'start' => date("Y-m-d H:i:s", strtotime($row->activity_datetime)),
    );
}

echo json_encode($events);
?>
