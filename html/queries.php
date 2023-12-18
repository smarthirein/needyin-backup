<?php
 $c1= "SELECT * FROM tbl_currentexperience   WHERE JUser_Id=".$row['JUser_Id'];
$result1 = mysqli_query($con,$c1);
$row1 = mysqli_fetch_array($result1);


$c2= "SELECT JPLoc_Id FROM  tbl_jobseeker WHERE JUser_Id=".$row['JUser_Id'];
$result2 = mysqli_query($con,$c2);
$row2= mysqli_fetch_array($result2); 

$c3="select Loc_Id,Loc_Name from tbl_location where Loc_Id=".$row2['JPLoc_Id'];
$result3 = mysqli_query($con,$c3);
$row3= mysqli_fetch_array($result3); 

$c4="select Loc_Id,Loc_Name from tbl_location where Loc_Id=".$row1['Loc_Id'];
$result4 = mysqli_query($con,$c4);
$row4= mysqli_fetch_array($result4); 

$c5="select Indus_Id,Indus_Name from tbl_industry where Indus_Id=".$row2['Indus_Id'];
$result5 = mysqli_query($con,$c5);
$row5= mysqli_fetch_array($result5);
 
$c6="select Func_Id,Func_Name from tbl_functionalarea where Func_Id=".$row2['Func_Id'];
$result6 = mysqli_query($con,$c6);
$row6= mysqli_fetch_array($result6); 

?>
