<?php
$pagina="productos";
require_once('arriba.php'); ?>
<section class="contenidos">
	<?php require_once('aside.php'); ?>
	<section class="contenidos2">
		<ul class="migas"><li><a href="./">Inicio</a></li><?php if($idcategoria<>""){
			$sql="select idcategoria, categoria_{$idioma} as categoria from categorias where idcategoria=" . $idcategoria;
			$r = $db->select($sql);
			$row=$db->get_row($r, 'MYSQL_ASSOC');
			?><li>&nbsp;/&nbsp;</li><li><a href="categorias/<?php echo $row["idcategoria"] ?>/<?php echo urls_amigables($row["categoria"]) ?>"><?php echo $row["categoria"] ?></a></li><?php 
		}else{
			?><li>&nbsp;/&nbsp;</li><li><a href="categorias">Productos</a></li><?php
		}?></ul>
		<ul class="ul_prod_cat"><li></li><li></li><li></li></ul>
	</section>
</section>
<div id="guia"></div>
<script type="text/javascript">
$(document).ready(function(e) {
	var cargando="No", paginaactual=0, seguircargando="Si", liact=1;
	$(window).scroll(function(e){
		if(cargando=="No" && seguircargando=="Si"){
			scrolled = $(window).scrollTop();
			x=$("#guia").offset().top - $(window).height();
			if(scrolled>x){
				cargadatos();
			}
		}
	});
	cargadatos=function(){
		cargando="Si";
		paginaactual++;
		$("#cargando").fadeIn(500);
		$.ajax({
			data: "acc=cargadatos&idcategoria=<?php echo $idcategoria; ?>&pagina=" + paginaactual,
			type: "GET",
			dataType: "json",
			url: "auxiliar.php",
			success: function(data){
				if(data.total>0){
					$.each(data.registros, function(i,registro){
						//$(".ul_prod_cat li:nth-child(" + liact + ")").append('<a href="producto/' + registro.idproducto + '/' + registro.tit_amigable + '"><img src="fotos/productos/tn/' + registro.foto + '" alt="' + registro.titulo + '"></a>');
						$(".ul_prod_cat li:nth-child(" + liact + ")").append('<a href="producto/' + registro.idproducto + '/' + registro.tit_amigable + '"><img src="fotos/productos/' + registro.foto + '" alt="' + registro.titulo + '"></a>');
						liact++;
						if(liact>3) liact=1;
					});
					//if(data.total<=9) seguircargando="No";
				}else{
					seguircargando="No";
				}
				$("#cargando").fadeOut(500);
				cargando="No";
			}
		});

	}
	$("#cargando").fadeIn(500);
	setTimeout("cargadatos();",1000);

});
</script>
<?php require_once('abajo.php'); ?>