<?php  require_once 'class.user.php';
if(isset($_GET['t'])) {
	$actualNumber='';
	for($i=0;$i<strlen($_GET['t']);$i++) {
		switch($_GET['t'][$i]) { 
			case 'x':
				$actualNumber =$actualNumber.'0';
				break;
			case 'a':
				$actualNumber =$actualNumber.'1';
				break;
			case 'v':
				$actualNumber =$actualNumber.'2';
				break;
			case 'n':
				$actualNumber =$actualNumber.'3';
				break;
			case 'i':
				$actualNumber = $actualNumber.'4';
				break;
			case 'e':
				$actualNumber = $actualNumber.'5';
				break;
			case 'd':
				$actualNumber = $actualNumber.'6';
				break;
			case 'j':
				$actualNumber = $actualNumber.'7';
				break;
			case 'y':
				$actualNumber = $actualNumber.'8';
				break;
			case 'z':
				$actualNumber = $actualNumber.'9';
				break; 
		}
	}
	if(strlen($actualNumber) >= 10) { 
		$select_query="SELECT Campaign_Name FROM tbl_campaign_details WHERE Mobile_No='$actualNumber'";
		$select_res=mysqli_query($con,$select_query);
		if(mysqli_num_rows($select_res)==0)	{
			$insert_query= "INSERT INTO tbl_campaign_details (Campaign_Name, Campaign_Des, Mobile_No, Email) VALUES ('SMS Campaign','', '$actualNumber','')";
			mysqli_query($con,$insert_query);
		}
	}
	
	
}

if(isset($_GET['w'])) {
	$actualNumber='';
	for($i=0;$i<strlen($_GET['w']);$i++) {
		switch($_GET['w'][$i]) { 
			case 'x':
				$actualNumber =$actualNumber.'0';
				break;
			case 'a':
				$actualNumber =$actualNumber.'1';
				break;
			case 'v':
				$actualNumber =$actualNumber.'2';
				break;
			case 'n':
				$actualNumber =$actualNumber.'3';
				break;
			case 'i':
				$actualNumber = $actualNumber.'4';
				break;
			case 'e':
				$actualNumber = $actualNumber.'5';
				break;
			case 'd':
				$actualNumber = $actualNumber.'6';
				break;
			case 'j':
				$actualNumber = $actualNumber.'7';
				break;
			case 'y':
				$actualNumber = $actualNumber.'8';
				break;
			case 'z':
				$actualNumber = $actualNumber.'9';
				break; 
		}
	}
	if(strlen($actualNumber) >= 10) { 
		$select_query="SELECT Campaign_Name FROM tbl_campaign_details WHERE Mobile_No='$actualNumber'";
		$select_res=mysqli_query($con,$select_query);
		if(mysqli_num_rows($select_res)==0)	{
			$insert_query= "INSERT INTO tbl_campaign_details (Campaign_Name, Campaign_Des, Mobile_No, Email) VALUES ('WhatsApp Campaign','', '$actualNumber','')";
			mysqli_query($con,$insert_query);
		}
	}
	
	
}





 ?>
<?php /* $con = mysqli_connect("localhost","needyin","Hl7w3&p0");
mysqli_select_db($con, "needyin_"); */ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Needyin</title>
    <!-- css includes-->
    <?php include"source_landing.php" ?>
        <script>
            $(document).ready(function () {
               
                $('.searchskills, .sel-city').focusin(function () {
                    $('.pagebanner-in').addClass('darkbg');
                })
              
                $('.searchskills, .sel-city').focusout(function () {
                    $('.pagebanner-in').removeClass('darkbg');
                });
            });
        </script>
	<style>
	 .img-employer {
		width: 100%;
		height: 100%;
	} 
	</style>
</head>

<body>
<?php 
 $query="select jdndstatus from tbl_jobseeker where JUser_Id=".$_SESSION['userSession'];
                                  $query_res=mysqli_query($con,$query);
                                  $dnd=mysqli_fetch_array($query_res);
                                $dnd_status=$dnd['jdndstatus'];
