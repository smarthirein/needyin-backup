<?php

require_once 'class.user.php';
$user_home = new USER();
$stmt = $user_home->runQuery("SELECT * FROM tbl_jobseeker  WHERE JUser_Id=:uid");
$stmt->execute(array(":uid"=>$_GET['juserid']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
 $uid=$_GET['uid'];
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

$jskills="SELECT Job_Skills,JTotalEy,cur_expl.ExpSalL,cur_expl.ExpMaxSalL from tbl_jobseeker INNER JOIN tbl_currentexperience as cur_expl on cur_expl.JUser_Id = tbl_jobseeker.JUser_Id where tbl_jobseeker.JUser_Id = '".$_GET['juserid']."'";
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
?>
<div id="container" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
<script src="highcharts.js"></script>
 <script>
 
Highcharts.chart('container', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Job Fitment'
    },
    xAxis: {
        categories: ['Skills', 'Experience', 'Salary']
    },
    yAxis: {
        min: 0,
        max:100,
        title: {
            text: '%'
        }
    },
    legend: {
        reversed: true
    },
    plotOptions: {
        series: {
            stacking: 'normal'
        }
    },
    series: [{
        name: <?php echo "'".$row['JFullName']."'"; ?>,
        data: [<?php echo intval($skill_percent); ?>, <?php echo intval($exp_percent); ?>, <? echo intval($ctc_percent); ?>, <?php echo intval($overall); ?>]
    }]
});

 </script>
 <script>
 
Highcharts.chart('container', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Job Fitment'
    },
    xAxis: {
        categories: ['Job Fitment'],
        title: {
            text: null
        }
    },
    yAxis: {
        min: 0,
        max: 100,
        title: {
            text: 'Percentage',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        }
    },
    tooltip: {
        valueSuffix: ' %'
    },
    plotOptions: {
        bar: {
            dataLabels: {
                enabled: true
            }
        }
    },
    
    credits: {
        enabled: false
    },
    series: [{
        name: 'Skills',
        data: [<?php echo intval($skill_percent); ?>]
    }, {
        name: 'Experience',
        data: [<?php echo intval($exp_percent); ?>]
    }, {
        name: 'Salary',
        data: [<?php echo intval($exp_percent); ?>]
    }]
});
 </script>