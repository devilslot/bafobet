<?
@session_start();
@header('Cache-Control:no-store, no-cache, must-revalidate'); //no cache
@header("Cache-Control: post-check=0, pre-check=0", false);
@header("Pragma:no-cache");
@session_cache_limiter('private_no_expire'); // works
@header("Content-type: text/html; charset=utf-8");
require_once "service/service.php";
require_once "creation/creation.init.php";
if($_SESSION[MEMBER]['LOGIN'] != 'ON'){
  @header('location: /index.php');
  exit;
}
$data = $ojc->LoadMatch($_GET['matchID']); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>แสดงความคิดเห็น</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
 <link rel="stylesheet" href="css/bootstrap.comment.css" media="screen">

  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</head>
<body>
  <div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <a href="javascript:;" class="navbar-brand">แสดงความคิดเห็น</a>
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
          <li class="text-warning"><a href="comment.php?matchID=<?php echo $_GET['matchID'];?>" target="_self" class="text-warning"><< ย้อนกลับ</a></li>
        </ul>

      </div>
    </div>
  </div>


  <div class="container">







    <div class="row">
      <div class="col-lg-6">
        <div class="well bs-component">
          <form class="form-horizontal" action="savecomment.php" method="post" tmt:validate="true"  autocomplete="off">
            <fieldset>
              <legend>แสดงความคิดเห็น</legend>

              <div class="form-group">
                <label for="textArea" class="col-lg-2 control-label">ข้อความ</label>
                <div class="col-lg-10">
                  <textarea class="form-control" rows="3" id="msg" name="msg" tmt:required="true" tmt:errorclass="invalid" tmt:message="กรุณากรอก ข้อความ"></textarea>
                </div>
              </div>

              <div class="form-group">
               <label for="textArea" class="col-lg-2 control-label"></label>
               <img src="CaptchaSecurityImages.php?width=100&height=40&characters=4" />
             </div>
             <div class="form-group">
              <label for="inputEmail" class="col-lg-2 control-label">CODE</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" name="security_code" id="security_code" placeholder="CODE" tmt:required="true" tmt:errorclass="invalid" tmt:message="กรุณากรอก CODE">
              </div>
            </div>
            <div class="form-group">
              <div class="col-lg-10 col-lg-offset-2">
                <input type="hidden" value="<?php echo $_GET['matchID'];?>" name="matchID"/>
                <button type="reset" class="btn btn-default">เคลียร์</button>
                <button type="submit" class="btn btn-primary">บันทึก</button>
              </div>
            </div>
          </fieldset>
        </form>
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

