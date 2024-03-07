<?php
include('db_conn2.php');


$query = $conn->query("SELECT sr.*, st.ed, st.sad, st.asd FROM sarf_requests sr
                        LEFT JOIN status_of_requests st ON sr.user_id = st.user_id
                        ORDER BY sr.id");

if (!$query) {
    die("Query failed: " . $conn->error);
}

$events = array();
while ($row = $query->fetch_object()) {
    $status = $row->ed;
    if($status == 'none'){
        $status = $row->sad;
        if($status == 'none'){
            $status = $row->asd;
        }
    }
    
    $color = '#3366cc';

    if ($status == 'pending') {
        $color = '#FFDB58';
    } elseif ($status == 'approved') {
        $color = '#90EE90';
    } elseif ($status == 'rejected') {
        $color = '#EE4B2B';
    }

    $events[] = array(
        'id' => $row->id,
        'title' => $row->activity_title,
        
        'start' => date("Y-m-d H:i:s", strtotime($row->activity_datetime)),
        'end' => date("Y-m-d H:i:s", strtotime($row->activity_end_datetime)),
        'program_organization' => $row->program_organization,
        'color' => $color,
        'textColor' => '#000000'
    );
}

echo json_encode($events);
?>
