  
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
                            <!--table-->
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
                                                   <th class="text-center" colspan="2">Scheduled Job Details</th>
                                                </tr>
												<tr width="50%">
													<th class="text-center" width="25%">Job Name </th> 
													 <th class="text-center" width="25%">Scheduled Time</th>
												</tr>
											</table>	
									    </th>   											
                                     
										
                                    </tr>
                                </thead>
								  <tbody><?php $i=1;?>
									<?php if($count !=0)  {   while ($row2 = mysqli_fetch_array($resultv1)) {?>
   										<tr>										
										<td><?php echo $i;?></td>
											<td width="13%"><a href="jobseeker-detail-recruiter.php?uid=<?php echo $row2['JUser_Id'] ?>&pgid=6" class="name"><?php echo $row2['JFullName']; ?></a></td>
											<td width="10%"><?php echo $row2['Des']; ?></td>
											<td width="65px" style="text-align:center;"><?php echo $row2['Company_Name']; ?></td>
											<td width="65px" style="text-align:center;"><?php if($row2['NoticePeriod']=='1'){echo "Immediate";}else {echo $row2['NoticePeriod']."days"; }?>  Notice</td>
												                            
											<td style="text-align:center; width:100px;" >
											
											<table width="100%" cellpadding="0" cellspacing="0" class="sche">
												<?php 
												$sql4 = "SELECT * FROM interviewscheduled WHERE emp_id='".$row2['emp_id']."' and juser_id='".$row2['JUser_Id']."'Group By job_id"; 
												$query4 = mysqli_query($con, $sql4);
											
												while ($row4 = mysqli_fetch_array($query4))
												{ 
												extract($row4);												                                                                    
												$sql2 = "SELECT * FROM tbl_jobposted where Job_Id ='".$job_id."'";
														$query2 = mysqli_query($con, $sql2);
														$row3 = mysqli_fetch_array($query2);?><?php //echo $row3['Job_Name']; 
												$sqlj = "SELECT * FROM tbl_desigination where Desig_Id ='".$row3['Job_Name']."'";
														$queryj = mysqli_query($con, $sqlj);
														$rowj = mysqli_fetch_array($queryj);?><?php //echo $rowj['Desig_Name'];  scheduled_on                                                                                                                                         
												?>
														<tr >
															<td class="text-center" width="50%">  <?php echo $rowj['Desig_Name']; ?> </td> 
															 <td class="text-center" width="50%">  <?php  $ff=date_create($scheduled_on); echo date_format($ff,"M d,Y")."&nbsp;&nbsp;".$hours."h"." ".$minutes."m";?>      </td>
														</tr>
														 <?php } ?>
											</table>
											</td>	
										</tr>    
							    		<?php $i++; ?>
										<?php  } } ?>					
                                </tbody>											
                            </table>
                         
                        </div>
					
	
  </div>
  <?php if($count >=10){ ?>
  <form method="post" action="dbrecruiter-sche-int.php">
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
    xmlhttp.open("GET","getScheduled.php?JobId="+job_id+"&JuserId="+juser_id+"&EmpId="+emp_id,true);
    xmlhttp.send();
}
</script>
