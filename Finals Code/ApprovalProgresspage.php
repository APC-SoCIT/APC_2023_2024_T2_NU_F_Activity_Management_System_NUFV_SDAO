<?php
include 'db_conn.php';
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
 
        $sql = "SELECT name, date_requested, program_organization, activity_title, activity_datetime, target_participants, activity_types, activity_options, sdao_options FROM sarf_requests WHERE program_organization = '$org'" ;
        $result = $conn->query($sql);

        $sqlUserId = "SELECT user_id FROM sarf_requests WHERE program_organization = '$org'";
        $resultUserId = $conn->query($sqlUserId);
        if (!$resultUserId) {
            die("Query failed: " . $conn->error);
        }
        $rowUserId = $resultUserId->fetch_assoc();
        $userId = $rowUserId['user_id'];

        $sqlOaPc = "SELECT program_chair, org_adviser FROM nu_accountsdb.studentaccounts WHERE program_organization = '$org'";
        $resultOaPc = $conn->query($sqlOaPc);
        if (!$resultOaPc) {
            die("Query failed: " . $conn->error);
        }
        $rowOaPc = $resultOaPc->fetch_assoc();  
        $OA = $rowOaPc['org_adviser'];
        $PC = $rowOaPc['program_chair'];

        if($userId == 408 || $userId == 409){ //college dean School Business and Accountancy
            $CD = 'Maribel B. Ruiz';
        } else if ($userId == 401 || $userId == 404 || $userId == 406){ //college dean School Engineering and Technology
            $CD = 'Napoleon C. Dela Cruz';
        } else if ($userId == 403){//college dean School of Architecture
            $CD = 'Aurora B. Panopio';
        } else if ($userId == ''){ //college dean School of Arts and Sciences
            $CD = 'Pamela V. Zuñiga';
        } else if ($userId == ''){// college dean School of Tourism and Hospitality Management
            $CD = 'Errol R. Martin';
        } else{
            $CD = 'College Dean Adviser';
        }


        

       $statusOfOaPcSdao = "SELECT org_adviser, cd, prog_chair, sdao, fmo, itso, lrc, hm from status_of_requests WHERE user_id = $userId";
       $resultStatusOfOaPcSdao = $conn->query($statusOfOaPcSdao);
       $rowStatusOfOaPcSdao = $resultStatusOfOaPcSdao->fetch_assoc();
      

       $OrgAdvStatus = $rowStatusOfOaPcSdao['org_adviser'];
       $OrgAdvStatusUC = strtoupper($OrgAdvStatus);

       
       $cdStatus = $rowStatusOfOaPcSdao['cd'];
       $cdStatusUC = strtoupper($cdStatus);

       

       $prog_chairStatus = $rowStatusOfOaPcSdao['prog_chair'];
       $prog_chairStatusUC = strtoupper($prog_chairStatus);

       $sdaoStatus = $rowStatusOfOaPcSdao['sdao'];
       $sdaoStatusUC = strtoupper($sdaoStatus);

       $fmoStatus = $rowStatusOfOaPcSdao['fmo'];
       $itsoStatus = $rowStatusOfOaPcSdao['itso'];
       $lrcStatus = $rowStatusOfOaPcSdao['lrc'];
       $hmStatus = $rowStatusOfOaPcSdao['hm'];


       $statusOfRequests = "SELECT * FROM `status_of_requests` WHERE user_id = $userId";
       $resultSOR = $conn->query($statusOfRequests);
       $rowOfSOR = $resultSOR->fetch_assoc();

       $sqlDateResponse = "SELECT oa_dt_response, cd_dt_response, pc_dt_response, sdao_dt_response FROM sarf.status_response WHERE user_id = $userId";
       $resultDr = $conn->query($sqlDateResponse);
       $rowOfDr = $resultDr->fetch_assoc();
       $dateResponseOA = $rowOfDr['oa_dt_response'];
       $dateResponsePC = $rowOfDr['pc_dt_response'];
       $dateResponseSDAO = $rowOfDr['sdao_dt_response'];
       $dateResponseCD = $rowOfDr['cd_dt_response'];


       $pendingCSS = 'font-size: 10px; font-weight: bold; background-color: rgba(245, 215, 98, 1); margin-top: 4px;
       width: 68px; height: 18px; align-items:center; display: flex; justify-content: center; border-radius: 6.8px;';
       
       $approvedCSS = 'font-size: 10px; font-weight: bold; background-color: rgba(153, 217, 71, 1); margin-top: 4px;
       width: 68px; height: 18px; align-items:center; display: flex; justify-content: center; border-radius: 6.8px;';

       $grayline = 'width: 55px; background-color: rgba(217, 217, 217, 1); height: 1.5px; margin-left: 5px;margin-right: 5px;';
       
       $approvedImageSrc = 'IMG/approvedIcon.png';
       $pendingImageSrc = 'IMG/pendingIcon.png';
       $grayPic = 'IMG/grayStatus.png';
       $circleIconSize = 'height: 33px; width: 33px; margin-top: 4.5px; border-radius: 50%;';


       $btnContainerDefault = 'display: flex; align-items:center; width: 250px; height: 50px; justify-content: space-between; margin-top: 20px;';
       $btnContainerItemsCentered = 'display: flex; align-items:center; width: 250px; height: 50px; justify-content: center; margin-top: 20px;';

       $rejectBtnRemoved = 'display: none';
       $rejectBtnDefault = 'width: 110px; height: 45px; border-radius: 28px; background-color: rgba(247, 88, 88, 1); display: flex; justify-content: center; align-items: center; font-size: 16px; cursor: pointer;';

       $approveBtnStyle = 'width: 110px; height: 45px; border-radius: 28px; background-color: rgba(153, 217, 71, 1); display: flex; justify-content: center; align-items: center; font-size: 16px; cursor: pointer;';
       $doneBtnStyle = 'width: 200px; height: 45px; border-radius: 28px; background-color: rgba(153, 217, 71, 1); display: flex; justify-content: center; align-items: center; font-size: 16px; cursor: default;';


       $statusRectangleCSS = 'display: none;';

       $borderGreen = 'border: solid 1px; color: green; margin-bottom: 3px;';
       $borderGoldenRod = 'border: solid 1px; color: goldenrod; padding: 1px; margin-bottom: 1px;';
       $borderGray =  'border: solid 1px; color: gray; padding: 2px;';


       $functionForApproveSDAO = "approveRequestSdao('" . $org . "')";
       $functionForApproveFMO = "sendMailToFMO('" . $org . "')";
       $functionForApproveITSO = "sendMailToITSO('" . $org . "')";
       $functionForApproveLRC = "sendMailToLRC('" . $org . "')";
       $functionForApproveHM = "sendMailToHM('" . $org . "')";
       $functionNothing = "nothing()";
       $functionForRejectBtn = "showRejectRequestSdao()";


                if($fmoStatus != 'none'){
                $emailFMO = $functionForApproveFMO;
               } else{
                $emailFMO = $functionNothing;
               } 

               if($itsoStatus != 'none'){
                $emailITSO = $functionForApproveITSO;
               } else{
                $emailITSO = $functionNothing;
               }
               
               if($lrcStatus != 'none'){
                $emailLRC = $functionForApproveLRC;
               } else{
                $emailLRC = $functionNothing;
               }
               
               if($hmStatus != 'none'){
                $emailHM = $functionForApproveHM;
               } else{
                $emailHM = $functionNothing;
               }
               $allfunction = $functionForApproveSDAO . "; " . $emailFMO . "; " . $emailITSO . "; " . $emailLRC . "; " . $emailHM;


       if ($OrgAdvStatus == 'approved') {
        $currentCSSOA = $approvedCSS;
        $currentStatusImgOA = $approvedImageSrc;
       
      
        } else if($OrgAdvStatus == 'pending') {
        $currentCSSOA = $pendingCSS;
        $currentStatusImgOA = $pendingImageSrc;
        }

        if($cdStatus == 'approved') {
        $currentCSSCD = $approvedCSS;
        $currentStatusImgCD = $approvedImageSrc;          
        } else if($cdStatus == 'pending') {
        $currentCSSCD = $pendingCSS;
        $currentStatusImgCD = $pendingImageSrc;
        }

        if($prog_chairStatus == 'approved'){
            $currentStatusImgPC = $approvedImageSrc;
            $currentCSSPC = $approvedCSS;
        } else  if($prog_chairStatus == 'pending'){
            $currentStatusImgPC = $pendingImageSrc;
            $currentCSSPC = $pendingCSS;
        } 

     
        
        if($prog_chairStatus == 'pending'){

            $PCstatusCss = $pendingCSS;
            $imageSrcPC = $pendingImageSrc;

            $currentFunctionForApproveBtn = "";
            $currentFunctionForRejectBtn = "";
            $btnContainerStatus = $btnContainerDefault;
            $btnCursor = $approveBtnStyle . "cursor: default";
            $getStatusRedBtn = $rejectBtnDefault . "cursor: default";

            $currentStatusImgSrc = $grayPic;

            $statusRectangleCSS = 'display: none;';
            $currentCSS = 'display: none';
            $displayNone = 'display: none';
            $border = $borderGray;
   
        } else if($prog_chairStatus == 'approved' && $sdaoStatus == 'pending'){
            $currentFunctionForApproveBtn = $allfunction;
            $currentFunctionForRejectBtn = $functionForRejectBtn;
            $btnContainerStatus = $btnContainerDefault;
            $btnCursor = $approveBtnStyle;           
            $getStatusRedBtn = $rejectBtnDefault;

            $currentStatusImgSrc = $pendingImageSrc;

            $statusRectangleCSS = 'display: block;';
            $currentCSS = $pendingCSS;
            $displayNone = '';
            $border = $borderGoldenRod;
        } else if($prog_chairStatus == 'approved' && $sdaoStatus == 'approved'){
            $currentFunctionForApproveBtn = '';
            $currentFunctionForRejectBtn = '';
            $btnContainerStatus = 'display: none;';
            $btnCursor = $doneBtnStyle;           
            $getStatusRedBtn = $rejectBtnRemoved;

            $currentStatusImgSrc = $approvedImageSrc;

            $statusRectangleCSS = 'display: block;';
            $currentCSS = $approvedCSS;
            $displayNone = '';
            $border = $borderGreen;
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
            <h1 class="h1Title">APPROVAL PROCESS</h1>
           
           <div class="lineSeparator"></div>

            </div>

            </div>
            <div class="Content">
                <div class="circleProgressContainer">

                    <div id="Requester" class="statusDiv">    
                        <div class="circleContainer">
                            <div class="circle"><img src="IMG/approvedIcon.png" style="<?php echo $circleIconSize?>" draggable="false"></div>
                            <div class="statusLine"></div>

                        </div>
                        <div class="circleDetails" style="word-wrap:break-word;">
                            <p style="font-weight: bold; font-size: 10px; margin-top: 4px;">Requester</p>
                            <p style="font-size: 10px; margin-top: 4px;"><?php echo $row['program_organization']?> - <?php echo $row['activity_options']?></p>
                            <p style="<?php echo $approvedCSS?>">SUBMITTED</p>
                            <p style="font-size: 10px; margin-top: 4px;"><?php echo $row['date_requested'] ?></p>


                        </div>
                    </div>
<!-- --------------------------------------------------------------------------------------------------------------->


                    <div id="OA" class="statusDiv">
                    <div class="circleContainer">
                    <div class="circle"><img src="<?php echo $currentStatusImgOA ?>" style="<?php echo $circleIconSize?>" draggable="false"></div>
                            <div class="statusLine"></div>

                        </div>
                        <div class="circleDetails" style="word-wrap:break-word;">
                            <p style="font-weight: bold; font-size: 10px; margin-top: 4px;">Organizational Adviser</p>
                            <p style="font-size: 10px; margin-top: 4px;"><?php echo $OA ?></p>
                            <p style="<?php echo $currentCSSOA ?>"><?php echo $OrgAdvStatusUC ?></p>
                            <p style="font-size: 10px; margin-top: 4px;"><?php 
        if($dateResponseOA == '0000-00-00 00:00:00'){
            echo "00-00-00 00:00";
        }else{
            echo date("y-m-d h:i A", strtotime($dateResponseOA));
         } ?></p>


                        </div>
                        
                    </div>

                    <div id="CD" class="statusDiv">
                    <div class="circleContainer">
                    <div class="circle"><img src="<?php echo $currentStatusImgCD ?>" style="<?php echo $circleIconSize?>" draggable="false"></div>
                            <div class="statusLine"></div>

                        </div>
                        <div class="circleDetails" style="word-wrap:break-word;">
                            <p style="font-weight: bold; font-size: 10px; margin-top: 4px;">College Dean</p>
                            <p style="font-size: 10px; margin-top: 4px;"><?php echo $OA ?></p>
                            <p style="<?php echo $currentCSSCD ?>"><?php echo $cdStatusUC ?></p>
                            <p style="font-size: 10px; margin-top: 4px;"><?php echo $dateResponseCD ?></p>


                        </div>
                        
                    </div>

                    <div id="PC" class="statusDiv">
                    <div class="circleContainer">
                            <div class="circle"><img src="<?php echo $currentStatusImgPC?>" style="<?php echo $circleIconSize?>"draggable="false"></div>
                            <div class="statusLine"></div>

                        </div>
                        <div class="circleDetails" style="word-wrap:break-word;">
                            <p style="font-weight: bold; font-size: 10px; margin-top: 4px;">Program Chair</p>
                            <p style="font-size: 10px; margin-top: 4px;"><?php echo $PC ?></p>
                            <p style="<?php echo $currentCSSPC ?>"><?php echo $prog_chairStatusUC ?></p>
                            <p style="font-size: 10px; margin-top: 4px;"><?php 
        if($dateResponsePC == '0000-00-00 00:00:00'){
            echo "00-00-00 00:00";
        }else{
            echo date("y-m-d h:i A", strtotime($dateResponsePC));
         } ?></p>


                        </div>

                    </div>

                    <div id="SDAO" class="statusDiv">
                    <div class="circleContainer">
                            <div class="circle"><img src="<?php echo $currentStatusImgSrc; ?>" id="pendingToApproveImg"  style="<?php echo $circleIconSize . "" . $border ?>" draggable="false"></div>
                            <div class="statusLine"></div>

                        </div>
                          <div class="circleDetails" style="word-wrap:break-word;">
                            <p style="font-weight: bold; font-size: 10px; margin-top: 4px; <?php echo $displayNone ?>">Student Development Activities Office</p>
                            <p style="font-size: 10px; margin-top: 4px; <?php echo $displayNone ?> ">Ernilson C. Caindoy</p>
                            <p id="pendingDetailSDAO" style="<?php echo $currentCSS ?>"><?php echo $sdaoStatusUC ?></p>
                            <p style="font-size: 10px; margin-top: 4px; <?php echo $displayNone?>"><?php echo $dateResponseSDAO ?></p>
                            <style>
                              
                            </style>
                        </div>
                    </div>

<?php 
$approverCount = 0;
$valuesOfSorArray = array_keys($rowOfSOR);

for ($i = 6; $i < count($valuesOfSorArray); $i++) {
    $columnName = $valuesOfSorArray[$i];
    $columnValue = $rowOfSOR[$columnName];
    
    if ($columnValue !== "none") {
        $approverCount++;
    }
}
$numOfnoneValues = 7 - $approverCount;
$numberOfStatusDivs = 7 - $numOfnoneValues;
for ($i = 0; $i < $numberOfStatusDivs; $i++) { ?>
    <div class="statusDiv">
        <div class="circleContainer">
            <div class="circle">
                <img src="<?php echo $grayPic; ?>" style="<?php echo $circleIconSize?>" draggable="false">
            </div>
            <?php if ($i < $numberOfStatusDivs - 1) { ?>
                <div style="<?php echo $grayline ?>"></div>
            <?php } ?>
        </div>
        <div class="circleDetails">
        </div>
    </div>
<?php } ?>

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

                        <div class="fileAttach" style="display:flex; justify-content: left; border:solid 1px; height: 40px; width:250px; border-radius: 45px; margin-top: 20px;"><button style="width: 90px; border-radius: 30px; border: none; cursor: pointer;">   </button></div>

                        <div class="rejectApproveBtnContainer" style="<?php echo $btnContainerStatus?>">

                        <div class="rejectBtn" onclick="<?php echo $currentFunctionForRejectBtn?>" style="<?php echo $getStatusRedBtn?>"><p id="rejectBtnId">Reject</div>

                        <div class="approveBtn" onclick="<?php echo $currentFunctionForApproveBtn ?>" style="<?php echo $btnCursor ?>"><p id="approveBtn"><?php if ($sdaoStatus == 'approved') {
                            echo 'Done';
                            } else{
                                echo 'Approve';
                            }?></p></div>
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
    var trimmedComment = document.getElementById('commentInput').value.trim();

    if (trimmedComment !== '') {
        $.ajax({
            type: 'POST',
            url:'reject_status.php',
            data: { org: org },
            success: function (rejectStatus){
                hideRejectRequestSdao();
                doneRejecting();
            },
        });  
    } else {
    }
}

