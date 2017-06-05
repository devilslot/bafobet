<?php include ('header.inc.php');?>
<div class="style29" style="width:240px; float:left;">
<?php include ('left.php');?>
</div>
<script>


function update_today() {
  $("#notice_div").html('Loading..'); 
  $.ajax({
    type: 'GET',
    url: 'tryscore-today.php',
    timeout: 2000,
    success: function(data) {
      $("#reload_today").html(data);
      //$("#notice_div").html(''); 
      window.setTimeout(update_today, 100000);
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
     // $("#notice_div").html('Timeout contacting server..');
     window.setTimeout(update_today, 100000);
   }
 });
}

function update_yesday() {
  $("#notice_div").html('Loading..'); 
  $.ajax({
    type: 'GET',
    url: 'tryscore-yesday.php',
    timeout: 2000,
    success: function(data) {
      $("#reload_yesday").html(data);
      //$("#notice_div").html(''); 
      window.setTimeout(update_yesday, 100000);
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
     // $("#notice_div").html('Timeout contacting server..');
     window.setTimeout(update_yesday, 100000);
   }
 });
}


$(document).ready(function(){
  update_today();
  update_yesday();
});
  </script>

  <style type="text/css">
  <!--
  .style68 {font-size: 12px; font-family: Tahoma; color: #CCCCCC; }
  -->
  </style>
  <div style="width:790px; float:right; ">
    <div id="reload_today">
      <div align="center"><br />
            <br />
          <img src="images/loading-bar.gif" width="192" height="12" />          <br />
          <span class="style29">กำลังโหลดทายผลบอล </span><br />
          <br />
          <br />
        </div>
    </div>
	
	
	<div id="reload_yesday">
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
