<?php
@session_start();

if (strrpos($_SESSION['admin'], $NombrePagina) === false) {
	header("Location:administracion.php");
	exit();
}

include "arribaADM.php" ?>

<?php
/*
OJO Para filtro
Agregar en la definición de valores de cada campo

$Filtrable=8;

y a cada campo que se quiera filtrar se le pone

$Campos[$a][$Filtrable]="Si";


*/
$Accion=rqq("accion");

// Funciones para crear los fintros
if($Accion=="crearfiltro"){
	for($i=1;$i<=$NCampos;$i++){
		if(isset($Campos[$i][$Filtrable])){
			$_SESSION[$NombrePagina . "_" . $Campos[$i][$Nombre]]=rqq("c_" . $Campos[$i][$Nombre]);
		}
	}
	$Accion="";
}
if(isset($Filtrable)){
	$virus = array(" el "," la "," las "," los "," un "," una "," unas "," de "," del "," y "," the "," and ");
	$cambios  = array(" "," "," "," "," "," "," "," "," "," "," "," ");
	if(!isset($whe)) $whe="";
	for($i=1;$i<=$NCampos;$i++){
		if(isset($Campos[$i][$Filtrable])){
			if(!isset($_SESSION[$NombrePagina . "_" . $Campos[$i][$Nombre]])) $_SESSION[$NombrePagina . "_" . $Campos[$i][$Nombre]]="";
			if($_SESSION[$NombrePagina . "_" . $Campos[$i][$Nombre]]<>""){
				if($whe<>"") $whe.=" and ";
				$_SESSION[$NombrePagina . "_" . $Campos[$i][$Nombre]]=str_replace($virus, $cambios, " " . $_SESSION[$NombrePagina . "_" . $Campos[$i][$Nombre]] . " ");
				$_SESSION[$NombrePagina . "_" . $Campos[$i][$Nombre]]=trim($_SESSION[$NombrePagina . "_" . $Campos[$i][$Nombre]]);
				$mpalabras = explode(" ", $_SESSION[$NombrePagina . "_" . $Campos[$i][$Nombre]]);
				$whe.= creawhere($Campos[$i][$Nombre]);
			}
		}
	}
	
}
function creawhere($campo){
	global $whe;
	global $mpalabras;
	$u="";
	foreach($mpalabras as $palabra){
		if(trim($palabra)<>""){
			$whe.=$u . $campo . " like '%" . $palabra . "%'";
			$u=" and ";
		}
	}
}
// fin de filtros

if(!isset($_SESSION["Ordenar" . $NombrePagina])){
	$_SESSION["Ordenar" . $NombrePagina]=$Campos[0][$Nombre];
}else
	if($_SESSION["Ordenar" . $NombrePagina]=="")
		$_SESSION["Ordenar" . $NombrePagina]=$Campos[0][$Nombre];
$union="";$StrCamp="";
for($i=0;$i<=$NCampos;$i++){
	$StrCamp=$StrCamp . $union . $Campos[$i][$Nombre];
	$union=",";
}
if(!isset($whe)) $whe='';
if($whe==''){
	$sqlcont="Select count(*) as total from " . $NombreTabla;
	$SQL="Select " . $StrCamp . " from " . $NombreTabla;
	if(isset($_SESSION["Where" . $NombrePagina])) if($_SESSION["Where" . $NombrePagina]!=''){
		$sqlcont=$sqlcont . " Where " . $_SESSION["Where" . $NombrePagina];
		$SQL=$SQL . " Where " . $_SESSION["Where" . $NombrePagina];
	}
}else{
	$sqlcont="Select count(*) as total from " . $NombreTabla . " Where ".$whe;
	$SQL="Select " . $StrCamp . " from " . $NombreTabla . " Where ".$whe;
	if(isset($_SESSION["Where" . $NombrePagina])) if($_SESSION["Where" . $NombrePagina]!=''){
		$sqlcont=$sqlcont . " and " . $_SESSION["Where" . $NombrePagina];
		$SQL=$SQL . " and " . $_SESSION["Where" . $NombrePagina];
	}
}
$SQL=$SQL . " Order by " . $_SESSION["Ordenar" . $NombrePagina];


//echo $SQL;

$id=rqq("id");
$pos=rqq("pos");

