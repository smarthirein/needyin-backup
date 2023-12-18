<?php  require_once 'class.user.php'; ?>
<? var_dump($_GET); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Needyin - Best Job Search Sites Online - Job Search Engines  NIII    </title>
  <meta name="description" content="">
  <meta name="keywords" content="">
  <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans|Candal|Alegreya+Sans">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <script src="dist/fastselect.standalone.js"></script>
<link rel="stylesheet" href="https://rawgit.com/dbrekalo/attire/master/dist/css/build.min.css">
<link rel="stylesheet" href="dist/fastselect.min.css">
  <link rel="stylesheet" type="text/css" href="css/imagehover.min.css">
  <link rel="stylesheet" type="text/css" href="css/style1.css">
  
  

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/css/bootstrap-select.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/js/bootstrap-select.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  
  <style>
  /* for search bar not to enlarging */
  .fstMultipleMode .fstControls {
    box-sizing: border-box;
    padding: 0.5em 0.5em 0em 0.5em;
    overflow-y: scroll;
    width: 20em;
    cursor: text;
    height: 2.2em;
}
  </style>

  
  <script>
    $(document).ready(function () {
      $('#newmodel').modal('show');
    })
  </script>
  
  
  <script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
$.src="https://v2.zopim.com/?4zAjUjU13yamEqxKtiwNnrmjmAyIF164";z.t=+new Date;$.
type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
</script>
  <!--Start of Tawk.to Script-->
<!-- <script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5da1a7d0f82523213dc6ecf6/1dmvpf3f7';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script> -->
<!--End of Tawk.to Script-->

  
  <script>
function validate()
{
    var skill=document.getElementById("languages").value;
    if(skill==0)
    {
        alert("Please Select your Preferred Skill");
        document.getElementById("languages").focus();
        return false;
    }
    var PLoc=document.getElementById("Ploc").value;
    if(PLoc==0)
    {
        alert("Please Select your Preferred Location");
        document.getElementById("PLoc").focus();
        return false;
    }
} 

        function modernAlertCallback(val,input,emp) {
         
             
                if (val === true) {
                  
                  var loc='<?php echo $PLoc; ?>';
                  var lang_ids='<?php echo $langids;?>';
                  var jid='<?php echo $j_data['Job_Id'];?>';
                  var c_url='<?php echo $actual_link;?>';

                    window.location.href="login.php?loc="+loc+"&sids="+lang_ids+"&job_id="+input+"&emp_id="+emp;
                    return true;
                } else {
                  return false;
                }
             
        }
</script>
</head>

