				<script type="text/javascript">
			$(document).ready(function()
			{
				  $('.edu').on('change',function(){
					var id = $(this).val();				
					if(id){
						$.ajax({
							type:'POST',
							url:'get_specialization.php',
							data:'id='+id,
							success:function(htmls){
								$('#specialization').html(htmls);
							}
						}); 
					}else{
						$('#specialization').html('<option value="">Select speacialization</option>'); 
					}
				});			
			});
			</script>
<div class="title-block-tab">
    <h4 class="flight">Education <span class="fbold">Information</span>  </h4> <a href="#!" onclick="addedu()"><i class="fa fa-plus" aria-hidden="true"></i> Add Education</a></div>
<!-- add education-->

<div class="display-features addeducation" id="add-education">
    <form method="post" action="general-info.php" name="edu-info">
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
								<select name="education" id="education1" class="edu form-control classic" required="true">
						   
								<option value="0" selected="selected">Select Education </option>
								<?php
								while ($row1 = mysqli_fetch_array($query1))
								{ 
								 extract($row1);
								?>
								<option value="<?php echo $Qual_Id; ?>"><?php echo $Qual_Name; ?></option>
								<?php } ?>
								</select>                  	
                </div>
            </div>	
                    <div class="col-md-3 col-xs-12 col-sm-6">

							<div class="form-group">
                                <label>Specialization <span class="mand">*</span> </label>
								<select class="form-control classic" name="specialization" id="specialization" class="browser-default" onChange="func_spec(this);"><span class="mand">*</span>
								<option value="0" selected="selected">Select Specialization </option>
								</select>
								
								<!-- new specialization adding code -->
								<div id="other-spec" style="display:none;">
										<label>
										<input id="other-spec" name="newspec" onfocusout="myspec()" style="height:37px !important;color:#005eb8 !important;font-size: 15px;" placeholder="Add Specialization"></input>
										</label>
								</div>
								<script>
									function func_spec(elem) {	
										if (elem.value == 'Others') {
											document.getElementById("other-spec").style.display = 'block';
											} else {
												document.getElementById("other-spec").style.display = 'none';
											}
										}														
									function myspec(){
											document.getElementById("other-spec").style.font="italic bold 0.5rem arial,serif";
									}
								</script>
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
                        <select class="form-control classic" name="university" id="university" required onChange="univ1_check(this);" >
							
                        <option value="0" selected> Name of University / College </option>
						<option value="Others">Others</option>
					
						<?php
						while ($row3 = mysqli_fetch_array($query3))
						{                            
                        	extract($row3);
						?>
						<option value="<?php echo $row3['University_Id']; ?>"><?php echo $row3['University_Name']; ?></option><?php } ?>
						
						</select>
                </div>
				<div id="other-univ" style="display:none;">
					<label>
					<input id="other-univs" name="newuniv" onfocusout="myuniv()" style="height:25px !important;color:#005eb8 !important;font-size: 15px;" placeholder="Add University"></input>
					</label>
					</div>
					<script>
						function univ1_check(elem) {	

						if (elem.value == 'Others') {
							
						document.getElementById("other-univ").style.display = 'block';
						} else {
							document.getElementById("other-univ").style.display = 'none';
						}
					}
					function myuniv(){
					document.getElementById("other-univ").style.font="italic bold 0.5rem arial,serif";}
					</script>
            </div>
            <div class="col-md-3 col-xs-12 col-sm-6">
                <div class="form-group">
                    <label>Year of Passing <span class="mand">*</span> </label>
                    <select class="form-control classic" name="yearpassed" id="yearpassed">
                        <option value="0" selected>Year of Passing </option>
                        <?php for($i=2017;$i>=1970;$i--)
						{
							?>
                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php }?>
                    </select>
                </div>
            </div>
             <div class="col-md-3 col-xs-12 col-sm-6">
                <div class="input-field">
                    <input type="text" name="percentage" id="percentage" class="validate" placeholder="Percentage"  maxlength="3" onkeypress="return isNumber()" >
                    <label>Enter Percentage</label>
                </div>
            </div>
            <div class="col-md-3 col-xs-12 col-sm-6">
                <div class="form-group mt10">
                   <label>Part time / Full time <span class="mand">*</span> </label>
                    <select class="form-control classic" name="partfulltime" id="partfulltime">
                        <option value="0" selected=>Part Time / Full Time </option>
                        <option value="Part Time">Part Time</option>
                        <option value="Full Time">Full Time </option>
                    </select>
                </div>
            </div>
        </div>
        <!--/row-->
      
        <!-- row-->
        <div class="row">
            <div class="col-md-12">
                <input type="submit" name="Eduinfo" value="Save" class="btn waves-effect waves-light btn-blue-sm " onclick="return validateedu()"/>
                <button class="btn waves-effect waves-light btn-blue-sm " type="reset" onclick="hideedu()">Cancel </button>
            </div>
        </div>
        <!--/row-->
    </form>
