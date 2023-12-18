<?php 
echo $d_cnt=count($c_ids);

$_SESSION['mcnt']=$d_cnt;
if($d_cnt>0)
{
foreach($c_ids as $cid)
{

 $sql1= "SELECT J.JFullName,J.JUser_Id,J.JPhoto,J.currentdate,J.JTotalEy,J.JPLoc_Id,Jd.Company_Name,Jd.NoticePeriod,Jd.Des,Jd.NoticePeriod,L.Loc_Name,Jd.CurrentSalL,Jd.CurrentSalT,
Jd.ExpSalL,Jd.ExpMaxSalL,qo.Qual_Name
FROM tbl_jobseeker J
JOIN tbl_currentexperience Jd ON J.JUser_Id = Jd.JUser_Id
JOIN tbl_location L on J.JpLoc_Id=L.Loc_Id
LEFT JOIN tbl_education Ed on J.JUser_Id= Ed.JUser_Id 
LEFT JOIN tbl_qualification qo on Ed.Qual_Id=qo.Qual_Id  where J.JuserStatus='A' AND  J.JUser_Id='".$cid."'
Group by J.JUser_Id 
ORDER BY J.JUser_Id DESC ";
$sql1_res=mysqli_query($con,$sql1);
$row2 = mysqli_fetch_array($sql1_res);

?>
<div class="row">
    <!-- block -->
	
	
	
    <div class="mb15">
        <div class="brdbg-white list-block-db row">
            <!-- job seekers block top results -->
            <div class="col-md-5 col-sm-12">
                <div class="row">
                <div class="col-md-4 col-sm-2 col-xs-12">
                    <figure class="js-list-pic">
                        <img class="img-cover" data-object-fit="cover" src="<?php if($row2['JPhoto']){  echo  $row2['JPhoto']; }else {?>img/nav-login-recruiter-img.jpg <?php } ?>">
                    </figure>
                </div>
                <div class="col-md-8 col-sm-10 col-xs-12 mobcenter">
                    <a href="jobseeker-detail-recruiter.php?uid=<?php echo $row2['JUser_Id'] ?>" class="name">
                        <h4 class="h4 txt-blue"><?php echo $row2['JFullName']; ?></h4>
                        <h5><?php echo $row2['Des']; ?></h5>
                        <p><?php echo $row2['Company_Name']; ?></p>
                    </a> <span class="notice-list"><?php //echo $row2['NoticePeriod']; ?><?php if($row2['NoticePeriod']=='1'){echo "Immediate";}else {echo $row2['NoticePeriod']; }?> days Notice</span> </div>
            </div>
            </div>
            <div class="col-md-7">
                
            <div class="row">
                <div class="col-md-12">
                    <table width="100%" cellpadding="0" cellspacing="0" class="list-table">
                        <tr>
                            <td><i class="fa fa-black-tie" aria-hidden="true"></i></td>
                            <td class="grtxt"> Prof. Experience </td>
                            <td><?php echo $row2['JTotalEy']; ?> Years - <?php echo $row2['JTotalEm']; ?> Months</td>   
                            <td><i class="fa fa-map-marker" aria-hidden="true"></i></td>
                            <td class="grtxt"> Preffered Location </td>
                            <td><?php echo $row2['Loc_Name']; ?></td>
                        </tr> 
                        <tr>
                            <td><i class="fa fa-inr" aria-hidden="true"></i></td>
                            <td class="grtxt"> Current Package (Lacs)</td>
                            <td><?php echo $row2['CurrentSalL']; ?></td>
                            <td><i class="fa fa-inr" aria-hidden="true"></i></td>
                            <td class="grtxt">Exp CTC (Lacs)</td>
                            <td>Min <?php echo $row2['ExpSalL']; ?></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-graduation-cap" aria-hidden="true"></i></td>
                            <td class="grtxt"> Education </td>
                            <td><?php echo $row2['Qual_Name']; ?></td>
                            <td><i class="fa fa-calendar" aria-hidden="true"></i></td>
                           	<td class="grtxt"> Last Active:</td>
								<td>
									<?php 
									 $nt_querys="select `Date&time` from tbl_recent_views where userid='".$row2['JUser_Id']."' order by `Date&time` DESC";
									$nt_ress=mysqli_query($con,$nt_querys);
									$datas_sws=mysqli_fetch_array($nt_ress);
									
									$date=date_create($datas_sws['Date&time']);
									echo date_format($date,"M d,Y");
									?>
								</td>
                        </tr>
                    </table>
                    
                </div>
                 
            </div>
           
            </div>
          
             <div class="">
                <div class="col-md-12">
                    <h6 class="h6">Skills</h6><p class="skills-js-list">
					<?php 
                        $sql = "SELECT * FROM tbl_jobseeker WHERE JUser_Id=".$row2['JUser_Id'];
                                                                            $result = mysqli_query($con,$sql);
                                                                            $row1 = mysqli_fetch_array($result);
                                                                            $skills=$row1['Job_Skills'];
                                                                            $skill_ids=explode(",",$skills);?>
					<p class="skills-js-list"><?php foreach($skill_ids as $skillid)  
                    { 
                        $ms_sql1="select * from tbl_masterskills where skill_Id=".$skillid;
                                           $ms_result1 = mysqli_query($con,$ms_sql1);
                                           $ms_data1 = mysqli_fetch_array($ms_result1);?>      
                    <span><?php echo $ms_data1['skill_Name']; ?></span> 
                    <?php } ?> </p>
                </div>
            </div>
     
           
           
        </div>
    </div>
   
</div>
<?php } 
} else {?>
    
    
    <div class="noprofiles-available text-center">
<h3 class="h3">Sorry we couldn't find any matches </h3>

<figure><img src="img/nofound.svg"></figure>
</div>
<?php } ?>