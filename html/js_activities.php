<?php require_once 'class.user.php';
$user_home = new USER();

$stmt = $user_home->runQuery("SELECT * FROM tbl_jobseeker u
							  JOIN tbl_currentexperience cexp on u.JUser_Id=cexp.JUser_Id
							  WHERE u.JUser_Id=:uid");
$stmt->execute(array(":uid"=>$_GET['uid']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Needyin</title>
    <!-- css includes-->
    <?php include"source.php" ?>
        <script>
            $(document).ready(function () {
                $('.modal').modal();
            });
        </script>
</head>

<body>
     <header>
         <div class="container nopadmob">
        <nav class="navbar navbar-default navbar-static nav-postlogin-js">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarpost" aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                <a class="navbar-brand" href="<?php echo SITEURL;?>"><img src="img/logo.png"></a>
            </div>
            
        </nav>
    </div>
   
    </header>
        <!-- main-->
        <main>
            <section class="jobseekar-profile">
               <div class="job-seekar-header">
                <div class="container">
                    <!-- top right buttons -->
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="header-top-btns pull-right" style="padding-bottom:10;">
                                      
                            </ul>
                        </div>
                    </div>
                    <!--/ top right buttons -->
                </div>
            </div>
                
                <!-- job seekar header -->
                <!-- job seekar body -->
                <section class="job-seekar-body">
                    <div class="js-profile-nav">
                        <!-- job seekear profile navigation -->
                        <div class="container">
                            <!-- update resume block -->
                            <div class="update-cv">
                                <div class="title-block-tab">
                                    <h4 class="flight">My Recent  <span class="fbold">Activites</span></h4> </div>
                                <!--change password -->
                                <div class="my-activities">
                                    <ul class="list-activities row">
									<?php 
									$jc1= "SELECT tv.*,tj.Job_Name FROM tbl_recent_views tv LEFT JOIN tbl_jobposted tj on tv.Reference=tj.Job_Id where userid='".$_GET['uid']."' ORDER BY id DESC limit 0,20 " ;
									$jresult1 = mysqli_query($con,$jc1);
									while ($jrow = mysqli_fetch_array($jresult1)){
									?>
                                      <a href="login.php" style="color:black;">  <li class="col-md-6">
                                           <div class="activities-div">
                                            <h5 class="h5"><?php echo $jrow['Activity'] ?>
											<span> <!--<?php echo $jrow['Date&time'] ?>-->
											<?php $date=date_create($jrow['Date&time']);
											echo date_format($date,"M d, Y H:i:s");?>
											</span></h5>
                                            <article class="activities-table">
                                                <p><span class="fbold"> <?php echo ucfirst($row['JFullName']); ?></span>
                                                 <?php echo $jrow['Activity'] ?>
                                                
												<?php $sql2 = "SELECT * FROM tbl_desigination where Desig_Id ='".$jrow['Job_Name']."'";
												$query2 = mysqli_query($con, $sql2);
												$row2 = mysqli_fetch_array($query2);

                                   ?>
                                                 <?php if($row2['Desig_Name']!="") { ?>
                                                 <b> for 
                                                 <?php echo $row2['Desig_Name']; 
                                                 } ?></b></p>                                                
                                            </article>
                                            </div>
                                        </li></a>
                                     <?php } ?>  
                                    </ul>
                                </div>
                                <!--/ change password -->
                            </div>
                            <!--/ update resume block -->
                        </div>
                    </div>
                    <!-- job seekar profile navigation -->
                </section>
                <!-- / job seekar body -->
            </section>
        </main>
        <!--/main-->
        
</body>

</html>