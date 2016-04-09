<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>cnode add</title>
</head>
<body>

<form action="<?php echo assem_m( 'add' );?>" method="post">
	r_id:<input type='text' name='r_id'></input><br>
	n_id:<input type='text' name='n_id'></input><br>
	<input type='hidden' name='form_token' value="<?php echo $this -> val['token']?>">
	<input type="submit" value="submit">
</form>

</body>
</html>
