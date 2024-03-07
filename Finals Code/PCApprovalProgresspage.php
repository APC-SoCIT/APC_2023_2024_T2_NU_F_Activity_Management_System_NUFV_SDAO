<?php
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
    $valueOfEmail = $_SESSION['email'];
    include 'db_conn2.php';

    if (isset($_GET['org'])) {
        $org = $_GET['org'];
 
        $sql = "SELECT name, program_organization, activity_title, activity_datetime, date_requested, target_participants, activity_types, activity_options, sdao_options FROM sarf_requests WHERE program_organization = '$org'" ;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();  
            $date_requested = $row['date_requested'];
        } else {
            die("No records found for organization: " . $org);
        }

        $sqlUserId = "SELECT user_id FROM sarf_requests WHERE program_organization = '$org'";
        $resultUserId = $conn->query($sqlUserId);
        if (!$resultUserId) {
            die("Query failed: " . $conn->error);
        }
        $rowUserId = $resultUserId->fetch_assoc();
        $userId = $rowUserId['user_id'];

        $sqlOA = "SELECT org_adviser FROM nu_accountsdb.studentaccounts WHERE program_organization = '$org'";
        $resultOA = $conn->query($sqlOA);
        if (!$resultOA) {
            die("Query failed: " . $conn->error);
        }
        $rowOA = $resultOA->fetch_assoc();  
        $OA = $rowOA['org_adviser'];

        $sqlPC = "SELECT program_chair FROM nu_accountsdb.studentaccounts WHERE program_organization = '$org'";
        $resultPC = $conn->query($sqlPC);
        if (!$resultPC) {
            die("Query failed: " . $conn->error);
        }
        $rowPC = $resultPC->fetch_assoc();  
        $PC = $rowPC['program_chair'];

         $sqlOrg = "SELECT org_adviser_program FROM nu_accountsdb.org_adviser_approver WHERE org_adviser_email = '$valueOfEmail'" ;
        $resultOrg = $conn->query($sqlOrg);

    
        $sqlOrg2 = "SELECT program_chair_program FROM nu_accountsdb.program_chair_approver WHERE program_chair_email = '$valueOfEmail'" ;
        $resultOrg2 = $conn->query($sqlOrg2);

        $statusOfProgChair = "SELECT prog_chair from status_of_requests WHERE user_id = $userId";
        $resultStatusOfProgChair = $conn->query($statusOfProgChair);
        $rowStatusOfProgChair = $resultStatusOfProgChair->fetch_assoc();
        $ProgChairStatus = $rowStatusOfProgChair['prog_chair'];
        $ProgChairStatusUC = strtoupper($ProgChairStatus);

       

    if (!$resultOrg || !$resultOrg2) {
        die("Query failed: " . $conn->error);
    }

    $org = "";
    if ($resultOrg->num_rows > 0) {
        $rowOrg = $resultOrg->fetch_assoc();
        $org = $rowOrg['org_adviser_program'];
        $sourceTable = "org_adviser_approver";
    } elseif ($resultOrg2->num_rows > 0) {
        $rowOrg2 = $resultOrg2->fetch_assoc();
        $org = $rowOrg2['program_chair_program'];
        $sourceTable = "program_chair_approver";
    } else {
        // Handle the case where the email is not found in either table
        die("Email not found in any table.");
    }

       $statusOfOrgAdv = "SELECT org_adviser, cd from status_of_requests WHERE user_id = $userId";
       $resultStatusOfOrgAdv = $conn->query($statusOfOrgAdv);
       $rowStatusOfOrgAdv = $resultStatusOfOrgAdv->fetch_assoc();

       $OrgAdvStatus = $rowStatusOfOrgAdv['org_adviser'];
       $OrgAdvStatusUC = strtoupper($OrgAdvStatus);

       $cdStatus = $rowStatusOfOrgAdv['cd'];
       $cdStatusUC = strtoupper($cdStatus);

       $sqlFLH = "SELECT facilities_requirements, learning_resource_center, hotel_management FROM sarf.student_activity_requests where user_id = '$userId'";
       $resultsqlFLH = $conn->query($sqlFLH);

       $statusOfRequests = "SELECT * FROM `status_of_requests` WHERE user_id = $userId";
       $resultSOR = $conn->query($statusOfRequests);
       $rowOfSOR = $resultSOR->fetch_assoc();

       $sqlDateResponse = "SELECT oa_dt_response, cd_dt_response, pc_dt_response FROM sarf.status_response WHERE user_id = $userId";
       $resultDr = $conn->query($sqlDateResponse);
       $rowOfDr = $resultDr->fetch_assoc();
       $dateResponseOA = $rowOfDr['oa_dt_response'];
       $dateResponsePC = $rowOfDr['pc_dt_response'];
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

       $functionForApprvBtnProgChair = "approveRequestProgChair('" . $org . "')";
       $functionForRejectBtn = "showRejectRequestPC()";

       $borderGreen = 'border: solid 1px; color: green; margin-bottom: 3px;';
       $borderGoldenRod = 'border: solid 1px; color: goldenrod; padding: 1px; margin-bottom: 1px;';
       $borderGray =  'border: solid 1px; color: gray; padding: 2px;';

        $borderPC = $borderGray;
        if($cdStatus=='pending'){
            $programChairTxt = '';
            $programChairValue = '';

            $pcImg = $grayPic;
            $statusRectangleCSS = 'display: none;';
            $dateDisplayCSS = 'display: none;';
            $getStatusRedBtn = $rejectBtnDefault;
            $btnContainerStatus = $btnContainerDefault;
            $getStatusGreenBtn = $approveBtnStyle . "cursor: default;";
            $currentFunctionForApprvBtn = "";
            $currentFunctionForRejectBtn = "";
            $getStatusRedBtn = $rejectBtnDefault . "cursor: default;";
            $greenBtnValue = 'Approve';
        }

        else if($cdStatus=='approved' && $ProgChairStatus == 'pending'){
            $pcImg = $pendingImageSrc;
            $pcCss = $pendingCSS;
            $statusRectangleCSS = 'display: block;' . $pendingCSS;
            $dateDisplayCSS = 'display: block;';
            $getStatusRedBtn = $rejectBtnDefault;
            $btnContainerStatus = $btnContainerDefault;
            $getStatusGreenBtn = $approveBtnStyle;
            $currentFunctionForApprvBtn = $functionForApprvBtnProgChair;
            $currentFunctionForRejectBtn = $functionForRejectBtn;
            $approveBtnText = 'Approve';
            $borderPC = $borderGoldenRod;
            $greenBtnValue ='Approve';
            $programChairTxt = 'Program Chair';
            $programChairValue = $PC;
                
            }
        else if($cdStatus=='approved'  && $ProgChairStatus == 'approved'){
            $pcCss = $approvedCSS;
            $pcImg = $approvedImageSrc; 
            $statusRectangleCSS = 'display: block;' . $approvedCSS;
            $dateDisplayCSS = 'display: block;';
            $getStatusRedBtn = $rejectBtnRemoved;
            $btnContainerStatus = $btnContainerItemsCentered;
            $getStatusGreenBtn = 'display: none;';
            $currentFunctionForApprvBtn = "";                
            $borderPC = $borderGreen;
            $greenBtnValue = 'Done';
            $programChairTxt = 'Program Chair';
            $programChairValue = $PC;
            }
        

        if (!$result) {
            die("Query failed: " . $conn->error);
        } 



        if ($resultsqlFLH->num_rows > 0) {
            $rowrsFLH = $resultsqlFLH->fetch_assoc();
            $facilities_requirements = $rowrsFLH['facilities_requirements'];
            $learning_resource_center = $rowrsFLH['learning_resource_center'];
            $hotel_management = $rowrsFLH['hotel_management'];
        } else {
            die("No records found for organization: " . $org);
        }

        $actDateTime = $row['activity_datetime'];

        
       if ($OrgAdvStatus == 'approved') {
            $currentStatusImgOA = $approvedImageSrc;
            $currentCSSOA = $approvedCSS;
        } else if($OrgAdvStatus == 'pending') {
            $currentStatusImgOA = $pendingImageSrc;
            $currentCSSOA = $pendingCSS;
        }

        if ($cdStatus == 'approved') {
            $currentStatusImgCD = $approvedImageSrc;
            $currentCSSCD = $approvedCSS;
        } else if($cdStatus == 'pending') {
            $currentStatusImgCD = $pendingImageSrc;
            $currentCSSCD = $pendingCSS;
        }
        
        

        $conn->close();

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/orgadvapprovalprogress.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
        <div class="circle"><img src="<?php echo $approvedImageSrc?>" style="<?php  echo $circleIconSize?>" draggable="false"></div>
        <div style="<?php echo $grayline ?>"></div>

    </div>
    <div class="circleDetails" style="word-wrap:break-word;">
        <p style="font-weight: bold; font-size: 10px; margin-top: 4px;">Requester</p>
        <p style="font-size: 10px; margin-top: 4px;"><?php echo $row['program_organization']?> - <?php echo $row['activity_options']?></p>
        <p style="<?php echo $approvedCSS?>">SUBMITTED</p>
        <p style="font-size: 10px; margin-top: 4px;"><?php echo date("Y-m-d",strtotime($row['date_requested'])) ?></p>


    </div>
