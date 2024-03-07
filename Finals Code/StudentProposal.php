<?php
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Proposal</title>
</head>
<body>
    <div class="split-background">
        </div>

        <div class="right">
            <div class="title">
                <h1 class="h1Title">Activity Proposal</h1>
                <div class="lineSeparator"><br><Br><br>
                    <form action="upload_proposal.php" method="POST" enctype="multipart/form-data">
                            <label for="file" class="form-label">Attach Proposal:</label><br>
                            <input type="file" class="form-control" name="file" id="file"><br><br>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
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
