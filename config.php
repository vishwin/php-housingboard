<?php // connection info and actions
$db_host="127.0.0.1";
$db_username='housingboard';
$db_password='Fitz and The Tantrums';
$db_connection=new mysqli($db_host, $db_username, $db_password, "housingboard");
if ($db_connection->connect_errno) {
	printf("Cannot connect to database.\n(A)bort, (R)etry, (F)ail?\n");
}
?>