switch (true){
	case ($Accion==""):
	//**********************  lista	

//echo $SQL;
	$tamanopagina=60;
	$pag=(int)("0" . rqq("pag"));
	if($pag==0) $pag=1;
	$r = $db->select($sqlcont);
	$row=$db->get_row($r, 'MYSQL_ASSOC');
	$totalpaginas=ceil($row["total"] / $tamanopagina);
	$r = $db->select($SQL . " LIMIT ". (($pag-1) * $tamanopagina) ."," . $tamanopagina);
	?>

<h2 id="tit_cuerpo"><?php echo strtoupper($Titulo2) ?> | LISTADO</h2>

<?php // OJO Filto
if(isset($Filtrable)){ ?>
	<form name="filtro" method="post" action="?accion=crearfiltro">
	<table border="0" cellspacing="0" cellpadding="5" style="margin-left:12px; margin-top:10px;"><tr><th align="left" colspan="2">FORMULARIO DE FILTRO</th></tr><?php
	for($i=1;$i<=$NCampos;$i++){
		if(isset($Campos[$i][$Filtrable])){?>
			<tr><td><?php echo $Campos[$i][$Titulo]; ?></td><td><input name="c_<?php echo $Campos[$i][$Nombre]; ?>" value="<?php echo $_SESSION[$NombrePagina . "_" . $Campos[$i][$Nombre]]; ?>" /></td></tr>
<?php }
	}
	?><tr><td colspan="2"><input type="submit" value="Filtrar" class="botones" />&nbsp;&nbsp;&nbsp;<a href="?accion=crearfiltro" class="botones">Quitar filtros</a></td></tr>
	</table></form><?php
}?>
<div class="navegacion">
<?php if(!isset($noincluir)){ ?><a href="?accion=agregar" class="agregar">Agregar nuevo registro</a><?php } ?>
<?php if($totalpaginas>1){ ?>
	<ul>
		<li<?php if($pag>1){ ?> class="activo" onClick="document.location='?pag=<?php echo $pag-1 ?>'"<?php }else{?> class="inactivo"<?php } ?>></li>
		<li>Página <?php echo $pag; ?> de <?php echo $totalpaginas; ?>
		<div><?php for($l=1; $l<=$totalpaginas; $l++){
			?><a href="?pag=<?php echo $l ?>"<?php if($pag==$l){ ?> class="activo"<?php } ?>>Página <?php echo $l ?></a><?php
		}?></div>
		</li>
		<li<?php if($pag<$totalpaginas){ ?> class="activo" onClick="document.location='?pag=<?php echo $pag+1 ?>'"<?php }else{?> class="inactivo"<?php } ?>></li>
	</ul>
<?php } ?>
</div>
<form name="formulario" method="post">
	<table id="tabla1">
		<thead> 
		  <?php for($i=1;$i<=$CamposLista;$i++){?>
			  <td><?php echo $Campos[$i][$Titulo]?></td>
		  <?php } ?>
		  	<td>&nbsp;</td>
		</thead>
	
		<?php
	//
	while ($row=$db->get_row($r, 'MYSQL_ASSOC')) {
		$id=$row[$Campos[0][$Nombre]];?>
		<tr onClick="editar(<?php echo $id?>)"> 
		  <?php for($i=1;$i <= $CamposLista;$i++){
				$id=$row[$Campos[0][$Nombre]];?>
				<td title="Código: <?php echo $id?>">
				<?php
				if(strtoupper($Campos[$i][$Tipo])=="SELECT"){
					if(strtoupper($Campos[$i][$Largo])=="SQL"){
						$r2 = $db->select($Campos[$i][$Valida]);
						while ($aux=$db->get_row($r2, 'MYSQL_ASSOC')) {
							if($row[$Campos[$i][$Nombre]]==$aux[$Campos[$i][$Nombre]]){
								echo $aux["tit"];
								break;
							}
						}
					}else{
						$sellist=explode("|",$Campos[$i][$Valida]);
						$most="";
						for($ii=0;$ii < count($sellist);$ii++){
							if($sellist[$ii]==$row[$Campos[$i][$Nombre]]) $most=$sellist[$ii+1];
							$ii++;
						}
						echo $most;
					}
				}else if(strtoupper($Campos[$i][$Tipo])=="FECHA"){
					echo Mfec($row[$Campos[$i][$Nombre]]);
				}else{
					echo Recortar($row[$Campos[$i][$Nombre]],200);
				}?></td>
		  <?php } ?>
		  <td align="right" style="white-space:nowrap">
			<a href="javascript:editar(<?php echo $id?>)" class="editar" title="Editar"></a>
			<?php if(!isset($noincluir)){ ?><a href="javascript:eliminar(<?php echo $id?>,<?php echo $pag?>)" class="eliminar" title="Eliminar"></a><?php } ?>
		  </td>
	 </tr>
	<?php } ?>
	  </table>

	<input type="hidden" value="Button" id="pag" name="pag"> <input type="hidden" value name="id"> 
	<input type="hidden" value name="accion"> <br> </td>


<div id="botones_accion">
<?php if(!isset($noincluir)){ ?><a href="?accion=agregar" class="agregar">Agregar nuevo registro</a><?php } ?>
<?php if(isset($ManEncadenado4)) echo $ManEncadenado4 ?>
	<?php if($Accion=="eliminar"){ ?><div class="alinear_de">Registro borrado<br></div><?php } ?>
</div>
<p>&nbsp;</p>
</form>

<script LANGUAGE="javascript">
{
	function eliminar(x,l)
	{
		if (confirm("Esta seguro de Eliminar este registro"))
			{
				document.formulario.accion.value = "eliminar";
				document.formulario.id.value = x;
				document.formulario.pag.value = l;
				document.formulario.submit();
			}
	}
	function editar(x)
	{
			document.formulario.accion.value = "editar";
			document.formulario.id.value = x;
			document.formulario.submit();
	}
}

</script>


<?php
	break;
case ($Accion=="editar" || $Accion=="agregar"):
	//**********************  editar
	if($Accion=="editar"){
		if($whe==''){
			$sql="Select count(*) as c from " . $NombreTabla;
			if(isset($_SESSION["Where" . $NombrePagina])) if($_SESSION["Where" . $NombrePagina]!='') $sql=$sql . " Where " . $_SESSION["Where" . $NombrePagina];
		}else{
			$sql="Select count(*) as c from " . $NombreTabla . " Where " . $whe;
			if(isset($_SESSION["Where" . $NombrePagina])) if($_SESSION["Where" . $NombrePagina]!='') $sql=$sql . " and " . $_SESSION["Where" . $NombrePagina];
		}
		
		$r = $db->select($sql);
		//echo $sql;
		$row=$db->get_row($r);
		$TotPos=$row["c"];
	
		$r = $db->select($SQL);
		//echo $SQL;
	
		$absPos=1;
		if($id!=""){//es por que vengo de la lista
			$Continuar=true;
			while (($row=$db->get_row($r, 'MYSQL_ASSOC')) && $row[$Campos[0][$Nombre]]<>$id) { 
				$Continuar=$row[$Campos[0][$Nombre]]<>$id;
				$absPos++;
			}
		}else if($pos!=""){//me estoy moviendo de uno en uno
			for($i=1;$i<=$pos;$i++){$succ = $row=$db->get_row($r, 'MYSQL_ASSOC'); $absPos++;}
			$absPos--;
		}
		$id=$row[$Campos[0][$Nombre]];
		$atras=$absPos!=1;
		$adelante=$absPos!=$TotPos;
		$Nuevo=false;
	}else{
		$atras=false;
		$adelante=false;
		$Nuevo=true;
	}
?><form name="formulario" method="post" action="?"> 
<h2 id="tit_cuerpo"><?php echo strtoupper($Titulo2) ?> | <?php if($Accion=="editar"){ ?>EDICIÓN<?php }else{ ?>NUEVA ENTRADA<?php } ?></h2>

<div class="navegacion">
	<a href="?" title="Ver lista" class="i_botones i_lista"></a>
<?php if($Accion!="agregar") if(!isset($noincluir)){?><a href="?accion=agregar"  class="i_botones i_agregar" title="Agregar nuevo registro"></a><?php } ?>
	<a href="JavaScript:Enviar();" title="Guardar" class="i_botones i_aceptar"></a>
<?php if($Accion!="agregar")  if(!isset($noincluir)){?><a href="javascript:eliminar(<?php echo $id ?>)"  class="i_botones i_eliminar" title="Eliminar"></a><?php }

if($Accion=="editar"){ ?>
	<ul>
		<li<?php if($absPos>1){ ?> class="activo" onClick="document.location='?accion=editar&amp;pos=<?php echo $absPos-1 ?>'"<?php }else{?> class="inactivo"<?php } ?>></li>
		<li title="Código:<?php echo $row[$Campos[0][$Nombre]]?>">Reg: <?php echo $absPos . " de: " . $TotPos?></li>
		<li<?php if($absPos<$TotPos){ ?> class="activo" onClick="document.location='?accion=editar&amp;pos=<?php echo $absPos+1 ?>'"<?php }else{?> class="inactivo"<?php } ?>></li>
	</ul>
<?php } ?>
</div>


<table id="tabla2">
	<?php for($i=1;$i<=$NCampos;$i++){?>
		<tr>
		  	<td>
				<h3><?php echo $Campos[$i][0]?></h3>
				  <?php if(strtoupper($Campos[$i][$Tipo])!="SELECT" && strtoupper($Campos[$i][$Tipo])!="TEXTAREA" && strtoupper($Campos[$i][$Tipo])!="UPLOAD"){ ?>
						<?php if(strtoupper($Campos[$i][$Tipo])=="FECHA" || strtoupper($Campos[$i][$Tipo])=="FECHAHORA" || strtoupper($Campos[$i][$Tipo])=="HORA"){
							switch (strtoupper($Campos[$i][$Valida])){
							case "FECHA":
								$tipocal="cal";
								break;
							case "FECHAHORA":
								$tipocal="com";
								break;
							case "HORA":
								$tipocal="hor";
								break;
							} ?>
							<input type="<?php echo $Campos[$i][$Tipo]?>" name="c<?php echo $i?>" value="<?php if(!$Nuevo) if(isset($row[$Campos[$i][$Nombre]])) echo MFec($row[$Campos[$i][$Nombre]]) . "" ?>" size="<?php echo $Campos[$i][$Largo]?>" <?php echo $Campos[$i][$Extras]?>>
							<a href="javascript:calendario('formulario.c<?php echo $i?>','<?php echo $tipocal?>');"><img src = "imagesADM/calendario.gif" width="24" height="18" border="0"></a> 
						<?php }else{?>
							<input type="<?php echo $Campos[$i][$Tipo]?>" name="c<?php echo $i?>"<?php if(substr($Campos[$i][$Extras],0,5)!="value"){ ?> value="<?php if(!$Nuevo) if(isset($row[$Campos[$i][$Nombre]])) echo Caracteres1($row[$Campos[$i][$Nombre]],2) . ""?>"<?php } ?> <?php echo $Campos[$i][$Extras]?> size="<?php echo $Campos[$i][$Largo]?>">
					<?php }?>
				  <?php }else if(strtoupper($Campos[$i][$Tipo])=="SELECT"){?>
						<select name="c<?php echo $i?>" <?php echo $Campos[$i][$Extras]?> style="max-width:500px">
						<?php if(strtoupper($Campos[$i][$Largo])=="LISTA"){
								$Lista=explode("|",$Campos[$i][$Valida]);
								for($j=0;$j < count($Lista);$j++){
									?><option value="<?php echo $Lista[$j]?>" <?php
									if(!$Nuevo){
										if(strtoupper($Campos[$i][$TipoDato])=="NUMERO"){ 
											if((int)($Lista[$j])==(int)($row[$Campos[$i][$Nombre]])) echo "Selected";
										}else{
											if($row[$Campos[$i][$Nombre]]!= NULL){
												if(trim($Lista[$j])==trim($row[$Campos[$i][$Nombre]])) echo "Selected";
											}
										}
									}?>><?php echo $Lista[$j+1]?></option>
								<?php	$j++;
								}
							}else if(strtoupper($Campos[$i][$Largo])=="SQL"){
								$r1 = $db->select($Campos[$i][$Valida]);
								while ($row1=$db->get_row($r1, 'MYSQL_ASSOC')) { 
									?><option value="<?php echo $row1[$Campos[$i][$Nombre]]?>" <?php if(!$Nuevo){
											if($row1[$Campos[$i][$Nombre]]!= NULL && $row[$Campos[$i][$Nombre]]!= NULL){
												if((int)($row1[$Campos[$i][$Nombre]])==(int)($row[$Campos[$i][$Nombre]])) echo "Selected";
											}
										  }?>><?php echo $row1["tit"]?></option><?php
								}
							}?>
					</select>
					<?php }else if(strtoupper($Campos[$i][$Tipo])=="TEXTAREA"){
					$vts=explode(",",$Campos[$i][$Largo]);?>		
						<textarea name="c<?php echo $i?>" cols="<?php echo $vts[0]?>" rows="<?php  echo $vts[1] ?>"><?php if(!$Nuevo) if(isset($row[$Campos[$i][$Nombre]])) echo Caracteres1($row[$Campos[$i][$Nombre]],2) ?></textarea>
					<?php }else if(strtoupper($Campos[$i][$Tipo])=="UPLOAD"){?>
						<input type="texo" name="c<?php echo $i?>" readonly <?php echo $Campos[$i][$Extras]?> value="<?php if(!$Nuevo) if(isset($row[$Campos[$i][$Nombre]])) echo $row[$Campos[$i][$Nombre]]?>" >
						<input class="botones"  name="abrir" type="button" onClick="opw('<?php echo $Campos[$i][$Largo]?>','c<?php echo $i?>','<?php echo $Campos[$i][$Extras]?>')" value="Abrir">
				<?php if(!$Nuevo) if(strpos(strtoupper($row[$Campos[$i][$Nombre]]),".JPG")>0 or strpos(strtoupper($row[$Campos[$i][$Nombre]]),".GIF")>0 or strpos(strtoupper($row[$Campos[$i][$Nombre]]),".PNG")>0){ ?>
				<br><a href="<?php echo $Campos[$i][$Largo] . "/" . $row[$Campos[$i][$Nombre]] ?>" target="_blank"><img id="c<?php echo $i?>i" src="<?php echo $Campos[$i][$Largo] . "/" . $row[$Campos[$i][$Nombre]] ?>" style="max-height:100px;"></a>
				<?php }?>
					<?php }?>
					<?php if(strtoupper($Campos[$i][$Tipo])=="TEXT"){?>
                  <a href="javascript:buscar('<?php echo $Campos[$i][$Nombre]?>','<?php echo strtoupper($Campos[$i][$Tipo])?>',document.formulario.c<?php echo $i?>.value,'<?php echo $Campos[$i][$Titulo]?>')"></a>
                	<?php if(strtoupper($Campos[$i][$Tipo])=="TEXTAREA"){?>
						<img  onclick="vis(document.all.inp<?php echo $i?>,document.all.btn<?php echo $i?>)" border="0" SRC="imagesADM/lupa.gif" width="17" height="19" style="cursor: hand"> 
						<input type="text" id="inp<?php echo $i?>" name="inp<?php echo $i?>" style="visibility: hidden">
						<img src = "imagesADM/flebsc.gif" id="btn<?php echo $i?>" name="btn<?php echo $i?>" onClick="enc(document.all.inp<?php echo $i?>.value,R<?php echo $i?>,b<?php echo $i?>)" style="visibility: hidden;cursor: hand" border="0" width="20" height="20"> 
					<?php }?>
				<?php }?>
			 <?php if(isset($Campos[$i][$SubTitulo])){ ?>
			 	<div class="rojo"><?php echo strtoupper($Campos[$i][$SubTitulo]) ?></div>
			<?php }?>
			   </td>
		  </tr>
									
			<?php }?>
    </table>
	<div id="encadenados">
		<?php 
		if(isset($ManEncadenado)){
			if($Accion!="agregar"){
				echo $ManEncadenado;
				$_SESSION[$Campos[0][$Nombre]]=$id;
				$mManEncadenado3=explode(",",$ManEncadenado3);
				foreach ($mManEncadenado3 as $l => $value) {
					$_SESSION["Ordenar" . $mManEncadenado3[$l]]="";
					$_SESSION["SQL" . $mManEncadenado3[$l]]="";
				}
			}else{
				echo $ManEncadenado2;
			}
		} ?>
	</div>
<div class="navegacion" style="margin-top:20px;">
	<a href="?" title="Ver lista" class="i_botones i_lista"></a>
<?php if($Accion!="agregar") if(!isset($noincluir)){?><a href="?accion=agregar"  class="i_botones i_agregar" title="Agregar nuevo registro"></a><?php } ?>
	<a href="JavaScript:Enviar();" title="Guardar" class="i_botones i_aceptar"></a>
<?php if($Accion!="agregar")  if(!isset($noincluir)){?><a href="javascript:eliminar(<?php echo $id ?>)"  class="i_botones i_eliminar" title="Eliminar"></a><?php }

if($Accion=="editar"){ ?>
	<ul>
		<li<?php if($absPos>1){ ?> class="activo" onClick="document.location='?accion=editar&amp;pos=<?php echo $absPos-1 ?>'"<?php }else{?> class="inactivo"<?php } ?>></li>
		<li title="Código:<?php echo $row[$Campos[0][$Nombre]]?>">Reg: <?php echo $absPos . " de: " . $TotPos?></li>
		<li<?php if($absPos<$TotPos){ ?> class="activo" onClick="document.location='?accion=editar&amp;pos=<?php echo $absPos+1 ?>'"<?php }else{?> class="inactivo"<?php } ?>></li>
	</ul>
<?php } ?>
</div>

    <input type="hidden" name="accion"><input type="hidden" name="Nuevo"><input name="id" type="hidden" id="id">
</form>
<script language="JavaScript" src="calendario.js"></script>
<script src="JavaTools.js"></script>

<script LANGUAGE="javascript">
function eliminar(x){
	if (confirm("Esta seguro de Eliminar este registro"))
		{
			document.formulario.accion.value = "eliminar";
			document.formulario.id.value = x;
			document.formulario.submit();
		}
}

function opw(diru,cam,extra){
	durl='upload/upload.php?diru=' + diru + '&cam=' + cam + '&cam=' + cam + '&extra=' + extra;
	opn=window.open(durl,null,'height=200,width=470,status=no,toolbar=no,menubar=no,location=no','true');
	opn.focus();
}
function act_foto(cual){
	x=MM_findObj(cual);
	if(x) x.style.display="none";
}

function buscar(x,t,v,tit){
	window.name ="registro";
	popup=window.open('buscar.php?value='+v+'&nombrepagina=<?php echo $NombrePagina?>&campo='+x+'&tipo='+t+'&tit=' + tit,null,'height=150,width=280,status=no,toolbar=no,menubar=no,location=no','true');
	popup.focus();
}

function ordenar(x){
	document.location='?accion=ordenar&campo='+x;
}

<?php for($i=1;$i<=$NCampos;$i++){
	if(strtoupper($Campos[$i][$Tipo])=="TEXTAREA"){?>
		R<?php echo $i?> = document.all.c<?php echo $i?>.createTextRange();
   		b<?php echo $i?>=R<?php echo $i?>.getBookmark();
	<?php }
}?>

function Enviar(){
	var msg='';
<?php for($i=1;$i<=$NCampos;$i++){
	switch (strtoupper($Campos[$i][$Valida])){
		case "NUMERO": ?>
			if (ChkNumero(document.formulario.c<?php echo $i?>.value)) msg=msg+'<?php echo $Campos[$i][$Titulo] ?>.'+ String.fromCharCode(13);
			<?php break;
		case "FECHA": ?>
			if (!ChkFecha(document.formulario.c<?php echo $i?>.value)) msg=msg+'<?php echo $Campos[$i][$Titulo] ?>.'+ String.fromCharCode(13);
			<?php break;
		case "BLANCO": ?>
			if (ChkBlanco(document.formulario.c<?php echo $i?>.value)) msg=msg+'<?php echo $Campos[$i][$Titulo] ?>.'+ String.fromCharCode(13);
			<?php break;
		case "EMAIL": ?>
			if (ChkEmail(document.formulario.c<?php echo $i?>.value)) msg=msg+'<?php echo $Campos[$i][$Titulo] ?>.'+ String.fromCharCode(13);
	<?php }
	if(strtoupper($Campos[$i][$Tipo])=="TEXTAREA"){?>
		if (document.formulario.c<?php echo $i?>.value.length>90000) msg=msg+'<?php echo $Campos[$i][$Titulo] ?>: es demasiado grande debe dividirlo en partes más o menos iguales de no mas de 90.000 caracteres c/u.';
	<?php }
 }?>		
	if (msg=='') {
		document.formulario.accion.value='guardar';
	<?php if($Nuevo){?>
		document.formulario.Nuevo.value=true;
	<?php }else{ ?>
		document.formulario.id.value = <?php echo $id?>;
		document.formulario.Nuevo.value=false;
	<?php } ?>
		document.formulario.submit();
	}else{
		alert('Debe chequear los siguientes campos:' + String.fromCharCode(13) + msg )
	}
}


function vis(x,y){
	 if (x.style.visibility!="visible") {x.value="";x.style.visibility="visible";x.focus()} else {x.style.visibility="hidden"}
	 if (y.style.visibility=="visible") {y.style.visibility="hidden"} else {y.style.visibility="visible"}
}

function enc(tx,oRange,b){
   if (tx=='')
   	alert('debe introducir el texto a buscar');
   else{
   a = oRange.findText(tx);               // true. case insensitive and partial word match.
   if (a) {oRange.select();oRange.moveStart('word',1);oRange.scrollIntoView(true)} else {alert('No se encontraron más coincidencias.');oRange.moveToBookmark(b)}
   }	
}
function pars(obj){
	if (obj.value.indexOf(String.fromCharCode(13))>0) {
		obj.value=obj.value.replace(/\r\n/gi,"<br>");
		}
	else{
		obj.value=obj.value.replace(/<br>/gi,String.fromCharCode(13));
	}

}
</script>
<?php 


	break;
case ($Accion=="guardar"):
	$u="";
	$data = array();
	for($i=1;$i<=$NCampos;$i++){
		if(strtoupper($Campos[$i][$Tipo])=="FECHA")
			$data[$Campos[$i][$Nombre]]=Mfec2(rq2("c" . $i));
		else
			$data[$Campos[$i][$Nombre]]=rq2("c" . $i);
	}

	if(rqq("Nuevo")=="true"){
		$id = $db->insert_array($NombreTabla, $data);
		if (!$id){
			$db->print_last_query();
			echo $db->last_error;
			exit;
		}

		
	}else{
		$rows = $db->update_array($NombreTabla, $data, $Campos[0][$Nombre] . "=" . $id);
		if (!$rows) $db->print_last_error(false);
	}
	//$db->print_last_query();
	?>
	<form name="formulario" method="post" action="?">
		<input type="hidden" value="<?php echo $id ?>" name="id"><input type="hidden" value="editar" name="accion">
	</form>
	<div id="alerta">Su información se ha guardado exitosamente<p><a href="javascript:document.formulario.submit();">Aceptar</a></p></div>
	<script language="javascript">
		setTimeout(function(){document.formulario.submit()},3000);
	</script><?php
	break;
case ($Accion=="eliminar"):
	$ssql="delete from " . $NombreTabla . " where " . $Campos[0][$Nombre] . "=" . $id ;
	$r = $db->ejecutar_sql($ssql);
	
	?>
	<div id="alerta">El registro fue eliminado exitosamente<p><a href="?pos=<?php echo $pos?>">Aceptar</a></p></div>
	<script language="javascript">
		setTimeout(function(){document.location="?pos=<?php echo $pos?>";},5000);
	</script><?php
	break;
case ($Accion=="buscar"):
	$campo=rqq("campo");
	$text1=rqq("text1");
	$Buscador=explode(" ",$text1);
	$Str="";
	
	if(strtoupper(rqq("tipo"))=="SELECT"){
		for($i=1;$i<=$NCampos;$i++) if($Campos[$i][$Nombre]==$campo){
			if(strtoupper($Campos[$i][$TipoDato])=="NUMERO"){
				$Str=$campo . " = " . $text1;
			}else{
				$Str="upper(" . $campo . ") = '" . strtoupper($text1) . "'";
			}
		}
	}else{
		$u="";
		for($i=0;$i < count($Buscador);$i++){
			$Str=$Str . "upper(" . $campo . ") like '%" . strtoupper($Buscador[$i]) . "%'" . $u;
			$u=" and ";
		}
	}
	$_SESSION["Where" . $NombrePagina]=$Str;
	?><script language="javascript">
		document.location="?";
	</script><?php
	break;
case ($Accion=="elifil"):
	$_SESSION["Where" . $NombrePagina]='';
	?><script language="javascript">
		document.location="?";
	</script><?php
	break;
}

function Recortar($Cadena,$Caracteres){
	if($Caracteres >0 )
		return substr($Cadena,0, $Caracteres);
}

function Mfec($Fecha){
	return date("d", strtotime("$Fecha")) . "/" . date("m", strtotime("$Fecha")) . "/" . date("y", strtotime("$Fecha"));
}

function Mfec2($Fecha){
	$ffa=explode("/",$Fecha);
	return $ffa[2] . "-" . $ffa[1] . "-" . $ffa[0];
}

function Caracteres1($Texto,$Tipo){
	$cambios1 = array("'","--","__",chr(10),'"');
	$cambios2  = array("","","","<br>","&quot;");
	if($Tipo==1)
		$temp = str_replace($cambios1, $cambios2, $Texto);
	else
		$temp = str_replace($cambios2, $cambios1, $Texto);
	return $temp;
}
include "abajoADM.php" ?>
