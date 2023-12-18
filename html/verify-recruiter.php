<?php
session_start();
require_once 'class.user.php';
if(empty($_GET['key']) && empty($_GET['code']))
{
	$user->redirect('index-recruiter.php');
}

if(isset($_GET['key']) && isset($_GET['code']))
{
	$id = base64_decode($_GET['key']);
	$code = $_GET['code'];
	 $stmt="select emp_id,status from tbll_emplyer where emp_id=".$id." and emp_code='".$code."'";
	 $stmt_res=mysqli_query($con,$stmt);
	 $row=mysqli_fetch_array($stmt_res);
	 $rowCount=mysqli_num_rows($stmt_res);
	 if($rowCount > 0)
	{
		if($row['status']==0)
		{			
			$ss="update tbll_emplyer SET status=1 where emp_id=".$id;
			$ss_res=mysqli_query($con,$ss);
			// to add the active status date to the table tbl_emp_admin_updts
			$eau="update tbl_emp_admin_updts SET 1_updts='NOW()' where emp_id=".$id;
			$eau_res=mysqli_query($con,$eau);
			?>
			<script lang="javascript">			
				alert("Your Account is Now Activated");
				window.location='index-recruiter.php';
			</script>		
<?php	  
		}
		else
		{
			?>
			<script lang="javascript">			
				alert("Your Account is Allready Activated ");
				window.location='index-recruiter.php';
			</script>		
		   <?php         
		}
	}
	else
	{?>
	<script lang="javascript">			
		alert(" No Account Found ");
		window.location='index-recruiter.php';
	</script>	
		<?php
	}	
}
?>
<?php  require_once 'class.user.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Needyin</title>
   
    <?php include"source.php" ?>
        <script>
            $(document).ready(function () {
                $('#default, .select-dropdown').focus(function () {
                    $('.pagebanner-in').addClass('darkbg');
                })
                $('#default, .select-dropdown').blur(function () {
                    $('.pagebanner-in').removeClass('darkbg');
                });
            });
        </script>
