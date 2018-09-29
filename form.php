<!DOCTYPE html>
<html>
<head>
	<title>loading images</title>
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="src/jquery.form.js"></script>
</head>
<body>
<div class="container">
	<br>
	<h3 align="center">ajax file upload progress bar</h3>
	<br>
</div>
<div class="panel panel-default">
    <div class="panel-heading"><b>Ajax File Upload Progress Bar using PHP JQuery</b></div>
    <div class="panel-body">
     <form id="uploadImage" action="upload.php" method="post">
      <div class="form-group">
       <label>File Upload</label>
       <input type="file" name="uploadFile" id="uploadFile" accept=".jpg, .png" />
      </div>
      <div class="form-group">
       <input type="submit" id="uploadSubmit" value="Upload" class="btn btn-info" />
      </div>
      <div class="progress">
       <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
      <div id="targetLayer" style="display:none;"></div>
     </form>
    </div>
   </div>
</body>
<script>
$(document).ready(function(){
 $('#uploadImage').submit(function(event){
  if($('#uploadFile').val())
  {
   event.preventDefault();
   $('#targetLayer').hide();
   $(this).ajaxSubmit({
    target: '#targetLayer',//which part of the page is to be changed 
    beforeSubmit:function(){
     $('.progress-bar').width('0%');
    },
    uploadProgress: function(event, position, total, percentageComplete)
    {
     $('.progress-bar').animate({
      width: percentageComplete + '%'
     }, {
      duration: 1000
     });
    },
    success:function(){
     $('#targetLayer').show();
    },
    resetForm: true
   });
  }
  return false;
 });
});
</script>
</html>