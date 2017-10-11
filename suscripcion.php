<?php
$pagina="carrito";

require_once('conexion.php');
if(!isset($_SESSION["totart"])) $_SESSION["totart"]=0;
$totart=$_SESSION["totart"];
if(rqq("acc")=="enviar"){
	$email=rqq("email");
	if($email<>""){
		$sql="select 1 from emails where email='" . $email . "'";
		$r = $db->select($sql);
		if($db->row_count==0){
			$data = array(
				'email' => $email,
			);
			$idemail=$db->insert_array('emails', $data);
			if(!$idemail){
				$db->print_last_error(false);
				exit();
			}
		}
	}
	
	header("location:suscripcion");
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
		<h1>Gracias por suscribirte en nuestra página.</h1>
	</section>
</section>
<?php require_once('abajo.php'); ?>