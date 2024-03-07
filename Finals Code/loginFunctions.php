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
    $ifexistingEMAIL = mysqli_query($conn, "SELECT * FROM `admin` WHERE admin_email='$emailVar'");
    $ifexistingPASSWORD = mysqli_query($conn, "SELECT * FROM `admin` WHERE admin_password='$passVar'");

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
        $sql = "SELECT * FROM admin WHERE admin_email='$emailVar' AND admin_password='$passVar'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result)===1){
            $row = mysqli_fetch_assoc($result);
            if($row['admin_email'] === $emailVar && $row['admin_password'] === $passVar ){
                $_SESSION['email'] = $row['admin_email'];
                $_SESSION['password'] = $row['admin_password']; 
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
        $ifexistingEMAIL = mysqli_query($conn, "SELECT * FROM `directors_approver` WHERE dapprover_email='$emailVar'");
        $ifexistingPASSWORD = mysqli_query($conn, "SELECT * FROM `director_approver` WHERE dapprover_password='$passVar'");
    
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
            $sql = "SELECT * FROM directors_approver WHERE dapprover_email='$emailVar' AND dapprover_password='$passVar'";
            $result = mysqli_query($conn, $sql);
    
            if(mysqli_num_rows($result)===1){
                $row = mysqli_fetch_assoc($result);
                if($row['dapprover_email'] === $emailVar && $row['dapprover_password'] === $passVar ){
                    $_SESSION['email'] = $row['dapprover_email'];
                    $_SESSION['password'] = $row['dapprover_password']; 
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
        $ifexistingEMAIL = mysqli_query($conn, "SELECT * FROM `facilities_and_equipment_approver` WHERE fapprover_email='$emailVar'");
        $ifexistingPASSWORD = mysqli_query($conn, "SELECT * FROM `facilities_and_equipment_approver` WHERE fapprover_password='$passVar'");
    
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
            $sql = "SELECT * FROM facilities_and_equipment_approver WHERE fapprover_email='$emailVar' AND fapprover_password='$passVar'";
            $result = mysqli_query($conn, $sql);
    
            if(mysqli_num_rows($result)===1){
                $row = mysqli_fetch_assoc($result);
                if($row['fapprover_email'] === $emailVar && $row['fapprover_password'] === $passVar ){
                    $_SESSION['email'] = $row['fapprover_email'];
                    $_SESSION['password'] = $row['fapprover_password']; 
                    if($_SESSION['email'] == 'fmo@nu-fairview.edu.ph'){
                        header("Location: FmoHomepage.php");
                    }else if($_SESSION['email'] == 'itso@nu-fairview.edu.ph'){
                        header("Location: ItsoHomepage.php");
                    }else if($_SESSION['email'] == 'lrc@nu-fairview.edu.ph'){
                        header("Location: LrcHomepage.php");
                    }else if($_SESSION['email'] == 'hm@nu-fairview.edu.ph'){
                        header("Location: HmHomepage.php");
                    }
                    //header("Location: ApprHomepage.php");
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


//FOR Program Chair USER TYPE _________________________________________________________________________________________________________


else if($selectedValue === "Program Chair"){
    if(isset($_POST['email']) && isset($_POST['password'])){    
        function validate($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $emailVar = validate($_POST['email']);
        $passVar = validate($_POST['password']);
        $ifexistingEMAIL = mysqli_query($conn, "SELECT * FROM `program_chair_approver` WHERE program_chair_email='$emailVar'");
        $ifexistingPASSWORD = mysqli_query($conn, "SELECT * FROM `program_chair_approver` WHERE program_chair_password='$passVar'");
    
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
            $sql = "SELECT * FROM program_chair_approver WHERE program_chair_email='$emailVar' AND program_chair_password='$passVar'";
            $result = mysqli_query($conn, $sql);
    
            if(mysqli_num_rows($result)===1){
                $row = mysqli_fetch_assoc($result);
                if($row['program_chair_email'] === $emailVar && $row['program_chair_password'] === $passVar ){
                    $_SESSION['email'] = $row['program_chair_email'];
                    $_SESSION['password'] = $row['program_chair_password']; 
                    header("Location: PCHomepage.php");
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



//FOR COLLEGE DEAN USER TYPE _________________________________________________________________________________________________________


else if($selectedValue === "College Dean"){
    if(isset($_POST['email']) && isset($_POST['password'])){    
        function validate($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        //$emailVar = validate($_POST['email']);
        //$passVar = validate($_POST['password']);
        //$ifexistingEMAIL = mysqli_query($conn, "SELECT * FROM `college_dean_approver` WHERE college_dean_email=?");
        //$ifexistingPASSWORD = mysqli_query($conn, "SELECT * FROM `college_dean_approver` WHERE college_dean_password=?");
        $ifexistingUser = "SELECT * FROM `college_dean_approver` WHERE college_dean_email=? AND college_dean_password=?";
        $stmt = $conn->prepare($ifexistingUser);
        $stmt->bind_param("ss", $emailVar, $passVar);

        $emailVar = ($_POST['email']);
        $passVar = ($_POST['password']);
        $stmt->execute();
        $resultifexistingquery = $stmt->get_result();
 
        if(empty($emailVar)){
            header("Location: Loginpage.php?error=Email is required");
            exit();
        }else if(empty($passVar)){
            header("Location: Loginpage.php?error=Password is required");
            exit();
        } else if($resultifexistingquery->num_rows === 0) {
            header("Location: Loginpage.php?error=Register your account first.");
            exit();
        } else{
            $sql = "SELECT * FROM college_dean_approver WHERE college_dean_email=? AND college_dean_password=?";
            $stmt2 = $conn->prepare($sql);
            $stmt2->bind_param("ss", $emailVariable, $passVariable);
            $emailVariable = ($_POST['email']);
            $passVariable = ($_POST['password']);
            $stmt2->execute();
            $resultstmt2 = $stmt2->get_result();
    
            if($resultifexistingquery->num_rows === 1){
                $rowUser = $resultstmt2->fetch_assoc();
                    $_SESSION['email'] = $rowUser['college_dean_email'];
                    $_SESSION['password'] = $rowUser['college_dean_password']; 
                    header("Location: CdHomepage.php");
                exit();
                
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

//FOR Org Adviser USER TYPE _________________________________________________________________________________________________________


else if($selectedValue === "Org Adviser"){
    if(isset($_POST['email']) && isset($_POST['password'])){    
        function validate($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $emailVar = validate($_POST['email']);
        $passVar = validate($_POST['password']);
        $ifexistingEMAIL = mysqli_query($conn, "SELECT * FROM `org_adviser_approver` WHERE org_adviser_email='$emailVar'");
        $ifexistingPASSWORD = mysqli_query($conn, "SELECT * FROM `org_adviser_approver` WHERE org_adviser_password='$passVar'");
    
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
            $sql = "SELECT * FROM org_adviser_approver WHERE org_adviser_email='$emailVar' AND org_adviser_password='$passVar'";
            $result = mysqli_query($conn, $sql);
    
            if(mysqli_num_rows($result)===1){
                $row = mysqli_fetch_assoc($result);
                if($row['org_adviser_email'] === $emailVar && $row['org_adviser_password'] === $passVar ){
                    $_SESSION['email'] = $row['org_adviser_email'];
                    $_SESSION['password'] = $row['org_adviser_password']; 
                    header("Location: OrgAdvHomepage.php");
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


