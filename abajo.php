	<div class="separador"></div>
	<footer>
		<div id="suscripcion">
			<h2>Suscríbete</h2>
			<form id="form_suscrip" name="form_suscrip" method="post" action="suscripcion?acc=enviar" onsubmit="return valida_suscrip(this)">
				<table><tr>
					<td><input name="email" type="email" placeholder="ingresa tu email aquí" required></td>
					<td><input type="submit" value="ENVIAR"></td>
				</tr></table>
			</form>
		</div>
		<div id="siguenos">
			<div>
				<a href="https://www.instagram.com/lulucreativeloft/" target="_blank"><img src="imagenes/instagram.svg"></a>&nbsp;
				<a href="https://www.pinterest.com/lulucreativelof/" target="_blank"><img src="imagenes/pinterest.svg"></a>&nbsp;
				<a href="https://www.facebook.com/Lul%C3%BA-Creative-Loft-493083060861917/?fref=ts" target="_blank"><img src="imagenes/facebook.svg"></a>&nbsp;
				<a href="mailto:lulucreativeloft@gmail.com" class="noload"><img src="imagenes/email.svg"></a>
				<h2>SÍGUENOS</h2>
			</div>
		</div>
		<div class="separador"></div>
		<h3>&copy; Copyright 2017 • Lulú Creative Loft • Rif. J-40440122-9 </h3>
	</footer>
</div>
<script type="text/javascript">
<!--
	function valida_suscrip(elFRM){
		var m="";
		if(elFRM.email.value=="") m="Debe llenar el email";
		if(m=="" && elFRM.email.value!="" && !vemail(elFRM.email.value)) m="El email es inválido";
		if(m==""){
			return true;
		}else{
			alert(m);
			return false;
		}
	}
	function vemail(vEmail){
		regx=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
		return regx.test(vEmail);
	}
	$(document).ready(function(e) {
		$("a").live("click",function(evento){
			if(!$(this).hasClass("noload")){
				evento.preventDefault();
				$("#cargando").fadeIn(500);
				document.location=$(this).attr("href");
			}
		})
	});
-->
$(document).ready(function(e) {
	var mmobile=true;
	$(".menu_hamburguesa").click(function(){
		if(mmobile){
			$(".ul_mm").slideDown(500);
			mmobile=false;
		}else{
			$(".ul_mm").slideUp(500);
			mmobile=true;
		}
	})
});
</script>
<div id="cargando"></div>
</body>
</html>
