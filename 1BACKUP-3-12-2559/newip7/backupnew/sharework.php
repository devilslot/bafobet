<?php if(empty($_COOKIE['PID'])){ echo '<script>window.location.href = "login.php";</script>'; } ?>
<div class="container-fluid">

  <h1>แบ่งงาน</h1>
<p>ขณะนี้เป็นเวลาทำงานช่วง 
<?php if($timework=='08'){?> 00:00-08:00<?php } ?>
<?php if($timework=='16'){?> 08:00-16:00<?php } ?>
<?php if($timework=='00'){?> 16:00-00:00<?php } ?>
 น.
</p>
  <hr>



  

</div>

<?php
//print_r($_POST);
$search_day = $_POST['search_day'];
$work = $_POST['work'];

if(!empty($search_day)){

	$sqla .= " AND added >= '".strtotime($search_day.' 00:00')."' AND added <= '".strtotime($search_day.' 23:59')."'";

}else{

	$sqla .= " and status='y'";

}
//echo "w:".$sql9;
if(!empty($work)){

	$sqla .= " AND date = '".$work."'";
}else{
	$sqla .= " and date = '".$timework."'";
}
?>
 <div id="page-wrapper">
            <div class="container-fluid">
				
				<div class="pull-right"></div>
				<div class="clearfix"></div>				
                <!-- /.row -->
                <form action="" method="post">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="text" class="form-control input-small datepicker" name="search_day" id="search_day" value="<?=$search_day?>" placeholder="วันที่">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                        	<select name="work" class="form-control">
                        	  <option value="08" <?php if($work=='08'){?> selected="selected" <?php } ?>>00:00-08:00</option>
                        	  <option value="16" <?php if($work=='16'){?> selected="selected" <?php } ?>>08:00-16:00</option>
                        	  <option value="00" <?php if($work=='00'){?> selected="selected" <?php } ?>>16:00-00:00</option>
                            </select>
                       	  
                        </div>
                   	</div>
                    <div class="col-md-3">
                    <div class="form-group">
                    <input name="searchac" type="hidden" value="y" />
                        	<button type="submit" class="btn btn-primary">ค้นหา</button>
                        </div>
                    </div>
                    <div class="col-md-3">
                    </div>
        		</div>
                </form>
                <div class="row">
					<div class="col-xs-12 col-sm-7">
                    <div id="sharework_msg"></div>
                   
					<table class="table table-bordered table-hover tdp2" id="agenttable" style="margin-top:10px;">
							<tbody>
							  <tr>
                              	<td class="active" width="10%">กลุ่ม</td>
								<td class="active" width="20%">ค่ายเกมส์</td>
                                <td class="active" width="20%">ID เกมส์</td>
								<td class="active" width="10%">กดเลือก</td>
								<td class="active" width="40%">ผู้เลือก</td>
								
							  </tr>
							</tbody>
							<tbody id="phtml">
								<?php
                                $sql = "select * from gamesid order by groupin asc";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
									
                                    
                                while($x = $result->fetch_assoc()) {
                                	
									if($x['groupin']==1){ $trcolor = '#99ff99'; }
									if($x['groupin']==2){ $trcolor = '#ff99ff'; }
									if($x['groupin']==3){ $trcolor = '#ffcc99'; }
									if($x['groupin']==4){ $trcolor = '#99ddff'; }
									if($x['groupin']==5){ $trcolor = '#cccccc'; }
                                ?>
                             <tr bgcolor="<?php echo $trcolor; ?>">
                             	<td><?=$x['groupin']?></td>
								<td><span class="btn btn-info btn-xs"><?=$x['provider']?></span></td>
                                <td><span class="btn btn-default btn-xs"><?=$x['gamesidname']?></span></td>
								<td>
								<?php
                                $sql3 = "select * from sharework where gamesid = '".$x['id']."' ".$sqla." order by added desc";
                                $result3= $conn->query($sql3);
                                if ($result3->num_rows > 0) {
                                $row = $result3->fetch_assoc();
								
								$sql4 = "select * from personnel where id = '".$row['persoid']."'";
                                $result4 = $conn->query($sql4);
								$row4 = $result4->fetch_assoc();
								
								$prosec =  $row4['name']." ".date('d/m/Y H:i',$row['added']);
								
								}else{ $prosec = "ไม่มีผู้เลือก"; }
								//echo $x['id']."".$row['gamesid'];
								//echo $sql3;
                                ?>
                                <?php 
								//
								
								
								if(($_POST['searchac']!='y')and($_COOKIE['PCLASS']!='Account')and($_COOKIE['PCLASS']!='Admin')){
								if($x['id']!=$row['gamesid'] ){
								?>
                                <button type="button" class="btn btn-primary btn-xs" id="addsw_<?php echo $x['id']; ?>" onclick="addsharework(<?=$x['id']?>);">เลือก</button>
                                <?php }else{ 
                                if($_COOKIE['PID']==$row4['id']){?>
                                <button type="button" class="btn btn-danger btn-xs" id="cansw_<?php echo $x['id']; ?>" onclick="endsharework(<?=$x['id']?>);">ยกเลิก</button>
                                <?php } } 
								}
								
									?>
                                </td>
								<td>
								<?php echo $prosec; ?>
								</td>
                                
								
								
							  </tr>
<?		
	}
}
?>							
							</tbody>
					</table>
                 
					</div>
<!-- ************************************* -->
				</div>
            </div>
            <!-- /.container-fluid -->
        </div>