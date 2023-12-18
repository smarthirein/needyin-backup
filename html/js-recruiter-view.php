<?php
session_start();
require_once("config.php");
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
	$user_home->redirect('index.php');
}
$stmt = $user_home->runQuery("SELECT * FROM tbl_jobseeker u Join tbl_currentexperience exp on u.JUser_Id=exp.JUser_Id
							  Join  tbl_location loc on exp.Loc_Id=loc.Loc_Id 
							
                              WHERE u.JUser_Id=:uid");

$jid=$_GET['jid'];
$sql1= "SELECT J.*,qo.Qual_Name,Ed.contact_name,L.Loc_Name,I.Indus_Name,F.Func_Name,Ed.companyname,Ed.eLogo,Ed.company_type,Ed.address1,Ed.contact_num,Ed.emp_email
                  FROM tbl_jobposted J    
                  LEFT JOIN tbl_location L on J.Loc_Id=L.Loc_Id
                  LEFT JOIN tbl_industry I on J.PIndus_Id=I.Indus_Id
                  LEFT JOIN tbl_functionalarea F on J.PFunc_Id=F.Func_Id                  
                  LEFT JOIN tbll_emplyer Ed on J.emp_id= Ed.emp_id 
                  LEFT JOIN tbl_qualification qo on J.PEduc_Id=qo.Qual_Id
                  where J.emp_id='".$uid."' AND J.Job_Id='".$jid."'";     
$result1 = mysqli_query($con,$sql1); 
$cc=mysqli_num_rows($result1);   
$rowview2 = mysqli_fetch_array($result1);  
  
$jskills="SELECT Job_Skills,JTotalEy,cur_expl.ExpSalL,cur_expl.ExpMaxSalL from tbl_jobseeker INNER JOIN tbl_currentexperience as cur_expl on cur_expl.JUser_Id = tbl_jobseeker.JUser_Id where tbl_jobseeker.JUser_Id = '".$_SESSION['userSession']."'";
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
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
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
		.half-circle {
    width: 150px;
    height: 80px;
    border-top-left-radius: 110px;
    border-top-right-radius: 110px;
    border: 15px solid gray;
    border-bottom: 0;
}
    </style> 
	

				
 
  
</head>

<body>
  <header class="personaHeader">
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="#" href="#"><h2><?php echo $row['JFullName']; ?><!--Ramesh Garikamokkala--></h2></a>
        </div>
      </div>
    </nav>
  </header>
  <!---Header Ends--->
  <!---Seacond start-->
  <section>
    <div class="container-fluid personaContent">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="col-md-4 col-sm-4 col-xs-4">
		  <img src="img/new.jpg" class="img-responsive personaPersonImage">
         <!-- <?php if($row2['JPhoto']!=" " && $row2['JPhoto']!="" && !is_null($row2['JPhoto'])){ ?>
                                     <img src="<?php echo $row2['JPhoto']; ?>">
                                     <?php } else if($row2['Gender']=="Male") { ?>
                                     <img src="img/js-profile-list-pic.jpg">
                                     <?php }  else {?>
									  <img  src="img/female.png">
									  <?php } ?>-->
		  <div class="imgContent">
		    <ul class="mainContent">
			   <li>DOB: <?php  $date=date_create($row['DoB']);
						echo date_format($date,"M d,Y");?></li>
			   <li> Designation:<?php echo $row['Des']; ?></li>
			   <li>Status:<?php if($row['NoticePeriod']=='1'){ echo "Immediate"; } else {echo $row['NoticePeriod']; ?> <?php }?>
     
              </li>
				<li>Location :<?php echo $row['Loc_Name']; ?> </li>
                                                      
				<li>Contact No:+91 <?php echo $row['JPhone']; ?></li>
			</ul>
		  </div>
        </div>
	<?php $stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

		
 $c1= "SELECT * FROM tbl_currentexperience   WHERE JUser_Id=".$row['JUser_Id'];
$result1 = mysqli_query($con,$c1);
$row1 = mysqli_fetch_array($result1);


			
$c2= "SELECT * FROM  tbl_jobseeker WHERE JUser_Id=".$row['JUser_Id'];
$result2 = mysqli_query($con,$c2);
$row2= mysqli_fetch_array($result2); 

$c3="select Loc_Id,Loc_Name from tbl_location where Loc_Id=".$row2['JPLoc_Id'];
$result3 = mysqli_query($con,$c3);
$row3= mysqli_fetch_array($result3);  
?>
        <div class="col-md-4 col-sm-4 col-xs-4">
          <div class="col-md-12 col-sm-12 col-xs-12 mainHeader">
            <h4>Personal Information</h4>
          </div>
          <div class="form">
            <form>
              <div class="form-group">
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                  <input type="email"  value="<?php echo $row['JEmail']; ?>" class="form-control" id="inputEmail4" placeholder="Personal Email Id" readonly>
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="inputPassword4" placeholder="Experience" value=" exp:<?php echo $row['JTotalEy']; ?> years-<?php echo $row['JTotalEm']; ?>" months readonly>
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="inputEmail4" placeholder="Current CTC (Lacs)" value="<?php echo $row['CurrentSalL']; ?>"readonly> 
                                                
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="inputPassword4" placeholder="Expected CTC (Lacs)" value=" Min: <?php echo $row['ExpSalL'];  ?> - Max: <?php echo $row['ExpMaxSalL']; ?> " readonly>
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="inputEmail4" placeholder="Preferred Location" value= "<?php echo $row3['Loc_Name'] ?>"readonly>
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="inputPassword4" placeholder="Notice Period" value="<?php if($row['NoticePeriod']=='1'){ echo "Immediate"; } else {echo $row['NoticePeriod']; ?> days<?php }?>" readonly>
     
                </div>
				 <div class="form-group col-md-12 col-sm-12 col-xs-12">
				 <input type="text" class="form-control" rows ="2" id="inputPassword4" placeholder="Roles & Responsibilites" value="<?php echo $row['profile_summary']; ?>"readonly>
                  <!--<textarea class="form-control" rows="2" id="comment" placeholder="ProfileSummary" value=" <?php echo $row['profile_summary']; ?>"></textarea>-->
                </div>	
                 	<div class="form-group col-md-12 col-sm-12 col-xs-12">
				  <button type="button" class="btn btn-success pull-right"> <a href="js-recruiter-view1.php">more</a>  </button>
				 </div> 
              </div>			
            </form>
			
          </div>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-4">		
          <div class="col-md-12 col-sm-12 col-xs-12 mainHeader">		  
            <h4>Professional Experience</h4>
          </div>
          <div class="form2">
            <form>
              <div class="form-group">
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                  <input type="email" class="form-control" id="inputEmail4" placeholder="Name Of Organisation" value="<?php echo $row['Company_Name'];?>"readonly>
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="inputPassword4" placeholder="Designation" value="<?php echo $row['Des']; ?>"readonly>
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                 <input type="email" class="form-control" id="inputEmail4" placeholder="Date of Joining" value="<?php echo($row['doJ']);
							//echo date_format($date,"M d,Y");?>"readonly> 
				 
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="inputPassword4" placeholder="Date of Relieved" value="currently Working "readonly>
						   
						
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                  <input type="email" class="form-control" id="inputEmail4" placeholder="Location"   value="<?php echo $row['Loc_Name']; ?>"readonly>
				                                      
                                                      
                    
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="inputPassword4" placeholder="Roles & Responsibilites" <?php $user_query="select Func_Name from tbl_functionalarea where Func_Id='".$row['Func_Id']."'";
						 $rr= mysqli_query($con,$user_query); $rrs=mysqli_fetch_array($rr); ?> value="<?php echo $rrs['Func_Name']; ?>" readonly>
                </div>
				<div class="form-group col-md-12 col-sm-12 col-xs-12">
                  <input type="text" class="form-control" rows ="2" id="inputPassword4" placeholder="Roles & Responsibilites" value="<?php echo $row['JDesc']; ?>" readonly>
                </div>
				<div class="form-group col-md-12 col-sm-12 col-xs-12">
				 <button type="button" class="btn btn-success pull-right">More</button>
				 </div>
              </div>
            </form>
          </div>
        </div>
		 <div class="col-md-4 col-sm-4 col-xs-4">
         <div class="keyContent">		 
			  <div class="col-md-12 col-sm-12 col-xs-12 mainHeader">		  
				<h4>Skills</h4>
			  </div>
			  <div class="col-md-12 col-sm-12 col-xs-12">
				<div class="keySkillsContent">
				
				   <?php   $sql = "SELECT pri_skills,Sec_Skills FROM tbl_jobseeker WHERE JUser_Id=".$row['JUser_Id'];
                                                                            $result = mysqli_query($con,$sql);
                                                                            $row1 = mysqli_fetch_array($result);
                                                                            $skills=$row1['pri_skills'];
                                                                            $skill_ids=explode(",",$skills);

                                                                         if($skills === '')
                                                                         {
                                                                            $count = 0;
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
				<div class="form-group col-md-12 col-sm-12 col-xs-12">
					 <button type="button" class="btn btn-success pull-right">More</button>
				</div>
			  </div>
		  </div>


                                        <div id="graphic"></div>
                                            <div class = "row">
                                            <div id="container" class="col-md-6" style="width: 400px; height: 190px; margin-left: 5px "></div>
                                            <div id="container-speed" class="col-md-4" style="width: 220px; height: 190px; margin-bottom: 5px"></div> 
                                            </div>


                                            <script>
Highcharts.chart('container', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Job Fitment'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        max:100,
        title: {
            text: 'Percentage'
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            pointWidth: 5,
            dataLabels: {
                enabled: true,
                format: '{point.y:.1f}%'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
    },

    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [{
            name: 'Salary',
            y: <?php echo intval($ctc_percent); ?>
           
        }, {
            name: 'Experience',
            y: <?php echo intval($exp_percent); ?>
           
        }, {
            name: 'Skills',
            y: <?php echo intval($skill_percent); ?>
        }]
    }],
   
});
</script>   
<?php
$overall =   ( intval($ctc_percent)+ intval($exp_percent)+  intval($skill_percent))/3;
  ?>    

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
var chartSpeed = Highcharts.chart('container-speed', Highcharts.merge(gaugeOptions, {
    yAxis: {
        min: 0,
        max: 100,
        title: {
            text: '<span style="font-size:17px;color:black">Overall Average</span>'
        }
    },

    credits: {
        enabled: false
    },

    series: [{
        name: '<span style="font-size:20px;color:black">Overall Average</span>',
        data: [<?php echo intval($overall) ; ?>],
        dataLabels: {
            format: '<div style="text-align:center"><span style="font-size:15px;color:' +
                ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}%</span><br/>'/* +
                   '<span style="font-size:10px;color:silver">Overall Average</span></div>'*/
        },
        tooltip: {
            valueSuffix: 'Overall Average'
        }
    }]

}));


