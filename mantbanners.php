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
$NCampos=3;

$Campos = array();

$Campos[0][$Nombre]="idbanner";
$a=1;

$Campos[$a][$Titulo]="Título";
$Campos[$a][$Tipo]="text";
$Campos[$a][$Largo]="80";
$Campos[$a][$Nombre]="titulo";
$Campos[$a][$Valida]="blanco";
$Campos[$a][$Extras]=" maxlength='100'";
$Campos[$a][$TipoDato]="TEXTO";
$Campos[$a][$SubTitulo]="MÁXIMO 100 CARACTERES (REQUERIDO)";
$a++;

$Campos[$a][$Titulo]="Foto";
$Campos[$a][$Tipo]="upload";
$Campos[$a][$Largo]="fotos/banners";
$Campos[$a][$Nombre]="foto";
$Campos[$a][$Valida]="";
$Campos[$a][$Extras]="|832|526";
$Campos[$a][$TipoDato]="TEXTO";
$Campos[$a][$SubTitulo]="832 px de ancho por 526 px de alto";
$a++;

$Campos[$a][$Titulo]="Enlace";
$Campos[$a][$Tipo]="text";
$Campos[$a][$Largo]="80";
$Campos[$a][$Nombre]="enlace";
$Campos[$a][$Valida]="";
$Campos[$a][$Extras]=" maxlength='200'";
$Campos[$a][$TipoDato]="TEXTO";
$Campos[$a][$SubTitulo]="MÁXIMO 200 CARACTERES (colocar la dirección completa incluyendo http://)";
$a++;


$Titulo1="";
$Titulo2="Banners";
$NombrePagina="mantbanners.php";
$NombreTabla="banners";

?>
<?php  include "mantinc.php" ?>
