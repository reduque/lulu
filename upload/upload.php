<?php
$directorioUpload="../" . $_REQUEST["diru"];
$campo=$_REQUEST["cam"];

//Set upload limit to 10MB
$UploadSizeLimit = 10000000;


if (!empty($_FILES['file1']['name'])) {
	$fileName = (string)(date("YmdHis")) . (string)(rand(1,9)) . substr($_FILES['file1']['name'],-4);
	$fileName = str_replace(array(" ","/","$","&","#","-","_"), array("","","","","","",""), $fileName);
	@mkdir ($directorioUpload,0755);
	
	$ok = (@is_uploaded_file($_FILES['file1']['tmp_name']) && @move_uploaded_file($_FILES['file1']['tmp_name'], $directorioUpload . "/" . $fileName));
	if($ok){
		if(isset($_REQUEST["extra"])) if($_REQUEST["extra"]<>""){
			$extra=explode("|",$_REQUEST["extra"]);
			$cantidad=count($extra)/3;
			for($l=0;$l<$cantidad;$l++){
				$destino="";
				if($extra[$l*3]<>""){
					$destino=$extra[$l*3] . "/";
					@mkdir ($directorioUpload . "/" . $destino,0755);
				}
				if($extra[($l*3)+1]<>0 and $extra[($l*3)+2]<>0){
					resizeImg($directorioUpload . "/" . $fileName, $directorioUpload . "/" . $destino . $fileName, $extra[($l*3)+1], $extra[($l*3)+2]);
				}else{
					stretchImg($directorioUpload . "/" . $fileName, $directorioUpload . "/" . $destino . $fileName, $extra[($l*3)+1], $extra[($l*3)+2]);
				}
			}
		}
	}
	?>
<title>Carga de archivos</title>
<style type="text/css">
	.botones{background-color:#0094D2; cursor:pointer; padding:2px 6px; display:inline-block; color:#FFF; border:none; transition:background-color 0.6s; text-decoration:none;}
	.botones:hover{background-color:#005082;}
</style>
<body>
<br>
<table border="0">
  <tr> 
    <td> 
      <p> <span class="titnoti"> 
        Envio de Archivos</span><br>
        <br>
        <span class="texto1">
		El 
        Archivo <?php echo $fileName;?>
        <?php
		
		if (!$ok) {
			?>
        	NO fue Guardado, se produjo un error.
        <?php 
	} else {
			chmod ($directorioUpload . "/" . $fileName, 0644); ?> 
        	fue Guardado
        <?php
	}?> 

        </span><br>
      </p>
      <p><a href="javascript:window.close()" class="botones">Cerrar</a>
  </tr>
  <tr> 
    <td><input type="hidden" name="campo" value="<?php echo $campo;?>">
</td>
  </tr>
  <tr>
    <td><br>

    </td>
  </tr>
</table>
<script language='JavaScript'>
	window.opener.document.formulario.<?php echo $campo;?>.value = '<?php echo $fileName?>';
	setTimeout(function(){window.close()},3000);
</script>
<br>

<?php
} else {
?>
<title>Carga de archivos</title>
<style type="text/css">
	.botones{background-color:#0094D2; cursor:pointer; padding:2px 6px; display:inline-block; color:#FFF; border:none; transition:background-color 0.6s;}
	.botones:hover{background-color:#005082;}
</style>
<body>
<br>
<table border="0">
  <tr>
    <td height="118">  <span class="titnoti"> 
      Envio de Archivos</span><br>
      <br>
      <table width=100%>
        <form  name="form1" method=post enctype="multipart/form-data" onSubmit="ver()">
          <tr> 
            <td class="texto2color">
              <div align="right" class="texto1">Archivo </div>
            </td>
            <td> 
              <p><input name="file1" type="file" class="botones"></p>
		
              <input name="submit" type="submit" class="botones" value="Enviar">
              <input name="submit2" type="button" class="botones" value="Ninguno" onClick="window.opener.document.formulario.<?php echo $campo;?>.value='';window.opener.act_foto('<?php echo $campo;?>i');window.close();">
            </td>
          </tr>
        </form>
      </table>
      <div align="center"><span class="texto1negritas"><br>
        </span><span class="texto1">El l&iacute;mite en el tama&ntilde;o del archivo es de 1Mb</span><br>
    </div>    </td>
  </tr>
</table>
<script type="text/javascript">
	function ver(){
		if (document.form1.file1.value.length==0) {alert("Debe seleccionar un archivo");event.returnValue=false;}
	}
</script>
<?php
}

function stretchImg($s_img, $d_img, $nuevo_ancho, $nuevo_alto, $new_root=false) 
{ 
	// Guarda los posibles tipos de imagenes en un array ($img_types) 
	static $img_types = array( 
		1 => 'Gif', 
		2 => 'Jpeg', 
		3 => 'Png',
		4 => 'jpg'
	); 
	  
	if (file_exists($s_img)) 
	{ 
		// Obtiene el tipo del fichero 
		list(,,$type) = getImageSize($s_img); 
		  
		// No se reconoce el tipo del fichero 
		if (!isset($img_types[$type])) { 
			trigger_error('No se reconoce el tipo de imagen', E_USER_WARNING); 
			return false; 
		} 
		  
		// Se define función que creará la imagen y se comprueba que exista 
		if (!function_exists($f_create = 'imageCreateFrom' . $img_types[$type])) { 
			trigger_error("No existe la función '{$f_create}' necesaria para abrir la imagen.", E_USER_WARNING); 
			return false; 
		} 
		  
		// Crea la imagen a partir del fichero y comprueba que se haya cargado bien 
		if (!$img = $f_create($s_img)) { 
			trigger_error("No se pudo abrir el fichero correctamente.", E_USER_WARNING); 
			return false; 
		} 

		// Obtiene el tamaño de la imagen original 
		list($aw, $ah) = array(imageSX($img), imageSY($img)); 
		
		// Si el ancho o el alto de la imagen es menor o igual a 0 
		if ($aw <= 0 || $ah <= 0) { 
			trigger_error("El tamaño de la imagen es incorrecto.", E_USER_WARNING); 
			return false; 
		} 
		  
		//calculo el valor que falta para el stretch
		if($nuevo_ancho==0){
			$nuevo_ancho=$nuevo_alt * $aw / $ah;
		}
		if($nuevo_alto==0){
			$nuevo_alto=$nuevo_ancho * $ah / $aw;
		}
		
		// Se calcula la proporción de la imagen 
		if($nuevo_ancho>$aw){ //si el ancho no es suficiente
			$nuevo_alto=(int)($nuevo_alto * $aw/$nuevo_ancho);
			$nuevo_ancho=$aw;
		}
		if($nuevo_alto>$ah){ //si el alto no es suficiente
			$nuevo_ancho=(int)($nuevo_ancho * $ah/$nuevo_alto);
			$nuevo_alto=$ah;
		}
		if (($nuevo_ancho/$aw) > ($nuevo_alto/$ah)){
			$x=0;
			$aux=(int)($nuevo_alto * $aw/$nuevo_ancho);
			$y=(int)(($ah-$aux)/2);
			$ah=$aux;
		} else { 
			$y=0;
			$aux=(int)($nuevo_ancho * $ah/$nuevo_alto);
			$x=(int)(($aw-$aux)/2);
			$aw=$aux;
		}

		// Si se puede crear la imagen a color verdadero se crea 
		if (function_exists('imageCreateTrueColor')) { 
			$img2 = imageCreateTrueColor($nuevo_ancho, $nuevo_alto); 
		} else { 
			if (function_exists('imageCreate')) { 
				trigger_error("No existe la función 'imageCreate', no se puede crear la imagen.", E_USER_WARNING); 
				return false; 
			} 
			  
			$img2 = imageCreate($nuevo_ancho, $nuevo_alto); 
		} 
		  
		if (!$img2) { 
			trigger_error("No se pudo crear la imagen correctamente.", E_USER_WARNING); 
			return false; 
		} 

		// Se intenta usar imageCopyResampled 
		if (function_exists('imageCopyResampled')) { 
			imagecopyresampled($img2, $img, 0, 0, $x, $y, $nuevo_ancho, $nuevo_alto, $aw, $ah);
		} else { 
			if (function_exists('imageCopyResized')) { 
				trigger_error("No existe la función 'imageCopyResized', no se puede redimensionar la imagen.", E_USER_WARNING); 
				return false; 
			} 
			  
			imageCopyResized($img2, $img, 0, 0, $x, $y, $nuevo_ancho, $nuevo_alto, $aw, $ah);
		} 

		// Se comprueba que exista la función para guardar la imagen, en caso 
		// contrario se prueban otros formatos. 
		foreach(array($img_types[$type], 'Jpeg', 'Png') as $type_t) { 
			if (function_exists($f_save = 'image' . $type_t)) { 
				// Se guarda la imagen
				if ($new_root!=false) {
					$d_img=$new_root;
				}else{
					$d_img=$d_img;
				}
				if ($f_save($img2, $d_img)) return true;     
				
			}                  
		} 
		  
		trigger_error("No se pudo guardar la imagen en '{$d_img}'.", E_USER_WARNING); 
		return false; 
	} 

	return false; 
} 


function resizeImg($s_img, $d_img, $nuevo_ancho, $nuevo_alto, $new_root=false) 
{ 
	// Guarda los posibles tipos de imagenes en un array ($img_types) 
	static $img_types = array( 
		1 => 'Gif', 
		2 => 'Jpeg', 
		3 => 'Png',
		4 => 'jpg'
	); 
	  
	if (file_exists($s_img)) 
	{ 
		// Obtiene el tipo del fichero 
		list(,,$type) = getImageSize($s_img); 
		  
		// No se reconoce el tipo del fichero 
		if (!isset($img_types[$type])) { 
			trigger_error('No se reconoce el tipo de imagen', E_USER_WARNING); 
			return false; 
		} 
		  
		// Se define función que creará la imagen y se comprueba que exista 
		if (!function_exists($f_create = 'imageCreateFrom' . $img_types[$type])) { 
			trigger_error("No existe la función '{$f_create}' necesaria para abrir la imagen.", E_USER_WARNING); 
			return false; 
		} 
		  
		// Crea la imagen a partir del fichero y comprueba que se haya cargado bien 
		if (!$img = $f_create($s_img)) { 
			trigger_error("No se pudo abrir el fichero correctamente.", E_USER_WARNING); 
			return false; 
		} 

		// Obtiene el tamaño de la imagen original 
		list($aw, $ah) = array(imageSX($img), imageSY($img)); 
		
		// Si el ancho o el alto de la imagen es menor o igual a 0 
		if ($aw <= 0 || $ah <= 0) { 
			trigger_error("El tamaño de la imagen es incorrecto.", E_USER_WARNING); 
			return false; 
		} 
		  
		// Se calcula la proporción de la imagen 
		if($nuevo_ancho>$aw){ //si el ancho no es suficiente
			$nuevo_alto=(int)($nuevo_alto * $aw/$nuevo_ancho);
			$nuevo_ancho=$aw;
		}
		if($nuevo_alto>$ah){ //si el alto no es suficiente
			$nuevo_ancho=(int)($nuevo_ancho * $ah/$nuevo_alto);
			$nuevo_alto=$ah;
		}
		if (($nuevo_ancho/$aw) > ($nuevo_alto/$ah)){
			$x=0;
			$aux=(int)($nuevo_alto * $aw/$nuevo_ancho);
			$y=(int)(($ah-$aux)/2);
			$ah=$aux;
		} else { 
			$y=0;
			$aux=(int)($nuevo_ancho * $ah/$nuevo_alto);
			$x=(int)(($aw-$aux)/2);
			$aw=$aux;
		}

		// Si se puede crear la imagen a color verdadero se crea 
		if (function_exists('imageCreateTrueColor')) { 
			$img2 = imageCreateTrueColor($nuevo_ancho, $nuevo_alto); 
		} else { 
			if (function_exists('imageCreate')) { 
				trigger_error("No existe la función 'imageCreate', no se puede crear la imagen.", E_USER_WARNING); 
				return false; 
			} 
			  
			$img2 = imageCreate($nuevo_ancho, $nuevo_alto); 
		} 
		  
		if (!$img2) { 
			trigger_error("No se pudo crear la imagen correctamente.", E_USER_WARNING); 
			return false; 
		} 

		// Se intenta usar imageCopyResampled 
		if (function_exists('imageCopyResampled')) { 
			imagecopyresampled($img2, $img, 0, 0, $x, $y, $nuevo_ancho, $nuevo_alto, $aw, $ah);
		} else { 
			if (function_exists('imageCopyResized')) { 
				trigger_error("No existe la función 'imageCopyResized', no se puede redimensionar la imagen.", E_USER_WARNING); 
				return false; 
			} 
			  
			imageCopyResized($img2, $img, 0, 0, $x, $y, $nuevo_ancho, $nuevo_alto, $aw, $ah);
		} 

		// Se comprueba que exista la función para guardar la imagen, en caso 
		// contrario se prueban otros formatos. 
		foreach(array($img_types[$type], 'Jpeg', 'Png') as $type_t) { 
			if (function_exists($f_save = 'image' . $type_t)) { 
				// Se guarda la imagen
				if ($new_root!=false) {
					$d_img=$new_root;
				}else{
					$d_img=$d_img;
				}
				if ($f_save($img2, $d_img)) return true;     
				
			}                  
		} 
		  
		trigger_error("No se pudo guardar la imagen en '{$d_img}'.", E_USER_WARNING); 
		return false; 
	} 

	return false; 
} 


?> 

</body>