<?
	//-------Funcoes Bem-----------------------------
	function CadastraBem($nome){
		$query = mysql_query($trace="INSERT INTO eleitoral_tipo_bens SET nome='$nome'");
	}
	function AlteraBem($nome,$id){
		$query = mysql_query($trace="UPDATE eleitoral_tipo_bens SET nome='$nome' WHERE id='$id'");
	}
	function ExcluiBem($id){
		$query = mysql_query($trace="DELETE FROM eleitoral_tipo_bens WHERE id='$id'");
	}
	
	//-------Funcoes Profissao-----------------------------
	function CadastraProfissao($nome,$datacomemoratica){
		$query = mysql_query($trace="INSERT INTO eleitoral_profissoes SET descricao='$nome',data_comemorativa='".DataBrToUsa($datacomemoratica)."'");
	}
	function AlteraProfissao($nome,$datacomemoratica,$id){
		$query = mysql_query($trace="UPDATE eleitoral_profissoes SET descricao='$nome',data_comemorativa='".DataBrToUsa($datacomemoratica)."' WHERE id='$id'");
	}
	function ExcluiProfissao($id){
		$query = mysql_query($trace="DELETE FROM eleitoral_profissoes WHERE id='$id'");
	}
	
	//-------Funcoes Zona-----------------------------
	function CadastraZona($nome,$secao,$local,$vkt_id){
		$query = mysql_query($trace="INSERT INTO eleitoral_zonas SET zona='$nome',secao='$secao',local='$local',vkt_id='$vkt_id'");
		//echo $trace;
	}
	function AlteraZona($nome,$secao,$local,$id){
		$query = mysql_query($trace="UPDATE eleitoral_zonas SET zona='$nome',secao='$secao',local='$local' WHERE id='$id'");
		//echo $trace;
	}
	function ExcluiZona($id){
		$query = mysql_query($trace="DELETE FROM eleitoral_zonas WHERE id='$id'");
	}
	
	//-------Funcoes Vinculo-----------------------------
	function CadastraVinculo($nome){
		$query = mysql_query($trace="INSERT INTO eleitoral_vinculos SET nome='$nome'");
		//echo $trace;
	}
	function AlteraVinculo($nome,$id){
		$query = mysql_query($trace="UPDATE eleitoral_vinculos SET nome='$nome' WHERE id='$id'");
		//echo $trace;
	}
	function ExcluiVinculo($id){
		$query = mysql_query($trace="DELETE FROM eleitoral_vinculos WHERE id='$id'");
	}
	
	//-------Funcoes Setor-----------------------------
	function CadastraSetor($nome,$coordenador_id,$vkt_id){
		$query = mysql_query($trace="INSERT INTO eleitoral_setor SET nome='$nome',coordenador_id='$coordenador_id',vkt_id=$vkt_id");
		//echo $trace;
	}
	function AlteraSetor($nome,$coordenador_id,$id){
		$query = mysql_query($trace="UPDATE eleitoral_setor SET nome='$nome',coordenador_id='$coordenador_id' WHERE id='$id'");
		//echo $trace;
	}
	function ExcluiSetor($id){
		$query = mysql_query($trace="DELETE FROM eleitoral_setor WHERE id='$id'");
	}
	
		//-------Funcoes Regiao-----------------------------
	function CadastraRegiao($sigla,$descricao,$vkt_id){
		$query = mysql_query($trace="INSERT INTO eleitoral_regioes SET sigla='$sigla',descricao='$descricao',vkt_id=$vkt_id");
	}
	function AlteraRegiao($sigla,$descricao,$id){
		$query = mysql_query($trace="UPDATE eleitoral_regioes SET sigla='$sigla',descricao='$descricao' WHERE id='$id'");
		//echo $trace;
	}
	function ExcluiRegiao($id){
		$query = mysql_query($trace="DELETE FROM eleitoral_regioes WHERE id='$id'");
	}
	
	//-------Funcoes Partido-----------------------------
	function CadastraPartido($sigla,$nome,$vkt_id){
		$query = mysql_query($trace="INSERT INTO eleitoral_partidos SET sigla='$sigla',nome='$nome',vkt_id=$vkt_id");
	}
	function AlteraPartido($sigla,$nome,$id){
		$query = mysql_query($trace="UPDATE eleitoral_partidos SET sigla='$sigla',nome='$nome' WHERE id='$id'");
		//echo $trace;
	}
	function ExcluiPartido($id){
		$query = mysql_query($trace="DELETE FROM eleitoral_partidos WHERE id='$id'");
	}
	
	//-------Funcoes Vereador-----------------------------
	function CadastraVereador($nome,$partido_id,$vkt_id){
		$query = mysql_query($trace="INSERT INTO eleitoral_vereadores SET nome='$nome',partido_id='$partido_id',vkt_id='$vkt_id'");
		//echo $trace;
	}
	function AlteraVereador($nome,$partido_id,$id){
		$query = mysql_query($trace="UPDATE eleitoral_vereadores SET nome='$nome',partido_id='$partido_id' WHERE id='$id'");
		//echo $trace;
	}
	function ExcluiVereador($id){
		$query = mysql_query($trace="DELETE FROM eleitoral_vereadores WHERE id='$id'");
		//echo $trace;
	}
	
	//-------Funcoes Coligacao-----------------------------
	function CadastraColigacao($nome,$vkt_id){
		$query = mysql_query($trace="INSERT INTO eleitoral_coligacoes SET nome='$nome',vkt_id='$vkt_id'");
		//echo $trace;
	}
	function AlteraColigacao($nome,$id){
		$query = mysql_query($trace="UPDATE eleitoral_coligacoes SET nome='$nome' WHERE id='$id'");
		//echo $trace;
	}
	function ExcluiColigacao($id){
		$query = mysql_query($trace="DELETE FROM eleitoral_coligacoes WHERE id='$id'");
		//echo $trace;
	}
	
	//-------Funcoes Funcao-----------------------------
	function CadastraFuncao($nome,$vkt_id){
		$query = mysql_query($trace="INSERT INTO eleitoral_funcoes SET nome='$nome',vkt_id=$vkt_id");
		//echo $trace;
	}
	function AlteraFuncao($nome,$id){
		$query = mysql_query($trace="UPDATE eleitoral_funcoes SET nome='$nome' WHERE id='$id'");
		//echo $trace;
	}
	function ExcluiFuncao($id){
		$query = mysql_query($trace="DELETE FROM eleitoral_funcoes WHERE id='$id'");
		//echo $trace;
	}
	
		//-------Funcoes Religiao-----------------------------
	function CadastraReligiao($nome,$vkt_id){
		$query = mysql_query($trace="INSERT INTO eleitoral_religioes SET nome='$nome',vkt_id='$vkt_id'");
		//echo $trace;
	}
	function AlteraReligiao($nome,$id){
		$query = mysql_query($trace="UPDATE eleitoral_religioes SET nome='$nome' WHERE id='$id'");
		//echo $trace;
	}
	function ExcluiReligiao($id){
		$query = mysql_query($trace="DELETE FROM eleitoral_religioes WHERE id='$id'");
		//echo $trace;
	}
	
	//-------Funcoes Bairros-----------------------------
	function ManipulaBairro($dados,$vkt_id,$id){
		if($id==''){$sql='INSERT INTO';$sql_fim="";}
		if($id>0){$sql='UPDATE';$sql_fim="WHERE id=$id";}
		$sql = mysql_query($trace="$sql eleitoral_bairros SET nome='{$dados['nome']}',regiao_id='{$dados['regiao_id']}',vkt_id='$vkt_id' $sql_fim");
		//echo $trace;
	}
	function Excluibairro($id){
		$query = mysql_query($trace="DELETE FROM eleitoral_bairros WHERE id='$id'");
		//echo $trace;
	}
?>