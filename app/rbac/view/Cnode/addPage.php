<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>cnode add</title>
</head>
<body>

<form action="<?php echo assem_m( 'add' );?>" method="post">
	n_name:<input type='text' name='n_name'></input><br>
	n_spec:<input type='text' name='n_spec'></input><br>
	n_icon:<input type='text' name='n_icon'></input><br>
	n_type:<input type='text' name='n_type'></input><br>
	n_pid:<input type='text' name='n_pid'></input><br>
	n_t_s:<input type='text' name='n_t_s'></input><br>
	<input type='hidden' name='form_token' value="<?php echo $this -> val['token']?>">
	<input type="submit" value="submit">
</form>

</body>
</html>
