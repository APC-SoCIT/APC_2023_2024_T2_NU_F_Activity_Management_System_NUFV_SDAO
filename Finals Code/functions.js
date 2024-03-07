      
        function loadContent(page) {
            $.ajax({
                url: page,
                type: 'GET',
                success: function(data) {
                    $('.right').html(data);

                

                    history.pushState(null, null, `Navbarpage.php?Page=${page}`);
                    $('.btnNavbar').removeClass('selected');
                          
                          $('.btnNavbar').eq(selectedIndex).addClass('.selected');
      
                        
                },
            });
           
        }

        // Function to retrieve the activeButton value from the query parameter
        function getActivePageFromQuery() {
            let urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('Page'); // Default to 1 if not present
        }

        $(document).ready(function() {
            let Page = getActivePageFromQuery();

            if (Page === 'Status') {
                loadContent('Statuspage.php');  
            } else if (Page === 'Approval') {
                loadContent('Approvalpage.php');
            } else if (Page === 'Timeline') {
                loadContent('Timelinepage.php');
            }
            else if (Page === 'Calendar') {
                loadContent('Calendarpage.php');
            }
            else if (Page === 'Reports') {
                loadContent('Reportspage.php');
            }
            else if (Page === 'Accounts') {
                loadContent('Accountpage.php');
            }
        });

        function displayAccount(page) {
            $.ajax({
                url: page,
                type: 'GET',
                success: function(data) {
                    $('.container').html(data);  
                    
                },
            });
           
        }
 

//DISPLAY ACCOUNTS ON MANAGE ACCOUNTS FUNCTION-------------------------------------->    
    
    function showPage(pageId) {
        // Hide all tab content
        var page = document.getElementsByClassName('Content');
        for (var i = 0; i < page.length; i++) {
            page[i].classList.remove('display');
        }
    // Show the selected tab content
        document.getElementById(pageId).classList.add('display'); 
  }

//------------------------------------------------------------------------------------>

//onBack and onNext function-------------------------------------------------------->

  var page =document.getElementsByClassName('Content');
  function onBack() {
    if(page1.classList.contains('display')){
        showPage('page0');
    } else if(page2.classList.contains('display')){
        showPage('page0');
    } else if(page3.classList.contains('display')){
        showPage('page0');
    }
  }
  function onNext(){
    if(page1.classList.contains('display')){
        showPage('page2');
    } else if(page2.classList.contains('display')){
        showPage('page3');
    }
  }

//------------------------------------------------------------------------------------>


//---HOME BUTTON----------------------------------------------------------------------------------->
   
        function goHome(){
            window.location.href = 'Homepage.php';
        }
  

//--------------------------------------------------------------------------------------------------->




   /* function goToApproval() {
        var page = 'ApprovalProgresspage.php'
            $.ajax({
                url: page,
                type: 'GET',
                success: function(data) {
                    $('.right').html(data);  

                    
                },
            });
           
        } */
    
        function goToApproval(activityTitle, programOrganization) {
            var page = 'ApprovalProgresspage.php?title=' + activityTitle + '&org=' + programOrganization;
            $.ajax({
                url: page,
                type: 'GET',
                success: function(data) {
                    $('.right').html(data);  
                },
            });
        }

        function goToApproval(programOrganization) {
            var page = 'ApprovalProgresspage.php?org=' + programOrganization;
            $.ajax({
                url: page,
                type: 'GET',
                success: function(data) {
                    $('.right').html(data);  
                },
            });
        }

      
       /*  function approveRequestSdao(org) {
            $.ajax({
                type: 'POST',
                url: 'update_status_SDAO.php',
                data: { org: org },
                success: function (response) {
                    var imagePendingToApprove = document.getElementById('pendingToApproveImg');
                    var pPendingDetail = document.getElementById('pendingDetailSDAO');
                    var idrejectBtn = document.getElementById('rejectBtnId');
                    var approveBtn =document.getElementById('approveBtn');
                    pPendingDetail.textContent = 'APPROVED';
                    pPendingDetail.style.backgroundColor = 'rgba(153, 217, 71, 1)';
                    imagePendingToApprove.style.backgroundColor = 'rgba(151, 239, 120, 1)';
                    imagePendingToApprove.style.padding = '1px';
                    imagePendingToApprove.src = 'IMG/check.png';
                    idrejectBtn.textContent = 'Back';
                    approveBtn.textContent = 'Done';      
                },
                error: function (error) {
                    console.error('Error:', error);
                    // Handle the error if needed
                }
            });
        } */



       

      
