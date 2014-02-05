<?
//--------------------BEM----------------------------------------------------------------
if(isset($_GET['idbem'])){$idbem=$_GET['idbem'];}

if(isset($_POST['idbem'])){$idbem=$_POST['idbem'];}

if($_POST['actionbem']=='Salvar'){
	if($idbem==0){
		CadastraBem($_POST['nome']);
	}
	if($idbem>0){
		AlteraBem($_POST['nome'],$idbem);
	}
}
if($_POST['actionbem']=='Excluir'){
	ExcluiBem($idbem);
}

if($idbem>0){
	$bem_q=mysql_fetch_object(mysql_query("SELECT * FROM eleitoral_tipo_bens WHERE id='$idbem'"));
	//echo "Bem:".$bem_q;
}

//--------------------PROFISSAO----------------------------------------------------------------
if(isset($_GET['idprofissao'])){$idprofissao=$_GET['idprofissao'];}

if(isset($_POST['idprofissao'])){$idprofissao=$_POST['idprofissao'];}
if($_POST['actionprofissao']=='Salvar'){
	if($idprofissao==0){
		CadastraProfissao($_POST['nome'],$_POST['data_comemorativa']);
	}
	if($idprofissao>0){
		AlteraProfissao($_POST['nome'],$_POST['data_comemorativa'],$idprofissao);
	}
}
if($_POST['actionprofissao']=='Excluir'){
	ExcluiProfissao($idprofissao);
}

if($idprofissao>0){
	$profissao=mysql_fetch_object(mysql_query($trace="SELECT * FROM eleitoral_profissoes WHERE id='$idprofissao'"));
	//echo $trace;
}

//--------------------Zona----------------------------------------------------------------
if(isset($_GET['idzona'])){$idzona=$_GET['idzona'];}

if(isset($_POST['idzona'])){$idzona=$_POST['idzona'];}
if($_POST['actionzona']=='Salvar'){
	if($idzona==0){
		CadastraZona($_POST['zona'],$_POST['secao'],$_POST['local'],$vkt_id);
	}
	if($idzona>0){
		AlteraZona($_POST['zona'],$_POST['secao'],$_POST['local'],$idzona);
	}
}
if($_POST['actionzona']=='Excluir'){
	ExcluiZona($idzona);
}

if($idzona>0){
	$zona_q=mysql_fetch_object(mysql_query($trace="SELECT * FROM eleitoral_zonas WHERE id='$idzona'"));
}

//--------------------Vinculo----------------------------------------------------------------
if(isset($_GET['idvinculo'])){$idvinculo=$_GET['idvinculo'];}

if(isset($_POST['idvinculo'])){$idvinculo=$_POST['idvinculo'];}
if($_POST['actionvinculo']=='Salvar'){
	if($idvinculo==0){
		CadastraVinculo($_POST['nome']);
	}
	if($idvinculo>0){
		AlteraVinculo($_POST['nome'],$idvinculo);
	}
}
if($_POST['actionvinculo']=='Excluir'){
	ExcluiVinculo($idvinculo);
}

if($idvinculo>0){
	$vinculo_q=mysql_fetch_object(mysql_query($trace="SELECT * FROM eleitoral_vinculos WHERE id='$idvinculo'"));
}

//--------------------Setor----------------------------------------------------------------
if(isset($_GET['idsetor'])){$idsetor=$_GET['idsetor'];}

if(isset($_POST['idsetor'])){$idsetor=$_POST['idsetor'];}
if($_POST['actionsetor']=='Salvar'){
	if($idsetor==0){
		CadastraSetor($_POST['nome'],$_POST['coordenador_id'],$vkt_id);
	}
	if($idsetor>0){
		AlteraSetor($_POST['nome'],$_POST['coordenador_id'],$idsetor);
	}
}
if($_POST['actionsetor']=='Excluir'){
	ExcluiSetor($idsetor);
}

if($idsetor>0){
	$setor_q=mysql_fetch_object(mysql_query($trace="SELECT * FROM eleitoral_setor WHERE id='$idsetor'"));
}

//--------------------Regiao----------------------------------------------------------------
if(isset($_GET['idregiao'])){$idregiao=$_GET['idregiao'];}

if(isset($_POST['idregiao'])){$idregiao=$_POST['idregiao'];}
 
if($_POST['actionregiao']=='Salvar'){
	if($idregiao==0){
		CadastraRegiao($_POST['sigla'],$_POST['descricao'],$vkt_id);
	}
	if($idregiao>0){
		AlteraRegiao($_POST['sigla'],$_POST['descricao'],$idregiao);
	}
}
if($_POST['actionregiao']=='Excluir'){
	ExcluiRegiao($idregiao);
}

if($idregiao>0){
	$regiao_q=mysql_fetch_object(mysql_query($trace="SELECT * FROM eleitoral_regioes WHERE id='$idregiao'"));
}

