<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
  
    
    <title>Login SDAO</title>
</head>
<body>
<div class="split-background">
        <div class="left">
        <img src="nuStamp.png" alt="Icon" class="nuIcon">
        
            <div class="thumbBox">
                <img src="thumb.png" class="thumbIcon">
                <div class="details">
                    <p><span class="largeText">Easy to use.</span> <spam class="smallText">You don't need to be a techie or should have an advanced knowledge in order to do or get what you need. You can manage as you go along!<p></span>
                </div>
            </div>

            <div class="thunderBox">
                <img src="thundr.png" class="thunderIcon">
                <div class="details">
                    <p><span class="largeText">Flexible.</span><spam class="smallText"> Allowing users to collect and evaluate data to generate appropriate information and reports as needed, presenting information in the right amount of detail according to the level of management.</p></span>
                </div>
            </div>

            <div class="peopleBox">
                <img src="peopleIcon.png" class="peopleIcon">
                <div class="details">
                    <p><span class="largeText">Collaborative.</span><spam class="smallText"> Facilitates communication between students, faculty and employees throughout the university.</p></span>
                </div>
            </div> 
            
        </div>
        <div class="right">

        <form action="loginpage.php" method="post">
        <div class="login-form">
            
                <h1>Education that works.</h1>
                <h2>Login</h2>
              
                <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error'];?></p> 
                <?php }?> 
               
                
                <div class="user">
                    <img src="userIcon.png" alt="">
               
                <input type="text" name="email" placeholder="Email" id="email" required>
                </div>
                
                <div class="pass">
                    <img src="hide.png" alt="" id="show">
               
                <input type="password" name="password" placeholder="Password" id="password" required>
                </div>

                <script>
                    let show = document.getElementById("show");
                    let password = document.getElementById("password");
                    show.onclick = function(){
                        if(password.type == "password"){
                            password.type = "text";
                            show.src = "show.png";
                        } else{
                            password.type = "password";
                            show.src = "hide.png";
                        }
                    }
                </script>
       
                <br>
                
                <div class="loginButton">
                <button type="submit"><span><img src="loginBtn.png"class="loginIcon"></span>Login</button>
                </div>
                <br>
                <div class="note">
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
