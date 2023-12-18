<?php require_once 'class.user.php';
if($_GET['exp_id']!="")
{
   
  $sql1 = "SELECT * FROM tbl_experience where JUser_Id='".$_GET['user_id']."' and Exp_Id='".$_GET['exp_id']."'";
            $query1 = mysqli_query($con, $sql1);
            $row1 = mysqli_fetch_array($query1);
                    $Exp_Id=$row1['Exp_Id'];

                    $user_queryD1="select Desig_Name from tbl_desigination  where Desig_Id='".$row1['Desig_Id']."'";
                         $rrD1= mysqli_query($con,$user_queryD1); 
                         $rrsD1=mysqli_fetch_array($rrD1); 
               
?>
    <form action="general-info.php" method="POST">
       
        <div class="row">
            <div class="col-md-3">
                <div class="input-fieldnew input-field">
                   <label>Company Name</label>
                    <input value="<?php echo $row1['Cmpy_Name'];?>" type="text" class="validate" name="Cmpy_Name" id="Cmpy_Name">
                    
                </div> 
            </div>
            <div class="col-md-3 mt10">
                <div class="form-group">
                           <label>Designation</label>
                            <?php
                            $sql = "SELECT Desig_Id,Desig_Name FROM tbl_desigination";
                            $query = mysqli_query($con, $sql);
                            if(!$query)
                            echo mysqli_error($con);
                            ?>
                            <select class="form-control classic" name="secondExp" id="secondExp">
                            <option value="0"> Select Designation </option>
                            <?php
                            while ($row2 = mysqli_fetch_array($query))
                            { 
                             extract($row2);
                            ?>
                            <option value="<?php echo $row2['Desig_Id'];?>" <?php if(trim($row2['Desig_Id'])==$row1['Desig_Id']) echo "selected"; else echo "";?>> <?php echo $row2['Desig_Name']; ?></option>
                            <?php } ?>
                            </select>
                        </div>
            </div>
            <div class="col-md-3">
                <div class="input-fieldnew input-field">
                    <label>Date of Join</label>
                    <input value="<?php echo $row1['doJ'];?>" type="date" class="datepickerc" name="txtsecondDoJ" id="txtsecondDoJ">
                   <input type="hidden" id="tempval" name="tempval" value="<?php echo $_GET['temp']; ?>">
                </div>
                <script>    $('.datepickerc').pickadate({
                                        selectMonths: true, 
                                        selectYears: 90, 
                                        format: 'dd-mm-yyyy',
                                        max:new Date()  });
                            </script>
            </div>
            <div class="col-md-3">
                <div class="input-fieldnew dtrel">
                   <label>Date of Relieved</label>
                    <input value="<?php echo $row1['dor'];?>" type="date" class="datepicker" name="txtsecondDoR" id="txtsecondDoR">
                    
                </div>
            </div>
        </div>
           <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <?php
                            $sql = "SELECT Loc_Id,Loc_Name FROM tbl_location WHERE Cntry_Id=101 ORDER BY Loc_Name";
                            $query = mysqli_query($con, $sql);
                            if(!$query)
                            echo mysqli_error($con);
                            ?>
                            <label>Location</label>
                        <select name="SecondExpLoc" id="SecondExpLoc" class="select-new form-control classic">
                            <option value="0" disabled> Select Location </option>
                            <?php
                                    while ($row2 = mysqli_fetch_array($query))
                                    { 
                                     extract($row2);
                                    ?>
                                <option value="<?php echo $Loc_Id; ?>" <?php if($row1[ 'Loc_Id']==$Loc_Id) echo "selected"; else echo ""; ?> >
                                    <?php echo $Loc_Name; ?>
                                </option>
                                <?php } ?>
                        </select>
                </div>
            </div>
             <div class="col-md-3">
                <div class="form-group">
                    <?php                                           
                          $sql2 = "SELECT Func_Id,Func_Name FROM tbl_functionalarea";
                          $query2 = mysqli_query($con, $sql2);
                         if(!$query2)
                           echo mysqli_error($con);
                          ?>
                           <label>Industry</label>
                        <select class="select-new form-control classic" name="SecondRolesR" id="SecondRolesR" >
                            <option value="0"> Select Industry </option>
                            <?php
                                    while ($row3 = mysqli_fetch_array($query2))
                                    { 
                                     extract($row3);
                                    ?>
                                <option value="<?php echo $row3['Func_Id']; ?>" <?php if(trim($row1[ 'Roles_Resp'])==$row3[ 'Func_Id']){ echo "selected";}else { echo "";}?>>
                                    <?php echo $row3['Func_Name']; ?>
                                </option>
                                <?php } ?>
                        </select>
                </div>
            </div>
        </div>
       
        <div class="row showdetails ">
            <div class="col-md-12 ">
                <div class="input-fieldnew input-field">
                    <label for="textarea1">Job Description</label>
                    <textarea name="SecondDesp" id="SecondDesp" class="materialize-textarea"><?php echo $row1['JDescri']; ?></textarea>
                    
                   
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" name="user_id" value="<?php echo $_GET['user_id'];?>">
                <input type="hidden" name="exp_id" value="<?php echo $_GET['exp_id'];?>">
                <button class="btn waves-effect waves-light btn-blue-sm " type="submit" onclick="return validateedit()" name="btnPrevExp">Save</button> <a href="jobseeker-profile.php" class="btn waves-effect waves-light btn-blue-sm ">Cancel </a> </form>
   
         </div>
    <hr>
    <?php } ?>