<?php include ('header.inc.php');?>
<div class="style29" style="width:240px; float:left;">
<?php include ('left.php');?>
</div>
<script>


function update() {
  $("#notice_div").html('Loading..'); 
  $.ajax({
    type: 'GET',
    url: 'reload2.php',
    timeout: 2000,
    success: function(data) {
      $("#reload").html(data);
      //$("#notice_div").html(''); 
      window.setTimeout(update, 100000);
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
     // $("#notice_div").html('Timeout contacting server..');
     window.setTimeout(update, 100000);
   }
 });
}


$(document).ready(function(){
  update();
});
  </script>

  <style type="text/css">
  <!--
  .style68 {font-size: 12px; font-family: Tahoma; color: #CCCCCC; }
  -->
  </style>
  <div style="width:790px; float:right; ">
    <div id="reload">
      <div align="center"><br />
            <br />
          <img src="images/loading-bar.gif" width="192" height="12" />          <br />
          <span class="style29">กำลังโหลดทายผลบอล </span><br />
          <br />
          <br />
        </div>
    </div>
  </div>
 <?php include('footer.inc.php');?>
