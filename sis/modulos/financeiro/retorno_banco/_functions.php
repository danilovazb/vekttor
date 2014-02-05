<?php

$tabela = "financeiro_arquivo_retorno";


/*
[ok] Recebe o Arquivo

[ok] registra no banco de dados do retorno o tipo de retorno

[ok] Muda o nome do arquivo de acordo com o id do banco de dados

[ok]abre o arquivo

[ok]Para todos os boletos com 700000 ou 800000


Verifica a idade do aluno 

Se nao tem Sala para o horario solicitado Cadastra uma sala

	caso tenha

Coloca o aluno na sala cadastrada ou não de acordo com a idade ou na nova sala

[ok]da como matricula paga 
*/


// Controlador

function cadastra () {
	
	global $tabela,$vkt_id;
	
	if($_FILES[arquivo]){
		$arquivo = $_FILES["arquivo"]["name"];
		$caminho = "modulos/financeiro/retorno_banco/arquivos_retorno/";
		$caminho_completo = $caminho.$arquivo;
		if(move_uploaded_file($_FILES['arquivo']['tmp_name'], $caminho_completo)){
			$f = file($caminho_completo);
			$count_f= count($f);
			mysql_query ("INSERT INTO financeiro_arquivo_retorno SET data_hora=now(),tipo = '{$_POST['tipo']}', vkt_id = '$vkt_id',nome_arquivo='$arquivo'");
			$arquivo_id = mysql_insert_id();
			$novo_caminho_completo=$caminho.$arquivo_id.'.ret';
			rename($caminho_completo,$novo_caminho_completo);
			$f='';
			$count_f='';

			switch ($_POST['tipo']){
				case "cef":
					arquivoRetornoCaixa($novo_caminho_completo);
					break;
				
				case "bb":
					arquivoRetornoBB($novo_caminho_completo,$arquivo_id);
					break;
				case "Bradesco":
					arquivoRetornoBradesco($novo_caminho_completo,$arquivo_id);
					break;
					
				default:
					break;
			}
		
		}else{
			alert('erro ao enviar arquivo:'.$caminho_completo)	;
		}
	}
	
}



function arquivoRetornoBB ($file,$importacao_id) {
	global $vkt_id;
	
	/*
	*	Abre arquivo e procura pelas seguintes posições (iniciando pelo 0):
	*	Posição 0 (Tipo de linha) deve ser tipo 7
	*	Posição 46 (Nosso numero) identificador do boleto
	*/

	$handler = fopen($file, "rb");
	$contents = "";
	$pagos = 0;
	
	if(!$handler) {
		echo "Falha ao abrir arquivo.";	
	} else {
		mysql_query("UPDATE escolar_matriculas SET pago = 'C' WHERE data_vencimento <DATE(NOW()) AND pago != 'S' AND vkt_id='$vkt_id'");
	//	echo "1 - Atualizou os antes de hoje para cancelado<br>";
		while (($buffer = fgets($handler)) !== false) {
			$item = substr($buffer, 1, 1);
			if( trim($item) == "7" ){ 

				$INFOMARIO = trim(substr($buffer, 10, 11), "0");
				$id = trim(substr($buffer, 10, 11), "0") - 90000000;
				$fatura_boleto = trim(substr($buffer, 10, 11), "0");
				//echo "2.1 - abrio o id 8 $id ($fatura_boleto)<br>";
				$valor = substr($buffer, 100, 6);
				
				if($id<0){
				  $id = trim(substr($buffer, 10, 11), "0") - 7000000;
					//echo "2.2 - abrio o idfoi menor que 0 buscou o 7 $id <br>";
				}

				if($id>0){
					//echo "2.3 - Entrou na confirmação com o id $id <br>";

					$matricula_query = mysql_query("SELECT * FROM escolar_matriculas WHERE id = '$id'");
					$matricula_obj = mysql_fetch_object($matricula_query);
					//echo "2.3 - Abriu a matricula  ($matricula_obj->id) no horario $matricula_obj->horario_id <br>";
					
					$sala_id=cria_salas($matricula_obj->horario_id);
					//echo "4 - Vai Usar a Sala ($sala_id) <br>";
					
				  if($matricula_obj->sala_id == 0){
				
					mysql_query($t ="UPDATE escolar_matriculas SET sala_id = '$sala_id', pago = 'S', valor_pago='".moedaBrToUsa($valor)."',arquivo_retorno_id='$importacao_id',fatura_boleto='$fatura_boleto' WHERE id = '$id'");
						//echo "5 - Viu que a matricula ainda não tinha sala e colocou a matricula nessa sala ($sala_id) <br> $t <br>";
				  }else{
					mysql_query($t ="UPDATE escolar_matriculas SET  pago = 'S', valor_pago='".moedaBrToUsa($valor)."',arquivo_retorno_id='$importacao_id',fatura_boleto='$fatura_boleto' WHERE id = '$id'");
						//echo "5 - Viu que a matricula ainda <strong>já</strong> tinha sala e colocou a matricula nessa sala ($sala_id) <br> $t <br>";
				  }
					$pagos++;
				}
		}
		}
		fclose($handler);
					//echo "6 - Contou o total de matriculas ($pagos) <br>";
		
		mysql_query($t="UPDATE financeiro_arquivo_retorno SET matriculas='$pagos' WHERE id='$importacao_id'");
					//echo "7 - Atualizou o registro do arquivo com  ($pagos) pagos com o sql <br>$t <br><br><br>";
	//	echo $t.'<br>';
		//echo 'Atualizaou o status do arquivo<br>';
	}
}

