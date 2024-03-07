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

        $sqlFMO = "SELECT facilities_requirements, learning_resource_center, hotel_management FROM sarf.student_activity_requests where user_id = '$userId'";
        $resultsqlFMO = $conn->query($sqlFMO);

       $statusOfSdao = "SELECT sdao from status_of_requests WHERE user_id = $userId";
       $resultStatusOfSdao = $conn->query($statusOfSdao);
       $rowStatusOfSdao = $resultStatusOfSdao->fetch_assoc();
       $sdaoStatus = $rowStatusOfSdao['sdao'];
       $sdaoStatusUC = strtoupper($sdaoStatus);

       $statusOfOaPcSdaoFmo = "SELECT org_adviser, prog_chair, sdao, fmo, itso, lrc, hm, asd, sad, ed, cd from status_of_requests WHERE user_id = $userId";
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

       $asdStatus = $rowStatusOfOaPcSdaoFmo['asd'];
       $asdStatusUC = strtoupper($asdStatus);

       $sadStatus = $rowStatusOfOaPcSdaoFmo['sad'];
       $sadStatusUC = strtoupper($sadStatus);

       $edStatus = $rowStatusOfOaPcSdaoFmo['ed'];
       $edStatusUC = strtoupper($edStatus);

       $cdStatus = $rowStatusOfOaPcSdaoFmo['cd'];
       $cdStatusUC = strtoupper($cdStatus);

       $hideStatusDiv = 'display: none;';

       if($fmoStatus == 'none'){
        $hideStatusDivFMO = $hideStatusDiv;
       } if ($itsoStatus == 'none'){
        $hideStatusDivITSO = $hideStatusDiv;
       } if ($lrcStatus == 'none'){
        $hideStatusDivLRC = $hideStatusDiv;        
       } if ($hmStatus == 'none'){
        $hideStatusDivHM = $hideStatusDiv;
       } if ($asdStatus == 'none'){
        $hideStatusDivASD = $hideStatusDiv;
       } if ($sadStatus == 'none'){
        $hideStatusDivSAD = $hideStatusDiv;
       } if ($edStatus == 'none'){
        $hideStatusDivED = $hideStatusDiv;
       } if ($cdStatus == 'none'){
        $hideStatusDivCD = $hideStatusDiv;
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

       //$borderGreen = 'border: solid 1px; color: green; padding-top: 1px;';
       //$borderGoldenRod = 'border: solid 1px; color: goldenrod; padding: 2px;';
       //$borderGray =  'border: solid 1px; color: gray; padding: 2px;';

       $borderGreen = 'border: solid 1px; color: green; margin-bottom: 3px;';
       $borderGoldenRod = 'border: solid 1px; color: goldenrod; padding: 1px; margin-bottom: 1px;';
       $borderGray =  'border: solid 1px; color: gray; padding: 2px;';

       $btnContainerDefault = 'display: flex; align-items:center; width: 250px; height: 50px; justify-content: space-between; margin-top: 20px;';
       $btnContainerItemsCentered = 'display: flex; align-items:center; width: 250px; height: 50px; justify-content: center; margin-top: 20px;';

       $btnContainerStatus = $btnContainerDefault;

       $rejectBtnRemoved = 'display: none';
       $rejectBtnDefault = 'width: 110px; height: 45px; border-radius: 28px; background-color: rgba(247, 88, 88, 1); display: flex; justify-content: center; align-items: center; font-size: 16px; cursor: pointer;';

       $approveBtnStyle = 'width: 110px; height: 45px; border-radius: 28px; background-color: rgba(153, 217, 71, 1); display: flex; justify-content: center; align-items: center; font-size: 16px; cursor: pointer;';
       $doneBtnStyle = 'width: 200px; height: 45px; border-radius: 28px; background-color: rgba(153, 217, 71, 1); display: flex; justify-content: center; align-items: center; font-size: 16px; cursor: default;';

       $getStatusGreenBtn = $approveBtnStyle;
       $getStatusRedBtn = $rejectBtnDefault;

       
       $functionForApproveBtnASD = "approveRequestASD('" . $org . "')";
       $functionForApproveBtnSAD = "approveRequestSAD('" . $org . "')";
       $functionForApproveBtnED = "approveRequestED('" . $org . "')";
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

        if ($cdStatus == 'approved') {
            $currentStatusImgCD = $approvedImageSrc;
            $currentCSSCD = $approvedCSS;
        } else if($cdStatus == 'pending') {
            $currentStatusImgCD = $pendingImageSrc;
            $currentCSSCD = $pendingCSS;
        }

        if($pcStatus == 'pending'){
            $imgStatusPC = $pendingImageSrc;
            $cssStatusPC = $pendingCSS;
        }
        else if($pcStatus == 'approved'){
            $cssStatusPC = $approvedCSS;
            $imgStatusPC = $approvedImageSrc;
        }
        
        if($sdaoStatus == 'pending'){
            $imgStatusSDAO = $pendingImageSrc;
            $cssStatusSDAO = $pendingCSS;
        }
        else if($sdaoStatus == 'approved'){
            $cssStatusSDAO = $approvedCSS;
            $imgStatusSDAO = $approvedImageSrc;
        }

        if($fmoStatus == 'pending'){
            $imgStatusFMO = $pendingImageSrc;
            $cssStatusFMO = $pendingCSS;
        }
        else if($fmoStatus == 'approved'){
            $cssStatusFMO = $approvedCSS;
            $imgStatusFMO = $approvedImageSrc;
        }

        if($itsoStatus == 'pending'){
            $imgStatusITSO = $pendingImageSrc;
            $cssStatusITSO = $pendingCSS;
        }
        else if($itsoStatus == 'approved'){
            $cssStatusITSO = $approvedCSS;
            $imgStatusITSO = $approvedImageSrc;
        }

        if($lrcStatus == 'pending'){
            $imgStatusLRC = $pendingImageSrc;
            $cssStatusLRC = $pendingCSS;
        }
        else if($lrcStatus == 'approved'){
            $cssStatusLRC = $approvedCSS;
            $imgStatusLRC = $approvedImageSrc;
        }

        if($hmStatus == 'pending'){
            $imgStatusHM = $pendingImageSrc;
            $cssStatusHM = $pendingCSS;
        }
        else if($hmStatus == 'approved'){
            $cssStatusHM = $approvedCSS;
            $imgStatusHM = $approvedImageSrc;
        }



//ASD DIRECTOR SIDE_________________________________________________________
        if($valueOfEmail == 'asdirector@nu-fairview.edu.ph'){
            if($hmStatus == 'none' && $lrcStatus != 'none'){
                

                if($lrcStatus == 'pending'){
                    $imgStatusASD = $grayPic;
                    $cssStatusASD = 'display: none;';
                    $borderASD = $borderGray;
                    $asdValue = '';
                    $asdApproverValue = '';
                    $dateDisplayASD = 'display: none;';
                    $getStatusGreenBtn = $approveBtnStyle . 'cursor: default;';
                    $getStatusRedBtn = $rejectBtnDefault . 'cursor: default;';
                    

                }
                else if ($lrcStatus == 'approved' && $asdStatus == 'pending'){
                $imgStatusASD = $pendingImageSrc;
                $cssStatusASD = $pendingCSS;
                $borderASD = $borderGoldenRod;
                $asdValue = 'Academic Service Director';
                $asdApproverValue = 'Jhun G. Himoldang';

                $currentFunctionForApproveBtn = $functionForApproveBtnASD;
                $currentFunctionForRejectBtn = $functionForRejectBtn;

                }

                else if ($lrcStatus == 'approved' && $asdStatus == 'approved'){
                    $cssStatusASD = $approvedCSS;
                    $imgStatusASD = $approvedImageSrc;
                    $borderASD = $borderGreen;
                    $asdValue = 'Academic Service Director';
                    $asdApproverValue = 'Jhun G. Himoldang';
    
                    $btnContainerStatus = 'display: none;';
                    
                }

            }

            else if($hmStatus == 'none' && $lrcStatus == 'none' && $itsoStatus != 'none'){

                if($itsoStatus == 'pending'){
                $imgStatusASD = $grayPic;
                $cssStatusASD = 'display: none;';
                $borderASD = $borderGray;
                $asdValue = '';
                $asdApproverValue = '';
                $dateDisplayASD = 'display: none;';
                $getStatusGreenBtn = $approveBtnStyle . 'cursor: default;';
                $getStatusRedBtn = $rejectBtnDefault . 'cursor: default;';
                }

                else if ($itsoStatus == 'approved' && $asdStatus == 'pending'){
                    $imgStatusASD = $pendingImageSrc;
                    $cssStatusASD = $pendingCSS;
                    $borderASD = $borderGoldenRod;
                    $asdValue = 'Academic Service Director';
                    $asdApproverValue = 'Jhun G. Himoldang';
    
                    $currentFunctionForApproveBtn = $functionForApproveBtnASD;
                    $currentFunctionForRejectBtn = $functionForRejectBtn;
    
                    }
    
                    else if ($itsoStatus == 'approved' && $asdStatus == 'approved'){
                        $cssStatusASD = $approvedCSS;
                        $imgStatusASD = $approvedImageSrc;
                        $borderASD = $borderGreen;
                        $asdValue = 'Academic Service Director';
                        $asdApproverValue = 'Jhun G. Himoldang';
        
                        $btnContainerStatus = 'display: none;';
                        
                    }

            }

            else if($hmStatus == 'none' && $lrcStatus == 'none' && $itsoStatus == 'none' && $fmoStatus != 'none'){

                if($fmoStatus == 'pending'){
                $imgStatusASD = $grayPic;
                $cssStatusASD = 'display: none;';
                $borderASD = $borderGray;
                $asdValue = '';
                $asdApproverValue = '';
                $dateDisplayASD = 'display: none;';
                $getStatusGreenBtn = $approveBtnStyle . 'cursor: default;';
                $getStatusRedBtn = $rejectBtnDefault . 'cursor: default;';
                }

                else if ($fmoStatus == 'approved' && $asdStatus == 'pending'){
                    $imgStatusASD = $pendingImageSrc;
                    $cssStatusASD = $pendingCSS;
                    $borderASD = $borderGoldenRod;
                    $asdValue = 'Academic Service Director';
                    $asdApproverValue = 'Jhun G. Himoldang';
    
                    $currentFunctionForApproveBtn = $functionForApproveBtnASD;
                    $currentFunctionForRejectBtn = $functionForRejectBtn;
    
                    }
    
                    else if ($fmoStatus == 'approved' && $asdStatus == 'approved'){
                        $cssStatusASD = $approvedCSS;
                        $imgStatusASD = $approvedImageSrc;
                        $borderASD = $borderGreen;
                        $asdValue = 'Academic Service Director';
                        $asdApproverValue = 'Jhun G. Himoldang';
        
                        $btnContainerStatus = 'display: none;';
                        
                    }

                

            }

            else if($hmStatus == 'none' && $lrcStatus == 'none' && $itsoStatus == 'none' && $fmoStatus == 'none'){
                $imgStatusASD = $grayPic;
                $cssStatusASD = 'display: none;';
                $borderASD = $borderGray;
                $asdValue = '';
                $asdApproverValue = '';
                $dateDisplayASD = 'display: none;';

            }



            else if($hmStatus == 'pending'){
                $imgStatusASD = $grayPic;
                $cssStatusASD = 'display: none;';
                $borderASD = $borderGray;
                $asdValue = '';
                $asdApproverValue = '';
                $dateDisplayASD = 'display: none;';

                $currentFunctionForApproveBtn = '';
                $currentFunctionForRejectBtn = '';

            }
            else if($hmStatus == 'approved' && $asdStatus == 'pending'){
                $imgStatusASD = $pendingImageSrc;
                $cssStatusASD = $pendingCSS;
                $borderASD = $borderGoldenRod;
                $asdValue = 'Academic Service Director';
                $asdApproverValue = 'Jhun G. Himoldang';

                $currentFunctionForApproveBtn = $functionForApproveBtnASD;
                $currentFunctionForRejectBtn = $functionForRejectBtn;
                

            }
            else if($hmStatus == 'approved' && $asdStatus == 'approved'){
                $cssStatusASD = $approvedCSS;
                $imgStatusASD = $approvedImageSrc;
                $borderASD = $borderGreen;
                $asdValue = 'Academic Service Director';
                $asdApproverValue = 'Jhun G. Himoldang';

                $btnContainerStatus = 'display: none;';

            }


        $imgStatusSAD = $grayPic;
        $cssStatusSAD = 'display: none;';
        $sadValue = '';
        $sadApproverValue = '';
        $dateDisplaySAD = 'display: none;';

        $imgStatusED = $grayPic;
        $cssStatusED = 'display: none;';
        $edValue = '';
        $edApproverValue = '';
        $dateDisplayED = 'display: none;';


        $imgStatusCD = $grayPic;
        $cssStatusCD = 'display: none;';
        $cdValue = '';
        $cdApproverValue = '';
        $dateDisplayCD = 'display: none;';

    }
// ASD DIRECTOR SIDE ___________________________________________________-


//SAD DIRECTOR SIDE_________________________________________________________

          if($valueOfEmail == 'sadirector@nu-fairview.edu.ph'){
            if($asdStatus == 'pending'){
                $imgStatusSAD = $grayPic;
                $cssStatusSAD = 'display: none;';
                $borderSAD = $borderGray;
                $sadValue = '';
                $sadApproverValue = '';
                $dateDisplaySAD = 'display: none;';
                $getStatusGreenBtn = $approveBtnStyle . 'cursor: default;';
                $getStatusRedBtn = $rejectBtnDefault . 'cursor: default;';

            }
            else if ($asdStatus == 'approved' && $sadStatus == 'pending'){
                $imgStatusSAD = $pendingImageSrc;
                $cssStatusSAD = $pendingCSS;
                $borderSAD = $borderGoldenRod;
                $sadValue = 'Senior Academic Director';
                $sadApproverValue = 'Ma. Donna B Lalusin';

                $currentFunctionForApproveBtn = $functionForApproveBtnSAD;
                $currentFunctionForRejectBtn = $functionForRejectBtn;

                }

                else if ($asdStatus == 'approved' && $sadStatus == 'approved'){
                    $cssStatusSAD = $approvedCSS;
                    $imgStatusSAD = $approvedImageSrc;
                    $borderSAD = $borderGreen;
                    $sadValue = 'Senior Academic Director';
                    $sadApproverValue = 'Ma. Donna B Lalusin';
    
                    $btnContainerStatus = 'display: none;';
                    
                }



            if($asdStatus == 'pending'){
                $imgStatusASD = $pendingImageSrc;
                $cssStatusASD = $pendingCSS;
                $asdValue = 'Academic Service Director';
                $asdApproverValue = 'Jhun G. Himoldang';

            } else if($asdStatus == 'approved'){
                $imgStatusASD = $approvedImageSrc;
                $cssStatusASD = $approvedCSS;
                $asdValue = 'Academic Service Director';
                $asdApproverValue = 'Jhun G. Himoldang';

            }



            $imgStatusED = $grayPic;
            $cssStatusED = 'display: none;';
            $edValue = '';
            $edApproverValue = '';
            $dateDisplayED = 'display: none;';
    
            $imgStatusCD = $grayPic;
            $cssStatusCD = 'display: none;';
            $cdValue = '';
            $cdApproverValue = '';
            $dateDisplayCD = 'display: none;';




          }

//SAD DIRECTOR SIDE_________________________________________________________

//ED DIRECTOR SIDE_________________________________________________________

if($valueOfEmail == 'edirector@nu-fairview.edu.ph'){

  
    $dateDisplayCD = 'display: none;';

    if($sadStatus == 'none'){
        if($asdStatus == 'pending'){
            $imgStatusED = $grayPic;
            $cssStatusED = 'display: none;';
            $borderED = $borderGray;
            $edValue = '';
            $edApproverValue = '';
            $dateDisplayED = 'display: none;';
            $getStatusGreenBtn = $approveBtnStyle . 'cursor: default;';
            $getStatusRedBtn = $rejectBtnDefault . 'cursor: default;';

        }
        else if ($asdStatus == 'approved' && $edStatus == 'pending'){
            $imgStatusED = $pendingImageSrc;
            $cssStatusED = $pendingCSS;
            $borderED = $borderGoldenRod;
            $edValue = 'Executive Director';
            $edApproverValue = 'Ricky R. Lawas';

            $currentFunctionForApproveBtn = $functionForApproveBtnED;
            $currentFunctionForRejectBtn = $functionForRejectBtn;

            }

            else if ($asdStatus == 'approved' && $edStatus == 'approved'){
                $cssStatusED = $approvedCSS;
                $imgStatusED = $approvedImageSrc;
                $borderED = $borderGreen;
                $edValue = 'Executive Director';
                $edApproverValue = 'Ricky R. Lawas';

                $btnContainerStatus = 'display: none;';
                
            }

    }





    else if($sadStatus == 'pending'){
        $imgStatusED = $grayPic;
        $cssStatusED = 'display: none;';
        $borderED = $borderGray;
        $edValue = '';
        $edApproverValue = '';
        $dateDisplayED = 'display: none;';

        $currentFunctionForApproveBtn = '';
        $currentFunctionForRejectBtn = '';
        $getStatusGreenBtn = $approveBtnStyle . 'cursor: default;';
        $getStatusRedBtn = $rejectBtnDefault . 'cursor: default;';

    }
    else if($sadStatus == 'approved' && $edStatus == 'pending'){
        $imgStatusED = $pendingImageSrc;
        $cssStatusED = $pendingCSS;
        $borderED = $borderGoldenRod;
        $edValue = 'Executive Director';
        $edApproverValue = 'Ricky R. Lawas';

        $currentFunctionForApproveBtn = $functionForApproveBtnED;
        $currentFunctionForRejectBtn = $functionForRejectBtn;
        

    }
    else if($sadStatus == 'approved' && $edStatus == 'approved'){
        $cssStatusED = $approvedCSS;
        $imgStatusED = $approvedImageSrc;
        $borderED = $borderGreen;
        $edValue = 'Executive Director';
        $edApproverValue = 'Ricky R. Lawas';

        $btnContainerStatus = 'display: none;';

    }


    if($asdStatus == 'pending'){
        $imgStatusASD = $pendingImageSrc;
        $cssStatusASD = $pendingCSS;
        $asdValue = 'Academic Service Director';
        $asdApproverValue = 'Jhun G. Himoldang';

    } else if($asdStatus == 'approved'){
        $imgStatusASD = $approvedImageSrc;
        $cssStatusASD = $approvedCSS;
        $asdValue = 'Academic Service Director';
        $asdApproverValue = 'Jhun G. Himoldang';

    }

    if($sadStatus == 'pending'){
        $imgStatusSAD = $pendingImageSrc;
        $cssStatusSAD = $pendingCSS;
        $sadValue = 'Senior Academic Director';
        $sadApproverValue = 'Ma. Donna B. Lalusin';

    } else if($sadStatus == 'approved'){
        $imgStatusSAD = $approvedImageSrc;
        $cssStatusSAD = $approvedCSS;
        $sadValue = 'Senior Academic Director';
        $sadApproverValue = 'Ma. Donna B. Lalusin';

    }





    
}

//ED DIRECTOR SIDE_________________________________________________________


        






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

        $dateNeededFormat = new DateTime($dateNeeded);
        

        $conn->close();

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/dirapprovalprogress.css">
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

                    <div id="CD" class="statusDiv">
                    <div class="circleContainer">
                            <div class="circle"><img src="<?php echo $currentStatusImgCD ?>" style="<?php echo $circleIconSize ?>" draggable="false"></div>
                            <div class="statusLine"></div>

                        </div>
                          <div class="circleDetails" style="word-wrap:break-word;">
                            <p style="font-weight: bold; font-size: 10px; margin-top: 4px;">College Dean</p>
                            <p style="font-size: 10px; margin-top: 4px;"><?php echo $CD?></p>
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
        <p style="font-weight: bold; font-size: 10px; margin-top: 4px;">Student Development Activity Office</p>
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
        <p style="font-weight: bold; font-size: 10px; margin-top: 4px;">Facilities Management Office</p>
        <p style="font-size: 10px; margin-top: 4px;">Engr. Sarah Libron</p>
        <p id="pendingDetailFMO" style="<?php echo $cssStatusFMO ?>"><?php echo $fmoStatusUC ?></p>
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
    <div class="circleDetails" style="word-wrap:break-word;">
        <p style="font-weight: bold; font-size: 10px; margin-top: 4px;">Information Technology System Office</p>
        <p style="font-size: 10px; margin-top: 4px;">Mr. Peter Magcaling</p>
        <p id="pendingDetailITSO" style="<?php echo $cssStatusITSO ?>"><?php echo $itsoStatusUC ?></p>
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
    <div class="circleDetails" style="word-wrap:break-word;">
        <p style="font-weight: bold; font-size: 10px; margin-top: 4px;">Learning Resource Center</p>
        <p style="font-size: 10px; margin-top: 4px;">Ms. Sandra Narciso</p>
        <p id="pendingDetailLRC" style="<?php echo $cssStatusLRC ?>"><?php echo $lrcStatusUC ?></p>
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
    <div class="circleDetails" style="word-wrap:break-word;">
        <p style="font-weight: bold; font-size: 10px; margin-top: 4px;">Hospitality Management</p>
        <p style="font-size: 10px; margin-top: 4px;">Mr. Errol Martin</p>
        <p id="pendingDetailHM" style="<?php echo $cssStatusHM ?>"><?php echo $hmStatusUC ?></p>
        <p style="font-size: 10px; margin-top: 4px; <?php echo $dateDisplayCSSHM ?>"><?php 
        if($dateResponseHM == '0000-00-00 00:00:00'){
            echo "00-00-00 00:00";
        }else{
            echo date("y-m-d h:i A", strtotime($dateResponseHM));
         } ?></p>
 
    </div>
</div>

<!--___________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________-->


<div id="ASD" class="statusDiv" style="<?php echo $hideStatusDivASD ?>">
<div class="circleContainer">
        <div class="circle"><img src="<?php echo $imgStatusASD?>" id="pendingToApproveImg5"style="<?php echo $circleIconSize . "" . $borderASD?>" draggable="false"></div>
        <div style="<?php echo $grayline?>"></div>

    </div>
    <div class="circleDetails" style="word-wrap:break-word;">
        <p style="font-weight: bold; font-size: 10px; margin-top: 4px;"><?php echo $asdValue ?></p>
        <p style="font-size: 10px; margin-top: 4px;"><?php echo $asdApproverValue ?></p>
        <p id="pendingDetailASD" style="<?php echo $cssStatusASD ?>"><?php echo $asdStatusUC ?></p>
        <p style="font-size: 10px; margin-top: 4px; <?php echo $dateDisplayASD ?>"><?php 
        if($dateResponseASD == '0000-00-00 00:00:00'){
            echo "00-00-00 00:00";
        }else{
            echo date("y-m-d h:i A", strtotime($dateResponseASD));
         } ?></p>
 
    </div>
</div>

<!--___________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________-->

<div id="SAD" class="statusDiv" style="<?php echo $hideStatusDivSAD ?>">
<div class="circleContainer">
        <div class="circle"><img src="<?php echo $imgStatusSAD ?>" id="pendingToApproveImg6"style="<?php echo $circleIconSize . "" . $borderSAD?>" draggable="false"></div>
        <div style="<?php echo $grayline?>"></div>

    </div>
    <div class="circleDetails" style="word-wrap:break-word;">
        <p style="font-weight: bold; font-size: 10px; margin-top: 4px;"><?php echo $sadValue ?></p>
        <p style="font-size: 10px; margin-top: 4px;"><?php echo $sadApproverValue ?></p>
        <p id="pendingDetailSAD" style="<?php echo $cssStatusSAD ?>"><?php echo $sadStatusUC ?></p>
        <p style="font-size: 10px; margin-top: 4px; <?php echo $dateDisplaySAD ?>"><?php 
        if($dateResponseSAD == '0000-00-00 00:00:00'){
            echo "00-00-00 00:00";
        }else{
            echo date("y-m-d h:i A", strtotime($dateResponseSAD));
         } ?></p>
 
    </div>
</div>

<!--___________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________-->

<div id="ED" class="statusDiv" style="<?php echo $hideStatusDivED ?>">
<div class="circleContainer">
        <div class="circle"><img src="<?php echo $imgStatusED?>" id="pendingToApproveImg7"style="<?php echo $circleIconSize . "" . $borderED?>" draggable="false"></div>

    </div>
    <div class="circleDetails" style="word-wrap:break-word;">
        <p style="font-weight: bold; font-size: 10px; margin-top: 4px;"><?php echo $edValue ?></p>
        <p style="font-size: 10px; margin-top: 4px;"><?php echo $edApproverValue ?></p>
        <p id="pendingDetailED" style="<?php echo $cssStatusED ?>"><?php echo $edStatusUC ?></p>
        <p style="font-size: 10px; margin-top: 4px; <?php echo $dateDisplayED ?>"><?php 
        if($dateResponseED == '0000-00-00 00:00:00'){
            echo "00-00-00 00:00";
        }else{
            echo date("y-m-d h:i A", strtotime($dateResponseED));
         } ?></p>
 
    </div>
</div>

<!--___________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________-->



<!--___________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________-->



<!-- ------------------------------------------------------------------------------------------------------------------------->

</div>
                <div class="activityDetailsContainer">
<!-- ACTIVITY DETAILS FOR FMO----------------------------------------------------------------------------------------> 

<div class="leftActivityDetailsContainerTopBot">

<div class="leftActDetailsContainerTop">


<div class="leftActivityDetails">
                        
                        <div class="firstLine">Event Details <br><br>Student Development Activity Office</div>
                     

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


                    <div class="leftActivityDetails">
                        <div class="firstLine"><br><br>Facility Management Office</div>

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

                        <div class="inputLine"><div class="asking">No. of Participants <div>:</div></div>
                        <div class="participantsDisplay"><?php echo $row['target_participants']?></div>
                        </div>
                    </div>
<!---------------------------------------------------------------------------------------------------------------------------->

<!-- ACTIVITY DETAILS FOR ITSO------------------------------------------------------------------------------------------------> 
                    <div class="leftActivityDetails">
                        <div class="firstLine"><br><br>Information Technology System Office</div>


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
                    </div>
<!---------------------------------------------------------------------------------------------------------------------------->

<!-- ACTIVITY DETAILS FOR LRC------------------------------------------------------------------------------------------------> 

<div class="leftActDetailsContainerBot">


<div class="leftActivityDetails">
                        <div class="firstLine">Learning Resource Center</div>


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
<div class="leftActivityDetails">
                        <div class="firstLine">Hospitality Management</div>


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