<!DOCTYPE html>
<html lang="en">
<?php
require_once 'class.user.php';
require_once 'source.php';
$user = new USER();
if(empty($_GET['id']) && empty($_GET['code']))
{
	$user->redirect('index.php');
}

?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login with Needyin</title>
    <!-- css includes-->
    <?php include"source.php" ?>
</head>

<body>
    <?php 
	include_once("analyticstracking.php");
	include"prelogin-header.php"; ?>
      
        <main>
           
            <section class="signin">
                <div class="container">
                    <div class="row sign">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="signin-main">
                                <div class="signin-in">
                                    <!-- sign in-->
                                    <div id="resetpw">
                                        <h3 class="h3 text-center flight">CREATE NEW <span class="fbold txt-blue">PASSWORD </span></h3>
                                        <div class="input-field">
                                            <p class="pt15 text-center">Hi , You can create a New Password here</p>
                                        </div>
                                        <form class="login-form" method="post" action="reset-pw-act.php">
                                            <div class="input-field">
                                                <input id="password1" type="password" class="validate" name="password1" pattern = "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!#^%*?&])[A-Za-z\d$@$!%#^*?&]{8,}" title="Password should contain Minimum eight charact, at least one uppercase letter, one lowercase letter, one number and one special character(!@#$%^&*)" required>
                                                <label for="password1">New Password</label>
                                            </div>
                                            <div class="input-field">
                                                <input id="password" type="password" class="validate" name="password" pattern = "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!#^%*?&])[A-Za-z\d$@$!%#^*?&]{8,}" title="Password should contain Minimum eight charact, at least one uppercase letter, one lowercase letter, one number and one special character(!@#$%^&*)" required>
                                                <label for="password">Confirm Password</label>
                                            </div>
											                                            <div class="input-field">
																							 <input id="ids" type="hidden" class="validate" name="ids" value="<?php echo $_GET['id'];?>">
																							 <input id="code" type="hidden" class="validate" name="code" value="<?php echo $_GET['code'];?>">
											</div>
                                            <div class="input-field btnreset">
                                                <input type="submit" class="btn btn-block waves-effect waves-light btn-sm" value="Reset & Login" name="btn-jobseeker-reset-pass"  onClick="return validatepassword()">
                                                <input type="button" class="btn btn-block waves-effect waves-light btn-sm" value="Cancel" onClick="Javascript:window.location.href = 'login.php';"> </div>
                                            <div class="input-field"> </div>
                                        </form>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
        </main>
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
        <!--/main-->
        <?php include "footer.php"; ?>
</body>

</html>