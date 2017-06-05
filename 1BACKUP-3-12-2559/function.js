function opencomment(matchid){
	$('#myModal').modal('show');
	$('#myModalcontent').html('<iframe frameborder="0" style="width:100%; border-width:0;" height="500" src="comment.php?matchID='+matchid+'"></iframe>');
}

function openplaygame(matchid){
	$('#myModal').modal('show');
	$('#myModalcontent').html('<iframe frameborder="0" style="width:100%; border-width:0;" height="500" src="playgame.php?matchID='+matchid+'"></iframe>');
	//$('#myModalcontent').load('playgame.php?matchID='+matchid+'');
}

function openprofile(){
	$('#myModal').modal('show');
	$('#myModalcontent').html('<iframe frameborder="0" style="width:100%; border-width:0;" height="500" src="profile.php"></iframe>');
}

function openchangepass(){
	$('#myModal').modal('show');
	$('#myModalcontent').html('<iframe frameborder="0" style="width:100%; border-width:0;" height="500" src="changepass.php"></iframe>');
}

function openchangepic(){
	$('#myModal').modal('show');
	$('#myModalcontent').html('<iframe frameborder="0" style="width:100%; border-width:0;" height="500" src="changepic.php"></iframe>');
}

function openmemberplay(refID){
	$('#myModal').modal('show');
	//$('#myModalcontent').html('<iframe frameborder="0" style="width:100%; border-width:0;" height="500" src="comment.php?matchID='+matchid+'"></iframe>');
	$('#myModalcontent').load('viewmemberplay.php?refID='+refID+'');
}