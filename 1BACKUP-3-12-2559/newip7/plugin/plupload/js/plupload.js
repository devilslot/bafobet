$(function() {
	$("#uploader").pluploadQueue({
    runtimes : 'gears,html5,flash,silverlight,browserplus',
		url : 'upload.php',
		max_file_size : '3mb',
		chunk_size : '1mb',
		unique_names : true,
		multiple_queues : true,
		filters : [
			{title : "Image files", extensions : "jpg,gif,png,jpeg,JPG,GIF,PNG,JPEG"},
			{title : "Zip files", extensions : "zip"}
		],

		init : {
			FilesAdded: function(up, files) {
				up.start();
			},

			FileUploaded: function(up, files, res){
				var obj = JSON.parse(res.response);
				if(obj.error != null){
					var err = obj.error;
					alert(err.message);
				}else{
					var rs = obj.result;
					$('body').append('<div>upload ok</div><hr/>');
				}
			},

			UploadComplete: function(up, files) {
				up.splice();
			}
		}
	});
});