<?php
require_once '../class.user.php';
$adm_login = new USER();				  
$stmt = $adm_login->runQuery("SELECT * FROM tbl_admin Re							
                              WHERE Re.id=:rid");
$stmt->execute(array(":rid"=>$_SESSION['adminSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$activePage = basename($_SERVER['PHP_SELF'], ".php");
$nt_query="select count(id)as sids from tbl_notifications where notification_to='".$_SESSION['adminSession']."' and profile_id !='' and mode='admin'  and notification_read=0";
$nt_res=mysqli_query($con,$nt_query);
$datas_sw=mysqli_fetch_array($nt_res);
 $nt_query1="select count(id)as emids from tbl_notifications where notification_to='".$_SESSION['adminSession']."' and job_owner_id !='' and mode='admin'  and notification_read=0";
$nt_res1=mysqli_query($con,$nt_query1);
$datas_sw1=mysqli_fetch_array($nt_res1);

?>
<div class="db-recruiter-header">
    <nav class="navbar navbar-static-top">
        <div class="container nopadmob">
            <div class="navbar-header">
                <a class="navbar-brand" href="dashboard-recruiter.php" alt="needyin" id="logo"><img src="../img/logo-white.svg" alt="needyin"></a>
            </div>
            <button class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
            <div class="collapse navbar-collapse navHeaderCollapse">
                <ul class="nav navbar-nav navbar-right">
                  <!--  <li class="<?php if($activePage == 'dashboard-admin') { echo 'active';}?>" ><a href="dashboard-admin.php"><span class="icon-nav"><i class="fa fa-tachometer" aria-hidden="true"></i></span>Dashboard</a></li>
                    -->
					 <li class="<?php if($activePage == 'profiles-latest') { echo 'active';} ?>"><a href="profiles-latest.php"><span class="icon-nav"><i class="fa fa-user-o" aria-hidden="true"></i></span>PROFILES</a></li>
                    <li class="<?php if($activePage == 'employers-latest'){ echo 'active';}?>"><a href="employers-latest.php"><span class="icon-nav"><i class="fa fa-list-alt" aria-hidden="true"></i></span>Employers</a></li>
                    
                 <li class="<?php if($activePage == 'all_jobs.php'){ echo 'active';}?>"><a href="all_jobs.php"><span class="icon-nav"><i class="fa fa-list-alt" aria-hidden="true"></i></span>All Jobs</a></li>
                    <li class="dropdown brdleft" > <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="icon-nav"><?php echo  $row['adm_Name'];?></span><?php echo $row["companyname"]?><span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">                           
                            <li class="<?php if($activePage == 'admin-update-password') { echo 'active';}?>"><a href="admin-update-password.php"><i class="fa fa-unlock-alt" aria-hidden="true"></i> Change Password</a></li>
							<li class="<?php if($activePage == 'notifications-admin') { echo 'active';} ?>"><a href="notifications-admin.php"><i class="fa fa-envelope-o" aria-hidden="true"></i> Notifications Jobseeker(<?php echo $datas_sw['sids'] ?>)</a></li>
							<li class="<?php if($activePage == 'notifications-admin-emp') { echo 'active';} ?>"><a href="notifications-admin-emp.php"><i class="fa fa-envelope-o" aria-hidden="true"></i> Notifications Employer(<?php echo $datas_sw1['emids'] ?>)</a></li>
                            <li class="<?php if($activePage == 'logout') { echo 'active';} ?>"><a href="../logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
                        </ul>
                    </li>
          
                </ul>
            </div>
        </div>
    </nav>
</div>
<style>
table.dataTable thead>tr>th.sorting_asc, table.dataTable thead>tr>th.sorting_desc, table.dataTable thead>tr>th.sorting, table.dataTable thead>tr>td.sorting_asc, table.dataTable thead>tr>td.sorting_desc, table.dataTable thead>tr>td.sorting
{
font-size:10px;
}

table.table-bordered.dataTable tbody th, table.table-bordered.dataTable tbody td{
	font-size:12px;
}
.postedjobs table.dataTable td a{
	font-size:11px;
	color:blue;
}
button[disabled], html input[disabled] {
    cursor: default;
    height: 25px !important;
}
select{
	height: 25px !important;
}
.other-inputs{
	height:25px !important;
}
</style>
