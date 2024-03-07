<?php
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
       $valueOfEmail = $_SESSION['email'];
       include 'db_conn2.php';
       include 'varDesigns.php';
   

    if (isset($_GET['org'])) {
        $org = $_GET['org'];
 
        $sql = "SELECT name, date_requested, program_organization, activity_title, activity_datetime, activity_end_datetime, target_participants, activity_types, activity_options, sdao_options FROM sarf_requests WHERE program_organization = '$org'" ;
        $result = $conn->query($sql);

        $sqlUserId = "SELECT user_id FROM sarf_requests WHERE program_organization = '$org'";
        $resultUserId = $conn->query($sqlUserId);
    
        if (!$resultUserId) {
            die("Query failed: " . $conn->error);
        }
    
        $rowUserId = $resultUserId->fetch_assoc();
        $userId = $rowUserId['user_id'];

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

        $sqlFMO = "SELECT facilities_requirements, learning_resource_center, hotel_management FROM sarf.student_activity_requests where user_id = '$userId'";
        $resultsqlFMO = $conn->query($sqlFMO);

       $statusOfSdao = "SELECT sdao from status_of_requests WHERE user_id = $userId";
       $resultStatusOfSdao = $conn->query($statusOfSdao);
       $rowStatusOfSdao = $resultStatusOfSdao->fetch_assoc();
       $sdaoStatus = $rowStatusOfSdao['sdao'];
       $sdaoStatusUC = strtoupper($sdaoStatus);

       $statusOfOaPcSdaoFmo = "SELECT org_adviser, cd, prog_chair, sdao, fmo, itso, lrc, hm from status_of_requests WHERE user_id = $userId";
       $resultStatusOfOaPcSdaoFmo = $conn->query($statusOfOaPcSdaoFmo);
       $rowStatusOfOaPcSdaoFmo = $resultStatusOfOaPcSdaoFmo->fetch_assoc();

       $OrgAdvStatus = $rowStatusOfOaPcSdaoFmo['org_adviser'];
       $OrgAdvStatusUC = strtoupper($OrgAdvStatus);

       $cdStatus = $rowStatusOfOaPcSdaoFmo['cd'];
       $cdStatusUC = strtoupper($cdStatus);

       $pcStatus = $rowStatusOfOaPcSdaoFmo['prog_chair'];
       $pcStatusUC = strtoupper($pcStatus);

       $sdaoStatus = $rowStatusOfOaPcSdaoFmo['sdao'];
       $sdaoStatusUC = strtoupper($sdaoStatus);

       $fmoStatus = $rowStatusOfOaPcSdaoFmo['fmo'];
       $fmoStatusUC = strtoupper($fmoStatus);

       $itsoStatus = $rowStatusOfOaPcSdaoFmo['itso'];
       $itsoStatusUC = strtoupper($itsoStatus);

       $lrcStatus = $rowStatusOfOaPcSdaoFmo['lrc'];
       $lrcStatusUC = strtoupper($lrcStatus);

       $hmStatus = $rowStatusOfOaPcSdaoFmo['hm'];
       $hmStatusUC = strtoupper($hmStatus);

       $hideStatusDiv = 'display: none;';

       if($fmoStatus == 'none'){
        $hideStatusDivFMO = $hideStatusDiv;
       } if ($itsoStatus == 'none'){
        $hideStatusDivITSO = $hideStatusDiv;
       } if ($lrcStatus == 'none'){
        $hideStatusDivLRC = $hideStatusDiv;        
       } if ($hmStatus == 'none'){
        $hideStatusDivHM = $hideStatusDiv;
        
       }


       $statusOfRequests = "SELECT * FROM `status_of_requests` WHERE user_id = $userId";
       $resultSOR = $conn->query($statusOfRequests);
       $rowOfSOR = $resultSOR->fetch_assoc();

       $sqlOaPc = "SELECT program_chair, org_adviser FROM nu_accountsdb.studentaccounts WHERE program_organization = '$org'";
       $resultOaPc = $conn->query($sqlOaPc);
       if (!$resultOaPc) {
           die("Query failed: " . $conn->error);
       }
       $rowOaPc = $resultOaPc->fetch_assoc();  
       $OA = $rowOaPc['org_adviser'];
       $PC = $rowOaPc['program_chair'];

       $sqlDateResponse = "SELECT oa_dt_response, pc_dt_response, sdao_dt_response, fmo_dt_response, itso_dt_response, lrc_dt_response, hm_dt_response, asd_dt_response, sad_dt_response, ed_dt_response, cd_dt_response FROM sarf.status_response WHERE user_id = $userId";
       $resultDr = $conn->query($sqlDateResponse);
       $rowOfDr = $resultDr->fetch_assoc();
       $dateResponseOA = $rowOfDr['oa_dt_response'];
       $dateResponsePC = $rowOfDr['pc_dt_response'];
       $dateResponseSDAO = $rowOfDr['sdao_dt_response'];
       $dateResponseFMO = $rowOfDr['fmo_dt_response'];
       $dateResponseITSO = $rowOfDr['itso_dt_response'];
       $dateResponseLRC = $rowOfDr['lrc_dt_response'];
       $dateResponseHM = $rowOfDr['hm_dt_response'];
       $dateResponseASD = $rowOfDr['asd_dt_response'];
       $dateResponseSAD = $rowOfDr['sad_dt_response'];
       $dateResponseED = $rowOfDr['ed_dt_response'];
       $dateResponseCD = $rowOfDr['cd_dt_response'];

       $sqlGetDetails = "SELECT learning_resource_center, date_requested, activity_datetime, remarks_tables, remarks_chairs, itso, itso_other from sarf_requests JOIN student_activity_requests on sarf_requests.user_id = student_activity_requests.user_id 
       where sarf_requests.user_id = $userId";
       $resultsqlGetDetails = $conn->query($sqlGetDetails);
       $rowGetDetails  = $resultsqlGetDetails->fetch_assoc();
       $room = $rowGetDetails['learning_resource_center']; 
       $dateReq = $rowGetDetails['date_requested']; 
       $dateNeeded = $rowGetDetails['activity_datetime']; 
       $numChairs = $rowGetDetails['remarks_tables']; 
       $numTables = $rowGetDetails['remarks_chairs']; 
       $devices = [$rowGetDetails['itso'], $rowGetDetails['itso_other']];


       $grayImgBackgroundColor = 'background-color: rgba(217, 217, 217, 1); height: 30px; width: 30px; 
       border-radius: 50%; display: flex; align-items: center; justify-content: center;';

       $borderGreen = 'border: solid 1px; color: green; margin-bottom: 3px;';
       $borderGoldenRod = 'border: solid 1px; color: goldenrod; padding: 1px; margin-bottom: 1px;';
       $borderGray =  'border: solid 1px; color: gray; padding: 2px;';

       $btnContainerDefault = 'display: flex; align-items:center; width: 250px; height: 50px; justify-content: space-between; margin-top: 20px;';
       $btnContainerItemsCentered = 'display: flex; align-items:center; width: 250px; height: 50px; justify-content: center; margin-top: 20px;';

       $rejectBtnRemoved = 'display: none';
       $rejectBtnDefault = 'width: 110px; height: 45px; border-radius: 28px; background-color: rgba(247, 88, 88, 1); display: flex; justify-content: center; align-items: center; font-size: 16px; cursor: pointer;';

       $approveBtnStyle = 'width: 110px; height: 45px; border-radius: 28px; background-color: rgba(153, 217, 71, 1); display: flex; justify-content: center; align-items: center; font-size: 16px; cursor: pointer;';
       $doneBtnStyle = 'width: 200px; height: 45px; border-radius: 28px; background-color: rgba(153, 217, 71, 1); display: flex; justify-content: center; align-items: center; font-size: 16px; cursor: default;';

       $functionForApproveBtnITSO = "approveRequestITSO('" . $org . "')";
       $functionForApproveBtnLRC = "approveRequestLRC('" . $org . "')";
       $functionForApproveBtnHM = "approveRequestHM('" . $org . "')";
       $functionForRejectBtn = "showRejectRequestItso()";

       $approveItsoOnly = "approveItsoOnly('" . $org . "')";
       $approveAndMailAsd = "approveAndMailAsd('" . $org . "')";

       $displayDetails = '';
       $hideDetails = 'display: none;';
       $hidden = 'visibility: hidden;';
       $displayDetailsFMO = $displayDetails;
       $displayDetailsITSO = $hideDetails;
       $displayDetailsLRC = $hideDetails;
       $displayDetailsHM = $hideDetails;
       
       $itsoValue = "";
       $itsoApproverValue = "";
       $greenBtnValue = 'Approve';

       $visibleNoneLRC = $hidden;
       $visibleNoneHM = $hidden;
       $imgStatusLRC = $grayPic;
       $lrcApproverValue = '';
       $lrcValue = '';

       $imgStatusHM = $grayPic;
       $hmApproverValue = '';
       $hmValue = '';
   
    
       if ($OrgAdvStatus == 'approved') {
        $currentCSSOA = $approvedCSS;
        $currentStatusImgOA = $approvedImageSrc;
        } else if($OrgAdvStatus == 'pending') {
        $currentCSSOA = $pendingCSS;
        $currentStatusImgOA = $pendingImageSrc;
        }

        if ($cdStatus == 'approved') {
        $currentCSSCD = $approvedCSS;
        $currentStatusImgCD = $approvedImageSrc;          
        } else if($cdStatus == 'pending') {
        $currentCSSCD = $pendingCSS;
        $currentStatusImgCD = $pendingImageSrc;
        }

        if($pcStatus == 'pending'){
            $imgStatusPC = $pendingImageSrc;
            $cssStatusPC = $pendingCSS;
        }
        else if($pcStatus == 'approved'){
            $cssStatusPC = $approvedCSS;
            $imgStatusPC = $approvedImageSrc;
        }

        if ($sdaoStatus == 'approved') {
            $currentStatusImgSDAO = $approvedImageSrc;
            $currentCSSSDAO = $approvedCSS;
        } else if($sdaoStatus == 'pending') {
            $currentStatusImgSDAO = $pendingImageSrc;
            $currentCSSSDAO = $pendingCSS;
        }


        $getStatusGreenBtn = $approveBtnStyle . "cursor: default;";
        $getStatusRedBtn = $rejectBtnDefault . "cursor: default;";
        $btnContainerStatus = $btnContainerDefault;

        if ($sdaoStatus == 'pending') {
            $imgStatusITSO = $grayPic;
            $itsoValue = "";
            $itsoApproverValue = "";
            $statusRectangleCSSITSO = 'display: none;';
            $dateDisplayCSSITSO = 'display: none;';
            $borderITSO = $borderGray;
            $currentFunctionForApproveBtn = "";
            $currentFunctionForRejectBtn = "";
       
            
        } else if ($sdaoStatus == 'approved' && $itsoStatus == 'pending'){
            $imgStatusITSO = $pendingImageSrc;
            $itsoValue = "Information Technology System Office";
            $itsoApproverValue = "Mr. Peter Magcaling";
            $statusRectangleCSSITSO = $pendingCSS;
            $borderITSO = $borderGoldenRod;
            $currentFunctionForApproveBtn = $approveItsoOnly;

            $currentFunctionForRejectBtn = $functionForRejectBtn;
            $getStatusGreenBtn = $approveBtnStyle;
            $getStatusRedBtn = $rejectBtnDefault;
            $btnContainerStatus = $btnContainerDefault;

            if($fmoStatus == 'none' || $fmoStatus == 'approved' && 
            $itsoStatus == 'none' || $itsoStatus == 'approved' &&
            $lrcStatus == 'none' || $lrcStatus == 'approved' && 
            $hmStatus == 'none' || $hmStatus == 'approved'){
                $currentFunctionForApproveBtn = $approveAndMailAsd;

            }

        } else if ($sdaoStatus == 'approved' && $itsoStatus == 'approved'){
            $imgStatusITSO = $approvedImageSrc;
            $itsoValue = "Information Technology System Office";
            $itsoApproverValue = "Mr. Peter Magcaling";
            $statusRectangleCSSITSO = $approvedCSS;
            $borderITSO = $borderGreen;
            $currentFunctionForApproveBtn = '';
            $currentFunctionForRejectBtn = '';
            $getStatusGreenBtn = $approveBtnStyle;
            $getStatusRedBtn = $rejectBtnDefault;
            $btnContainerStatus = 'display: none';

        } 



        if (!$result) {
            die("Query failed: " . $conn->error);
        } 
        
        if (!$resultsqlFMO) {
            die("Query failed: " . $conn->error);
        }

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();  
        } else {
            die("No records found for organization: " . $org);
        }

        if ($resultsqlFMO->num_rows > 0) {
            $rowrsFMO = $resultsqlFMO->fetch_assoc();
            $facilities_requirements = $rowrsFMO['facilities_requirements'];
            $learning_resource_center = $rowrsFMO['learning_resource_center'];
            $hotel_management = $rowrsFMO['hotel_management'];
        } else {
            die("No records found for organization: " . $org);
        }

        $actDateTime = $row['activity_datetime'];
        $actEndDateTime = $row['activity_end_datetime'];

        $dateNeededFormat = new DateTime($dateNeeded);
        

        $conn->close();

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/apprapprovalprogress.css">
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
        <div class="circle"><img src="IMG/approvedIcon.png" style="<?php echo $circleIconSize ?>"  draggable="false"></div>
        <div style=" width: 55px; background-color: rgba(217, 217, 217, 1); height: 1.5px; margin-left: 5px;margin-right: 5px;"></div>

    </div>
    <div class="circleDetails" style="word-wrap:break-word;">
        <p style="font-weight: bold; font-size: 10px; margin-top: 4px;">Requester</p>
        <p style="font-size: 10px; margin-top: 4px;"><?php echo $row['program_organization']?> - <?php echo $row['activity_options']?></p>
        <p style="<?php echo $approvedCSS ?>">SUBMITTED</p>
        <p style="font-size: 10px; margin-top: 4px;"><?php echo $row['date_requested'] ?></p>


    </div>
