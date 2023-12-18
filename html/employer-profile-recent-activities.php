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
        <script>
            $(document).ready(function () {
                $('.modal').modal();
            });
        </script>
</head>

<body>
    <?php 
	include_once("analyticstracking.php");
	include "includes-recruiter/db-recruiter-header.php" ?>
       
        <main>
            <section class="jobseekar-profile">
               
              
                <section class="job-seekar-body">
                    <div class="js-profile-nav">
                       
                        <div class="container">
                            
                            <div class="update-cv">
                                <div class="title-block-tab">
                                    <h4 class="flight">My Recent  <span class="fbold">Activites</span></h4> </div>
                            
                                <div class="my-activities">
                                    <ul class="list-activities row">
									<?php 
									$jc1= "SELECT tv.*,tj.Job_Name,jk.JFullName,jk.JuserStatus FROM tbl_recent_views tv
									LEFT JOIN tbl_jobseeker jk on tv.userid=jk.JUser_Id
									LEFT JOIN tbl_jobposted tj on tv.Reference=tj.Job_Id 
									where empid='".$row['emp_id']."' and jk.JuserStatus='A' Order By tv.id DESC LIMIT 20 " ;
									$jresult1 = mysqli_query($con,$jc1);
									while ($jrow = mysqli_fetch_array($jresult1)){
									?>
									
                                        <li class="col-md-6">
                                           <div class="activities-div">
                                            <h5 class="h5"><?php echo $jrow['Activity'] ?>
											<span>
										
											<?php $date=date_create($jrow['Date&time']);
											echo date_format($date,"M d,Y H:i:s");?>											
											</span></h5>
                                            <article class="activities-table">
                                                <p><span class="fbold"><?php echo trim(ucfirst($jrow['JFullName']));?></span><?php echo $jrow['Activity'] ?> <?php $sql2 = "SELECT * FROM tbl_desigination where Desig_Id ='".$jrow['Job_Name']."'";
												$query2 = mysqli_query($con, $sql2);
												$row2s = mysqli_fetch_array($query2);?><?php if($row2s['Desig_Name']) { echo "for"; }?>  
                                                <span class="fbold"><?php echo $row2s['Desig_Name']; ?></span></p>
                                            </article>
                                            </div>
                                        </li>
                                     <?php } ?>  
                                    </ul>
                                </div>
                             
                            </div>
                       
                        </div>
                    </div>
                   
                </section>
              
            </section>
        </main>
      
        <?php //include 'footer.php'?>
        
</body>

</html>
