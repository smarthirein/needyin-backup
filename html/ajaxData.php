<?php
session_start();
require_once("config.php");
require_once 'class.user.php';

if(isset($_POST["country_id"]) && !empty($_POST["country_id"])){
    //Get all state data	
	 $sql2 = "SELECT * FROM tbl_states WHERE Cntry_Id = ".$_POST['country_id']."  ORDER BY states ASC";
												$query2 = mysqli_query($con, $sql2);
    
    
    //Count total number of rows
    $rowCount = mysqli_num_rows($query2);
    
    //Display states list
    if($rowCount > 0){
        echo '<option value="">Select State</option>';
        while($row = mysqli_fetch_array($query2)){ 
            echo '<option value="'.$row['id'].'">'.$row['states'].'</option>';
        }
    }else{
        echo '<option value="">State Not Applicable</option>';
    }
}

if(isset($_POST["state_id"]) && !empty($_POST["state_id"])){
    //Get all city data
    
    $sql3 = "SELECT * FROM tbl_location WHERE state_id = ".$_POST['state_id']." ORDER BY Loc_Name ASC";
												$query3 = mysqli_query($con, $sql3);
    //Count total number of rows
    $rowCount =  mysqli_num_rows($query3);
    
    //Display cities list
    if($rowCount > 0){
        echo '<option value="">Select City</option>';
        while($row = mysqli_fetch_array($query3)){ 
            echo '<option value="'.$row['Loc_Id'].'">'.$row['Loc_Name'].'</option>';
        }
    }else{
        echo '<option value="">City not available</option>';
    }
}
?>

