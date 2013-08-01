<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="it">
<head>
<title>Architeka</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<link type="text/css" href="../template/mobile/mobile.css" rel="stylesheet"  media="all" />
</head>
<body>

<div class="header">Architeka <span>mobile</span></div>
<div class="menu">&nbsp;<?php if($feedback!='') echo $feedback;?></div>
<div class="content">
	<h3>Login</h3>
	<form action="login.php" method="post">
	<label for="username">Username: </label><input id="username" type="text" name="username" /><br/><br/>
	<label for="password">Password: </label><input id="password" type="password" name="password" /><br/>
	<input type="submit" name="submit" value="Accedi" />
	</form>
</div>
<div class="footer"></div>

</body>
</html>