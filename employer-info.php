<?php 
session_start();
require_once("config.php");
require_once 'class.user.php';
require_once 'dbconfig.php';
require_once'mail/PHPMailer/PHPMailerAutoload.php';



			 
 if(isset($_POST['Empinfo'])){		
			
			$email=$_POST['email'];
				$comname=$_POST['comname'];
				$password=md5($_POST['password']);
				$cpassword=md5($_POST['cpassword']);
				$code = md5(uniqid(rand()));
				$ctype=$_POST['ctype'];
				$industry_type=$_POST['industry_type'];
				$address1=$_POST['address1'];
				
				$country=$_POST['country'];
				$state=$_POST['state'];
				$location=$_POST['city'];
				$pincode=$_POST['pincode'];
				$cnumbers=$_POST['cnumber'];
				$cname=$_POST['cname'];
				$terms=$_POST['terms'];
				
				$cin=$_POST['cin'];
				$mblen=strlen($cnumbers);
				$msgg=array();
				
	 	$checkemailsql="SELECT * FROM `tbll_emplyer` WHERE `emp_email`='$email' OR 	contact_num='$cnumbers'";
		$checkemailsqlres=mysqli_query($con,$checkemailsql);
		$check_js="SELECT * FROM tbl_jobseeker WHERE JEmail='$email' OR JPhone='$cnumbers'";
		$check_sql=mysqli_query($con,$check_js);
		if(mysqli_num_rows($check_sql)>0)
		{
			$msgg[] = "Sorry !  email or phone number already exists registered as jobseeker, Please check";
		}
		
		if(empty($_FILES['roc']['name']) && $cin=="")
		{

		$msgg[]="Please upload ROC file or enter cin ";
		}	
		
		 if($password!=$cpassword)
		 {
			 $msgg[]="Passwords aren't matching";
		 }
		
		 if(empty($terms))
		 {
			 $msgg[]="Please accept our terms and conditions";
		 }
	  if($mblen<10)
			  {
				  $msgg[]="Mobile number must be 10 letters";
			  }
			   
			  	 
			 if(!filter_var($email, FILTER_VALIDATE_EMAIL))
			  {
				  $msgg[]="Enter Valid Email";
			  }
			   $checkemailsql="SELECT * FROM `tbll_emplyer` WHERE `emp_email`='$email' OR 	contact_num='$cnumbers'";
			   $checkemailsqlres=mysqli_query($con,$checkemailsql);
			   
		  if(mysqli_num_rows($checkemailsqlres)>0)
		{
		$msgg[] = "Sorry !  email or phone number already exists , Please check";
		}
		
	 		if(!empty($msgg))
  {		?>	<script language='javascript'>
		<?php	foreach($msgg as $k)
		  {?>
		  alert("<?php echo	$k."\\n";?>");
		  <?php
			 
		  }?>
		  history.go(-1);
			</script>
	<?php		
				  
		 }
	  else
		 {
				 $insert_edu = "INSERT INTO tbll_emplyer SET emp_email='$email',emp_password='$password',companyname='$comname',company_cin='$cin',company_type='$ctype',industry_type='$industry_type',address1='$address1',address2='$address2.',country_id='$country',state_id='$state',loc_id='$location',pincode='$pincode',contact_num='$cnumbers',contact_name='$cname',terms='$terms',emp_code='$code'";
				
					$edu= mysqli_query($con,$insert_edu);
					$empid=mysqli_insert_id($con);
		  $insert_emp="INSERT INTO tbl_users SET User_Email='".$email."', User_Password='$password', User_Type='Employer', User_Tokencode='$code', User_Status='N'";
				$insert_emp_res=mysqli_query($con2,$insert_emp);
				$empid_phase2=mysqli_insert_id($con2);

				$insert_comp_details="INSERT INTO tbl_emp_cmpny_details SET Ecmd_Cmpny_Id='$empid_phase2', Ecmd_Cmpny_Name='$comname', Ecmd_Cmpny_Type='$ctype', Ecmd_Cmpny_Phone_No='$cnumbers', Ecmd_Industry='$industry_type'";
				$insert_comp_res=mysqli_query($con2,$insert_comp_details);
				
				$insert_cont_details="INSERT INTO tbl_emp_persnl_details SET Eprd_User_id='$empid_phase2', Eprd_Pincode='$pincode', Eprd_Contact_Name='$cname', Eprd_Contact_No='$cnumbers'";
				$insert_cont_res=mysqli_query($con2,$insert_cont_details);
				
		  // to add the inactive status date to the table tbl_emp_admin_updts
					$updt_edu = "INSERT INTO tbl_emp_admin_updts SET 0_updts='NOW()',emp_id='$empid'";				
					$updu= mysqli_query($con,$updt_edu);
					$description="New Employer Registered";					
				$insert_query = "INSERT into tbl_notifications SET description='".$description."',job_owner_id='".$empid."',notification_to='1',notification_from='".$empid."',mode='admin'"; 
				$rr1 = mysqli_query($con,$insert_query);
					if($_FILES['roc']['name']) {
						
				$ext=substr(strrchr($_FILES['roc']['name'],"."),1);		
		$ext=strtolower($ext);
		if($ext=="jpg" || $ext=="jpeg" || $ext=="gif" || $ext=="png"|| $ext=="pdf") {				
		$tiny_image="Upload/Roc/".$_FILES['roc']['name']; 
		$new_name="Upload/Roc/roc_".(int)$empid.".".$ext;
		rename($tiny_image,$new_name);
			move_uploaded_file($_FILES['roc']['tmp_name'], $new_name);   
		
		$update_logo =	"UPDATE tbll_emplyer SET roc='".$new_name."' WHERE emp_id=".(int)$empid;  
		
		$ul= mysqli_query($con,$update_logo);
		
		
		}
					}
					
		  if($edu!=0)
					{
					$retrieveid="SELECT * FROM `tbll_emplyer` WHERE `emp_email`='$email'";
						$retrieveidres=mysqli_query($con,$retrieveid);
						$retrieveidrow=mysqli_fetch_array($retrieveidres);
						$id=$retrieveidrow['emp_id'];
			  			$uname=$retrieveidrow['companyname'];
						$email_to = $email;
						$siteurl="http://needyin.com"; 

						$key = base64_encode($id);
			  			  $id = $key;
			  $uname= ucfirst($uname);
			  $em_name=base64_encode($uname);
			  $em_id=base64_encode($id);
			  $js_code=base64_encode($code);
			  	

							$email_subject = "Welcome to NeedyIn!";
							$email_from ="support@needyin.com";
						 
			  
			  $message .="<table width='600' border='0' cellspacing='0' cellpadding='0' style='font-family:arial; margin:0 auto;'>
                             <tr height='43px'>
						            <td align='left' width='400px;' >
						                    <a href='".$siteurl."' target='_blank'><img src='".$siteurl."/img/logo.png' width='198'></a>
						               
						            </td>
						            <td align='right' width='300px;'>
						                <table>
						                    <tr height='70'>
						                        <td align='center' style='padding-right:10px;'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/about_us.php' target='_blank'>About Us</a> |</td>
						                        <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/contact.php' target='_blank'>Contact</a> |
						                        </td>
												 <td align='center'> 
												 <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/emp_register.php?&emn=".$em_name."&emi=".$em_id."&emc=".$em_code."' target='_blank'>View in web</a> </td>
						                    </tr>
						                </table>
						            </td>
       						 </tr>
        					 <tr>
								            <td colspan='2' style='background:url(".$siteurl."/img/thankyou_img.png) no-repeat center 0; height:335px;' >
								              <div style='padding: 15px; text-align: justify; margin-left: 311px; margin-top: 16px; width: 175px;font-size: 13px; padding-left: 10px;'>
								                   Dear ".$uname.",<br><br>
								              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Thank you for registering with us. Before you begin with needyin.com we request you to confirm your official registered e-mail address as it will improve the account security. 
								              </div>
								              
								            </td>
       						 </tr>
					        <tr>
					            <td colspan='2' style='background:#90bd14;' align='center'>
					                <p style='font-size:15px; line-height:25px; color:#fff; padding:10px 0; margin:0;'>To complete your registration process, please click on the below link to validate your account.</p>
					                <p style='font-size:20px; font-weight:bold; color:#fff; margin:0; padding-bottom:15px;  margin:0;'><a href=".$siteurl."/verify-recruiter.php?key=".$key."&code=".$code.">Click here to validate </a></p>
					            </td>
					        </tr>
					        <tr>
					            <td height='10' colspan='2' align='center'>
					                <!--<p style='font-size:15px; line-height:22px; color:#333; padding:0 10px; margin:0;'></p>-->
					            </td>
					        </tr>
					        <tr>
					            <td colspan='2' style='background:#0274bb;' align='center'>
					                <p style='font-size:13px; line-height:16px; color:#fff; '>You have received this mail because your e-mail ID is registered with Needyin.com. This is a system-generated e-mail regarding your Needyin account preferences, please don't reply to this message.</p>
					            </td>
					        </tr>
    
	</table>";	  
	
						$mail = new PHPMailer;
                       
						$mail->IsSMTP();
						

						$mail->Host = 'mail.webmailcommunications.com';
						$mail->SMTPAuth = true;
						$mail->Username = 'support@needyin.com';
						$mail->Password = 'Support@123';
						$mail->SMTPSecure = 'tls';

						$mail->From = $email_from;
						$mail->FromName = 'Needyin';
						$mail->addAddress($email_to);

						$mail->isHTML(true);

						$mail->Subject = $email_subject;
						$mail->Body    = $message;

	

						 if($mail->send())
						 {
						?>
						 
					
						 		<script lang="javascript">
								alert("successfully Registered.An email has been sent to your account please verify");													
								window.location="index-recruiter.php";
								</script>
						<?php
						}
						else
	{
						 	?>
								<script lang="javascript">
								alert("Sorry Mail Not Sent,Please Try once again");
								
								
					 window.location="index-recruiter.php";</script>
<?php
}
		 }
	} 	
 }

			
 ?>