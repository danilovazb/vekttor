<?
function alteraVencimentoFatura($id_fatura,$data_vencimento,$comissao=false){
	if($comissao){$tabela='faturas_comissao';}else{$tabela="faturas";}
	$o="UPDATE $tabela SET data_vencimento='".dataBrToUsa($data_vencimento)."' WHERE id='$id_fatura' ";
	mysql_query($o);
}