<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>category add</title>
</head>
<body>

<form action="<?php echo assem_m( 'add' );?>" method="post">
	c_name:<input type='text' name='c_name'></input><br>
	c_spec:<input type='text' name='c_spec'></input><br>
	c_type:<input type='text' name='c_type'></input><br>
	c_pid:<input type='text' name='c_pid'></input><br>
	c_t_s:<input type='text' name='c_t_s'></input><br>
	<input type='hidden' name='form_token' value="<?php echo $this -> val['token']?>">
	<input type="submit" value="submit">
</form>

</body>
</html>
