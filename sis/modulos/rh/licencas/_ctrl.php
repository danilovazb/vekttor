<?php

if($_GET['id']>0){$id=$_GET['id'];}
if($_POST['id']>0){$id=$_POST['id'];}

if($_POST['action']== 'Salvar'){
	manipulaLicenca($_POST,$vkt_id);
}

if($_POST['action']== 'Excluir'){
	excluiLicenca($_POST,$vkt_id);
}

?>