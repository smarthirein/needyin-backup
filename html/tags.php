<?php
session_start();
require_once 'class.user.php';
$emp_login = new USER();

if(!$emp_login->is_logged_in())
{
	$emp_login->redirect('dashboard-recruiter.php');
}
		  
$stmt = $emp_login->runQuery("SELECT * FROM tbll_emplyer WHERE emp_id=:rid");
$stmt->execute(array(":rid"=>$_SESSION['empSession']));

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
</head>

<body>
    <?php include"includes-recruiter/db-recruiter-header.php"?>
        <!-- main-->
        <main>
            <!-- tags header -->
            <div class="tags-header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3 class="h3 flight txt-white">My Job Seekers <span class="fbold"> Tags</span></h3>
                            <p>For a quick navigation, save candidates profile sby adding a relevant tag, it work just like a Bookmark!</p>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ tags header -->
            <!-- tags body -->
            <section class="tags-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="tag-card">
                                <div class="numb"> <a href="#!"><h4 class="h4">UI Developers <span class="pull-right fbold">37</span></h4></a> </div>
                                <p class="tag-det"> List of developers have good exposure to UI technologies like javaScript Frameworks, HTML5, CSS3, and could also have UI Design </p> <a class="followers-link" href="#!"><i class="fa fa-heart-o" aria-hidden="true"></i> 20 Followers</a> </div>
                        </div>
                        <div class="col-md-4">
                            <div class="tag-card">
                                <div class="numb"> <a href="#!"><h4 class="h4">Java with Javascript <span class="pull-right fbold">50</span></h4></a> </div>
                                <p class="tag-det"> List of developers have good exposure to UI technologies like javaScript Frameworks, HTML5, CSS3, and could also have UI Design </p> <a class="followers-link" href="#!"><i class="fa fa-heart-o" aria-hidden="true"></i> 20 Followers</a> </div>
                        </div>
                        <div class="col-md-4">
                            <div class="tag-card">
                                <div class="numb"> <a href="#!"><h4 class="h4">PHP Junior Developers <span class="pull-right fbold">75</span></h4></a> </div>
                                <p class="tag-det"> List of developers have good exposure to UI technologies like javaScript Frameworks, HTML5, CSS3, and could also have UI Design </p> <a class="followers-link" href="#!"><i class="fa fa-heart-o" aria-hidden="true"></i> 20 Followers</a> </div>
                        </div>
                        <div class="col-md-4">
                            <div class="tag-card">
                                <div class="numb"> <a href="#!"><h4 class="h4">PHP Senior Developers <span class="pull-right fbold">37</span></h4></a> </div>
                                <p class="tag-det"> List of developers have good exposure to UI technologies like javaScript Frameworks, HTML5, CSS3, and could also have UI Design </p> <a class="followers-link" href="#!"><i class="fa fa-heart-o" aria-hidden="true"></i> 20 Followers</a> </div>
                        </div>
                        <div class="col-md-4">
                            <div class="tag-card">
                                <div class="numb"> <a href="#!"><h4 class="h4">PHP Tech Leads <span class="pull-right fbold">37</span></h4></a> </div>
                                <p class="tag-det"> List of developers have good exposure to UI technologies like javaScript Frameworks, HTML5, CSS3, and could also have UI Design </p> <a class="followers-link" href="#!"><i class="fa fa-heart-o" aria-hidden="true"></i> 20 Followers</a> </div>
                        </div>
                        <div class="col-md-4">
                            <div class="tag-card">
                                <div class="numb"> <a href="#!"><h4 class="h4">UX Designers<span class="pull-right fbold">37</span></h4></a> </div>
                                <p class="tag-det"> List of developers have good exposure to UI technologies like javaScript Frameworks, HTML5, CSS3, and could also have UI Design </p> <a class="followers-link" href="#!"><i class="fa fa-heart-o" aria-hidden="true"></i> 20 Followers</a> </div>
                        </div>
                        <div class="col-md-4">
                            <div class="tag-card">
                                <div class="numb"> <a href="#!"><h4 class="h4">HR Executive<span class="pull-right fbold">37</span></h4></a> </div>
                                <p class="tag-det"> List of developers have good exposure to UI technologies like javaScript Frameworks, HTML5, CSS3, and could also have UI Design </p> <a class="followers-link" href="#!"><i class="fa fa-heart-o" aria-hidden="true"></i> 20 Followers</a> </div>
                        </div>
                        <div class="col-md-4">
                            <div class="tag-card">
                                <div class="numb"> <a href="#!"><h4 class="h4">Android Developers<span class="pull-right fbold">20</span></h4></a> </div>
                                <p class="tag-det"> List of developers have good exposure to UI technologies like javaScript Frameworks, HTML5, CSS3, and could also have UI Design </p> <a class="followers-link" href="#!"><i class="fa fa-heart-o" aria-hidden="true"></i> 20 Followers</a> </div>
                        </div>
                        <div class="col-md-4">
                            <div class="tag-card">
                                <div class="numb"> <a href="#!"><h4 class="h4">Executive Manager<span class="pull-right fbold">37</span></h4></a> </div>
                                <p class="tag-det"> List of developers have good exposure to UI technologies like javaScript Frameworks, HTML5, CSS3, and could also have UI Design </p> <a class="followers-link" href="#!"><i class="fa fa-heart-o" aria-hidden="true"></i> 20 Followers</a> </div>
                        </div>
                        <div class="col-md-4">
                            <div class="tag-card">
                                <div class="numb"> <a href="#!"><h4 class="h4">Engineering Manager<span class="pull-right fbold">37</span></h4></a> </div>
                                <p class="tag-det"> List of developers have good exposure to UI technologies like javaScript Frameworks, HTML5, CSS3, and could also have UI Design </p> <a class="followers-link" href="#!"><i class="fa fa-heart-o" aria-hidden="true"></i> 20 Followers</a> </div>
                        </div>
                        <div class="col-md-4">
                            <div class="tag-card">
                                <div class="numb"> <a href="#!"><h4 class="h4">Selinium Test Engineer<span class="pull-right fbold">37</span></h4></a> </div>
                                <p class="tag-det"> List of developers have good exposure to UI technologies like javaScript Frameworks, HTML5, CSS3, and could also have UI Design </p> <a class="followers-link" href="#!"><i class="fa fa-heart-o" aria-hidden="true"></i> 20 Followers</a> </div>
                        </div>
                        <div class="col-md-4">
                            <div class="tag-card">
                                <div class="numb"> <a href="#!"><h4 class="h4">Program Manager<span class="pull-right fbold">37</span></h4></a> </div>
                                <p class="tag-det"> List of developers have good exposure to UI technologies like javaScript Frameworks, HTML5, CSS3, and could also have UI Design </p> <a class="followers-link" href="#!"><i class="fa fa-heart-o" aria-hidden="true"></i> 20 Followers</a> </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--/ tags body -->
        </main>
        <!--/main-->
        <?php include"footer.php" ?>
</body>

</html>