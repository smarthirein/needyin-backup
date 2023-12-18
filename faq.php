<?php require_once 'class.user.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ</title>
   
    <?php include"source.php" ?>
</head>

<body>
    <?php 
	include_once("analyticstracking.php");
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
    include "prelogin-header2.php"; 
  } 
	?>
    
        <main>
            
            <section class="page-title-block">
                <div class="container">
                    <article class="page-titlein">
                        <h2 class="h2 flight txt-white">Frequently <span class="fbold">Asked Questions</span></h2>
                        
                    </article>
                </div>
            </section>
           
         
            <section class="page-content">
                <div class="container">
                    <div class="row faq">
                        <div class="col-md-6">
                            <h4 class="flight h4 cont-titl">FAQ<font size="2">s</font> by <span class="fbold"> Recruiters</span></h4>
                            <div class="row pt15">
                                <!--accordian-->
                                <ul class="collapsible" data-collapsible="accordion">
                                    <li>
                                        <div class="collapsible-header">What is Needyin?</div>
                                        <div class="collapsible-body">
                                            <p class="text-justify">Needyin strives to bring together professionals and opportunities which enable them to balance their priorities for handling critical phases in one’s professional & personal lives.</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="collapsible-header">What kind of employees can we find in the needyin.com?</div>
                                        <div class="collapsible-body">
                                            <p class="text-justify">You will find candidate profiles with different skill sets related to IT industry. The candidates registered in the portal are the closest match to your requirements within your budget and location proximity. </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="collapsible-header">How can I upload my requirement in Needyin and how much it costs?</div>
                                        <div class="collapsible-body">
                                            <p class="text-justify">You have to sign-up with your registered company profile in needyin.com to start posting the job requirements and which is at free of cost.</p>
                                            
                                        </div>
                                    </li>
                                    <li>
                                        <div class="collapsible-header">Is it necessary to get registered in Needyin to upload the jobs?</div>
                                        <div class="collapsible-body">
                                            <p class="text-justify">Yes, you need to register in the portal using your official email id and password to start posting your requirements.</p>
                                        </div>
                                    </li>
                                    
                                    <li>
                                        <div class="collapsible-header">I uploaded my requirement but it’s not showing in the list. Whom to contact?</div>
                                        <div class="collapsible-body">
                                            <p class="text-justify">If the job requirement is not updated on the website after 24 hours of posting, you can send an email to info@needyin.com. </p>
                                        </div>
                                    </li>
                                    
                                </ul>
                              
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4 class="flight h4 cont-titl">FAQ<font size="2">s</font> by <span class="fbold"> Jobseekers </span></h4>
                            <div class="row pt15">
                              
                                <ul class="collapsible" data-collapsible="accordion">
                                    <li>
                                        <div class="collapsible-header">What is Needyin?</div>
                                        <div class="collapsible-body">
                                            <p class="text-justify">Needyin strives to bring together professionals and opportunities which enable them to balance their priorities for handling critical phases in one’s professional & personal lives.</p>
                                           <!-- <p class="text-justify">This need corrections and new punch line should be added</p>-->
                                        </div>
                                    </li>
                                    <li>
                                        <div class="collapsible-header">Who can register in needyin.com?</div>
                                        <div class="collapsible-body">
                                            <p class="text-justify">Any experienced professional, facing a problem in balancing their priorities for handling critical phases in one’s professional & personal lives, and wants to relocate, to take care of their situations in control for a short term to long term view.</p>
                                            <p>What are the documents required to register in Needyin? </p>
                                            
                                            <ul class="faqlist">
                                                <li><i class="fa fa-angle-double-right" aria-hidden="true"></i> Scanned photo copy, </li>
                                                <li><i class="fa fa-angle-double-right" aria-hidden="true"></i> A proof for the reason to relocate - Medical Certificates, Family Photo etc.</li>
                                                <li> <i class="fa fa-angle-double-right" aria-hidden="true"></i> Educational Certificates </li>
                                               
                                            </ul>
                                           
                                        </div>
                                    </li>
                                    <li>
                                        <div class="collapsible-header">Why do we have to upload supporting documents?</div>
                                        <div class="collapsible-body">
                                            <p class="text-justify">The supporting documents are required to be verified and validated for the genuineness of the cause or reason to relocate. </p>
                                        </div>
                                    </li>
                                   
                                    <li>
                                        <div class="collapsible-header">Is there any restriction for applying jobs? </div>
                                        <div class="collapsible-body">
                                            <p class="text-justify">There is no restriction in applying for jobs. You can apply for all the relevant job openings available in the portal as per your preferred criteria. </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="collapsible-header">How do I know if a recruiter is viewing my profile?</div>
                                        <div class="collapsible-body">
                                            <p class="text-justify">If your profile is downloaded/viewed/shortlisted then you will get alerts/notifications on your registered email-id. </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="collapsible-header">How can recruiters connect with me? </div>
                                        <div class="collapsible-body">
                                            <p class="text-justify">Your profile details are visible to the recruiters, who want to connect with you. If your profile is shortlisted, you will receive an email or a call from the recruiter. </p>
                                        </div>
                                    </li>
                                    
                                     <li>
                                        <div class="collapsible-header">How do I deactivate my account?  </div>
                                        <div class="collapsible-body">
                                            <p class="text-justify">You can unsubscribe using DND settings. </p>
                                        </div>
                                    </li>
                                </ul>
                           
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
        </main>
     
        <?php //include"footer.php"?>
</body>

</html>