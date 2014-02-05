<?
//Includes
// configuraчуo inicial do sistema
include("../../../_config.php");
// funчѕes base do sistema
include("../../../_functions_base.php");

//Array nome do эndice de acordo com sistema vekttor
//Array valor do эndice de acordo com a caixa econєmica federal
$grau_instruncao = array("1"=>"8","2"=>"1","3"=>"1","4"=>"1","5"=>"2","6"=>"3","7"=>"4","8"=>"5","9"=>"6","10"=>"7","11"=>"7","12"=>"7");
$empresa =  mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id=".$_GET['empresa_id']));
$funcionarios_empresa = mysql_query($t="SELECT * FROM rh_funcionario WHERE empresa_id='".$_GET['empresa_id']."' AND status='admitidos'");
		$info[]=strtoupper("Arquivo CEF\n");
		$info[]=strtoupper("Empresa: $empresa->razao_social\n");
		$info[]=strtoupper("Copie e cole o conteњdo abaixo na planilha da Caixa Econєmica Federal\n");
		/*$info[]=strtoupper("NOME COMPLETO;NOME REDUZIDO;CPF;PIS;Cart. Trab com sщrie;Data de NASCIMENTO;Local de nascimento;UF NASCIMENTO;ESTADO CIVIL;NOME DO CONJUGE;PAI;MУE;SEXO;DOC (RG);");
		$info[]=strtoupper("NUMERO;DOCUMENTO;EMISSOR;DOC;UF;DOC (Data de emissуo);OCUPACAO;DATA DE ADMISSAO;ENDERECO (Rua, Av, etc);BAIRRO;MUNICIPIO;UF;CEP;DDD;TELEFONE;e-mail;Grau de instruчуo;");
		$info[]=strtoupper(	"RENDA VALOR;Conta Destino;Banco;Conta Destino;Agъncia;Conta Destino;Conta;Conta Destino;DV da Conta\n");*/
		while($funcionario = mysql_fetch_object($funcionarios_empresa)){
			$estado_nascimento = mysql_fetch_object(mysql_query("SELECT * FROM cep WHERE cidade='$funcionario->cidade'"));
			
			$info[]=strtoupper("$funcionario->nome;$funcionario->nome;$funcionario->cpf;$funcionario->pis;$funcionario->carteira_profissional_numero - $funcionario->carteira_profissional_serie;".DataUsaToBr($funcionario->data_nascimento).";");
			$info[]=strtoupper("$funcionario->naturalidade;$estado_nascimento->estado;$funcionario->estado_civil;$funcionario->nome_conjugue;$funcionario->filiacao_pai;$funcionario->filiacao_mae;$funcionario->sexo;");
			$info[]=strtoupper("$funcionario->rg;".substr($funcionario->rg_orgao_emissor,0,3).";".substr($funcionario->rg_orgao_emissor,6,2).";".$funcionario->rg_data_emissao.";$funcionario->cargo;".DataUsaToBr($funcionario->data_admissao).";$funcionario->endereco;");
			$info[]=strtoupper("$funcionario->bairro;$funcionario->cidade;$funcionario->estado;$funcionario->cep;".substr($funcionario->telefone1,1,2).";".substr($funcionario->telefone1,4).";");
			$info[]=strtoupper("$funcionario->email;".$grau_instruncao[$funcionario->grau_instrucao].";$funcionario->salario;$funcionario->conta_bancaria\n");
			
		}
		
		$infos = implode("",$info);
		$infos = strtoupper($infos);
	
   		$file = "CEF.csv";
		@unlink("$file");
		$handle = fopen($file, 'a');
		fwrite($handle,$infos);
		fclose($handle);

		$i =date("Ymdhis");
	
		header('Content-type: octet/stream');
    	header('Content-disposition: attachment; filename="'.basename($file).'";');
    	header('Content-Length: '.filesize($file));
    	readfile($file);
?>