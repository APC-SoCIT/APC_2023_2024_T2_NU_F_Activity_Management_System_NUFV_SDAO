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
    <link rel="stylesheet" href="CSS/approvalprogress.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="functions.js"></script>
    <title>Document</title>
</head>
<body>

      <div class="split-background">

        <div class="right">
        <div class="titleBox">
            <div class="upperTitle">
            <h1 class="h1Title">APPROVAL WORKFLOW</h1>
           
           <div class="lineSeparator"></div>

            </div>

            </div>
            <div class="Content">
                <div class="circleProgressContainer">

                    <div id="Requester" class="statusDiv">    
                        <div class="circleContainer">
                            <div class="circle"><img src="IMG/check.png" class="imgCheck" draggable="false"></div>
                            <div class="lineNextToCircle"></div>

                        </div>
                        <div class="circleDetails">
                            <p style="font-weight: bold; font-size: 14px; margin-top: 4px;">Requester</p>
                            <p style="font-size: 12px; margin-top: 2px;"><?php echo $row['program_organization']?> - <?php echo $row['activity_options']?></p>
                            <p style="font-size: 12px; font-weight: bold; background-color: rgba(153, 217, 71, 1); margin-top: 2px;
                            width: 80px; height: 25px; align-items:center; display: flex; justify-content: center; border-radius: 6px;">SUBMITTED</p>
                            <p style="font-size: 12px;"><?php echo $row['activity_datetime'] ?></p>


                        </div>
                    </div>

                    <div id="SDAO" class="statusDiv">
                    <div class="circleContainer">
                            <div><img src="IMG/3dotsPending.png" style="background-color: rgba(245, 215, 98, 1);
                            height: 34px; width: 37px; height: 37px; width: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center;" draggable="false"></div>
                            <div style=" width: 100%; background-color: rgba(217, 217, 217, 1); height: 1.5px; margin-left: 5px;margin-right: 5px;"></div>

                        </div>
                        <div class="circleDetails">
                            <p style="font-weight: bold; font-size: 14px; margin-top: 4px;">SDAO</p>
                            <p style="font-size: 12px; margin-top: 2px;">Ernilson C. Caindoy</p>
                            <p style="font-size: 12px; font-weight: bold; background-color: rgba(245, 215, 98, 1); margin-top: 2px;
                            width: 80px; height: 25px; align-items:center; display: flex; justify-content: center; border-radius: 6px;">PENDING</p>
                            <p style="font-size: 12px;"><?php echo $row['activity_datetime'] ?></p>
                        </div>
                    </div>

                    <div id="LRC" class="statusDiv">
                    <div class="circleContainer">
                            <div><img src="IMG/grayStatus.png" style="background-color: rgba(217, 217, 217, 1);
                            height: 34px; width: 37px; height: 37px; width: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center;" draggable="false"></div>
                            <div style=" width: 100%; background-color: rgba(217, 217, 217, 1); height: 1.5px; margin-left: 5px;margin-right: 5px;"></div>

                        </div>
                        <div class="circleDetails">
                        </div>
                        
                    </div>

                    <div id="FMO" class="statusDiv"></div>
                    <div id="ASD" class="statusDiv"></div>
                    <div id="SAD" class="statusDiv"></div>
                    <div id="ED" class="statusDiv"></div>



                </div>
                <div class="activityDetailsContainer">
                    <div class="leftActivityDetails">
                        <div class="firstLine">Event Details</div>

                        <div class="secondLine"><div class="Name">Name<div>:</div></div> 
                        <div class="nameDisplay"><?php echo $row['name']?></div>
                        </div>

                        <div class="thirdLine"><div class="NameofOrg">Name of Program / Organization / Club <div>:</div></div>
                        <div class="orgDisplay"><?php echo $row['program_organization']?></div>
                        </div>
                        
                        <div class="fourthLine"><div class="themeOFAct">Title / Theme of Activity <div>:</div></div>
                        <div class="themeDisplay"><?php echo $row['activity_title']?></div>
                        </div>

                        <div class="fifthLine"><div class="dateTimeOfAct">Date / Time of the Activity <div>:</div></div>    
                        <div class="dateTimeDisplay"><?php echo $row['activity_datetime']?></div>
                        </div>

                        <div class="sixthLine"><div class="noOfParticipants">Target No. of Participants <div>:</div></div>
                        <div class="participantsDisplay"><?php echo $row['target_participants']?></div>
                        </div>
                        <div class="seventhLine"><div class="typeOfAct">Type of Activity <div>:</div></div>
                        <div class="typeOfActDisplay"><?php echo $row['activity_types']?></div>
                        </div>

                        <div class="eighthLine"><div class="activityDesc">Activity Inclusion / Description <div>:</div></div>
                        <div class="actDescDisplay"><?php echo $row['activity_options']?></div>
                        </div>

                        <div class="ninthLine"><div class="typeOfBudget">Type of Budget <div>:</div></div>
                        <div class="typeOfBudgetDisplay"><?php echo $row['sdao_options']?></div>
                        </div>
                     

                    </div>

                    <div class="rightActivityDetails">

                    </div>





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