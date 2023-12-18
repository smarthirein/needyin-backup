<?php 
session_start();
require_once("config.php");
require_once 'class.user.php';
$user_home = new USER();
 
if(!isset($_SESSION['empSession']))
{
		 $user_home->redirect('index-recruiter.php');
} 
	
$stmt = $user_home->runQuery("SELECT * FROM tbll_emplyer WHERE emp_id=:eid");
$stmt->execute(array(":eid"=>$_SESSION['empSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$JUser_Id=$_REQUEST['uid'];
/*
$notification_id=$_REQUEST['noti_id'];*/
/*
$read_noti="UPDATE tbl_notifications SET notification_read=1 WHERE id='".$notification_id."'";
mysqli_query($con,$read_noti);
$profile_user_id = trim($JUser_Id);
$visitor_user_id = trim($row['emp_id']); */
    
$jc1= "SELECT * FROM tbl_jobseeker WHERE JUser_Id='".$JUser_Id."'";
$jresult1 = mysqli_query($con,$jc1);
$jrow = mysqli_fetch_array($jresult1);

// $c1= "SELECT * FROM tbl_currentexperience   WHERE JUser_Id=".$JUser_Id;
// $result1 = mysqli_query($con,$c1);
// $row1 = mysqli_fetch_array($result1);

$c3="Select Loc_Id,Loc_Name from tbl_location where Loc_Id=".$jrow['JPLoc_Id'];
$result3 = mysqli_query($con,$c3);
$row3= mysqli_fetch_array($result3); 

// $c4="Select Loc_Id,Loc_Name from tbl_location where Loc_Id=".$row1['Loc_Id'];
// $result4 = mysqli_query($con,$c4);
// $row4= mysqli_fetch_array($result4); 

$jc2= "SELECT Job_Name,Comp_Name,Job_Id FROM tbl_jobposted WHERE emp_id='".$row['emp_id']."' and Job_Status=1"; 
$jresult2 = mysqli_query($con,$jc2);
$jrow2 = mysqli_fetch_array($jresult2);

/*$noti_query="select * from tbl_notifications where notification_to='".$_SESSION['empSession']."' and mode='jobseeker'";
$noti_res=mysqli_query($con,$noti_query);
$notif_cnt=mysqli_num_rows($noti_res);*/

$sql3= "SELECT Job_Skill,Min_Exp,Sal_Range,MSal_Range,emp_id,Job_Id from tbl_jobposted  where  emp_id='".$row['emp_id']."'  and Job_Status=1";
                  $result6 = mysqli_query($con,$sql3); 
                  $cc=mysqli_num_rows($result6);   
                  $rowview2 = mysqli_fetch_array($result6);  
                
                  $jskills="SELECT Job_Skills,JTotalEy,cur_expl.ExpSalL,cur_expl.ExpMaxSalL from tbl_jobseeker INNER JOIN tbl_currentexperience as cur_expl on cur_expl.JUser_Id = tbl_jobseeker.JUser_Id where tbl_jobseeker.JUser_Id=".$JUser_Id;
                  $jobfitresult = mysqli_query($con,$jskills);   
                  $jobfitmentrow = mysqli_fetch_array($jobfitresult);  
                  
                  $jobfitskills=explode(',',$jobfitmentrow['Job_Skills']);
                  $empskills=explode(',',$rowview2['Job_Skill']);
				  $common_skills=array_intersect($jobfitskills,$empskills);
                  $skill_percent=(count($common_skills)/count($jobfitskills))*100;
                if($jobfitmentrow['JTotalEy']>=$rowview2['Min_Exp'])
                  {
                      $exp_percent=100;
                  }
                  else
                  {
                      $exp_percent=($jobfitmentrow['JTotalEy']/$rowview2['Min_Exp'])*100;
             
                  }

                  if($jobfitmentrow['ExpMaxSalL']>=$rowview2['Sal_Range'])
                  {
                      $ctc_percent=100;
                  }
                  else
                  {
                      $ctc_percent=($jobfitmentrow['ExpMaxSalL']/$rowview2['Sal_Range'])*100;
                  }
                  $overall=($skill_percent+$exp_percent+$ctc_percent)/3;
				  
				  
if(isset($_SESSION['userSession']))
{
$jobseekerid=$_SESSION['userSession'];
$sqlinsert="INSERT INTO `tbl_jobseekerview` (`emp_id`, `JUser_Id`, `job_id`) VALUES ('$uid','$jobseekerid','$jid')";
mysqli_query($con,$sqlinsert);
}	   
                  $actual_link = "$_SERVER[REQUEST_URI]"; 
                  
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Persona</title>
  <meta charset="utf-8">
  <link rel="shortcut icon" href="img2/favicon.ico" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/style2.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
  <script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>
 
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
				
		<style>
        body {
            font-family: "Arial", sans-serif;
        }
        
        .bar {
            fill: #5f89ad;
        }
        
        .axis {
            font-size: 10px;
        }
        
        .axis path,
        .axis line {
            fill: none;
            display: none;
        }
        
        .label {
            font-size: 10px;
        }
        .modal .modal-content {
           padding: 0px !important;
         }
		
    </style> 
	



<body>
  <header class="personaHeader">
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="col-md-12 col-sm-12 col-xs-4">
        <div class="navbar-header mainTitle">
          <a class="#" href="#"><h4><?php  echo $jrow['JFullName']; ?><!--Ramesh Garikamokkala--></h4></a>
        </div>
        </div>
      </div>
    </nav>
  </header>
  <!---Header Ends--->
  <!---Seacond start-->
 
  <section>
    <div class="container-fluid personaContent">
      <div class="col-md-12 col-sm-12 col-xs-4">
        <div class="col-md-4 col-sm-12 col-xs-12">
        <img src="<?php echo $jrow['JPhoto']; ?>" class="img-responsive personaImg" style = "width:100%;height:100%;">
        <!-- <style>img.img-responsive.personaImg {
          height:200%;
    width: 100%;
}</style> -->
      <img src="img/jsprofilelistpic.png">
		  <div class="imgContent">
		    <ul class="mainContent">
			   <li> Designation:<?php echo $jrow['Job_Id']; ?></li>
			   <li>Status:<?php if($row1['NoticePeriod']=='1'){ echo "Immediate"; } else {echo $row1['NoticePeriod']; ?> <?php }?>
     
              </li>
				<li>Location :<?php echo $row3['Loc_Name']; ?> </li>
                                                
				<!-- <li>Contact No:+91 <?php/* echo $jrow['JPhone'];*/ ?></li> -->
			</ul>
		  </div>
        </div>

        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="col-md-12 col-sm-12 col-xs-12 mainHeader">
            <h6>Personal Information</h6>
          </div>
          <div class="form">
            <form>
              <div class="form-group">
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                  <input type="email"  value="Email Id:<?php echo $jrow['JEmail']; ?>" class="form-control" id="inputEmail4"readonly>
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="inputPassword4"value="Experience:<?php echo $jrow['JTotalEy']; ?> Years - <?php echo $jrow['JTotalEm']; ?> Months"  readonly>
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="inputEmail4"value="Current CTC(Lacs):<?php echo $row1['CurrentSalL']; ?>"readonly> 
                                                
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="inputPassword4"value="Expected CTC(Lacs)Min:<?php echo $row1['ExpSalL'];  ?> - Max: <?php echo $row1['ExpMaxSalL']; ?>  " readonly>
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="inputEmail4"value="Location:<?php echo $row4['Loc_Name'] ?>"readonly>
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="inputPassword4" value="Notice Period:<?php if($row1['NoticePeriod']=='1'){ echo "Immediate"; } else {echo $row1['NoticePeriod']; ?> days<?php }?>" readonly>
     
                </div>
				 <div class="form-group col-md-12 col-sm-12 col-xs-12">
				 <input type="text" class="form-control" rows ="2" id="inputPassword4" value="Details:<?php echo $jrow['profile_summary']; ?>"readonly>
                  <!--<textarea class="form-control" rows="2" id="comment" placeholder="ProfileSummary" value=" <?php echo $row1['profile_summary']; ?>"></textarea>-->
                </div>	
                 	<div class="form-group col-md-12 col-sm-12 col-xs-12">
				  <button type="button" class="btn btn-success pull-left"> <a href="jobseeker-detail-recruiter-blocklist.php?uid=<?php echo $jrow['JUser_Id'] ?>">More-PersonalInfo</a></button>
				</div> 
        </div>			
        </form>		
        </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">		
          <div class="col-md-12 col-sm-12 col-xs-12 mainHeader">		  
            <h6>Professional Experience</h6>
          </div>
          <div class="form2">
            <form>
              <div class="form-group">
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
               <input type="email" class="form-control" id="inputEmail4" value="CompanyName:<?php echo $row1['Company_Name'];?>"readonly>
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="inputPassword4"value="Designation:<?php echo $row1['Des']; ?>"readonly>
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                 <input type="email" class="form-control" id="inputEmail4" value="DoJ:<?php echo($row1['doJ']);
							// echo date_format($date,"M d,Y");?>"readonly> 
				 
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                <input type="text" class="form-control" id="inputPassword4" placeholder="Date of Relieved" value="currently Working "readonly>
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                  <input type="email" class="form-control" id="inputEmail4" value="Location:<?php  echo $row4['Loc_Name'];
                                                //         {
                                                //             $cnt= "SELECT * FROM  tbl_country  WHERE Cntry_Id=".$row1['Loc_Id'];
                                                //             $cnt_res = mysqli_query($con,$cnt);
                                                //             $cnt_data = mysqli_fetch_array($cnt_res);
                                                //             $cloc_name=$cnt_data['Cntry_Name'];
                                                //         } else
                                                //         {
                                                //             $cloc_name=$row4['Loc_Name'];
                                                //         }
                                                // echo $cloc_name; ?>"readonly> 
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="inputPassword4" <?php $user_query="select Func_Name from tbl_functionalarea where Func_Id='".$jrow['Func_Id']."'";
						 $rr= mysqli_query($con,$user_query); $rrs=mysqli_fetch_array($rr); ?> value="Roles:<?php echo $rrs['Func_Name']; ?>" readonly>
                </div>
				<div class="form-group col-md-12 col-sm-12 col-xs-12">
                  <input type="text" class="form-control" rows ="2" id="inputPassword4" value="JobDes:<?php echo $row1['JDesc']; ?>" readonly>
                </div>
				<div class="form-group col-md-12 col-sm-12 col-xs-12">
				 <button type="button" class="btn btn-success pull-left"><a href="jobseeker-detail-recruiter-blocklist.php?uid=<?php echo $jrow['JUser_Id']?>/">More-ProfessionalExperience</button>
				</div>
        </div>
        </form>
        </div>
        </div>
		<div class="container-fluid">
		<div class= "row">
		 <div class="col-md-2 col-sm-12 col-xs-12">
        <div class="keyContent">		 
			  <div class="mainHeader">		  
       <h6>Skills</h6>
			  </div>
			  <div class="col-md-2 col-sm-15 col-xs-15">
				<div class="keySkillsContent">				
        <?php   $sql = "SELECT pri_skills,Sec_Skills FROM tbl_jobseeker WHERE JUser_Id=".$jrow['JUser_Id'];
                                                                            $result = mysqli_query($con,$sql);
                                                                            $row1 = mysqli_fetch_array($result);
                                                                            $skills=$row1['pri_skills'];
                                                                            $skill_ids=explode(",",$skills);

                                                                         if($skills === '')
                                                                         {
                                                                            $count = 0;
                                                                            echo $skills;
                                                                          } else{
                                                                            $count = count(explode(",",$skills));
                                                                          }


                             if($count!=0)
                             {
                                         foreach($skill_ids as $skillid)  { ?>                                          
                                       
                           
                                       <?php 
                                    $ms_sql1="select * from tbl_masterskills where skill_Id=".$skillid;
                                           $ms_result1 = mysqli_query($con,$ms_sql1);
                                           $ms_data1 = mysqli_fetch_array($ms_result1);
                                           echo $ms_data1['skill_Name'];?>                                 

                                        <?php }  
                                           }
                                        else { ?>                       
                                    No Skills                              
                                        <?php  }                                      
                                         ?>
				</div>
				<div class="form-group col-md-15 col-sm-15 col-xs-15">
					 <!-- <button type="button" class="btn btn-success pull-center">More-Skills</button> -->
				</div>
			  </div>
		  </div>
		</div>
		
		<div class="col-md-2 col-sm-15 col-xs-15">		
			  <div class="mainHeader">		  
				   <h6>Reason To Relocate</h6>
		    </div>
			<!--  <div class="form3">-->
				<form>
				 <!--  <div class="form-group col-md-12 col-sm-12 col-xs-12">
				      <input type="text" class="form-control" rows ="3" id="inputPassword4" placeholder="Address" value="<?php echo $row_add['address']; ?>">
					  <textarea class="form-control" rows="2" id="comment" placeholder="Address"></textarea>
					</div>-->
					 <div class="form-group">
					 <input type="text" class="form-control" rows ="3" id="inputPassword4" placeholder="Reason To Relocate" value="<?php echo $jrow['jReasonType']; ?>" readonly>
					 <!-- <textarea class="form-control" rows="2" id="comment" placeholder="Reason To Relocate" value="<?php //echo $row['jReasonType']; ?>"></textarea>-->
					</div>
					<div class="form-group">
					 <!-- <button type="button" class="btn btn-success pull-left"><a href="jobseeker-detail-recruiter.php?uid=<?php echo $jrow['JUser_Id'] ?>">More-Resons</button> -->
					 </div>
				</form>
			 <!-- </div>-->
          </div>
          <div class="col-md-4 col-sm-12 col-xs-12">		
              <div class="mainHeader">		  
                <h6>Fitment</h6>
              </div>
                <div class="keySkillsContent1">
                <div id="wrapper" class="row">   
                <div class="col-md-2 col-sm-20 col-xs-20" id="container" style="min-width: 110px; max-width: 110px; height: 130px; margin-bottom: 5px"></div>              
                <!-- class="col-md-4 col-sm-8" style="width: 220px; height: 190px; margin-bottom: 5px"   -->
                <!-- <div class="col-md-2 col-sm-20 col-xs-20 nopadding" id="container" style="min-width: 120px; max-width: 250px; height: 100px; "></div>               -->
                <div class="col-md-2 col-sm-20 col-xs-20 " id="container1" style="min-width: 110px; max-width: 110px; height: 130px; margin-bottom: 5px"></div>     
                <div class="col-md-2 col-sm-20 col-xs-20 "  id="container2" style="min-width: 110px; max-width: 110px; height: 130px; margin-bottom: 5px"></div>                        
                </div>          
          </div>		    		  
          </div>
          </div>
         <script>
        var gaugeOptions = {

    chart: {
        type: 'solidgauge'
    },

    title: null,

    pane: {
        center: ['50%', '85%'],
        size: '85%',
        startAngle: -90,
        endAngle: 90,
        background: {
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
            innerRadius: '60%',
            outerRadius: '100%',
            shape: 'arc'
        }
    },

    tooltip: {
        enabled: false
    },

    // the value axis
    yAxis: {
        stops: [
            [0.1, '#DF5353'], // green
            [0.5, '#DDDF0D'], // yellow
            [0.9, '#55BF3B'] // red
        ],
        lineWidth: 2,
        minorTickInterval: null,
        tickAmount: 2,
        title: {
            y: -70
        },
        labels: {
            y: 16
        }
    },

    plotOptions: {
        solidgauge: {
            dataLabels: {
                y: 5,
                borderWidth: 0,
                useHTML: true
            }
        }
    }
};

// The speed gauge
var chartSpeed = Highcharts.chart('container', Highcharts.merge(gaugeOptions, {
    yAxis: {
        min: 1,
        max: 100,
        title: {
            text: '<span style="font-size:15px;color:black">Salary</span>',
        }
    },
 
    credits: {
        enabled: false
    },

    series: [{
        name: '<span style="font-size:20px;color:black">Salary</span>',
        data: [<?php echo intval($ctc_percent) ; ?>],
        dataLabels: {
            format: '<div style="text-align:center"><span style="font-size:15px;color:' +
                ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}%</span><br/>'/* +
                   '<span style="font-size:10px;color:silver">Overall Average</span></div>'*/
        },
        tooltip: {
            valueSuffix: 'Salary'
        }
    }]

}));

var chartSpeed = Highcharts.chart('container1', Highcharts.merge(gaugeOptions, {
    yAxis: {
        min: 1,
        max: 100,
        title: {
            text: '<span style="font-size:15px;color:black">Experience</span>',
        }
    },
 
    credits: {
        enabled: false
    },

    series: [{
        name: '<span style="font-size:20px;color:black">Experience</span>',
        data: [<?php echo intval($exp_percent) ; ?>],
        dataLabels: {
            format: '<div style="text-align:center"><span style="font-size:15px;color:' +
                ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}%</span><br/>'/* +
                   '<span style="font-size:10px;color:silver">Overall Average</span></div>'*/
        },
        tooltip: {
            valueSuffix: 'Experience'
        }
    }]

}));

var chartSpeed = Highcharts.chart('container2', Highcharts.merge(gaugeOptions, {
    yAxis: {
        min: 1,
        max: 100,
        title: {
            text: '<span style="font-size:15px;color:black">Skills</span>',
        }
    },
 
    credits: {
        enabled: false
    },

    series: [{
        name: '<span style="font-size:20px;color:black">Skills</span>',
        data: [<?php echo intval($skill_percent) ; ?>],
        dataLabels: {
            format: '<div style="text-align:center"><span style="font-size:15px;color:' +
                ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}%</span><br/>'/* +
                   '<span style="font-size:10px;color:silver">Overall Average</span></div>'*/
        },
        tooltip: {
            valueSuffix: 'Skills'
        }
    }]

}));

