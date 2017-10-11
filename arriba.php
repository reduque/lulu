<?php require_once('conexion.php');

$idcategoria=rqq("idcategoria");
?><!doctype html>
<html>
<head>
<meta name="description" content="Diseño de páginas web">
<meta name="keywords" content="HTML,CSS,XML,JavaScript">
<meta name="author" content="Cacao Digital, C.A.">
<base href="<?php echo $carpeta; ?>" / >

<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="mobile-web-app-capable" content="yes">
<meta name="viewport" content="width=640">
<link rel="apple-touch-icon-precomposed" href="imagenes/logo.png" />
<link rel="icon" href="imagenes/logo.png">

<meta charset="utf-8">
<!--[if lt IE 9]>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
<![endif]-->
<title>lulú Creative Loft</title>
<script src="jquery-1.7.1.min.js"></script>
<link href="estilos.css?v=2" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css"/>
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>

</head>
<body>
<div class="cuerpo">
	<header>
		<a href="./" id="logo"></a>
		<div class="floatd noenmobile">
			<ul class="ul_redes">
				<li><a href="https://www.instagram.com/lulucreativeloft/" target="_blank"><img src="imagenes/instagram.svg"></a></li>
				<li><a href="https://www.pinterest.com/lulucreativelof/" target="_blank"><img src="imagenes/pinterest.svg"></a></li>
				<li><a href="https://www.facebook.com/Lul%C3%BA-Creative-Loft-493083060861917/?fref=ts" target="_blank"><img src="imagenes/facebook.svg"></a></li>
				<li><a href="mailto:lulucreativeloft@gmail.com" class="noload"><img src="imagenes/email.svg"></a></li>
				<?php if(isset($_SESSION["totart"])) if($_SESSION["totart"]>0){ ?><li><a href="carrito"><img src="imagenes/carrito.svg"></a></li><?php } ?>
			<!--
			<?php
			if($idioma=='es'){
				?><li><a href="?i=en" class="noload"><img src="imagenes/en.svg"></a></li><?php
			}else{
				?><li><a href="?i=es" class="noload"><img src="imagenes/es.svg"></a></li><?php
			}?>
		-->
			</ul>
			<div class="separador"></div>
			<nav>
				<ul>
					<li><a href="categorias"<?php if($pagina=="productos") echo ' class="activo"'; ?>><?php if($idioma=="es"){ ?>PRODUCTOS<?php }else{ ?>PRODUCTS<?php } ?></a></li>
					<!-- <li><a href="servicios"<?php if($pagina=="servicios") echo ' class="activo"'; ?>>SERVICIOS</a></li> -->
					<li><a href="nosotros"<?php if($pagina=="nosotros") echo ' class="activo"'; ?>><?php if($idioma=="es"){ ?>SOBRE NOSOTROS<?php }else{ ?>ABOUT US<?php } ?></a></li>
				</ul>
			</nav>
		</div>
		<div class="menu_hamburguesa noenpc"></div>
	</header>
	<ul class="ul_mm noenpc">
		<?php if(isset($_SESSION["totart"])) if($_SESSION["totart"]>0){ ?><li><a href="carrito"><?php if($idioma=="es"){ ?>CARRITO<?php }else{ ?>SHOPPING CARD<?php } ?></a></li><?php } ?>
		<li><a href="categorias"<?php if($pagina=="productos") echo ' class="activo"'; ?>>PRODUCTOS</a></li><?php
		$sql="select idcategoria, categoria_{$idioma} as categoria from categorias";
		$r_asida = $db->select($sql);
		while ($row_asida=$db->get_row($r_asida, 'MYSQL_ASSOC')){
			?><li class="submenues"><a href="categorias/<?php echo $row_asida["idcategoria"] ?>/<?php echo urls_amigables($row_asida["categoria"]) ?>"<?php if($row_asida["idcategoria"]==$idcategoria) echo ' class="activo"'; ?>><?php echo $row_asida["categoria"] ?></a></li><?php
		} ?>
		<li><a href="servicios"<?php if($pagina=="servicios") echo ' class="activo"'; ?>>SERVICIOS</a></li>
		<li><a href="nosotros"<?php if($pagina=="nosotros") echo ' class="activo"'; ?>>SOBRE NOSOTROS</a></li>
	</ul>