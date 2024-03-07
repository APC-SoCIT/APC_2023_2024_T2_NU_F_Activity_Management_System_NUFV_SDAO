<?php

session_start();


if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
    $valueOfEmail = $_SESSION['email'];
    include "db_conn2.php";


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT f.filename ,f.upload_date, f.activity_title, s.activity_types, s.program_organization 
    FROM files f 
    JOIN sarf_requests s ON f.activity_title = s.activity_title";

    $result = $conn->query($sql);

  
    if ($result) {
?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="CSS/Reports.css">
            <title>Uploaded Files</title>
            <style>
                .table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }

                .table th, .table td {
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

                .btn {
                    background-color: #90EE90;
                    color: white;
                    padding: 8px 12px;
                    text-decoration: none;
                    border: none;
                    border-radius: 20px;
                    cursor: pointer;
                    display: inline-block;
                    transition: backkground-color 0.3s ease;
                    text-align: center;
                }
                .btn:hover {
                    background-color: #0056b3;
                }
                .dropdown-container {
                    text-align: right;
                    margin-bottom: 20px;
                }

                #sortDropdown {
                    margin-right: 20px;
                }
            </style>
        </head>
        <body>
            <div class="split-background">

                </div>

                <div class="right">
                    <div class="title">
                    <h1 class="h1Title">Field End Event Report</h1>
                        <div class="lineSeparator">
                            <p class="reminderText">This page provides a comprehensive summary of the activities, achievements, and challenges faced by our student organization during the specified reporting period</p>
                        </div>
                      
            </div>
<div class="Content">
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
                                    ?>
                                            <tr>
                                                <td><?php echo $row['activity_title']; ?></td>
                                                <td><?php echo $row['activity_types']; ?></td>
                                                <td><?php echo $row['program_organization']; ?></td>
                                                <td><?php echo $row['upload_date']; ?></td>
                                                <td><a href="<?php echo $file_path; ?>" class="btn btn-primary" download>Download File</a></td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                    ?>
                                        <tr>
                                            <td colspan="7">No files uploaded yet.</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>

</div>
                            
                        
                    
                </div>
            </div>

        </body>
        </html>
<?php
    } else {
        echo "Error: " . $conn->error;
    }

    
    $conn->close();
} else {
    header("Location: Loginpage.php");
    exit();
}
?>