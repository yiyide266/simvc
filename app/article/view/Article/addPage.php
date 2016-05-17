<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>category add</title>
</head>
<body>

<form action="<?php echo assem_m( 'add' );?>" method="post">
	a_title:<input type='text' name='a_title'></input><br>
	a_content:<input type='text' name='a_content'></input><br>
	a_pub_time:<input type='text' name='a_pub_time'></input><br>
	a_pub_dpt:<input type='text' name='a_pub_dpt'></input><br>
	a_pub_author:<input type='text' name='a_pub_author'></input><br>
	a_creat_time:<input type='text' name='a_creat_time'></input><br>
	a_creat_uid:<input type='text' name='a_creat_uid'></input><br>
	a_update_time:<input type='text' name='a_update_time'></input><br>
	a_cid:<input type='text' name='a_cid'></input><br>
	a_sort:<input type='text' name='a_sort'></input><br>
	<input type='hidden' name='form_token' value="<?php echo $this -> val['token']?>">
	<input type="submit" value="submit">
</form>

</body>
</html>
