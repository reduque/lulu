<?php
$pagina="inicio";
require_once('arriba.php'); ?>
	<section class="contenidos">
		<?php require_once('aside.php'); ?>
		<section class="contenidos2">
		<?php
		$sql="select * from banners order by rand()";
		$r = $db->select($sql);
		while ($row=$db->get_row($r, 'MYSQL_ASSOC')){
			?><a href="<?php echo $row["enlace"] ?>"><img src="fotos/banners/<?php echo $row["foto"] ?>" alt="<?php echo $row["titulo"]; ?>"></a><?php
		} ?>		
		</section>
		<script type="text/javascript">
		$(document).ready(function(e) {
			$('.contenidos2').slick({
				dots: false,
				autoplay: true,
				autoplaySpeed:5000,
				prevArrow:'<div class="slick-prev"></div>',
				nextArrow:'<div class="slick-next"></div>'
			});
		});
		</script>
	</section>
	<ul class="cat_home"><?php
	$sql="select idcategoria, categoria_{$idioma} as categoria, foto from categorias where destacado='S'";
	$r = $db->select($sql);
	while ($row=$db->get_row($r, 'MYSQL_ASSOC')){
		?><li><a href="categorias/<?php echo $row["idcategoria"] ?>/<?php echo urls_amigables($row["categoria"]) ?>"><img src="fotos/categorias/<?php echo $row["foto"] ?>"><h2><?php echo $row["categoria"] ?></h2></a></li><?php
	} ?></ul>
<?php require_once('abajo.php'); ?>