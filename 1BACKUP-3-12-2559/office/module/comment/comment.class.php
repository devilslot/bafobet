<?php
/*================================================*\
*  Author : Attaphon Wongbuatong
*  Created Date : 08/02/2016 01:14
*  Module : Class
*  Description : Backoffice Class
*  Involve People : MangEak
*  Last Updated : 08/02/2016 01:14
\*================================================*/

class SubClass extends AppClass{

	public function __construct($table='', $lang='th'){
		$this->table = $table;
		$this->lang = $lang;
	}


	public function ViewButton($mod, $permission, $input){
		$btn = array();

		// if(array_key_exists("EDIT", $input) && $permission['EDIT'][$mod]){
		// 	$btn[] = "<li class='text-left'><a href='javascript:;' onclick='me.LoadEdit({code});'><i class='fa fa-edit'></i> ".$input['EDIT']."</a></li>";
		// }
		if(array_key_exists("DEL", $input) && $permission['DEL'][$mod]){
			$btn[] = "<li class='text-left'><a href='javascript:;' onclick='me.DelView({code});'><i class='fa fa-trash-o'></i> ".$input['DEL']."</a></li>";
		}
		if(array_key_exists("PRINT", $input) && $permission['PRINT'][$mod]){
			$btn[] = "<li class='text-left'><a href='javascript:;' onclick='me.Print({code});'><i class='fa fa-print'></i> ".$input['PRINT']."</a></li>";
		}

		if(empty($btn)){
			$result = "";
		}else{
			$result  = "<div class='btn-group btn-group-xs'>";
			$result .= "    <button class='btn shiny dropdown-toggle' type='button' data-toggle='dropdown'><span class='fa fa-cog'></span>&nbsp;<span class='fa fa-caret-down'></span></button>";
			$result .= "    <ul class='dropdown-menu dropdown-menu-right'>";
			$result .= implode(" ", $btn);
			$result .= "    </ul>";
			$result .= "</div>";
		}

		return $result;
	}
}
?>





























