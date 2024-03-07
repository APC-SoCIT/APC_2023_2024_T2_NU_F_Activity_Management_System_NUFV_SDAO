<?php
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
    if (isset($_GET['org'])) {
        $org = $_GET['org'];
        

        $sname = "localhost:3307";
        $uname = "root";
        $password = "";
        $db_name = "sarf";

        $conn = new mysqli($sname, $uname, $password, $db_name);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
 
        $sql = "SELECT name, program_organization, activity_title, activity_datetime, target_participants, activity_types, activity_options, sdao_options FROM sarf_requests WHERE program_organization = '$org'" ;
        $result = $conn->query($sql);

        $nextToSdao = '';

        if ($sdaoStatus == 'approved'){
            $nextToSdao = 'Facility Management Office';
        }

        

        if (!$result) {
            die("Query failed: " . $conn->error);
        }

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $conn->close();
        } else {
            die("No records found for organization: " . $org);
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/lrc_itso_hm.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="functions.js"></script>
    <title>Document</title>
    <style>
        .itso_lrc_hmStatus{
            width: 100%;
            height: 100%;
            display: flex;
        }
        .leftActivityDetails2{
            width: 70%;
            height: 100%;
            display: flex;
            flex-direction: column;
            border: solid 1px;
        }
        .rightActivityDetails2{
            width: 30%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding-top: 22%;
            border: solid 1px;
        }
    </style>


</head>
<body>
    <div class="itso_lrc_hmStatus">
        <div class="leftActivityDetails2">
            
            




        </div>
                    <div class="rightActivityDetails2">
                        <div class="attachmentBox" style=" height: 190px; width: 300px; padding-bottom: 20px; font-family: sans-serif; font-weight: bold; font-size: 24px; display: flex; flex-direction:column; align-items:center;">
                        Attachment
                        <div class="fileAttach" style="border:solid 1px; height: 40px; width:250px; border-radius: 45px; margin-top: 20px;"></div>

                        <div class="rejectApproveBtnContainer" style="display: flex; align-items:center; width: 250px; height: 50px; justify-content: space-between; margin-top: 20px;">
                        <div class="rejectBtn" style="width: 110px; height: 45px; border-radius: 28px; background-color: rgba(247, 88, 88, 1); display: flex; justify-content: center; align-items: center; font-size: 16px; cursor: pointer;">Reject</div>
                        <div class="approveBtn" style="width: 110px; height: 45px; border-radius: 28px; background-color: rgba(153, 217, 71, 1); display: flex; justify-content: center; align-items: center; font-size: 16px; cursor: pointer;">Approve</div>
                        </div>
                        
                        </div>
                    </div>
    </div>
     
    
</body>
</html>

<?php
} else{
    header("Location: Loginpage.php");
    exit();
}
?>