<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ÎÞ±êÌâÎÄµµ</title>
</head>
<body>

<form action="<?php echo assem_m( 'add' );?>" method="post">
	Ù~ÌÃû£º<input type='text' name='u_account'></input><br>
	ÃÜ  ´a£º<input type='text' name='u_pass'></input><br>
	PID   £º<input type='text' name='u_pid'></input><br>
	SORT  £º<input type='text' name='u_t_s'></input><br>
	<input type='hidden' name='form_token' value="<?php echo $this -> val['token']?>">
	<input type="submit" value="Ìá½»">
</form>

</body>
</html>
