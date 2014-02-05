<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Teste</title>
<link type="text/css"  href="../../fontes/css/sis.css"/>
<script src="../../fontes/js/jquery.min.js"></script>
</head>
<body>
<h3>Relatório</h3>
<div id="conteudo">
<div id="dados"></div>
</div>
<? 
$url=str_replace('|','&',$_GET['url']); 
?>
<script>
$("#dados").load('<?=$url?> #dados');
</script>
</body>
</html>