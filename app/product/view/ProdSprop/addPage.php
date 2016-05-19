<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tag add</title>
</head>
<body>

<form action="<?php echo assem_m( 'add' );?>" method="post">
	spp_name:<input type='text' name='spp_name'></input><br>
	spp_pid:<input type='text' name='spp_pid'></input><br>
	spp_fid:<input type='text' name='spp_fid'></input><br>
	<input type='hidden' name='form_token' value="<?php echo $this -> val['token']?>">
	<input type="submit" value="submit">
</form>

</body>
</html>
