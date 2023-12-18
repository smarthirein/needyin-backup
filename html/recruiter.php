<?php
require_once 'class.user.php';
header('Cache-Control: no cache'); //no cache
 session_cache_limiter('private_no_expire');

session_start();
$user_home = new USER();
 $c_url='list-jobseekers-rec-db.php'.'?loc='.$_GET['loc'].'&skills='.$_GET['sids'];
if(isset($_POST['emp-login']))
{
	$email = trim($_POST['emailid']);
	$upass = trim($_POST['password']);
	
	if($user_home->login1($email,$upass))
	{
        if($_GET['sids']=="")
        {
             $user_home->redirect('dashboard-recruiter.php');
        }
        else 
        {   
            $user_home->redirect($c_url);
        }
		
		
	}
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Post a job and find the profiles which compromise with the current CTC.">
	<meta http-equiv="X-UA-Compatible" content="IE=10,9,7,8" />
    <title>Top Free Job Posting Website Online for Employers in India - Needyin</title>
    <!-- css includes-->
    <?php include "source.php";?>
        <script type="text/javascript">
            $(function () {
                $('.crsl-items').carousel({
                    visible: 4
                    , itemMinWidth: 258
                    , itemEqualHeight: 320
                    , itemMargin: 8
                , });
                $("a[href=#]").on('click', function (e) {
                    e.preventDefault();
                });
            });
        </script>
		        <script>
function validatecredentials()
{
 var email=document.getElementById("emailid").value;
    if(email=="")
    {
        alert("Please give your Email ID");
        document.getElementById("emailid").focus();
        return false;
    }
   if(!emailverify(email))
	{
	
        document.getElementById("emailid").focus();
        return false;
		
	}

    var pwd=document.getElementById("password").value;
    if(pwd=="")
    {
        alert("Please Give Your password");
        document.getElementById("password").focus();
        return false;
    }
}
function validatesearch()
{
	var skill=document.getElementById("languages").value;
	if(skill==0)
	{
		alert("Please Select Skill Name");
		document.getElementById("languages").focus();
		return false;
	}

}	
</script>
</head>

<body>
    <?php 	
	include_once("analyticstracking.php");
	if(isset($_SESSION['empSession']))
        {
             include "includes-recruiter/db-recruiter-header.php"; 
        } 
		else
	{
    include "includes-recruiter/prelogin-header-recruiter.php"; 
  } 
     ?>
        
        <main class="recruiter-main">
            
            <div class="container">
                <div class="login-block">
                    <div class="row">
                       
                        <div class="col-md-5 col-sm-12 col-xs-12">
                            <article class="top-ban-content">
                                <h1 class="flight-thin h2">
                               HIRE FAST WITH ACTIVE <span class="fbold"> JOBSEEKERS </span>
                            </h1>
                                <p class="flight">Register as an employer with Needyin to hire best available talents.</p>
                            </article>
                        </div>
                      
						<?php
						if(!isset($_SESSION['empSession']))
        {				?>
                        <div class="col-md-4 col-sm-6 col-sm-offset-3 col-xs-12 col-md-offset-3">
                            <div class="login-recruiter">
							 <form class="emp-form" method="POST">		
								<?php
								if(isset($_GET['error']))
								{
								?>
								<div class='alert alert-danger'>
										<button class='close' data-dismiss='alert'>&times;</button>
										<strong>Wrong Details!</strong> 																	
								</div>
								<?php
								}
								?>				 
                                <div class="form-group">
                                    <label>Business E-mail Id</label>
                                    <input class="form-control validate" name="emailid" id="emailid" type="text" placeholder="Professional Email ID"> </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control validate" name="password" id="password" type="password" placeholder="Enter Password"> </div>
                                <div class="form-group forgotpw" style="margin-bottom:0;"> <a href="forgotpw-recruiter.php" class="txt-white">Forgot Password?</a> </div>
                                <div class="form-group" style="margin-bottom:0;">
                                 <button name="emp-login" class="btn btn-blue-sm btn-block waves-effect" onclick="return validatecredentials()">Login</button></div>
                                <p class="notamem text-center">Not a member?  <a class="fbold" href="employer-registration.php" ;>Sign up</a></p>
							</form>
                            </div>
                        </div>
		<?php }?>
                       
                    </div>
                </div>
            </div>
          
            <div class="container search-ban">
              
                <div class="row" >
                    <div class="col-md-12">
                       
                        <div class="row search-home nomrg">
                            <div class="search-home-in">
                                <div class="row">
                                <form name="sk_search" action="list-jobseekers-rec-db-prelogin.php" method="post">
                                   
                                    <div class="col-md-5 col-sm-5 col-xs-12 searchskills">
									<label class="masterlabel2">Select Skills </label>
                                      
                                        <?php   $sql3 = "SELECT skill_Id,skill_Name FROM tbl_masterskills ORDER BY skill_Name ASC";
                                                $query3 = mysqli_query($con, $sql3);
                                                if(!$query3)
                                                echo mysqli_error($con);
                                                ?>
                                                 <select class="selectpicker" multiple data-live-search="true" data-live-search-placeholder="Search" id="languages" name="languages[]" data-live-search="true">
												 <option value="0" disabled>Select Job Skill</option>
                                                    <?php
                                                    while ($row3 = mysqli_fetch_array($query3))
                                                    { 
                                                     extract($row3);
                                                    ?>
                                                    <option data-tokens="<?php echo $row3['skill_Name']; ?>" value="<?php echo $row3['skill_Id']; ?>"><?php echo $row3['skill_Name']; ?></option>
                                                    <?php } ?>  
                                                </select>
                                    </div>
                                    
									
                                    <div class="col-md-4 col-xs-12 col-sm-4 sel-city">
									<label class="masterlabel2">Select Location </label>
                                        <div class="form-group">										
                                           <select class="selectpicker" data-live-search="true" data-live-search-placeholder="Search" data-actions-box="true" name="location" id="location">
                                                    <option value="0" ></option>
                                                    <?php 
                                                $q1 = "SELECT * FROM tbl_location WHERE Cntry_Id=101 ORDER BY Loc_Name";
                                                    $r1 = mysqli_query($con,$q1);
                                                    while($res1 = mysqli_fetch_array($r1)){
                                                    $locName = $res1['Loc_Name'];
                                                    $locId = $res1['Loc_Id'];
                                                    ?>
                                                    <option value="<?php echo $locId;?>" <?php if ($loctName==$locName){ echo 'selected';}?> ><?php echo $locName;?></option>;
                                                    <?php }
                                                    ?>       
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3 col-sm-3 col-xs-12 btn-search">
                                        
                                        <input type="submit"  name="searchjobseek" value="Find Profiles" class="btn waves-effect waves-light fbold text-center" onclick="return validatesearch()"/>
                                    </div>
                                   
                                    </form>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
                
                <div class="row highlets-home">
                    <div class="col-md-5 col-sm-5 text-center">
                        <figure class="text-center"><img src="img/highlets-img.png"></figure>
                    </div>
                    <div class="col-md-7 col-sm-7">
                        <article>
                         
                            <br><br><h2 class="h2 txt-blue title-latestjobs  flight"><br><br>Reach the <span class="fbold">right people, faster</span></h2>
							    <?php 
								$sql4 = "SELECT Count() as Id FROM tbl_jobposted WHERE Job_Status='1'";
                                $query4 = mysqli_query($con,$sql4);
                                $row4 = mysqli_fetch_array($query4);
								?> 
                            <p><span class="fbold" style="color:#005eb8;" > <?php $row4['id'] ?></span> </p>
                        </article>
                        
                    </div>
                </div>
                
                <div class="latest-jobseekers">
                    <div class="row">
                        <!-- recent live job seekers -->
                       <div class="recent-js">
                            <div id="w">
                              
                                <nav class="slidernav">
                                    <div id="navbtns" class="clearfix"> <a href="#" class="previous"><i class="fa fa-chevron-left" aria-hidden="true"></i></a> <a href="#" class="next"><i class="fa fa-chevron-right" aria-hidden="true"></i></a> </div>
                                </nav>
                               <div class="crsl-items" data-navigation="navbtns">
                                    <div class="crsl-wrap">
                              
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                        
                    </div>
               </div>
                
                <div class="circle-box">
                    <div class="row">
                        <div class="col-md-4 text-center circle-icon">
                            <figure><img src="img/circle-icon01.png"></figure>
                            <article class="text-center article-circle">
                                <h4 class="h4 fbold">JOB SEEKERS</h4>
                                <p>Give your job search a boost. Send your CV to our network of recruiters. Receive timely job alerts.</p>
                            </article>
                        </div>
                        <div class="col-md-4 text-center circle-icon">
                            <figure><img src="img/circle-icon02.png"></figure>
                            <article class="text-center article-circle">
                                <h4 class="h4 fbold">EMPLOYERS</h4>
                                <p>Unmatched firepower for your hard-to-fill positions. Efficient platform. One point of contact. Drive qualified applicants to your open jobs.</p>
                            </article>
                        </div>
                        <div class="col-md-4 text-center circle-icon">
                            <figure><img src="img/circle-icon03.png"></figure>
                            <article class="text-center article-circle">
                                <h4 class="h4 fbold">RECRUITERS</h4>
                                <p>Get help filling your positions. Give your business massive exposure in our recruiter directory.</p>
                            </article>
                        </div>
                    </div>
                </div>
              
            </div>
          
          
	
        </main>
     
        <?php //include "footer.php"; ?>

</body>

</html>