//--------------------Partido----------------------------------------------------------------
if(isset($_GET['idpartido'])){$idpartido=$_GET['idpartido'];}

if(isset($_POST['idpartido'])){$idpartido=$_POST['idpartido'];}
 
if($_POST['actionpartido']=='Salvar'){
	if($idpartido==0){
		CadastraPartido($_POST['sigla'],$_POST['nome'],$vkt_id);
	}
	if($idpartido>0){
		AlteraPartido($_POST['sigla'],$_POST['nome'],$idpartido);
	}
}
if($_POST['actionpartido']=='Excluir'){
	ExcluiPartido($idpartido);
}

if($idpartido>0){
	$partido_q=mysql_fetch_object(mysql_query($trace="SELECT * FROM eleitoral_partidos WHERE id='$idpartido'"));
}

//--------------------Vereador----------------------------------------------------------------
if(isset($_GET['idvereador'])){$idvereador=$_GET['idvereador'];}

if(isset($_POST['idvereador'])){$idvereador=$_POST['idvereador'];}

if($_POST['actionvereador']=='Salvar'){
	if($idvereador==0){
		CadastraVereador($_POST['nome'],$_POST['partido_id'],$vkt_id);
	}
	if($idvereador>0){
		AlteraVereador($_POST['nome'],$_POST['partido_id'],$idvereador);
	}
}
if($_POST['actionvereador']=='Excluir'){
	ExcluiVereador($idvereador);
}

if($idvereador>0){
	$vereador_q=mysql_fetch_object(mysql_query($trace="SELECT * FROM eleitoral_vereadores WHERE id='$idvereador'"));
	//echo $trace;
}

//--------------------Coligacao----------------------------------------------------------------
if(isset($_GET['id_coligacao'])){$id_coligacao=$_GET['id_coligacao'];}

if(isset($_POST['id_coligacao'])){$id_coligacao=$_POST['id_coligacao'];}

if($_POST['actioncoligacao']=='Salvar'){
	if($id_coligacao==0){
		CadastraColigacao($_POST['nome'],$vkt_id);
	}
	if($id_coligacao>0){
		AlteraColigacao($_POST['nome'],$id_coligacao);
	}
}
if($_POST['actioncoligacao']=='Excluir'){
	ExcluiColigacao($id_coligacao);
}

if($id_coligacao>0){
	$coligacao_q=mysql_fetch_object(mysql_query($trace="SELECT * FROM eleitoral_coligacoes WHERE id='$id_coligacao'"));
	//echo $trace;
}

//--------------------Funcoes----------------------------------------------------------------
if(isset($_GET['id_funcao'])){$id_funcao=$_GET['id_funcao'];}

if(isset($_POST['id_funcao'])){$id_funcao=$_POST['id_funcao'];}

if($_POST['actionfuncao']=='Salvar'){
	if($id_funcao==0){
		CadastraFuncao($_POST['nome'],$vkt_id);
	}
	if($id_funcao>0){
		AlteraFuncao($_POST['nome'],$id_funcao);
	}
}
if($_POST['actionfuncao']=='Excluir'){
	ExcluiFuncao($id_funcao);
}

if($id_funcao>0){
	$funcao_q=mysql_fetch_object(mysql_query($trace="SELECT * FROM eleitoral_funcoes WHERE id='$id_funcao'"));
}

//--------------------Religioes----------------------------------------------------------------
if(isset($_GET['idreligiao'])){$idreligiao=$_GET['idreligiao'];}

if(isset($_POST['idreligiao'])){$idreligiao=$_POST['idreligiao'];}

if($_POST['actionreligiao']=='Salvar'){
	if($idreligiao==0){
		CadastraReligiao($_POST['nome'],$vkt_id);
	}
	if($idreligiao>0){
		AlteraReligiao($_POST['nome'],$idreligiao);
	}
}
if($_POST['actionreligiao']=='Excluir'){
	ExcluiReligiao($idreligiao);
}

if($idreligiao>0){
	$religiao_q=mysql_fetch_object(mysql_query($trace="SELECT * FROM eleitoral_religioes WHERE id='$idreligiao'"));
}

//--------------------Bairro----------------------------------------------------------------
if(isset($_GET['idbairro'])){$idbairro=$_GET['idbairro'];}

if(isset($_POST['idbairro'])){$idbairro=$_POST['idbairro'];}

if($_POST['actionbairro']=='Salvar'){
	//if($idbairro==0){
		ManipulaBairro($_POST,$vkt_id,$idbairro);
	//}
	//if($idbairro>0){
		//AlteraBairro($_POST['nome'],$_POST['regiao_id'],$idbairro);
	//}
}
if($_POST['actionbairro']=='Excluir'){
	Excluibairro($idbairro);
}

if($idbairro>0){
	$bairro_q=mysql_fetch_object(mysql_query($trace="SELECT * FROM eleitoral_bairros WHERE id='$idbairro'"));
	//echo $trace;
}
?>