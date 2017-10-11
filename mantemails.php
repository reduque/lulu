<?php 
include ("conexion.php");
if (empty($_SESSION['usradm'])){?><script type="text/javascript">document.location="administracion.php";</script><?php  }
if (!isset($_SESSION['usradm'])){?><script type="text/javascript">document.location="administracion.php";</script><?php  }
if (ord($_SESSION["usradm"])==0) header("location:administracion.php");
if (ord($_SESSION["usradm"])==0){ ?>
<script type="text/javascript">
	document.location="administracion.php";
</script>
<?php  } ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Administraci&oacute;n</title>
</head>

<body>
<?php 
$db->dump_query("select email from emails");
?>
</body>
</html>