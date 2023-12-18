<?php 
session_start();
require_once 'class.user.php';

$user_home = new USER();
if(!isset($_SESSION['empSession']))
{
$user_home->redirect('index-recruiter.php');   
}
		  
$stmt = $user_home->runQuery("SELECT * FROM tbll_emplyer WHERE emp_id=:rid");
$stmt->execute(array(":rid"=>$_SESSION['empSession']));

$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Needyin</title>
 
    <?php include"source.php" ?>
        <script>
            $(document).ready(function () {
                $('.modal').modal();
            });
        </script>
</head>

<body>
    <?php 
	include_once("analyticstracking.php");
	include"includes-recruiter/db-recruiter-header.php"?>
        
        <main>
            <section class="jobseekar-profile">
             
                <section class="job-seekar-body">
                    <div class="js-profile-nav">
                        
                        <div class="container">
                            
                            <div class="update-cv">
                                <div class="title-block-tab">
                                    <h4 class="flight">Update <span class="fbold">Password</span></h4> </div>
                              
                                <div class="change-pw">
                                    <form action="recruiter-profile-update-password-process.php" method="post">
                                        <div class="input-field">
                                            <input id="password" type="password" class="validate" name="password"  pattern = "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!#^%*?&])[A-Za-z\d$@$!%#^*?&]{8,}" title="Password should contain Minimum eight charact, at least one uppercase letter, one lowercase letter, one number and one special character(!@#$%^&*)">
                                            <label for="password">Old Password</label>
                                        </div>
                                        <div class="input-field">
                                            <input id="newpassword" type="password" class="validate" name="newpassword"  pattern = "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!#^%*?&])[A-Za-z\d$@$!%#^*?&]{8,}" title="Password should contain Minimum eight charact, at least one uppercase letter, one lowercase letter, one number and one special character(!@#$%^&*)">
                                            <label for="newpassword">New Password</label>
                                        </div>
                                        <div class="input-field">
                                            <input id="conpassword" type="password" class="validate" name="conpassword"  pattern = "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!#^%*?&])[A-Za-z\d$@$!%#^*?&]{8,}" title="Password should contain Minimum eight charact, at least one uppercase letter, one lowercase letter, one number and one special character(!@#$%^&*)">
                                            <label for="conpassword">Confirm Password</label>
                                        </div>
                                        <div class="input-field">
                                            <button class="btn btn-blue-sm" type="submit" name="Changepwd" onclick="return validatepassword()">Save & Update</button>
                                           <a href="index.php" class="btn btn-blue-sm">Cancel</a>
                                        </div>
                                    </form>
                                </div>
                             
                            </div>
                          
                        </div>
                    </div>
                   
                </section>
             
            </section>
        </main>
     
        <div id="modal1" class="modal editpic-modal">
            <div class="modal-content">
                <h4 class="text-center">Change Profile Picture</h4>
            
                <div class="profile-pic-edit text-center">
                    <figure><img src="img/profile-pic.jpg"></figure>
             
            </div>
            <div class="modal-footer text-center"> <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Cancel</a> <a href="recruiter-profile-update-password.php" class="btn-flat file-field input-field"><span>Upload Picture</span> <input type="file"></a> <a href="#!" class=" waves-effect waves-green btn-flat">Save</a> <a href="#!" class=" waves-effect waves-green btn-flat">Delete</a> </div>
        </div>
       
        <div id="reset-pwjs" class="modal bottom-sheet text-center alertbx">
            <div class="modal-footer"> <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat"><i class="fa fa-times" aria-hidden="true"></i></a> </div>
            <div class="modal-content">
                <h4 class="h4 txt-blue">Update Password</h4>
                <p>You have Successfully Reset with New Password</p>
                <button class="btn btn-flat" onclick="Javascript:window.location.href='login.php';">Login Again</button>
            </div>
        </div>
      
        <script>
            $(document).ready(function () {
                Materialize.updateTextFields();
            });
        </script>
        
            <script>
               
                function centerModal() {
                    $(this).css('display', 'block');
                    var $dialog = $(this).find(".modal-dialog ");
                    var offset = ($(window).height() - $dialog.height()) / 2;
           
                    $dialog.css("margin-top ", offset);
                }
                $('.modal').on('show.bs.modal', centerModal);
                $(window).on("resize ", function () {
                    $('.modal:visible').each(centerModal);
                });
				
				
				
				
				
				
				function validatepassword()
				{
					var opwd=document.getElementById('password').value;
					var pwd=document.getElementById('newpassword').value;
					var verpwd=document.getElementById('conpassword').value;
					if(opwd=="")
				{
					alert("Please give Old Password");
					document.getElementById('password').focus();
					
					return false;
				}
				if(opwd == pwd){
					alert("Old Password and new password canot be same.");
					document.getElementById('password').focus();
					return false;
				}
					
					if(!passwordverify(pwd))
				{
					document.getElementById('newpassword').focus();
					
					return false;
				}
				
				if(pwd!=verpwd)
				{
					
					alert("New Password and Confirm Password are not Same,Please Check");
					document.getElementById('conpassword').focus();
					
					return false;
					
					
				}
					
					
					
				}
            </script>
</body>

</html>