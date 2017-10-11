<?php
include ("conexion.php");
$acc=rqq("acc");
switch($acc){
case "cargadatos":
	$pagina=rqq("pagina");
	if($pagina=="") $pagina=1;
	$idcategoria=rqq("idcategoria");
	$registros_por_pagina=15;
	$inicio = ($pagina - 1) * $registros_por_pagina;
	$sql="select idproducto, titulo_{$idioma} as titulo, foto from productos";
	if($idcategoria<>"") $sql.=" where idcategoria={$idcategoria}";
	$sql.=" limit " . $inicio . "," . $registros_por_pagina;
/*
echo $sql;
exit;
*/
	$r = $db->select($sql);
	$data["total"]=$db->row_count;
	while ($row=$db->get_row($r, 'MYSQL_ASSOC')){
		$row["tit_amigable"]=urls_amigables($row["titulo"]);
		$data["registros"][]=$row;
	}
	echo json_encode($data);
	break;



}




?>