</script>  
















<!--		  <div class="markspercantage">
		         <div class="col-md-12 col-sm-12 col-xs-12 mainHeader">		  
				<h4>Fitment</h4>
			  </div>
			  <div class="col-md-12 col-sm-12 col-xs-12">
				<div class="keySkillsContent">
               
            
               
                  <div class="half-circle">
				          
				
				 
				
				  
				  </div>
				<div class="half-circle">
			
				
				</div>
				<div class="half-circle">
				</div>-->
     			<!--   <div id="wrapper" class="center">
				   <div class="col-md-4 col-sm-6 col-xs-12">

						<svg class="progress blue noselect" data-progress="55" x="0px" y="0px" viewBox="0 0 776 628">
							<path class="track" d="M723 314L543 625.77 183 625.77 3 314 183 2.23 543 2.23 723 314z"></path>
							<path class="fill" d="M723 314L543 625.77 183 625.77 3 314 183 2.23 543 2.23 723 314z"></path>
							<text class="value" x="50%" y="61%">0% </text>
							
						</svg>
						</div>
						 <div class="col-md-4 col-sm-6 col-xs-12">
						<svg class="progress green noselect" data-progress="100" x="0px" y="0px" viewBox="0 0 776 628">
							<path class="track" d="M723 314L543 625.77 183 625.77 3 314 183 2.23 543 2.23 723 314z"></path>
							<path class="fill" d="M723 314L543 625.77 183 625.77 3 314 183 2.23 543 2.23 723 314z"></path>
							<text class="value" x="50%" y="61%">0%</text>
							
						</svg>
						</div>
						<div class="col-md-4 col-sm-6 col-xs-12">
						<svg class="progress green noselect" data-progress="100" x="0px" y="0px" viewBox="0 0 776 628">
							<path class="track" d="M723 314L543 625.77 183 625.77 3 314 183 2.23 543 2.23 723 314z"></path>
							<path class="fill" d="M723 314L543 625.77 183 625.77 3 314 183 2.23 543 2.23 723 314z"></path>
							<text class="value" x="50%" y="61%">0%</text>
							
						</svg>
                         </div>
				</div>-->
				</div>
				<div class="form-group col-md-12 col-sm-12 col-xs-12">
					 <button type="button" class="btn btn-success pull-right">More</button>
				</div>
			  </div>
		  </div>
        </div>
          <div class="col-md-4 col-sm-4 col-xs-4">		
			  <div class="col-md-12 col-sm-12 col-xs-12 mainHeader">		  
				<h4>Reason To Relocate</h4>
			  </div>
			<!--  <div class="form3">-->
				<form>
				 <!--  <div class="form-group col-md-12 col-sm-12 col-xs-12">
				      <input type="text" class="form-control" rows ="3" id="inputPassword4" placeholder="Address" value="<?php echo $row_add['address']; ?>">
					  <textarea class="form-control" rows="2" id="comment" placeholder="Address"></textarea>
					</div>-->
					 <div class="form-group col-md-12 col-sm-12 col-xs-12">
					 <input type="text" class="form-control" rows ="3" id="inputPassword4" placeholder="Reason To Relocate" value="<?php echo $row['jReasonType']; ?>" readonly>
					 <!-- <textarea class="form-control" rows="2" id="comment" placeholder="Reason To Relocate" value="<?php //echo $row['jReasonType']; ?>"></textarea>-->
					</div>
					<div class="form-group col-md-12 col-sm-12 col-xs-12">
					 <button type="button" class="btn btn-success pull-right">More</button>
					 </div>
				</form>
			 <!-- </div>-->
          </div>
		    		  
      </div>
    </div>
	<!------seacond row------>
	
	  <!----second row ends--->
    </div>
    </div>
  </section>
</body>



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

 </script>




</html>