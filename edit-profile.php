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

	
	 if(isset($_POST['editprofile'])){
		 
		 
		 	 $msgg=array();
	 $mblen=strlen($_POST['mobile']);
	 
	 
	 if(empty($_POST['PIndus'])||empty($_POST['country'])||empty($_POST['state'])||empty($_POST['loc'])||empty($_POST['pincode'])||empty($_POST['mobile'])||empty($_POST['emp-strength'])||empty($_POST['yearreg'])||empty($_POST['noofbranches'])||empty($_POST['registype'])||empty($_POST['ContactName']))
		 {
			 
			 $msgg[]="One of the field is empty plz check again";
			
			 
			 
		 }
  if($mblen<10)
			  {
				  $msgg[]="Mobile number must be 10 letters";
			  }
			   		  
			   if (!is_numeric($_POST['mobile'])) {
				   
				   $msgg[]="Phone Number can be Numerics only";
			   }
			 
			    if (!is_numeric($_POST['noofbranches'])) {
				   
				   $msgg[]="No of branches can be Numerics only";
			   }
			    if (!is_numeric($_POST['yearreg'])) {
				   
				   $msgg[]="Registration year can be Numerics only";
			   }
			   
			    if (!is_numeric($_POST['pincode'])) {
				   
				   $msgg[]="Pin code can be  Numerics only";
			   }
			 
    $is_alpha_space = ctype_alpha(str_replace(' ', '', $_POST['ContactName']));

	if (!($is_alpha_space)) {
        $msgg[]="Contact name can be  Alphabets only";
    } 
		 
		 if(!empty($msgg))
  { ?><script language="javascript">alert("<?php  foreach($msgg as $k) {echo $k.'\\n'; }?>");
		history.go(-1);
		</script>
		<?php 
  }
				else
				{
					if($row['status']==1){
		  $user_update_query="Update tbll_emplyer SET
emp_email='".$_POST['email']."',companyname='".$_POST['CompName']."',industry_type='".$_POST['PIndus']."',address1='".$_POST['address1']."',
country_id='".$_POST['country']."',state_id='".$_POST['state']."',loc_id='".$_POST['loc']."',pincode='".$_POST['pincode']."',
contact_num='".$_POST['mobile']."',designation='".$_POST['designation']."',EmployerStrength='".$_POST['emp-strength']."',OfficeNo='".$_POST['']."',
CompanyUrl='".$_POST['csite']."',YoR='".$_POST['yearreg']."',NoOfBranch='".$_POST['noofbranches']."',ToR='".$_POST['registype']."',status='2'
WHERE emp_id='".$row['emp_id']."'";
$description="Employer completed 100%";
$insert_query = "INSERT into tbl_notifications SET description='".$description."',job_owner_id='".$row['emp_id']."',notification_to='1',notification_from='".$row['emp_id']."',mode='admin'"; 
				$rr1 = mysqli_query($con,$insert_query);
				
				
			
				$subject="Employer completed 100%";
				$subject1="Thanks for Registering as an employer with NeedyIn";
				$emp_email=$_POST['email'];
										$nt_message="<table width='600' border='0' cellspacing='0' cellpadding='0' style='font-family:arial; margin:0 auto;'>
       
        <tr height='43px'>
                <td align='left' width='400px;' >
                        <a href=".$siteurl." target='_blank'><img src='".$siteurl."img/logo.png' width='198'></a>
                </td>
                <td align='right' width='300'>
                    <table>
                        <tr height='70'>
                            <td align='center' style='padding-right:10px;'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."about-us.php' target='_blank'>About Us</a> |</td>
                            <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."contact.php.php' target='_blank'>Contact</a> |</td>
                           
                           
                        </tr>
                    </table>
                </td>
        </tr>
         <tr>
                <td colspan='2' style='background:#90bd14;' align='center'>
                    <p style='font-size:15px; line-height:20px; color:#fff; padding:5px ; text-align: justify;'>Dear Admin ,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A new profile is identified with name called ".$_POST['CompName']." and Email id is ".$_POST['email'].". </p>
                </td>
        </tr>
        <tr>
                <td style='height:15px;'>
                </td>
        </tr>
        <tr height='320'>
                <td colspan='2'   style='background:url(".$siteurl."img/notif.png) no-repeat center 0;background-size: 560px 310px; height:320px;'>
             
                        <table style='margin-bottom: 185px; width: 400px; margin-left: 60px;'>
                        <tr >
                            <td align='center'>
                            <p style='padding-right:10px;font-size:14px; color:white; text-decoration:none;width:120px; '>I heard about needyin from my friend and registered in the portal two weeks back. </p></td>
                        </tr>
                    </table>
</div>						
				</td>
		</tr>		
				
     
            
        <tr>
            <td height='10' colspan='2' align='center'>
               <p style='font-size:15px; line-height:22px; color:#333; padding:0 10px; margin:0;'></p>
            </td>
        </tr>
  
        
        </tr>
    </table>";
	
							$nt_message1="<table width='600' border='0' cellspacing='0' cellpadding='0' style='font-family:arial; margin:0 auto;'>
       
        <tr height='43px'>
                <td align='left' width='400px;' >
                        <a href=".$siteurl." target='_blank'><img src='".$siteurl."img/logo.png' width='198'></a>
                </td>
                <td align='right' width='300'>
                    <table>
                        <tr height='70'>
                            <td align='center' style='padding-right:10px;'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."about-us.php' target='_blank'>About Us</a> |</td>
                            <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."contact.php.php' target='_blank'>Contact</a> |</td>
                           
                           
                        </tr>
                    </table>
                </td>
        </tr>

         <tr>
                <td colspan='2' style='background:#90bd14;' align='center'>
                    <p style='font-size:15px; line-height:20px; color:#fff; padding:5px ; text-align: justify;'>Dear Employer ,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A new profile is identified with name called ".$_POST['CompName']." and Email id is ".$_POST['email'].". </p>
                 <p style='font-size:15px; line-height:20px; color:#fff; padding:5px ; text-align: justify;'>Please note: <br/>
1.	Your service will be processed within 2 working days after successful validation from our end. <br/>
2.	You can continue to explore the features of our NeedyIn services with job postings.<br/>
3.	However, the visibility of job posts will be available to the job seekers as per the agreed SLAs only after curated by Team NeedyIn </p>
				</td>
        </tr>
        <tr>
                <td style='height:15px;'>
                </td>
        </tr>
        <tr height='320'>
                <td colspan='2'   style='background:url(".$siteurl."img/notif.png) no-repeat center 0;background-size: 560px 310px; height:320px;'>
             
                        <table style='margin-bottom: 185px; width: 400px; margin-left: 60px;'>
                        <tr >
                            <td align='center'>
                            <p style='padding-right:10px;font-size:14px; color:white; text-decoration:none;width:120px; '>I heard about needyin from my friend and registered in the portal two weeks back. </p></td>
                        </tr>
                    </table>
</div>						
				</td>
		</tr>		
				
     
            
        <tr>
            <td height='10' colspan='2' align='center'>
               <p style='font-size:15px; line-height:22px; color:#333; padding:0 10px; margin:0;'></p>
            </td>
        </tr>
  
        
        </tr>
    </table>";
	$admin_email="dvln.rao@needyin.com";

				$mm=$user_home->send_mail2($admin_email,$nt_message,$subject);
				$mm1=$user_home->send_mail2($emp_email,$nt_message1,$subject);
	
					}else{
						 $user_update_query="Update tbll_emplyer SET
emp_email='".$_POST['email']."',companyname='".$_POST['CompName']."',industry_type='".$_POST['PIndus']."',address1='".$_POST['address1']."',
country_id='".$_POST['country']."',state_id='".$_POST['state']."',loc_id='".$_POST['loc']."',pincode='".$_POST['pincode']."',
contact_num='".$_POST['mobile']."',designation='".$_POST['designation']."',EmployerStrength='".$_POST['emp-strength']."',OfficeNo='".$_POST['']."',
CompanyUrl='".$_POST['csite']."',YoR='".$_POST['yearreg']."',NoOfBranch='".$_POST['noofbranches']."',ToR='".$_POST['registype']."' WHERE emp_id='".$row['emp_id']."'";
					}
				 $rr= mysqli_query($con,$user_update_query);
					 // to add the SA status date to the table tbl_emp_admin_updts
				 $eau="update tbl_emp_admin_updts SET 2_updts='NOW()' where emp_id=".$row['emp_id'];
			$eau_res=mysqli_query($con,$eau);
				 $insert_jexp1 ="INSERT INTO tbl_recent_views SET userid='',Action='Updated',Activity='Updated My Profile',Reference='',empid='".$row['emp_id']."',Ipaddress='".$_SERVER['REMOTE_ADDR']."'";
$rr= mysqli_query($con,$insert_jexp1);				
				if($rr!=0)
					{?>
			<script type="text/javascript" src="js/objectFitPolyfill.min.js"></script>
		<script>
		alert("Successfully Updated Records"); 
		window.location.href = "view-profile-recruiter.php";
		</script>
				
					<?php  }
			  
	 }		}
		if(isset($_POST['Savelogo'])){
			 $_FILES['logo']['name'];
			if($_FILES['logo']['name']) {
				$ext=substr(strrchr($_FILES['logo']['name'],"."),1);		
		$ext=strtolower($ext);
		if($ext=="jpg" || $ext=="jpeg" || $ext=="gif" || $ext=="png") {						
			$tiny_image="Upload/Employerpics/logo".$row['emp_id'].".".$ext;
			move_uploaded_file($_FILES['logo']['tmp_name'], $tiny_image);   
		
		 $update_logos =	("UPDATE tbll_emplyer SET ePhoto='".$tiny_image."' WHERE emp_id=".(int)$row['emp_id']);  
		$usl= mysqli_query($con,$update_logos);
		if($usl!=0)
		{?>		<script>alert("Profile Picture Successfully Updated");window.location.href = "edit-profile-recruiter.php";</script>
		<?php  }
		}
	} 	
				
			}
			if(isset($_POST['Saveclogo'])){
			
			if($_FILES['clogo']['name']) {
				$ext=substr(strrchr($_FILES['clogo']['name'],"."),1);		
		$ext=strtolower($ext);
		if($ext=="jpg" || $ext=="jpeg" || $ext=="gif" || $ext=="png") {						
			$tiny_image="Upload/Employerpics/clogo".$row['emp_id'].".".$ext;
			move_uploaded_file($_FILES['clogo']['tmp_name'], $tiny_image);   
		
		 $update_logo =	("UPDATE tbll_emplyer SET eLogo='".$tiny_image."' WHERE emp_id=".(int)$row['emp_id']);  
		$ul= mysqli_query($con,$update_logo);
		if($ul!=0)
		{?>		<script>alert("Logo successfully Updated");window.location.href = "edit-profile-recruiter.php";</script>
		<?php  }
		}
	} 	
				
			}
