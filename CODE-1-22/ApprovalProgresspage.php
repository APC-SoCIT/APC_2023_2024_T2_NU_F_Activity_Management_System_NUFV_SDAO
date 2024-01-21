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

        $sqlUserId = "SELECT user_id FROM sarf_requests WHERE program_organization = '$org'";
        $resultUserId = $conn->query($sqlUserId);
    
        if (!$resultUserId) {
            die("Query failed: " . $conn->error);
        }
    
        $rowUserId = $resultUserId->fetch_assoc();
        $userId = $rowUserId['user_id'];

       $statusOfSdao = "SELECT sdao from status_of_requests WHERE user_id = $userId";
       $resultStatusOfSdao = $conn->query($statusOfSdao);
       $rowStatusOfSdao = $resultStatusOfSdao->fetch_assoc();
       $sdaoStatus = $rowStatusOfSdao['sdao'];
       $sdaoStatusUC = strtoupper($sdaoStatus);

       
       $statusOfFmo = "SELECT fmo from status_of_requests WHERE user_id = $userId";
       $resultStatusOfFmo = $conn->query($statusOfFmo);
       $rowStatusOfFmo = $resultStatusOfFmo->fetch_assoc();
       $fmoStatus = $rowStatusOfFmo['fmo'];
       $fmoStatusUC = strtoupper($fmoStatus);

       $pendingCSS = 'font-size: 10px; font-weight: bold; background-color: rgba(245, 215, 98, 1); margin-top: 4px;
       width: 68px; height: 18px; align-items:center; display: flex; justify-content: center; border-radius: 6.8px;';
       
       $approvedCSS = 'font-size: 10px; font-weight: bold; background-color: rgba(153, 217, 71, 1); margin-top: 4px;
       width: 68px; height: 18px; align-items:center; display: flex; justify-content: center; border-radius: 6.8px;';
       
       $approvedImageSrc = 'IMG/check.png';
       $pendingImageSrc = 'IMG/3dotsPending.png';
       $grayPic = 'IMG/grayStatus.png';
       $ImgBackgroundColorPending = 'background-color: rgba(245, 215, 98, 1); height: 30px; width: 30px; border-radius: 50%; 
       display: flex; align-items: center; justify-content: center;';
       $ImgBackgroundColorApproved = 'background-color: rgba(151, 239, 120, 1); height: 30px; width: 30px; border-radius: 50%; 
       display: flex; align-items: center; justify-content: center; padding: 1px;';

       $grayImgBackgroundColor = 'background-color: rgba(217, 217, 217, 1); height: 30px; width: 30px; 
       border-radius: 50%; display: flex; align-items: center; justify-content: center;';

       if ($sdaoStatus == 'approved' && $fmoStatus == 'pending') {
        $currentCSS = $approvedCSS;
        $currentStatusImgSrc = $approvedImageSrc;
        $currentImgBackgroundColor = $ImgBackgroundColorApproved;
        $ImgSrcGray = $grayPic;
        $ImgBackgroundColorGray = $grayImgBackgroundColor;
        } else if($sdaoStatus == 'pending') {
        $currentCSS = $pendingCSS;
        $currentStatusImgSrc = $pendingImageSrc;
        $currentImgBackgroundColor = $ImgBackgroundColorPending;
        $ImgSrcGray = $grayPic;
        $ImgBackgroundColorGray = $grayImgBackgroundColor;
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
                            <div class="circle"><img src="IMG/check.png" class="imgCheckRequester" draggable="false"></div>
                            <div style=" width: 55px; background-color: rgba(217, 217, 217, 1); height: 1.5px; margin-left: 5px;margin-right: 5px;"></div>

                        </div>
                        <div class="circleDetails" style="word-wrap:break-word;">
                            <p style="font-weight: bold; font-size: 10px; margin-top: 4px;">Requester</p>
                            <p style="font-size: 10px; margin-top: 4px;"><?php echo $row['program_organization']?> - <?php echo $row['activity_options']?></p>
                            <p style="font-size: 10px; font-weight: bold; background-color: rgba(153, 217, 71, 1); margin-top: 4px;
                            width: 68px; height: 18px; align-items:center; display: flex; justify-content: center; border-radius: 6.8px;">SUBMITTED</p>
                            <p style="font-size: 10px; margin-top: 4px;"><?php echo $row['activity_datetime'] ?></p>


                        </div>
                    </div>
<!-- --------------------------------------------------------------------------------------------------------------->
                    <div id="SDAO" class="statusDiv">
                    <div class="circleContainer">
                            <div id="circleSdaoApproved"><img src="<?php echo $currentStatusImgSrc; ?>" id="pendingToApproveImg" style="<?php echo $currentImgBackgroundColor?>" draggable="false"></div>

                            <style>
                                #pendingToApproveImg{
                                    background-color: rgba(245, 215, 98, 1); height: 34px; width: 37px; border-radius: 50%; 
                                    display: flex; align-items: center; justify-content: center;
                                }

                            </style>

                            <div style=" width: 55px; background-color: rgba(217, 217, 217, 1); height: 1.5px; margin-left: 5px;margin-right: 5px;"></div>

                        </div>
                          <div class="circleDetails" style="word-wrap:break-word;">
                            <p style="font-weight: bold; font-size: 10px; margin-top: 4px;">Student Development Activities Office</p>
                            <p style="font-size: 10px; margin-top: 4px;">Ernilson C. Caindoy</p>
                            <p id="pendingDetailSDAO" style="<?php echo $currentCSS; ?>"><?php echo $sdaoStatusUC ?></p>
                            <p style="font-size: 10px; margin-top: 4px;"><?php echo $row['activity_datetime'] ?></p>
                            <style>
                              
                            </style>
                        </div>
                    </div>

                    <div id="FMO" class="statusDiv">
                    <div class="circleContainer">
                            <div><img src="<?php echo $ImgSrcGray; ?>" style="<?php echo $ImgBackgroundColorGray; ?>" draggable="false"></div>
                            <div style=" width: 55px; background-color: rgba(217, 217, 217, 1); height: 1.5px; margin-left: 5px;margin-right: 5px;"></div>

                        </div>
                        <div class="circleDetails">
                        </div>
                        
                    </div>

                    <div id="LRC" class="statusDiv">
                    <div class="circleContainer">
                            <div><img src="IMG/grayStatus.png" style="background-color: rgba(217, 217, 217, 1);
                            height: 30px; width: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center;" draggable="false"></div>
                            <div style=" width: 55px; background-color: rgba(217, 217, 217, 1); height: 1.5px; margin-left: 5px;margin-right: 5px;"></div>

                        </div>
                        <div class="circleDetails">
                        </div>

                    </div>

                    <div id="ASD" class="statusDiv">
                    <div class="circleContainer">
                            <div><img src="IMG/grayStatus.png" style="background-color: rgba(217, 217, 217, 1);
                            height: 30px; width: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center;" draggable="false"></div>
                            <div style=" width: 55px; background-color: rgba(217, 217, 217, 1); height: 1.5px; margin-left: 5px;margin-right: 5px;"></div>

                        </div>
                        <div class="circleDetails">
                        </div>
                    </div>

                    <div id="SAD" class="statusDiv">
                    <div class="circleContainer">
                            <div><img src="IMG/grayStatus.png" style="background-color: rgba(217, 217, 217, 1);
                            height: 30px; width: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center;" draggable="false"></div>
                            <div style=" width: 55px; background-color: rgba(217, 217, 217, 1); height: 1.5px; margin-left: 5px;margin-right: 5px;"></div>

                        </div>
                        <div class="circleDetails">
                        </div>
                    </div>

                    <div id="SAD" class="statusDiv">
                    <div class="circleContainer">
                            <div><img src="IMG/grayStatus.png" style="background-color: rgba(217, 217, 217, 1);
                            height: 30px; width: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center;" draggable="false"></div>
                            <div style=" width: 55px; background-color: rgba(217, 217, 217, 1); height: 1.5px; margin-left: 5px;margin-right: 5px;"></div>

                        </div>
                        <div class="circleDetails">
                        </div>
                    </div>

                    <div id="SAD" class="statusDiv">
                    <div class="circleContainer">
                            <div><img src="IMG/grayStatus.png" style="background-color: rgba(217, 217, 217, 1);
                            height: 30px; width: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center;" draggable="false"></div>
                            <div style=" width: 55px; background-color: rgba(217, 217, 217, 1); height: 1.5px; margin-left: 5px;margin-right: 5px;"></div>

                        </div>
                        <div class="circleDetails">
                        </div>
                    </div>

                    <div id="SAD" class="statusDiv">
                    <div class="circleContainer">
                            <div><img src="IMG/grayStatus.png" style="background-color: rgba(217, 217, 217, 1);
                            height: 30px; width: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center;" draggable="false"></div>
                            <div style=" width: 55px; background-color: rgba(217, 217, 217, 1); height: 1.5px; margin-left: 5px;margin-right: 5px;"></div>

                        </div>
                        <div class="circleDetails">
                        </div>
                    </div>

                    <div id="SAD" class="statusDiv">
                    <div class="circleContainer">
                            <div><img src="IMG/grayStatus.png" style="background-color: rgba(217, 217, 217, 1);
                            height: 30px; width: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center;" draggable="false"></div>
                            <div style=" width: 55px; background-color: rgba(217, 217, 217, 1); height: 1.5px; margin-left: 5px;margin-right: 5px;"></div>

                        </div>
                        <div class="circleDetails">
                        </div>
                    </div>

                    <div id="SAD" class="statusDiv">
                    <div class="circleContainer">
                            <div><img src="IMG/grayStatus.png" style="background-color: rgba(217, 217, 217, 1);
                            height: 30px; width: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center;" draggable="false"></div>
                            <div style=" width: 55px; background-color: rgba(217, 217, 217, 1); height: 1.5px; margin-left: 5px;margin-right: 5px;"></div>

                        </div>
                        <div class="circleDetails">
                        </div>
                    </div>

