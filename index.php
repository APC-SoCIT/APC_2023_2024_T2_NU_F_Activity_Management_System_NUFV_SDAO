<?php 
    include("insert.php");
    ?>
<html>
<head>
    <title>SARF</title> 
    <link rel="stylesheet" href="CSS/style.css"> 
</head>
<body>
<form class="Form1" action="insert.php" method="post" onsubmit="return validateForm()">
        <div class="form">
            <img src="IMG/image_8.png" id="image_8" alt="Logo">
            <div id="nu_fairview">NU FAIRVIEW</div>
            <div id="student_development_activities_office">STUDENT DEVELOPMENT ACTIVITIES OFFICE</div>
            <div id="student_activity_request_form">STUDENT ACTIVITY REQUEST FORM</div>
            <div id="form_description">
                This form is designed to request permission for organizing a student activity at National University Fairview.
            </div>
        </div>

        <div class="First-line">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required value="">
    </div>
    <div class="form-group">
        <label for="date_requested">Date Requested</label> 
        <input type="date" id="date_requested" name="date_requested" required value="">
    </div>
</div>

<div class="Second-line">
    <div class="program_organization">
        <label for="program_organization">Name of Program / Club / Organization</label>
        <input type="text" id="program_organization" name="program_organization" required value="">
    </div>
</div>

<div class="Third-line">
    <div class="form-group">
        <label for="activity_title">Title of the Activity</label>
        <input type="text" id="activity_title" name="activity_title" required value="">
    </div>  
    <div class="form-group">
        <label for="activity_datetime">Date / Time of the Activity</label> 
        <input type="datetime-local" id="activity_datetime" name="activity_datetime" required value="">
    </div>
</div>

<div class="fourth-line">
    <div class="activity_objective">
        <label for="activity_objective">Objective of the Activity:</label>
        <input type="text" id="activity_objective" name="activity_objective" required value="">
    </div>
</div>

<div class="Fifth-line">
    <div class="form-group target-participants">
        <label for="target-participants">Target No. of Participants</label>
        <input type="number" name="target_no_of_participants" id="target-participants" required value="">
    </div>
        
            <div class="form-group activity-type">
                <label for="activity-type">Type of Activity</label>
                <div class="activity-options">
                    <input type="checkbox" name="ActivityType[]" id="internal" value="Internal (within the campus)">
                    <label for="internal">Internal<br>(within the campus)</label>
        
                    <input type="checkbox" name="ActivityType[]" id="external" value="External (Outside of the Campus)">
                    <label for="external">External<br>(Outside of the Campus)</label>
        
                    <input type="checkbox" name="ActivityType[]" id="combination" value="Combination">
                    <label for="combination">Combination</label>
                </div>
            </div>
        </div>

        <div class="Sixth-line">
            <div class="activity-options2">
                <div class="activity-inclusion-title">
                    <label>Activity Inclusion / Description (please check if any applicable)</label>
                </div>
                
                <div>
                <input type="checkbox" name="ActivityOptions[]" id="selling" value="Selling of food/product/item/ticket">
                <label for="selling">Selling of food/product/item/ticket</label>
                </div>
                <div>
                <input type="checkbox" name="ActivityOptions[]" id="seminar" value="Seminar/Training/Panel/ discussion">
                <label for="seminar">Seminar/Training/Panel/ discussion</label>
                </div>
                <div>
                    <input type="checkbox" name="ActivityOptions[]" id="concert" value="Concert/Music performance">
                    <label for="concert">Concert/Music performance</label>
                </div>
                <div>
                    <input type="checkbox" name="ActivityOptions[]" id="fund_collection" value="Fund Collection/Donation Drive">
                    <label for="fund_collection">Fund Collection/Donation Drive</label>
                </div>
                <div>
                    <input type="checkbox" name="ActivityOptions[]" id="sports" value="Sports Activities/Team Building">
                    <label for="sports">Sports Activities/Team Building</label>
                </div>
                <div>
                    <input type="checkbox" name="ActivityOptions[]" id="community_outreach" value="Community Outreach/Social Works">
                    <label for="community_outreach">Community Outreach/Social Works</label>
                </div>
                <div>
                    <input type="checkbox" name="ActivityOptions[]" id="sponsor_support" value="Sponsor Support">
                    <label for="sponsor_support">Sponsor Support</label>
                </div>
                <div>
                    <input type="checkbox" name="ActivityOptions[]" id="rental" value="Rental of items outside">
                    <label for="rental">Rental of items outside</label>
                </div>
                <div>
                    <input type="checkbox" name="ActivityOptions[]" id="competition" value="Competition/Contest">
                    <label for="competition">Competition/Contest</label>
                </div>
                <div class="Others-line">
                    <div class="others-input">
                        <p>Others pls. indicate.</p>
                        <input type="text" id="others_indicate" name="others_indicate" value="">
                    </div>
                    <hr>
                </div>
                
                </div>
                <div id="sdao_description">
                    STUDENT DEVELOPMENT & ACTIVITY OFFICE (SDAO) (please check if any applicable)
                </div>
                

