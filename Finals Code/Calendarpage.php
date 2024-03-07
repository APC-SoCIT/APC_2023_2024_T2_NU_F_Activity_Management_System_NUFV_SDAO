<?php
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="CSS/Calendar.css">
    <title>Document</title>
</head>
<body> 
        <div class="right">
            <div class="title">
                <h1 class="h1Title">CALENDAR</h1>
           
                <div class="lineSeparator">
                </div>

            </div>
            <div class="Content">
                
            <script>
                $(document).ready(function() {
        $.ajax({
            url: 'Calendar.php',
            type: 'GET',
            success: function(response) {
                $('.Content').html(response);
            },
            error: function(xhr, status, error) {
                console.error('Error:', status, error);
            }
        });
    
});

            </script>

   
    
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