<!-- ------------------------------------------------------------------------------------------------------------------------->

                </div>
                <div class="activityDetailsContainer">
                    <div class="leftActivityDetails">
                        <div class="firstLine">Event Details</div>

                        <div class="inputLine"><div class="asking">Name<div>:</div></div> 
                        <div class="nameDisplay"><?php echo $row['name']?></div>
                        </div>

                        <div class="inputLine"><div class="asking">Name of Program / Organization / Club <div>:</div></div>
                        <div class="orgDisplay"><?php echo $row['program_organization']?></div>
                        </div>
                        
                        <div class="inputLine"><div class="asking">Title / Theme of Activity <div>:</div></div>
                        <div class="themeDisplay"><?php echo $row['activity_title']?></div>
                        </div>

                        <div class="inputLine"><div class="asking">Date / Time of the Activity <div>:</div></div>    
                        <div class="dateTimeDisplay"><?php echo $row['activity_datetime']?></div>
                        </div>

                        <div class="inputLine"><div class="asking">Target No. of Participants <div>:</div></div>
                        <div class="participantsDisplay"><?php echo $row['target_participants']?></div>
                        </div>
                        <div class="inputLine"><div class="asking">Type of Activity <div>:</div></div>
                        <div class="typeOfActDisplay"><?php echo $row['activity_types']?></div>
                        </div>

                        <div class="inputLine"><div class="asking">Activity Inclusion / Description <div>:</div></div>
                        <div class="actDescDisplay"><?php echo $row['activity_options']?></div>
                        </div>

                        <div class="inputLine"><div class="asking">Type of Budget <div>:</div></div>
                        <div class="typeOfBudgetDisplay"><?php echo $row['sdao_options']?></div>
                        </div>
                     

                    </div>

                    <div class="rightActivityDetails">

                        <div class="attachmentBox" style=" height: 190px; width: 300px; padding-bottom: 20px; font-family: sans-serif; font-weight: bold; font-size: 24px; display: flex; flex-direction:column; align-items:center;">
                        Attachment

                        <div class="fileAttach" style="border:solid 1px; height: 40px; width:250px; border-radius: 45px; margin-top: 20px;"></div>

                        <div class="rejectApproveBtnContainer" style="display: flex; align-items:center; width: 250px; height: 50px; justify-content: space-between; margin-top: 20px;">
                        <div class="rejectBtn" onclick="showRejectRequestSdao()" style="width: 110px; height: 45px; border-radius: 28px; background-color: rgba(247, 88, 88, 1); display: flex; justify-content: center; align-items: center; font-size: 16px; cursor: pointer;">Reject</div>
                        <div class="approveBtn" onclick="approveRequestSdao('<?php echo $org; ?>')" style="width: 110px; height: 45px; border-radius: 28px; background-color: rgba(153, 217, 71, 1); display: flex; justify-content: center; align-items: center; font-size: 16px; cursor: pointer;"><?php if ($sdaoStatus == 'approved') {
                            echo 'Next';
                            } else{
                                echo 'Approve';
                            }?></div>
                        </div>

                        <div id="overlay"></div>
                            <div id="rejectCommentBox">
                                <div id="rejectCommentBoxContent">
                                    <div class="upperBox" style="display: flex; flex-direction: column; align-items: center; margin-bottom: 20px;">
                                    <p>Reason for Rejection</p>
                                    <div style="width: 220px; height: 1.5px; background-color: black; margin-top: 5px;"></div>
                                    </div>
                                    
                                    <textarea id="commentInput" rows="4" cols="50"></textarea>
                                    <div class="buttonForOverlay">
                                    <button onclick="hideRejectRequestSdao()" class="overlayCancelBtn">Cancel</button>
                                    <button onclick="proceedRejectFunction('<?php echo $org; ?>')" class="overlayRejectBtn">Reject</button>

                                    </div>
                                 
                                </div>
                            </div>

                        </div>
                        <script>
  function showRejectRequestSdao() {
    document.getElementById('overlay').style.display = 'block';
    document.getElementById('rejectCommentBox').style.display = 'block';
  }

  function hideRejectRequestSdao() {
    document.getElementById('overlay').style.display = 'none';
    document.getElementById('rejectCommentBox').style.display = 'none';
  }

  function proceedRejectFunction(org) {

        $.ajax({
            type: 'POST',
            url:'reject_status.php',
            data: { org: org },
            success: function (rejectStatus){
                hideRejectRequestSdao();
            },
        });  
    } 

</script>
                     
                        <script>
         function approveRequestSdao(org) {
            $.ajax({
                type: 'POST',
                url: 'update_status_SDAO.php',
                data: { org: org },
                success: function (response) {
                    var imagePendingToApprove = document.getElementById('pendingToApproveImg');
                    var circleSDAO1 = document.getElementById('circleSdaoApproved');
                    var pPendingDetail = document.getElementById('pendingDetailSDAO');
                    pPendingDetail.textContent = 'APPROVED';
                    pPendingDetail.style.backgroundColor = 'rgba(153, 217, 71, 1)';
                    imagePendingToApprove.style.backgroundColor = 'rgba(151, 239, 120, 1)';
                    imagePendingToApprove.style.padding = '1px';
                    imagePendingToApprove.src = 'IMG/check.png';
                },
                error: function (error) {
                    console.error('Error:', error);
                    // Handle the error if needed
                }
            });
        }
</script>
                        
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