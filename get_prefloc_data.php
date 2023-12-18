<?php require_once 'class.user.php';
include "source.php";
        if($_GET['cntryid']=="101"){ ?>
<div class="form-group" >
                                      <?php
                                          $sql = "SELECT Loc_Id,Loc_Name FROM tbl_location where Cntry_Id='101' ORDER BY Loc_Name";
                                          $query = mysqli_query($con, $sql);
                                          if(!$query)
                                          echo mysqli_error($con);
                                          ?>
                                          <label>Preferred Location <span class="mand" id="pl">*</span></label>
                                          <select class="form-control classic" id="ploc" name="ploc" onChange="showArea(this.value)">
                                              <option value="0"selected="selected" disabled>  </option>
                                              <?php
                                    while ($row1 = mysqli_fetch_array($query))
                                    { 
                                     extract($row1);
                                    ?>
                                                  <option value="<?php echo $Loc_Id; ?>">
                                                      <?php echo $Loc_Name; ?>
                                                  </option>
                                                  <?php } ?>
                                          </select>

                                  </div>
        

         <?php  } ?>
  