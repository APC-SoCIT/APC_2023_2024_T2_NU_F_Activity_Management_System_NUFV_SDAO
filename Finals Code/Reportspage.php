<?php
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/Reports.css">
    <title>Document</title>
</head>
<body> 
        <div class="right">
            <div class="title">
                <h1 class="h1Title">Organizations End Activity Report</h1>
           
                <div class="lineSeparator">
                </div>
            </div>
            
            <div class="Content">     
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