</div>

<!--___________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________-->

<div id="OA" class="statusDiv">
                    <div class="circleContainer">
                    <div class="circle"><img src="<?php echo $currentStatusImgOA ?>" style="<?php echo $circleIconSize ?>" draggable="false"></div>
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

<!--___________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________-->

<div id="CD" class="statusDiv">
                    <div class="circleContainer">
                    <div class="circle"><img src="<?php echo $currentStatusImgOA ?>" style="<?php echo $circleIconSize ?>" draggable="false"></div>
                            <div class="statusLine"></div>

                        </div>
                        <div class="circleDetails" style="word-wrap:break-word;">
                            <p style="font-weight: bold; font-size: 10px; margin-top: 4px;">College Dean</p>
                            <p style="font-size: 10px; margin-top: 4px;"><?php echo $CD ?></p>
                            <p style="<?php echo $currentCSSCD ?>"><?php echo $cdStatusUC ?></p>
                            <p style="font-size: 10px; margin-top: 4px;"><?php 
        if($dateResponseOA == '0000-00-00 00:00:00'){
            echo "00-00-00 00:00";
        }else{
            echo date("y-m-d h:i A", strtotime($dateResponseOA));
         } ?></p>


                        </div>
                        
                    </div>

<!--___________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________-->


<div id="PC" class="statusDiv">
<div class="circleContainer">
        <div class="circle"><img src="<?php echo $imgStatusPC; ?>" style="<?php echo $circleIconSize?>" draggable="false"></div>
        <div style="<?php echo $grayline?>"></div>

    </div>
      <div class="circleDetails" style="word-wrap:break-word;">
        <p style="font-weight: bold; font-size: 10px; margin-top: 4px;">Program Chair</p>
        <p style="font-size: 10px; margin-top: 4px;"><?php echo $PC ?></p>
        <p id="pendingDetailPC" style="<?php echo $cssStatusPC; ?>"><?php echo $pcStatusUC ?></p>
        <p style="font-size: 10px; margin-top: 4px;"><?php 
        if($dateResponsePC == '0000-00-00 00:00:00'){
            echo "00-00-00 00:00";
        }else{
            echo date("y-m-d h:i A", strtotime($dateResponsePC));
         } ?></p>
        <style>
          
        </style>
    </div>
