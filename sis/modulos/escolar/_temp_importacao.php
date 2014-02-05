<pre><?
//include("../../_config.php");
include("../../_functions_base.php");
include("_tem_functions.php");

$host		= 'localhost';
$login_bd	= 'root';
$senha_bd	= '001236';
$bd			= 'muraki_inscricoes';



mysql_connect($host,$login_bd,$senha_bd)or die("nao conectou");
mysql_select_db($bd)or die("nao acessiy");


function validaCPF($cpf){	// Verifiva se o número digitado contém todos os digitos
	
	// Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
    if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999'){
		return false;
    }else{   // Calcula os números para verificar se o CPF é verdadeiro
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;

            if ($cpf{$c} != $d) {
                return false;
            }
        }

        return true;
    }
}

$q = mysql_query("SELECT * FROM matriculas as m,alunos  as a WHERE m.aluno_id=a.id AND pago = 'S' ");

while($r=mysql_fetch_object($q)){
	$xx++;
	$i=1;
	if(strlen($r->resp_cpf) > 0){
		$dados['f_nome_contato'] 	= $r->resp_nome ;
		$dados['f_nascimento']		= dataUsaToBr($r->resp_data_nascimento) ;
		$dados['f_cnpj_cpf']		= $r->resp_cpf;
		$dados['f_rg']				= $r->resp_rg ;
		$dados['f_data_emissao']	= dataUsaToBr($r->resp_rg_dt_expedicao) ;
		$dados['f_email']			= $r->email ;
		$dados['f_telefone1']		= $r->telefone1 ;
		$dados['f_telefone2']		= $r->telefone2;
		$dados['f_cep']				= $r->resp_cep ;
		$dados['f_endereco']		= $r->resp_endereco ;
		$dados['f_bairro']			= $r->resp_bairro ;
		$dados['f_cidade']			= $r->resp_cidade ;
		$dados['f_estado']			= $r->resp_uf ;
		
	}else{
		$dados['f_nome_contato'] 	= $r->nome;
		$dados['f_ramo_atividade'] 	= $r->profissao ;
		$dados['f_nascimento']		= dataUsaToBr($r->data_nascimento) ;
		$dados['f_cnpj_cpf']		= $r->cpf;
		$dados['f_rg']				= $r->rg;
		$dados['f_data_emissao']	= dataUsaToBr($r->rg_dt_expedicao) ;
		$dados['f_email']			= $r->email;
		$dados['f_telefone1']		= $r->telefone1 ;
		$dados['f_telefone2']		= $r->telefone2 ;
		$dados['f_cep']				= $r->cep ;
		$dados['f_endereco']		= $r->endereco ;
		$dados['f_bairro']			= $r->bairro ;
		$dados['f_cidade']			= $r->cidade;
		$dados['f_estado']			= $r->uf;
		$dados['f_grau_instrucao']	= $r->escolaridade ;
	}
	
	$dados['nome'][$i]				= $r->nome;
	$dados['data_nascimento'][$i]	= dataUsaToBr($r->data_nascimento);
	$dados['endereco'][$i]			= $r->endereco;
	$dados['bairro'][$i]			= $r->bairro;
	$dados['complemento'][$i]		= $r->complemento ;
	$dados['telefone1'][$i]			= $r->telefone1;
	$dados['telefone2'][$i]			= $r->telefone2;
	$dados['cep'][$i]				= $r->cep;
	$dados['cidade'][$i]			= $r->cidade;
	$dados['uf'][$i]				= $r->uf;
	$dados['rg'][$i]				= $r->rg;
	$dados['rg_dt_expedicao'][$i]	= dataUsaToBr($r->rg_dt_expedicao);
	$dados['cpf'][$i]				= $r->cpf;
	$dados['email'][$i]				= $r->email;
	$dados['profissao'][$i]			= $r->profissao;
	$dados['escolaridade'][$i]		= $r->escolaridade;
	
	
	
	$dados[periodo_id][$i] 			= 1;
	$dados[escola_id][$i]			= $r->escola_id;
	$dados[curso_id][$i]			= $r->curso_id;
	$dados[modulo_id][$i]			= $r->modulo_id;
	$dados[horario_id][$i]			= $r->horario_id;
	$dados[sala_id][$i]				= $r->sala_id;
	$dados[data_vencimento][$i]		= $r->data_vencimento ;
	$dados[tipo_matricula][$i]		= $r->tipo_matricula;
	$dados[valor][$i]				= 0;
	$dados[data_criacao][$i]		= $r->data_criacao;
	
	$responsavel_id = manipulaResponsavel($dados,7,0);
	if($responsavel_id>0){
		$aluno_id = mantem_matricula ($responsavel_id,$dados,$i);

	}
	
	print_r($dados);
}



?></pre>