</div>

<!--___________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________-->

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

<!--___________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________-->

<div id="CD" class="statusDiv">
<div class="circleContainer">
        <div class="circle"><img src="<?php echo $currentStatusImgCD ?>" style="<?php echo $circleIconSize ?>" draggable="false"></div>
        <div class="statusLine"></div>

    </div>
      <div class="circleDetails" style="word-wrap:break-word;">
        <p style="font-weight: bold; font-size: 10px; margin-top: 4px;">College Dean</p>
        <p style="font-size: 10px; margin-top: 4px;">Director</p>
        <p id="pendingDetailSDAO" style="<?php echo $currentCSSCD ?>"><?php echo $cdStatusUC ?></p>
        <p style="font-size: 10px; margin-top: 4px;"><?php 
if($dateResponseCD == '0000-00-00 00:00:00'){
echo "00-00-00 00:00";
}else{
echo date("y-m-d h:i A", strtotime($dateResponseCD));
} ?></p>
        <style>
          
        </style>
    </div>
</div>

<!--___________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________-->

<div id="PC" class="statusDiv">
<div class="circleContainer">
        <div class="circle"><img src="<?php echo $pcImg; ?>" id="pendingToApproveImg2" style="<?php echo $circleIconSize . "" . $borderPC?>" draggable="false"></div>

        <div style="<?php echo $grayline ?>"></div>

    </div>
    <div class="circleDetails" style="word-wrap:break-word;">
                        <p style="font-weight: bold; font-size: 10px; margin-top: 4px;"><?php echo $programChairTxt ?></p>
                        <p style="font-size: 10px; margin-top: 4px;"><?php echo $programChairValue ?></p>
                        <p id="pendingDetail2"style="<?php echo $statusRectangleCSS ?>"><?php echo $ProgChairStatusUC ?></p>
                        <p style="font-size: 10px; margin-top: 4px; <?php echo $dateDisplayCSS ?>">
                        <?php 
        if($dateResponsePC == '0000-00-00 00:00:00'){
            echo "00-00-00 00:00";
        }else{
            echo date("y-m-d h:i A", strtotime($dateResponsePC));
         } ?></p>
                    </div>  
