<!doctype html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Documento sem t&iacute;tulo</title>
<style type="text/css">
body,td,th {
	font-family: Consolas, "Andale Mono", "Lucida Console", "Lucida Sans Typewriter", Monaco, "Courier New", monospace;
}
</style>
</head>

<body>
<?
if($_FILES[fileField]){
	for($i=0;$i<count($_FILES[fileField][name]);$i++){
		
		$tmp = $_FILES[fileField][tmp_name][$i];
		
		$arquivo = $_POST[pasta].$_FILES[fileField][name][$i];
		if(!file_exists($_POST[pasta])){
			mkdir($_POST[pasta]);
		}
		
		if(move_uploaded_file($tmp,$arquivo)){
			chmod ($arquivo,0777);
			echo "Arquivo enviado $arquivo<br>";
		}else{
			echo "<strong>ERRO - $arquivo</strong><br>";	
		}
	}
}

?>
<form enctype="multipart/form-data" method="post" >
    <label for="textfield">Pasta<br>
</label>
  <input name="pasta" type="text" id="pasta" value="/">
  <br>
  <label for="fileField">Arquivo</label>
  <br>
  <input name="fileField[]" type='file' multiple />
   
  <input type="submit" name="submit" id="submit" value="Enviar">
</form>
</body>
</html>