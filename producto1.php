<?php
$pagina="productos";
require_once('arriba.php');
$idproducto=rqq("idproducto");
$sql="select idproducto, titulo_{$idioma} as titulo, a.foto as foto_p, b.* from productos a inner join categorias b on a.idcategoria=b.idcategoria where idproducto=" . $idproducto;
$r = $db->select($sql);
$row=$db->get_row($r, 'MYSQL_ASSOC');

$row["categoria"]=$row["categoria_" . $idioma];
for($l=1; $l<=3; $l++){
	$row["material" . $l]=$row["material" . $l . "_" . $idioma];
	$row["tamano" . $l]=$row["tamano" . $l . "_" . $idioma];
}

$idcategoria=$row["idcategoria"];
?>
<section class="contenidos">
	<?php require_once('aside.php'); ?>
	<section class="contenidos2">
		<ul class="migas">
			<li><a href="./">Inicio</a></li>
			<li>&nbsp;/&nbsp;</li><li><a href="categorias/<?php echo $row["idcategoria"] ?>/<?php echo urls_amigables($row["categoria"]) ?>"><?php echo $row["categoria"] ?></a></li>
			<li>&nbsp;/&nbsp;</li><li><a href="producto/<?php echo $row["idproducto"] ?>/<?php echo urls_amigables($row["titulo"]) ?>"><?php echo $row["titulo"] ?></a></li>
		</ul>
		<div class="det_prdito">
			<h1 class="noenpc"><?php echo $row["categoria"] ?> <?php echo $row["titulo"] ?></h1>
			<center><img src="fotos/productos/<?php echo $row["foto_p"] ?>" alt="<?php echo $row["titulo"] ?>"></center>
			<div class="Desc_producto">
				<h1 class="noenmobile"><?php echo $row["categoria"] ?> <?php echo $row["titulo"] ?></h1>
				<form id="form_pedido" name="form_pedido" method="post" action="carrito">
					<input name="idproducto" type="hidden" value="<?php echo $row["idproducto"] ?>">
					<input name="titulo" type="hidden" value="<?php echo $row["categoria"] ?> <?php echo $row["titulo"] ?>">
					<input name="foto" type="hidden" value="<?php echo $row["foto_p"] ?>">
					<table>
						<tr>
							<th>MATERIAL</th>
							<td>
								<select name="material"><?php
								for($l=1; $l<=3; $l++){
									if($row["material" . $l]<>""){ ?><option value="<?php echo $row["material" . $l]; ?>"><?php echo $row["material" . $l]; ?></option><?php }
								}
								?></select>
							</td>
						</tr>
						<tr><td class="tdsep"></td></tr>
						<tr>
							<th>TAMAÑO</th>
							<td>
								<select name="tamano"><?php
								for($l=1; $l<=3; $l++){
									if($row["tamano" . $l]<>""){ ?><option value="<?php echo $row["tamano" . $l]; ?>"><?php echo $row["tamano" . $l]; ?></option><?php }
								}
								?></select>
							</td>
						</tr>
						<tr><td class="tdsep"></td></tr>
						<tr>
							<th>CANTIDAD</th>
							<td>
								<select name="cantidad"><?php
								$u="";
								$cantidades="";
								for($l=1; $l<=3; $l++){
									if($row["cantidad" . $l]<>""){ 
										?><option value="<?php echo $row["cantidad" . $l]; ?>"><?php echo $row["cantidad" . $l]; ?></option><?php
										$cantidades.= $u . $row["cantidad" . $l];
										$u="|";
									}
								}
								?></select>
								<input type="hidden" name="cantidades" value="<?php echo $cantidades; ?>">
							</td>
						</tr>
						<tr><td class="tdsep"></td></tr>
						<tr><th>COMENTARIO</th></tr>
						<tr><td class="tdsep"></td></tr>
						<tr>
							<td colspan="2">
								<textarea name="descripcion" rows="5"></textarea>
							</td>
						</tr>
						<tr><td class="tdsep"></td></tr>
						<tr>
							<td colspan="2" style="text-align:center">
								<button onClick="document.form_pedido.submit();">AGREGAR<br>AL PRESUPUESTO</button>
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</section>
</section>
<script type="text/javascript">
<!--
	function valida(elFRM){
		var m="";
		if(elFRM.comentario.value=="") m="Debe llenar el email";
		if(m=="" && elFRM.email.value!="" && !vemail(elFRM.email.value)) m="El email es inválido";
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