<?php
// Ensure that sessions are started before any output
session_start();

include "db_conn2.php";

// Check if the database connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle filtering by organization
$filter_query = "";
if (isset($_POST['filter_organization']) && !empty($_POST['filter_organization'])) {
    $organization = $_POST['filter_organization'];
    $filter_query = " WHERE s.program_organization = '$organization'";
}

// Handle sorting by date
$date_sort_query = "";
if (isset($_POST['date_sort']) && ($_POST['date_sort'] == 'ASC' || $_POST['date_sort'] == 'DESC')) {
    $date_sort = $_POST['date_sort'];
    $date_sort_query = " ORDER BY f.upload_date $date_sort";
}

// SQL query to select all files along with their corresponding activity titles, types, and organizations
$sql = "SELECT f.filename, f.upload_date, f.activity_title, s.activity_types, s.program_organization 
        FROM files f 
        JOIN sarf_requests s ON f.activity_title = s.activity_title" . $filter_query . $date_sort_query;

$result = $conn->query($sql);

// Check if the query was successful
if ($result) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>End Activity Files</title>
    <style>
.table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.table th,
.table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
    vertical-align: middle;
}

.table th {
    background-color: #f2f2f2;
}

.table tr:hover {
    background-color: #ddd;
}

/* Styles for buttons */
.btn {
    background-color: #90EE90;
    color: white;
    padding: 8px 12px;
    text-decoration: none;
    border: none;
    border-radius: 20px;
    cursor: pointer;
    display: inline-block;
    transition: background-color 0.3s ease;
    text-align: center;
}

.btn:hover {
    background-color: #0056b3;
}
form {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-end;
    margin-bottom: 10px; /* Adjust as needed */
}

form select,
form input[type="submit"] {
    margin-left: 10px; /* Adjust as needed */
    margin-bottom: 10px; /* Adjust as needed */
}
</style>
   
</head>
<body>
<div class="split-background">

</div>

    <div class="right">
    <div class="title">
        <h1 class="h1Title">Field End Event Report</h1>
        <div class="lineSeparator"><br>
            <p>This page provides a comprehensive summary of the activities, achievements, and challenges faced by our student organization during the specified reporting period</p><br><Br><br>
            <form action="" method="post">
        <select name="filter_organization">
        <option value="">Filter by Organization</option>
        <?php
        $org_query = "SELECT DISTINCT program_organization FROM sarf_requests";
        $org_result = $conn->query($org_query);
        if ($org_result->num_rows > 0) {
            while ($row = $org_result->fetch_assoc()) {
                $organization = $row['program_organization'];
                echo "<option value='$organization'>$organization</option>";
            }
        }
        ?>
    </select>
    <!-- Dropdown for sorting by date -->
    <select name="date_sort">
        <option value="">Sort by Date</option>
        <option value="ASC">Date Ascending</option>
        <option value="DESC">Date Descending</option>
    </select>
    <input type="submit" value="Sort">
</form>


    <table class="table">
        <thead>
            <tr>
                <th>Activity Name</th>
                <th>Activity Type</th>
                <th>Program Organization</th>
                <th>Date</th>
                <th>PDF</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $file_path = "uploads/" . $row['filename'];
                    echo "<tr>";
                    echo "<td>" . $row['activity_title'] . "</td>";
                    echo "<td>" . $row['activity_types'] . "</td>";
                    echo "<td>" . $row['program_organization'] . "</td>";
                    echo "<td>" . $row['upload_date'] . "</td>";
                    echo "<td><a href='$file_path' class='btn btn-primary' download>Download File</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No files uploaded yet.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
<?php
} else {
    echo "Error: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
