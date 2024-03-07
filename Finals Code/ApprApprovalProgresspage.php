<?php
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
       $valueOfEmail = $_SESSION['email'];
   

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
 
        $sql = "SELECT name, date_requested, program_organization, activity_title, activity_datetime, activity_end_datetime, target_participants, activity_types, activity_options, sdao_options FROM sarf_requests WHERE program_organization = '$org'" ;
        $result = $conn->query($sql);

        $sqlUserId = "SELECT user_id FROM sarf_requests WHERE program_organization = '$org'";
        $resultUserId = $conn->query($sqlUserId);
    
        if (!$resultUserId) {
            die("Query failed: " . $conn->error);
        }
    
        $rowUserId = $resultUserId->fetch_assoc();
        $userId = $rowUserId['user_id'];

        $sqlFMO = "SELECT facilities_requirements, learning_resource_center, hotel_management FROM sarf.student_activity_requests where user_id = '$userId'";
        $resultsqlFMO = $conn->query($sqlFMO);

       $statusOfSdao = "SELECT sdao from status_of_requests WHERE user_id = $userId";
       $resultStatusOfSdao = $conn->query($statusOfSdao);
       $rowStatusOfSdao = $resultStatusOfSdao->fetch_assoc();
       $sdaoStatus = $rowStatusOfSdao['sdao'];
       $sdaoStatusUC = strtoupper($sdaoStatus);

       $statusOfOaPcSdaoFmo = "SELECT org_adviser, prog_chair, sdao, fmo, itso, lrc, hm from status_of_requests WHERE user_id = $userId";
       $resultStatusOfOaPcSdaoFmo = $conn->query($statusOfOaPcSdaoFmo);
       $rowStatusOfOaPcSdaoFmo = $resultStatusOfOaPcSdaoFmo->fetch_assoc();

       $OrgAdvStatus = $rowStatusOfOaPcSdaoFmo['org_adviser'];
       $OrgAdvStatusUC = strtoupper($OrgAdvStatus);

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

       $pendingCSS = 'font-size: 10px; font-weight: bold; background-color: rgba(245, 215, 98, 1); margin-top: 4px;
       width: 68px; height: 18px; align-items:center; display: flex; justify-content: center; border-radius: 6.8px;';
       
       $approvedCSS = 'font-size: 10px; font-weight: bold; background-color: rgba(153, 217, 71, 1); margin-top: 4px;
       width: 68px; height: 18px; align-items:center; display: flex; justify-content: center; border-radius: 6.8px;';

       $grayline = 'width: 55px; background-color: rgba(217, 217, 217, 1); height: 1.5px; margin-left: 5px;margin-right: 5px;';
       
       $approvedImageSrc = 'IMG/approvedIcon.png';
       $pendingImageSrc = 'IMG/pendingIcon.png';
       $grayPic = 'IMG/grayStatus.png';
       $circleIconSize = 'height: 33px; width: 32px; margin-top: 4.5px; border-radius: 50%;';


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

       $functionForApproveBtnFMO = "approveRequestFmo('" . $org . "')";
       $functionForApproveBtnITSO = "approveRequestITSO('" . $org . "')";
       $functionForApproveBtnLRC = "approveRequestLRC('" . $org . "')";
       $functionForApproveBtnHM = "approveRequestHM('" . $org . "')";
       $functionForRejectBtn = "showRejectRequestFmo()";

       $displayDetails = '';
       $hideDetails = 'display: none;';
       $hidden = 'visibility: hidden;';
       $displayDetailsFMO = $displayDetails;
       $displayDetailsITSO = $hideDetails;
       $displayDetailsLRC = $hideDetails;
       $displayDetailsHM = $hideDetails;
       
       $itsoValue = "";
       $itsoApproverValue = "";
       $visibleNoneITSO = $hidden;
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

        if($pcStatus == 'pending'){
            $imgStatusPC = $pendingImageSrc;
            $cssStatusPC = $pendingCSS;
        }
        else if($pcStatus == 'approved'){
            $cssStatusPC = $approvedCSS;
            $imgStatusPC = $approvedImageSrc;
        }

        $imgStatusITSO = $grayPic;

        if ($sdaoStatus == 'pending') {
            $imgStatusSDAO = $pendingImageSrc;
            $cssStatusSDAO = $pendingCSS;
            $imgStatusFMO = $grayPic;
            $fmoValue = "";
            $fmoApproverValue = "";
            $statusRectangleCSSFMO = 'display: none;';
            $dateDisplayCSSFMO = 'display: none;';
            $borderFMO = $borderGray;
            $currentFunctionForApproveBtn = "";
            $currentFunctionForRejectBtn = "";
            $getStatusGreenBtn = $approveBtnStyle . "cursor: default;";
            $getStatusRedBtn = $rejectBtnDefault . "cursor: default;";
            $btnContainerStatus = $btnContainerDefault;
            
        } else if($sdaoStatus == 'approved') {
            $cssStatusSDAO = $approvedCSS;
            $imgStatusSDAO = $approvedImageSrc;
            $fmoValue = "Facility - Management Office";
            $fmoApproverValue = "Engr. Sarah Libron";
 
            if($fmoStatus == 'approved'){
                $imgStatusFMO = $approvedImageSrc;
                $statusRectangleCSSFMO = $approvedCSS;
                $dateDisplayCSSFMO = '';
                $borderFMO = $borderGreen;
                $currentFunctionForApproveBtn = "";
                $currentFunctionForRejectBtn = "";
                $getStatusGreenBtn = $doneBtnStyle . "cursor: default;";
                $getStatusRedBtn = $rejectBtnRemoved;
                $btnContainerStatus = $btnContainerItemsCentered;
               
                
                $greenBtnValue = 'Done';

            } else if ($fmoStatus == 'pending'){
                $imgStatusFMO = $pendingImageSrc;
                $statusRectangleCSSFMO = $pendingCSS;
                $borderFMO = $borderGoldenRod;
                $currentFunctionForApproveBtn = $functionForApproveBtnFMO;
                $currentFunctionForRejectBtn = $functionForRejectBtn;
                $getStatusGreenBtn = $approveBtnStyle;
                $getStatusRedBtn = $rejectBtnDefault;
                $btnContainerStatus = $btnContainerDefault;
          
                
            }

            }
