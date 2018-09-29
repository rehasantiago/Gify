<?php
    if (isset($_FILES['attachments'])) {
        $msg = "";
        $targetFile = "upload/" . basename($_FILES['attachments']['name'][0]);
        if (file_exists($targetFile))
            $msg = array("status" => 0, "msg" => "File already exists!");
        else if (move_uploaded_file($_FILES['attachments']['tmp_name'][0], $targetFile))
            $msg = array("status" => 1, "msg" => "File Has Been Uploaded", "path" => $targetFile);

        exit(json_encode($msg));
    }
?>
<html>
	<head>
		<title>jQuery File Upload Script</title>
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<style type="text/css">
			#dropZone {
				border: 3px dashed #0088cc;
				padding: 50px;
				width: 500px;
				margin-top: 20px;
			}

			#files {
				border-top: 1px dotted #0088cc;
				padding-top: 20px;
				display: none;
        list-style: none;
			}
      #files > div{
        float: left;
        padding-left: 10px;
      }

            #error {
                color: red;
            }
            .wrap{
              position: relative;
            }
            .close{
              position: absolute;
              right:2px;
              top:2px;
              color:white;
              size: 5px;
            }
            button{
              position: relative;
              left:20%;
              right:20%;
              
            }
		</style>
	</head>
	<body>
		<center>
			<div id="dropZone">
				<h1>Drag & Drop Files...</h1>
				<input type="file" id="fileupload" name="attachments[]" multiple>
			</div>
      <button id="create">Create</button>
      <button id="show">Show</button>
			<h1 id="error"></h1><br><br>
			<div class="progress">
       <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
      </div><br><br>
			<div id="files"></div>
      
		</center>

		<script src="http://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
		<script src="js/vendor/jquery.ui.widget.js" type="text/javascript"></script>
		<script src="js/jquery.iframe-transport.js" type="text/javascript"></script>
		<script src="js/jquery.fileupload.js" type="text/javascript"></script>
    <script src="src/jquery.form.js"></script>
        <script type="text/javascript">
            $(function () {
               var files = $("#files");

               $("#fileupload").fileupload({
                   url: 'uploads.php',
                   dropZone: '#dropZone',
                   dataType: 'json',
                   autoUpload: false
               }).on('fileuploadadd', function (e, data) {
                   var fileTypeAllowed = /.\.(jpg|png|jpeg)$/i;
                   var fileName = data.originalFiles[0]['name'];
                   var fileSize = data.originalFiles[0]['size'];
                   if (!fileTypeAllowed.test(fileName))
                        $("#error").html('Only images are allowed!');
                   else if (fileSize > 500000)
                       $("#error").html('Your file is too big! Max allowed size is: 500KB');
                   else {
                       $("#error").html("");
                       data.submit();
                   }
               }).on('fileuploaddone', function(e, data) {
                    var status = data.jqXHR.responseJSON.status;
                    var msg = data.jqXHR.responseJSON.msg;

                    if (status == 1) {
                        var path = data.jqXHR.responseJSON.path;
                        $("#files").fadeIn().append('<div class="wrap"><span class="close">&times;</span><img style="width: 100px; height: 100px;" src="'+path+'" /></div>');
                        $('.close').click(function(){
                          $(this).parent('div').remove();
                          $.post('delete.php',{path:path},function(data){
                              
                          });
                        });
                    } else
                        $("#error").html(msg);
               }).on('fileuploadprogressall', function(e,data) {
                    var progress = parseInt(data.loaded / data.total * 100,10);
                    $(".progress-bar").width(progress+'%');

               });
            });
            $('#create').click(function(){
              $.get('executeFile.php',function(data,status){
                alert('gif created successfully');
              });
            });
            $('#show').click(function(){
              location.href='showGif.html';
            });
        </script>
	</body>
</html>