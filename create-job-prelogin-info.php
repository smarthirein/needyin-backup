<?php
session_start();
require_once("config.php");
require_once 'class.user.php';
$user_home = new USER();
    if(isset($_POST['btn-CreateJob']))
	{ 

				
			    $JobName=$_POST['PJobName'];
				$Skills = implode(",",$_POST['PSkills']);						
				$PAward = implode(",",$_POST['PAward']);							
				$PLang = implode(",",$_POST['PLang']);							
				$PVisa = implode(",",$_POST['PVisa']);		
				$code = md5(uniqid(rand()));
                $PLoc=$_POST['PLoc'];	
				$PMinE=$_POST['PMinE'];
				$PMaxE=$_POST['PMaxE'];
				$PSal=$_POST['PSal']; 
				$PCompname=$_POST['PCompname'];
				$PCompurl=$_POST['PCompurl'];
				$PJobdesc=$_POST['PJobdesc'];
				$PEduc=$_POST['PEduc'];
				$PSpeca=$_POST['PSpeca'];
				$PUniver=$_POST['PUniver'];
				$PIndus=$_POST['PIndus'];				
				$PFunct=$_POST['PFunct'];
				$PAchive=$_POST['PAchive'];								
				$PCitizen=$_POST['PCitizen'];				
	            $Pperm=$_POST['Pperm'];				
				$PFull=$_POST['PFull'];
				$Gender=$_POST['Gender'];				
				$wtt=$_POST['wtt'];
				$Passport=$_POST['Passport'];	
			    $recName=$_POST['recName'];
				 $address=$_POST['address'];
				  $cnumber=$_POST['cnumber'];
				   $email=$_POST['emailName'];
				   				$msgg=array();
				$desclen=strlen($PJobdesc);
				
				if(empty($JobName))
		 {
			 
			 $msgg[]="please fill Job Name";
			 
		 }
		 else if(empty($PMinE))
			  {
			 
			 $msgg[]="please select Min Exp";
			 
		 }
		 else if(empty($PMaxE))
			  {
			 
			 $msgg[]="please select Max Exp";
			 
		 } else if(empty($PSal))
			  {
			 
			 $msgg[]="please select Salary";
			 
		 }
		 else if(empty($PCompname))
			  {
			 
			 $msgg[]="please fill company name";
			 
		 }else if(empty($PJobdesc))
			  {
			 
			 $msgg[]="please fill job desc ";
			 
		 }
		 else if(empty($PEduc))
			  {
			 
			 $msgg[]="please select education";
			 
		 }
		 else if(empty($PSpeca))
			  {
			 
			 $msgg[]="please select specialization";
			 
		 }
		 else if(empty($PUniver))
			  {
			 
			 $msgg[]="please select university";
			 
		 }
		 else if(empty($PIndus))
			  {
			 
			 $msgg[]="please select industry type";
			 
		 }
		 else if(empty($PFunct))
			  {
			 
			 $msgg[]="please select functional area";
			 
		 }
		 else if(empty($Gender))
			  {
			 
			 $msgg[]="please select Gender";
			 
		 }
		 else if(empty($Pperm))
			  {
			 
			 $msgg[]="please select Job type";
			 
		 }
		 
		 else if(empty($recName))
			  {
			 
			 $msgg[]="please select Recruiter Name";
			 
		 }else if(empty($address))
			  {
			 
			 $msgg[]="please give your address";
			 
		 }else if(empty($cnumber))
			  {
			 
			 $msgg[]="please give your contact number";
			 
		 }else if(empty($email))
			  {
			 
			 $msgg[]="please give your email";
			 
		 }
		  
			   $sql="SELECT  * FROM `tbll_emplyer` WHERE emp_email='$email' or contact_num='$cnumber'";
				$sqlres=mysqli_query($con,$sql);
				$numrows=mysqli_num_rows($sqlres);
				if($numrows>0)
				{
					 $msgg[]="This email already exists please login and post job";
					
				}
			   if($desclen<250)
			   {
				   
				   $msgg[]="Job description Must be at least 250 characters, you have entered $desclen characters";
			   }
			   $is_alpha_space = ctype_alpha(str_replace(' ', '', $JobName));
	if (!($is_alpha_space))
	{
        $msgg[]="Job Name can be  Alphabets only";
    }
	if(empty($Skills))
	{
		$msgg[]="Please Select at least one skill required";
	}
	if(empty($PCitizen))
	{
		$msgg[]="Please Select at least one Citizenship required";
	}
	
	 $PCompname_space = ctype_alpha(str_replace(' ', '', $PCompname));
	if (!($PCompname_space))
		{
			
        $msgg[]="company name can be  Alphabets only";
    }
	if($PMinE>$PMaxE)
	{
		
		$msgg[]="Minmum Experience can't be more than Max Experience , please check";
	}
	if(!empty($PCompurl))
	{
		if (!filter_var($PCompurl, FILTER_VALIDATE_URL) === false) {
			echo(" ");
		} else {
			$msgg[]="Please Enter Valid URL";
		}
		
	}
				if(!empty($msgg))
  {?><script language="javascript">alert("<?php  foreach($msgg as $k) {echo $k.'\\n'; }?>");
		history.go(-1);
		</script>
		<?php 
			
				  
		 }
		 else 
		 {
				
				

				$characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
				$password = '';
				$max = strlen($characters) - 1;
				for ($i = 0; $i < 5; $i++) {
				$password .= $characters[mt_rand(0, $max)];
				}
								
				$pass=$password;				
			  $createAccount="INSERT INTO tbll_emplyer(emp_email,emp_password,contact_name,contact_num,address1,emp_code) Values('$email','$pass','$recName','$cnumber','$address','$code')";
				$create_Account= mysqli_query($con,$createAccount);
		    	$emp_id = mysqli_insert_id($con);	
				
			  $create_job = "INSERT INTO tbl_jobposted SET 
				Job_Name='".$JobName."',
				Job_Skill='".$Skills."',
				Loc_Id='".$PLoc."',
				Min_Exp='".$PMinE."',
				Max_Exp='".$PMaxE."',
				Comp_Name='".$PCompname."',
				Comp_Url='".$PCompurl."',
				Job_Desc='".$PJobdesc."',
				PEduc_Id='".$PEduc."',
				PSpeci_Id='".$PSpeca."',
				PUniver_Id='".$PUniver."',
				PIndus_Id='".$PIndus."',	 
				PFunc_Id='".$PFunct."',
				PAchive='".$PAchive."',
				PAward='".$PAward."',
				PLang='".$PLang."',
				Pcitizenship='".$PCitizen."',				 
			    PJobtype='".$Pperm."',
				PEmploytype='".$PFull."',
				Sal_Range='".$PSal."',
				PGender='".$Gender."',
				PVisaCtry='".$PVisa."',				 
			    PWillingtotravel='".$wtt."',
				PPassport='".$Passport."',	
				emp_id='".$emp_id."' ";	
				$createJob= mysqli_query($con,$create_job);
								if($createJob!=0)
									{	
														$id = $emp_id;		
														$key = base64_encode($id);
														$id = $key;
								
								   $message .= "Hello ".$recName."<br/>";
 
                          $message .= "Welcome to Needyin !<br /><br />";
                          $message .= "To complete your registration  please , just click following link !<br /><br />";
                           $message .= "<a href=".$GLOBALS['siteurl']."verify.php?id=".$id."&code=".$code.">Click HERE to Activate </a><br /><br />";
                          $message .= "Thanks,";
						
			$subject = "Confirm Registration";
			
												
												
											 $user_home->send_mail($email,$message,$subject);
												$msg = "
													<div class='alert alert-success'>
														<button class='close' data-dismiss='alert'>&times;</button>
														<strong>Success!</strong>  We've sent an email to $email.
													Please click on the confirmation link in the email to create your account. 
													</div>
													";		
												?> 
												<script>alert("successfully updated Records");window.location.href = "index-recruiter.php";</script>";		
												<?php																																				
												}
												else 
												{
												echo "sorry , Query could no execute...";
												}												
	}}
	?>
			

      