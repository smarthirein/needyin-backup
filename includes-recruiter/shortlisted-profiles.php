   

   <div class="row">
    <script>
            $(document).ready(function () {
                $('#example').DataTable();
            });
        </script>
		<style>
		.sche td:first-child{
			border-right:1px solid #ddd;
		}
		.sche tr:last-child td {
			border-bottom: none !important;
		}
		.sche tr td{
			border-bottom:1px solid #ddd !important;
		}
		</style>
	
   <div class="col-md-12 postedjobs">
                           
                            <table id="example" class="table table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%">
                                <thead>
                                    <tr role="row">
									<th  width="1%">SNo</th>
                                        <th  width="15%">Name</th>
                                        <th width="17%">Position</th>
                                        <th width="15%" class="text-center">Current Company</th>
										<th width="15%" class="text-center">Notice period</th>
                                        <th width="57%" class="th-top" colspan="2" style="padding:0">            
											<table width="100%" cellpadding="0" cellspacing="0">
												<tr class="brdrow" width="50%">
                                                   <th class="text-center" colspan="3">Shortlisted Job Details</th>
                                                </tr>
												<tr width="50%">
													<th class="text-center" width="20%">Job Name </th> 
													 <th class="text-center" width="20%">Shortlisted Date</th>
													 <th class="text-center" width="10%">Scheduled</th>
												</tr>
											</table>	
									    </th>   											
                                     
										
                                    </tr>
                                </thead>
								  <tbody><?php $n=1;?>
									<?php if($count !=0)  {   while ($row2 = mysqli_fetch_array($result1)) {?>
   										<tr>										
										<td><?php echo $n;?></td>
											<td width="13%"><a href="jobseeker-detail-recruiter.php?uid=<?php echo $row2['JUser_Id'] ?>&pgid=6" class="name"><?php echo $row2['JFullName']; ?></a></td>
											<td width="10%"><?php echo $row2['Des']; ?></td>
											<td width="65px" style="text-align:center;"><?php echo $row2['Company_Name']; ?></td>
											<td width="65px" style="text-align:center;"><?php if($row2['NoticePeriod']=='1'){echo "Immediate";}else {echo $row2['NoticePeriod']."days"; }?>  Notice</td>
												                            
											<td style="text-align:center; width:100px;" >
											
											<table width="100%" cellpadding="0" cellspacing="0" class="sche">
												<?php 
											echo	$sql9 = "SELECT * FROM tbl_shortlisted WHERE emp_id='".$row2['emp_id']."' and JUser_Id=".$row2['JUser_Id']; 
												$query9 = mysqli_query($con, $sql9);
									
											
												while ($row4 = mysqli_fetch_array($query9))
												{ 
											 extract($row4);
												 $sql2 = "SELECT * FROM tbl_jobposted where Job_Id ='".$JobId."'";
												$query2 = mysqli_query($con, $sql2);
												$row3 = mysqli_fetch_array($query2); $row3['Job_Name']; 
												$sqlj = "SELECT * FROM tbl_desigination where Desig_Id ='".$row3['Job_Name']."'";
												$queryj = mysqli_query($con, $sqlj);
												$rowj = mysqli_fetch_array($queryj);$rowj['Desig_Name'];                                                                                                                                    
												?>
														<tr >
															<td class="text-center" width="45%">  <?php echo $rowj['Desig_Name']; ?> </td> 
															 <td class="text-center" width="45%">  <?php  $ff=date_create($scheduled_on); echo date_format($ff,"M d,Y")."&nbsp;&nbsp";?>      </td>
														<td class="text-center" width="10%">
														  <a href="#<?php echo $rowj['Desig_Name'];echo $JobId?>"><i class="fa fa-calendar" aria-hidden="true"></i> </a>
														</td>
														</tr>
															<div id="<?php echo $rowj['Desig_Name'];echo $JobId?>" class="modal">
            <form method="post" action="visit.php">
                <div class="modal-content text-center">
                    <h3 class="h3 flight">Schedule the <span class="fbold">Interview</span></h3>
                   
					
                    <div class="importjobs-in">
                       
                       <div class="row form-group">
                             <label>You can Schedule the interview to selected candidates</label>
								<?php
									 $sqldrop = "SELECT * FROM tbl_shortlisted WHERE emp_id='".$row2['emp_id']."' and JUser_Id='".$row2['JUser_Id']."'"; 
									$query4 = mysqli_query($con, $sqldrop);
									
									?>
                                  
									
									 <input  type="text" value="<?php echo $rowj['Desig_Name'];?>" disabled>
								  <input name="jobid" id="jobid" type="hidden" value="<?php echo $JobId;?>">
                       </div>
                     <div  class="row form-group">
                                    <div class="col-md-4 input-field" >
                                        <input type="date" class="datepicker" name="dates" id="dates" placeholder="click to select date   &nbsp;&nbsp;&nbsp;&nbsp; &#x25A6;" >
            							<script>
                                            $('.datepicker').pickadate({
                                                selectMonths: true, // Creates a dropdown to control month
                                                selectYears: 15, // Creates a dropdown of 15 years to control year
            									min:new Date()									
                                            });
                                        </script>
                                    </div>
            						<div class="col-md-3 input-field" >
            					
            							  <select name="hours" id="hours" class="form-control classic" >
            							   <option value="hrs">Select Hours</option>
            							  <?php for($i=0;$i<=23;$i++) { ?>
            							  <option><?php echo $i; ?></option>
            							  <?php }?>
            							  </select>
            						  </div>
            						  <div class="col-md-3 input-field" >
            						
            								<select name="min" id="min" class="form-control classic" >
            								<option value="0">Select Minutes </option>
            								  <?php for($i=5;$i<=55;$i=$i+5) { ?>
											<option><?php echo $i; ?></option>
												<?php }?>
            								
            								  </select>
            						  </div>
                         </div>
						<div class=" input-field">
								<input type="hidden" id="sub-sendmsg" type="hidden" name="email" value="<?php echo $row2['JEmail']?>,<?php echo $row2['JUser_Id'];?>">
								<input type="hidden" id="sub-sendmsg" type="hidden" name="comp_name" value="<?php echo $row2['Comp_Name']?>">
								<!--<input type="hidden"  name="jobid"  value="<?php //echo $rowv4['JobId'] ?>"> -->
								<input type="hidden" name="juserid"  value="<?php echo $row2['JUser_Id'] ?>">
								<input type="hidden" name="empid"  value="<?php echo $row2['emp_id'] ?>">
							    <label for="sub-sendmsg"></label>
					    </div>
						<div class="row input-field">
                            <textarea id="writemsg2" class="materialize-textarea" name="message"></textarea>
                            <label for="writemsg2">Write a Message</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer newfoot"> 
				<span class="sch-fields">All filelds are mandatory</span>
				<a class="modal-action waves-effect waves-green btn-flat"><input type="submit" name="sendschedule" value="Schedule" onclick="return validschedule()"> </a>
				<a href="jobseeker-detail-recruiter.php?uid=<?php echo $row2['JUser_Id'];?>" class="modal-action modal-close waves-effect waves-green btn-flat">cancel</a>
				 </div>
			</form>
            </div>
														 <?php } ?>
											</table>
											</td>	
										</tr>    
							    		<?php $n++; ?>
									
										<?php  } } ?>					
                                </tbody>											
                            </table>
                         
                        </div>
					
	
  </div>
  <?php if($count >=10){ ?>
  <form method="post" action="dbrecruiter-profles-shortlist.php">
	<input type="submit" name="Subs" class="btn waves-effect waves-light fbold text-center waves-input-wrapper" value="Load More">
	</form>
  <?php  } ?>
   
