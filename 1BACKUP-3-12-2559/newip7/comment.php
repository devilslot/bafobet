<?
@session_start();
require_once "service/service.php";
require_once "creation/creation.init.php";

$data = $ojc->LoadMatch($_GET['matchID']); 
$cnt = $ojc->LoadCount('comment','matchID',$_GET['matchID']); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>แสดงความคิดเห็น</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <link rel="stylesheet" href="bootstrap.min.css" media="screen">

  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

</head>
<body>
  <div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <a href="javascript:;" class="navbar-brand">ความคิดเห็น [ <font color="#E8A317"><?php echo number_format($cnt);?></font> รายการ ]</a>
        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>
      <div class="navbar-collapse collapse" id="navbar-main">
        <ul class="nav navbar-nav">


        </ul>

        <ul class="nav navbar-nav navbar-right">
          <?php if($_SESSION[MEMBER]['LOGIN'] == "ON") {?>
          <li><a href="comment.php?matchID=<?php echo $_GET['matchID'];?>&userID=<?php echo $_SESSION[MEMBER]['DATA']['code'];?>" target="_self">ความคิดเห็นของ <font color="#4CC417"><?php echo $_SESSION[MEMBER]['DATA']['username'];?></font></a></li>
          <li><a href="comment.php?matchID=<?php echo $_GET['matchID'];?>" target="_self">ดูความคิดเห็นทั้งหมด</a></li>
          <?php } ?>
        </ul>

      </div>
    </div>
  </div>


  <div class="container">







      <!-- Tables
      ================================================== -->
      <div class="bs-docs-section">
        <br/><br/><br/>
        <div class="row">
          <div class="col-xs-6">

            <div class="alert alert-dismissible alert-success" align="center">

              <h3><?php echo $data['HomeName'];?></h3>
            </div>

          </div>
          <div class="col-xs-6">

            <div class="alert alert-dismissible alert-warning" align="center">
              <h3><?php echo $data['AwayName'];?></h3>
            </div>

          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
           <h5 class="text-success" align="center"><?php echo $data['LeagueEngName'];?> - <?php  $new_time = strtotime($data['Date']); echo date('H:i', $new_time);?> น.</h5>   
           <?php if($_SESSION[MEMBER]['LOGIN'] == "ON") {?>
           <p class="bs-component">
            <a href="addComment.php?matchID=<?php echo $_GET['matchID'];?>" class="btn btn-primary pull-right" >เพิ่มความคิดเห็น</a>
          </p><br/><br/>
          <?php } ?>
          <div class="bs-component" style="padding-top:10px;">
            <table class="table table-striped table-hover ">
              <thead>
                <tr>
                  <th>#</th>
                  <th>ความเห็น</th>
                  <th width="20%">วัน/เวลา</th>
                  <th width="10%">สมาชิก</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if(!empty($_GET['userID'])){
                  $where = ' AND memberID = "'.$_SESSION[MEMBER]['DATA']['code'].'" ';
                }

                $sql="
                SELECT
                  *
                FROM
                comment
                WHERE
                matchID = '".$_GET['matchID']."'
                $where
                ORDER BY
                code 
                ASC
                ;";
       // echo $sql;
                $query=mysql_query($sql);
                $loop ='';
                while($row=mysql_fetch_assoc($query)){
                  $loop++;
                  ?>
                  <tr>
                    <td><?php echo $loop;?></td>
                    <td><?php echo $row['msg'];?>
                      <?php if($_SESSION[MEMBER]['DATA']['code'] == $row['memberID']) {  ?>
                      <br/><a href="editComment.php?id=<?php echo $row['code'];?>&matchID=<?php echo $_GET['matchID'];?>" class="btn btn-primary btn-xs">แก้ไขข้อความ</a>  <a href="delcomment.php?id=<?php echo $row['code'];?>&matchID=<?php echo $_GET['matchID'];?>" onClick="return confirm('ยืนยันการลบข้มูล ?')" class="btn btn-danger btn-xs">ลบข้อความ</a>
                      <?php } ?>
                    </td>
                    <td class="text-success"><?php echo DateTimeDisplay($row['date_create'],9);?></td>
                    <td class="text-warning"><?php echo $row['user_create'];?></td>
                  </tr>

                  <?php 
                } 

                mysql_free_result($query);

                ?>
                <tr>

                </tbody>
              </table> 
            </div><!-- /example -->
          </div>
        </div>
      </div>

      



      <footer>
        <div class="row">
          <div class="col-lg-12">

            <ul class="list-unstyled">
              <li class="pull-right"><a href="#top">Back to top</a></li>

            </ul>

          </div>
        </div>

      </footer>


    </div>


    </html>