</script>  
				</div>			
			  </div>
		  </div>
        </div>

	<!------seacond row------>
	
	  <!----second row ends--->
    </div>
    </div>
  </section>

<script>
function GetJobs_skill(loc_id,skill_id)
{
 
    var xmlhttp;
    if (window.XMLHttpRequest)
      {
      xmlhttp=new XMLHttpRequest();
      }
    else
      {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange=function()
      {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
     //  alert(xmlhttp.responseText);
        document.getElementById("job-list").innerHTML=xmlhttp.responseText;
       //document.getElementById("test"+loc_id).checked = false;
       
        }
      }
    xmlhttp.open("GET","similarskill_jobs.php?loc_id="+loc_id+"&skill_id="+skill_id,true);
    xmlhttp.send();
}
function applyNow(){
    
    var skill_percent = 20;   //<?php echo $skill_percent; ?>;
   

    if(skill_percent>50) {
        return true;
    }
    else
    {
		
        if(confirm('Skills percentage is less than 50%. Do you want to continue?')) {
               return true;
         } else {
			 return false;
		 } 
     }

}

$("#container svg g.highcharts-axis-labels text:first-child").ready(function() {
	$("#container svg g.highcharts-axis-labels text:first-child").attr("x", "18.5");
	$("#container svg g.highcharts-axis-labels text:last-child").attr("x", "61.5");
	$("#container svg g.highcharts-axis-labels text:last-child").attr("opacity", "1");
});

