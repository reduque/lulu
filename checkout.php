<?php
$pagina="carrito";

require_once('conexion.php');
if(!isset($_SESSION["totart"])) $_SESSION["totart"]=0;
$totart=$_SESSION["totart"];
if(rqq("acc")=="enviar"){
	$subject="Se ha realizado una nueva solicitud por la página web";
	$cuerpo='
	<center><h1>Se ha realizado una nueva solicitud por la página web</h1></center>
	<table width="600" align="center">
		<tr><td colspan="5"><h2>DATOS DEL PEDIDO</h2></td></tr>
		<tr>
			<th>PRODUCTO</th>
			<th>MATERIAL</th>
			<th>TAMAÑO</th>
			<th>CANTIDAD</th>
			<th>COMENTARIOS</th>
		</tr>';
	for($l=1; $l<= $_SESSION["totart"] ; $l++){
		$cuerpo.='<tr>
			<td><h3>' . $_SESSION["titulo" . $l] . '</h3><p><img style="width:200px" src="' . $carpeta . 'fotos/productos/tn/' . $_SESSION["foto" . $l] . '" alt="' . $_SESSION["titulo" . $l] . '"></p></td>
			<td><p>' . $_SESSION["material" . $l] . '</p></td>
			<td><p>' . $_SESSION["tamano" . $l] . '</p></td>
			<td><p>' . $_SESSION["cantidad" . $l] . '</p></td>
			<td><p>' . nl2br($_SESSION["descripcion" . $l]) . '</p></td>
		</tr>';
	}
	$cuerpo.='</table>
	<p>&nbsp;</p>
	<table width="600" align="center">
		<tr><td colspan="2"><h2>DATOS DEL SOLICITANTE</h2></td></tr>
		<tr><th>NOMBRE</th><td>' . rqq("nombre") . '</td></tr>
		<tr><th>EMAIL</th><td>' . rqq("email") . '</td></tr>
		<tr><th>TELÉFONO</th><td>' . rqq("telefono") . '</td></tr>
		<tr><th>DIRECCIÓN</th><td>' . nl2br(rqq("diteccion")) . '</td></tr>
	</table>
	<p>&nbsp;</p>
	';

	$emailventas="presupuestoslulu@gmail.com";
	//$emailventas="rafael.duque@gmail.com";
	
	try {
		mail($emailventas, $subject, $cuerpo, $headers);
	} catch (Exception $e) {
	}
	//email al cliente
	$subject="lulucreativeloft.com";
	$cuerpo='<table border="0" align="center" width="500" cellpadding="20"><tr><td align="center"><img src="http://lulucreativeloft.com/imagenes/logo.gif"></td></tr><tr><td align="center">¡Muchas gracias por contactarnos!<br>Ya recibimos tu solicitud y pronto te estaremos enviando el presupuesto.</td></tr></table>';
	$email=rqq("email");
	
	try {
		mail($email, $subject, $cuerpo, $headers);
	} catch (Exception $e) {
	}

	
	$_SESSION["totart"]=0;
	header("location:checkout");
	exit;
}


require_once('arriba.php');
?>
<section class="contenidos">
	<?php require_once('aside.php'); ?>
	<section class="contenidos2">
		<ul class="migas">
			<li><a href="./">Inicio</a></li><li>&nbsp;/&nbsp;</li><li><a href="carrito">Pedidos</a></li>
		</ul>
		<h1>Gracias por su pedido, pronto será contactado por nuestro equipo de ventas.</h1>
	</section>
</section>
<?php require_once('abajo.php'); ?>