<div class="Sixth-line">
    <div class="activity-options2">
        <div class="activity-inclusion-title">
            <label>Activity Inclusion / Description (please check if any applicable)</label>
        </div>
        <div class="Tenth-line">
        <div class="checkbox-option">
            <input type="checkbox" name="SDAOOptions[]" id="sdao_budget" value="With SDAO Budget">
            <label for="sdao_budget">With SDAO Budget</label>
            </div>
            <div class="Seventh-line">
                <div class="checkbox-option">
                    <input type="checkbox" name="SDAOOptions[]" id="program_college_budget" value="With Program/College Budget">
                    <label for="program_college_budget">With Program/College Budget</label>
                </div>
                <div class="Eight-line">
                    <div class="checkbox-option">
                        <input type="checkbox" name="SDAOOptions[]" id="sponsor" value="With Sponsor">
                        <label for="sponsor">With Sponsor</label>
                    </div>
                    <div class="Ninth-line">
                        <div class="checkbox-option">
                            <input type="checkbox" name="SDAOOptions[]" id="no_budget_requirements" value="No budgetary requirements">
                            <label for="no_budget_requirements">No budgetary requirements</label>
                        </div>
                        <div class="Others-line">
                            <div class="others-input">
                                <p>Others pls. indicate.</p>
                                <input type="text" id="others_indicate" name="others_indicate" value="">
                            </div>
                            </div>

                            <div class="Eleventh-line">
                                <button id="backButton" onclick="goBack()">Back</button>
                                <button id="nextButton" onclick="goToNextPage()">Next Page</button>
                            </div>
                        
        </div>

        
    </div>
</body>
<script>
    function validateForm() {
        var requiredFields = document.querySelectorAll('[required]');
        var checkboxes = document.querySelectorAll('[type="checkbox"]');
        var valid = true;

        requiredFields.forEach(function (field) {
            var label = field.previousElementSibling;

            if (!field.value.trim()) {
                label.innerHTML = label.innerHTML.replace('*', '') + '<span style="color: red">*</span>'; 
                valid = false;
            } else {
                label.innerHTML = label.innerHTML.replace('<span style="color: red">*</span>', '');
            }
        });

        var activityTypeCheckboxes = document.querySelectorAll('[name="ActivityType[]"]');
        var activityTypeLabel = document.querySelector('.activity-type label');

        if (![...activityTypeCheckboxes].some(checkbox => checkbox.checked)) {
            activityTypeLabel.innerHTML = 'Type of Activity<span style="color: red">*</span>';
            valid = false;
        } else {
            activityTypeLabel.innerHTML = 'Type of Activity';
        }

        var inclusionCheckboxes = document.querySelectorAll('[name="ActivityOptions[]"]');
        var inclusionLabel = document.querySelector('.activity-inclusion-title label');

        if (![...inclusionCheckboxes].some(checkbox => checkbox.checked)) {
            inclusionLabel.innerHTML = 'Activity Inclusion / Description (please check if any applicable)<span style="color: red">*</span>';
            valid = false;
        } else {
            inclusionLabel.innerHTML = 'Activity Inclusion / Description (please check if any applicable)';
        }

        var sdaoCheckboxes = document.querySelectorAll('[name="SDAOOptions[]"]');
        var sdaoLabel = document.querySelector('#sdao_description label');

        if (![...sdaoCheckboxes].some(checkbox => checkbox.checked)) {
            sdaoLabel.innerHTML = 'STUDENT DEVELOPMENT & ACTIVITY OFFICE (SDAO) (please check if any applicable)<span style="color: red">*</span>';
            valid = false;
        } else {
            sdaoLabel.innerHTML = 'STUDENT DEVELOPMENT & ACTIVITY OFFICE (SDAO) (please check if any applicable)';
        }

        if (!valid) {
            alert('Please fill in all the required fields and check at least one checkbox in each category.');
        }

        return valid;
    }

    function goBack() {
            window.history.back();
        }

    function goToNextPage() {
        (validateForm()) 
            window.location.href = "pagetwo.php";

        
    }
</script>


</html>
