<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/login.css">
  
    
    <title>Login SDAO</title>
</head>
<body>
<div class="split-background">
        <div class="left">
        <div class="diagonalTopRight"></div>
        <div class="diagonalBottomLeft"></div>
        <div class="topLeft">
        <!--<img src="IMG/nuStamp.png" alt="Icon" class="nuIcon">-->
        <div class="leftNU"><img src="IMG/nulogo2.png"></div>
        <div class="rightNU"><span class="nuName">NU FAIRVIEW</span>  
        <br> STUDENT DEVELOPMENT ACTIVITIES OFFICE</div>

        </div>
           
            <div class="box thumbBox">
                <img src="IMG/thumb.png" class="thumbIcon">
                <div class="details">
                    <p><span class="largeText">Easy <span class="toUse">to use.</span></span> <span class="smallText"><br>
                    You don't need to be a techie or should have an advanced knowledge in order to do or get what you need. You can manage as you go along!<p></span>
                </div>
            </div>
<div class="lineSeparator"></div>
            <div class="box thunderBox">
                <img src="IMG/thundr.png" class="thunderIcon">
                <div class="details">
                    <p><span class="largeText">Flexible.</span><span class="smallText"><br>
                    Allowing users to collect and evaluate data to generate appropriate information and reports as needed, presenting information in the right amount of detail according to the level of management.</p></span>
                </div>
            </div>

            <div class="box peopleBox">
                <img src="IMG/peopleIcon.png" class="peopleIcon">
                <div class="details">
                    <p><span class="largeText">Collaborative.</span><span class="smallText"> Facilitates communication between students, faculty and employees throughout the university.</p></span>
                </div>
            </div> 
            
        </div>
        <div class="right">

        <form action="loginFunctions.php" method="post">
        <div class="login-form">
                <h1 class="h1">Activity Management System</h1>
             
                <div class="dropdown-container">
                    <select name="userType" id="userType">
                        <option class="option" value="Admin">Admin</option>
                        <option value="College Dean">College Dean</option>
                        <option value="Director">Director</option>
                        <option value="Approver">Approver</option>
                        <option value="Program Chair">Program Chair</option>
                        <option value="Org Adviser">Org Adviser</option>
                        <option value="Student">Student</option>
                    </select>
                </div>
                
                <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error'];?></p> 
                <?php }?> 
               
                
                <div class="user">
                    <img src="IMG/userIcon.png" alt="">
        
                <input type="text" name="email" placeholder="Email" id="email" required>
                </div>
                
                <div class="pass">
                    <img src="IMG/hide.png" alt="" id="show">
               
                <input type="password" name="password" placeholder="Password" id="password" required>
                </div>

<!--to see password ------------------------------------------------------------------------------------------------------------->
                <script>
                    let show = document.getElementById("show");
                    let password = document.getElementById("password");
                    show.onclick = function(){
                        if(password.type == "password"){
                            password.type = "text";
                            show.src = "IMG/show.png";
                        } else{
                            password.type = "password";
                            show.src = "IMG/hide.png";
                        }
                    }

                    setTimeout(function() {
            passwordInput.type = "password";
            passwordIcon.innerHTML = '<img class="icon unview-icon" src="img/view.png" alt="Password Icon">';
        }, 800); 
                </script>
<!------------------------------------------------------------------------------------------------------------------------------->
       
                <br>
                
                <div class="loginButton">
                <button type="submit"><span><img src="IMG/loginBtn.png"class="loginIcon"></span>Login</button>
                </div>
                <br>
                <div class="note">
                    <div class="lineNote"></div>
                    <p>All modules, contents and services included in this system is intended for Nationalians' use only. You may not, except with our express written permission, distribute or commercially exploit its contents. Nor may you transmit it or store it in any other website or other form of electronic retrieval system. National University © 2023.</p>
                </div>
        </div>
                     
            </form>
            </div>
       
        </div> 
    </div>

    </div>
    
</body>
</html>
