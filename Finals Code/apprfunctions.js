
function goToApprApproval(programOrg) {
    var page = 'ApprApprovalProgresspage.php?org=' + programOrg;
    $.ajax({
        url: page,
        type: 'GET',
        success: function(data) {
            $('.right').html(data);  
        },
    });
}
   