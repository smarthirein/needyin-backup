<?php  error_reporting(0);?>
<div onload="load()" class="title-block-tab">
    <h4 class="flight">Skills <span class="fbold">Information</span>  </h4> </div>
<div class="display-features">
    <!-- Current company-->
    <div class="display-details">
        <!-- display details edit and title -->
        <article class="sub-title">
            <h4 class="pull-left">List of Primary Skills</h4> <a class="pull-right" href="javascript:void(0)" title="Edit!" data-placement="top" onclick="editskills()" id="edit-ic-skills"><i class=" fa fa-pencil-square-o " aria-hidden="true "></i></a> </article>
        <!--/ display details edit and title -->
        <!-- display details show-->
        <!-- edit form details  -->
        <div id="editskills">
           <!-- <form action="skills-info.php" method="post">-->
            <form action="current_skills.php" method="post">
				<!--<div>	
					<input type="button" class="button" value="Add skills" onclick="addField();">
				</div>-->
             <div class="row">
              <div class="col-md-12">
                <div class="table skillstable table-bordered" id="myTable">                  
                    <th>Skill Name </th>                                                                   
                    <div>
				
                    <?php    
						 $sql1= "SELECT pri_skills FROM tbl_jobseeker WHERE JUser_Id=".$row['JUser_Id'];
						$result1 = mysqli_query($con,$sql1);
						$data1=mysqli_fetch_array($result1);
						$skills1 = explode(',',$data1['pri_skills']);
						  foreach($skills1 as $ii)
						  {
							$q2 = "SELECT * FROM tbl_masterskills WHERE skill_Id ='".$ii."'";
							$r2 = mysqli_query($con,$q2);
							$res2 = mysqli_fetch_array($r2);
							$skillsArray[] = $res2['skill_Id'];
						
						  }
					?> 
						
                    <div class="form-group editskills">
						<?php
						$ms_sql="select * from tbl_masterskills where skill_Status='1' Order By skill_Name";
						$ms_result = mysqli_query($con,$ms_sql);
						?>
						<select class="selectpicker" multiple data-live-search="true" data-live-search-placeholder="Search"  name="skills[]" id="skills1" onChange="skill_check(this)";>   
						<option value="Others">Others</option>
						<?php 
						while ($ms_data = mysqli_fetch_array($ms_result)) { ?> 
						<option value="<?php echo $ms_data['skill_Id']; ?>" <?php if (in_array($ms_data['skill_Id'],$skillsArray)){ echo 'selected'; } ?> > <?php echo $ms_data['skill_Name']; ?></option>
						<?php } 
							?>                                  
						</select>
						<div id="other-skill" style="display:none;">
						<label><input id="other-skills" name="newskill" onfocusout="myfunc()" style="height:25px !important;color:#005eb8 !important;font-size: 15px;" placeholder="Add Skill"></input>
						</label>
						</div>
                    </div>
					<script>
						function skill_check(elem) {	
							if (elem.value =='Others') {
								document.getElementById("other-skill").style.display = 'block';
							} else {
								document.getElementById("other-skill").style.display = 'none';
							}
						}
						function myskill(){								
								document.getElementById("other-skill").style.font="italic bold 0.5rem arial,serif";
						}
						</script>
                    </div>
                </div> 
                </div>
                </div>
         
            <div class="row">
                <div class="col-md-12">
                   <input type="hidden" name="user_id" value="<?php echo $row['JUser_Id']; ?>">
					<input type="submit"  name="Skillsinfo" onclick="return checkselection()" value="Save" class="btn waves-effect waves-light btn-blue-sm "/>    
                    <button class="btn waves-effect waves-light btn-blue-sm " type="button" onclick="showexp()">Cancel </button>
                </div>
            </div>
			<input type="hidden"  name="noofSkills" value="" id="noofSkills"/>  

			</form>
        </div>
        <!--/ edit form details -->
        <!--show details -->
        <div id="showskills">
            <!--row-->
            <div class="row showdetails ">
                <div class="col-md-4 col-md-offset-4">
			
                    <table class="table skillstable table-bordered">
                        <thead>
                            <tr>
                                <th>Skill Name</th>                             
                            </tr>
                        </thead>
                        <tbody>
						<?php	$sql = "SELECT * FROM tbl_jobseeker WHERE JUser_Id=".$row['JUser_Id'];
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
                            <tr>
                                <td><?php 
                                    $ms_sql1="select * from tbl_masterskills where skill_Id=".$skillid;
                                           $ms_result1 = mysqli_query($con,$ms_sql1);
                                           $ms_data1 = mysqli_fetch_array($ms_result1);

                                echo $ms_data1['skill_Name'];?></td>
                              <!--  <td><?php echo $row1['version'];?></td>
                                <td><?php echo $row1['experience'];?></td>
                                <td><?php echo $row1['last_used'];?></td>-->
                            </tr>
                           <?php }  
                           }
                           else { ?>
                           <tr>
                                <td><center>No Skills</center></td>
                                </tr>
                           <?php  }
                            ?>
                        </tbody>
                    </table>
					
                </div>
            </div>
            <!--/row-->
        </div>
        <!-- show details -->
        <!--/ display details show-->
       <article class="sub-title">
            <h4 class="pull-left">List of Secondary Skills</h4> <a class="pull-right" href="javascript:void(0)" title="Edit!" data-placement="top" onclick="editsecskills()" id="edit-sc-skills"><i class=" fa fa-pencil-square-o " aria-hidden="true "></i></a> </article>
        <!--/ display details edit and title -->
        <!-- display details show-->
        <!-- edit form details  -->
		
        <div id="editsecskills" style="display:none;">
           <!-- <form action="skills-info.php" method="post">-->
            <form action="sec_skills.php" method="post">
				<!--<div>	
					<input type="button" class="button" value="Add skills" onclick="addField();">
				</div>-->
             <div class="row">
              <div class="col-md-12">
                <div class="table skillstable table-bordered" id="myTable">                  
                    <th>Skill Name</th>                                                                   
                    <div>
				
                    <?php    
						 $sql1= "SELECT Sec_Skills FROM tbl_jobseeker WHERE JUser_Id=".$row['JUser_Id'];
						$result1 = mysqli_query($con,$sql1);
						$data12=mysqli_fetch_array($result1);
						$skills12 = explode(',',$data12['Sec_Skills']);
						  foreach($skills12 as $ii)
						  {
							$q22 = "SELECT * FROM tbl_masterskills WHERE skill_Id ='".$ii."'";
							$r22 = mysqli_query($con,$q22);
							$res22 = mysqli_fetch_array($r22);
							$skillsArray2[] = $res22['skill_Id'];
						
						  }
					?> 
						
                    <div class="form-group editskills">
						<?php
						$ms_sql="select * from tbl_masterskills where skill_Status='1' Order By skill_Name";
						$ms_result = mysqli_query($con,$ms_sql);
						?>
						<select class="selectpicker" multiple data-live-search="true" data-live-search-placeholder="Search"  name="secskills[]" id="skills12">   
						
						<?php 
						while ($ms_data = mysqli_fetch_array($ms_result)) { ?> 
						<option value="<?php echo $ms_data['skill_Id']; ?>" <?php if (in_array($ms_data['skill_Id'],$skillsArray2)){ echo 'selected'; } ?> > <?php echo $ms_data['skill_Name']; ?></option>
						<?php } 
							?>                                  
						</select>
					
                    </div>
					<script>
									function secskill_check(elem) {	
									if (elem.value =='Others') {
								document.getElementById("other-secskill").style.display = 'block';
							} else {
								document.getElementById("other-secskill").style.display = 'none';
							}
						}
						function myskill(){								
								document.getElementById("other-secskill").style.font="italic bold 0.5rem arial,serif";
						}
						</script>
                        
                        
                       
                      
                    
						
                    </div>
                </div> 
                </div>
                </div>
         
            <div class="row">
                <div class="col-md-12">
                   <input type="hidden" name="user_id" value="<?php echo $row['JUser_Id']; ?>">
					<input type="submit"  name="Skillsinfo" onclick="return checksecselection()" value="Save" class="btn waves-effect waves-light btn-blue-sm "/>    
                    <button class="btn waves-effect waves-light btn-blue-sm " type="button" onclick="showsecexp()">Cancel </button>
                </div>
            </div>
			<input type="hidden"  name="noofSkills" value="" id="noofSkills"/>  

			</form>
        </div>
        <!--/ edit form details -->
        <!--show details -->
        <div id="showsecskills" col-md-4>
            <!--row-->
            <div class="row showdetails ">
                <div class="col-md-4 col-md-offset-4">
			
                    <table class="table skillstable table-bordered">
                        <thead>
                            <tr>
                                <th>Skill Name</th>                             
                            </tr>
                        </thead>
                        <tbody>
						<?php	$sql = "SELECT * FROM tbl_jobseeker WHERE JUser_Id=".$row['JUser_Id'];
																			$result = mysqli_query($con,$sql);
																			$row1 = mysqli_fetch_array($result);
                                                                            $skills=$row1['Sec_Skills'];
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
                            <tr>
                                <td><?php 
                                    $ms_sql1="select * from tbl_masterskills where skill_Id=".$skillid;
                                           $ms_result1 = mysqli_query($con,$ms_sql1);
                                           $ms_data1 = mysqli_fetch_array($ms_result1);

                                echo $ms_data1['skill_Name'];?></td>
                              <!--  <td><?php echo $row1['version'];?></td>
                                <td><?php echo $row1['experience'];?></td>
                                <td><?php echo $row1['last_used'];?></td>-->
                            </tr>
                           <?php }  
                           }
                           else { ?>
                           <tr>
                                <td><center>No Skills</center></td>
                                </tr>
                           <?php  }
                            ?>
                        </tbody>
                    </table>
					
                </div>
            </div>
            <!--/row-->
        </div>
		
		
		
		
		

    </div>
    <!--/ Current company -->
