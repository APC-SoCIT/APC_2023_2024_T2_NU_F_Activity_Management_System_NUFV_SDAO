<?php
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/account.css">

    <title>Document</title>
</head>
<body>
      <div class="split-background">
       
        <div class="right">
        <div class="title">
                <h1 class="h1Title">ACCOUNT MANAGEMENT</h1>

            <div class="lineSeparator">
                <p class="reminderText">Update personal information, change passwords, set notification preferences, and manage security features, ensuring a tailored and secure experience.</p>
            </div>

            </div>
    


        <div id="page0" class="Content display">
            <?php include('pageZero.php'); ?>
        </div>

        <div id="page1" class="Content">
            <?php include('pageOne.php'); ?>
        </div>

        <div id="page2" class="Content">
            <?php include('pageTwoAccount.php'); ?>
        </div>

        <div id="page3" class="Content">
            <?php include('pageThree.php'); ?>
        </div>

    <script>
    function showPage(pageId) {
        // Hide all tab content
        var page = document.getElementsByClassName('Content');
        for (var i = 0; i < page.length; i++) {
            page[i].classList.remove('display');
        }
    // Show the selected tab content
        document.getElementById(pageId).classList.add('display');
        
  }
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