if(isset($_POST['removepic']))
		{
	if($row['ePhoto'] !="")
			{
			$remove_pic =	("Update tbll_emplyer Set ePhoto=NULL   WHERE emp_id=".(int)$row['emp_id']);  
		    $rl= mysqli_query($con,$remove_pic);
			if($rl == 0)
		{?>		<script>alert("Profile Pic is not Removed");window.location.href = "edit-profile-recruiter.php";</script>
		<?php  }
		
			else
				
			{?>		<script>alert("Profile Picture is removed");window.location.href = "edit-profile-recruiter.php";</script>
		<?php  }
		}else{
			?><script>alert("Profile Picture is not available");window.location.href = "edit-profile-recruiter.php";</script><?php
		}
		}
		if(isset($_POST['removelogo']))
		{
			if($row['eLogo'] !="")
			{
			$remove_logo =	("Update tbll_emplyer Set eLogo=NULL   WHERE emp_id=".(int)$row['emp_id']);  
		    $rl= mysqli_query($con,$remove_logo);
			if($rl == 0)
		{?>		<script>alert("Profile Pic is not Removed");window.location.href = "edit-profile-recruiter.php";</script>
		<?php  }
		
			else
				
			{?>		<script>alert("Profile Picture is removed");window.location.href = "edit-profile-recruiter.php";</script>
		<?php  }
				}else{
			?><script>alert("Company Logo is not available");window.location.href = "edit-profile-recruiter.php";</script><?php
		}
		}
 ?>
 