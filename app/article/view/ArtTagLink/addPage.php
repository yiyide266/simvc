<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TagLink add</title>
</head>
<body>

<form action="<?php echo assem_m( 'add' );?>" method="post">
	t_id:<input type='text' name='t_id'></input><br>
	a_id:<input type='text' name='a_id'></input><br>
	<input type='hidden' name='form_token' value="<?php echo $this -> val['token']?>">
	<input type="submit" value="submit">
</form>

</body>
</html>
