<?php include ('header.inc.php');?>
<div class="style29" style="width:240px; float:left;">
<?php include ('left.php');?>
</div>

<script>
function update() {
  $("#notice_div").html('Loading..'); 
  $.ajax({
    type: 'GET',
    url: 'reloadtded.php',
    timeout: 4000,
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
.style69 {
	color: #0099CC;
	font-weight: bold;
}
.style70 {color: #FFB22C}
.style74 {	font-size: 18px;
	font-weight: bold;
	color: #FF9621;
}
.style79 {	font-size: 24px;
	color: #FFB12D;
}
.style80 {color: #0099CC}
.style81 {color: #00FF00}
-->
</style>

    
    <div style="width:790px; float:right; ">
      <div id="reload">
        
      </div>
      <br />
    </div>
 <?php include('footer.inc.php');?>