<body>
  <!--model popup-->
 <!--<div class="container">
    <div class="modal fade" id="newmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <img src="img1/headlogo.png" class="img-responsive logoImage">
            <h4 class="modal-title" id="exampleModalLabel">Book a Meet</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Name:</label>
                <input type="text" class="form-control" id="recipient-name">
              </div>
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Contact No:</label>
                <input type="text" class="form-control" id="recipient-name">
              </div>
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Email Id:</label>
                <input type="text" class="form-control" id="recipient-name">

              </div>
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Company Name</label>
                <input type="text" class="form-control" id="recipient-name">

              </div>
            </form>
          </div>
          <div class="modal-footer">

            <button type="button" class="btn btn-success">Book a Appointment</button>
          </div>
        </div>
      </div>
    </div>
  </div>-->
  <!--Navigation bar-->
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.html"><img src="img1/logo2.png" class="img-responsive logoImage"></a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="job-seeker-login.php"><span class="glyphicon glyphicon-user"></span> Job Seekers</a></li>
          <li><a href="recruiter.php"><span class="glyphicon glyphicon-log-in"></span> Empolyer Zone</a></li>
          <li><a href="https://play.google.com/store/apps/details?id=com.needyin.jobseeker&amp;pcampaignid=MKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1"><img
                src="img1/gplay.png" style="width:105px" alt="Get it on Google Play"></a></li>
        </ul>
      </div>
    </div>
  </nav>
  <!--/ Navigation bar-->
  <!--Modal box-->
  <div class="container">
    <div class="modal fade" id="login" role="dialog">
      <div class="modal-dialog modal-sm">
        <!-- Modal content no 1-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title text-center form-title">Login</h4>
          </div>
          <div class="modal-body padtrbl">

            <div class="login-box-body">
              <p class="login-box-msg">Sign in to start your session</p>
              <div class="form-group">
                <form name="" id="loginForm">
                  <div class="form-group has-feedback">
                    <!----- username -------------->
                    <input class="form-control" placeholder="Username" id="loginid" type="text" autocomplete="off" />
                    <span style="display:none;font-weight:bold; position:absolute;color: red;position: absolute;padding:4px;font-size: 11px;background-color:rgba(128, 128, 128, 0.26);z-index: 17;  right: 27px; top: 5px;"
                      id="span_loginid"></span>
                    <!---Alredy exists  ! -->
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                    <!----- password -------------->
                    <input class="form-control" placeholder="Password" id="loginpsw" type="password" autocomplete="off" />
                    <span style="display:none;font-weight:bold; position:absolute;color: grey;position: absolute;padding:4px;font-size: 11px;background-color:rgba(128, 128, 128, 0.26);z-index: 17;  right: 27px; top: 5px;"
                      id="span_loginpsw"></span>
                    <!---Alredy exists  ! -->
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                  </div>
                  <div class="row">
                    <div class="col-xs-12">
                      <div class="checkbox icheck">
                        <label>
                          <input type="checkbox" id="loginrem"> Remember Me
                        </label>
                      </div>
                    </div>
                    <div class="col-xs-12">
                      <button type="button" class="btn btn-green btn-block btn-flat" onclick="userlogin()">Sign In</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  <!-- job list header -->
					<div class="banner">
                    <div class="bg-color">
                    <div class="container">
                    <div class="row">
					<div class="col-md-offset-1 col-md-12 banner-text text-center">
                    <div class="col-md-4">
                    <div class="text-border">
               <form name="jobsearch" action="job-search-results-prelogin.php" method="post">
                                       
              <?php $sql3 = "SELECT skill_Id,skill_Name FROM tbl_masterskills ORDER BY skill_Name";
              $query3 = mysqli_query($con, $sql3);
              if(!$query3)
                                                echo mysqli_error($con);
                                                ?>
												
