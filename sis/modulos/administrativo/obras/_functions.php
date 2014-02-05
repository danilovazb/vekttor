<?
//Empreendimento
function cadastraObra($nome,$tipo,$orcamento,$inicio,$fim,$obs){
	
	$inicio=validaDataUsa($inicio);
	$fim=validaDataUsa($fim);
	$obs=limitaTexto($obs,255);
	$orcamento = moedaBrToUsa($orcamento);

	if(mysql_query("
				INSERT INTO empreendimento SET
				nome='".$nome."',
				tipo='".$tipo."',
				orcamento='".$orcamento."',
				inicio='".$inicio."',
				fim='".$fim."',
				obs='".$obs."'
				")){
		salvaUsuarioHistorico("Formulário - Empreendimento",'cadastrou','empreendimento',mysql_insert_id());
		return 1;
	}
	
	return 0;
}



function alteraObra($id,$nome,$tipo,$orcamento,$inicio,$fim,$obs){
	
	if($nome!=""){
		$nome=limitaTexto($nome,255);
	}else return 0;
	$inicio=validaDataUsa($inicio);
	$fim=validaDataUsa($fim);
	$obs=limitaTexto($obs,255);
	$orcamento = moedaBrToUsa($orcamento);
	if(mysql_query($trace="
				UPDATE empreendimento SET
				nome='".$nome."',
				tipo='".$tipo."',
				orcamento='".$orcamento."',
				inicio='".$inicio."',
				fim='".$fim."',
				obs='".$obs."'
				WHERE
				id='".$id."'
				")){
		salvaUsuarioHistorico("Formulário - Empreendimento",'alterou','empreendimento',$id);
		return 1;
	}
	
	return 0;
}

function excluiObra($id){
	
	$negociacao=mysql_fetch_object(mysql_query("SELECT * FROM negociacao WHERE empreendimento_id='".$id."' LIMIT 1"));
	if($negociacao->id>0)return 0;
	$disponibilidade=mysql_fetch_object(mysql_query("SELECT * FROM disponibilidade WHERE empreendimento_id='".$id."' LIMIT 1"));
	if($disponibilidade->id>0)return 0;
	
	if($id>0){
		salvaUsuarioHistorico("Formulário - Empreendimento",'deletou','empreendimento',$id);
		mysql_query("
					DELETE FROM empreendimento
					WHERE id='".$id."'
					");

		return 1;
	}
	
	return 0;
}
?>