</div>

<!--___________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________-->

<!-- status circles and details -->

<?php 
$approverCount = 0;
$valuesOfSorArray = array_keys($rowOfSOR);
for ($i = 5; $i < count($valuesOfSorArray); $i++) {
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

                        <div class="inputLine"><div class="asking">Venue<div>:</div></div> 
                        <div class="nameDisplay"><?php echo (!empty($facilities_requirements) && $facilities_requirements !== 'none') ? $facilities_requirements . '<br>' : ''; 
                        echo (!empty($learning_resource_center) && $learning_resource_center !== 'none') ? $learning_resource_center . '<br>' : '';
                        echo (!empty($hotel_management) && $hotel_management !== 'none') ? $hotel_management : '';?></div>
                        </div>

                        <div class="inputLine"><div class="asking">Date<div>:</div></div>
                        <div class="orgDisplay"><?php echo date("Y-m-d",strtotime($actDateTime))?></div>
                        </div>
                        
                        <div class="inputLine"><div class="asking">Start Time<div>:</div></div>
                        <div class="themeDisplay"><?php echo date("h:i A",strtotime($actDateTime))?></div>
                        </div>

                        <div class="inputLine"><div class="asking">No. of Participants <div>:</div></div>
                        <div class="participantsDisplay"><?php echo $row['target_participants']?></div>
                        </div>
                     

                    </div>

                    <div class="rightActivityDetails">

                        <div class="attachmentBox" style=" height: 190px; width: 300px; padding-bottom: 20px; font-family: sans-serif; font-weight: bold; font-size: 24px; display: flex; flex-direction:column; align-items:center;">
                        Attachment

                        <div class="fileAttach" style="border:solid 1px; height: 40px; width:250px; border-radius: 45px; margin-top: 20px;"></div>

                        <div class="rejectApproveBtnContainer" style="<?php echo $btnContainerStatus?>">

                        <div class="rejectBtn" id="rejectBtnId" onclick="<?php echo $currentFunctionForRejectBtn ?>" style="<?php echo $getStatusRedBtn?>">Reject</div>
                        <div class="approveBtn" id="approveBtn"onclick="<?php echo $currentFunctionForApprvBtn?>" style="<?php echo $getStatusGreenBtn ?>"><?php echo $greenBtnValue ?></div>
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
                                    <button onclick="hideRejectRequestPC()" class="overlayCancelBtn">Cancel</button>
                                    <button onclick="proceedRejectFunction('<?php echo $org; ?>')" class="overlayRejectBtn">Reject</button>

                                    </div>
                                 
                                </div>
                            </div>

                        </div>
                     


<script>
  function showRejectRequestPC() {
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('rejectCommentBox').style.display = 'block';
  }
  function hideRejectRequestPC() {
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
                hideRejectRequestPC();
                doneRejecting();
            },
        });  
    } else {
    }
}

function doneRejecting() {
            $.ajax({
                url: 'PCApprovalpage.php',
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