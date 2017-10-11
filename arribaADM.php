<?php
include ("conexion.php");
if (empty($_SESSION['usradm'])) header("location:administracion.php");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<html lang="es">
<title>Administración</title>
<link href="estilosADM.css" rel="stylesheet" type="text/css" />
<script src="jquery-1.7.1.min.js"></script>
</head>
<body>

<!--
	ojo con:
	
	* TITULO
	* 		web mail
	* 		estadísticas
	* 		panel de control
	* 		soporte técnico 2 veces
	*** 	derechos reservados abajo

-->

<section id="titulo">
	<h1>Cliente</h1>
	<div class="alinear_de"><a href="administracion2.php">Ir al inicio</a><a href="index.php" target="_blank">Ver mi sitio web</a><a href="administracion.php?acc=1">Salir del administrador</a></div>
</section>

<?php
$_SESSION['admin']="";

$sql="select * from admin where id_admin=" . $_SESSION["usradm"];
$r = $db->select($sql);
$row=$db->get_row($r);
?>
<div id="cuerpo">
	<aside>
		<ul>
		<?php if($row["mantcontenidos"]=='S'){
			$_SESSION['admin']=$_SESSION['admin'] . "mantcategorias.php mantproductos.php mantbanners.php" ?>
			<li><a href="mantcategorias.php">Categorías / Productos</a></li>
			<li><a href="mantbanners.php">Banners</a></li>
			<li><a href="mantemails.php">Suscripciones</a></li>
		<?php } ?>
		</ul>
	
		<ul>
		<?php if($row["mantadmin"]=='S'){
			$_SESSION['admin']=$_SESSION['admin'] . "mantadmin.php" ?>
			<li><a href="mantadmin.php" class="i_usuario">Administradores</a></li>
		<?php } ?>
			<li><a href="mailto:info@cacaodigital.com" class="i_email">Soporte técnico</a></li>
		</ul>
	</aside>
	<div id="cuerpo2">