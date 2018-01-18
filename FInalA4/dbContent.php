<?php
	$fileContent= $_SERVER['QUERY_STRING'];
	$fileUrl = substr($fileContent,5);
	$allContent = shell_exec("./db -content ".$fileUrl);
	echo $allContent;
?>
