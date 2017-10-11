<?php include ("conexion.php");
$ntabla="";
$acc="";
if(isset($_REQUEST["ntabla"])) $ntabla=$_REQUEST["ntabla"];
if(isset($_REQUEST["acc"])) $acc=$_REQUEST["acc"];
if($acc=="ingresar"){
	if(rqq("clave")=="cacaodigitalca"){
		$_SESSION["admincacao"]="ok";
		header('Location:?');
		exit;
	}
}
if($acc=="cargacampos"){
	$tabla=rqq("tabla");
	$sql="select * from " . $tabla . " limit 0,1";
	$r = $db->select($sql);
	$row=$db->get_row($r, 'MYSQL_ASSOC');
	echo "<span onClick=\"llenacampos('" . $tabla . "')\"><b>" . $tabla . "</b></span>";
	foreach ($row as $col => $value) {
		echo " - <span onClick=\"llenacampos('" . $col . "')\">" . $col . "</span>";
	}
	exit;
}
?><html>
<head>
<title>Edición Cacao Digital c.a.</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body bgcolor="#fffff7" text="#000000">
<?php


if(!isset($_SESSION["admincacao"])){?>
	<form name="ss" method="post" action="?acc=ingresar">
		<input name="clave" type="password">
		<input type="submit" value="Ingresar">
	</form><?php
	exit;
}
if($ntabla==""){ ?>
	<table width="100%"><tr>
	<td width="1" style="padding-right:20px; white-space:nowrap" valign="top">
	<div onClick="llena('Select ')">Select</div>
	<div onClick="llena('Select * from ')">Select * from</div>
	<div onClick="llena('describe ')">describe</div>
	<div onClick="llena(' order by ')">order by</div>
	<p>------</p>
	<?php
	$sql="SELECT table_name FROM information_schema.tables where table_schema='" . $db->db . "'";
	$r = $db->select($sql);
	while($row=$db->get_row($r, 'MYSQL_ASSOC')){
		?><div><span class="estructura" onClick="leecampos('<?php echo $row["table_name"]; ?>')"></span> <span onClick="llena('<?php echo $row["table_name"]; ?>')"><?php echo $row["table_name"]; ?></span></div><?php
	} ?>
	</td>
	<td valign="top">
		<form name="form1" method="post" action="?acc=consultar">
			<textarea name="ntabla" id="t1" rows="5" style="width:100%"><?php echo $ntabla ?></textarea>
			<p><input type="submit" name="Submit" value="Consultar">&nbsp;&nbsp;<button onClick="document.form1.ntabla.value=''">Limpiar</button></p>
		</form> 
		<p id="campos"></p>
		<form name="form2" method="post" action="?acc=ejecutar">
			<textarea name="ntabla" id="t2" rows="20" style="width:100%"><?php echo $ntabla ?></textarea>
			<p><input type="submit" name="Submit" value="Ejecutar"></p>
		</form>
	</td>
	</tr></table>
<style>
	span{cursor:pointer;}
	.estructura{width:17px; height:17px;display:inline-block; background-image:url("data:image/svg+xml;utf8,<svg version='1.1' id='Capa_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px'	 viewBox='0 0 60 60' style='enable-background:new 0 0 60 60;' xml:space='preserve'><path d='M53,41V29H31V19h7V3H22v16h7v10H7v12H0v16h16V41H9V31h20v10h-7v16h16V41h-7V31h20v10h-7v16h16V41H53z M24,5h12v12H24V5z	 M14,55H2V43h12V55z M36,55H24V43h12V55z M58,55H46V43h12V55z'/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>");}
</style>
	
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script type="text/javascript">
	var cact="t1";
	function llena(conque){
		document.form1.ntabla.value+=conque;
	}
	function leecampos(tabla){
		$("#campos").load("edicion.php?acc=cargacampos&tabla=" + tabla);
	}
	$("#t1").focus(function(){cact="t1";})
	$("#t2").focus(function(){cact="t2";})

	function llenacampos(campo){
		$('#' + cact).val($('#' + cact).val() + campo);
		$('#' + cact).focus();
	}
</script>


<?php }else{ 
?><a href="javascript:" onClick="window.history.back(1);">Regresar</a><?php
	if($acc=="consultar"){
		$db->dump_query($_REQUEST["ntabla"]);
	}else{
		$db->ejecutar_sql($_REQUEST["ntabla"]);
		$db->print_last_query();
		echo "<p>Ejecutado</p>";
	}
?><a href="javascript:" onClick="window.history.back(1);">Regresar</a><?php
} ?>
</body>
</html>