</div>

<!--/ add education -->
<div class="display-features">
    <!-- Post Graduation-->
    <div class="display-details">
    
            <!-- edit form details -->
            <div id="editForm" ></div>
            <!-- /edit form details -->
            <!--show details -->
            <?php $sql1 = "SELECT * FROM tbl_education where JUser_Id='".$row['JUser_Id']."' ORDER BY  YearPassed DESC ";
			$query1 = mysqli_query($con, $sql1);
			$ed_cnt=mysqli_num_rows($query1);
			$i=0;
			$j=0;
			while($row1 = mysqli_fetch_array($query1)){
				$sql2 = "SELECT Qual_Name FROM tbl_qualification where Qual_Id='".$row1['Qual_Id']."' ";
				$query2 = mysqli_query($con, $sql2);
				$row2 = mysqli_fetch_array($query2);
				$Edu_Id=$row1['Edu_Id'];
				$quals[$i++]=$row1[2];
				$yearpassed[$j++]=$row1['YearPassed'];				
				?>
				<script>
				
				function hideedu<?php echo $Edu_Id; ?>() {
    var ae3 = document.getElementById("editedu<?php echo $Edu_Id; ?>");
    ae3.style.display = "none";
	    document.getElementById("viewedu<?php echo $Edu_Id; ?>").style.display = 'block';
}

					function func_spec<?php echo $Edu_Id; ?>(elem) {	
										if (elem.value == 'Others') {
											document.getElementById("other-spec<?php echo $Edu_Id; ?>").style.display = 'block';
											} else {
												document.getElementById("other-spec<?php echo $Edu_Id; ?>").style.display = 'none';
											}
										}														
									function myspec<?php echo $Edu_Id; ?>(){
											document.getElementById("other-spec<?php echo $Edu_Id; ?>").style.font="italic bold 0.5rem arial,serif";
									}
								</script>
								
											<script>
						function univ1_check<?php echo $Edu_Id; ?>(elem) {	

						if (elem.value == 'Others') {
							
						document.getElementById("other-univ<?php echo $Edu_Id; ?>").style.display = 'block';
						} else {
							document.getElementById("other-univ<?php echo $Edu_Id; ?>").style.display = 'none';
						}
					}
					function myuniv<?php echo $Edu_Id; ?>(){
					document.getElementById("other-univ<?php echo $Edu_Id; ?>").style.font="italic bold 0.5rem arial,serif";}
					
					
					function validateedu<?php echo $Edu_Id; ?>()
  {
  
  var education = document.getElementById('education_qual<?php echo $Edu_Id; ?>').value;
            	if(education=="0")
            	{
            		alert("Please Select Education Type !");
            		document.getElementById('education_qual<?php echo $Edu_Id; ?>').focus();
            		return false;
            	}

				<?php	if(isset($quals))
				{ ?>
			
				var quals= <?php echo json_encode($quals); ?>;
				
			var exists=true;
				var flag_edu = 0;
				 			
				for(var i=0;i<quals.length;i++)
				{
					if(quals[i]==education)
					{
						flag_edu++;
						if(flag_edu > 1) {
							exists=false;
							alert("You have Already Added this Course in your Profile");
							return exists;
						}
					}					
					
				}
				
				<?php } ?>	
				var specialization=document.getElementById('specialization<?php echo $Edu_Id; ?>').value;
            	if(specialization=="0")
            	{
            		alert("Please Select Specialization ");
            		document.getElementById('specialization<?php echo $Edu_Id; ?>').focus();
            		return false;
            	}
				if(specialization == "Others") {
					var newspec = document.getElementById('newspec<?php echo $Edu_Id; ?>').value;
					if(newspec == "") {
						alert("Please Add Specialization");
						document.getElementById('newspec<?php echo $Edu_Id; ?>').focus();
						return false;
					}
				}
				
				
				
				var university=document.getElementById('university<?php echo $Edu_Id; ?>').value;
            	if(university=="0")
            	{
            		alert("Please Select University");
            		document.getElementById('university<?php echo $Edu_Id; ?>').focus();
            		return false;
            	}
				var yearpassed=document.getElementById('yearpassed<?php echo $Edu_Id; ?>').value;
            	if(yearpassed=="0")
            	{
            		alert("Please Select Year Of Passed");
            		document.getElementById('yearpassed<?php echo $Edu_Id; ?>').focus();
            		return false;
            	}
				<?php	if(isset($yearpassed))
				{ ?>
				var yearpa= <?php echo json_encode($yearpassed); ?>;
				var yearexists=true;
				var flag_year = 0;
				for(var i=0;i<yearpa.length;i++)
				{
					if(yearpa[i]==yearpassed)
					{
						flag_year++;
						if(flag_year > 1) {
							yearexists=false;
							alert("Can't Have Same Passing Year for Different Educations");
							return yearexists;
						}
					}
				}
				
				<?php      }  ?>
				
				var percentage=document.getElementById('percentage<?php echo $Edu_Id; ?>').value;
            	if(percentage!="")
            	{	
					if(percentage>100)
					{
            		alert("Percentage can be between 0 and 100 only");
            		document.getElementById('percentage<?php echo $Edu_Id; ?>').focus();
            		return false;
					}
            	}
				
				
				var partfulltime=document.getElementById('partfulltime<?php echo $Edu_Id; ?>').value;
            	if(partfulltime=="0")
            	{
            		alert("Please Select Part Time or Full Time in Education Type !");
            		document.getElementById('partfulltime<?php echo $Edu_Id; ?>').focus();
            		return false;
            	}
				
				else 
					return true;
			
  }
  
					</script>
					
                <article class="sub-title">
                    <h4 class="pull-left">
						<span class="fbold"><?php echo $row2['Qual_Name'];?></span>
					</h4>
					 <a class="pull-right" href="javascript:void(0);" title="Edit!" data-placement="top" onclick="return edit_edu(<?php echo $Edu_Id.",".$row['JUser_Id']; ?>)" id="edit-icon2"><i class=" fa fa-pencil-square-o " aria-hidden="true "></i></a> 
                  </article>
				<div id="editedu<?php echo $Edu_Id;?>">
				</div>
                <div id="viewedu<?php echo $Edu_Id;?>">
                    <!--row-->
                    <div class="row showdetails ">
                        <div class="col-md-2 col-xs-12 col-sm-6">
                            <div class="block-show ">
                                <h4>Degree</h4>
                                <p>
                                    <?php echo $row2['Qual_Name'];?>
                                </p>
                            </div>
                        </div>
						<div class="col-md-3 col-xs-12 col-sm-6">
								<div class="block-show ">
                                <h4>Specialization Type </h4>
                                <p>
								<?php $sql4 = "SELECT Speca_Id,Speca_Name FROM tbl_specialization WHERE Speca_Id='".$row1['Speca_Id']."'";
								$query4 = mysqli_query($con, $sql4);
								$row4 = mysqli_fetch_array($query4); echo $row4['Speca_Name'];?>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-5 col-xs-12 col-sm-6">
                            <div class="block-show ">
                                <h4>Name of School / University </h4>
                                <p>
                                    <?php $sql3 = "SELECT University_Name FROM tbl_university where University_Id='".$row1['University_Id']."'";
					$query3 = mysqli_query($con, $sql3);
					$row3 = mysqli_fetch_array($query3); echo $row3['University_Name'];?>
                                </p>
                            </div>
                        </div>

                        <div class="col-md-2 col-xs-12 col-sm-6">
                            <div class="block-show ">
                                <h4>Year of Passing</h4>
                                <p>
                                    <?php echo $row1['YearPassed']; ?>
                                </p>
                            </div>
                        </div>
                         <div class="col-md-2 col-xs-12 col-sm-6">
                            <div class="block-show ">
                                <h4>Percentage </h4>
                                <p>
                                    <?php echo $row1['Percentage']; ?>%</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-12 col-sm-6">
                            <div class="block-show ">
                                <h4>Full Time / Part Time</h4>
                                <p>
                                    <?php echo $row1['partfulltime']; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!--/row-->
                   
                </div>
                <div class="display-details">
				</div>
                <?php  }?>
                    <!--/ display details show-->

    </div>
    <?php if($ed_cnt=='0' || $ed_cnt==""){ ?>
<div id="dis_msg" style="margin-top: 90px;"><center>Click on "Add Education" button to enter the educational details</center></div>
<?php } ?>
    <!--/ Post Graduation -->
	<script lang="javascript">
	function validateedu()
  {
  
  var education = document.getElementById('education1').value;
            	if(education=="0")
            	{
            		alert("Please Select Education Type !");
            		document.getElementById('education1').focus();
            		return false;
            	}

				<?php	if(isset($quals))
				{ ?>
			
				var quals= <?php echo json_encode($quals); ?>;
				
			var exists=true;
				
				{ 			
				for(var i=0;i<quals.length;i++)
				{
					if(quals[i]==education)
					{
						
						exists=false;
						alert("You have Already Added this Course in your Profile");
						return exists;
					}					
					
				}}
				
				<?php } ?>	
				var specialization=document.getElementById('specialization').value;
            	if(specialization=="0")
            	{
            		alert("Please Select Specialization ");
            		document.getElementById('specialization').focus();
            		return false;
            	}
				
				
				var university=document.getElementById('university').value;
            	if(university=="0")
            	{
            		alert("Please Select University");
            		document.getElementById('university').focus();
            		return false;
            	}
				var yearpassed=document.getElementById('yearpassed').value;
            	if(yearpassed=="0")
            	{
            		alert("Please Select Year Of Passed");
            		document.getElementById('yearpassed').focus();
            		return false;
            	}
				<?php	if(isset($yearpassed))
				{ ?>
				var yearpa= <?php echo json_encode($yearpassed); ?>;
				var yearexists=true;
				for(var i=0;i<yearpa.length;i++)
				{
					if(yearpa[i]==yearpassed)
					{
						
						yearexists=false;
						alert("Can't Have Same Passing Year for Different Educations");
						return yearexists;
					}
				}
				
				<?php      }  ?>
				
				var percentage=document.getElementById('percentage').value;
            	if(percentage!="")
            	{	
					if(percentage>100)
					{
            		alert("Percentage can be between 0 and 100 only");
            		document.getElementById('percentage').focus();
            		return false;
					}
            	}
				
				
				var partfulltime=document.getElementById('partfulltime').value;
            	if(partfulltime=="0")
            	{
            		alert("Please Select Part Time or Full Time in Education Type !");
            		document.getElementById('partfulltime').focus();
            		return false;
            	}
				
				else 
					return true;
			
  }
  
  function edit_edu(edu_id, user_id) {
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
                document.getElementById("editedu"+edu_id).innerHTML=xmlhttp.responseText;
                document.getElementById("viewedu"+edu_id).style.display = 'none';
                }
              }
            xmlhttp.open("GET","edit_education.php?edu_id="+edu_id+"&user_id="+user_id,true);
            xmlhttp.send();      
  }
  	
		function qual_change(edu_id) {
			console.log(edu_id);
 			var qual_id = document.getElementById("education_qual"+edu_id).value;
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
</div>