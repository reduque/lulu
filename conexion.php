<?php
@session_start();
header('Content-Type: text/html; charset=utf-8');
require_once('db.class.php');
$db = new db_class;
if($_SERVER['HTTP_HOST']=="localhost"){
	if (!$db->connect('localhost', 'root', 'admin', 'lulu', true)) $db->print_last_error(false);
	$carpeta="http://localhost/lulu/";
}else{
	if (!$db->connect('localhost', 'lulu_usrvb', 'UE[oPsElp)UJ', 'lulu_website', true)) $db->print_last_error(false);
	$carpeta="http://lulucreativeloft.com/";
}

$idioma="";
if (!array_key_exists('idioma', $_SESSION)) {
	$idioma = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	if($idioma<>"es" and $idioma<>"en") $idioma="es";
}else{	
	if(isset($_REQUEST["i"])) $idioma = trim($_REQUEST["i"]);
}
if($idioma<>""){
	$_SESSION["idioma"]=$idioma;
}
$idioma=$_SESSION["idioma"];
//$idioma="es";

$headers = "MIME-Version: 1.0\n"; 
$headers .= "Content-type: text/html; charset=utf-8\n"; 
$headers .= "X-Priority: 3\n"; 
$headers .= "X-MSmail-Priority: Normal\n"; 
$headers .= "X-mailer: php\n"; 
$headers .= "From: lulucreativeloft@gmail.com\n"; 

function rqq($objeto){
	$temp='';
	if(isset($_REQUEST[$objeto])) $temp = trim($_REQUEST[$objeto]);
	
	$select = "select";
	$insert = "insert";
	$update = "update";
	$delete = "delete";
	$having = "having";
	$alter = "alter table";
	$drop = "drop table";
	$dropdatabase = "drop database";
	$dropindex = "drop index";
	$dropuser = "drop user";
	$create = "create";
	$sarepoints = "sarepoints";
	$raiserror = "raiserror";

	$virus = array("'","--","__","=","<",">");
	$cambios  = array("","","","","","");
	$temp = str_replace($virus, $cambios, $temp);
	return $temp;
}
function rq2($objeto){
	$temp='';
	if(isset($_REQUEST[$objeto])) $temp = trim($_REQUEST[$objeto]);
	$virus = array("'","--","__","script");
	$cambios  = array("´","","","");
	$temp = str_replace($virus, $cambios, $temp);
	return $temp;
}
function volteafecha($cualfecha){
	$mfecha=explode("-", $cualfecha);
	return $mfecha[2] . "/" . $mfecha[1] . "/" . $mfecha[0];
}

$meses = array("","Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre");

$mrcd=array(
	 0 =>'A',
	 1 =>'B',
	 2 =>'C',
	 3 =>'D',
	 4 =>'E',
	 5 =>'F',
	 6 =>'G',
	 7 =>'H',
	 8 =>'I',
	 9 =>'J',
	10 =>'K',
	11 =>'L',
	12 =>'M',
	13 =>'N',
	14 =>'O',
	15 =>'P',
	16 =>'Q',
	17 =>'R',
	18 =>'S',
	19 =>'T',
	20 =>'U',
	21 =>'V',
	22 =>'W',
	23 =>'X',
	24 =>'Y',
	25 =>'Z',
	26 =>'1',
	27 =>'2',
	28 =>'3',
	29 =>'4',
	30 =>'5',
	31 =>'6',
	32 =>'7',
	33 =>'8',
	34 =>'9',
	35 =>'0',
	36 =>'a',
	37 =>'b',
	38 =>'c',
	39 =>'d',
	40 =>'e',
	41 =>'f',
	42 =>'g',
	43 =>'h',
	44 =>'i',
	45 =>'j',
	46 =>'k',
	47 =>'l',
	48 =>'m',
	49 =>'n',
	50 =>'o',
	51 =>'p',
	52 =>'q',
	53 =>'r',
	54 =>'s',
	55 =>'t',
	56 =>'u',
	57 =>'v',
	58 =>'w',
	59 =>'x',
	60 =>'y',
	61 =>'z'
);
function codifica($valor){
	global $mrcd;
	$separador=rand(0,6);
	$salida="";
    while($valor>55){
		@$division    = $valor/55;
		@$resultINT   = floor($valor/55);
		@$remnant     = $valor%55;
		$salida  = $mrcd[$remnant+$separador].
		$mrcd[61-($remnant+$separador)].$salida;
		$valor=$resultINT;
	}
	$salida  = $mrcd[$separador*5] . $mrcd[$valor+$separador]. $mrcd[61-($valor+$separador)].$salida;
	return $salida;
}
function decodifica($valor){
	global $mrcd;
	$separador=0;
	$mvalor=str_split($valor);
	$resultado1=0;
	$resultado2=0;
	for($i=0;$i<=61;$i++)
		if($mvalor[0]==$mrcd[$i])
			$separador=$i/5;
			
	$contexp=((count($mvalor)-1)/2)-1;
	for($l=1;$l<count($mvalor);$l+=2){
		for($i=0;$i<=61;$i++){
			if($mvalor[$l]==$mrcd[$i]){
				$resultado1+=($i-$separador)*pow(55,$contexp);
			}
			if($mvalor[$l+1]==$mrcd[$i]){
				$resultado2+=(61-($i+$separador))*pow(55,$contexp);
			}
		}
		$contexp--;
	}
	if($resultado1==$resultado2 and is_int($separador)){
		return $resultado1;
	}else{
		return "";
	}
}
function urls_amigables($url) {
	$url=mb_strtolower($url, 'UTF-8');
	//Rememplazamos caracteres especiales latinos
	$find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
	$repl = array('a', 'e', 'i', 'o', 'u', 'n');
	$url = str_replace ($find, $repl, $url);
	// Añaadimos los guiones
	$find = array(' ', '&', '\r\n', '\n', '+'); 
	$url = str_replace ($find, '-', $url);
	// Eliminamos y Reemplazamos demás caracteres especiales
	$find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
	$repl = array('', '-', '');
	$url = preg_replace ($find, $repl, $url);
	return $url;
}

?>