?>
   <div class="loader"></div>
    <?php 
     if($dnd_status=='2')
        {
            include "postlogin-header-inactive.php"; 
        }
        else 
        {
              if(isset($_SESSION['userSession']))
                    {
                         include "postlogin-header-jobseekar.php"; 
                    } 
                 
            	else if(isset($_SESSION['empSession']))
                    {
                         include "includes-recruiter/db-recruiter-header.php"; 
                    } 
                    
            		else
            	{
                include "prelogin-header1.php"; 
              } 
       }
	?>
        <!-- main-->
        <main>
            <!-- page banner and search block -->
            <section class="page-banner-js">
                <div class="pagebanner-in">
                    <div class="bannerin">
                        <div class="container">
                            <!-- search -->
                            <div class="row search-home nomrg">
                                <div class="search-home-in newsearch">
                                    <div class="row">
									<?php 
									if(isset($_SESSION['empSession']))
        {
									
		}
		else
			require_once "search.php";
		?>
                                    </div>
                                </div>
                            </div>
                            <!-- / search -->
                            <div class="row">
                                <div class="col-md-12  text-center">
                                    <!-- banner article -->
                                    <article>
                                        <h1 class="h1 txt-white">Exciting Career Opportunities </h1>
                                        <p class="txt-white flight">Get registered with Needyin and Reunite with your immediate family at your preferred location. </p>
                                    </article>
                                    <!-- /banner article -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- / page banner and search block -->
            <!--commercial advertisements-->
           <section class="ads-block">
                <div class="container">
                  <div class="row">
                  <div > <!--class="col-md-8 col-md-offset-2"-->
                       <ul id="slides" class="slide01">
                            <li class="slide showing "><a href="javascript:void(0)"><img class="img-employer" src="img/ads-img/ad-home01.jpg"></a></li>
                          <!-- <li class="slide"><a href="javascript:void(0)"><img class="img-employer" src="img/ads-img/ad-home02.jpg"></a></li> -->
                           <li class="slide"><a href="javascript:void(0)"><img class="img-employer" src="img/ads-img/ad-home03.jpg"></a></li>
                           <!-- <li class="slide"><a href="javascript:void(0)"><img class="img-employer" src="img/ads-img/ad-home04.jpg"></a></li>
                           <li class="slide"><a href="javascript:void(0)"><img class="img-employer" src="img/ads-img/ad-home05.jpg"></a></li>
                           <li class="slide"><a href="javascript:void(0)"><img class="img-employer" src="img/ads-img/ad-home06.jpg"></a></li> -->
                        </ul>
                    </div>
                  </div>
                </div>
                <script>
                   var slides = document.querySelectorAll('#slides .slide');
                        var currentSlide = 0;
                        var slideInterval = setInterval(nextSlide,5000);

                        function nextSlide(){
                            slides[currentSlide].className = 'slide';
                            currentSlide = (currentSlide+1)%slides.length;
                            slides[currentSlide].className = 'slide showing';
                        }
                </script>
            </section> 
            <!--/ commercial advertisements -->
            
            
            <!-- top employers -->
          <section class="top-employers">
                <div class="container">
                    <h3 class="h3 text-center flight">Top <span class="fbold">Employers</span></h3>
                   
                    <div class="row">
					<?php 
					$employer_list = "SELECT * from tbll_emplyer INNER JOIN tbl_jobposted ON tbl_jobposted.emp_id=tbll_emplyer.emp_id WHERE status=4 AND Job_Status = 1 AND adm_status='A' AND eLogo IS NOT NULL GROUP BY tbl_jobposted.emp_id LIMIT 4";
					$employer_list_query=mysqli_query($con,$employer_list);
					$num_of_rows=mysqli_num_rows($employer_list_query);
					switch($num_of_rows) {
						case 1:
							$class_name="col-md-12";
							break;
						case 2: 
							$class_name="col-md-6";
							break;
						case 3:
							$class_name= "col-md-4";
							break;
						case 4:
							$class_name= "col-md-3";
							break;
					}
					while($employer_list_row = mysqli_fetch_array($employer_list_query)){
						?> 
                        <div class="<?php echo $class_name; ?> text-center">
                            <figure>
                                <a href="job_company.php?cmpny_id=<?php echo $employer_list_row['emp_id']; ?>"> <?php if($employer_list_row['eLogo'])  { ?>  <img src="<?php echo $employer_list_row['eLogo']; ?>">  <?php } else { ?>  <h1 style="color:black;"> <?php echo $employer_list_row['companyname']; ?></h1>  <?php } ?> <!--<span class="comp-name"> <?php echo $employer_list_row['companyname']; ?> </span> -->
                                <!--<span class="noofjobs">(225 Jobs)</span>--> </a>
                            </figure>
                        </div>
						<?php
					}
					?>
    
                    </div>
                    <!-- /row -->
                    <!-- row -->
                 <!--   <div class="row">
                        <div class="col-md-2 text-center">
                            <figure>
                                <a href="#!"><img src="img/topemp-ic07.png"> <span class="comp-name">Altmetric </span><!--<span class="noofjobs">(225 Jobs)</span>--> <!--</a>
                            </figure>
                        </div>
                        <div class="col-md-2 text-center">
                            <figure>
                                <a href="#!"><img src="img/topemp-ic08.png"> <span class="comp-name">EUA </span><!--<span class="noofjobs">(225 Jobs)</span>--> <!--</a>
                            </figure>
                        </div>
                        <div class="col-md-2 text-center">
                            <figure>
                                <a href="#!"><img src="img/topemp-ic09.png"> <span class="comp-name">Ascap </span><!--<span class="noofjobs">(225 Jobs)</span>--> <!--</a>
                            </figure>
                        </div>
                        <div class="col-md-2 text-center">
                            <figure>
                                <a href="#!"><img src="img/topemp-ic10.png"> <span class="comp-name">Caterpiller  </span></a>
                            </figure>
                        </div>
                        <div class="col-md-2 text-center">
                            <figure>
                                <a href="#!"><img src="img/topemp-ic11.png"> <span class="comp-name">Omnibus Press  </span></a>
                            </figure>
                        </div>
                        <div class="col-md-2 text-center">
                            <figure>
                                <a href="#!"><img src="img/topemp-ic12.png"> <span class="comp-name">City Pass  </span></a>
                            </figure>
                        </div>
                    </div>
                    <!-- /row -->
                </div>
            </section>
            <!--/ top employers -->
            <!-- how it works and why needyin -->
            <section class="howwhy">
                <div class="container">
                    <div class="row">
                        <!-- how it works -->
                        <div class="col-md-6">
                            <div class="howitworks-home">
                                <h3 class="h3 pb15">How it Works</h3>
                                <!-- row -->
                                <div class="row">
                                    <div class="col-md-2 col-xs-2 col-sm-2 text-center"><img src="img/hiwicon01.png"></div>
                                    <div class="col-md-10 col-sm-10 col-xs-10">
                                        <article>
                                            <h4 class="h4 fbold">Register with Needyin </h4>
                                            <p class="text-justify">Needyin only allows job seekers who have family contingency and are looking to reunite with their immediate family to register in the portal. Register your profile with Needyin and update your career details. Once the profile is updated and share your resume you will get latest job openings relevant to your profile at your inbox.</p>
                                        </article>
                                    </div>
                                </div>
                                <!--/ row -->
                                <figure class="text-center"><img src="img/down-arrow.png"></figure>
                                <!-- row -->
                                <div class="row">
                                    <div class="col-md-10 col-xs-10 col-sm-10">
                                        <article class="text-right">
                                            <h4 class="h4 fbold">Apply for relevant job openings at Needyin </h4>
                                            <p>Find out all the relevant job openings matching your profile. You can start applying for different job opportunities available at Needyin.</p>
                                        </article>
                                    </div>
                                    <div class="col-md-2 col-xs-2 col-sm-2 text-center"><img src="img/hiwicon02.png"></div>
                                </div>
                                <!--/ row -->
                                <figure class="text-center"><img src="img/down-arrow.png"></figure>
                                <!-- row -->
                                <div class="row">
                                    <div class="col-md-2 col-xs-2 col-sm-2 text-center"><img src="img/hiwicon03.png"></div>
                                    <div class="col-md-10 col-xs-10 col-sm-10">
                                        <article>
                                            <h4 class="h4 fbold">Get your dream job </h4>
                                            <p class="text-justify">Your profile details are visible to the recruiters who wants to connect with you. Once your profile is shortlisted recruiters will get back to you by email or call. Needyin will help you to get your dream job at the desired location. It will help you to reunite with your immediate family members to take care of the basic necessity of your family.</p>
                                        </article>
                                    </div>
                                </div>
                                <!--/ row -->
                                <figure class="text-center"><img src="img/down-arrow.png"></figure>
                                <!-- row -->
                                <div class="row">
                                    <div class="col-md-10 col-xs-10 col-sm-10">
                                        <article class="text-right">
                                            <h4 class="h4 fbold">Deactivate your account </h4>
                                            <p>Once you are able to find out your dream job at the desired location you can deactivate your profile in Needyin. Since Needyin does not allow candidates who are looking for a regular job change you will not be able to register in the portal again.</p>
                                        </article>
                                    </div>
                                    <div class="col-md-2 col-xs-2 col-sm-2 text-center"><img src="img/hiwicon04.png"></div>
                                </div>
                                <!--/ row -->
                            </div>
                        </div>
                        <!--/ how it works -->
                        <!-- Why needyin -->
                        <div class="col-md-6">
                            <div class="howitworks-home yneedyin">
                                <h3 class="h3 pb15">Why Needyin</h3>
                                <p class="pb10">Needyin is a unique idea of an online job portal, designed to help people to relocate to their hometown with a proper job.</p>
                                <p>Here are few USPs that makes Needyin different from other job portals: </p>
                                <!-- row -->
                                <div class="row">
                                    <div class="col-md-2 col-xs-2 col-sm-2 text-center"><img src="img/yneedyicon-01.png"></div>
                                    <div class="col-md-10 col-xs-10 col-sm-10">
                                        <article>
                                            <p class="text-justify"><span class="fbold">Only for Needy:-</span> We allow only those job seekers to search and apply for a job who have family contingency and are looking for relocation to their hometown.</p>
                                        </article>
                                    </div>
                                </div>
                                <!--/ row -->
                                <!-- row -->
                                <div class="row">
                                    <div class="col-md-2 col-xs-2 col-sm-2 text-center"><img src="img/yneedyicon-02.png"></div>
                                    <div class="col-md-10 col-xs-10 col-sm-10">
                                        <article>
                                            <p class="text-justify"><span class="fbold">Large Employer Database:- </span>We have a large pool of employers and the candidates can select from varied employers in their preferred location and apply for relevant job openings.</p>
                                        </article>
                                    </div>
                                </div>
                                <!--/ row -->
                                <!-- row -->
                                <div class="row">
                                    <div class="col-md-2 col-xs-2 col-sm-2 text-center"><img src="img/yneedyicon-03.png"></div>
                                    <div class="col-md-10 col-xs-10 col-sm-10">
                                        <article>
                                            <p class="text-justify"><span class="fbold">Salary Expectations:- </span>Sometimes, the profiles aren’t shortlisted or candidates get rejected due to high salary package. Needyin offers a solution that allows job seekers to select the preferred salary range and apply for jobs which pay at par or little lesser.</p>
                                        </article>
                                    </div>
                                </div>
                                <!--/ row -->
                                <!-- row -->
                                <div class="row">
                                    <div class="col-md-2 col-xs-2 col-sm-2 text-center"><img src="img/yneedyicon-04.png"></div>
                                    <div class="col-md-10 col-xs-10 col-sm-10">
                                        <article>
                                            <p class="text-justify"><span class="fbold">Background Verified Profiles: - </span>All the profiles uploaded on the portal are verified by our team of experts. </p>
                                        </article>
                                    </div>
                                </div>
                                <!--/ row -->
                                <!-- row -->
                                <div class="row">
                                    <div class="col-md-2 col-xs-2 col-sm-2 text-center"><img src="img/yneedyicon-05.png"></div>
                                    <div class="col-md-10 col-xs-10 col-sm-10">
                                        <article>
                                            <p class="text-justify"><span class="fbold">Easy to Navigate: - </span>Our job portal is very easy to navigate. All a user needs to do is to create an account with us, upload the resume and the documents, select the salary bar, and apply for the job. </p>
                                        </article>
                                    </div>
                                </div>
                                <!--/ row -->
                                <!-- row -->
                                <div class="row">
                                    <div class="col-md-2 col-xs-2 col-sm-2 text-center"><img src="img/yneedyicon-06.png"></div>
                                    <div class="col-md-10 col-xs-10 col-sm-10">
                                        <article>
                                            <p class="text-justify"><span class="fbold">Grab your dream job: - </span> We do not allow those candidates to apply who are looking for a regular job change. This benefits the job seekers in finding a good job in a lesser period of time.</p>
                                        </article>
                                    </div>
                                </div>
                                <!--/ row -->
                                 <!-- row -->
                                <div class="row">
                                    <div class="col-md-2 col-xs-2 col-sm-2 text-center"><img src="img/yneedyicon-07.png"></div>
                                    <div class="col-md-10 col-xs-10 col-sm-10">
                                        <article>
                                            <p class="text-justify"><span class="fbold">Better work life balance:- </span> Register with Needyin and grab your dream job to improve the work life balance of your career.</p>
                                        </article>
                                    </div>
                                </div>
                                <!--/ row -->
                            </div>
                        </div>
                        <!--/ Why needyin -->
                    </div>
                </div>
            </section>
            <!--/ how it works nad why needyin-->
        </main>
        <!--/main-->
        <?php 
        if($dnd_status!='2')
         {
            include 'footer.php';
            } ?>
</body>

</html>