</div>

<!--___________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________-->

<div id="SDAO" class="statusDiv">
<div class="circleContainer">
        <div class="circle"><img src="<?php echo $currentStatusImgSDAO ?>" id="pendingToApproveImg"  style="<?php echo $circleIconSize ?>" draggable="false"></div>
        <div class="statusLine"></div>

    </div>
      <div class="circleDetails" style="word-wrap:break-word;">
        <p style="font-weight: bold; font-size: 10px; margin-top: 4px;">Student Development Activities Office</p>
        <p style="font-size: 10px; margin-top: 4px;">Ernilson C. Caindoy</p>
        <p id="pendingDetailSDAO" style="<?php echo $currentCSSSDAO ?>"><?php echo $sdaoStatusUC ?></p>
        <p style="font-size: 10px; margin-top: 4px;"><?php 
if($dateResponseSDAO == '0000-00-00 00:00:00'){
echo "00-00-00 00:00";
}else{
echo date("y-m-d h:i A", strtotime($dateResponseSDAO));
} ?></p>
        <style>
          
        </style>
    </div>
</div>

<!--___________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________-->


<div id="ITSO" class="statusDiv" style="<?php echo $hideStatusDivITSO?>">
<div class="circleContainer">
        <div class="circle"><img src="<?php echo $imgStatusITSO?>" id="pendingToApproveImg2"style="<?php echo $circleIconSize . "" . $borderITSO?>" draggable="false"></div>
        <div style="<?php echo $grayline?>"></div>

    </div>
    <div class="circleDetails" style="word-wrap:break-word; <?php echo $visibleNoneITSO?>">
        <p style="font-weight: bold; font-size: 10px; margin-top: 4px;"><?php echo $itsoValue?></p>
        <p style="font-size: 10px; margin-top: 4px;"><?php echo $itsoApproverValue ?></p>
        <p id="pendingDetailITSO" style="<?php echo $statusRectangleCSSITSO ?>"><?php echo $itsoStatusUC ?></p>
        <p style="font-size: 10px; margin-top: 4px; <?php echo $dateDisplayCSSITSO ?>"><?php 
        if($dateResponseITSO == '0000-00-00 00:00:00'){
            echo "00-00-00 00:00";
        }else{
            echo date("y-m-d h:i A", strtotime($dateResponseITSO));
         } ?></p>
        <style>
          
        </style>
    </div>
