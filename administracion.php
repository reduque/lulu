<?php include ("conexion.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administración</title>
<link href="estilosADM.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
$acc=rqq('acc');
if (empty($_SESSION['usradm']) and $acc=="3") $acc="";
if (!empty($_SESSION['usradm']) and $acc=="") $acc="3";
if($acc=="2"){

	$usuario = rqq('login');
	$pass = rqq('password');
	$sql = "select id_admin from admin where nombre = '$usuario' AND clave = '$pass' ";
	$r = $db->select($sql);
	if($db->row_count>0){
		$row=$db->get_row($r);
		$idusuario = $row["id_admin"] ;
		$_SESSION['usradm'] = $idusuario;
		$acc="3";
	}else{
		$_SESSION['usradm']="";
		$acc="";
		$err1="si";
	}
}
switch ($acc) {
	case "1":
		cerrar();
		break;
	case "3": ?>
		<script type="text/javascript">
			<!--
			 document.location="administracion2.php";
		 	-->
		 </script>
		 <?php
		 exit();
		break;
	default:
		login();
		break;
}

function cerrar(){

	session_destroy();?>
		<script type="text/javascript">
			<!--
			 document.location="index.php";
		 	-->
		 </script>
	<?php exit();
}

function login(){ 
	global $err1;?>

<form name="formingreso" method="post" action="?acc=2">


<div id="inicio">INICIAR SESIÓN</div>
<div id="inicio1">
	<div id="inicio2">
	
		<p>NOMBRE DE USUARIO</p>
		<p><input name="login" type="text" class="Caja_texto"></p>
		<p>CONTRASEÑA</p>
		<input name="password" type="password" class="Caja_texto"><br /><br />
		
		<div class="alinear_de">
			<input type="submit" value="ENTRAR" class="botones" />&nbsp;&nbsp;&nbsp;&nbsp;
		</div>
	</div>
	<div id="error1">
		<?php if($err1=="si"){ ?>Usuario o clave inválidos<?php } ?>
	</div>
</div>
</form>
<script language="javascript">
	document.formingreso.login.focus();;
</script>

<?php } ?>
</body>
</html>
