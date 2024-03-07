<?php
session_start();

if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
    include "db_conn2.php";
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['organization'])) {
        $organization = mysqli_real_escape_string($conn, $_GET['organization']);

        $sql = "SELECT * FROM files WHERE program_organization = '$organization' ORDER BY upload_date DESC";

        $result = $conn->query($sql);

        if ($result) {
?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title><?php echo $organization; ?> Summary</title>
                
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
                        font-family: sans-serif;
                    }

                    .table th {
                        background-color: #f2f2f2;
                    }


                    .table tr:hover {
                        background-color: #ddd;
                    }
                    a {
                        text-decoration: none;
                        color: inherit;
                    }
                    .goBackTimelineBtn{
                        background-color: rgba(246, 205, 45, 1);
                        border: none;
                        height: 35px;
                        width:  90px;
                        border-radius: 20px;
                        cursor: pointer;
                        font-weight: bold;
                        margin-left: 10px;
                    }

                </style>
            </head>
            <body>
            <div class="split-background">
            <div class="left">
            
            </div>
        </div>
                    <div class="right">
                        <div class="title">
                            <h1 class="h1Title" style="font-family: sans-serif; padding-left: 10px;"><?php echo $organization; ?> Summary</h1>
                            <div class="lineSeparator"><br>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Report Date</th>
                                            <th>Activity Title</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                        ?>
                                                <tr>
                                                    <td><?php echo date("Y-m-d h:i A",strtotime($row['upload_date'])) ?></td>
                                                    <td><?php echo $row['activity_title']; ?></td>
                                                </tr>
                                        <?php
                                            }
                                        } else {
                                        ?>
                                            <tr>
                                                <td colspan="2">No reports available for <?php echo $organization; ?>.</td>
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
                <button class="goBackTimelineBtn" onclick="loadContent('Timeline')">Back</button>

                <script>
                function loadContent(Page){
                    window.location.href = `Navbarpage.php?Page=${Page}`;
                }
    </script>

            </body>
            </html>
<?php
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        header("Location: Homepage.php");
        exit();
    }

    $conn->close();
} else {
    header("Location: Loginpage.php");
    exit();
}
?>