</head>
<body>
    <?php 
  if(isset($_SESSION['userSession']))
        {
             include "postlogin-header-jobseekar.php"; 
        } else {
    include "prelogin-header.php"; 
    } ?>
       
        <main>
           
            <section class="page-banner-js">
                <div class="pagebanner-in">
                    <div class="bannerin">
                        <div class="container">
                            
                            <div class="row search-home nomrg">
                                <div class="search-home-in newsearch">
                                    <div class="row">
									<?php require_once "search.php";?>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="row">
                                <div class="col-md-12  text-center">
                                   
                                    <article>
                                        <h1 class="h1 txt-white flight ">Exciting Career Opportunities </h1>
                                        <p class="txt-white flight">No matter where you are in your career, chances are you're in need of a little motivation to get to the next step—to go for the job you'll actually love waking up for, to ask for that promotion, or to just push through a rough day. </p>
                                    </article>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
           
            <section class="top-employers">
                <div class="container">
                    <h3 class="h3 text-center flight">Top <span class="fbold">Employers</span></h3>
                   
                    <div class="row">
                        <div class="col-md-2 text-center">
                            <figure>
                                <a href="#!"><img src="img/topemp-ic01.png"> <span class="comp-name">freelancer.com  </span><span class="noofjobs">(225 Jobs)</span></a>
                            </figure>
                        </div>
                        <div class="col-md-2 text-center">
                            <figure>
                                <a href="#!"><img src="img/topemp-ic02.png"> <span class="comp-name">wot if  </span><span class="noofjobs">(225 Jobs)</span></a>
                            </figure>
                        </div>
                        <div class="col-md-2 text-center">
                            <figure>
                                <a href="#!"><img src="img/topemp-ic03.png"> <span class="comp-name">Merck  </span><span class="noofjobs">(225 Jobs)</span></a>
                            </figure>
                        </div>
                        <div class="col-md-2 text-center">
                            <figure>
                                <a href="#!"><img src="img/topemp-ic04.png"> <span class="comp-name">airbnb  </span><span class="noofjobs">(225 Jobs)</span></a>
                            </figure>
                        </div>
                        <div class="col-md-2 text-center">
                            <figure>
                                <a href="#!"><img src="img/topemp-ic05.png"> <span class="comp-name">cisco  </span><span class="noofjobs">(225 Jobs)</span></a>
                            </figure>
                        </div>
                        <div class="col-md-2 text-center">
                            <figure>
                                <a href="#!"><img src="img/topemp-ic06.png"> <span class="comp-name">Fedex  </span><span class="noofjobs">(225 Jobs)</span></a>
                            </figure>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-2 text-center">
                            <figure>
                                <a href="#!"><img src="img/topemp-ic07.png"> <span class="comp-name">Altmetric  </span><span class="noofjobs">(225 Jobs)</span></a>
                            </figure>
                        </div>
                        <div class="col-md-2 text-center">
                            <figure>
                                <a href="#!"><img src="img/topemp-ic08.png"> <span class="comp-name">EUA  </span><span class="noofjobs">(225 Jobs)</span></a>
                            </figure>
                        </div>
                        <div class="col-md-2 text-center">
                            <figure>
                                <a href="#!"><img src="img/topemp-ic09.png"> <span class="comp-name">Ascap  </span><span class="noofjobs">(225 Jobs)</span></a>
                            </figure>
                        </div>
                        <div class="col-md-2 text-center">
                            <figure>
                                <a href="#!"><img src="img/topemp-ic10.png"> <span class="comp-name">Caterpiller  </span><span class="noofjobs">(225 Jobs)</span></a>
                            </figure>
                        </div>
                        <div class="col-md-2 text-center">
                            <figure>
                                <a href="#!"><img src="img/topemp-ic11.png"> <span class="comp-name">Omnibus Press  </span><span class="noofjobs">(225 Jobs)</span></a>
                            </figure>
                        </div>
                        <div class="col-md-2 text-center">
                            <figure>
                                <a href="#!"><img src="img/topemp-ic12.png"> <span class="comp-name">City Pass  </span><span class="noofjobs">(225 Jobs)</span></a>
                            </figure>
                        </div>
                    </div>
                    
                </div>
            </section>
           
            <section class="howwhy">
                <div class="container">
                    <div class="row">
                        
                        <div class="col-md-6">
                            <div class="howitworks-home">
                                <h3 class="h3 pb15">How it works</h3>
                                
                                <div class="row">
                                    <div class="col-md-2 text-center"><img src="img/hiwicon01.png"></div>
                                    <div class="col-md-10">
                                        <article>
                                            <h4 class="h4 fbold">Let us know what you’re looking for</h4>
                                            <p class="text-justify">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                                        </article>
                                    </div>
                                </div>
                                
                                <figure class="text-center"><img src="img/down-arrow.png"></figure>
                                
                                <div class="row">
                                    <div class="col-md-10">
                                        <article class="text-right">
                                            <h4 class="h4 fbold">We will send them to professionals</h4>
                                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                                        </article>
                                    </div>
                                    <div class="col-md-2 text-center"><img src="img/hiwicon02.png"></div>
                                </div>
                               
                                <figure class="text-center"><img src="img/down-arrow.png"></figure>
                              
                                <div class="row">
                                    <div class="col-md-2 text-center"><img src="img/hiwicon03.png"></div>
                                    <div class="col-md-10">
                                        <article>
                                            <h4 class="h4 fbold">He’re your Job done</h4>
                                            <p class="text-justify">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                                        </article>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="howitworks-home yneedyin">
                                <h3 class="h3 pb15">Why Needyin</h3>
                              
                                <div class="row">
                                    <div class="col-md-2 text-center"><img src="img/yneedyicon-01.png"></div>
                                    <div class="col-md-10">
                                        <article>
                                            <p class="text-justify">We allow only those job seekers to search and apply for a job who have family contingency and are looking for relocation to their hometown.</p>
                                        </article>
                                    </div>
                                </div>
                              
                                <div class="row">
                                    <div class="col-md-2 text-center"><img src="img/yneedyicon-02.png"></div>
                                    <div class="col-md-10">
                                        <article>
                                            <p class="text-justify">We have a large pool of employers and the candidates can select from the varied employers in their hometown’s location and apply for the job.</p>
                                        </article>
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-2 text-center"><img src="img/yneedyicon-03.png"></div>
                                    <div class="col-md-10">
                                        <article>
                                            <p class="text-justify">Sometimes, the profiles aren’t shortlisted or candidates get rejected due to high salary package. Thus, we offer an option on our portal that allows the job seekers to select a salary range and apply for those jobs which pay at par or little lesser.</p>
                                        </article>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-2 text-center"><img src="img/yneedyicon-04.png"></div>
                                    <div class="col-md-10">
                                        <article>
                                            <p class="text-justify">All the profiles that are uploaded on the portal are verified by our team of experts. </p>
                                        </article>
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-2 text-center"><img src="img/yneedyicon-05.png"></div>
                                    <div class="col-md-10">
                                        <article>
                                            <p class="text-justify">Our job portal is very easy to navigate. All a user needs to do is create an account with us, upload the resume and the documents, select the salary bar, and apply for the job. </p>
                                        </article>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                       
                    </div>
                </div>
            </section>
          
        </main>
      
        <?php include "footer.php"; ?>
</body>

</html>