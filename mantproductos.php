<?php  
@session_start();
$whe = "idcategoria = " . $_SESSION["idcategoria"];

$Titulo=0;
$Tipo=1;
$Extras=3;
$Largo=2;
$Valida=4;
$Nombre=5;
$TipoDato=6; //TEXTO, NUMERO, FECHA
$SubTitulo=7;

$CamposLista=1;
$NCampos=9;

$Campos = array();

$Campos[0][$Nombre]="idproducto";
$a=1;

$Campos[$a][$Titulo]="Título español";
$Campos[$a][$Tipo]="text";
$Campos[$a][$Largo]="80";
$Campos[$a][$Nombre]="titulo_es";
$Campos[$a][$Valida]="blanco";
$Campos[$a][$Extras]=" maxlength='100'";
$Campos[$a][$TipoDato]="TEXTO";
$Campos[$a][$SubTitulo]="MÁXIMO 100 CARACTERES (REQUERIDO)";
$a++;

$Campos[$a][$Titulo]="Título inglés";
$Campos[$a][$Tipo]="text";
$Campos[$a][$Largo]="80";
$Campos[$a][$Nombre]="titulo_en";
$Campos[$a][$Valida]="blanco";
$Campos[$a][$Extras]=" maxlength='100'";
$Campos[$a][$TipoDato]="TEXTO";
$Campos[$a][$SubTitulo]="MÁXIMO 100 CARACTERES (REQUERIDO)";
$a++;

$Campos[$a][$Titulo]="Foto principal";
$Campos[$a][$Tipo]="upload";
$Campos[$a][$Largo]="fotos/productos";
$Campos[$a][$Nombre]="foto";
$Campos[$a][$Valida]="";
$Campos[$a][$Extras]="|420|0|tn|260|0";
$Campos[$a][$TipoDato]="TEXTO";
$Campos[$a][$SubTitulo]="420 px de ancho alto libre";
$a++;

for($l=1; $l<=5; $l++){
	$Campos[$a][$Titulo]="Foto adicional " . $l;
	$Campos[$a][$Tipo]="upload";
	$Campos[$a][$Largo]="fotos/productos";
	$Campos[$a][$Nombre]="foto" . $l;
	$Campos[$a][$Valida]="";
	$Campos[$a][$Extras]="|420|0";
	$Campos[$a][$TipoDato]="TEXTO";
	$Campos[$a][$SubTitulo]="420 px de ancho alto libre";
	$a++;
}

$Campos[$a][$Titulo]="";
$Campos[$a][$Tipo]="hidden";
$Campos[$a][$Largo]="10";
$Campos[$a][$Nombre]="idcategoria";
$Campos[$a][$Valida]="";
$Campos[$a][$Extras]="value='" . $_SESSION["idcategoria"] . "'";
$a++;

$Titulo1="";
$Titulo2="Productos";
$NombrePagina="mantproductos.php";
$NombreTabla="productos";

$ManEncadenado="<a href='mantcategorias.php?accion=editar&id=" . $_SESSION["idcategoria"] . "' class='botones'>Regresar a la administración de Categorías</a>";
$ManEncadenado2="<a href='mantcategorias.php?accion=editar&id=" . $_SESSION["idcategoria"] . "' class='botones'>Regresar a la administración de Categorías</a> recuerde publicar primero su producto";
$ManEncadenado3="";
$ManEncadenado4="<br/><br/><a href='mantcategorias.php?accion=editar&id=" . $_SESSION["idcategoria"] . "' class='botones'>Regresar a la administración de Categorías</a>";
include "mantinc.php" ?>
