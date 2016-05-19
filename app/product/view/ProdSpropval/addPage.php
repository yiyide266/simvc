<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>prod spropval add</title>
</head>
<body>

<form action="<?php echo assem_m( 'add' );?>" method="post">
	sppv_type:<input type='text' name='sppv_type'></input><br>
	sppv_val:<input type='text' name='sppv_val'></input><br>
	sppv_spid:<input type='text' name='sppv_spid'></input><br>
	sppv_pid:<input type='text' name='sppv_pid'></input><br>
	sppv_apt:<input type='text' name='sppv_apt'></input><br>
	sppv_ap:<input type='text' name='sppv_ap'></input><br>
	sppv_st:<input type='text' name='sppv_st'></input><br>
	sppv_s:<input type='text' name='sppv_s'></input><br>
	sppv_sku:<input type='text' name='sppv_sku'></input><br>
	sppv_t_s:<input type='text' name='sppv_t_s'></input><br>
	<input type='hidden' name='form_token' value="<?php echo $this -> val['token']?>">
	<input type="submit" value="submit">
</form>

</body>
</html>