function doneRejecting() {
            $.ajax({
                url: 'Approvalpage.php',
                type: 'GET',
                success: function(data) {
                    $('.right').html(data);
                        
                },
            });
           
        }
</script>
                     
<script>
    var doneClicking = false;
          function approveRequestSdao(org) {
            if (doneClicking) {
            return;
        }
        doneClicking = true;

            $.ajax({
                type: 'POST',
                url: 'update_status_SDAO.php',
                data: { org: org },
                success: function (response) {
                    var imagePendingToApprove = document.getElementById('pendingToApproveImg');
                    var pPendingDetail = document.getElementById('pendingDetailSDAO');
                    var idrejectBtn = document.getElementById('rejectBtnId');
                    var approveBtn = document.getElementById('approveBtn');
                    var rejectBtn = document.querySelector('.rejectBtn');
                    var qapproveBtn = document.querySelector('.approveBtn');
                    var btnContainer = document.querySelector('.rejectApproveBtnContainer');
                    
                    qapproveBtn.style.cursor = 'default';
                    qapproveBtn.style.width = '200px';
                    qapproveBtn.textContent = 'DONE';
                    rejectBtn.style.display = 'none'; 
                    btnContainer.style.justifyContent = 'center';

                    pPendingDetail.textContent = 'APPROVED';
                    pPendingDetail.style.backgroundColor = 'rgba(153, 217, 71, 1)';
                    imagePendingToApprove.style.color = 'green';
                    imagePendingToApprove.src = 'IMG/approvedIcon.png';
                    idrejectBtn.style.visibility = 'hidden';

                    $.ajax({
                    type: 'POST',
                    url: 'send.php', 
                    data: { 
                        email: 'svn70101@gmail.com', 
                        subject: 'Approval Notification',
                        message: 'Your request has been approved by the SDAO.'
                    },
                    success: function (response) {
                        console.log('Email sent successfully');
                    },
                    error: function (error) {
                        console.error('Error sending email:', error);
                        // Handle the error if needed
                    }
                });
                    
                },
                error: function (error) {
                    console.error('Error:', error);
                    // Handle the error if needed
                }
            });
        }

</script>

<script>
    function goToHomepage(){
        $.ajax({
                url: 'Approvalpage.php',
                type: 'GET',
                success: function(data) {
                    $('.right').html(data);
                },
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