<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>article comment add</title>
</head>
<body>

<form action="<?php echo assem_m( 'add' );?>" method="post">
	c_aid:<input type='text' name='c_aid'></input><br>
	c_uid:<input type='text' name='c_uid'></input><br>
	c_content:<input type='text' name='c_content'></input><br>
	c_comment_time:<input type='text' name='c_comment_time'></input><br>
	c_status:<input type='text' name='c_status'></input><br>
	c_pid:<input type='text' name='c_pid'></input><br>
	c_t_s:<input type='text' name='c_t_s'></input><br>
	<input type='hidden' name='form_token' value="<?php echo $this -> val['token']?>">
	<input type="submit" value="submit">
</form>

</body>
</html>
