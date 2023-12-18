
<?php
require_once 'class.user.php';
 
 
$edu_id = $_GET['edu_id'];
$user_id = $_GET['user_id'];

		$edu = "SELECT * FROM tbl_education where JUser_Id='".$user_id ."' and Edu_Id='".$edu_id."' ";
		$edu_result = mysqli_query($con, $edu);
		$edu_row = mysqli_fetch_array($edu_result);
		
?>		
      <form method="post" action="update_education.php" name="edu-info">
        <!-- row-->
        <div class="row">
            <div class="col-md-3 col-xs-12 col-sm-6">
                <div class="form-group">
								<?php
								$sql1 = "SELECT Qual_Id,Qual_Name FROM tbl_qualification ORDER BY Qual_Name";
								$query1 = mysqli_query($con, $sql1);
								if(!$query1)
								echo mysqli_error($con);
								?>
								 <label>Education <span class="mand">*</span> </label>
								<select name="education" id="education_qual<?php echo $edu_id; ?>" class="edu form-control classic" required="true" onChange="qual_change(<?php echo $edu_id; ?>);">
						   
								<option value="0" selected="selected" disabled>Select Education </option>
								<?php
								while ($row1 = mysqli_fetch_array($query1))
								{ 
								 extract($row1);
								?>
								<option value="<?php echo $Qual_Id;?>" <?php if($Qual_Id == $edu_row['Qual_Id']) echo "selected";  ?>><?php echo $Qual_Name; ?></option>
								<?php } ?>
								</select>                  	
                </div>
            </div>	
                    <div class="col-md-3 col-xs-12 col-sm-6">

							<div class="form-group">
                                <label>Specialization <span class="mand">*</span> </label>
								<select class="form-control classic" name="specialization" id="specialization<?php echo $edu_id; ?>" class="browser-default" onChange="func_spec<?php echo $edu_id; ?>(this);"><span class="mand">*</span>
								<option value="0" selected="selected" disabled>Select Specialization </option>
								<option value="Others">Others</option>
								<?php 
									   $spec_query = "SELECT Speca_Id,Speca_Name FROM tbl_specialization WHERE Qual_Id='".$edu_row['Qual_Id']."'ORDER By Speca_Name ";
										$spec_res = mysqli_query($con, $spec_query);
										while($spec_row = mysqli_fetch_array($spec_res))
										{
											extract($row1);
											?>	
											<option value="<?php echo $spec_row['Speca_Id']; ?>" <?php if($spec_row['Speca_Id'] == $edu_row['Speca_Id']) echo "selected"; ?>><?php echo $spec_row['Speca_Name'];?></option>
											<?php 
										} ?>
								
								</select>
								
								<!-- new specialization adding code -->
								<div id="other-spec<?php echo $edu_id; ?>" style="display:none;">
										<label>
										<input id="newspec<?php echo $edu_id; ?>" name="newspec" onfocusout="myspec<?php echo $edu_id; ?>()" style="height:37px !important;color:#005eb8 !important;font-size: 15px;" placeholder="Add Specialization"></input>
										</label>
								</div>
                            </div>
            </div>
            <div class="col-md-3 col-xs-12 col-sm-6">
                <div class="form-group">
                   <label>University / College <span class="mand">*</span> </label>
                    <?php 											
					$sql3 = "SELECT University_Id,University_Name FROM tbl_university ORDER BY University_Name";
					$query3 = mysqli_query($con, $sql3);
					if(!$query3)
					echo mysqli_error($con);
					?>
                        <select class="form-control classic" name="university" id="university" required onChange="univ1_check<?php echo $edu_id; ?>(this);" >
							
                        <option value="0" selected disabled> Name of University / College </option>
						<option value="Others">Others</option>
					
						<?php
						while ($row3 = mysqli_fetch_array($query3))
						{                            
                        	extract($row3);
						?>
						<option value="<?php echo $row3['University_Id']; ?>" <?php if($row3['University_Id'] == $edu_row['University_Id']) echo "selected"; ?>><?php echo $row3['University_Name']; ?></option><?php } ?>
						
						</select>
                </div>
				<div id="other-univ<?php echo $edu_id; ?>" style="display:none;">
					<label>
					<input id="other-univs" name="newuniv" onfocusout="myuniv()" style="height:25px !important;color:#005eb8 !important;font-size: 15px;" placeholder="Add University"></input>
					</label>
					</div>
            </div>
            <div class="col-md-3 col-xs-12 col-sm-6">
                <div class="form-group">
                    <label>Year of Passing <span class="mand">*</span> </label>
                    <select class="form-control classic" name="yearpassed" id="yearpassed">
                        <option value="0" selected disabled>Year of Passing </option>
                        <?php for($i=2017;$i>=1970;$i--)
						{
							?>
                            <option value="<?php echo $i;?>" <?php if($i == $edu_row['YearPassed']) echo "selected"; ?>><?php echo $i;?></option>
                            <?php }?>
                    </select>
                </div>
            </div>
             <div class="col-md-3 col-xs-12 col-sm-6">
                <div class="input-field">
                    <input type="text" name="percentage" id="percentage" class="validate" placeholder="Percentage"  maxlength="3" onkeypress="return isNumber()" value="<?php echo $edu_row['Percentage']; ?>">
                    
                </div>
            </div>
            <div class="col-md-3 col-xs-12 col-sm-6">
                <div class="form-group mt10">
                   <label>Part time / Full time <span class="mand">*</span> </label>
                    <select class="form-control classic" name="partfulltime" id="partfulltime">
                        <option value="0" selected=>Part Time / Full Time </option>
                        <option value="Part Time" <?php if($edu_row['partfulltime'] == "Part Time") echo "selected"; ?>>Part Time</option>
                        <option value="Full Time" <?php if($edu_row['partfulltime'] == "Full Time") echo "selected"; ?>>Full Time </option>
                    </select>
                </div>
            </div>
        </div>
        <!--/row-->
      <input type = "hidden" value= "<?php echo $edu_id; ?>" name = "edu_id"/>
        <!-- row-->
        <div class="row">
            <div class="col-md-12">
                <input type="submit" name="Eduinfo" value="Save" class="btn waves-effect waves-light btn-blue-sm " onclick="return validateedu<?php echo $edu_id; ?>()"/>
                <button class="btn waves-effect waves-light btn-blue-sm " type="reset" onclick="hideedu<?php echo $edu_id; ?>()">Cancel </button>
            </div>
        </div>
        <!--/row-->
    </form>
	
	<script type="text/javascript">
	
		function qual_change(edu_id) {
			console.log(edu_id);
 			var qual_id = document.getElementById("speacialization"+edu_id);
			 				$.ajax({
							type:'POST',
							url:'get_specialization.php',
							data:'id='+qual_id,
							success:function(htmls){
								$('#specialization'+edu_id).html(htmls);
							}
						});  
		}
			
			</script>