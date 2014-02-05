<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
<script src="../fontes/js/jquery.min.js"></script>
</head>

<body>
https://www.googleapis.com/language/translate/v2?key=AIzaSyCSYWVaDBCgKuGlks_DCFZQZl4CCIlTaJQ&q=hello%20world&source=en&target=pt
<form>
<label style="">De
	<select style="display:block;" id="origem">
    	<option value="en">Inglês</option>
        <option value="pt">Português</option>
    </select>
</label>
<label style="">Para
	<select style="display:block;" id="destino">
    	<option value="en">Inglês</option>
        <option value="pt">Português</option>
        <option value="de">Alemão</option>
    </select>
</label>
	<label style="display:block; margin-top:10px;">
    Texto a traduzir
    	<textarea style="display:block;" id="texto" name="texto" cols="50"></textarea>
    </label>
    <label>
    	<input value="Traduzir" type="button" onclick="traduzir()" />
    </label>
    <label style="float:left; margin-top:10px;">
    Texto traduzido
    	<div id="traduzido" style=" width:200px; height:200px; border:solid 1px black;"></div>
    </label>
</form>
<script>
	function traduzir(){
		origem=$("#origem option:selected").val();
		destino=$("#destino option:selected").val();
		//console.log("origem:"+origem+" destino:"+destino);
		
		texto=escape($("#texto").val());
		
		$.get('traduzir.php?origem='+origem+'&destino='+destino+'&texto=' + texto, function(data){
   			retorno= data;
			$('#traduzido').html(unescape(retorno));
		});
		
	}
</script>

</body>
</html>
