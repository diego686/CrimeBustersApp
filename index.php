<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="">
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Crime Busters</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Place favicon.ico in the root directory -->
	<link rel="stylesheet" href="./dist/app.css">
</head>
<body>
	
	<div id="app">
		<navbar></navbar>
		<router-view></router-view>
	</div>

	<script src="./dist/app.js"></script>
</body>
</html>