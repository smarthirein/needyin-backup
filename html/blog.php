<?php 
require_once 'class.user.php'; ?>
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
    
        <main>
       
            <section class="page-title-block">
                <div class="container">
                    <article class="page-titlein">
                        <h2 class="h2 flight txt-white">Blog of <span class="fbold"> Needyin</span></h2>
                 
                    </article>
                </div>
            </section>
      
            <section class="page-content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <figure class="text-center under-img"><img src="img/pageunder-construction.jpg" class="img-responsive"></figure>
                        </div>
                    </div>
                </div>
            </section>
   
        </main>
      
        <?php include"footer.php"?>
</body>

</html>