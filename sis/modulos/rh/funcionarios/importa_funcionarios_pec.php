<?php
	exit();
	// configuração inicial do sistema
	include("../../../_config.php");
	// funções base do sistema
	include("../../../_functions_base.php");
	$vkt=186;
	
	$empresa_id='12959';
	$arquivo = file("Func_PEC.TXT");
	
	$cont=count($arquivo);
	
	//$inicio_registro =  "0148-CAFETERIA NORTE SUL MATRIZ";
	//$inicio_registro =  "0463-CAFETERIA NORTE SUL LTDA FILIAL 02";
	//$inicio_registro =  "0394-CONFEITARIA ITUPORANGA EIRELI ME";
	//$inicio_registro =  "0332-G M RODRIGUES ALIMENTOS";
	$inicio_registro   =  "0358-PADARIA RECIFE LTDA EPP";
	//$inicio_registro   =  "0171-CAFETERIA NORTE SUL LTDA FILIAL";
	//$inicio_registro   =  "0302-G M RODRIGUES PAES";
	//$inicio_registro =  "0490-G M RODRIGUES PAES ME FILIAL 01";
	$fim_registro    =  "+--------------------------------------+--------------------------------------------------------------------------------------+";
	for($l=0;$l<$cont;$l++){
		
				
		$linha =$arquivo[$l];
		
		//Nome e número sequencial da empresa
		if(trim($linha)==$inicio_registro){
		
			$sql = "INSERT INTO rh_funcionario SET vkt_id='$vkt', empresa_id='$empresa_id', ";
			//echo $arquivo[$l+2]."<br>";
			$numero_sequencial_empresa = substr($arquivo[$l+2],7,6);
			
			$nome_funcionario = trim(substr($arquivo[$l+2],15,-30));
			$sql.="numero_sequencial_empresa='$numero_sequencial_empresa' , nome='$nome_funcionario', ";
		}
		
		//Endereco, numero da casa e complemento
		if(strstr($linha,"Endereco:")&&!strstr($linha,"Agencia:")){
			$endereco = trim($linha);
			$endereco = str_replace("|","",$endereco);
			$endereco = substr($endereco,10,43);
			$endereco = explode(",",$endereco);
			$endereco = $endereco[0];
			$numero_casa = $endereco[1];
			$complemento = substr($linha,72);
			$complemento = str_replace("|","",$complemento);
			$sql.="endereco='$endereco', casa_numero='$numero_casa',complemento='$complemento', ";
			
		}
		
		//Bairro e cidade
		if(strstr($linha,"Bairro:")){
			$bairro = trim(substr($linha,14,40));
			$cidade = substr($linha, 62);
			$cidade = str_replace("|","",$cidade);
			$cidade = trim($cidade);
			$sql.="bairro='$bairro', cidade='$cidade', ";			
		}
		
		//cep e email
		if(strstr($linha,"C.E.P")){
			$cep = substr($linha,14,9);
			$email = substr($linha,37);
			$email = str_replace("|","",$email);
			$sql.="cep='$cep', email='$email', ";
		}
		
		//número de filhos, raça/cor, data de nascimento
		if(strstr($linha,"NR Filhos:")){
						
			$numero_filhos =  substr($linha, 45,5);
			$raca_cor = trim(substr($linha, 59,2));
			$data_nascimento = substr($linha,82,10);
			$sql.="cor='$raca_cor', data_nascimento='".DataBrToUsa($data_nascimento)."', ";
				
		}
		
		//CBO 2002, Função
		if(strstr($linha,"CBO 2002:")){
						
			$cbo = trim(substr($linha,39,9));
			$funcao = substr($linha,57,26);
			$sql.="cbo='$cbo', ";
			echo $nome_funcionario." ".$numero_sequencial_empresa." ".$cbo." ".$funcao."<br>";
			echo "UPDATE rh_funcionario SET cargo='$funcao' WHERE empresa_id='$empresa_id' AND numero_sequencial_empresa='$numero_sequencial_empresa' <br>";
		}
		continue;
		//Estado Civil, naturalidade
		if(strstr($linha,"Est. Civil:")){
			
			$estado_civil = substr($linha,17,30);
			$naturalidade = substr($linha,53);
			$naturalidade = trim(str_replace("|","",$naturalidade));
			$sql.="estado_civil='solteiro', naturalidade='$naturalidade', ";
			
		}
		
		//sexo
		if(strstr($linha,"Sexo:")){
			$sexo = substr($linha,13,1);
			if($sexo=='F'){
				$sexo = "feminino";
			}else{
				$sexo = "masculino";
			}
			
			$sql.="sexo='$sexo', ";
		}
		
		if(strstr($linha,"Mae:")){
			//echo strpos($linha,"Mae:")." ".strpos($linha,"Nacionalidade:")."<br>";
			$mae = trim(substr($linha,12,58));
			$sql.="filiacao_mae='$mae', ";
		}
		
		if(strstr($linha,"Pai:")){
			$pai = trim(substr($linha,12,58));
			$sql.="filiacao_pai='$pai', ";
		}
		
		//data de admissao, tipo de movimento, tipo_adm_rais
		if(strstr($linha,"Admissao:")){
			
			$data_admissao  = trim(substr($linha,16,26));
			//$tipo_movimento = substr($linha,66,2);
			//$tipo_adm_rais  = substr($linha,92,1);
			echo $tipo_movimento."<br>";
			$sql.="data_admissao='".DataBrToUsa($data_admissao)."', tipo_admissao='80', ";
			
		}
		
		//data da rescisão, causa da rescisão
		if(strstr($linha,"Data Rescisao:")){
			
			$data_rescisao = substr($linha,22,10);
			$causa_rescisao = substr($linha,69,2);
			
			if($causa_rescisao>0){
				echo "Demitido";
			}else{
				echo "Não demitido";
			}
			echo $data_rescisao." ".strlen($data_rescisao)." ".$causa_rescisao."<br>";
		}
		
		if(strstr($linha,"CTPS:")){
			
			$cpf=trim(substr($linha,55,20));
			
			$ctps = trim(substr($linha,13,9));
			$serie = trim(substr($linha,29,6));
			$uf_ctps = trim(substr($linha,44,2));
			$reservista = substr($linha,90);
			$reservista = trim(str_replace("|","",$reservista));
			
			
			
			//$sql.="carteira_profissional_numero='$ctps', carteira_profissional_serie='$serie', carteira_profissional_estado_emissor='$uf_ctps',carteira_reservista='$reservista', ";
			//$sql = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_funcionario WHERE empresa_id='$empresa_id' AND numero_sequencial_empresa='$numero_sequencial_empresa' AND vkt_id='$vkt'"));
			//echo $t." ".$sql->id." ".$nome_funcionario." ".$sql->nome."<br>";
			/*if($causa_rescisao>0){
				mysql_query($sql_demissao="INSERT INTO rh_funcionario_demitidos SET vkt_id='$vkt_id', empresa_id='$empresa_id', funcionario_id='$sql->id', data_demissao='".DataBrToUsa($data_rescisao)."', tipo_demissao='demissao_sem_justa_causa'
				");
				echo $sql_demissao." ";
				mysql_query($t="UPDATE rh_funcionario SET status='Demitidos' WHERE id='$sql->id'");echo $t."<br>";
			}*/
			//mysql_query($t="UPDATE rh_funcionario SET cpf='$cpf' WHERE id='$sql->id'");
			//echo "<br>$t".mysql_error()."<br>";
		}
		
		/*if(strstr($linha,"RG:")){
			
			$rg=substr($linha,11,12);
			$data_rg=substr($linha,33,10);
			$orgao_rg=substr($linha,65,4);
			$estado_rg=substr($linha,87,6);
			$cart_reservista = str_replace("|","",substr($linha,106));
			
			$sql.="rg='$ctps', rg_data_emissao='".DataBrToUsa($data_rg)."', rg_orgao_emissor='$orgao_rg/$estado_rg', ";
			
		}
		
		if(strstr($linha,"Tit. Eleit:")){
			
			$titulo_eleitor = trim(substr($linha,19,27));
			$zona_titulo    = trim(substr($linha,53,14));
			$secao_titulo   = trim(str_replace("|","",substr($linha,74)));
			
			$sql.="titulo_eleitor_numero='$titulo_eleitor',titulo_eleitor_zona='$zona_titulo',titulo_eleitor_secao='$secao_titulo',";
		}
		
		if(strstr($linha,"Numero:")){
			
			$pis = trim(substr($linha,14,19));
			//$zona_titulo    = trim(substr($linha,47,10));
			//$secao_titulo   = trim(str_replace("|","",substr($linha,74)));
			$sql.="pis='$pis', ";
		}
		
		if(strstr($linha,"Vale Transporte(%):")){
			
			$porcent_transporte = substr($linha,54,1);
			$sql.="vale_transporte='$porcent_transporte'";
		}
		
		if(strstr($linha,"Aquisicao De:")){
			
			$inicio_aquisicao_ferias = trim(substr($linha,68,11));
			$fim_aquisicao_ferias    = trim(substr($linha,84,11));
			
		}
		
		if(strstr($linha,"Gozo de:")){
			
			$inicio_gozo_ferias = trim(substr($linha,63,11));
			$fim_gozo_ferias    = trim(substr($linha,84,11));
						
		}
		
		if(trim($linha)==$fim_registro){
			//mysql_query($sql);
			//echo $sql." ".mysql_error()."<br>";
			//$funcionario_id=mysql_insert_id();
			//echo $funcionario_id."<br>";
			
			/*if($inicio_aquisicao_ferias!=" "){
				mysql_query($sql_ferias="INSERT INTO rh_ferias SET vkt_id='$vkt_id', empresa_id='$empresa_id', funcionario_id='$funcionario_id', data_inicio_aquisicao='".DataBrToUsa($inicio_aquisicao_ferias)."', 
				data_fim_aquisicao='".DataBrToUsa($fim_aquisicao_ferias)."', data_inicio='".DataBrToUsa($inicio_gozo_ferias)."', data_fim='".DataBrToUsa($fim_gozo_ferias)."'");
				echo $sql_ferias." ".mysql_error()."<br>";
			}
			
			for($i=0;$i<=$numero_filhos;$i++){
				mysql_query("INSERT INTO rh_funcionario_dependentes SET vkt_id='$vkt_id', funcionario_id='$funcionario_id',nome='filho$i', data_nascimento=NOW(), grau_parentesco='filho', escolaridade='1'");
				echo $sql_dependentes." ".mysql_error()."<br>";
			}
			
			if($data_rescisao!=" "){
				mysql_query($sql_demissao="INSERT INTO rh_funcionario_demitidos SET vkt_id='$vkt_id', empresa_id='$empresa_id', funcionario_id='$funcionario_id', data_demissao='".DataBrToUsa($data_rescisao)."', tipo_demissao='demissao_sem_justa_causa'
				");
				echo $sql_demissao." ".mysql_error()."<br>";
			}
						
		}*/
						
		//echo "<br>";
	}
	
	
	/*$funcionarios_demitidos = mysql_query($t="SELECT * FROM rh_funcionario_demitidos WHERE vkt_id='186'");
	echo mysql_num_rows($funcionarios_demitidos)."<br><br>";
	while($funcionario = mysql_fetch_object($funcionarios_demitidos)){
		echo $funcionario->funcionario_id." ".$funcionario->vkt_id."<br>";
		mysql_query($t="UPDATE rh_funcionario SET status='demitidos' WHERE id='$funcionario->funcionario_id' AND vkt_id='$vkt'");
		echo $t." ".mysql_error();
	}*/
?>