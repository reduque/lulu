<aside class="noenmobile">
	<h1>LULÚ SHOP</h1><?php
$sql="select idcategoria, categoria_{$idioma} as categoria from categorias";
$r_asida = $db->select($sql);
	?><div><?php
	while ($row_asida=$db->get_row($r_asida, 'MYSQL_ASSOC')){
		?><a href="categorias/<?php echo $row_asida["idcategoria"] ?>/<?php echo urls_amigables($row_asida["categoria"]) ?>"<?php if($row_asida["idcategoria"]==$idcategoria) echo ' class="activo"'; ?>><?php echo $row_asida["categoria"] ?></a><?php
	} ?>
	</div>
</aside>