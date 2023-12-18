<?php
session_start();
require_once("config.php");
require_once 'class.user.php';
$user_home = new USER();
 
if(!isset($_SESSION['empSession']))
{
         $user_home->redirect('index-recruiter.php');
   
} 
 if(!isset($_GET['JUser_Id']))
     $user_home->redirect('index-recruiter.php');
 else
     $JUser_Id=$_GET['JUser_Id'];
 
?> 

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Needyin</title>
    
	
	
    <?php include"source.php" ?>
	 <script type="text/javascript" src="js/jquery.bootstrap-responsive-tabs.min.js"></script>
	
	
</head>

<body>
    <?php 
	 include_once("analyticstracking.php");
	 include 'includes-recruiter/db-recruiter-header.php'; ?>
      
        <main>
           
            <section class="rec-view">
               
                <div class="container">

                <div class="cv-div">
                                <?php   $sql1= "SELECT * FROM tbl_jobseeker WHERE JUser_Id=".$JUser_Id;
                                                                            $result1 = mysqli_query($con,$sql1);
                                                                            $row1 = mysqli_fetch_array($result1);
                                                                            ?>
                                                                            
                                    <p class="atresume">Attached Resume: (Uploaded on <?php $date=date_create($row1['currentdate']);echo date_format($date,"M d,Y");?>) 
                                    <a href="<?php echo $row1['file_location']; ?>" download target="_blank"><i class="fa fa-download" aria-hidden="true"></i> Download</a> 
										<a style="float:right;" href="shin-fitment.php?uid=<?php echo $row1['upload_emplr_Id'];?>&jid=<?php echo $row1['Job_Id'];?>&skill=<?php echo $row1['Job_Skills'];?>&jname=<?php echo $row1['JFullName'];?>&jsid=<?php echo $row1['JUser_Id'];?>"><span class="glyphicon glyphicon-backward"></span> Back</a>									
                                        
                                    </p>
                                    <div class="resume-preview mCustomScrollbar div-resume" >
                                        <p> Resume</p>
                                        <div>
                                        
                                            <p><?php  $cv=explode('.',$row1['file_location']);;if($cv[1]=="pdf" || $cv[1]=="PDF"){?>
                                            <embed src="<?php echo $row1['file_location']?>" width="100%" height="675" type='application/pdf'>
                                            <?php } else{ $upcv=explode("/",$row1['file_location']); 
                                            

echo "<iframe src=https://view.officeapps.live.com/op/embed.aspx?src=http://dev.needyin.com/".$row1['file_location']." width=100% height=675></iframe>";

                                            }?>
                                            </p>
                                        </div>
                                                             </div>
                                </div>
                   
                </div>
               
            </section>
           
        </main>
      
     
       
            
           
</body>

</html>