<div class="row">
	<div class="col-md-6">
		<div class="form-horizontal" role="form">
			<?php
			$app->PushText('ชื่อเว็บไซต์ (TH)', 'name_th', 'mydata', 100);
			$app->PushText('Title', 'titles', 'mydata');
			$app->PushTextArea('Keywords', 'keywords', 'mydata');

			?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-horizontal" role="form">
			<?php  
			$app->PushText('ชื่อเว็บไซต์ (EN)', 'name_en', 'mydata', 100);
			$app->PushTextArea('Description', 'descriptions', 'mydata');

			?>
		</div>
	</div>
</div>