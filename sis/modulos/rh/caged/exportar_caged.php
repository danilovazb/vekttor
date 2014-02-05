<?php
	//$info[] = strtoupper(trataTxt("$r->cod;$r->responsavel_id;$r->nome;$r->endereco;$r->bairro;$r->cidade;$r->uf;$r->cep;$r->telefone1;$cpf;$r->email;$r->razao_social;$r->cnpj_cpf\n"));
	//Includes
	include("../../../_config.php");
	include("../../../_functions_base.php");
	include("_functions.php");
	include("_ctrl.php");	
	global $vkt_id;
	
	
	$mes = $_GET['mes']+1;
	$ano = $_GET['ano'];
	
	$data_mes_competencia = $ano."-".$mes."-".date("t");
	$data_atual = date('Y')."-".date('m')."-".date('d');	
	
	$diferenca_data = mysql_fetch_object(mysql_query($t="SELECT DATEDIFF('$data_atual','$data_mes_competencia') as diferenca_data"));
	//echo $t."<br>";
	//echo $diferenca_data->diferenca_data."<br>";
	//if($diferenca_data->diferenca_data>7){
		//$registro_c = "X";
	//}else{
		$registro_c = "C";
	//}
	
	//cliente_fornecedor = empresa
	$cliente_fornecedor = mysql_fetch_object(mysql_query($t="SELECT 
																* 
														  FROM 
														  		clientes_vekttor														  		
														  WHERE
														  		id='$cliente_id'"));
																
														
	
	//primeira linha armazena o autorizado REGISTRO A(AUTORIZADO) - empresa que gera a folha
	
	//TIPO DE REGISTRO, caracter, 1 posição - Define o registro a ser informado. Obrigatoriamente o conteúdo é A.
	$autorizado_tipo_reg        = "A";
	
	//TIPO DE LAYOUT, caracter, 5 Posições - Informe qual o layout do arquivo CAGED. Obrigatoriamente o conteúdo é L2009.
	$autorizado_tipo_layout	    = "L2009";
	
	//FILLER, caracter, 2 posições - Deixar em branco
	$autorizado_filler          = "  ";
	
	//MEIO FÍSICO, numérico, 1 posição - Informe qual o meio físico utilizado para informar o arquivo CAGED. 
	//2 - Disquete
    //3 - Fita
    //4 - Outros 
	$autorizado_meio_mag        = "4";
	
	//COMPETÊNCIA, numérico, 6 posições - Mês e ano de referência das informações do CAGED. Informar sem máscara(/.\-,).	
	$autorizado_competencia_mes = $mes;
	$autorizado_competencia_mes = str_pad($autorizado_competencia_mes, 2, '0', STR_PAD_LEFT );	
			
	$autorizado_competencia_ano = $ano;
	
	//ALTERAÇÃO, numérico, 1 posição - Define se os dados cadastrais informados irão ou não atualizar o Cadastro de Autorizados do CAGED Informatizado.
	//1 - Nada a alterar 
    //2 - Alterar dados cadastrais 
	$autorizado_alteracao       = $_GET['alteracao_autorizado'];
	
	//SEQUÊNCIA, numérico, 5 posições - Número seqüencial no arquivo.
	$sequencia                  = 1;
	$autorizado_sequencia       = str_pad($sequencia, 5, '0', STR_PAD_LEFT);
	
	//TIPO IDENTIFICADOR, numérico, 1 posição - Define o tipo de identificador do estabelecimento a informar. (1 - CNPJ / 2 - CEI) 
	$autorizado_tipo_ident      = "1";
	
	//NÚMERO IDENTIFICADOR DO AUTORIZADO, numérico, 14 posições - Número identificador do estabelecimento. Não havendo inscrição do estabelecimento no Cadastro Nacional de Pessoa Jurídica (CNPJ), informar o número de registro no CEI (Código Específico do INSS). O número do CEI tem 12 posições, preencher este campo com 00(zeros) à esquerda.
	$autorizado_numero_ident    = formata_cnpj($cliente_fornecedor->cnpj);	
	
	//NOME/RAZÃO SOCIAL DO AUTORIZADO, caracter, 35 posições - Nome/Razão Social do estabelecimento autorizado.
	$autorizado_nome            = str_pad(substr($cliente_fornecedor->nome,0,35),35," ",STR_PAD_RIGHT);
	
	//ENDEREÇO, caracter, 40 posições - Informar o Endereço do estabelecimento (Rua, Av., Trav., Pç.) com número e complemento.
	$autorizado_endereco       = trataTxt(substr($cliente_fornecedor->endereco,0,40));
	$autorizado_endereco       = str_pad($autorizado_endereco, 40," ",STR_PAD_RIGHT);	
	
	//CEP, numérico, 8 posições - Informar o Código de Endereçamento Postal do estabelecimento conforme a tabela da Empresa de Correios e Telégrafos-ECT. Informar sem máscara(/.\-,).
	$autorizado_cep           = str_replace("-","",$cliente_fornecedor->cep);
	$autorizado_cep           = str_pad($autorizado_cep,8,0,STR_PAD_LEFT);	
	
	//UF, caracter, 2 posições - Informar a Unidade de Federação.	
	$autorizado_uf            = trataTxt(substr($cliente_fornecedor->estado,0,2));
	$autorizado_uf            = str_pad($autorizado_uf,2," ");
		
	$autorizado_telefone      = $cliente_fornecedor->telefone;
	$autorizado_telefone      = str_replace("-","",$autorizado_telefone);
	$autorizado_telefone      = str_replace("(","",$autorizado_telefone);
	$autorizado_telefone      = str_replace(")","",$autorizado_telefone);
	
	//DDD, numérico, 4 posições - Informar DDD do telefone para contato com o Ministério do Trabalho e Emprego. 
	$autorizado_telefone_ddd  = "00".substr($autorizado_telefone,0,2);
	
	//TELEFONE, numérico, 8 posições - Informar o número do telefone para contato com o responsável pelas informações contidas no arquivo CAGED.
	$autorizado_telefone      = substr($autorizado_telefone, 2);
	
	//RAMAL, numérico, 5 posições - Informar o ramal, se houver, complemento do telefone informado. 
	$autorizado_ramal         = "00000";
	
	$autorizado_filler2           = str_pad("  ",0,90,STR_PAD_RIGHT);
	
	//$infos = implode("",$info);
	//echo $infos;
	
	
//-------------------------Registro B (estabelecimento)-----------------------------------//	
//seleciona as empresas
$clientes_fornecedores = mysql_query($t="SELECT 
										*, cf.id as cf_id 
									  FROM 
									  
									  	rh_empresas rh_e,
									 	cliente_fornecedor cf
									  WHERE
									  	rh_e.cliente_fornecedor_id = cf.id AND
										rh_e.vkt_id='$vkt_id'
									");

$numero_movimentacoes = 0;
while($cf = mysql_fetch_object($clientes_fornecedores)){
	
	//verifica se a empresa já possui ou não registro
	$existe_registro = mysql_query($t="SELECT * FROM rh_caged WHERE mes='$autorizado_competencia_mes' AND ano='$autorizado_competencia_ano' AND
	empresa_id = $cf->cf_id");
	
	if(mysql_num_rows($existe_registro)<=0){
		
		mysql_query("INSERT INTO rh_caged SET mes='$autorizado_competencia_mes',ano='$autorizado_competencia_ano', empresa_id = '$cf->cf_id', vkt_id='$vkt_id'");
		$estabelecimento_declaracao = "1";
		
	}else{
		$estabelecimento_declaracao = "2";
	}
	
	//TIPO DE REGISTRO, caracter, 1 posição - Define o registro a ser informado. Obrigatoriamente o conteúdo é B.
	$estabelecimento_tipo_reg   = "B";
	$infob[] = $estabelecimento_tipo_reg;
	
	//TIPO IDENTIFICADOR, numérico, 1 posição - Define o tipo de identificador do estabelecimento a informar. (1 - CNPJ / 2 - CEI)
	$estabelecimento_tipo_ident = 1;	
	$infob[] = $estabelecimento_tipo_ident;
	
	//NÚMERO IDENTIFICADOR DO ESTABELECIMENTO, numérico, 14 posições - Número identificador do estabelecimento. Não havendo inscrição do estabelecimento no Cadastro Nacional de Pessoa Jurídica (CNPJ), informar o número de registro no CEI (Código Específico do INSS). O número do CEI tem 12 posições, preencher este campo com 00(zeros) à esquerda.
	$estabelecimento_tipo_ident = trataTxt($cf->cnpj_cpf);
	$estabelecimento_tipo_ident = str_pad($estabelecimento_tipo_ident,14,"0",STR_PAD_LEFT);	
	$infob[] = $estabelecimento_tipo_ident;
	
	$sequencia++;
	
	//SEQUÊNCIA, numérico, 5 posições - Número seqüencial no arquivo.
	$estabelecimento_sequencia = str_pad($sequencia,5,"0",STR_PAD_LEFT);	
	$infob[] = $estabelecimento_sequencia;
	
	//PRIMEIRA DECLARAÇÃO, numérico, 1 posição - Define se é ou  não a  primeira  declaração do  estabelecimento  ao  Cadastro Geral de Empregados e Desempregados-CAGED-Lei nº 4.923/65.
	//    1 - primeira declaração 
    //2 - já informaram ao CAGED anteriormente 
	$infob[] = trataTxt("$estabelecimento_declaracao");
	
	//ALTERAÇÃO, numérico, 1 posição - Define se os dados cadastrais informado irão ou não atualizar o Cadastro de Autorizados do CAGED Informatizado.

    //1 - Nada a atualizar 
    //2 - Alterar dados cadastrais do estabelecimento (Razão Social, Endereço, CEP, Bairro, UF, ou Atividade Econômica) 
    //3 - Encerramentos de Atividades (Fechamento do estabelecimento) 
	$estabelecimento_alteracao = $_GET['alteracao_estabelecimento'];
	$infob[] = trataTxt("$estabelecimento_alteracao");
	
	//CEP , numérico, 8 posições - Informar o Código de Endereçamento Postal do estabelecimento conforme a tabela da Empresa de Correios e Telégrafos-ECT. Informar sem máscara(/.\-,).
	$estabelecimento_cep = trataTxt(substr($cf->cep,0,9));
	$estabelecimento_cep = str_replace("-","",$cf->cep);
	$estabelecimento_cep = str_pad($estabelecimento_cep,8,"0",STR_PAD_LEFT);
	$infob[] = $estabelecimento_cep;
	
	//FILLER, caracter, 5 posições - Deixar em branco
	$estabelecimento_filler = "     ";
	$infob[] = trataTxt("$estabelecimento_filler");
	
	//NOME/RAZÃO SOCIAL DO ESTABELECIMENTO, caracter, 40 posições - Nome/Razão Social do estabelecimento.
	$estabelecimento_nome = trataTxt(substr($cf->razao_social,0,40));
	$estabelecimento_nome = str_pad($estabelecimento_nome,40," ",STR_PAD_RIGHT);
	$infob[] = $estabelecimento_nome;
	
	//ENDEREÇO, caracter, 40 posições - Informar o Endereço do estabelecimento (Rua, Av., Trav., Pç.) com número e complemento.
	$estabelecimento_endereco= trataTxt(substr($cf->endereco." ".$cf->numero." ".$cf->complemento,0,40));
	$estabelecimento_endereco= str_pad($estabelecimento_endereco,40," ");
	$infob[] = $estabelecimento_endereco;
	
	//BAIRRO, caracter, 20 posições - Informar o bairro correspondente.
	$estabelecimento_bairro = trataTxt(substr($cf->bairro,0,20));
	$estabelecimento_bairro = str_pad($estabelecimento_bairro,20," ");	
	$infob[] = trataTxt("$estabelecimento_bairro"); 
	
	//UF, caracter, 2 posições - Informar a Unidade de Federação. 
	$estabelecimento_estado = trataTxt(substr($cf->estado,0,2));
	$estabelecimento_estado = str_pad($cf->estado,2,STR_PAD_RIGHT);
	$infob[] = trataTxt("$estabelecimento_estado");
	
	//TOTAL DE EMPREGADOS EXISTENTES NO 1º DIA, numérico, 5 posições - Total de empregados existentes na empresa no início do primeiro dia do mês de referência (competência). 
	$numero_funcionarios_primeiro_dia_empresa = mysql_num_rows(mysql_query("
										SELECT * FROM 
											rh_funcionario
										WHERE
											empresa_id = $cf->cf_id AND
											data_admissao = '$cf->dt_inicio_atividades' AND
											status='admitidos'
									"));
	
	if(strlen($numero_funcionarios_primeiro_dia_empresa)<5){
	
		$numero_funcionarios_primeiro_dia_empresa = str_pad($numero_funcionarios_primeiro_dia_empresa, 5, "0", STR_PAD_LEFT);
	
	}else{
		$numero_funcionarios_primeiro_dia_empresa = substr($numero_funcionarios_primeiro_dia_empresa,0,5);
	}
	
	$infob[] = trataTxt("$numero_funcionarios_primeiro_dia_empresa");
	
	//ICRO EMPRESA OU EMPRESA DE PEQUENO PORTE, numérico, 1 posição - Informe se o estabelecimento se enquadra como micro empresa ou empresa de pequeno porte, de acordo com a Lei - 9.841 de 05/10/1999, utilizando:  1 - Para indicar SIM e 2 - Para indicar NÃO 
	$estabelecimento_prote_estab = $cf->porte_empresa;
	
	$infob[] = trataTxt("$estabelecimento_prote_estab");
	
	$estabelecimento_cnae        = trataTxt(substr($cf->cnae_principal,0,5));
	$estabelecimento_cnae       .= trataTxt(substr($cf->objectvo_principal,0,2));
	$estabelecimento_cnae        = str_pad($estabelecimento_cnae, 7, "0", STR_PAD_LEFT);
	
	$infob[] = $estabelecimento_cnae;
	
	//DDD, numérico, 4 posições - Informar DDD do telefone para contato com o Ministério do Trabalho e Emprego.
	$estabelecimento_telefone      = $cf->telefone1;
	$estabelecimento_telefone      = str_replace("-","",$estabelecimento_telefone);
	$estabelecimento_telefone      = str_replace("(","",$estabelecimento_telefone);
	$estabelecimento_telefone      = str_replace(")","",$estabelecimento_telefone);
	
	$estabelecimento_telefone_ddd = "00".substr($estabelecimento_telefone,0,2);
	$infob[] = trataTxt("$estabelecimento_telefone_ddd");
	//TELEFONE, numérico, 8 posições - Informar o número do telefone para contato com o responsável pelas informações contidas no arquivo CAGED.
	$estabelecimento_telefone = substr($estabelecimento_telefone, 2);
	$infob[] = trataTxt("$estabelecimento_telefone");
	//E-MAIL, caracter, 50 posições - Endereço eletrônico do estabelecimento ou do responsável, utilizado para eventuais contatos, todos os caracteres serão transformados em minúsculos.
	$estabelecimento_email    = str_pad($cf->email, 50, " ", STR_PAD_RIGHT);;
	$infob[] = $estabelecimento_email;
	//FILLER, caracter, 27 posições - Deixar em branco.
	$estabelecimento_filler2 = str_pad(" ",27," ");
	
	$infob[] = "$estabelecimento_filler2\n";
	
	
//-------------------------Registro C (Movimentacao_caged)-----------------------------------//	

	//consulta_admissoes
	$admissoes = mysql_query($t="SELECT *,rh_f.id as funcionario_id,rh_f.grau_instrucao as funcionario_instrucao, rh_f.cep as funcionario_cep, rh_f.sexo as sexo_f
								
								 FROM rh_funcionario rh_f,
									cliente_fornecedor cf			 
								 WHERE 
								 	rh_f.empresa_id = cf.id AND
									MONTH(rh_f.data_admissao) = '$autorizado_competencia_mes' AND 
									YEAR(rh_f.data_admissao) = '$autorizado_competencia_ano' AND
									rh_f.vkt_id = '$vkt_id' AND
									rh_f.empresa_id = '$cf->cf_id'");
	$numero_movimentacoes += mysql_num_rows($admissoes);
	
	//consulta_demissoes
	$demissoes = mysql_query($t="SELECT *, rh_f.id as funcionario_id,rh_f.grau_instrucao as funcionario_instrucao, rh_f.cep as funcionario_cep, rh_f.sexo as sexo_f FROM 
									rh_funcionario_demitidos rh_fd, 
									rh_funcionario rh_f,
									cliente_fornecedor cf
								
								WHERE 
									MONTH(rh_fd.data_demissao) = '$autorizado_competencia_mes' AND 
									YEAR(rh_fd.data_demissao) = '$autorizado_competencia_ano' AND
									rh_fd.funcionario_id = rh_f.id AND
									rh_f.empresa_id      = cf.id AND
									rh_fd.vkt_id = '$vkt_id' AND
									rh_fd.empresa_id = '$cf->cf_id'");
	$numero_movimentacoes += mysql_num_rows($demissoes);								
	
	$movimentacoes = array("admissao"=>$admissoes,"demissao"=>$demissoes);
	$tipos_demissoes = array("demissao_com_justa_causa"=>31,
							"demissao_com_justa_causa"=>32,
							"pedido_demissao"=>40,
							"fim_contrato"=>45,
							);
	
	foreach($movimentacoes as $tipo => $m){
		
		while($movimentacao = mysql_fetch_object($m)){	
			$sequencia++;
		
			/*TIPO DE REGISTRO, caracter, 1 posição - Define o registro a ser informado. Obrigatoriamente o conteúdo é C.*/
			$movimentacao_tipo_registro         = $registro_c;
			$infob[] = $movimentacao_tipo_registro;
						
			/*TIPO IDENTIFICADOR, numérico, 1 posição - Define o tipo de identificador do estabelecimento a informar. (1 - CNPJ / 2 - CEI) */
			$movimentacao_tipo_identificacao    = "1";		
			$infob[] = $movimentacao_tipo_identificacao;
			
			/*NÚMERO IDENTIFICADOR DO ESTABELECIMENTO, numérico, 14 posições - Número identificador do estabelecimento. Não havendo inscrição do estabelecimento no Cadastro Nacional de Pessoa Jurídica (CNPJ), informar o número de registro no CEI (Código Específico do INSS). O número do CEI tem 12 posições, preencher este campo com 00(zeros) à esquerda*/
			$movimentacao_ident_estabelecimento = formata_cnpj($movimentacao->cnpj_cpf);
			$infob[] = $movimentacao_ident_estabelecimento;
			
			//SEQUÊNCIA, numérico, 5 posições - Número seqüencial no arquivo.	
			$movimentacao_sequencia             = str_pad($sequencia,5,"0",STR_PAD_LEFT);
			$infob[] = $movimentacao_sequencia;
			
			//PIS/PASEP, numérico, 11 posições - Número do PIS/PASEP do empregado movimentado. Informar sem máscara(/.\-,).
			$movimentacao_pis                   = trataTxt($movimentacao->pis);
			$movimentacao_pis                   = str_pad($movimentacao_pis,11,"0",STR_PAD_LEFT);
			$infob[] = $movimentacao_pis;
			
			//SEXO, numérico, 1 posição - Define o sexo do empregado. (1 - Masculino / 2 - Feminino)	
			if($movimentacao->sexo_f=='masculino'){
				$movimentacao_sexo = "1";
			}else{
				$movimentacao_sexo = "2";
			}
			$infob[] = $movimentacao_sexo;
			
			//NASCIMENTO, numérico, 8 posições - Dia, mês e ano de nascimento do empregado. Informar a data do nascimento sem máscara(/.\,).
			$movimentacao_data_nascimento    = trataTxt(DataUsaToBr($movimentacao->data_nascimento));
			$infob[] = $movimentacao_data_nascimento;
			
			//INSTRUÇÃO, numérico, 2 posição - Define o grau de instrução do empregado.
		
			//1  - Analfabeto inclusive o que, embora tenha recebido instrução, não se alfabetizou; 
			//2  - Até 4ª série incompleta do Ensino Fundamental (antigo 1º grau ou primário) que se tenha alfabetizado sem ter freqüentado escola regular; 
			//3  - 4ª série completa do Ensino Fundamental (antigo 1º grau ou primário); 
			//4  - Da 5ª à 8ª série do Ensino Fundamental (antigo 1º grau ou ginásio); 
			//5  – Ensino Fundamental completo (antigo 1º grau ou primário e ginasial); 
			//6  – Ensino Médio incompleto (antigo 2º grau, secundário ou colegial);
			//7  – Ensino Médio completo (antigo 2º grau, secundário ou colegial);
			//8  – Educação Superior incompleta; 
			//9  – Educação Superior completa;
			//10 – Mestrado;
			//11 - Doutorado.
			$movimentacao_instrucao             = str_pad($movimentacao->funcionario_instrucao,2,"0",STR_PAD_LEFT);;
			
			$infob[] = $movimentacao_instrucao;
			
			//FILLER, caracter, 4 posições - Deixar em branco.
			$movimentacao_filler                = "    ";
			$infob[] = $movimentacao_filler;
			
			//REMUNERAÇÃO (SALÁRIO MENSAL), numérico, 8 posições - Informar o salário recebido, ou a receber. Informar com centavos sem pontos e sem vírgulas. Ex: R$ 134,60 informar: 13460 
			$movimentacao_salario_mensal        = trataTxt($movimentacao_salario_mensal);
			$movimentacao_salario_mensal        = formata_campo(consulta_salario($movimentacao->funcionario_id),8,"0",STR_PAD_LEFT);
			$infob[] = $movimentacao_salario_mensal;
			
			//HORAS TRABALHADAS, numérico, 2 posições - Informar a quantidade de horas trabalhadas por semana (de 1 até 44 horas).	
			$movimentacao_horas_trabalhado      = "44";
			$infob[] = $movimentacao_horas_trabalhado;
			
			//ADMISSÃO, numérico, 8 posições - Dia, mês e ano de admissão do empregado. Informar a data de admissão sem máscara(/.\-,).
			$movimentacao_data_admissao         = trataTxt(DataUsaToBr($movimentacao->data_admissao));
			$infob[] = $movimentacao_data_admissao;	
			
			//TIPO DE MOVIMENTO, numérico, 2 posições - Define o tipo de movimento.
		
			//ADMISSÃO:
		
			//10 - Primeiro emprego 
			//20 - Reemprego 
			//25 - Contrato por prazo determinado 
			//35 - Reintegração 
			//70 - Transferência de entrada
		
			//DESLIGAMENTO:
		
			//31 - Dispensa sem justa causa 
			//32 - Dispensa por justa causa 
			//40 - A pedido (espontâneo) 
			//43 - Término de contrato por prazo determinado 
			//45 - Término de contrato 
			//50 - Aposentado 
			//60 - Morte 
			//80 - Transferência de saída
			//$movimentacao_tp_movimentacao="00";
			if($tipo=="admissao"){
				if(empty($movimentacao->tipo_admissao)){
					$movimentacao_tp_movimentacao = "10";	
				}else{
					$movimentacao_tp_movimentacao = $movimentacao->tipo_admissao;	
				}
				//echo "Admissão: ".$movimentacao_tp_movimentacao."<br>";
			}
			if($tipo=="demissao"){
				$movimentacao_tp_movimentacao = $tipos_demissoes[$movimentacao->tipo_demissao];
				//echo "Demissão: ".$movimentacao_tp_movimentacao."<br>";
				//echo "OI: ".$movimentacao_tp_movimentacao."=>".$movimentacao->tipo_demissao; 
			}
			
			$infob[] = $movimentacao_tp_movimentacao;
			
			//DIA DE DESLIGAMENTO, numérico, 2 posições - Se o tipo de movimento for desligamento, informar o dia da saída do empregado, se for admissão deixar em branco.
			$movimentacao_dia_deslig            = str_pad(substr($movimentacao->data_demissao,0,2),2,"0");
			//echo "<br>Tipo:$tipo <br> Dia de Desligamento: $movimentacao_dia_deslig <br> Tipo Movimentação: $movimentacao_tp_movimentacao";
			$infob[] = $movimentacao_dia_deslig;
			
			//NOME DO EMPREGADO, caracter, 40 posições - Informar o nome do empregado movimentado.
			$movimentacao_nome_empregado        = trataTxt(substr($movimentacao->nome,0,40));
			$movimentacao_nome_empregado        = str_pad($movimentacao_nome_empregado, 40," ", STR_PAD_RIGHT);
			$infob[] = $movimentacao_nome_empregado;
			
			//NÚMERO DA CARTEIRA DE TRABALHO, numérico, 8 posições - Informar o número da carteira de trabalho e previdência social do empregado.
			$movimentacao_numero_ctps_numero    = trataTxt(substr($movimentacao->carteira_profissional_numero,0,40));
			$movimentacao_numero_ctps_numero    = str_pad($movimentacao_numero_ctps_numero, 8,"0", STR_PAD_LEFT);
			$infob[] = $movimentacao_numero_ctps_numero;
			
			//SÉRIE DA CARTEIRA DE TRABALHO, numérico, 4 posições - Informar o número de série da carteira de trabalho e previdência social do empregado
			$movimentacao_numero_ctps_serie     = trataTxt(substr($movimentacao->carteira_profissional_serie,0,4));
			$movimentacao_numero_ctps_serie     = str_pad($movimentacao_numero_ctps_serie, 4,"0", STR_PAD_LEFT);
			$infob[] = $movimentacao_numero_ctps_serie;
			
			//FILLER, caracter, 7 posições - Deixar em branco.
			$movimentacao_filler                = "       ";
			$infob[] = $movimentacao_filler;
			//RAÇA/COR, numérico, 1 posição - Informe a raça ou cor do empregado, utilizando os códigos:
			$movimentacao_casa_cor              = $movimentacao->cor;
			$infob[] = $movimentacao_casa_cor;
			// PORTADOR DE DEFICIÊNCIA, numérico, 1 posição - Informe se o empregado é portador de deficiência, utilizando:
		
			//1 - Para indicar SIM 
			//2 - Para indicar NÃO 
			$movimentacao_pess_def              = $movimentacao->possui_deficiencia;
			$infob[] = $movimentacao_pess_def;
			
			//CBO2000, numérico, 6 posições - Informe o código de ocupação conforme a Classificação Brasileira de Ocupação - CBO. Informar sem máscara(/.\-,).
			$movimentacao_cbo     = trataTxt(substr($movimentacao->cbo,0,4));
			$movimentacao_cbo     = str_pad($movimentacao_cbo, 6,"0", STR_PAD_LEFT);
			$infob[] = $movimentacao_cbo;
			
			//APRENDIZ, numérico, 1 posição - Informar se o empregado é Aprendiz ou não. (1 - SIM / 2 - NÃO) 
			$movimentacao_aprendiz              = $movimentacao->aprendiz;
			$infob[] = $movimentacao_aprendiz;
			
			//UF DA CARTEIRA DE TRABALHO, caracter, 2 posições - Informar a Unidade de Federação da carteira de trabalho e previdência social do empregado.
			//OBS: Quando se tratar de carteira de trabalho, novo modelo, para o campo série deve ser utilizado uma posição do campo uf, ficando obrigatoriamente a última em branco 
			$movimentacao_uf_ctps = trataTxt(substr($movimentacao->carteira_profissional_estado_emissor,0,4));
			$movimentacao_uf_ctps = str_pad($movimentacao_uf_ctps, 2," ", STR_PAD_LEFT);
			$infob[] = $movimentacao_uf_ctps;
			
			//TIPO DEFICIÊNCIA FÍSICA / BENEFICIÁRIO REABILITADO, caracter, 1 posição - Informe o tipo de deficiência do empregado, conforme as categorias abaixo, ou se o mesmo é beneficiário reabilitado da Previdência Social.
		
			//1 - Física
			//2 - Auditiva
			//3 - Visual
			//4 - Mental
			//5 - Múltipla
			//6 - Reabilitado 
			$movimentacao_tp_def_fisica         = $movimentacao->tipo_deficiencia;
			$infob[] = $movimentacao_tp_def_fisica;
			
			//CPF, numérico, 11 posições - Código Pessoa Física da Receita Federal.
			$movimentacao_cpf                   = trataTxt($movimentacao->cpf);
			$movimentacao_cpf                   = str_pad($movimentacao_cpf,11,"0",STR_PAD_LEFT);
			$infob[] = $movimentacao_cpf;
			
			//CEP RESIDÊNCIA TRABALHADOR, numérico, 8 posições - Informar o Código de Endereçamento Postal do trabalhador conforme a tabela da Empresa de Correios e Telégrafos-ECT. Informar sem máscara (/.\-,).
			
			$movimentacao_cep                   = trataTxt($movimentacao->funcionario_cep,0,9);
			$movimentacao_cep                   = str_pad($movimentacao_cep,8,"0",STR_PAD_LEFT);
			$infob[] = $movimentacao_cep;
			
			//FILLER, caracter, 81 posições. - Deixar em branco
			$movimentacao_filler                = str_pad(" ",81," ",STR_PAD_RIGHT);
			$infob[] = ("$movimentacao_filler\n");
			
		}//while
	}//foreach
}//while cliente fornecedor
	
	
	//TOTAL DE ESTABELECIMENTOS INFORMADOS, numérico, 5 posições - Quantidade de registros tipo B (Estabelecimento) informados no arquivo. 
	$autorizado_estab_informados = mysql_num_rows($clientes_fornecedores);
	$autorizado_estab_informados = str_pad($autorizado_estab_informados,5,"0",STR_PAD_LEFT);
	//TOTAL DE MOVIMENTAÇÕES INFORMADOS, numérico, 5 posições - Quantidade de registros tipo C e/ou X (Empregado) informados no arquivo.
	
	
	$autorizado_movim_informados = str_pad($numero_movimentacoes,5,"0",STR_PAD_LEFT);
	
	//A-Informações dos autorizados
	$info[] ="$autorizado_tipo_reg$autorizado_tipo_layout$autorizado_filler$autorizado_meio_mag$autorizado_competencia_mes$autorizado_competencia_ano$autorizado_alteracao$autorizado_sequencia$autorizado_tipo_ident$autorizado_numero_ident$autorizado_nome$autorizado_endereco$autorizado_cep$autorizado_uf$autorizado_telefone_ddd$autorizado_telefone$autorizado_ramal$autorizado_estab_informados$autorizado_movim_informados$autorizado_filler2$autorizado_filler3\n";
	
	foreach($infob as $b){
		$info[] = $b;
	}
	
	
	$infos = implode("",$info);
	$infos = strtoupper($infos);
	
   	$file = "arquivo_caged.re";
	@unlink("$file");
	$handle = fopen($file, 'a');
	fwrite($handle,$infos);
	fclose($handle);

	$i =date("Ymdhis");
	
	header('Content-type: octet/stream');
    header('Content-disposition: attachment; filename="'.basename($file).'";');
    header('Content-Length: '.filesize($file));
    readfile($file);
	
	//echo "<script>location='$file?$i'";
	exit();

?>