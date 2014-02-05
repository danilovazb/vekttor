<?php
function cadastra_grupo_cardapio($nome,$d){
	global $vkt_id;
	$query=mysql_query($trace="INSERT INTO cozinha_cardapios_grupos SET 
	nome='$d[nome]', 
	descricao='$d[descricao]',
	ordem='$d[ordem]',
	cafe ='$d[cafe]',
	almoco ='$d[almoco]',
	lanche ='$d[lanche]',
	janta ='$d[janta]',
	ceia  ='$d[ceia]',
	cafe_ordem ='$d[cafe_ordem]',
	almoco_ordem ='$d[almoco_ordem]',
	lanche_ordem ='$d[lanche_ordem]',
	janta_ordem ='$d[janta_ordem]',
	ceia_ordem ='$d[ceia_ordem]',
	vkt_id='$vkt_id'
	");
}

function altera_grupo_cardapio($id,$d){
	global $vkt_id;
	$query=mysql_query($trace="UPDATE cozinha_cardapios_grupos SET 	nome='$d[nome]', 
	descricao='$d[descricao]',
	ordem='$d[ordem]',
	cafe ='$d[cafe]',
	almoco ='$d[almoco]',
	lanche ='$d[lanche]',
	janta ='$d[janta]',
	ceia  ='$d[ceia]',
	cafe_ordem ='$d[cafe_ordem]',
	almoco_ordem ='$d[almoco_ordem]',
	lanche_ordem ='$d[lanche_ordem]',
	janta_ordem ='$d[janta_ordem]',
	ceia_ordem ='$d[ceia_ordem]',
	vkt_id='$vkt_id'
 WHERE id='$id'");
}

function deleta_grupo_cardapio($id){
	$query=mysql_query($trace="DELETE FROM cozinha_cardapios_grupos WHERE id='$id'");
}

?>