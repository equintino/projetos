<?php
$where='local';
valida_cookies::limpaCookies();

if ($where=="local")
		header("Location: index.html");
if ($where=="start")
		header("Location: start.php");
?>