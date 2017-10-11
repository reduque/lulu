<?php
$pagina="carrito";
require_once('conexion.php');
if(!isset($_SESSION["totart"])) $_SESSION["totart"]=0;
$totart=$_SESSION["totart"];
$idproducto=rqq("idproducto");
if($idproducto<>""){
	$noesta=true;
	$cantidad=rqq("cantidad");
	if($cantidad=="") $cantidad=1;
	if($cantidad==0){
		$pborrar=10000;
		for($l=1; $l<=$totart; $l++){
			if($_SESSION["idproducto" . $l]==$idproducto){
				$pborrar=$l;
				$l=10000;
			}
		}
		if($pborrar<>10000){
			for($l=$pborrar; $l<=$totart-1; $l++){
				$_SESSION["idproducto" . $l]=$_SESSION["idproducto" . ($l+1)];
				$_SESSION["cantidad" . $l]=$_SESSION["cantidad" . ($l+1)];
				$_SESSION["descripcion" . $l]=$_SESSION["descripcion" . ($l+1)];
				$_SESSION["material" . $l]=$_SESSION["material" . ($l+1)];
				$_SESSION["tamano" . $l]=$_SESSION["tamano" . ($l+1)];
				$_SESSION["titulo" . $l]=$_SESSION["titulo" . ($l+1)];
				$_SESSION["foto" . $l]=$_SESSION["foto" . ($l+1)];
				$_SESSION["cantidades" . $l]=$_SESSION["cantidades" . ($l+1)];
			}
			$totart--;
			$_SESSION["totart"]=$totart;
		}
		$noesta=false;
	}else{
		for($l=1; $l<=$totart; $l++){
			if($_SESSION["idproducto" . $l]==$idproducto){
				$_SESSION["cantidad" . $l]=$cantidad;
				$noesta=false;
			}
		}
	}
	if($noesta){
		$totart++;
		$_SESSION["totart"]=$totart;
		$_SESSION["idproducto" . $totart]=$idproducto;
		$_SESSION["cantidad" . $totart]=$cantidad;
		$_SESSION["descripcion" . $totart]=rqq("descripcion");
		$_SESSION["material" . $totart]=rqq("material");
		$_SESSION["tamano" . $totart]=rqq("tamano");
		$_SESSION["titulo" . $totart]=rqq("titulo");
		$_SESSION["foto" . $totart]=rqq("foto");
		$_SESSION["cantidades" . $totart]=rqq("cantidades");
	}
	header("location:carrito");
}


require_once('arriba.php');
?>
<section class="contenidos">
	<?php require_once('aside.php'); ?>
	<section class="contenidos2">
		<ul class="migas">
			<li><a href="./">Inicio</a></li><li>&nbsp;/&nbsp;</li><li><a href="carrito">Pedidos</a></li>
		</ul>
		<?php
		if($_SESSION["totart"]>0){ ?>
			<table class="t_carrito">
				<tr>
					<th>PRODUCTO</th>
					<th class="noenmobile">MATERIAL</th>
					<th class="noenmobile">TAMAÑO</th>
					<th class="noenmobile">CANTIDAD</th>
					<th class="noenpc">DESCRIPCIÓN</th>
				</tr>
			<?php
			for($l=1; $l<= $_SESSION["totart"] ; $l++){
				?><tr>
					<td><h1><?php echo $_SESSION["titulo" . $l]; ?></h1><p><img src="fotos/productos/tn/<?php echo $_SESSION["foto" . $l]; ?>" alt="<?php echo $_SESSION["titulo" . $l]; ?>"></p></td>
					<td class="noenmobile"><p><?php echo $_SESSION["material" . $l]; ?></p></td>
					<td class="noenmobile"><p><?php echo $_SESSION["tamano" . $l]; ?></p></td>
					<td class="noenmobile"><p><select onChange="$('#cargando').fadeIn(500); document.location='carrito?idproducto=<?php echo $_SESSION["idproducto" . $l]; ?>&cantidad=' + this.value"><option value="0">Eliminar</option><?php
						$cantidades=explode("|", $_SESSION["cantidades" . $l]);
						foreach($cantidades as $cantidad){
							?><option value="<?php echo $cantidad; ?>"<?php if($cantidad==$_SESSION["cantidad" . $l]) echo ' selected'; ?>><?php echo $cantidad; ?></option><?php
						} ?>
					</select></p></td>
					<td class="noenpc">
						<p>MATERIAL: <?php echo $_SESSION["material" . $l]; ?></p>
						<p>TAMAÑO: <?php echo $_SESSION["tamano" . $l]; ?></p>
						<p>CANTIDAD: <select onChange="$('#cargando').fadeIn(500); document.location='carrito?idproducto=<?php echo $_SESSION["idproducto" . $l]; ?>&cantidad=' + this.value"><option value="0">Eliminar</option><?php
							$cantidades=explode("|", $_SESSION["cantidades" . $l]);
							foreach($cantidades as $cantidad){
								?><option value="<?php echo $cantidad; ?>"<?php if($cantidad==$_SESSION["cantidad" . $l]) echo ' selected'; ?>><?php echo $cantidad; ?></option><?php
							} ?>
						</select></p>
					</td>
				</tr><?php
			} ?>
			</table>
			<p>&nbsp;</p>
			<form id="form_suscrip" name="form_suscrip" method="post" action="checkout?acc=enviar" onsubmit="return valida_pedido(this)">
			<table class="t_carrito2">
				<tr>
					<th>NOMBRE</th>
					<td><input type="text" name="nombre" required></td>
				</tr>
				<tr><td class="tdsep"></td></tr>
				<tr>
					<th>EMAIL</th>
					<td><input type="email" name="email" required></td>
				</tr>
				<tr><td class="tdsep"></td></tr>
				<tr>
					<th>TELÉFONO</th>
					<td><input type="text" name="telefono" required></td>
				</tr>
				<tr><td class="tdsep"></td></tr>
				<tr>
					<th>DIRECCIÓN DE ENVÍO</th>
					<td><textarea name="diteccion" rows="5" required></textarea></td>
				</tr>
				<tr><td class="tdsep"></td></tr>
				<tr><td colspan="2"><input type="submit" class="botones" value="ENVIAR"></td></tr>
			</table>
			</form>
		<?php }else{
			?><p>No posee productos en el carrito en este momento</p><?php
		}?>
	</section>
</section>
<script type="text/javascript">
<!--
	function valida_pedido(elFRM){
		var m="";
		if(m=="" && elFRM.nombre.value=="") m="Debe llenar todos los campos del formulario";
		if(m=="" && elFRM.email.value=="") m="Debe llenar todos los campos del formulario";
		if(m=="" && elFRM.email.value!="" && !vemail(elFRM.email.value)) m="El email es inválido";
		if(m=="" && elFRM.telefono.value=="") m="Debe llenar todos los campos del formulario";
		if(m=="" && elFRM.diteccion.value=="") m="Debe llenar todos los campos del formulario";
		if(m==""){
			return true;
		}else{
			alert(m);
			return false;
		}
	}
-->
</script>
<?php require_once('abajo.php'); ?>