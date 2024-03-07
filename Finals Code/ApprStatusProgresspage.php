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
 
        $sql = "SELECT name, date_requested, program_organization, activity_title, activity_datetime, target_participants, activity_types, activity_options, sdao_options FROM sarf_requests WHERE program_organization = '$org'" ;
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

        $sqlOaPc = "SELECT program_chair, org_adviser FROM nu_accountsdb.studentaccounts WHERE program_organization = '$org'";
        $resultOaPc = $conn->query($sqlOaPc);
        if (!$resultOaPc) {
            die("Query failed: " . $conn->error);
        }
        $rowOaPc = $resultOaPc->fetch_assoc();  
        $OA = $rowOaPc['org_adviser'];
        $PC = $rowOaPc['program_chair'];

       $statusOfRequests = "SELECT org_adviser, prog_chair, sdao, fmo, itso, lrc, hm, asd, sad, ed, cd from status_of_requests WHERE user_id = $userId";
       $resultStatusOfRequests = $conn->query($statusOfRequests);
       $rowStatusOfRequests = $resultStatusOfRequests->fetch_assoc();

       $OrgAdvStatus = $rowStatusOfRequests['org_adviser'];
       $OrgAdvStatusUC = strtoupper($OrgAdvStatus);

       $prog_chairStatus = $rowStatusOfRequests['prog_chair'];
       $prog_chairStatusUC = strtoupper($prog_chairStatus);

       $sdaoStatus = $rowStatusOfRequests['sdao'];
       $sdaoStatusUC = strtoupper($sdaoStatus);

       $fmoStatus = $rowStatusOfRequests['fmo'];
       $fmoStatusUC = strtoupper($fmoStatus);

       $itsoStatus = $rowStatusOfRequests['itso'];
       $itsoStatusUC = strtoupper($itsoStatus);

       $lrcStatus = $rowStatusOfRequests['lrc'];
       $lrcStatusUC = strtoupper($lrcStatus);

       $hmStatus = $rowStatusOfRequests['hm'];
       $hmStatusUC = strtoupper($hmStatus);

       $asdStatus = $rowStatusOfRequests['asd'];
       $asdStatusUC = strtoupper($asdStatus);

       $sadStatus = $rowStatusOfRequests['sad'];
       $sadStatusUC = strtoupper($sadStatus);

       $edStatus = $rowStatusOfRequests['ed'];
       $edStatusUC = strtoupper($edStatus);

       $cdStatus = $rowStatusOfRequests['cd'];
       $cdStatusUC = strtoupper($cdStatus);

       $statusOfRequests = "SELECT * FROM `status_of_requests` WHERE user_id = $userId";
       $resultSOR = $conn->query($statusOfRequests);
       $rowOfSOR = $resultSOR->fetch_assoc();

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
  


       $pendingCSS = 'font-size: 10px; font-weight: bold; background-color: rgba(245, 215, 98, 1); margin-top: 4px;
       width: 68px; height: 18px; align-items:center; display: flex; justify-content: center; border-radius: 6.8px;';
       
       $approvedCSS = 'font-size: 10px; font-weight: bold; background-color: rgba(153, 217, 71, 1); margin-top: 4px;
       width: 68px; height: 18px; align-items:center; display: flex; justify-content: center; border-radius: 6.8px;';

       $grayline = 'width: 55px; background-color: rgba(217, 217, 217, 1); height: 1.5px; margin-left: 5px;margin-right: 5px;';
       
       $approvedImageSrc = 'IMG/approvedIcon.png';
       $pendingImageSrc = 'IMG/pendingIcon.png';
       $circleIconSize = 'height: 33px; width: 33px; margin-top: 4.5px; border-radius: 50%;';


   

    

       if ($OrgAdvStatus == 'approved') {
            $currentStatusImgOA = $approvedImageSrc;
            $currentCSSOA = $approvedCSS;
        } else if($OrgAdvStatus == 'pending') {
            $currentStatusImgOA = $pendingImageSrc;
            $currentCSSOA = $pendingCSS;
        }

        if($prog_chairStatus == 'approved'){
            $currentStatusImgPC = $approvedImageSrc;
            $currentCSSPC = $approvedCSS;
        } else  if($prog_chairStatus == 'pending'){
            $currentStatusImgPC = $pendingImageSrc;
            $currentCSSPC = $pendingCSS;
        } 

        if ($sdaoStatus == 'approved') {
            $currentStatusImgSDAO = $approvedImageSrc;
            $currentCSSSDAO = $approvedCSS;
        } else if($sdaoStatus == 'pending') {
            $currentStatusImgSDAO = $pendingImageSrc;
            $currentCSSSDAO = $pendingCSS;
        }

        $ifNoneHideDiv = 'display: none;';

        $hideFmo = '';
        if ($fmoStatus == 'approved') {
            $currentStatusImgFMO = $approvedImageSrc;
            $currentCSSFMO = $approvedCSS;
        } else if($fmoStatus == 'pending') {
            $currentStatusImgFMO = $pendingImageSrc;
            $currentCSSFMO = $pendingCSS;
        } else if($fmoStatus == 'none'){
            $hideFmo = $ifNoneHideDiv;
        }

        $hideItso = '';
        if ($itsoStatus == 'approved') {
            $currentStatusImgITSO = $approvedImageSrc;
            $currentCSSITSO = $approvedCSS;
        } else if($itsoStatus == 'pending') {
            $currentStatusImgITSO = $pendingImageSrc;
            $currentCSSITSO = $pendingCSS;
        } else if($itsoStatus == 'none'){
            $hideItso = $ifNoneHideDiv;
        }

        $hideLrc = '';
        if ($lrcStatus == 'approved') {
            $currentStatusImgLRC = $approvedImageSrc;
            $currentCSSLRC = $approvedCSS;
        } else if($lrcStatus == 'pending') {
            $currentStatusImgLRC = $pendingImageSrc;
            $currentCSSLRC = $pendingCSS;
        } else if($lrcStatus == 'none'){
            $hideLrc = $ifNoneHideDiv;
        }

        $hideHm = '';
        if ($hmStatus == 'approved') {
            $currentStatusImgHM = $approvedImageSrc;
            $currentCSSHM = $approvedCSS;
        } else if($hmStatus == 'pending') {
            $currentStatusImgHM = $pendingImageSrc;
            $currentCSSHM = $pendingCSS;
        } else if($hmStatus == 'none'){
            $hideHm = $ifNoneHideDiv;
        }

        if ($asdStatus == 'approved') {
            $currentStatusImgASD = $approvedImageSrc;
            $currentCSSASD = $approvedCSS;
        } else if($asdStatus == 'pending') {
            $currentStatusImgASD = $pendingImageSrc;
            $currentCSSASD = $pendingCSS;
        }

        $hideSad = '';
        if ($sadStatus == 'approved') {
            $currentStatusImgSAD = $approvedImageSrc;
            $currentCSSSAD = $approvedCSS;
        } else if($sadStatus == 'pending') {
            $currentStatusImgSAD = $pendingImageSrc;
            $currentCSSSAD = $pendingCSS;
        } else if ($sadStatus == 'none'){
            $hideSad = $ifNoneHideDiv;
        }
        
        $hideEd = '';
        if ($edStatus == 'approved') {
            $currentStatusImgED = $approvedImageSrc;
            $currentCSSED = $approvedCSS;
        } else if($edStatus == 'pending') {
            $currentStatusImgED = $pendingImageSrc;
            $currentCSSED = $pendingCSS;
        } else if ($edStatus == 'none'){
            $hideEd = $ifNoneHideDiv;
        }

        if ($cdStatus == 'approved') {
            $currentStatusImgCD = $approvedImageSrc;
            $currentCSSCD = $approvedCSS;
        } else if($cdStatus == 'pending') {
            $currentStatusImgCD = $pendingImageSrc;
            $currentCSSCD = $pendingCSS;
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
    <link rel="stylesheet" href="CSS/statusprogress.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="functions.js"></script>
    <title>Document</title>    
    

</head>
<body>
      <div class="split-background">

        <div class="right">
        <div class="titleBox">
            <div class="upperTitle">
            <h1 class="h1Title">ACTIVITY STATUS</h1>
           
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
                            <div class="circle"><img src="<?php echo $currentStatusImgCD ?>" style="<?php echo $circleIconSize ?>" draggable="false"></div>

                        </div>
                          <div class="circleDetails" style="word-wrap:break-word;">
                            <p style="font-weight: bold; font-size: 10px; margin-top: 4px;">College Dean</p>
                            <p style="font-size: 10px; margin-top: 4px;"><?php echo $CD ?></p>
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

                    <div id="FMO" class="statusDiv" style="<?php echo $hideFmo?>">
                    <div class="circleContainer">
                            <div class="circle"><img src="<?php echo $currentStatusImgFMO ?>" style="<?php echo $circleIconSize ?>" draggable="false"></div>
                            <div class="statusLine"></div>

                        </div>
                          <div class="circleDetails" style="word-wrap:break-word;">
                            <p style="font-weight: bold; font-size: 10px; margin-top: 4px;">Facilities Management Office</p>
                            <p style="font-size: 10px; margin-top: 4px;">Engr. Sarah Libron</p>
                            <p id="pendingDetailSDAO" style="<?php echo $currentCSSFMO ?>"><?php echo $fmoStatusUC ?></p>
                            <p style="font-size: 10px; margin-top: 4px;"><?php 
        if($dateResponseFMO == '0000-00-00 00:00:00'){
            echo "00-00-00 00:00";
        }else{
            echo date("y-m-d h:i A", strtotime($dateResponseFMO));
         } ?></p>
                            <style>
                              
                            </style>
                        </div>
                    </div>

                    <div id="ITSO" class="statusDiv" style="<?php echo $hideItso?>">
                    <div class="circleContainer">
                            <div class="circle"><img src="<?php echo $currentStatusImgITSO ?>" style="<?php echo $circleIconSize ?>" draggable="false"></div>
                            <div class="statusLine"></div>

                        </div>
                          <div class="circleDetails" style="word-wrap:break-word;">
                            <p style="font-weight: bold; font-size: 10px; margin-top: 4px;">Information Technology System Office</p>
                            <p style="font-size: 10px; margin-top: 4px;">Mr. Peter Magcaling</p>
                            <p id="pendingDetailSDAO" style="<?php echo $currentCSSITSO ?>"><?php echo $itsoStatusUC ?></p>
                            <p style="font-size: 10px; margin-top: 4px;"><?php 
        if($dateResponseITSO == '0000-00-00 00:00:00'){
            echo "00-00-00 00:00";
        }else{
            echo date("y-m-d h:i A", strtotime($dateResponseITSO));
         } ?></p>
                            <style>
                              
                            </style>
                        </div>
                    </div>

                    <div id="LRC" class="statusDiv" style="<?php echo $hideLrc?>">
                    <div class="circleContainer">
                            <div class="circle"><img src="<?php echo $currentStatusImgLRC ?>" style="<?php echo $circleIconSize ?>" draggable="false"></div>
                            <div class="statusLine"></div>

                        </div>
                          <div class="circleDetails" style="word-wrap:break-word;">
                            <p style="font-weight: bold; font-size: 10px; margin-top: 4px;">Learning Resource Center</p>
                            <p style="font-size: 10px; margin-top: 4px;">Ms. Sandra Narciso</p>
                            <p id="pendingDetailSDAO" style="<?php echo $currentCSSLRC ?>"><?php echo $lrcStatusUC ?></p>
                            <p style="font-size: 10px; margin-top: 4px;"><?php 
        if($dateResponseLRC == '0000-00-00 00:00:00'){
            echo "00-00-00 00:00";
        }else{
            echo date("y-m-d h:i A", strtotime($dateResponseLRC));
         } ?></p>
                            <style>
                              
                            </style>
                        </div>
                    </div>

                    <div id="HM" class="statusDiv" style="<?php echo $hideHm?>">
                    <div class="circleContainer">
                            <div class="circle"><img src="<?php echo $currentStatusImgHM ?>" style="<?php echo $circleIconSize ?>" draggable="false"></div>
                            <div class="statusLine"></div>

                        </div>
                          <div class="circleDetails" style="word-wrap:break-word;">
                            <p style="font-weight: bold; font-size: 10px; margin-top: 4px;">Hotel Management</p>
                            <p style="font-size: 10px; margin-top: 4px;">Mr. Errol Martin</p>
                            <p id="pendingDetailSDAO" style="<?php echo $currentCSSHM ?>"><?php echo $hmStatusUC ?></p>
                            <p style="font-size: 10px; margin-top: 4px;"><?php 
        if($dateResponseHM == '0000-00-00 00:00:00'){
            echo "00-00-00 00:00";
        }else{
            echo date("y-m-d h:i A", strtotime($dateResponseHM));
         } ?></p>
                            <style>
                              
                            </style>
                        </div>
                    </div>

                    <div id="ASD" class="statusDiv">
                    <div class="circleContainer">
                            <div class="circle"><img src="<?php echo $currentStatusImgASD ?>" style="<?php echo $circleIconSize ?>" draggable="false"></div>
                            <div class="statusLine"></div>

                        </div>
                          <div class="circleDetails" style="word-wrap:break-word;">
                            <p style="font-weight: bold; font-size: 10px; margin-top: 4px;">Academic Service Director</p>
                            <p style="font-size: 10px; margin-top: 4px;">Jhun G. Himoldang</p>
                            <p id="pendingDetailSDAO" style="<?php echo $currentCSSASD ?>"><?php echo $asdStatusUC ?></p>
                            <p style="font-size: 10px; margin-top: 4px;"><?php 
        if($dateResponseASD == '0000-00-00 00:00:00'){
            echo "00-00-00 00:00";
        }else{
            echo date("y-m-d h:i A", strtotime($dateResponseASD));
         } ?></p>
                            <style>
                              
                            </style>
                        </div>
                    </div>

                    <div id="SAD" class="statusDiv" style="<?php echo $hideSad?>">
                    <div class="circleContainer">
                            <div class="circle"><img src="<?php echo $currentStatusImgSAD ?>" style="<?php echo $circleIconSize ?>" draggable="false"></div>
                            <div class="statusLine"></div>

                        </div>
                          <div class="circleDetails" style="word-wrap:break-word;">
                            <p style="font-weight: bold; font-size: 10px; margin-top: 4px;">Senior Academic Director</p>
                            <p style="font-size: 10px; margin-top: 4px;">Ma. Donna B. Lalusin</p>
                            <p id="pendingDetailSDAO" style="<?php echo $currentCSSSAD ?>"><?php echo $sadStatusUC ?></p>
                            <p style="font-size: 10px; margin-top: 4px;"><?php 
        if($dateResponseSAD == '0000-00-00 00:00:00'){
            echo "00-00-00 00:00";
        }else{
            echo date("y-m-d h:i A", strtotime($dateResponseSAD));
         } ?></p>
                            <style>
                              
                            </style>
                        </div>
                    </div>

                    <div id="ED" class="statusDiv" style="<?php echo $hideEd?>">
                    <div class="circleContainer">
                            <div class="circle"><img src="<?php echo $currentStatusImgED ?>" style="<?php echo $circleIconSize ?>" draggable="false"></div>
                            

                        </div>
                          <div class="circleDetails" style="word-wrap:break-word;">
                            <p style="font-weight: bold; font-size: 10px; margin-top: 4px;">Executive Director</p>
                            <p style="font-size: 10px; margin-top: 4px;">Ricky R. Lawas</p>
                            <p id="pendingDetailSDAO" style="<?php echo $currentCSSED ?>"><?php echo $edStatusUC ?></p>
                            <p style="font-size: 10px; margin-top: 4px;"><?php 
        if($dateResponseED == '0000-00-00 00:00:00'){
            echo "00-00-00 00:00";
        }else{
            echo date("y-m-d h:i A", strtotime($dateResponseED));
         } ?></p>
                            <style>
                              
                            </style>
                        </div>
                    </div>

                 


<!-- ------------------------------------------------------------------------------------------------------------------------->

                </div>
                <div class="activityDetailsContainer">
                    <div class="leftActivityDetails">
                        <div class="firstLine">Event Details</div><br>
                        
                        <div class="inputLine"><div class="asking">Activity Name<div>:</div></div>
                        <div class="themeDisplay"><?php echo $row['activity_title']?></div>
                        </div><br>

                        <div class="inputLine"><div class="asking">Activity Type <div>:</div></div>
                        <div class="actDescDisplay"><?php echo $row['activity_options']?></div>
                        </div><br>

                        <div class="inputLine"><div class="asking">Orgs Name <div>:</div></div>
                        <div class="orgDisplay"><?php echo $row['program_organization']?></div>
                        </div><br>

                        <div class="inputLine"><div class="asking">Date<div>:</div></div>    
                        <div class="dateTimeDisplay"><?php echo date("Y-m-d h:i A",strtotime($row['activity_datetime']))?></div>
                        </div><br>
                     

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