function cria_salas($horario_id){
	global $vkt_id;
	//echo "((($horario_id)))";
	//echo "3 - Entrou no criasala com o horario_id ($horario_id) <br>";
	$query_salas= mysql_query($t="SELECT * FROM escolar_salas 
							  WHERE 
								  horario_id = '$horario_id' ");
								  
	$salas = mysql_num_rows($query_salas);
	//echo "3.1 - Contou quantas salas tem para esse horario ($salas) <br>";
  
  	$horario = mysql_fetch_object(mysql_query("SELECT * FROM escolar_horarios WHERE id = '$horario_id'"));
	//print_r($horario);
  	$vagas = $horario->qtde_salas;
	//echo "3.2 - Selecionou o horario ($horario->id) e definiu quantidade de salalas totais ($vagas) <br>";
  	
	
  	if($salas == 0) {
		$t ="INSERT INTO escolar_salas SET vkt_id='$vkt_id', curso_id = '$horario->curso_id', modulo_id = '$horario->modulo_id', escola_id = '$horario->escola_id', horario_id = '$horario->id', nome = 'Sala 1 '";
		$cadastra_primeira_sala = mysql_query($t);
		$sala_id = mysql_insert_id();	
		//echo "3.3 - Viu que não tinha nenhuma sala e Criou a 'Sala 1'  ($sala_id) <br>";
		return $sala_id;
  	}else{
		$consulta_ultima_sala = mysql_query("SELECT * FROM escolar_salas 
											WHERE 
												horario_id = '$horario->id' 
											ORDER BY id DESC LIMIT 1");
		
		$consulta_ultima_sala_dados = mysql_fetch_object($consulta_ultima_sala);
		//echo "3.3 - Viu que ja tinha abriu a ultima sala crida com o nome ($consulta_ultima_sala_dados->nome) a sala_id  ($sala_id) <br>";
		
		$consulta_alunos_na_sala = @mysql_result(mysql_query($t= "SELECT count(*) FROM escolar_matriculas 
																WHERE
																	sala_id = '$consulta_ultima_sala_dados->id'"), 0);
		//echo "3.4 - Contou quantos alunos tinham matriculados na sala nome ($consulta_ultima_sala_dados->nome id $consulta_ultima_sala_dados->id )  ($consulta_alunos_na_sala) alunos <br>";
		$vagas_livres = $vagas - $consulta_alunos_na_sala;
		
		//echo "3.5 - Verificou quantas vagas ainda tinham disponiveis ($vagas_livres) pois Existiam ($vagas) vagas e  já tinham se matriculados ($consulta_alunos_na_sala)<br>";
		if($vagas_livres < 1) {
			

			$nome_da_sala = "Sala ".($salas + 1).' * ';
			mysql_query($t ="INSERT INTO escolar_salas SET vkt_id='$vkt_id', curso_id = '$horario->curso_id', modulo_id = '$horario->modulo_id', escola_id = '$horario->escola_id', horario_id = '$horario->id', nome = '$nome_da_sala'");
			$sala_id = mysql_insert_id();
			//echo "3.6 - Viu que não tinha mais vaga e criou uma nova sala nome ($nome_da_sala) com o id ($sala_id)<br>";
			return $sala_id;
			
		} else {
			$sala_id = $consulta_ultima_sala_dados->id;
			return $sala_id;
			//echo "3.7 - Viu que ainda tinha vaga na sala e retornou a sala ($consulta_ultima_sala_dados->nome) com o id ($sala_id)<br>";
		
		
		}
	}

	
}

function arquivoRetornoCaixa ($file) {
	
	/*
	*	Abre arquivo e procura pelas seguintes posições (iniciando pelo 0):
	*	Posição 13 (Segmento do "detalhe") deve ser tipo T
	*	Posição 46 (Nosso numero) identifi cador do boleto
	*/

	$handler = fopen($file, "rb");
	$contents = "";
	$pagos = 0;
		
	if(!$handler) {
		echo "Falha ao abrir arquivo.";	
	} else {
		
		while (($buffer = fgets($handler)) !== false) {
			
			$tipo = substr($buffer, 13, 1);
			
			if( $tipo == "T" ){ 
			
				$codigo = substr($buffer, 46, 11);
				$id = $codigo - $sis['geral']['nosso_numero'];
				$query = mysql_query("SELECT * FROM matriculas WHERE id = '$id'")or die(mysql_error());		
						
				if( mysql_num_rows($query) > 0 ){
					$query2 = mysql_query("UPDATE matriculas SET pago = 'S' WHERE id = '$id'");
					$pagos++;
				}
			}
		}
		fclose($handler);
		
		return $pagos;
	}
}

?>