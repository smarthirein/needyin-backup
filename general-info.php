<?php 
session_start();
//require_once("config.php");
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
	$user_home->redirect('index.php');
}
$msg=array();


$stmt = $user_home->runQuery("SELECT * FROM tbl_jobseeker u
							  JOIN tbl_currentexperience cexp on u.JUser_Id=cexp.JUser_Id
							  WHERE u.JUser_Id=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);



if(isset($_POST['Savedinfo']))
{   $checkid=$_SESSION['userSession'];
	$alternolen=strlen($_POST['alter_no']);
	$moblen=strlen($_POST['JPhone']);
	$prof=trim($_POST['profile']);
	$locationid=$_POST['Cloc'];
	/******* starts   drop down for new industry and functional area **************/
	 $newindus=$_POST['newindus'];
	 $newfunc=$_POST['newfunc']; 
	if($_POST['newindus']!="" && $_POST['industry']=="Others") {
		$jindus="select * from tbl_industry where Indus_Name='".$newindus."'";
            $indus_res=mysqli_query($con,$jindus);
            $indus_data=mysqli_fetch_array($indus_res);
			if(mysqli_num_rows($indus_res)==1){		
				echo $indus=$indus_data['Indus_Id'];			
			}
			else{				
				$indus_query = "INSERT into tbl_industry SET  Indus_Name='".$newindus."'"; 
				$iq1 = mysqli_query($con,$indus_query);				
				$jindus1="select * from tbl_industry where Indus_Name='".$newindus."'";
				$indus_res1=mysqli_query($con,$jindus1);
				$indus_data1=mysqli_fetch_array($indus_res1);
				$indus=$indus_data1['Indus_Id'];
				
			}
	}else{
		$indus=$_POST['industry'];
	}
	if($_POST['newfunc']!="" && $_POST['functional_area']=="Others"){
			$jfunc="select * from tbl_functionalarea where Func_Name='".$newfunc."'";
            $func_res=mysqli_query($con,$jfunc);
            $func_data=mysqli_fetch_array($func_res);
			if(mysqli_num_rows($func_res)==1){		
				$func=$func_data['Func_Id'];
			}
			else{
				
			$func_query = "INSERT into tbl_functionalarea SET  Func_Name='".$newfunc."'";
				$fq1 = mysqli_query($con,$func_query);
				
				$jfunc1="select * from tbl_functionalarea where Func_Name='".$newfunc."'"; 
            $func_res1=mysqli_query($con,$jfunc1);
            $func_data1=mysqli_fetch_array($func_res1);
			 $func=$func_data1['Func_Id'];
				
			}
	}
	else{
		$func=$_POST['functional_area'];
	}
			
			/******* Ends  drop down for new industry and functional area **************/
		//echo "new industry".$newindus;exit;
	
		$proflen=strlen($prof);
		$sql = "SELECT * FROM tbl_currentexperience where Loc_Id='$locationid' AND JUser_Id='$checkid'";
		$query = mysqli_query($con, $sql);
  	//if(empty($_POST['full_name'])||empty($_POST['JPhone'])||empty($_POST['profile']) || empty($_POST['dob'])||empty($_POST['gender']))
		//$msg[]="One of the field is Empty please check /n ";
	
	if($moblen!=10)
		$msg[]="Please check mobile number";
	
	
	if($alternolen!=10)
		$msg[]="Please check alternative mobile number";
	if(mysqli_num_rows($query)>0)
	{
		$msg[]="Current Location can't be Preferred Location";
		
	}
	if(empty($_POST['Cloc']))
	{
		
		$msg[]="Please give Your Preferred Location";
		
	}
	
	
	if($proflen>250&&$proflen<100)
	$msg[]="Profile summary must be have atleast 100 and atmost 250 characters";
	
	
	
	if(empty($_POST['gender']))
		$msg[]="Please select you gender";
	
	
	
	if(empty($_POST['years'])&&empty($_POST['months']))
		$msg[]="Please Give Experience";
	
	/*if(empty($_POST['CSL'])&&empty($_POST['CST']))
		$msg[]="Please Give Current Salary";
	
	if(empty($_POST['ESL'])&&empty($_POST['EST']))
		$msg[]="Please Give  Expected Salary";*/
	
	
	
	if(!empty($msg))
	{
		
		?><script language="javascript">alert("<?php  foreach($msg as $k) {echo $k.'\\n'; }?>");
		history.go(-1);
		</script>
		<?php 
	}

else {

			$query1="select JPLoc_Id,Job_Skills from tbl_jobseeker where JUser_Id='".$row['JUser_Id']."' "; 
            $q_res1=mysqli_query($con,$query1);
            $q_data=mysqli_fetch_array($q_res1);
            $loc_id=$q_data['JPLoc_Id']; 

         //  $_POST['Cloc']; 
           $_POST['ESL']; 
 $_POST['EMSL'];
            $sal="select * from tbl_currentexperience where JUser_Id=".$row['JUser_Id'];
            $sal_res=mysqli_query($con,$sal);
            $sal_data=mysqli_fetch_array($sal_res);

            if($loc_id!=$_POST['Cloc'] || $sal_data['ExpSalL']!=$_POST['ESL'])
            {
            	$skills=explode(",",$q_data['Job_Skills']); 
            	//print_r($skills); exit;
		            	foreach($skills as $skill)
		               {
					      $cj2="select Job_Id,Job_Skill from tbl_jobposted where Loc_Id='".$_POST['Cloc']."' and Sal_Range<='".$_POST['ESL']."' and Job_Status='1' and  FIND_IN_SET('".$skill."', Job_Skill) ";   
		           
		                  $resultcj2 = mysqli_query($con,$cj2);  
		                  while($result_cj2=mysqli_fetch_array($resultcj2))
		                  {
		                         $job_ids[]=$result_cj2['Job_Id'];
		                         $skillids[]=$result_cj2['Job_Skill'];
		                  }

		               } 
		              // print_r($job_ids); exit;
		                   $jobs=array_unique($job_ids);

							foreach($jobs as $job)
							{
								   $cj3="select emp_id from tbl_jobposted where Job_Id='".$job."' and Job_Status='1'";
								   $resultcj3 = mysqli_query($con,$cj3);  
								$result_cj3=mysqli_fetch_array($resultcj3); 
								$description="'".$row['JFullName']."' user skills and location are matching to your job. please check once ";

									$insert_query = "INSERT into tbl_notifications SET  job_id='".$job."',description='".$description."',job_owner_id='".$result_cj3['emp_id']."',profile_id='".$_SESSION['userSession']."',notification_to='".$job."',notification_from='".$_SESSION['userSession']."'"; 
												$rr1 = mysqli_query($con,$insert_query);

									$emp_query="select emp_email from tbll_emplyer where emp_id=".$result_cj3['emp_id'];
									$emp_res=mysqli_query($con,$emp_query);
									$emp_data=mysqli_fetch_array($emp_res);

									$emp_email=$emp_data['emp_email'];
									$subject="Regarding Skills";

									$mm=$user_home->send_mail2($emp_email,$description,$subject);

							}
               }

			  $date = new DateTime($_POST['date']);
				$new_date_format = $date->format('Y-m-d');
				$dob=strtotime($_POST['dob']);
				$prof_summary = htmlspecialchars($_POST['profile'], ENT_QUOTES);
			 $user_update_query="UPDATE tbl_jobseeker SET JFullName='".$_POST['full_name']."',DoB='".$new_date_format."',Gender='".$_POST['gender']."',JPhone='".$_POST['JPhone']."',JTotalEy='".$_POST['years']."',JTotalEm='".$_POST['months']."',JPLoc_Id='".$_POST['Cloc']."',Indus_Id='".$indus."',Func_Id='".$func."',profile_summary='".$prof_summary."' where JUser_Id='".$row['JUser_Id']."'"; 
		 //exit;
				 $rr= mysqli_query($con,$user_update_query); 
				  $insert_jexp1 ="INSERT INTO tbl_recent_views SET userid='".$row['JUser_Id']."',Action='Updated',Activity='Updated My General Information ',Ipaddress='".$_SERVER['REMOTE_ADDR']."'";
					$jexp1= mysqli_query($con,$insert_jexp1);
					if($rr!=0)
					{
						 $cs_qq="UPDATE tbl_currentexperience SET CurrentSalL='".$_POST['CSL']."',ExpSalL='".$_POST['ESL']."',ExpMaxSalL='".$_POST['EMSL']."',alter_no='".$_POST['alter_no']."' where JUser_Id='".$row['JUser_Id']."'"; 
							$cs_res=mysqli_query($con,$cs_qq);


						?>		<script>alert("successfully Updated General Information");window.location.href = "jobseeker-profile.php";</script>
					<?php  }
			  
		  }		  
}
if(isset($_POST['removelogo']))
		{
	if($row['JPhoto'] !="")
			{
			$remove_logo =	("Update tbl_jobseeker Set JPhoto=NULL   WHERE JUser_Id=".$row['JUser_Id']);  
		    $rl= mysqli_query($con,$remove_logo);
			if($rl == 0)
		{?>		<script>alert("Profile Pic is not Removed");window.location.href = "jobseeker-profile.php";</script>
		<?php  }
		
			else
				
			{?>		<script>alert("Profile Picture is removed");window.location.href = "jobseeker-profile.php";</script>
		<?php  }
	}else{
			?><script>alert("Profile Picture is not available");window.location.href = "jobseeker-profile.php";</script><?php
		}
		}
		    if(isset($_POST['langinfo']))
		    {
			// print_r($_POST); exit;
				if($_POST['language1'] == $_POST['language2'] || $_POST['language1']==$_POST['language3'] || $_POST['language2']==$_POST['language3']){ ?>
					<script>alert("Languages can not be same");window.location.href = "jobseeker-profile.php";</script>
				<?php exit; }
				else {
				 $counts=$_POST['counts']; 
				 $user_queryl="select * from lang_known where JUser_Id='".$row['JUser_Id']."'";
				 $rrlk= mysqli_query($con,$user_queryl); 
		     	 $count1=mysqli_num_rows($rrlk); 

				 $insert_jexp1 ="INSERT INTO tbl_recent_views SET userid='".$row['JUser_Id']."',Action='Added',Activity='Added Languages Known',Ipaddress='".$_SERVER['REMOTE_ADDR']."'";
					$jexp1= mysqli_query($con,$insert_jexp1);
					
				 if($count1 == '0')
				 { 	
				
				for($ii=1;$ii<=3;$ii++)
                          {
							  if($_POST['language'.$ii]!=0)
							  {
				  $insert_query1 = "INSERT INTO lang_known SET lang_id='".$_POST['language'.$ii]."',lang_read='".$_POST['read'.$ii]."',lang_write='".$_POST['write'.$ii]."',lang_speak='".$_POST['speak'.$ii]."',JUser_Id='".$row['JUser_Id']."' ";
					$rr= mysqli_query($con,$insert_query1);

					// $insert_query2 = "INSERT INTO lang_known SET lang_id='".$_POST['language2']."',lang_read='".$_POST['read2']."',lang_write='".$_POST['write2']."',lang_speak='".$_POST['speak2']."',JUser_Id='".$row['JUser_Id']."' ";
				//	$rr= mysqli_query($con,$insert_query2);

					// $insert_query3 = "INSERT INTO lang_known SET lang_id='".$_POST['language3']."',lang_read='".$_POST['read3']."',lang_write='".$_POST['write3']."',lang_speak='".$_POST['speak3']."',JUser_Id='".$row['JUser_Id']."' ";
					//$rr= mysqli_query($con,$insert_query3); 
					}
						  }
					
					if($rr!=0)
					{?>		<script>alert("Language Details Successfully Updated");window.location.href = "jobseeker-profile.php";</script>
					<?php  }
					exit;
					
				}
            else {
            //	print_r($_POST); exit;
				    $del_qq="DELETE  from lang_known where JUser_Id='".$row['JUser_Id']."'";
				    $del_res=mysqli_query($con,$del_qq); 
				    if($del_res!="")
				    {
                          for($i=1;$i<=3;$i++)
                          {
							  if($_POST['language'.$i]!=0)
							  {
								  if($_POST['read'.$i]== '' && $_POST['write'.$i] =='' && $_POST['speak'.$i]=='' )
								  {}
							  else
							  {$insert_query1 = "INSERT INTO lang_known SET lang_id='".$_POST['language'.$i]."',lang_read='".$_POST['read'.$i]."',lang_write='".$_POST['write'.$i]."',lang_speak='".$_POST['speak'.$i]."',JUser_Id='".$row['JUser_Id']."' ";
							  $rr= mysqli_query($con,$insert_query1); }
							  }
		               	} 
				}
					/* $update_query1 = "UPDATE lang_known SET lang_read='".$_POST['read1']."',lang_write='".$_POST['write1']."',lang_speak='".$_POST['speak1']."' where JUser_Id='".$row['JUser_Id']."' and lang_id='".$_POST['language1']."' ";
					$uu= mysqli_query($con,$update_query1);

					 $update_query2 = "UPDATE lang_known SET lang_read='".$_POST['read2']."',lang_write='".$_POST['write2']."',lang_speak='".$_POST['speak2']."' where JUser_Id='".$row['JUser_Id']."' and lang_id='".$_POST['language2']."' ";
					$uu= mysqli_query($con,$update_query2);

					 $update_query3 = "UPDATE lang_known SET lang_read='".$_POST['read3']."',lang_write='".$_POST['write3']."',lang_speak='".$_POST['speak3']."' where JUser_Id='".$row['JUser_Id']."' and lang_id='".$_POST['language3']."' ";
					$uu= mysqli_query($con,$update_query3); */
					
					
					
					if($rr!=0)
					{?>		<script>alert("Language Details Successfully Updated");window.location.href = "jobseeker-profile.php";</script>
					<?php  }
					
					
					exit;
					
			}
			}
	}
			  if(isset($_POST['Eduinfo']))
			  {$edumsg=array();
				  $education=$_POST['education'];
				  $university=$_POST['university'];
				 // $specid=$_POST['specialization'];
				  $yearpassed=$_POST['yearpassed'];
				  $percentage=$_POST['percentage'];
				 // $grade=$_POST['grade'];
				  $partfulltime=$_POST['partfulltime'];
				
				  $jssid=$row['JUser_Id'];
				  $newspec=$_POST['newspec'];
				  if($_POST['newspec']!="" && $_POST['specialization']=='Others'){
						$jspec="select * from tbl_specialization where Speca_Name='".$newspec."'";
						$spec_res=mysqli_query($con,$jspec);
						$spec_data=mysqli_fetch_array($spec_res);
						if($spec_data==1){		
							$spec=$_POST['specialization'];
						}
						else{
							
						$spec_query = "INSERT into tbl_specialization SET  Speca_Name='".$newspec."'";
							$fq1 = mysqli_query($con,$spec_query);
							
							$jspec1="select * from tbl_specialization where Speca_Name='".$newspec."'"; 
						$spec_res1=mysqli_query($con,$jspec1);
						$spec_data1=mysqli_fetch_array($spec_res1);
						 $spec=$spec_data1['Speca_Id'];
							
						}
					}
					else{
						$spec=$_POST['specialization'];
					}
					$newuniv=$_POST['newuniv'];
					  if($_POST['newuniv']!="" && $_POST['university']=='Others'){
						$juniv="select * from tbl_university where University_Name='".$newuniv."'";
						$univ_res=mysqli_query($con,$juniv);
						$univ_data=mysqli_fetch_array($univ_res);
						if($univ_data==1){		
							$univ=$_POST['university'];
						}
						else{
							
						$univ_query = "INSERT into tbl_university SET  University_Name='".$newuniv."'";
						$fq1 = mysqli_query($con,$univ_query);							
						$juniv1="select * from tbl_university where University_Name='".$newuniv."'"; 
						$univ_res1=mysqli_query($con,$juniv1);
						$univ_data1=mysqli_fetch_array($univ_res1);
						$univ=$univ_data1['University_Id'];
							
						}
					}
					else{
						$univ=$_POST['university'];
					}
				 
				  $edumsg=array();
				  if(empty($_POST['education'])||empty($spec)||empty($univ) || empty($_POST['yearpassed'])||empty($_POST['partfulltime']))
				  {//$edumsg[]="One of the field is Empty please check /n ";
				  
				 ?><script language='javascript'>alert('One of the field is Empty please check');history.go(-1);</script>";
							<?php
				  
				}
			//	else  if ((!is_numeric($percentage)) || ($percentage>100)) 
				//{
				   
				//   echo "<script language='javascript'>alert('Percentage can be Numerics only and less than 100 only');history.go(-1);</script>";
			 //  }
				
				
			else
					{
				  
				 $insert_edu = "INSERT INTO tbl_education SET Qual_Id='$education',University_Id='$univ',Speca_Id='$spec',YearPassed='$yearpassed',Percentage='$percentage',grade='$grade',partfulltime='$partfulltime',JUser_Id='$jssid' ";
				 //echo $sql;
					$edu= mysqli_query($con,$insert_edu);
					
					$insert_jexp1 ="INSERT INTO tbl_recent_views SET userid='".$row['JUser_Id']."',Action='Added',Activity='Added Education Details ',Ipaddress='".$_SERVER['REMOTE_ADDR']."'";
					$jexp1= mysqli_query($con,$insert_jexp1);
					
					if($edu!=0)
					{?>		<script>alert("Successfully Updated Educaton Details");window.location.href = "jobseeker-profile.php";</script>
					<?php  }
					}
			  }
					
		if(isset($_POST['Savelogo']))
		
		{

			if(empty($_FILES['logo']['name']))
				{?>
					
						 <script language="javascript">alert("Please upload a photo ");history.go(-1);</script> 

					
				<?php	
				}
				//echo "DDD";
				clearstatcache();
				//echo $_FILES['resume']['name'];
				$logosize= filesize($_FILES['logo']['tmp_name']);
				//echo $resumesize;
				//exit;
				//echo $filese;
		


		$allowed =  array('JPG','JPEG','PNG','GIF');
		
		
		
		if($_FILES['logo']['name']) {
		
		$ext=strtoupper(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
		if($logosize>60000)
		{	?>
	
	 <script language="javascript">alert("Maximum Resume size is 60KB");history.go(-1);</script> 
	 <?php

								
		}	
			else if(!(in_array($ext,$allowed)))
				 {
			 ?>
	 <script language="javascript">alert("Wrong resume file type please upload again");history.go(-1);</script> 
	 
	<?php		 
		 }
			else
			{				
				
			
		$ext=substr(strrchr($_FILES['logo']['name'],"."),1);		
		$ext=strtolower($ext);
		
		if($ext=="jpg" || $ext=="jpeg" || $ext=="gif" || $ext=="png") {						
			$tiny_image="Upload/ProfilePic/logo".$row['JUser_Id'].".".$ext;
			move_uploaded_file($_FILES['logo']['tmp_name'], $tiny_image);   
		
		$update_logo =	("UPDATE tbl_jobseeker SET JPhoto='".$tiny_image."' WHERE JUser_Id=".(int)$row['JUser_Id']);  
		$ul= mysqli_query($con,$update_logo);
		if($ul!=0)
		{?>		<script>alert("Profile Picture Updated Successfully");window.location.href = "jobseeker-profile.php";</script>
		<?php  }
		}
	} 	
				
			}
		}
			
			if(isset($_POST['Saveresume']))
			{
				//echo $_FILES['resume']['name'];
		//exit;
				if(empty($_FILES['resume']['name']))
				{?>
					
						 <script language="javascript">alert("Please upload a file ");history.go(-1);</script> 
				<?php	
				}
				//echo "DDD";
				clearstatcache();
				//echo $_FILES['resume']['name'];
				$resumesize= filesize($_FILES['resume']['tmp_name']);
				//echo $resumesize;
				//exit;
				//echo $filese;
		$allowed =  array('DOCX','DOC' ,'PDF');
		if($_FILES['resume']['name']) {
		$ext=strtoupper(pathinfo($_FILES['resume']['name'], PATHINFO_EXTENSION));
		if(!(in_array($ext,$allowed)))
				 {
			 ?>
	 <script language="javascript">alert("Wrong resume file type please upload again");history.go(-1);</script> 
	 
	<?php		 
		 }
		else if($resumesize>256000)
		{	?>
	
	 <script language="javascript">alert("Maximum Resume size is 250Kb");history.go(-1);</script> 
	 <?php					
		}	
		else
		{
			$tiny_image1="Upload/Cv/resume".$row['JUser_Id'].rand().".".$ext;
			move_uploaded_file($_FILES['resume']['tmp_name'], $tiny_image1);
			$cur_date=date("Y-m-d H:i:s");
		$update_logo1 =	("UPDATE tbl_currentexperience SET UpdateCV='".$tiny_image1."', currentdate='".$cur_date."' WHERE JUser_Id=".(int)$row['JUser_Id']);  
		
		$ul= mysqli_query($con,$update_logo1);
		$insert_jexp1 ="INSERT INTO tbl_recent_views SET userid='".$row['JUser_Id']."',Action='Added',Activity='Added New Resume',Ipaddress='".$_SERVER['REMOTE_ADDR']."'";
					$jexp1= mysqli_query($con,$insert_jexp1);
					/*$insert_jexp1 ="INSERT INTO tbl_recent_views SET userid='".$row['JUser_Id']."',Action='Updated',Activity='Added Education Details ',Ipaddress='".$_SERVER['REMOTE_ADDR']."'";
					$jexp1= mysqli_query($con,$insert_jexp1);*/
		if($ul!=0)
		{?>		<script>alert("Resume successfully Updated");window.location.href = "jobseeker-profile-update-resume.php";</script>
		<?php  }
		}
		}
	} 		
			  if(isset($_POST['subexp']))
			  { 
			  //	print_r($_POST); 
			  	$msgexp=array();
				  if(empty($_POST['txtcmpy']))
				  {
					  $msgexp[]="Please give your company name";
					  
				  }
				   if(empty($_POST['desi']))
				  {
					  
					  $msgexp[]="Please give your designation";
				  }
				   if(empty($_POST['txtdoj']))
				  {
					  $msgexp[]="Please give your Date of Join";
					  
				  }
				   if(empty($_POST['txtdor']))
				  {
					  $msgexp[]="Please give your date of releiving";
					  
				  }
				   if(empty($_POST['eloc']))
				  {
					  
					  $msgexp[]="Please give your location";
				  }
				   if(empty($_POST['eres']))
				  {
					  
					  $msgexp[]="Please give your roles and responsibilities";
				  }
				   if(empty($_POST['txtjexp']))
				  {
					  
					  $msgexp[]="Please give job description";
				  }
				  $txtlength=strlen($_POST['txtexp']);
				  if($txtlength>5000){
					  $msgexp[]="Description is too long";
					  
				  }
				//  $jdate = new DateTime($_POST['txtdoj']);
				//  $newjdate = $jdate->format('Y-m-d');

				  $jdate = $_POST['txtdoj'];
                  $arrj = explode('/', $jdate);
                  $newjdate = $arrj[2].'-'.$arrj[1].'-'.$arrj[0];
				  
				//  $rdate = new DateTime($_POST['txtdor']);
			   //	$newrdate = $rdate->format('Y-m-d');
                  $rdate = $_POST['txtdor'];
                  $arr = explode('/', $rdate);
                  $newrdate = $arr[2].'-'.$arr[1].'-'.$arr[0]; 
				  if($newjdate>$newrdate)
				  {
					  
					  $msgexp[]="Please give Valid Date of relieving";					  
				  }
				  if(!empty($msgexp))
	{
		?><script language="javascript">alert("<?php  foreach($msgexp as $k) {echo $k.'\\n'; }?>");
		history.go(-1);
		</script>
		<?php 
	}

else {
				  
				$prof1_desc = htmlspecialchars($_POST['txtjexp'], ENT_QUOTES);
				$insert_jexp ="INSERT INTO tbl_experience SET Cmpy_Name='".$_POST['txtcmpy']."',Desig_Id='".$_POST['desi']."',doj='".$newjdate."',dor='".$newrdate."',Loc_Id='".$_POST['eloc']."',Roles_Resp='".$_POST['eres']."',JDescri='".$prof1_desc."',JUser_Id='".$row['JUser_Id']."' ";
					$jexp= mysqli_query($con,$insert_jexp);
						$insert_jexp1 ="INSERT INTO tbl_recent_views SET userid='".$row['JUser_Id']."',Action='Added',Activity='Added New Experience Details',Ipaddress='".$_SERVER['REMOTE_ADDR']."'";
					$jexp1= mysqli_query($con,$insert_jexp1);
					if($jexp!=0)
					{
						?>		<script>alert("Successfully Updated Experience Details");window.location.href = "jobseeker-profile.php";</script>
					<?php  
					}
					}
			  }
			 if(isset($_POST['submitpsp'])){
						//print_r($_POST); 
						$msgpsp=array();
					
				$user_query2="select * from tbl_passport where JUser_Id='".$row['JUser_Id']."'";
				$rrlk2= mysqli_query($con,$user_query2); 
				 $count=mysqli_num_rows($rrlk2);		
				
				 $date1 = new DateTime($_POST['txtDOI']); 
				 if(empty($date1))
				 {
					 $msgpsp[]= "Please give date of issue";
				 }
				
				 $new_date_format1 = $date1->format('Y-m-d');
				$_POST['txtDOE'];
				$date2 = new DateTime($_POST['txtDOE']);
				if(empty($date2))
				{
					$msgpsp[]= "Please give date of Expiry";
					
				}
				 $new_date_format2 = $date2->format('Y-m-d');
                                    
				 if(strtotime ($new_date_format1)>strtotime($new_date_format2))
				 {
					 $msgpsp[]="Please give valid Date of expiry";
				 }
				if(empty($_POST['PLocation']))
				{
					$msgpsp[]= "Please give Passport issue place";
				}
				if(!(empty($msgpsp)))
  {   ?><script language="javascript">alert("<?php  foreach($msgpsp as $k) {echo $k.'\\n'; }?>");
		history.go(-1);
		</script>
		<?php 
			/*foreach ($_POST as $key => $value)
			if(empty($value))
 echo "Field ".htmlspecialchars($key)." is ".htmlspecialchars($value)."<br>";	*/
				  
		 }
		 
				else if($count ==0)
				{ 			
			 $insert_query1 = "INSERT INTO tbl_passport SET Number='".$_POST['txtpno']."',Loc_Id='".$_POST['PLocation']."',DoI='".$new_date_format1."', DoED='".$new_date_format2."',JUser_Id='".$row['JUser_Id']."' "; 
						
				$rr= mysqli_query($con,$insert_query1);
				$insert_jexp1 ="INSERT INTO tbl_recent_views SET userid='".$row['JUser_Id']."',Action='Added',Activity='Added Passport Details',Ipaddress='".$_SERVER['REMOTE_ADDR']."'";
					$jexp1= mysqli_query($con,$insert_jexp1);
					
					$update_jexp1 ="update tbl_jobseeker SET JCauthorised='".$_POST['acountry']."',Jcitizen='".$_POST['RCountry']."' where JUser_Id='".$row['JUser_Id']."'";
					$upcountry= mysqli_query($con,$update_jexp1);
			
				
					if($rr!=0)
					{?>		<script>alert("Passport Details Updated");window.location.href = "jobseeker-profile.php";</script>
					<?php  
					}								
					exit;
 }
					
 else
 {
//echo $new_date_format1;
//echo $new_date_format2;	
//print_r($_POST['acountry']); exit;
				$acount = implode(",",$_POST['acountry']);
	 $update_query1 = "UPDATE tbl_passport SET Number='".$_POST['txtpno']."' , Loc_Id='".$_POST['PLocation']."',
					DoI='".$new_date_format1."', DoED='".$new_date_format2."' where JUser_Id='".$row['JUser_Id']."' ";
					$uq1= mysqli_query($con,$update_query1);
					
					$insert_jexp1 ="INSERT INTO tbl_recent_views SET userid='".$row['JUser_Id']."',Action='Updated',Activity='Updated Passport Details',Ipaddress='".$_SERVER['REMOTE_ADDR']."'";
					$jexp1= mysqli_query($con,$insert_jexp1);
					$update_jexp1 ="update tbl_jobseeker SET JCauthorised='".$acount."',Jcitizen='".$_POST['RCountry']."' where JUser_Id='".$row['JUser_Id']."'"; 
					$upcountry= mysqli_query($con,$update_jexp1);
					if($uq1!=0)
					{?>		<script>alert("Passport Details Successfully Updated");window.location.href = "jobseeker-profile.php";</script>
					<?php
					}					
					exit;
					//$count--;
			  
		}
					 }
					  if(isset($_POST['editEduinfo'])){
				
				 $insert_edu = "update  tbl_education SET Qual_Id='".$_POST['education']."',University_Id='".$_POST['university']."',YearPassed='".$_POST['yearofpass']."',Percentage='".$_POST['percentage']."',grade='".$_POST['grade']."',partfulltime='".$_POST['partfulltime']."',activities='".$_POST['actvities']."' where JUser_Id='".$row['juser_id']."'and Edu_Id='".$_POST['edu_id']."' ";
					$edu= mysqli_query($con,$insert_edu);
					$insert_jexp1 ="INSERT INTO tbl_recent_views SET userid='".$row['JUser_Id']."',Action='Updated',Activity='Updated Education Details',Ipaddress='".$_SERVER['REMOTE_ADDR']."'";
					$jexp1= mysqli_query($con,$insert_jexp1);
					if($edu!=0)
					{?>		<script>alert("Successfully Updated Education");window.location.href = "jobseeker-profile.php";</script>
					<?php  }
					}
				
		if(isset($_POST['editexp']))

        {

	
	/*if(empty($_POST['cdesi']) || empty($_POST['doj']) || empty($_POST['dor']) || empty($_POST['eloc']) || empty($_POST['funtional_area']) || empty($_POST['Desc']))
		echo '<script>alert("Record is empty");window.location.href = "jobseeker-profile.php";</script>';  echo"oops";
	else*/
	 
		$cmpy_name=$_POST['Company_Name'];
		$desig=$_POST['cdesi'];
		if($_POST['doj']!=""){
			$dojj=$_POST['doj'];			
$date = str_replace('/', '-', $dojj);
 $doj= date('Y-m-d', strtotime($date));
			
		 }

		/* if($_POST['doj']!=""){
			$datei=date_create($_POST['doj']);
		 $doj= date_format($datei,"Y-m-d");
		 //echo $doj;
		 //exit;
		 }*/
		//$doj=$_POST['doj']; 
		//$dor=$_POST['dor'];
		$loc=$_POST['eloc'];
		$func=$_POST['functional_area'];
		$desc=$_POST['Desc'];
		$msgproexp=array();
		//echo "wafafa";
		
		if(empty($cmpy_name))
		{
			$msgproexp[]="Please give Company Name";
		}
				//echo "yes";
		if(empty($desig))
		{
			$msgproexp[]="Please give Designation in Company";
		}
		$newdoj = new DateTime($doj);
				  $newdojdate = $newdoj->format('Y-m-d');
		//$new_date_dojformat = $doj->format('Y-m-d');
		//echo $newdojdate;
		//exit;
		if(empty($newdojdate))
		{
			$msgproexp[]="Please give your Date of Joining";
		}
		/*
		if(empty($loc))
		{
			$msgproexp[]="Please give Your Location";
		}*/
		
		if(empty($func))
		{
			$msgproexp[]="Please give your Functional Area";
		}
		
		if(empty($desc))
		{
			$msgproexp[]="Please give Job Description";
		}
		//echo  "feafeaff";
		if(!empty($msgproexp))
	{//echo "wwdwwa";
		?><script language="javascript">alert("<?php  foreach($msgproexp as $k) {echo $k.'\\n'; }?>");
		history.go(-1);
		</script>
		<?php 
	}	

else {
	//echo "tes";
	    $prof_desc = htmlspecialchars($desc, ENT_QUOTES);
		 $updcurr="UPDATE tbl_currentexperience SET Company_Name = '$cmpy_name', Des = '$desig', doJ='$newdojdate',JDesc='$prof_desc' WHERE JUser_Id= $row[JUser_Id]";
		//echo $updcurr;
		$updcurr1="UPDATE tbl_jobseeker SET Func_Id= '$func' WHERE JUser_Id= $row[JUser_Id]";
		$update1=mysqli_query($con,$updcurr1);
		$update=mysqli_query($con,$updcurr);
		
		$insert_jexp1 ="INSERT INTO tbl_recent_views SET userid='".$row['JUser_Id']."',Action='Updated',Activity='Updated Current Experience Details',Ipaddress='".$_SERVER['REMOTE_ADDR']."'";
					$jexp1= mysqli_query($con,$insert_jexp1);
					//echo $insert_jexp1;
					//exit;
		
		if($update!=0 && $update1!=0)
		{
			?>	<script>alert("Successfully edited Experience");window.location.href = "jobseeker-profile.php";</script>
			<?php  
		}
		else 
			echo mysqli_error($con);
	}
}
if(isset($_POST['editadd']))	
        {
			 $c_sql1="select user_id from tbl_address where user_id=".$row['JUser_Id'];
			   $c_res1=mysqli_query($con,$c_sql1); 
			  $c_ress= mysqli_fetch_array($c_res1);
			  $c_ress['user_id'];
			   if($c_ress['user_id'] == ""){
				
				$cadr_sql1="INSERT INTO tbl_address (country,state,location,address,address_type,user_id,user_type ) VALUES('".$_POST['country_name']."','".$_POST['state2']."','".$_POST['city2']."','".$_POST['address']."','".$_POST['address_type']."','".$row[JUser_Id]."','".$_POST['user_type']."')";
		              $cadr_res1=mysqli_query($con,$cadr_sql1); 
					  if($cadr_res1){
						  ?>	<script>alert("Successfully Updated Address");window.location.href = "jobseeker-profile.php";</script>
			<?php  
					  }
			   }
			   else
			   {
				 $updadd="UPDATE tbl_address SET country= '".$_POST["country_name"]."',state= '".$_POST["state2"]."',location='".$_POST["city2"]."',address= '".$_POST["address"]."',address_type= '".$_POST["address_type"]."' WHERE user_id= $row[JUser_Id]";
		$upadds=mysqli_query($con,$updadd);
		if($upadds){
						  ?>	<script>alert("Successfully Updated Address");window.location.href = "jobseeker-profile.php";</script>
			<?php  
					  }
			   }
		            
		
			
		}

	if(isset($_POST['btnPrevExp']))

        {
		$cmpy_name=$_POST['Cmpy_Name'];
		$desig=$_POST['secondExp'];
		$doj=$_POST['txtsecondDoJ']; 
		$dor=$_POST['txtsecondDoR'];
		$loc=$_POST['SecondExpLoc'];
		$func=$_POST['SecondRolesR'];
		$desc=$_POST['SecondDesp'];
		$juser_id=$_POST['user_id'];
		$exp_id=$_POST['exp_id'];
		//$newindus=$_POST['newindus'];
		//echo "new industry".$newindus;exit;
		$msgproexp=array();
		//echo "wafafa";
		
		if(empty($cmpy_name))
		{
			$msgproexp[]="Please give Company Name";
		}
				//echo "yes";
		if(empty($desig))
		{
			$msgproexp[]="Please give Designation in Company";
		}
		$newdoj = new DateTime($doj);
				  $newdojdate = $newdoj->format('Y-m-d');
		//$new_date_dojformat = $doj->format('Y-m-d');
	//	echo $newdojdate."feafaefa".$doj.$_POST['txtsecondDoJ'];
		//exit;
		if(empty($doj))
		{
			$msgproexp[]="Please give your Date of Joining";
		}
		
		if(empty($loc))
		{
			$msgproexp[]="Please give Your Location";
		}
		
		if(empty($func))
		{
			$msgproexp[]="Please give your Functional Area";
		}
		
		if(empty($desc))
		{
			$msgproexp[]="Please give Job Description";
		}
		//echo  "feafeaff";
		if(!empty($msgproexp))
	{//echo "wwdwwa";
		echo "<script language='javascript'>alert('";
	  foreach($msgproexp as $k)
		  {
			?><script language="javascript">alert("<?php  foreach($msgproexp as $k) {echo $k.'\\n'; }?>");
		history.go(-1);
		</script>
		<?php 
	}
	}	

else {
    	$prof1_desc = htmlspecialchars($desc, ENT_QUOTES);
		$updcurr="UPDATE tbl_experience SET Cmpy_Name = '$cmpy_name', Desig_id = '$desig', Loc_Id = '$loc' ,doJ='$doj',dor='$dor',JDescri='$prof1_desc' WHERE JUser_Id='$juser_id' and Exp_Id='$exp_id'"; 
		//echo $updcurr; 
		
		$update=mysqli_query($con,$updcurr);
		
		
		//$insert_jexp1 ="INSERT INTO tbl_recent_views SET userid='".$row['JUser_Id']."',Action='Updated',Activity='Updated Current Experience Details',Ipaddress='".$_SERVER['REMOTE_ADDR']."'";
				//	$jexp1= mysqli_query($con,$insert_jexp1);
		
		if($update!=0)
		{
			?>	<script>alert("successfully edited Previous Expereince");window.location.href = "jobseeker-profile.php";</script>
			<?php  
		}
		else 
			echo mysqli_error($con);
	}
}
if(isset($_POST['Savepayslip']))
{
		$_FILES['payslip']['name'];	
	$jid=$row['JUser_Id'];
	$payslipextension=strtoupper(pathinfo($_FILES['payslip']['name'], PATHINFO_EXTENSION));
	$allowed =  array('DOCX','DOC' ,'PDF');
	$payslipsize= filesize($_FILES['payslip']['tmp_name']);
	if(!(in_array($payslipextension,$allowed)))
	{
			?>	<script>alert("Allowed extensions are docx, doc and pdf only.");window.location.href = "jobseeker-profile.php";</script>
			<?php  
	}
	else if($payslipsize>256000)
		{	?>
	
	 <script language="javascript">alert("Maximum Payslip size is 250Kb");history.go(-1);</script> 
	 <?php					
		}
	else
	{
	$payslip="Upload/Payslip/".$_FILES['payslip']['name'];
	$new_name_payslip="Upload/Payslip/payslip_".$jid.".".$payslipextension;
	rename($payslip,$new_name_payslip);
	move_uploaded_file($_FILES['payslip']['tmp_name'],$new_name_payslip);
		if($_POST['test5']==''){
		$checks='N';
	}
	else{
		$checks=$_POST['test5'];
	}
		
	 $sqlfiles=" UPDATE `tbl_currentexperience` SET `PaySlip`='$new_name_payslip',`show_payslip`='$checks' WHERE `JUser_Id`='".$row['JUser_Id']."'";
	
	$sqlres=mysqli_query($con,$sqlfiles);
	if($sqlres!=0)
		{
			?>	<script>alert("successfully updated latest payslip");window.location.href = "jobseeker-profile.php";</script>
			<?php  
		}
		else 
			echo mysqli_error($con);
	}
}
 ?>
      