<script>
 function scheduledjobs_list(job_id,juser_id,emp_id)
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
      
        document.getElementById("dates_list"+juser_id).innerHTML=xmlhttp.responseText;
        }
      }
    xmlhttp.open("GET","getShortlisted.php?JobId="+job_id+"&JuserId="+juser_id+"&EmpId="+emp_id,true);
    xmlhttp.send();
}
	 function scheduledjobs_list(job_id,juser_id,emp_id)
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
      
        document.getElementById("dates_list"+juser_id).innerHTML=xmlhttp.responseText;
}
}
}

function validschedule()
			{
				var jbn=document.getElementById('jobid').value;
            	if( jbn =="")
            	{
            		alert("Please select the jobname");
            		document.getElementById('jobid').focus();
            		return false;
            	}
				var dates=document.getElementById('dates').value;
            	if( dates==0)
            	{
            		alert("Please give date to schedule message");
            		document.getElementById('dates').focus();
            		return false;
            	}
            	var hours=document.getElementById('hours').value;
            	if( hours =="hrs")
            	{
            		alert("Please select the time");
            		document.getElementById('hours').focus();
            		return false;
            	}
            	if( hours =="0")
            	{
            		var minutes=document.getElementById('min').value;
            		if(minutes=="0")
            		{
            			alert("Please select the minutes");
            		     document.getElementById('min').focus();
            		     return false;
            		}
            	}
				
				var message=document.getElementById('writemsg2').value;
            	if( message.length <1)
            	{
            		alert("Please type Message");
            		document.getElementById('writemsg2').focus();
            		return false;
            	}
				
			}

</script>