<?php

$name = 'participantes.csv';
$fp = fopen($name, 'r');
header('Content-type: text/csv; charset=windows-1252');
header('Content-Length: ' . filesize($name));
header('Content-Description: File Transfer');
header('Content-Disposition: attachment; filename='.basename($name));
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
fpassthru($fp);
exit;
 ?>
