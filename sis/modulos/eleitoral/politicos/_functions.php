<?
	//-------Funcoes Vereador-----------------------------
	function CadastraVereador($nome,$data_nascimento,$partido_id,$telefone1,$telefone2,$email,$estadocivil,$naturalidade,
	$endereco,$bairro,$cidade,$estado,$cep,$cargo,$numero,$slogan,$coligacao_id,$qtd_votos,$vkt_id){
		$query = mysql_query($trace="INSERT INTO eleitoral_politicos SET nome='$nome', data_nascimento='".DataBrToUsa($data_nascimento)."',
		partido_id='$partido_id',telefone1='$telefone1',telefone2='$telefone2',email='$email',estado_civil='$estadocivil',
		naturalidade='$naturalidade', endereco='$endereco', bairro='$bairro', cidade='$cidade', uf='$estado',
		cep='$cep', slogan='$slogan', numero='$numero', coligacao_id='$coligacao_id', quantidade_votos='$qtd_votos', cargo='$cargo', vkt_id='$vkt_id'");
		//echo $trace;
	}
	
	function AlteraVereador($nome,$data_nascimento,$partido_id,$telefone1,$telefone2,$email,$estadocivil,$naturalidade,
	$endereco,$bairro,$cidade,$estado,$cep,$cargo,$numero,$slogan,$coligacao_id,$qtd_votos,$id){
		$query = mysql_query($trace="UPDATE eleitoral_politicos SET nome='$nome', data_nascimento='".DataBrToUsa($data_nascimento)."',
		partido_id='$partido_id',telefone1='$telefone1',telefone2='$telefone2',email='$email',estado_civil='$estadocivil',
		naturalidade='$naturalidade', endereco='$endereco', bairro='$bairro', cidade='$cidade', uf='$estado',
		cep='$cep', slogan='$slogan', numero='$numero', coligacao_id='$coligacao_id', quantidade_votos='$qtd_votos', cargo='$cargo' WHERE id='$id'");
		//echo $trace."<br>";
	}
	function ExcluiVereador($id){
		$query = mysql_query($trace="DELETE FROM eleitoral_politicos WHERE id='$id'");
		//echo $trace;
	}
	
?>