<div class="display-features">
    <!-- Current company-->
    <div class="display-details">
        <!-- display details edit and title -->
        <article class="sub-title">
            <h4 class="pull-left">List of Primary Skills</h4> </article>
        <!--/ display details edit and title -->
        <!-- display details show-->
        <!--show details -->
        <div>
            <!--row-->
            <div class="row showdetails ">
                <div class="col-md-4 col-md-offset-4">
                     <table class="table skillstable table-bordered">
                        <thead>
                            <tr>
                                <th>Skill Name</th>
                                <!--<th>Version</th>
                                <th>Last Used</th>
                                <th>Experience</th>-->
                            </tr>
                        </thead>
                        <tbody>
                        <?php $sql = "SELECT pri_skills,Sec_Skills FROM tbl_jobseeker WHERE JUser_Id=".$row['JUser_Id'];
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
            <h4 class="pull-left">List Secondary of Skills</h4> </article>
        <!--/ display details edit and title -->
        <!-- display details show-->
        <!--show details -->
        <div>
            <!--row-->
            <div class="row showdetails ">
                <div class="col-md-4 col-md-offset-4">
                     <table class="table skillstable table-bordered">
                        <thead>
                            <tr>
                                <th>Skill Name</th>
                                <!--<th>Version</th>
                                <th>Last Used</th>
                                <th>Experience</th>-->
                            </tr>
                        </thead>
                        <tbody>
                        <?php   
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
    </div>
    <!--/ Current company -->
</div>