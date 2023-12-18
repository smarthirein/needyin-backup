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
?>
										
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Needyin</title>

    <?php include"source.php" ?>
</head>

<body>
    <?php 
	include_once("analyticstracking.php");
	include'includes-recruiter/db-recruiter-header.php' ?>
     
        <main>
            
            <section class="db-recruiter">
                <div class="container">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <article class="dbpage-title">
                                <h4 class="h4"> <i class="fa fa-user" aria-hidden="true"></i> Profile</h4> </article>
                        </div>
                    </div>
                   
                </div>
               
                <div class="profile-rec">
                    <div class="container">
                        <div class="row">
                            
                            <div class="col-md-4 col-sm-5 text-center">
                                <div class="profile-left">
                                    <div class="profile-pic-rec">
                                        <figure class="rec-pic">
										<?php $profileLogo=$row['ePhoto']; if($profileLogo){?>
											<img class="img-cover" data-object-fit="cover" src="<?php echo $profileLogo; ?>"><?php } else {?>
															<img class="img-cover" data-object-fit="cover" src="img/js-profile-list-pic.jpg"> 
											<?php } ?> 
                                           
                                        </figure>
                                         <figcaption class="figcapt"><?php echo ucfirst($row["contact_name"])?> <span> <?php echo ucfirst($row["designation"])?>, <?php echo ucfirst($row["companyname"])?> </span></figcaption>
                                        <figure class="logo-company"> 
											<?php $profileLogo1=$row['eLogo']; if($profileLogo1){?>
										<img  class="img-contain" data-object-fit="contain" src="<?php echo $profileLogo1; ?>"><?php } else {?>
															<img  class="img-contain" data-object-fit="contain" src="img/logo.svg"> 
											<?php } ?>
                                           
                                        </figure>
                                         <p class="pt15"> <?php echo ucfirst($row["address1"])?> <?php echo ucfirst($row["address2"])?>  </p>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="col-md-8 col-sm-7">
                                <div class="profile-right">
                                   
                                    <div class="row">
                                        <a class="btn-floating red pull-right tooltipped waves-effect waves-light" data-position="top" data-delay="50" data-tooltip="Edit Profile" href="edit-profile-recruiter.php"> <i class="fa fa-pencil" aria-hidden="true"></i> </a>
                                    </div>
                                    
                                    <div class="main-profile-rec">
                                       
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="block-show">
                                                    <h4>Company Name</h4>
                                                    <p><?php echo ucfirst($row["companyname"])?></p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="block-show">
                                                    <h4>Location</h4>
													<?php  $sqlz="select Loc_Name from tbl_location where Loc_Id='".$row['loc_id']."'";
													$results = mysqli_query($con,$sqlz);
											$rows = mysqli_fetch_array($results); ?>
                                                    <p><?php echo ucfirst($rows["Loc_Name"])?></p>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="block-show">
                                                    <h4>Official Email ID</h4>
                                                    <p><?php echo $row["emp_email"]?></p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="block-show">
                                                    <h4>Company Type</h4>
                                                    <p><?php echo ucfirst($row["company_type"])?></p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="block-show">
												<?php $sql3 = "SELECT * FROM tbl_industry where Indus_Id ='".$row['industry_type']."'";
												$query3 = mysqli_query($con, $sql3);
												$row3 = mysqli_fetch_array($query3);?>
                                                    <h4>Industry</h4>
                                                    <p><?php echo $row3['Indus_Name'];?></p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="block-show">
                                                    <h4>Employers Strength</h4>
                                                    <p><?php echo $row['EmployerStrength'];?></p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            
                                            <div class="col-md-4">
                                                <div class="block-show">
                                                    <h4>Office Contact Number</h4>
                                                    <p><?php echo $row["contact_num"]?></p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="block-show">
                                                    <h4>Address</h4>
												<?php $sql2 = "SELECT * FROM tbl_location where Loc_Id ='".$row['loc_id']."'";
												$query2 = mysqli_query($con, $sql2);
												$row2 = mysqli_fetch_array($query2);?>
												<?php $sql4 = "SELECT * FROM tbl_country where Cntry_Id ='".$row['country_id']."'";
												$query4 = mysqli_query($con, $sql4);
												$row4 = mysqli_fetch_array($query4);?>
												<?php $sql5 = "SELECT * FROM tbl_states where id ='".$row['state_id']."'";
												$query5 = mysqli_query($con, $sql5);
												$row5 = mysqli_fetch_array($query5);?>																							
                                                    <p><?php echo $row["address1"]?> , <?php echo $row["address2"]?> , <?php echo $row2["Loc_Name"]?> - <?php echo $row["pincode"]?>, <?php echo $row5["states"]?>, <?php echo $row4["Cntry_Name"]?>.</p>
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="block-show">
                                                    <h4>Company Website</h4>
                                                    <p><?php echo $row["CompanyUrl"]?></p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="block-show">
                                                    <h4>Year of Registration</h4>
                                                    <p><?php echo $row["YoR"]?></p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="block-show">
                                                    <h4>Type of Registration</h4>
                                                    <p><?php echo $row["ToR"]?></p>
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="block-show">
                                                    <h4>Number of Branches</h4>
                                                    <p><?php echo $row["NoOfBranch"]?></p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="block-show">
                                                    <h4>Mobile Number</h4>
                                                    <p><?php echo $row["contact_num"]?></p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4 class="h4 txt-blue pb15">Account Security</h4> </div>
                                            <div class="col-md-12">
                                                <div class="block-show">
                                                    <h4>Username</h4>
                                                    <p><?php echo $row["emp_email"]?></p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="block-show">
                                                    <h4></h4>
                                                    <p></p>
                                                </div>
                                            </div>
                                        </div>
                                      
                                    </div>
                                </div>
                            </div>
                          
                        </div>
                    </div>
                </div>
				<script lang="javascript">
				var name=document.getElementById('PJobName').value;
            	if(name==0)
            	{
            		alert("Please Enter Job name");
            		document.getElementById('PJobName').focus();
            		return false;
            	}
			

			var PSkills=document.getElementById('PSkills').value;
            	if(PSkills==0)
            	{
            		alert("Please Select skills");
            		document.getElementById('PSkills').focus();
            		return false;
            	}
				
				
            	
				
				
				var mobnum=document.getElementById('PLoc').value;
				if(mobnum=="0")
            	{
            		alert("Please Select Preferred Location");
            		document.getElementById('PLoc').focus();
            		return false;
            	}
				
				
				var exp=document.getElementById('PMinE').value;
				var expmon=document.getElementById('PMaxE').value;
            	if(exp==0&&expmon==0)
            	{
            		alert("Please Give Experience");
            		document.getElementById('PMinE').focus();
            		return false;
            	}
				
				
				
				
				
				
				
				
				</script>
				
				
				
				
             
            </section>
          
        </main>
     
</body>

</html>