//ITSO SIDE |---------------------------------------------------------------------------------------------------------------->
//----------V

            if($valueOfEmail == 'itso@nu-fairview.edu.ph'){
                $displayDetailsITSO = $displayDetails;
                $displayDetailsFMO = $hideDetails;
                $borderFMO = '';
                $fmoValue = "Facility - Management Office";
                $fmoApproverValue = "Engr. Sarah Libron";
                $visibleNoneITSO = '';

                if($fmoStatus == 'none'){
                    if($sdaoStatus == 'pending'){
                        $currentFunctionForApproveBtn = '';
                        $currentFunctionForRejectBtn = '';
                        $btnContainerStatus = $btnContainerDefault;
                        $getStatusGreenBtn = $approveBtnStyle . 'cursor: default;';
                        $getStatusRedBtn = $rejectBtnDefault . 'cursor: default;';
                        $dateDisplayCSSITSO = 'display: none;';
                        $greenBtnValue = 'Approve';     
                        
    
                        $borderITSO = $borderGray;
                        $itsoApproverValue = '';
                        $itsoValue = '';
                        $statusRectangleCSSITSO = 'display: none;';
                    } else if ($sdaoStatus == 'approved' && $itsoStatus == 'pending'){
                        $borderITSO = $borderGoldenRod;
                        $imgStatusITSO = $pendingImageSrc;
                        $itsoApproverValue = 'Mr. Peter Magcaling';
                        $itsoValue = "Information - Technology System Office";
                        $statusRectangleCSSITSO = $pendingCSS;
                        $btnContainerStatus = $btnContainerDefault;
                        $getStatusGreenBtn = $approveBtnStyle;
                        $getStatusRedBtn = $rejectBtnDefault;
                        $currentFunctionForApproveBtn = $functionForApproveBtnITSO;
                        $currentFunctionForRejectBtn = $functionForRejectBtn;
                        $greenBtnValue = 'Approve';
                    } else if ($sdaoStatus == 'approved' && $itsoStatus == 'approved'){
                        $borderITSO = $borderGreen;
                        $imgStatusITSO = $approvedImageSrc;
                        $itsoApproverValue = 'Mr. Peter Magcaling';
                        $itsoValue = "Information - Technology System Office";
                        $statusRectangleCSSITSO = $approvedCSS;
                        $btnContainerStatus = 'display: none;';
    
                    }
                    
                    

                }
                

                 else if($fmoStatus == 'pending'){
                    $imgStatusFMO = $pendingImageSrc;
                    $statusRectangleCSSFMO = $pendingCSS;
                    $currentFunctionForApproveBtn = '';
                    $currentFunctionForRejectBtn = '';
                    $btnContainerStatus = $btnContainerDefault;
                    $getStatusGreenBtn = $approveBtnStyle . 'cursor: default;';
                    $getStatusRedBtn = $rejectBtnDefault . 'cursor: default;';
                    $dateDisplayCSSFMO = 'display: block;';
                    $dateDisplayCSSITSO = 'display: none;';
                    $greenBtnValue = 'Approve';     
                    

                    $borderITSO = $borderGray;
                    $itsoApproverValue = '';
                    $itsoValue = '';
                    $statusRectangleCSSITSO = 'display: none;';
                } else if ($fmoStatus == 'approved' && $itsoStatus == 'pending'){
                    $borderITSO = $borderGoldenRod;
                    $imgStatusITSO = $pendingImageSrc;
                    $itsoApproverValue = 'Mr. Peter Magcaling';
                    $itsoValue = "Information - Technology System Office";
                    $statusRectangleCSSITSO = $pendingCSS;
                    $btnContainerStatus = $btnContainerDefault;
                    $getStatusGreenBtn = $approveBtnStyle;
                    $getStatusRedBtn = $rejectBtnDefault;
                    $currentFunctionForApproveBtn = $functionForApproveBtnITSO;
                    $currentFunctionForRejectBtn = $functionForRejectBtn;
                    $greenBtnValue = 'Approve';
                } else if ($fmoStatus == 'approved' && $itsoStatus == 'approved'){
                    $borderITSO = $borderGreen;
                    $imgStatusITSO = $approvedImageSrc;
                    $itsoApproverValue = 'Mr. Peter Magcaling';
                    $itsoValue = "Information - Technology System Office";
                    $statusRectangleCSSITSO = $approvedCSS;
                    $btnContainerStatus = 'display: none;';

                }



            }

