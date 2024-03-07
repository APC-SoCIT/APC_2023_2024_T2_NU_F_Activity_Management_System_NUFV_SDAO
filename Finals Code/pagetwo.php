<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>SARF</title>
    <link rel="stylesheet" href="CSS/style1.css">
</head>

<body>
    <div class="Form2">
       
            <div class="imgAndNU">
                <img src="IMG/image_8.png" id="image_8" alt="Logo">
                <div id="nu_fairview">NU FAIRVIEW</div>
            <div id="student_development_activities_office">STUDENT DEVELOPMENT ACTIVITIES OFFICE</div>
            

            </div>
            <div class="form"> 
            <div id="student_activity_request_form">STUDENT ACTIVITY REQUEST FORM</div>
            <div id="form_description">
                This form is designed to request permission for organizing a student activity at National University Fairview.
            </div>
        </div>

        <form action="process_form.php" method="post">
        <div class="bold-left-label-container">
            <label class="bold-left-label1" for="">Facilities Management Office (FMO): </label> <br> <br>
        <label class="bold-left-label" for="">Facilities Requirements (please check if any applicable): </label> <br><br>
        </div>
        
        <div class="eight-container">
           
            <div class="checkbox-options">
                <div class="checkbox-pair">
                    <input class="adjust-right" type="checkbox" name="Facilities Requirements[]" value="Canteen">Canteen
                </div>
                <div class="checkbox-pair">
                    <input class="adjust-right" type="checkbox" name="Facilities Requirements[]" value="Basketball Court">Basketball Court
                </div>
                <div class="checkbox-pair">
                    <input class="adjust-right" type="checkbox" name="Facilities Requirements[]" value="Sky Garden">Sky Garden
                </div>
                <div class="checkbox-pair">
                    <input class="adjust-right" type="checkbox" name="Facilities Requirements[]" value="AVR">AVR
                </div>
                <div class="checkbox-pair">
                    <input class="adjust-right" type="checkbox" name="Facilities Requirements[]" value="NSTP Room">NSTP Room
                </div>
                <div class="others-input6">
                    <p>Remarks</p>
                    <input type="text" id="facitxt" name="facitxt" value="">
                </div>                

            </div>
        

        <div class="eight1">
               <div class="checkbox-options2">
            <div class="checkbox-pair">
                <input type="checkbox" name="Facilities Requirements[]" value="Level 1 Hallway">Level 1 Hallway
            </div>
            <div class="checkbox-pair">
                <input type="checkbox" name="Facilities Requirements[]" value="Level 1 Student Lounge P.E Area">Level 1 Student Lounge P.E Area
            </div>
            <div class="checkbox-pair">
                <input type="checkbox" name="Facilities Requirements[]" value="Prayer Room">Prayer Room
            </div>
            <div class="checkbox-pair">
                <input type="checkbox" name="Facilities Requirements[]" value="Classroom">Classroom (Room Number)
                <input type="text" id="classnum" name="classnum" value="">

            </div>
            <div class="checkbox-pair">
                <input type="checkbox" name="Facilities Requirements[]" value="Other pls. indicate">Other pls. indicate
                <input type="text" id="otherfaci" name="otherfaci" value="">

            </div>
        </div>
    </div>
</div>
        
<hr>

<div class="nine">
    <label class="bold-label" for="">Learning Resource Center: </label> <br> <br>
    <input type="checkbox" name="Learning Resource Center[]" value="Level 1 Function Room">Level 1 Function Room <br>
    <p class="bold-text"> Library Room Needed</p><br>
    <div class="nine1">
        <input type="checkbox" name="Learning Resource Center[]" value="Discussion Room No.1">Discussion Room No.1 <br>
        <input type="checkbox" name="Learning Resource Center[]" value="Discussion Room No.2">Discussion Room No.2 <br>
    </div>
        <div class="nine2">

        <input type="checkbox" name="Learning Resource Center[]" value="Discussion Room No.3">Discussion Room No.3 <br>
        <input type="checkbox" name="Learning Resource Center[]" value="Discussion Room No.4">Discussion Room No.4 <br>
    </div>
    <div class="nine3">
        <div class="others-input2">
            <p>Number of tables needed</p>
            <input type="text" id="remarks_tables" name="remarks_tables" value="">
        </div>       
        <div class="others-input4">
            <p>Number of chairs needed</p>
            <input type="text" id="remarks_chairs" name="remarks_chairs" value="">
        </div>       
    </div>

</div>
 <hr>
            <div class="ten">
                <label class="bold-label2" for="">Hotel Management  </label> <br> 
                <label for=""></label> <br>
                <input type="checkbox" name="Hotel Management[]" value="5th Floor Function Room to be approved by HM">5th Floor Function Room to be approved by HM <br>
            </div>

            <hr>

            <div class="eleven">
                <p><strong>Information Technology System Office (ITSO)</strong></p>
                <label for=""><strong>ITSO</strong> (please check if any applicable)</label> <br>
            </div>
      
                <div class="eleven1"> 
                    <input type="checkbox" name="Learning Resource Center[]" value="Level 1 Function Room">Level 1 Function Room <br>
                    <p class="libraryRoomNeeded">Library Room Needed</p><br>
                    <div class="checkbox-container">
                        <div class="checkbox-group">
                            <input type="checkbox" name="ITSO[]" value="LCD">LCD <br>
                            <input type="checkbox" name="ITSO[]" value="Projector">Projector <br>
                            <input type="checkbox" name="ITSO[]" value="Microphone">Microphone <br>
                        </div>
                        
                        <div class="checkbox-group">
                            <input type="checkbox" name="ITSO[]" value="TV">TV <br>
                            <input type="checkbox" name="ITSO[]" value="Speaker">Speaker <br>
                            <input type="checkbox" name="ITSO[]" value="Other pls. indicate">Other pls. indicate <br>
                            <input type="text" id="itso_other" name="itso_other" value="">
                </div>
        </div>
        <div class="button-container">
                    <button id="button" type="button" name="back" onclick="window.location.href='index.php'">Back</button>
                    <button id="submit" type="submit" name="submit">Submit</button>
                </div>
        </div>
    </form>
        </div>

            
            
</body>
<script>

</script>
</html>
