<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ÎÞ±êÌâÎÄµµ</title>
<script type="text/javascript" src="<?php echo _PURL_;?>/js/jquery_1.2.6.min.js"></script>
</head>

<body>
<input type="button" value="click">
<?php echo _PURL_;?>
<script>


$.ajax({'url':'<?php echo assem_m( 'get' );?>','type':'post','dataType':'text','data':{},success:function(result){ 
	console.log( result );
 }
});

</script>
</body>
</html>
