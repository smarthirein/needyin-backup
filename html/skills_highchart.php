<!--<script src="https://code.highcharts.com/highcharts.js"></script>
<div id="skills" style=" max-width: 400px; height: 130px; margin: 0 auto"></div> -->
<?php
require_once 'dbconfig.php';
?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>

<div id="container" style="min-width: 310px; height: auto; margin: 0 auto"></div>
<?php $skills=unserialize(urldecode($_GET['skills'])); 

?>
<?php
foreach($skills as $eskill)
{
        $skill_sql="SELECT Csk_Skill_Id as id,count(Csk_Skill_Id) as skill_count,Skill_Name from tbl_cand_skills csk inner join tbl_masterskills ms on ms.Skill_Id=csk.Csk_Skill_Id INNER JOIN tbl_users us on us.User_Id=csk.Csk_User_Id  where Csk_Skill_Id='".$eskill."' and User_Type='Jobseeker'";
          $skill_res = mysqli_query($con2, $skill_sql); 
           $data_skills = mysqli_fetch_array($skill_res);
           $data[]=array("count"=>$data_skills['skill_count'],"name"=>$data_skills['Skill_Name']);
           
         
}
     


$i=0;
foreach($skills as $skill)
{
 $skill_sql="SELECT Skill_Name,Cpfd_Total_Exp_Years,Cprd_First_Name,Cprd_Last_Name from tbl_cand_skills csk INNER join tbl_masterskills ms on ms.Skill_Id=csk.Csk_Skill_Id INNER JOIN tbl_cand_prof_details cpd on cpd.Cpfd_User_Id=csk.Csk_User_Id INNER join tbl_cand_prsnl_details prsnl on prsnl.Cprd_User_Id=csk.Csk_User_Id INNER JOIN tbl_users us on us.User_Id=csk.Csk_User_Id where Csk_Skill_ID='".$skill."' and User_Type='Jobseeker'";
$skill_res = mysqli_query($con2, $skill_sql); 
while($data_skills = mysqli_fetch_array($skill_res))
{
$dd_chart[$i][]=array("skill_name"=>$data_skills['Skill_Name'],"exp"=>$data_skills['Cpfd_Total_Exp_Years'],"name"=>$data_skills['Cprd_First_Name']);
}
$i++;
}?>

<?php

?>
 
<script>

// Create the chart
Highcharts.chart('container', {
    chart: {
        type: 'column',
        events: {
        drilldown: function(e) {
            this.yAxis[0].setTitle({ text: 'Experience' });
        },
        drillup: function(e) {
            this.yAxis[0].setTitle({ text: 'Count' });
        }
        }
    },
    title: {
        text: 'Skills'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            enabled: true,
            text: 'Count'
        }
    },
    legend: {
        enabled: false
    },
    credits: {
    enabled: false
  },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y:.1f}'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b><br/>'
    },

    series: [{
        name: 'Skills',
        colorByPoint: true,
        data: [<?php $pskills=$data;

?>
   
	<?php
	
foreach($pskills as $data)
{?>
	{
		
        name: '<?php  echo  $data['name']; ?>',
        y: <?php  echo  $data['count']; ?>,
		drilldown: '<?php  echo  $data['name']; ?>'
    },
	<?php }?>
	]
    }],
 
 drilldown: {
     
        series: [
         
                <?php foreach($dd_chart as $data1) {?>
                    {
            name: '<?php  echo  $data1[0]['skill_name']; ?>',
            id: '<?php  echo  $data1[0]['skill_name']; ?>',
            data: [
                <?php foreach($data1 as $data2) {?>
                ['<?php  echo  $data2['name']; ?>',<?php  echo  $data2['exp']; ?>],
              <?}?>
            ]
        }, <?php }?>], 
       
    }
});
</script>

