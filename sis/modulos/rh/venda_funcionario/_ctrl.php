<?php

if( !empty($_GET["funcionario_id"]) ){
	$funcionarioID = $_GET["funcionario_id"];
	$empresaID     = $_GET["empresa_id"];
	$funcionario = mysql_fetch_object(mysql_query(" SELECT * FROM rh_funcionario WHERE id = '$funcionarioID' "));
}

if(!empty($_GET["venda_id"])){
	$empresaID     = $_GET["empresa_id"];
	$funcionarioID     = $_GET["funcionario_id"];
	$VendaEdit = mysql_fetch_object( mysql_query(" SELECT * FROM ".VENDA." WHERE id = '".($_GET["venda_id"])."' "));
	$vendaParcela = mysql_fetch_object(mysql_query(" SELECT COUNT(id) AS qtdParcela FROM ".PARCELA." WHERE venda_id = '".$VendaEdit->id."' "));
	$funcionario = mysql_fetch_object(mysql_query(" SELECT * FROM rh_funcionario WHERE id = '$funcionarioID' "));
}

if($_POST["action"] == "Salvar"){
	Salvar($_POST);
}

if($_POST["action"] == "Cancelar Venda"){
	CancelarVenda($_POST["venda_id"]);
}