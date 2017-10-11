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
$NCampos=4;

$Campos = array();

$Campos[0][$Nombre]="id_admin";
$a=1;

$Campos[$a][$Titulo]="Nombre";
$Campos[$a][$Tipo]="text";
$Campos[$a][$Largo]="50";
$Campos[$a][$Nombre]="nombre";
$Campos[$a][$Valida]="blanco";
$Campos[$a][$Extras]=" maxlength='50'";
$Campos[$a][$TipoDato]="TEXTO";
$Campos[$a][$SubTitulo]="MÁXIMO 50 CARACTERES (REQUERIDO)";
$a++;

$Campos[$a][$Titulo]="Contraseña";
$Campos[$a][$Tipo]="text";
$Campos[$a][$Largo]="50";
$Campos[$a][$Nombre]="clave";
$Campos[$a][$Valida]="blanco";
$Campos[$a][$Extras]=" maxlength='50'";
$Campos[$a][$TipoDato]="TEXTO";
$Campos[$a][$SubTitulo]="MÁXIMO 50 CARACTERES (REQUERIDO)";
$a++;

$Campos[$a][$Titulo]="Mantiene Usuarios";
$Campos[$a][$Tipo]="select";
$Campos[$a][$Largo]="lista";
$Campos[$a][$Nombre]="mantadmin";
$Campos[$a][$Valida]="N|No|S|Si";
$Campos[$a][$Extras]="";
$Campos[$a][$TipoDato]="TEXTO";
$a++;

$Campos[$a][$Titulo]="Mantiene Contenidos";
$Campos[$a][$Tipo]="select";
$Campos[$a][$Largo]="lista";
$Campos[$a][$Nombre]="mantcontenidos";
$Campos[$a][$Valida]="N|No|S|Si";
$Campos[$a][$Extras]="";
$Campos[$a][$TipoDato]="TEXTO";
$a++;


$Titulo1="Administración de Serrao Guerra";
$Titulo2="Administradores";
$NombrePagina="mantadmin.php";
$NombreTabla="admin";
$Whe="";
?>
<?php include "mantinc.php" ?>
