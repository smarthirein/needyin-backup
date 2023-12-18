<?php
require_once '../class.user.php';
header('Cache-Control: no cache'); //no cache
 session_cache_limiter('private_no_expire');

session_start();
$user_home = new USER(); 
if(isset($_POST['admin-login']))
{
	$email = trim($_POST['emailid']);
	$upass = trim($_POST['password']);
	
	if($user_home->loginadmin($email,$upass))
	{        
        $user_home->redirect('profiles-latest.php');       
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Post a job and find the profiles which compromise with the current CTC.">
    <title>Top Free Job Posting Website Online for Employers in India - Needyin</title>
    <!-- css includes-->
    <?php include "source.php";?>
        <script type="text/javascript">
            $(function () {
                $('.crsl-items').carousel({
                    visible: 4
                    , itemMinWidth: 258
                    , itemEqualHeight: 320
                    , itemMargin: 8
                , });
                $("a[href=#]").on('click', function (e) {
                    e.preventDefault();
                });
            });
        </script>
		        <script>
function validatecredentials()
{
 var email=document.getElementById("emailid").value;
    if(email=="")
    {
        alert("Please give your Email ID");
        document.getElementById("emailid").focus();
        return false;
    }
   if(!emailverify(email))
	{
	
        document.getElementById("emailid").focus();
        return false;
		
	}

    var pwd=document.getElementById("password").value;
    if(pwd=="")
    {
        alert("Please Give Your password");
        document.getElementById("password").focus();
        return false;
    }
}
function validatesearch()
{
	var skill=document.getElementById("languages").value;
	if(skill==0)
	{
		alert("Please Select Skill Name");
		document.getElementById("languages").focus();
		return false;
	}

}	
</script>
</head>

<body>
    <?php 	
	include_once("analyticstracking.php");
	if(isset($_SESSION['adminSession']))
        {
             include "../includes-recruiter/admin_header.php"; 
        } 
		else
	{
    include "../includes-recruiter/prelogin-header-admin.php"; 
  } 
     ?>
	
  
        <main class="recruiter-main">
            
            <div class="container">
                <div class="login-block">
                    <div class="row">
                       
                        <div class="col-md-5 col-sm-12 col-xs-12">
                            <article class="top-ban-content">
                                <h2 class="flight-thin h2"> Welcome To
                                <span class="fbold"> Needyin Curation </span>
                            </h2>
                               
                            </article>
                        </div>
                      
						<?php
						if(!isset($_SESSION['adminSession']))
        {				?>
                        <div class="col-md-4 col-sm-6 col-sm-offset-3 col-xs-12 col-md-offset-3">
                            <div class="login-recruiter">
							 <form class="emp-form" method="POST">		
								<?php
								if(isset($_GET['error']))
								{
								?>
								<div class='alert alert-danger'>
										<button class='close' data-dismiss='alert'>&times;</button>
										<strong>Wrong Details!</strong> 																	
								</div>
								<?php
								}
								?>				 
                                <div class="form-group">
                                    <label>Business E-mail Id</label>
                                    <input class="form-control validate" name="emailid" id="emailid" type="text" placeholder="Professional Email ID"> </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control validate" name="password" id="password" type="password" placeholder="Enter Password"> </div>
                                <div class="form-group forgotpw" style="margin-bottom:0;"> <a href="forgotpw-recruiter.php" class="txt-white">Forgot Password?</a> </div>
                                <div class="form-group" style="margin-bottom:0;">
                                 <button name="admin-login" class="btn btn-blue-sm btn-block waves-effect" onclick="return validatecredentials()">Login</button></div>
                               
							</form>
                            </div>
                        </div>
		<?php }?>
                       
                    </div>
                </div>
            </div>
          
            
	
        </main>
     
        <?php include "../footer.php"; ?>

</body>

</html>