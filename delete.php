<?php
$path=$_POST['path'];
echo $path;
unlink($path);
?>