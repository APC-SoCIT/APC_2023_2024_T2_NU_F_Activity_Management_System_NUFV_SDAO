<?php
session_start();

if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
    include "db_conn2.php";

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT program_organization, COUNT(*) as total_events FROM files GROUP BY program_organization ORDER BY total_events DESC";

    $result = $conn->query($sql);
    if ($result) {
?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Uploaded Files</title>
            <link rel="stylesheet" href="CSS/Timeline.css">
            <style>
                /* Add your table styling here */
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
                    width: 50%;
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
                a {
                    text-decoration: none;
                    color: inherit;
                }

            </style>
        </head>
        <body>
            <div class="split-background">

                </div>

                <div class="right">
                    <div class="title">
                        <h1 class="h1Title">Organization Tally</h1>
                        <div class="lineSeparator">
                            <p class="reminderText">It displays the number of successful events organized by each organization, providing valuable insights into their contributions to the campus' community.</p><br><Br><br>


                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Organization</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                    ?>
                                            <tr>
                                            <td><a href="DirTimeline2.php?organization=<?php echo urlencode($row['program_organization']); ?>"><?php echo $row['program_organization']; ?></a></td>
                                                <td><?php echo $row['total_events']; ?></td>
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
            </div>
        

        </body>
        </html>
        
<?php
    } else {
        echo "Error: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // Redirect the user to the login page if not logged in
    header("Location: Loginpage.php");
    exit();
}
?>
