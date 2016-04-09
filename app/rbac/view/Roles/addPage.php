<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>roles add</title>
</head>
<body>

<form action="<?php echo assem_m( 'add' );?>" method="post">
	r_name:<input type='text' name='r_name'></input><br>
	r_des:<input type='text' name='r_des'></input><br>
	<input type='hidden' name='form_token' value="<?php echo $this -> val['token']?>">
	<input type="submit" value="submit">
</form>

</body>
</html>
