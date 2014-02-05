<?
include("../../_config.php");
//Funções 

function consulta_ultimo_saldo($almoxarifado_id,$produto_id){
	global $vkt_id;
	$estoque=mysql_fetch_object(mysql_query($trace="SELECT * FROM estoque_mov WHERE produto_id='$produto_id' AND almoxarifado_id='$almoxarifado_id' AND vkt_id='$vkt_id' ORDER BY id DESC LIMIT 1"));

	if($estoque->id>0){
		$qtd=$estoque->saldo;
	}else{
		$qtd=0;
	}
	return $qtd;
}
/*
seleciona os almoxarifados
while($almoxarifado=$a){
	seleciona os produtos dos almoxarifados
	while($p=mysql_fetch_object($produto_q)){
		verifica o estoque
		if($p->estoque_minimo>=consulta_ultimo_saldo($almoxarifado->id, $produto->id)){
		}
	}
	
}
*/
function movimenta_estoque($almoxarifado_id,$produto_id,$doc_id,$doc_tipo,$entrada,$saida,$unidade=NULL){
	global $vkt_id,$usuario_id;
	//echo "<><>"; 
	$saldo = consulta_ultimo_saldo($almoxarifado_id,$produto_id);
	
	if($saldo>=$saida){
		$novosaldo =$saldo+$entrada-$saida;
		mysql_query($trace="INSERT INTO estoque_mov SET vkt_id='$vkt_id',usuario_id='$usuario_id',almoxarifado_id='$almoxarifado_id', produto_id='$produto_id', data_hora=NOW(), doc='$doc_id',doc='$doc_tipo', entrada='$entrada',saida='$saida', saldo='$novosaldo'");				
		return true;
	}else{
		return false;
	}
}

//tirou daqui (saiu)
//movimenta_estoque(1,150,5,'transferencia',0,0.2,'g');//unidade de origem tirei de la

//colocou aqui (entrou)
//movimenta_estoque(2,150,5,'transferencia',0.2,0,'g');//unidade de destino coloquei la
?>