//LRC SIDE |-----itso gagawing lrc--fmo gagawing itso--------------------------------------------------------------------------------->
//----------V


if($valueOfEmail == 'lrc@nu-fairview.edu.ph'){
    if ($fmoStatus == 'approved') {
        $imgStatusFMO = $approvedImageSrc;
        $currentStatusImgFMO = $approvedImageSrc;
        $statusRectangleCSSFMO = $approvedCSS;

        $fmoValue = "Facility Management Office";
        $fmoApproverValue = "Engr. Sarah Libron";
        $dateDisplayCSSFMO = '';
          
        } else if($fmoStatus == 'pending') {
        $imgStatusFMO = $pendingImageSrc;
        $currentStatusImgFMO = $pendingImageSrc;
        $statusRectangleCSSFMO = $pendingCSS;

        $fmoValue = "Facility - Management Office";
        $fmoApproverValue = "Engr. Sarah Libron";
        $dateDisplayCSSFMO = '';
        }


    $displayDetailsLRC = $displayDetails;
    $displayDetailsITSO = $hideDetails;
    $displayDetailsFMO = $hideDetails;

    $borderITSO = '';
    $borderFMO = '';
    $visibleNoneLRC = '';
    $visibleNoneITSO = '';
    $lrcValue = "Learning Resource Center";
    $lrcApproverValue = "Ms. Sandra Narciso";

     if($itsoStatus == 'none'  && $fmoStatus != 'none'){
        if($fmoStatus == 'pending'){
            $imgStatusLRC = $grayPic;
            $borderLRC = $borderGray;
            $lrcValue = '';
            $lrcApproverValue = '';
            $statusRectangleCSSLRC = 'display: none;';
            $dateDisplayCSSLRC = 'display: none;';
    
            $greenBtnValue = 'Approve';   
            $currentFunctionForApproveBtn = '';
            $currentFunctionForRejectBtn = ''; 
            $btnContainerStatus = $btnContainerDefault;
            $getStatusGreenBtn = $approveBtnStyle . 'cursor: default;';
            $getStatusRedBtn = $rejectBtnDefault . 'cursor: default;';
    
        } else if ($fmoStatus == 'approved' && $lrcStatus == 'pending'){
            $borderLRC = $borderGoldenRod;
            $imgStatusLRC = $pendingImageSrc;
            $statusRectangleCSSLRC = $pendingCSS;
    
            $btnContainerStatus = $btnContainerDefault;
            $getStatusGreenBtn = $approveBtnStyle;
            $getStatusRedBtn = $rejectBtnDefault;
            $greenBtnValue = 'Approve';
            $currentFunctionForApproveBtn = $functionForApproveBtnLRC;
            $currentFunctionForRejectBtn = $functionForRejectBtn;
       
        } else if ($fmoStatus == 'approved' && $lrcStatus == 'approved'){
            $borderLRC = $borderGreen;
            $imgStatusLRC = $approvedImageSrc;
            $statusRectangleCSSLRC = $approvedCSS;
            $btnContainerStatus = 'display: none;';
    
                   
        }
    

    }

    else if($fmoStatus == 'none' && $itsoStatus == 'none'){
        if($sdaoStatus == 'pending'){
            $imgStatusLRC = $grayPic;
            $borderLRC = $borderGray;
            $lrcValue = '';
            $lrcApproverValue = '';
            $statusRectangleCSSLRC = 'display: none;';
            $dateDisplayCSSLRC = 'display: none;';
    
            $greenBtnValue = 'Approve';   
            $currentFunctionForApproveBtn = '';
            $currentFunctionForRejectBtn = ''; 
            $btnContainerStatus = $btnContainerDefault;
            $getStatusGreenBtn = $approveBtnStyle . 'cursor: default;';
            $getStatusRedBtn = $rejectBtnDefault . 'cursor: default;';
    
        } else if ($sdaoStatus == 'approved' && $lrcStatus == 'pending'){
            $borderLRC = $borderGoldenRod;
            $imgStatusLRC = $pendingImageSrc;
            $statusRectangleCSSLRC = $pendingCSS;
    
            $btnContainerStatus = $btnContainerDefault;
            $getStatusGreenBtn = $approveBtnStyle;
            $getStatusRedBtn = $rejectBtnDefault;
            $greenBtnValue = 'Approve';
            $currentFunctionForApproveBtn = $functionForApproveBtnLRC;
            $currentFunctionForRejectBtn = $functionForRejectBtn;
       
        } else if ($sdaoStatus == 'approved' && $lrcStatus == 'approved'){
            $borderLRC = $borderGreen;
            $imgStatusLRC = $approvedImageSrc;
            $statusRectangleCSSLRC = $approvedCSS;
            $btnContainerStatus = 'display: none;';
    
                   
        }
    

    }

    

    else if($itsoStatus == 'pending'){
        $imgStatusITSO = $pendingImageSrc;
        $itsoApproverValue = 'Mr. Peter Magcaling';
        $itsoValue = "Information - Technology System Office";
        $statusRectangleCSSITSO = $pendingCSS;
  
        $imgStatusLRC = $grayPic;
        $borderLRC = $borderGray;
        $lrcValue = '';
        $lrcApproverValue = '';
        $statusRectangleCSSLRC = 'display: none;';
        $dateDisplayCSSITSO = 'display: block;';
        $dateDisplayCSSLRC = 'display: none;';

        $greenBtnValue = 'Approve';   
        $currentFunctionForApproveBtn = '';
        $currentFunctionForRejectBtn = ''; 
        $btnContainerStatus = $btnContainerDefault;
        $getStatusGreenBtn = $approveBtnStyle . 'cursor: default;';
        $getStatusRedBtn = $rejectBtnDefault . 'cursor: default;';

    } else if ($itsoStatus == 'approved' && $lrcStatus == 'pending'){
        $borderLRC = $borderGoldenRod;
        $imgStatusLRC = $pendingImageSrc;
        $statusRectangleCSSLRC = $pendingCSS;

        $imgStatusITSO = $approvedImageSrc;
        $itsoApproverValue = 'Mr. Peter Magcaling';
        $itsoValue = "Information - Technology System Office";
        $statusRectangleCSSITSO = $approvedCSS;

        $btnContainerStatus = $btnContainerDefault;
        $getStatusGreenBtn = $approveBtnStyle;
        $getStatusRedBtn = $rejectBtnDefault;
        $greenBtnValue = 'Approve';
        $currentFunctionForApproveBtn = $functionForApproveBtnLRC;
        $currentFunctionForRejectBtn = $functionForRejectBtn;
   
    } else if ($itsoStatus == 'approved' && $lrcStatus == 'approved'){
        $borderLRC = $borderGreen;
        $imgStatusLRC = $approvedImageSrc;
        $statusRectangleCSSLRC = $approvedCSS;

        $imgStatusITSO = $approvedImageSrc;
        $itsoApproverValue = 'Mr. Peter Magcaling';
        $itsoValue = "Information - Technology System Office";
        $statusRectangleCSSITSO = $approvedCSS;     
        $btnContainerStatus = 'display: none;';   
    }



}

