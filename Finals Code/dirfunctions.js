
        function goToDirApproval(programOrganization) {
            var page = 'DirApprovalProgresspage.php?org=' + programOrganization;
            $.ajax({
                url: page,
                type: 'GET',
                success: function(data) {
                    $('.right').html(data);  
                },
            });
        }   


       

      
