<?
//Empreendimento
function cadastraInteresse($dados,$regioes,$vkt_id){
	
	$data=validaDataUsa($dados['data']);
	if($dados['nome']!=="")$nome=limitaTexto($dados['nome'],255); else return 0;
	$telefone = limitaTexto($dados['telefone'],255);
	$telefone_2 = limitaTexto($dados['telefone_2'],255);
	$email=limitaTexto($dados['email'],255);

	if(mysql_query($t="
				INSERT INTO interesse SET
				nome='".$dados['nome']."',
				CEP='".$dados['cep']."',
				endereco='".$dados['endereco']."',
				numero='".$dados['numero']."',
				estado='".$dados['estado']."',
				bairro='".$dados['bairro']."',
				cidade='".$dados['cidade']."',
				complemento='".$dados['complemento']."',
				telefone_residencial='".$dados['telefone_residencial']."',
				telefone_comercial='".$dados['telefone_comercial']."',
				email='".$dados['email']."',
				propaganda='".$dados['propaganda']."',
				faixa_idade='".$dados['faixa_idade']."',
				estado_civil='".$dados['estado_civil']."',
				sexo='".$dados['sexo']."',
				grau_instrucao='".$dados['grau_instrucao']."',
				renda_familiar='".$dados['renda_familiar']."',
				filhos='".$dados['filhos']."',
				computador='".$dados['computador']."',
				internet='".$dados['internet']."',
				site_nv='".$dados['site_nv']."',
				residencia='".$dados['residencia']."',
				qtd_quartos='".$dados['qtd_quartos']."',
				finalidade_compra='".$dados['finalidade_compra']."',
				interesse_regioes='".$regioes."',
				faixa_interesse='".$dados['faixa_interesse']."',
				caracteristica_imovel='".$dados['caracteristica_imovel']."',
				fecha_negocio='".$dados['fecha_negocio']."',
				avaliacao_atendimento='".$dados['avaliacao_atendimento']."',
				observacoes='".$dados['observacoes']."',
				data='".DataBrToUsa($dados['data'])."',
				interacao='".$dados['interacao_status']."',
				usuario_id='".$_SESSION['usuario']->id."',
				corretor_id='".$dados['corretor_id']."',
				outra_propaganda='".$dados['outra_propaganda']."',
				outra_regiao='".$dados['outra_regiao']."',
				outra_caracteristica='".$dados['outra_caracteristica']."',
				outro_negocio='".$dados['outro_negocio']."',
				vkt_id='".$vkt_id."'
				")){
				
		$id_insert=mysql_insert_id();
		
		salvaUsuarioHistorico("Formulário - Interesses",'cadastrou','interesse',$id_insert);
				
		mysql_query($trace="
				INSERT INTO interesse_interacao SET
				interesse_id='".$id_insert."',
				data='".$data."',
				hora='".$hora."',
				status='".$interacao_status."'
				");
		return 1;
	}
	//echo $t."<br>";	
	return 0;
}



function alteraInteresse($id,$dados,$regioes){
	
	$data=validaDataUsa($dados['data']);
	if($nome!=="")$nome=limitaTexto($dados['nome'],255); else return 0;
	$telefone = limitaTexto($telefone,255);
	$telefone_2 = limitaTexto($telefone_2,255);
	$email=limitaTexto($email,255);
	
	if(mysql_query($t="
				UPDATE interesse SET
				nome='".$dados['nome']."',
				CEP='".$dados['cep']."',
				endereco='".$dados['endereco']."',
				numero='".$dados['numero']."',
				estado='".$dados['estado']."',
				bairro='".$dados['bairro']."',
				cidade='".$dados['cidade']."',
				complemento='".$dados['complemento']."',
				telefone_residencial='".$dados['telefone_residencial']."',
				telefone_comercial='".$dados['telefone_comercial']."',
				email='".$dados['email']."',
				propaganda='".$dados['propaganda']."',
				faixa_idade='".$dados['faixa_idade']."',
				estado_civil='".$dados['estado_civil']."',
				sexo='".$dados['sexo']."',
				grau_instrucao='".$dados['grau_instrucao']."',
				renda_familiar='".$dados['renda_familiar']."',
				filhos='".$dados['filhos']."',
				computador='".$dados['computador']."',
				internet='".$dados['internet']."',
				site_nv='".$dados['site_nv']."',
				residencia='".$dados['residencia']."',
				qtd_quartos='".$dados['qtd_quartos']."',
				finalidade_compra='".$dados['finalidade_compra']."',
				interesse_regioes='".$regioes."',
				faixa_interesse='".$dados['faixa_interesse']."',
				caracteristica_imovel='".$dados['caracteristica_imovel']."',
				fecha_negocio='".$dados['fecha_negocio']."',
				avaliacao_atendimento='".$dados['avaliacao_atendimento']."',
				observacoes='".$dados['observacoes']."',
				data='".DataBrToUsa($dados['data'])."',
				interacao='".$dados['interacao_status']."',
				hora='".$dados['hora']."',
				usuario_id='".$_SESSION['usuario']->id."',
				corretor_id='".$dados['corretor_id']."',
				outra_propaganda='".$dados['outra_propaganda']."',
				outra_regiao='".$dados['outra_regiao']."',
				outra_caracteristica='".$dados['outra_caracteristica']."',
				outro_negocio='".$dados['outro_negocio']."'
				WHERE
				id='".$id."'
				")){
		//echo "Trace=".$t;
		$id_insert=$id;			
					
		salvaUsuarioHistorico("Formulário - Interesses",'alterou','interesse',$id_insert);
		
		$d=mysql_fetch_object(mysql_query("SELECT id,data FROM interesse_interacao WHERE interesse_id='".$id_insert."' AND status='0' ORDER BY id DESC"));
		if($d->id>0&&$data!=""){
			mysql_query($trace="
					UPDATE interesse_interacao SET
					interesse_id='".$id_insert."',
					data='".$data."',
					hora='".$hora."',
					status='".$interacao_status."'
					WHERE id='".$d->id."'
					");
		}elseif($data!=""){
			mysql_query($trace="
					INSERT INTO interesse_interacao SET
					interesse_id='".$id_insert."',
					data='".$data."',
					hora='".$hora."',
					status='".$interacao_status."'
					");
		}
		return 1;
	}
	
	return 0;
}

function excluiInteresse($id){
	
	if($id>0){
		salvaUsuarioHistorico("Formulário - Interesses",'excluiu','interesse',$id);
		mysql_query("
					DELETE FROM interesse
					WHERE id='".$id."'
					");
		mysql_query("
					DELETE FROM interesse_interacao
					WHERE interesse_id='".$id."'
					");
		return 1;
	}
	
	return 0;
}
?>