//hm SIDE |-----lrc gagawing hm--itso gagawing lrc--------------------------------------------------------------------------------->
//----------V


if($valueOfEmail == 'hm@nu-fairview.edu.ph'){
    if ($fmoStatus == 'approved') {
        $imgStatusFMO = $approvedImageSrc;
        $currentStatusImgFMO = $approvedImageSrc;
        $statusRectangleCSSFMO = $approvedCSS;

        $fmoValue = "Facility Management Office";
        $fmoApproverValue = "Engr. Sarah Libron";
        $dateDisplayCSSFMO = '';
          
        } else if($fmoStatus == 'pending') {
        $imgStatusFMO = $pendingImageSrc;
        $currentStatusImgFMO = $pendingImageSrc;
        $statusRectangleCSSFMO = $pendingCSS;

        $fmoValue = "Facility - Management Office";
        $fmoApproverValue = "Engr. Sarah Libron";
        $dateDisplayCSSFMO = '';
        }
    $displayDetailsHM = $displayDetails;
    $displayDetailsLRC = $hideDetails;
    $displayDetailsITSO = $hideDetails;
    $displayDetailsFMO = $hideDetails;

    $borderFMO = '';
    $borderLRC = '';
    $borderITSO = '';
    $visibleNoneITSO = '';
    $visibleNoneHM = '';
    $itsoApproverValue = 'Mr. Peter Magcaling';
    $itsoValue = "Information - Technology System Office";

    $visibleNoneLRC = '';
    $lrcValue = "Learning Resource Center";
    $lrcApproverValue = "Ms. Sandra Narciso";

    if($itsoStatus == 'approved'){
        $imgStatusITSO = $approvedImageSrc;
        $statusRectangleCSSITSO = $approvedCSS;

    } else if ($itsoStatus == 'pending'){
        $imgStatusITSO = $pendingImageSrc;
        $statusRectangleCSSITSO = $pendingCSS;
    }


    if($lrcStatus == 'none' && $itsoStatus != 'none'){
        if($itsoStatus == 'pending'){
            $borderHM = $borderGray;
            $imgStatusHM = $grayPic;
            $borderHM = $borderGray;
            $hmValue = '';
            $hmApproverValue = '';
            $statusRectangleCSSHM = 'display: none;';
            $dateDisplayCSSHM = 'display: none;';
    
            $greenBtnValue = 'Approve';   
            $currentFunctionForApproveBtn = '';
            $currentFunctionForRejectBtn = ''; 
            $btnContainerStatus = $btnContainerDefault;
            $getStatusGreenBtn = $approveBtnStyle . 'cursor: default;';
            $getStatusRedBtn = $rejectBtnDefault . 'cursor: default;';
    
    
        } else if ($itsoStatus == 'approved' && $hmStatus == 'pending'){
            $borderHM = $borderGoldenRod;
            $imgStatusHM = $pendingImageSrc;
            $statusRectangleCSSHM = $pendingCSS;
            $hmValue = "Hotel Management";
            $hmApproverValue = "Mr. Errol Martin";
    
            $greenBtnValue = 'Approve';   
            $currentFunctionForApproveBtn = $functionForApproveBtnHM;
            $currentFunctionForRejectBtn = $functionForRejectBtn; 
            $btnContainerStatus = $btnContainerDefault;
            $getStatusGreenBtn = $approveBtnStyle . 'cursor: pointer;';
            $getStatusRedBtn = $rejectBtnDefault . 'cursor: pointer;';
    
       
        } else if ($itsoStatus == 'approved' && $hmStatus == 'approved'){
            $borderHM = $borderGreen;
            $statusRectangleCSSHM = $approvedCSS;
            $dateDisplayCSSHM = '';
    
            $hmValue = "Hotel Management";
            $hmApproverValue = "Mr. Errol Martin";
    
            $btnContainerStatus = 'display: none;';
            $greenBtnValue = 'Done';   
            $currentFunctionForApproveBtn = '';
            $currentFunctionForRejectBtn = '';
            $imgStatusHM = $approvedImageSrc;
            
        
        }
        
       
    }

    else if($lrcStatus == 'none' && $itsoStatus == 'none' && $fmoStatus != 'none'){
        if($fmoStatus == 'pending'){
            $borderHM = $borderGray;
            $imgStatusHM = $grayPic;
            $borderHM = $borderGray;
            $hmValue = '';
            $hmApproverValue = '';
            $statusRectangleCSSHM = 'display: none;';
            $dateDisplayCSSHM = 'display: none;';
    
            $greenBtnValue = 'Approve';   
            $currentFunctionForApproveBtn = '';
            $currentFunctionForRejectBtn = ''; 
            $btnContainerStatus = $btnContainerDefault;
            $getStatusGreenBtn = $approveBtnStyle . 'cursor: default;';
            $getStatusRedBtn = $rejectBtnDefault . 'cursor: default;';
    
    
        } else if ($fmoStatus == 'approved' && $hmStatus == 'pending'){
            $borderHM = $borderGoldenRod;
            $imgStatusHM = $pendingImageSrc;
            $statusRectangleCSSHM = $pendingCSS;
            $hmValue = "Hotel Management";
            $hmApproverValue = "Mr. Errol Martin";
    
            $greenBtnValue = 'Approve';   
            $currentFunctionForApproveBtn = $functionForApproveBtnHM;
            $currentFunctionForRejectBtn = $functionForRejectBtn; 
            $btnContainerStatus = $btnContainerDefault;
            $getStatusGreenBtn = $approveBtnStyle . 'cursor: pointer;';
            $getStatusRedBtn = $rejectBtnDefault . 'cursor: pointer;';
    
       
        } else if ($fmoStatus == 'approved' && $hmStatus == 'approved'){
            $borderHM = $borderGreen;
            $statusRectangleCSSHM = $approvedCSS;
            $dateDisplayCSSHM = '';
    
            $hmValue = "Hotel Management";
            $hmApproverValue = "Mr. Errol Martin";
    
            $btnContainerStatus = 'display: none;';
            $greenBtnValue = 'Done';   
            $currentFunctionForApproveBtn = '';
            $currentFunctionForRejectBtn = '';
            $imgStatusHM = $approvedImageSrc;
            
        
        }
        
       
    }

    else if($lrcStatus == 'none' && $itsoStatus == 'none' && $fmoStatus == 'none'){
        if($sdaoStatus == 'pending'){
            $borderHM = $borderGray;
            $imgStatusHM = $grayPic;
            $borderHM = $borderGray;
            $hmValue = '';
            $hmApproverValue = '';
            $statusRectangleCSSHM = 'display: none;';
            $dateDisplayCSSHM = 'display: none;';
    
            $greenBtnValue = 'Approve';   
            $currentFunctionForApproveBtn = '';
            $currentFunctionForRejectBtn = ''; 
            $btnContainerStatus = $btnContainerDefault;
            $getStatusGreenBtn = $approveBtnStyle . 'cursor: default;';
            $getStatusRedBtn = $rejectBtnDefault . 'cursor: default;';
    
    
        } else if ($sdaoStatus == 'approved' && $hmStatus == 'pending'){
            $borderHM = $borderGoldenRod;
            $imgStatusHM = $pendingImageSrc;
            $statusRectangleCSSHM = $pendingCSS;
            $hmValue = "Hotel Management";
            $hmApproverValue = "Mr. Errol Martin";
    
            $greenBtnValue = 'Approve';   
            $currentFunctionForApproveBtn = $functionForApproveBtnHM;
            $currentFunctionForRejectBtn = $functionForRejectBtn; 
            $btnContainerStatus = $btnContainerDefault;
            $getStatusGreenBtn = $approveBtnStyle . 'cursor: pointer;';
            $getStatusRedBtn = $rejectBtnDefault . 'cursor: pointer;';
    
       
        } else if ($sdaoStatus == 'approved' && $hmStatus == 'approved'){
            $borderHM = $borderGreen;
            $statusRectangleCSSHM = $approvedCSS;
            $dateDisplayCSSHM = '';
    
            $hmValue = "Hotel Management";
            $hmApproverValue = "Mr. Errol Martin";
    
            $btnContainerStatus = 'display: none;';
            $greenBtnValue = 'Done';   
            $currentFunctionForApproveBtn = '';
            $currentFunctionForRejectBtn = '';
            $imgStatusHM = $approvedImageSrc;
            
        
        }
        
       
    }
    

    else if($lrcStatus == 'pending'){
        $imgStatusLRC = $pendingImageSrc;
        $statusRectangleCSSLRC = $pendingCSS;


        $borderHM = $borderGray;
        
        $imgStatusHM = $grayPic;
        $borderHM = $borderGray;
        $hmValue = '';
        $hmApproverValue = '';
        $statusRectangleCSSHM = 'display: none;';
        $dateDisplayCSSHM = 'display: none;';

        $greenBtnValue = 'Approve';   
        $currentFunctionForApproveBtn = '';
        $currentFunctionForRejectBtn = ''; 
        $btnContainerStatus = $btnContainerDefault;
        $getStatusGreenBtn = $approveBtnStyle . 'cursor: default;';
        $getStatusRedBtn = $rejectBtnDefault . 'cursor: default;';


    } else if ($lrcStatus == 'approved' && $hmStatus == 'pending'){
        $borderHM = $borderGoldenRod;
        $imgStatusHM = $pendingImageSrc;
        $statusRectangleCSSHM = $pendingCSS;
        $hmValue = "Hotel Management";
        $hmApproverValue = "Mr. Errol Martin";

        $greenBtnValue = 'Approve';   
        $currentFunctionForApproveBtn = $functionForApproveBtnHM;
        $currentFunctionForRejectBtn = $functionForRejectBtn; 
        $btnContainerStatus = $btnContainerDefault;
        $getStatusGreenBtn = $approveBtnStyle . 'cursor: pointer;';
        $getStatusRedBtn = $rejectBtnDefault . 'cursor: pointer;';

        $imgStatusLRC = $approvedImageSrc;
        $statusRectangleCSSLRC = $approvedCSS;

   
    } else if ($lrcStatus == 'approved' && $hmStatus == 'approved'){
        $borderHM = $borderGreen;
        $statusRectangleCSSHM = $approvedCSS;
        $dateDisplayCSSHM = '';

        $hmValue = "Hotel Management";
        $hmApproverValue = "Mr. Errol Martin";

        $btnContainerStatus = $btnContainerItemsCentered;
        $greenBtnValue = 'Done';   
        $currentFunctionForApproveBtn = '';
        $currentFunctionForRejectBtn = '';

        $imgStatusLRC = $approvedImageSrc;
        $statusRectangleCSSLRC = $approvedCSS;

        $imgStatusHM = $approvedImageSrc;
        
    
    }

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
        <div class="circle"><img src="<?php echo $imgStatusSDAO; ?>" style="<?php echo $circleIconSize?>" draggable="false"></div>
        <div style="<?php echo $grayline?>"></div>

    </div>
    <div class="circleDetails" style="word-wrap:break-word;">
        <p style="font-weight: bold; font-size: 10px; margin-top: 4px;">Student Development Activities Office</p>
        <p style="font-size: 10px; margin-top: 4px;">Ernilson C. Caindoy</p>
        <p id="pendingDetailSDAO" style="<?php echo $cssStatusSDAO; ?>"><?php echo $sdaoStatusUC ?></p>
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

<div id="FMO" class="statusDiv" style="<?php echo $hideStatusDivFMO?>">
<div class="circleContainer">
        <div class="circle"><img src="<?php echo $imgStatusFMO?>" id="pendingToApproveImg"style="<?php echo $circleIconSize . "" . $borderFMO?>" draggable="false"></div>
        <div style="<?php echo $grayline?>"></div>

    </div>
    <div class="circleDetails" style="word-wrap:break-word;">
        <p style="font-weight: bold; font-size: 10px; margin-top: 4px;"><?php echo $fmoValue?></p>
        <p style="font-size: 10px; margin-top: 4px;"><?php echo $fmoApproverValue ?></p>
        <p id="pendingDetailFMO" style="<?php echo $statusRectangleCSSFMO ?>"><?php echo $fmoStatusUC ?></p>
        <p style="font-size: 10px; margin-top: 4px; <?php echo $dateDisplayCSSFMO ?>"><?php 
        if($dateResponseFMO == '0000-00-00 00:00:00'){
            echo "00-00-00 00:00";
        }else{
            echo date("y-m-d h:i A", strtotime($dateResponseFMO));
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

<div id="LRC" class="statusDiv" style="<?php echo $hideStatusDivLRC?>">
<div class="circleContainer">
        <div class="circle"><img src="<?php echo $imgStatusLRC?>" id="pendingToApproveImg3"style="<?php echo $circleIconSize . "" . $borderLRC?>" draggable="false"></div>
        <div style="<?php echo $grayline?>"></div>

    </div>
    <div class="circleDetails" style="word-wrap:break-word; <?php echo $visibleNoneLRC?>">
        <p style="font-weight: bold; font-size: 10px; margin-top: 4px;"><?php echo $lrcValue?></p>
        <p style="font-size: 10px; margin-top: 4px;"><?php echo $lrcApproverValue ?></p>
        <p id="pendingDetailLRC" style="<?php echo $statusRectangleCSSLRC ?>"><?php echo $lrcStatusUC ?></p>
        <p style="font-size: 10px; margin-top: 4px; <?php echo $dateDisplayCSSLRC ?>"><?php 
        if($dateResponseLRC == '0000-00-00 00:00:00'){
            echo "00-00-00 00:00";
        }else{
            echo date("y-m-d h:i A", strtotime($dateResponseLRC));
         } ?></p>
        <style>
          
        </style>
    </div>
</div>

<!--___________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________-->

<div id="HM" class="statusDiv" style="<?php echo $hideStatusDivHM?>">
<div class="circleContainer">
        <div class="circle"><img src="<?php echo $imgStatusHM?>" id="pendingToApproveImg4"style="<?php echo $circleIconSize . "" . $borderHM?>" draggable="false"></div>
        <div style="<?php echo $grayline?>"></div>

    </div>
    <div class="circleDetails" style="word-wrap:break-word; <?php echo $visibleNoneHM?>">
        <p style="font-weight: bold; font-size: 10px; margin-top: 4px;"><?php echo $hmValue?></p>
        <p style="font-size: 10px; margin-top: 4px;"><?php echo $hmApproverValue ?></p>
        <p id="pendingDetailHM" style="<?php echo $statusRectangleCSSHM ?>"><?php echo $hmStatusUC ?></p>
        <p style="font-size: 10px; margin-top: 4px; <?php echo $dateDisplayCSSHM ?>"><?php 
        if($dateResponseHM == '0000-00-00 00:00:00'){
            echo "00-00-00 00:00";
        }else{
            echo date("y-m-d h:i A", strtotime($dateResponseHM));
         } ?></p>
 
    </div>
</div>

<!--___________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________-->


<?php 
$numberOfStatusDivs = 4;
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
<!-- ACTIVITY DETAILS FOR FMO----------------------------------------------------------------------------------------> 
                    <div class="leftActivityDetails" style="<?php echo $displayDetailsFMO?>;">
                        <div class="firstLine">Event Details</div>

                        <div class="inputLine"><div class="asking">Venue<div>:</div></div> 
                        <div class="nameDisplay"><?php echo (!empty($facilities_requirements) && $facilities_requirements !== 'none') ? $facilities_requirements . '<br>' : '';echo (!empty($learning_resource_center) && $learning_resource_center !== 'none') ? $learning_resource_center . '<br>' : '';
                        echo (!empty($hotel_management) && $hotel_management !== 'none') ? $hotel_management : '';?></div>
                        </div>

                        <div class="inputLine"><div class="asking">Date<div>:</div></div>
                        <div class="orgDisplay"><?php echo date("Y-m-d", strtotime($actDateTime))?></div>
                        </div>
                        
                        <div class="inputLine"><div class="asking">Start Time<div>:</div></div>
                        <div class="themeDisplay"><?php echo date("h:i A", strtotime($actDateTime))?></div>
                        </div>

                        <div class="inputLine"><div class="asking">Start Time<div>:</div></div>
                        <div class="themeDisplay"><?php echo date("h:i A", strtotime($actEndDateTime))?></div>
                        </div>

                        <div class="inputLine"><div class="asking">No. of Participants <div>:</div></div>
                        <div class="participantsDisplay"><?php echo $row['target_participants']?></div>
                        </div>
                    </div>
<!---------------------------------------------------------------------------------------------------------------------------->

<!-- ACTIVITY DETAILS FOR ITSO------------------------------------------------------------------------------------------------> 
                    <div class="leftActivityDetails" style="<?php echo $displayDetailsITSO ?>;">
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
                                    <button onclick="hideRejectRequestFmo()" style="cursor: pointer;" class="overlayCancelBtn">Cancel</button>
                                    <button onclick="proceedRejectFunction('<?php echo $org; ?>')" style="cursor: pointer;" class="overlayRejectBtn">Reject</button>

                                    </div>
                                 
                                </div>
                            </div>

                        </div>
                     
                        <script>
         function approveRequestFmo(org) {
            $.ajax({
                type: 'POST',
                url: 'update_status_FMO.php',
                data: { org: org },
                success: function (response) {
                    v
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