</div>

<!--___________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________-->

<?php 
$numberOfStatusDivs = 3;
for ($i = 0; $i < $numberOfStatusDivs; $i++) { ?>
    <div class="statusDiv">
        <div class="circleContainer">
            <div>
                <img src="<?php echo $grayPic; ?>" style="<?php echo $grayImgBackgroundColor?>" draggable="false">
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
<!-- ACTIVITY DETAILS FOR ITSO------------------------------------------------------------------------------------------------> 
                    <div class="leftActivityDetails">
                        <div class="firstLine">Event Details</div>


                        <div class="inputLine"><div class="asking">Devices<div>:</div></div>
                        <div class="orgDisplay"><?php echo $devices[0]?> <br> <?php echo $devices[1]?></div>
                        </div>
                        
                        <div class="inputLine"><div class="asking">Quantity<div>:</div></div>
                        <div class="participantsDisplay"></div>
                        </div>

                        <div class="inputLine"><div class="asking">Borrow Time<div>:</div></div>
                        <div class="themeDisplay"><?php echo date("h:i A",strtotime($actDateTime))?></div>
                        </div>

                    </div>
<!---------------------------------------------------------------------------------------------------------------------------->

<!-- ACTIVITY DETAILS FOR LRC------------------------------------------------------------------------------------------------> 
<div class="leftActivityDetails" style="<?php echo $displayDetailsLRC ?>;">
                        <div class="firstLine">Event Details</div>


                        <div class="inputLine"><div class="asking">Room<div>:</div></div>
                        <div class="orgDisplay"><?php echo $room?></div>
                        </div>
                        
                        <div class="inputLine"><div class="asking">Date Requested<div>:</div></div>
                        <div class="participantsDisplay"><?php echo $dateReq?></div>
                        </div>

                        <div class="inputLine"><div class="asking">Date Needed<div>:</div></div>
                        <div class="themeDisplay"><?php echo $dateNeededFormat->format("Y-m-d")?></div>
                        </div>

                        <div class="inputLine"><div class="asking">Number of Chair<div>:</div></div>
                        <div class="themeDisplay"><?php echo $numChairs?></div>
                        </div>

                        <div class="inputLine"><div class="asking">Number of Tables<div>:</div></div>
                        <div class="themeDisplay"><?php echo $numTables?></div>
                        </div>


                    </div>
<!---------------------------------------------------------------------------------------------------------------------------->

<!-- ACTIVITY DETAILS FOR HM------------------------------------------------------------------------------------------------> 
<div class="leftActivityDetails" style="<?php echo $displayDetailsHM ?>;">
                        <div class="firstLine">Event Details</div>


                        <div class="inputLine"><div class="asking">Room<div>:</div></div>
                        <div class="orgDisplay"><?php echo $room?></div>
                        </div>
                        
                        <div class="inputLine"><div class="asking">Date<div>:</div></div>
                        <div class="participantsDisplay"><?php echo $dateNeededFormat->format("Y-m-d")?></div>
                        </div>

                        <div class="inputLine"><div class="asking">Time<div>:</div></div>
                        <div class="themeDisplay"><?php echo date("h:i A", strtotime($dateNeeded))?></div>
                        </div>

                        <div class="inputLine"><div class="asking">Equipment<div>:</div></div>
                        <div class="themeDisplay"><?php echo $numChairs?></div>
                        </div>

                    </div>
<!---------------------------------------------------------------------------------------------------------------------------->


                    <div class="rightActivityDetails">

                        <div class="attachmentBox" style=" height: 190px; width: 300px; padding-bottom: 20px; font-family: sans-serif; font-weight: bold; font-size: 24px; display: flex; flex-direction:column; align-items:center;">
                        Attachment

                        <div class="fileAttach" style="border:solid 1px; height: 40px; width:250px; border-radius: 45px; margin-top: 20px;"></div>

                        <div class="rejectApproveBtnContainer" style="<?php echo $btnContainerStatus?>">

                        <div class="rejectBtn" onclick="<?php echo $currentFunctionForRejectBtn?>" style="<?php echo $getStatusRedBtn?>"><p id="rejectBtnId">Reject</div>

                        <div class="approveBtn" onclick="<?php echo $currentFunctionForApproveBtn ?>" style="<?php echo $getStatusGreenBtn ?>"><p id="approveBtn"><?php echo $greenBtnValue ?></p></div>
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
                                    <button onclick="hideRejectRequestItso()" style="cursor: pointer;" class="overlayCancelBtn">Cancel</button>
                                    <button onclick="proceedRejectFunction('<?php echo $org; ?>')" style="cursor: pointer;" class="overlayRejectBtn">Reject</button>

                                    </div>
                                 
                                </div>
                            </div>

                        </div>
                     
                        
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