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
              email: '<?php echo $recipient ?>', 
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
