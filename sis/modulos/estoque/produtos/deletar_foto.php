<?

include "../../../_config.php";
if($_GET[id]>0){
	$id=$_GET[id];
	$produto_q=mysql_query($oi="SELECT * FROM produto WHERE id='$id'");
	mysql_query("UPDATE produto SET foto='' WHERE id='$id'");
	$produto=mysql_fetch_object($produto_q);
	$foto=$produto->foto;
	$foto_separado=explode("/",$foto);
	echo "fotos_produtos/".$foto_separado[4];
	unlink("fotos_produtos/".$foto_separado[4]);
}

?>