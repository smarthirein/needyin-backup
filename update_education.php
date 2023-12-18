<?php
require_once("config.php");
require_once 'class.user.php';
$reg_user = new USER();
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
							
						$spec_query = "INSERT into tbl_specialization SET  Speca_Name='".$newspec."' , Qual_Id = '".$_POST['education']."'";
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
				  
				 $insert_edu = "UPDATE tbl_education SET Qual_Id='$education',University_Id='$univ',Speca_Id='$spec',YearPassed='$yearpassed',Percentage='$percentage',grade='$grade',partfulltime='$partfulltime' WHERE Edu_Id ='".$_POST['edu_id']."' ";
				 //echo $sql;
					$edu= mysqli_query($con,$insert_edu);
					
					$insert_jexp1 ="INSERT INTO tbl_recent_views SET userid='".$row['JUser_Id']."',Action='Updated',Activity='Updated Education Details ',Ipaddress='".$_SERVER['REMOTE_ADDR']."'";
					$jexp1= mysqli_query($con,$insert_jexp1);
					
					if($edu!=0)
					{?>		<script>alert("Successfully Updated Educaton Details");window.location.href = "jobseeker-profile.php";</script>
					<?php  }
					}
			  }

?> 