</div>

<script type="text/javascript">
		var myTable = document.getElementById("myTable");
		console.log(myTable);
		document.getElementById("noofSkills").value = myTable.rows.length-1;
        function addField (argument) {
            var myTable = document.getElementById("myTable");
			document.getElementById("noofSkills").value = myTable.rows.length;
            var currentIndex = myTable.rows.length;
            var currentRow = myTable.insertRow(-1);	
			
	
            var linksBox = document.createElement("input");
            linksBox.setAttribute("name", "skills" + currentIndex);

            var keywordsBox = document.createElement("input");
            keywordsBox.setAttribute("name", "version" + currentIndex);

            var violationsBox = document.createElement("input");
            violationsBox.setAttribute("name", "experience" + currentIndex);
			
			var last_used1 = document.createElement("input");
            last_used1.setAttribute("name", "last_used" + currentIndex);

            var addRowBox = document.createElement("input");
            addRowBox.setAttribute("type", "button");
            addRowBox.setAttribute("value", "Add skills");
            addRowBox.setAttribute("onclick", "addField();");
            addRowBox.setAttribute("class", "button");
			
            var currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(linksBox);

            currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(keywordsBox);

            currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(violationsBox);
			
			  currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(last_used1);

            currentCell = currentRow.insertCell(-1);
            currentCell.appendChild(addRowBox);
        }
		function checkselection()
		{
		var skill=document.getElementById("skills1").value;
	if(skill==0)
	{
		alert("Please Select a  Skill to update");
		document.getElementById("skills1").focus();
		return false;
	}
		else
			return true;
		
		
		}
			
		function showsecexp() {
    var sk3 = document.getElementById("editsecskills");
    sk3.style.display = "none";
    var sk4 = document.getElementById("showsecskills");
    sk4.style.display = "block";
    var sk6 = document.getElementById("edit-sc-skills");
    sk6.style.display = "block";
}
	function editsecskills() {
    var sk1 = document.getElementById("editsecskills");
    sk1.style.display = "block";
    var sk2 = document.getElementById("showsecskills");
    sk2.style.display = "none";
    var sk5 = document.getElementById("edit-sc-skills");
    sk5.style.display = "none";
}
    </script>