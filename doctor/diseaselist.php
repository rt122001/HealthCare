<?php
session_start();
?>
<?php

	$file =file_get_contents('diseaselist.txt',FILE_INCLUDE_PATH);

	$symptoms = explode("\n", $file);

	echo json_encode($symptoms);

?>