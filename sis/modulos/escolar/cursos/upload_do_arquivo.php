<?
print_r($_FILES);

if($_FILES['arquivo']){
	echo "entrou no envio do arquivo";
	move_uploaded_file($_FILES['arquivo']['tmp_name'],$_FILES['arquivo']['name']);
	exit();
}

?>