<?php 
$Titulo=0;
$Tipo=1;
$Extras=3;
$Largo=2;
$Valida=4;
$Nombre=5;
$TipoDato=6; //TEXTO, NUMERO, FECHA
$SubTitulo=7;

$CamposLista=1;
$NCampos=19;

$Campos = array();

$Campos[0][$Nombre]="idcategoria";
$a=1;

$Campos[$a][$Titulo]="Categoría español";
$Campos[$a][$Tipo]="text";
$Campos[$a][$Largo]="80";
$Campos[$a][$Nombre]="categoria_es";
$Campos[$a][$Valida]="blanco";
$Campos[$a][$Extras]=" maxlength='50'";
$Campos[$a][$TipoDato]="TEXTO";
$Campos[$a][$SubTitulo]="MÁXIMO 50 CARACTERES (REQUERIDO)";
$a++;

$Campos[$a][$Titulo]="Categoría inglés";
$Campos[$a][$Tipo]="text";
$Campos[$a][$Largo]="80";
$Campos[$a][$Nombre]="categoria_en";
$Campos[$a][$Valida]="blanco";
$Campos[$a][$Extras]=" maxlength='50'";
$Campos[$a][$TipoDato]="TEXTO";
$Campos[$a][$SubTitulo]="MÁXIMO 50 CARACTERES (REQUERIDO)";
$a++;

$Campos[$a][$Titulo]="Destacada";
$Campos[$a][$Tipo]="select";
$Campos[$a][$Largo]="lista";
$Campos[$a][$Nombre]="destacado";
$Campos[$a][$Valida]="N|No|S|Si";
$Campos[$a][$Extras]="";
$Campos[$a][$TipoDato]="TEXTO";
$a++;

$Campos[$a][$Titulo]="Foto";
$Campos[$a][$Tipo]="upload";
$Campos[$a][$Largo]="fotos/categorias";
$Campos[$a][$Nombre]="foto";
$Campos[$a][$Valida]="";
$Campos[$a][$Extras]="|640|424";
$Campos[$a][$TipoDato]="TEXTO";
$Campos[$a][$SubTitulo]="640 px de ancho por 424 px de alto";
$a++;

for($l=1; $l<=3; $l++){
	$Campos[$a][$Titulo]="Material español " . $l;
	$Campos[$a][$Tipo]="text";
	$Campos[$a][$Largo]="80";
	$Campos[$a][$Nombre]="material" . $l . "_es";
	$Campos[$a][$Valida]="";
	$Campos[$a][$Extras]=" maxlength='20'";
	$Campos[$a][$TipoDato]="TEXTO";
	$Campos[$a][$SubTitulo]="MÁXIMO 20 CARACTERES";
	$a++;

	$Campos[$a][$Titulo]="Material inglés " . $l;
	$Campos[$a][$Tipo]="text";
	$Campos[$a][$Largo]="80";
	$Campos[$a][$Nombre]="material" . $l . "_en";
	$Campos[$a][$Valida]="";
	$Campos[$a][$Extras]=" maxlength='20'";
	$Campos[$a][$TipoDato]="TEXTO";
	$Campos[$a][$SubTitulo]="MÁXIMO 20 CARACTERES";
	$a++;
}

for($l=1; $l<=3; $l++){
	$Campos[$a][$Titulo]="Tamaño español " . $l;
	$Campos[$a][$Tipo]="text";
	$Campos[$a][$Largo]="80";
	$Campos[$a][$Nombre]="tamano" . $l . "_es";
	$Campos[$a][$Valida]="";
	$Campos[$a][$Extras]=" maxlength='20'";
	$Campos[$a][$TipoDato]="TEXTO";
	$Campos[$a][$SubTitulo]="MÁXIMO 20 CARACTERES";
	$a++;

	$Campos[$a][$Titulo]="Tamaño inglés " . $l;
	$Campos[$a][$Tipo]="text";
	$Campos[$a][$Largo]="80";
	$Campos[$a][$Nombre]="tamano" . $l . "_en";
	$Campos[$a][$Valida]="";
	$Campos[$a][$Extras]=" maxlength='20'";
	$Campos[$a][$TipoDato]="TEXTO";
	$Campos[$a][$SubTitulo]="MÁXIMO 20 CARACTERES";
	$a++;
}

for($l=1; $l<=3; $l++){
	$Campos[$a][$Titulo]="Cantidad " . $l;
	$Campos[$a][$Tipo]="text";
	$Campos[$a][$Largo]="80";
	$Campos[$a][$Nombre]="cantidad" . $l;
	$Campos[$a][$Valida]="";
	$Campos[$a][$Extras]=" maxlength='3'";
	$Campos[$a][$TipoDato]="TEXTO";
	$Campos[$a][$SubTitulo]="MÁXIMO 3 CARACTERES";
	$a++;
}

$Titulo1="";
$Titulo2="Categorías";
$NombrePagina="mantcategorias.php";
$NombreTabla="categorias";

$ManEncadenado="<p><a href='mantproductos.php' class='botones'>Administrar productos</a></p>";
$ManEncadenado2="Debe publicar lacategoría para administrar sus productos";
$ManEncadenado3="mantproductos.php";

?>
<?php  include "mantinc.php" ?>
