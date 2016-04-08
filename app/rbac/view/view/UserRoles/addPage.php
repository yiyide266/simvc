<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ÎÞ±êÌâÎÄµµ</title>
</head>
<body>

<form action="<?php echo assem_m( 'add' );?>" method="post">
	½M  ID£º<input type='text' name='u_id'></input><br>
	ÓÃôID£º<input type='text' name='r_id'></input><br>
	<input type='hidden' name='form_token' value="<?php echo $this -> val['token']?>">
	<input type="submit" value="Ìá½»">
</form>

</body>
</html>