<select class="multipleSelect"  name="languages[]" multiple data-live-search="true"id="languages" placeholder="Select Skills">
    <option value="0" disabled>Select Job Skill</option>				
	
	<?php
                while ($row3 = mysqli_fetch_array($query3))
                { 
                extract($row3);
                ?>
<option value="<?php echo $row3['skill_Id']; ?>" <?php if (in_array($row3['skill_Id'],$language_ids)){ echo 'selected'; } ?>><?php echo $row3['skill_Name']; ?></option>
                                                    <?php } ?>			

												</select>
																							
												 <script>
                                           $('.multipleSelect').fastselect();
                                              </script>
												</div>
												</div>
                                    <div class="col-md-4">
									<div class="text-border">
								
             <select style=" width: 100%;
    height: 40px;
    padding: 0.5em 0.5em 0em 0.5em;
    padding: .28571em .35714em;
}"  data-live-search="true"  name="PLoc" name="Ploc" id="PLoc" data-live-search-placeholder="Select Location" data-actions-box="true">

                                       <option>Select Location</option>
                                   
                                        <?php
										$q1 = "SELECT * FROM tbl_location where Cntry_Id='101' ORDER BY Loc_Name";
										$r1 = mysqli_query($con,$q1);
                                                    
                                                    while($res1 = mysqli_fetch_array($r1)){
                                                    $locName = $res1['Loc_Name'];
                                                    $locId = $res1['Loc_Id'];
                                                   ?>
    <option value="<?php echo $locId;?>" <?php if ($locName==$PLoc){ echo 'selected';}?> ><?php echo $locName;?></option>;
                                        <?php }
                                        ?>       
                                            </select>
                                       								
												</div>
												</div>

                                    <div class="col-md-4">
									<div class="text-border">
									<input type="submit" class="btn btn-success pull-left searchBtn" name="jobsearch" value="SEARCH" onclick="return validate()"></a>
									</div>
									</div>
									
									</div>
									</form>
	
		<div class="col-md-12">
            <div class="intro-para text-center quote">
              <p class="big-text">Exciting Career Opportunities</p>
              <p class="small-text">Get registered with Needyin and Reunite with your immediate family at your preferred
                location.
              </p>

            </div>
		
            <a href="#feature" class="mouse-hover">
              <div class="mouse"></div>
            </a>
         </div>
	
		 </div>
		 </div>
		 </div>
		 </div>
		
  <!--/ Banner-->
  <!--Feature-->
  <section id="feature" class="section-padding">
    <div class="container">
      <div class="row">
        <div class="header-section text-center">
          <h2>How It Works</h2>

          <hr class="bottom-line">
        </div>
        <div class="infoImage">
          <img src="img1/newfinfal02-01.png" class="img-responsive" alt="infoImage">
        </div>
      </div>
  </section>
  <!--/ feature-->
  <!--Organisations-->


  <!--Testimonial-->
  <section id="testimonial" class="section-padding" style="background-image: url(img1/bg-banner2.jpg)">
    <div class="whyNeedyin">
      <div class="container">
        <div class="row">
          <div class="header-section text-center">
            <h2 class="white">Why Needyin</h2>
            <p class="white">Needyin is a unique idea of an online job portal, designed to help people to relocate to their
              hometown with a proper job.</p>

            <hr class="bottom-line bg-white">
          </div>
          <div class="col-md-12 col-sm-12">
            <div class="text-comment">
              <div class="clearfix"></div>
              <div class="col-md-4">
                <div class="text-comment1">
                  <div class="newIcon">
                    <img src="img1/icons/worklife-01.png" class="img-responsive"></div>
                  <h2 class="white1">Only for Needy</h2>
                  <div class="rupeeCont">
                    <p class="white1">We allow only those job seekers to search and apply for a job who have family contingency
                      and are looking for relocation to their hometown.</p>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="text-comment2">
                  <div class="newIcon">
                    <img src="img1/icons/database.png" class="img-responsive">
                  </div>
                  <div class="rupeeCont">
                    <h2 class="white1">Large Employer Database</h2>
                    <p class="white1">We have a large pool of employers and the candidates can select from varied employers
                      in their preferred location and apply for relevant job openings.</p>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="text-comment3">

                  <div class="newIcon">
                    <img src="img1/icons/bgverified.png" class="img-responsive">

                  </div>
                  <div class="rupeeCont">
                    <h2 class="white1">Background Verified Profiles</h2>
                    <p class="white1"> All the profiles uploaded on the portal are verified by our team of experts.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 col-sm-12">
            <div class="text-comment">
              <div class="col-md-4">
                <div class="text-comment4">

                  <div class="newIcon">
                    <img src="img1/icons/money.png" class="img-responsive">
                  </div>
                  <div class="rupeeCont">
                    <h2 class="white1">Salary Expectations</h2>
                    <p class="white1">Sometimes, the profiles aren’t shortlisted or candidates get rejected due to high salary
                      package. Needyin offers a solution that allows job seekers to select the preferred salary range and
                      apply for jobs which pay at par or little lesser.</p>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="text-comment5">

                  <div class="newIcon">
                    <img src="img1/icons/arrow.png" class="img-responsive">
                  </div>
                  <div class="rupeeCont">
                    <h2 class="white1">Easy to Navigate</h2>
                    <p class="white1">Our job portal is very easy to navigate. All a user needs to do is to create an account
                      with us, upload the resume and the documents, select the salary bar, and apply for the job.</p>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="text-comment6">

                  <div class="newIcon">
                    <img src="img1/icons/grab.png" class="img-responsive">
                  </div>
                  <div class="rupeeCont">
                    <h2 class="white1">Grab your dream job</h2>
                    <p class="white1">We do not allow those candidates to apply who are looking for a regular job change.
                      This benefits the job seekers in finding a good job in a lesser period of time.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="text-comment">
              <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="text-comment7">
                   <div class="newIcon">
                    <img src="img1/icons/worklife-01.png" class="img-responsive">
                  </div>
                  <div class="rupeeCont">
                    <h2 class="white1">Better work life balance</h2>
                    <p class="white1"> Register with Needyin and grab your dream job to improve the work life balance of
                      your career.
                    </p>
                  </div> 
                </div>
              </div>
			                <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="text-comment7">
                   <div class="newIcon">
                    <img src="img1/icons/worklife-01.png" class="img-responsive">
                  </div>
                  <div class="rupeeCont">
                    <h2 class="white1">Unique and Distinct </h2>
                    <p class="white1"> Needyin is really unique and distinct from all the other job portals, as it is functioning just to help professionals return to their roots without compromising on their career. Prior, the job seekers have to either compromise on the salary front or on their position if they were rigid on the location of the job.  
                    </p>
                  </div> 
                </div>
              </div>
			                <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="text-comment7">
                   <div class="newIcon">
                    <img src="img1/icons/worklife-01.png" class="img-responsive">
                  </div>
                  <div class="rupeeCont">
                    <h2 class="white1">Unite with Family </h2>
                    <p class="white1"> Professionals with the help of this job site can reunite with their family by finding a good job in their home-town. Posting various job openings from all across the country, Needyin makes great effort in helping professionals return to their home town along with a lucrative job opportunity.   
                    </p>
                  </div> 
                </div>
              </div>
            </div>
		</div>
        </div>
      </div>
    </div>
  </section>
  <!--/ Testimonial-->
  <!--Pricing-->
  <section id="pricing" class="section-padding">
    <div class="container">
      <div class="row">
      <div class="header-section text-center">
          <h2>Top Employers</h2>
          <hr class="bottom-line">
        </div>
      <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-1">
       
        <div class="marque">
          
            <ul class="nav navbar-nav social-links">
             <!-- <li><a href="http://dev.needyin.com/job_company.php?cmpny_id=2"><img src="img1/logo47.png"></a></li>-->
              <li><a href="http://dev.needyin.com/job_company.php?cmpny_id=60"><img src="img1/talisma-logo-e1512382990776.png"></a></li>
              <li><a href="http://dev.needyin.com/job_company.php?cmpny_id=62"><img src="img1/logo62.png"></a></li>
              <li><a href="http://dev.needyin.com/job_company.php?cmpny_id=70"><img src="img1/logo70.png"></a></li>
             
            </ul>
         
        </div>
      </div>
      </div>
    </div>
  </section>
  <!--/ Pricing-->
  <!--Contact-->

  <!--/ Contact-->
  <!--Footer-->
  <footer id="footer" class="footer">
    <div class="container text-center">
      <div class="aboutUs">
        <div class="col-md-3 col-sm-3 col-xs-12">
          <div class="aboutCont">
            <h4>About us....</h4>
            <p>Needyin only allows job seekers who have family contingency and are looking to reunite with their immediate
              family to register in the portal. Register your profile with Needyin and update your career details. Once the
              profile is updated and share your resume you will get latest job openings relevant to your profile at your
              inbox.
            </p>
          </div>
        </div>
      </div>
      <div class="siteMap">
        <div class="col-md-3 col-sm-3 col-xs-12">
          <div class="aboutCont">
            <h4>Site Map</h4>
            <ul>
             <li><a href="job-seeker-login.php">JobSeeker</a></li>
              <li><a href="recruiter.php">EmpolyerLogin</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="getIn">
        <div class="col-md-3 col-sm-3 col-xs-12">
          <div class="aboutCont">
            <h4>Our Product</h4>
            <p>Work Life Balance
            </p>
          </div>
        </div>
      </div>
      <div class="medialinks">
        <div class="col-md-3 col-sm-3 col-xs-12">
          <div class="aboutCont">
            <h4>Get In Touch</h4>
            <ul class="nav nav-navbar">
               <li><a href="https://twitter.com/Needyin"><i class="fa fa-twitter"></i></a></li>
              <li><a href="https://www.facebook.com/needyintechnologies/"><i class="fa fa-facebook"></i></a></li>
              <li><a href="https://plus.google.com/u/0/105538346773411208249?tab=mX"><i class="fa fa-google"></i></a></li>
              <li><a href="https://www.linkedin.com/company/needyintechnologies/"><i class="fa fa-linkedin"></i></a></li>
            </ul>
          </div>
          <div class="address">
            <address>
              <h4>Contact Us</h4>
              <p>MR House, <br>Indian Airlines Colony,<br>Begumpet, Hyderabad, Telangana 500016.</p>
              <div class="clearfix"></div>

            </address>
            <ul class="socialIcon">
              <li>
                <i class="fa fa-mobile" style="font-size:18px;color:#fff"></i>&nbsp+91 912123245</li>
              <li>
                <i class="fa fa-envelope" style="font-size:14px;color:#c03f2f"></i>&nbspinfo@needyin.com </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- End newsletter-form -->
    </div>
  </footer>
  <div class="subfooter">
    <p>©2018 Needyin. All rights reserved Designed by <a href="https://needyin.com/">needyin.com</a> </p>
  </div>
  <!--/ Footer-->

  <script src="js/jquery.easing.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/custom.js"></script>


</body>


</html>
