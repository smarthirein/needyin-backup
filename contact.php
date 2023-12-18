<?php require_once 'class.user.php';
require_once 'mail/PHPMailer/PHPMailerAutoload.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>

    <?php include "source.php" ?>
        <script>
            $(document).ready(function () {
                $('.modal').modal();
            });
        </script>
</head>

<body>
    <?php 
	include_once("analyticstracking.php");
  if(isset($_SESSION['userSession']))
        {
             include "postlogin-header-jobseekar.php"; 
        } 
     
	else if(isset($_SESSION['empSession']))
        {
             include "includes-recruiter/db-recruiter-header.php"; 
        } 
		else
	{
    include "prelogin-header2.php"; 
  } 
	?>
        
        <main>
          
            <section class="page-title-block">
                <div class="container">
                    <article class="page-titlein">
                        <h2 class="h2 flight txt-white">Contact <span class="fbold">Needyin</span></h2>
                     
                    </article>
                </div>
            </section>
           
           
            <section class="page-content">
                <div class="container">
                    <div class="row">
					<div class="col-md-12">
					<form action="#!" method="POST">
						<h4 class="req-title">Fill in the form, we will get back to you shortly</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-field">
                                <input id="first_name" name="first_name" type="text" class="validate" maxlength="55">
                                <label for="first_name">Full Name *</label>
                            </div>
                        </div>
                       
                        <div class="col-md-4">
                            <div class="input-field">
                                <input id="tph" name="tph" type="text" class="validate" onkeypress="return isNumber()" maxlength="10">
                                <label for="tph">Contact Number *</label>
                            </div>
                        </div>
                         
                    </div>
                    <div class="row">
                       

                        <div class="col-md-4">
                            <div class="input-field">
                                <input id="email" name="email" type="email" class="validate" maxlength="55">
                                <label for="email">Email *</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-field">
                                <input id="comp_name" name="comp_name" type="text" class="validate" maxlength="55">
                                <label for="comp_name">Company Name *</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        
                      
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-field">
                                <textarea id="textarea1" name="textarea1" class="materialize-textarea" data-length="120"></textarea>
                                <label for="textarea1">Description *</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="submit" class="btn btn-blue-sm" name="contactsubmit" onclick="return validcntrec()">
                            <button class="btn btn-blue-sm  modal-action modal-close waves-effect">Cancel</button>
                        </div>
                
            </div>
			</form>
					</div>
                       
                        
                    </div>
                </div>
            </section>
           
        </main>
        
        <?php //include"footer.php"; ?>
            
			
			<script type="text/javascript">
			function isNumber(evt) 
{
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) 
	{
        return false;
    }
   else
   {
		return true;
   }
}
			function validcntrec()
			{				
			var fname=document.getElementById('first_name').value;
				if(fname=="")
				{					
					alert("Please Give Your Full Name");
				
					
						return false;
																				
				}								
		
				
				var comp_name=document.getElementById('comp_name').value;
				if(comp_name=="")
				{
					alert("Please Give Your Company Name");
					
					return false;															
				}
				var email=document.getElementById('email').value;
				if(email=="")
				{
					alert("Please Give Your Email");
				
					return false;															
				}
				
				if(!emailverify(email))
				{
					
				
					return false;															
				}
				
				
				
				var tph=document.getElementById('tph').value;
				if(tph=="")
				{
					alert("Please Give Your Contact Number");
				
					return false;															
				}
				
				var textarea1=document.getElementById('textarea1').value;
				if(textarea1=="")
				{
					alert("Please Specify Your Requirements");
				
					return false;															
				}
																					
			}
			
			</script>
          
</body>

</html>
<?php
if(isset($_SESSION['']))
{
	$empid=$_SESSION['empSession'];
	
}
else
	$empid=0;
if(empty($_POST['first_name'])||empty($_POST['comp_name'])||empty($_POST['email'])||empty($_POST['tph'])||empty($_POST['textarea1']))
{	
?> 
			<?php	

}

else if(isset($_POST['contactsubmit']))
{
	
	$sqlcontact="INSERT INTO tbl_contactrecuriter(emp_id, recuriterFirstName, recuriterLastName,recruiterdesignation, recuriterCompanyName,recuriterLocation, recuriterEmail, recuriterContactNo, recuriterCompUrl, recruiterSpecificRequired) VALUES ('$empid','".$_POST['first_name']."','".$_POST['last_name']."','".$_POST['designation']."','".$_POST['comp_name']."','".$_POST['location']."','".$_POST['email']."','".$_POST['tph']."','".$_POST['url']."','".$_POST['textarea1']."')";

	$sqlcontactres=mysqli_query($con,$sqlcontact);
	
	if($sqlcontactres)
	{
		 $email_to = "support@needyin.com"; 
		 
			$email_subject = $subject;
		 $message=$_POST['textarea1']." This mail has been received from ".$_POST['email'];
				$mail = new PHPMailer;
$email_to="support@needyin.com";
$mail->IsSMTP();

$mail->Host = 'mail.needyin.com';
$mail->SMTPAuth = true;
$mail->Username = 'support@needyin.com';
$mail->Password = 'Support@123';
$mail->SMTPSecure = 'tls';

$mail->From ='support@needyin.com';
$mail->FromName = $_POST['first_name'];
$mail->addAddress($email_to);

$mail->isHTML(true);

$mail->Subject = $subject;
$mail->Body    = $message;
			 if($mail->send())
				 { ?> <script lang="text/javascript">
		            alert("Your request mail has been sent");</script>
			<?php	
				 }
				else
				{ ?> <script lang="text/javascript">
			alert("Your Request hasn't been sent");
				</script>
          
			<?php
	
				}
	}
	
}
?>