	</div>
	<div class="separador"></div>
</div>

<footer>
	<div class="alinear_iz">TODOS LOS DERECHOS RESERVADOS - CACAO DIGITAL, C.A. - J-29656593-7</div>
	<div class="alinear_de">PARA SOPORTE TÉCNICO: <a href="mailto:info@cacaodigital.com">INFO@CACAODIGITAL.COM</a></div>
</footer>
<script type="text/javascript">
$(window).load(function(e){
	ajustar=function(){
		$winh = $(window).height();
		$winw = $(window).width();
		$('#cuerpo').css('min-height', $winh-60);
		$('#cuerpo2').css('min-height', $winh-60);
		$('#cuerpo2').css('width', $winw-270);
		$('#bienvenida').css('min-height', $winh-60);		
	}
	$(window).bind("resize",function(e){ajustar();})
	ajustar();
});
</script>
</body>
</html>
