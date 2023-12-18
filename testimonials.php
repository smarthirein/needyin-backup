<?php require_once 'class.user.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Needyin</title>
    <!-- css includes-->
    <?php include"source.php" ?>
        <script type="text/javascript" src="js/jquery.bootstrap-responsive-tabs.min.js"></script>
</head>

<body>
     <?php 
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
    include "prelogin-header.php"; 
  } 
	?>
        <!-- main-->
        <main>
            <!-- page title --> 
            <section class="page-title-block">
                <div class="container">
                    <article class="page-titlein">
                        <h2 class="h2 flight txt-white">Testimonials of <span class="fbold">  Jobseekers and Employers</span></h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                    </article>
                </div>
            </section>
            <!--/ page title -->
            <!-- page static content body -->
            <section class="page-content">
                <div class="container">
                    <div class="row testi-page">
                        <div class="row">
                           <div class="col-md-6">
                               <h4 class="h4 testtitle">Testimonials of Jobseekers</h4>
                               <div class="row">
                                        <div class="col-md-12">
                                            <div class="testi-div">
                                                <figure><img class="img-cover" data-object-fit="cover" src="img/profile-pic.jpg"></figure>
                                                <article class="testi-desc">
                                                    <p class="text-justify"> <span><i class="fa fa-quote-left" aria-hidden="true"></i></span>Needyin is a life changer as it puts job seekers in the centre and on demand. I heard about this site from my friend and it was truly a great thing to know about such an initiative. The best part is that you get a notification even when an employer views your profile.</p>
                                                    <h5 class="h5 fbold">DINESH KUMAR SAHU <span class="txt-blue ">Chennai</span></h5> </article>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="testi-div">
                                                <figure><img class="img-cover" data-object-fit="cover" src="img/profile-pic1.jpg"></figure>
                                                <article class="testi-desc">
                                                    <p class="text-justify"> <span><i class="fa fa-quote-left" aria-hidden="true"></i></span>Needyin is a life changer as it puts job seekers in the centre and on demand. I heard about this site from my friend and it was truly a great thing to know about such an initiative. The best part is that you get a notification even when an employer views your profile.</p>
                                                    <h5 class="h5 fbold">SHIVANAGOUDA B.B <span class="txt-blue ">Bengaluru</span></h5> </article>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="testi-div">
                                                <figure><img class="img-cover" data-object-fit="cover" src="img/profile-pic1.jpg"></figure>
                                                <article class="testi-desc">
                                                    <p class="text-justify"> <span><i class="fa fa-quote-left" aria-hidden="true"></i></span>Needyin is a life changer as it puts job seekers in the centre and on demand. I heard about this site from my friend and it was truly a great thing to know about such an initiative. The best part is that you get a notification even when an employer views your profile.</p>
                                                    <h5 class="h5 fbold">TAMILSELVAN R <span class="txt-blue"> New Delhi </span></h5> </article>
                                            </div>
                                        </div>
                                    </div>
                               </div>
                               <div class="col-md-6">
                                <h4 class="h4 testtitle">Testimonials of Recruiters</h4>
                                <div class="row">
                                        <div class="col-md-12">
                                            <div class="testi-div">
                                                <figure><img class="img-cover" data-object-fit="cover" src="img/profile-pic.jpg"></figure>
                                                <article class="testi-desc">
                                                    <p class="text-justify"> <span><i class="fa fa-quote-left" aria-hidden="true"></i></span>Needyin is a life changer as it puts job seekers in the centre and on demand. I heard about this site from my friend and it was truly a great thing to know about such an initiative. The best part is that you get a notification even when an employer views your profile.</p>
                                                    <h5 class="h5 fbold">DINESH KUMAR SAHU <span class="txt-blue ">Chennai</span></h5> </article>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                             <div class="testi-div">
                                                <figure><img class="img-cover" data-object-fit="cover" src="img/profile-pic.jpg"></figure>
                                                <article class="testi-desc">
                                                    <p class="text-justify"> <span><i class="fa fa-quote-left" aria-hidden="true"></i></span>Needyin is a life changer as it puts job seekers in the centre and on demand. I heard about this site from my friend and it was truly a great thing to know about such an initiative. The best part is that you get a notification even when an employer views your profile.</p>
                                                    <h5 class="h5 fbold">DINESH KUMAR SAHU <span class="txt-blue ">Chennai</span></h5> </article>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                             <div class="testi-div">
                                                <figure><img class="img-cover" data-object-fit="cover" src="img/profile-pic.jpg"></figure>
                                                <article class="testi-desc">
                                                    <p class="text-justify"> <span><i class="fa fa-quote-left" aria-hidden="true"></i></span>Needyin is a life changer as it puts job seekers in the centre and on demand. I heard about this site from my friend and it was truly a great thing to know about such an initiative. The best part is that you get a notification even when an employer views your profile.</p>
                                                    <h5 class="h5 fbold">DINESH KUMAR SAHU <span class="txt-blue ">Chennai</span></h5> </article>
                                            </div>
                                        </div>
                                    </div>
                                   </div>
                                </div>
                            <!--/tab--> 
                        </div>
                    </div>
            </section>
            <!--/ page static content body -->
        </main>
        <!--/main-->
        <?php include"footer.php"?>
            
</body>

</html>