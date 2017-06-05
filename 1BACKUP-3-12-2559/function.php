<?php
session_start();
require_once "service/service.php";
require_once "creation/creation.init.php";

if(isset($_POST['opencomment'])){
	
	$data = $ojc->LoadMatch($_POST['matchID']); 
	$cnt = $ojc->LoadCount('comment','matchID',$_POST['matchID']); 

	 $html .= '<div class="navbar navbar-default">
    
      <div class="navbar-header">
        <a href="javascript:;" class="navbar-brand">ความคิดเห็น [ <font color="#E8A317">'.number_format($cnt).'</font> รายการ ]</a>
        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>
      <div class="navbar-collapse collapse" id="navbar-main">
        <ul class="nav navbar-nav">


        </ul>

        <ul class="nav navbar-nav navbar-right">';
		
          if($_SESSION[MEMBER]['LOGIN'] == "ON") {
          $html .= '<li><a href="comment.php?matchID='.$_POST['matchID'].'&userID='.$_SESSION[MEMBER]['DATA']['code'].'" target="_self">ความคิดเห็นของ <font color="#4CC417">'.$_SESSION[MEMBER]['DATA']['username'].'</font></a></li>
          <li><a href="comment.php?matchID='.$_POST['matchID'].'" target="_self">ดูความคิดเห็นทั้งหมด</a></li>';
           }
         $html .= '</ul>

      </div>
    </div>
  </div>


  







      <!-- Tables
      ================================================== -->
      <div class="bs-docs-section">
        <br/><br/><br/>
        <div class="row">
          <div class="col-xs-6">

            <div class="alert alert-dismissible alert-success" align="center">

              <h3>'.$data['HomeName'].'</h3>
            </div>

          </div>
          <div class="col-xs-6">

            <div class="alert alert-dismissible alert-warning" align="center">
              <h3>'.$data['AwayName'].'</h3>
            </div>

          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
           <h5 class="text-success" align="center">'.$data['LeagueEngName'].' - '.date('H:i', strtotime($data['Date'])).' น.</h5>  ';
           if($_SESSION[MEMBER]['LOGIN'] == "ON") {
           $html .= '<p class="bs-component">
            <a href="addComment.php?matchID='.$_POST['matchID'].'" class="btn btn-primary pull-right" >เพิ่มความคิดเห็น</a>
          </p><br/><br/>';
           } 
         $html .= '<div class="bs-component" style="padding-top:10px;">
            <table class="table table-striped table-hover ">
              <thead>
                <tr>
                  <th>#</th>
                  <th>ความเห็น</th>
                  <th width="20%">วัน/เวลา</th>
                  <th width="10%">สมาชิก</th>
                </tr>
              </thead>
              <tbody>';
                
                if(!empty($_GET['userID'])){
                  $where = ' AND memberID = "'.$_SESSION[MEMBER]['DATA']['code'].'" ';
                }

                $sql="
                SELECT
                  *
                FROM
                comment
                WHERE
                matchID = '".$_POST['matchID']."'
                $where
                ORDER BY
                code 
                DESC
                ;";
       // echo $sql;
                $query=mysql_query($sql);
                $loop ='';
                while($row=mysql_fetch_assoc($query)){
                  $loop++;
                  
                  $html .='<tr>
                    <td>'.$loop.'</td>
                    <td>'.$row['msg'].'';
					
                       if($_SESSION[MEMBER]['DATA']['code'] == $row['memberID']) {  
					   
					   $html .='
                      <br/><a href="editComment.php?id='.$row['code'].'&matchID='.$_POST['matchID'].'" class="btn btn-primary btn-xs">แก้ไขข้อความ</a>  <a href="delcomment.php?id='.$row['code'].'&matchID='.$_POST['matchID'].'" onClick="return confirm("ยืนยันการลบข้มูล ?")" class="btn btn-danger btn-xs">ลบข้อความ</a>
                      '; } 
					  
					  $html .='
                    </td>
                    <td class="text-success">'.DateTimeDisplay($row['date_create'],9).'</td>
                    <td class="text-warning">'.$row['user_create'].'</td>
                  </tr>

                  ';
                } 

                mysql_free_result($query);

                $html .= '
                <tr>

                </tbody>
              </table> 
            </div><!-- /example -->
          </div>
        </div>
      </div>

    ';
    
		$status['status'] = "1";
		$status['html'] = $html;
		echo json_encode($status);
		exit();

}
?>