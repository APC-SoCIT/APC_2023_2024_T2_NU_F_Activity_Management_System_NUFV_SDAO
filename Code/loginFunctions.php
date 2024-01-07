<?php
session_start();

include "db_conn.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $selectedValue = $_POST["userType"];

//FOR ADMIN USER TYPE _________________________________________________________________________________________________________   
if($selectedValue === "Admin"){
    if(isset($_POST['email']) && isset($_POST['password'])){
    
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $emailVar = validate($_POST['email']);
    $passVar = validate($_POST['password']);
    $ifexistingEMAIL = mysqli_query($conn, "SELECT * FROM `accountstbl` WHERE email='$emailVar'");
    $ifexistingPASSWORD = mysqli_query($conn, "SELECT * FROM `accountstbl` WHERE password='$passVar'");

    if(empty($emailVar)){
        header("Location: Loginpage.php?error=Email is required");
        exit();
    }else if(empty($passVar)){
        header("Location: Loginpage.php?error=Password is required");
        exit();
    } else if(mysqli_num_rows($ifexistingEMAIL) == 0) {
        header("Location: Loginpage.php?error=Register your account first.");
        exit();
    } else{
        $sql = "SELECT * FROM accountstbl WHERE email='$emailVar' AND password='$passVar'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result)===1){
            $row = mysqli_fetch_assoc($result);
            if($row['email'] === $emailVar && $row['password'] === $passVar ){
                $_SESSION['email'] = $row['email'];
                $_SESSION['password'] = $row['password']; 
                header("Location: Homepage.php");
            exit();
            }
        }else {
            header("Location: Loginpage.php?error= No account matches with the given email and password. Double-check your campus and account credentials.");
            exit();
        }
    }
}else{
    header("Location: Loginpage.php");
    exit();
}
    }

//FOR Director USER TYPE _________________________________________________________________________________________________________
else if($selectedValue === "Director"){
    if(isset($_POST['email']) && isset($_POST['password'])){    
        function validate($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $emailVar = validate($_POST['email']);
        $passVar = validate($_POST['password']);
        $ifexistingEMAIL = mysqli_query($conn, "SELECT * FROM `diraccounts` WHERE email='$emailVar'");
        $ifexistingPASSWORD = mysqli_query($conn, "SELECT * FROM `diraccounts` WHERE password='$passVar'");
    
        if(empty($emailVar)){
            header("Location: Loginpage.php?error=Email is required");
            exit();
        }else if(empty($passVar)){
            header("Location: Loginpage.php?error=Password is required");
            exit();
        } else if(mysqli_num_rows($ifexistingEMAIL) == 0) {
            header("Location: Loginpage.php?error=Register your account first.");
            exit();
        } else{
            $sql = "SELECT * FROM diraccounts WHERE email='$emailVar' AND password='$passVar'";
            $result = mysqli_query($conn, $sql);
    
            if(mysqli_num_rows($result)===1){
                $row = mysqli_fetch_assoc($result);
                if($row['email'] === $emailVar && $row['password'] === $passVar ){
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['password'] = $row['password']; 
                    header("Location: DirHomepage.php");
                exit();
                }
            }else {
                header("Location: Loginpage.php?error= No account matches with the given email and password. Double-check your campus and account credentials.");
                exit();
            }
        }
    }else{
        header("Location: Loginpage.php");
        exit();
    }
        }    
        
//FOR Approver USER TYPE _________________________________________________________________________________________________________

else if($selectedValue === "Approver"){
    if(isset($_POST['email']) && isset($_POST['password'])){    
        function validate($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $emailVar = validate($_POST['email']);
        $passVar = validate($_POST['password']);
        $ifexistingEMAIL = mysqli_query($conn, "SELECT * FROM `approveraccounts` WHERE email='$emailVar'");
        $ifexistingPASSWORD = mysqli_query($conn, "SELECT * FROM `approveraccounts` WHERE password='$passVar'");
    
        if(empty($emailVar)){
            header("Location: Loginpage.php?error=Email is required");
            exit();
        }else if(empty($passVar)){
            header("Location: Loginpage.php?error=Password is required");
            exit();
        } else if(mysqli_num_rows($ifexistingEMAIL) == 0) {
            header("Location: Loginpage.php?error=Register your account first.");
            exit();
        } else{
            $sql = "SELECT * FROM approveraccounts WHERE email='$emailVar' AND password='$passVar'";
            $result = mysqli_query($conn, $sql);
    
            if(mysqli_num_rows($result)===1){
                $row = mysqli_fetch_assoc($result);
                if($row['email'] === $emailVar && $row['password'] === $passVar ){
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['password'] = $row['password']; 
                    header("Location: ApprHomepage.php");
                exit();
                }
            }else {
                header("Location: Loginpage.php?error= No account matches with the given email and password. Double-check your campus and account credentials.");
                exit();
            }
        }
    }else{
        header("Location: Loginpage.php");
        exit();
    }
        }   

//FOR Student USER TYPE _________________________________________________________________________________________________________

else if($selectedValue === "Student"){
    if(isset($_POST['email']) && isset($_POST['password'])){    
        function validate($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $emailVar = validate($_POST['email']);
        $passVar = validate($_POST['password']);
        $ifexistingEMAIL = mysqli_query($conn, "SELECT * FROM `studentaccounts` WHERE email='$emailVar'");
        $ifexistingPASSWORD = mysqli_query($conn, "SELECT * FROM `studentaccounts` WHERE password='$passVar'");
    
        if(empty($emailVar)){
            header("Location: Loginpage.php?error=Email is required");
            exit();
        }else if(empty($passVar)){
            header("Location: Loginpage.php?error=Password is required");
            exit();
        } else if(mysqli_num_rows($ifexistingEMAIL) == 0) {
            header("Location: Loginpage.php?error=Register your account first.");
            exit();
        } else{
            $sql = "SELECT * FROM studentaccounts WHERE email='$emailVar' AND password='$passVar'";
            $result = mysqli_query($conn, $sql);
    
            if(mysqli_num_rows($result)===1){
                $row = mysqli_fetch_assoc($result);
                if($row['email'] === $emailVar && $row['password'] === $passVar ){
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['password'] = $row['password']; 
                    header("Location: StudHomepage.php");
                exit();
                }
            }else {
                header("Location: Loginpage.php?error= No account matches with the given email and password. Double-check your campus and account credentials.");
                exit();
            }
        }
    }else{
        header("Location: Loginpage.php");
        exit();
    }
        }   


}


