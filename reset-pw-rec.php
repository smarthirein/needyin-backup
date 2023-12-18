<?php

require_once 'class.user.php';
$user = new USER();

if(empty($_REQUEST['id']) && empty($_REQUEST['code']))
{
	$user->redirect('index.php');
}

if($_REQUEST['id'] !="" && $_REQUEST['code'] !="")
{
	 $id = base64_decode($_REQUEST['id']); 
	$code = $_REQUEST['code'];	
	$sqlver="SELECT * FROM tbll_emplyer WHERE emp_id='$id' AND emp_code='$code'";

	$sqlverres=mysqli_query($con,$sqlver);
	$sqlverrow = mysqli_fetch_array($sqlverres);

	if(mysqli_num_rows($sqlverres) == 1)
	{
		if(isset($_POST['btn-reset-pass']))
		{
			$pass = $_POST['password1'];
		 	$cpass = $_POST['password'];
			
			if($cpass!==$pass)
			{
				echo "<script lang='javascript' >alert('Given Passwords doesn't match');</script>";
			}
			
			else if(strlen($cpass)<'8')
			{
				echo "<script lang='javascript' >alert('Password must Contain at leasr 8 letters');</script>";
			}
			else
			{
				 $password = md5($cpass);
				$sqlupdate = "UPDATE `tbll_emplyer` SET `emp_password`='$password' WHERE emp_id='$id'";
				
				mysqli_query($con,$sqlupdate);
				
				echo "<script lang='javascript' >alert('Your Password is changed , Relogin to continue');</script>";
						
						
				header("refresh:5;index-recruiter.php");
			}
		}	
	}
	else
	{echo "<script lang='javascript' >alert('No Account Found, Try again');</script>";
				
				
				
	}
	
	
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login with Needyin</title>
    <!-- css includes-->
    <?php include "source.php"; ?>
</head>

<body>
    <?php
include_once("analyticstracking.php");
include"includes-recruiter/prelogin-header-recruiter.php"?>
      
        <main>
          
            <section class="signin signin-rec">
                <div class="container">
                    <div class="row sign">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="signin-main">
                                <div class="signin-in">
                                    <!-- sign in-->
                                    <div id="resetpw">
                                        <h3 class="h3 text-center flight">CREATE NEW <span class="fbold txt-blue">PASSWORD </span></h3>
                                        <div class="input-field">
                                            <p class="pt15 text-center">Hi <?php echo $sqlverrow['contact_name']; ?> Hi ,You can create a New Password here</p>
                                        </div>
                                        <form class="login-form" method="post" action="#">
                                            <div class="input-field">
                                                <input id="password1" type="password" class="validate" name="password1" pattern = "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!#^%*?&])[A-Za-z\d$@$!%#^*?&]{8,}" title="Password should contain Minimum eight charact, at least one uppercase letter, one lowercase letter, one number and one special character(!@#$%^&*)">
                                                <label for="password1">New Password</label>
                                            </div>
                                            <div class="input-field">
                                                <input id="password" type="password" class="validate" name="password" pattern = "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!#^%*?&])[A-Za-z\d$@$!%#^*?&]{8,}" title="Password should contain Minimum eight charact, at least one uppercase letter, one lowercase letter, one number and one special character(!@#$%^&*)">
                                                <label for="password">Confirm Password</label>
                                            </div>
                                            <div class="input-field btnreset">
                                                <input type="submit" class="btn btn-block waves-effect waves-light btn-sm" value="Reset & Login" name="btn-reset-pass" onClick="return validatepassword()">
                                                <input type="button" class="btn btn-block waves-effect waves-light btn-sm" value="Cancel" onClick="Javascript:window.location.href = 'index-recruiter.php';"> </div>
                                            <div class="input-field"> </div>
                                        </form>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
					<script lang="javascript">
		function validatepassword()
		{
		var pwd=document.getElementById('password1').value;
					var verpwd=document.getElementById('password').value;
					if(!passwordverify(pwd))
				{
					document.getElementById('password1').focus();
					
					return false;
				}
				
				if(pwd!=verpwd)
				{
					
					alert("New Password and Confirm Password Must be Same");
					document.getElementById('password').focus();
					
					return false;
					
					
				}
					
		
		}
		</script>
       
        </main>
      
        <?php include"footer.php"?>
</body>

</html>