$("#container1 svg g.highcharts-axis-labels text:first-child").ready(function() {
	$("#container1 svg g.highcharts-axis-labels text:first-child").attr("x", "18.5");
	$("#container1 svg g.highcharts-axis-labels text:last-child").attr("x", "61.5");
	$("#container1 svg g.highcharts-axis-labels text:last-child").attr("opacity", "1");
});

$("#container svg g.highcharts-axis-labels text:first-child").ready(function() {
	$("#container2 svg g.highcharts-axis-labels text:first-child").attr("x", "18.5");
	$("#container2 svg g.highcharts-axis-labels text:last-child").attr("x", "61.5");
	$("#container2 svg g.highcharts-axis-labels text:last-child").attr("opacity", "1");
});

 </script>
<script>
var forEach = function (array, callback, scope) {
	for (var i = 0; i < array.length; i++) {
		callback.call(scope, i, array[i]);
	}
};
window.onload = function(){
	var max = 2160;
	forEach(document.querySelectorAll('.progress'), function (index, value) {
	percent = value.getAttribute('data-progress');
		value.querySelector('.fill').setAttribute('style', 'stroke-dashoffset: ' + ((100 - percent) / 100) * max);
		value.querySelector('.value').innerHTML = percent + '%';
	});
}
</script>
</body>
</html>