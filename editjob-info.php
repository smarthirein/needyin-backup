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
if(isset($_REQUEST['jobId'])){
        if(isset($_POST['updateJobBtn'])){
				$JobName=$_POST['PJobName'];				
				$Skills = implode(",",$_POST['PSkills']);
				$PAward = implode(",",$_POST['PAward']);			
				$PLang = implode(",",$_POST['PLang']);
				$PVisa = implode(",",$_POST['PVisa']);		
				$PLoc=$_POST['PLoc'];
				$PMinE=$_POST['PMinE'];
				$PMaxE=$_POST['PMaxE'];
				$PSal=$_POST['PSal'];
				$PCompname=$_POST['PCompname'];
				$PCompurl=$_POST['PCompurl'];
				$PJobdesc = htmlspecialchars($_POST['PJobdesc'], ENT_QUOTES);
			  
				$PEduc=$_POST['PEduc'];
				$PSpeca=$_POST['PSpeca'];
				$PUniver=$_POST['PUniver'];
				$PIndus=$_POST['PIndus'];				
				$PFunct=$_POST['PFunct'];
				$PAchive=$_POST['PAchive'];								
				$PCitizen=$_POST['PCitizen'];				
	          
				$Gender=$_POST['Gender'];
				$MPSal=$_POST['MPSal'];
				$jobcreation=$_POST['jobcreation'];
				$jobclosed=$_POST['jobclosed'];
				$wtt=$_POST['wtt'];
				$Passport=$_POST['Passport'];	
				$msgg=array();
				$desclen=strlen($PJobdesc);			
				$job_cat=$_POST['job_category'];				
				$filurl=filter_var($_POST['PCompurl'], FILTER_SANITIZE_URL);			
			if(empty($JobName))
		 {		 
			 $msgg[]="Please fill Job Name";			
		 }
		 else if(empty($PMinE))
			  {			 
			 $msgg[]="Please Select Min Exp";			 
		 }
		 else if(empty($PMaxE))
			  {			 
			 $msgg[]="Please Select Max Exp";			 
		 } else if(empty($PSal))
			  {			 
			 $msgg[]="Please Select Salary";			 
		 }
		else if(empty($PJobdesc))
			  {			 
			 $msgg[]="Please fill Job Description ";			 
		 }
		 
			   $is_alpha_space = ctype_alpha(str_replace(' ', '', $JobName));
	
				if($PMinE>$PMaxE)
				{
					
					$msgg[]="Minmum Experience can't be more than Max Experience , please check";
				}
			
							if(!empty($msgg))
  {?><script language="javascript">alert("<?php  foreach($msgg as $k) {echo $k.'\\n'; }?>");
		history.go(-1);
		</script>
		<?php  
		 }		
			else
			{	
 $jobskills="select Job_Skill from tbl_jobposted where emp_id='".$row['emp_id']."' and Job_Id='".$_REQUEST['jobId']."'";
 $jobskills2 = mysqli_query($con,$jobskills);  
					                  while($job_skill=mysqli_fetch_array($jobskills2))
					                  {
						                $skillids[]=$job_skill['Job_Skill'];
					                  }
									 $p_skills= implode(",",$skillids);
									 $prev_skills=explode(",",$p_skills);
								
                                     $sks=explode(",",$Skills);
								
						foreach($sks as $v) 
						{ 
						    if (!in_array($v, $prev_skills)) 
						    { 
						        $add_skills[]=$v;
						    } 
						}  
				$added_skills=implode(",",$add_skills);
				if($added_skills!="")
				{
			 	$updated_skills=$p_skills.",".$added_skills;
			     } else {
			      	$updated_skills=$p_skills;
			     } 
				$EditJob = "UPDATE tbl_jobposted SET 
				Job_Skill='".$updated_skills."',				
				Min_Exp='".$PMinE."',
				Max_Exp='".$PMaxE."',
				Sal_Range='".$PSal."',
				MSal_Range='".$MPSal."',
				jobcreation='".$jobcreation."',
				jobclosed='".$jobclosed."',
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
				PGender='".$Gender."',
				PVisaCtry='".$PVisa."',				 
			    PWillingtotravel='".$wtt."',
				PPassport='".$Passport."',
				notshow_jobseeker='".$notshow."',
				category_id='".$job_cat."',				
				emp_id='".$row['emp_id']."'				
				WHERE Job_Id = '".$_REQUEST['jobId']."'				
				";		
				$EditJob= mysqli_query($con,$EditJob);
				$job_id = $_REQUEST['jobId'];				
				if($EditJob !=0)
				{
					$Skills1=$_POST['PSkills'];
					
					foreach($Skills1 as $skill)
		                    {
								 $cj2="select JUser_Id,Job_Skills from tbl_jobseeker where JPLoc_Id='".$PLoc."' and  FIND_IN_SET('".$skill."', Job_Skills) "; 
				                  $resultcj2 = mysqli_query($con,$cj2);  
					                  while($result_cj2=mysqli_fetch_array($resultcj2))
					                  {
						                  $user_ids[]=$result_cj2['JUser_Id'];
						                  $skillids[]=$result_cj2['Job_Skills'];
					                  }
		            		 } 
                             $userids=array_filter(array_unique($user_ids));     
                             $u_cnt=count($userids); 
                              
                                if($u_cnt!='0')
                                {  
									foreach($userids as $user)
									{
                                       $sal_qq="select ExpSalL,JUser_Id from tbl_currentexperience where JUser_Id='".$user."'"; 
										$sal_res=mysqli_query($con,$sal_qq);
										$sal_data=mysqli_fetch_array($sal_res);
										$sdata_cnt=mysqli_num_rows($sal_res);
										if($sdata_cnt!='0')
                                         {

										 $cj3="select emp_id from tbl_jobposted where Job_Id='".$job_id."'"; 
										 $resultcj3 = mysqli_query($con,$cj3);  
										 $result_cj3=mysqli_fetch_array($resultcj3); 
										 $description="Please check it is maching to yours skills";
										 $insert_query = "INSERT into tbl_notifications SET  job_id='".$job_id."',description='".$description."',job_owner_id='".$result_cj3['emp_id']."',profile_id='".$user."',notification_to='".$user."',notification_from='".$job_id."',mode='employer'";
										 $rr1 = mysqli_query($con,$insert_query);
										 $jb_seeker="select JEmail,JFullName from tbl_jobseeker where '".$user."' and jdndstatus='0'";
							             $jb_res=mysqli_query($con,$jb_seeker);
							             $jb_data=mysqli_fetch_array($jb_res);
										 $jb_email=$jb_data['JEmail'];
										 
										  $cj4="select Desig_Name from  tbl_desigination where Desig_Id=".$result_cj3['JobName'] ;  
										   $resultcj4 = mysqli_query($con,$cj3);  
										   $result_cj4=mysqli_fetch_array($resultcj3);

										   $jsname=base64_encode($jb_data['JFullName']);
										   $jobname=base64_encode($result_cj4['Desig_Name']);
										   $cmpname=base64_encode($result_cj3['Comp_Name']);
							             $subject="Job is updated in Needyin";
										 
										 $nt_message="<table width='600' border='0' cellspacing='0' cellpadding='0' style='font-family:arial; margin:0 auto;'>
       
        <tr height='43px'>
                <td align='left' width='400px;' >
                        <a href=".$siteurl." target='_blank'><img src='".$siteurl."/img/logo.png' width='198'></a>
                </td>
                <td align='right' width='300'>
                    <table>
                        <tr height='70'>
                            <td align='center' style='padding-right:10px;'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/about_us.php' target='_blank'>About Us</a> |</td>
                            <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/contact.php' target='_blank'>Contact</a> |</td>
                            <td align='center'> <a style='font-size:14px; color:#333333; text-decoration:none; font-family:arial;' href='".$siteurl."/crjb_notif.php?jsname=".$jsname."&jobname=".$jobname."&cmpname=".$cmpname."' target='_blank'>View in web</a> </td>
                           
                        </tr>
                    </table>
                </td>
        </tr>
         <tr>
                <td colspan='2' style='background:#90bd14;' align='center'>
                    <p style='font-size:15px; line-height:20px; color:#fff; padding:5px ; text-align: justify;'>Dear ".$jb_data['JFullName'].",<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;We have identified one job posted matching you profile with your preferred criterias. </p>
                </td>
        </tr>
        <tr>
                <td style='height:15px;'>
                </td>
        </tr>
        <tr height='320'>
                <td colspan='2'   style='background:url(".$siteurl."/img/notif.png) no-repeat center 0;background-size: 560px 310px; height:320px;'>
             
                        <table style='margin-bottom: 185px; width: 400px; margin-left: 60px;'>
                        <tr >
                            <td align='center'>
                            <p style='padding-right:10px;font-size:14px; color:white; text-decoration:none;width:120px; '>One New job is posted match with your Profile. </p></td>


                            <td align='center'>
                            <p style='font-size:14px; margin-left: 45px; color:white;;width:120px; text-decoration:none;'> 
                            Job Name : ".$result_cj3['Desig_Name']."</br>
                            Company Name : ".$PCompname."
                            </p></td>

                            <td   align='center' ><p style='font-size:14px; color:white; ;width:120px;text-decoration:none;margin-left: 50px;'>To view job details please click on the link below</br><a href=".$siteurl.">NeedyIn </a></p></td>
                           
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
    <tr>
            <td colspan='2' style='background:#0274bb;' align='center'>
                <p style='font-size:13px; line-height:30px; color:#fff; '>You have received this mail because your e-mail ID is registered with Needyin.com. This is a system-generated e-mail regarding your Needyin account preferences, please dont reply to this message.</p>
            </td>
        </tr>
        
        </tr>
    </table>";                                      
											
							              
										  $headers  = 'MIME-Version: 1.0' . "\r\n";
										  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
							              $mm=  $user_home->send_mail2($jb_email,$message,$subject);
										   $nt_message=null;
                                         }
									    }
                                 }			 
				}
	?>
					<script>alert("Your job has been updated");window.location.href = "rec-jobs.php";</script>
				<?php 			
		}
			
}	}
?>
			

      