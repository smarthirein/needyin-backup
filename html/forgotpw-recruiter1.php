<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login with Needyin</title>
    <!-- css includes-->
    <?php include"source.php" ?>
</head>

<body>
    <?php include"includes-recruiter/prelogin-header-recruiter.php" ;?>
      
        <main>
            <!-- login, register, forgot password -->
            <section class="signin signin-rec">
                <div class="container">
                    <div class="row sign">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="signin-main">
                                <div class="signin-in">
                                   
                                    <div id="forgotpw-rec">
                                        <h3 class="h3 text-center flight">FORGOT <span class="fbold txt-blue">PASSWORD? </span></h3>
                                        <form class="login-form" method="post" action="#">
                                            <div class="input-field">
                                                <p class="text-justify pb15">Enter your username or the email address you used on registration, if you remember either of them. We will send you an email message with instructions to reset your password.</p>
                                            </div>
                                            <div class="input-field">
                                                <input id="last_name" name="last_name" type="text" class="validate" type="email" required>
                                                <label for="Email ID">Enter Your Registered email ID</label>
                                            </div>
                                            <div class="input-field forgotpwbtn">
                                                <input class="btn pull-left waves-effect waves-light" type="submit" value="Reset" name="btn-reset-submit">
                                                <button class="btn pull-right waves-effect waves-light"  name="action" onclick="showlogin()"> CANCEL </button>
                                            </div>
                                        </form>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
           
        </main>
     
        <?php include"footer.php"?>
</body>
<?php
session_start();
require_once 'class.user.php';
$user = new USER();

if($user->is_logged_in()!="")
{
	$user->redirect('login.php');
}
if(!empty($_POST['last_name'))
{
if(isset($_POST['btn-reset-submit']))
{
	$email = $_POST['last_name'];
	
	$pwdresetquery=("SELECT * FROM `tbll_emplyer` WHERE emp_email='$email'");
	$pwdresetqueryres=mysqli_query($con,$pwdresetquery);
	$pwdresetqueryrow = mysqli_fetch_array($pwdresetqueryres);
	
	if(mysqli_num_rows($pwdresetqueryres) == 1)
	{
		$id = base64_encode($pwdresetqueryrow['emp_email']);
		$code = md5(uniqid(rand()));
	
		$stmt = $user->runQuery("UPDATE tbll_emplyer SET tokenCode=:token WHERE emp_email=:email");
		$stmt->execute(array(":token"=>$code,"email"=>$email));
		
		$message= "
				   Hello , $email
				   <br /><br />
				   We got requested to reset your password, if you do this then just click the following link to reset your password, if not just ignore                   this email,
				   <br /><br />
				   Click Following Link To Reset Your Password 
				   <br /><br />
				   <a href='$baseurl/reset-pw-rec.php?id=$id&code=$code'>click here to reset your password</a>
				   <br /><br />
				   Thank you :)
				   ";
		$subject = "Password Reset";
		
		
		$user->send_mail($email,$message,$subject);
		
		echo "<script lang='javascript' >alert('An Email Has been Sent your Email Regarding Resetting Password , Please check your mail');</script>";
	}
	else
	{
		echo "<script lang='javascript' >alert('Entered Email does not exist');</script>";
	}
}
}
?>
</html>