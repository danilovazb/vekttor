<?
function trataTxt($var) {

	$var = strtolower($var);
	
	$var = preg_replace("[áàâãª]","a",$var);	
	$var = preg_replace("[éèê]","e",$var);	
	$var = preg_replace("[í]","e",$var);	
	$var = preg_replace("[óòôõº]","o",$var);	
	$var = preg_replace("[úùûü]","u",$var);	
	$var = str_replace("ç","c",$var);
	
	return $var;
}

$t="SELECT
	m.data_criacao,
	m.fatura_boleto,
	m.id matricula_id,
	m.pago matricula_pago, 
	m.sala_id sala,
	m.tipo_matricula tipo,
	m.sala_id,
	m.responsavel_id,
	m.aluno_id,
	m.escola_id,
	m.curso_id,
	m.valor,
	cf.razao_social,
	cf.cnpj_cpf,
	ea.cpf as aluno_cpf,
	date(m.data_vencimento) as data_vencimento,
	date(m.data_criacao) as data_criacao
FROM
	escolar_matriculas m,
	cliente_fornecedor cf,
	escolar_alunos ea
WHERE
	m.pago LIKE 'S'
AND
	m.aluno_id=ea.id
AND
    m.responsavel_id=cf.id	
";
 
if(!empty($_GET[escola_id])){
  	$t.="AND m.escola_id='{$_GET[escola_id]}'";
}
if(!empty($_GET[cursos_id])){
	$t.=" AND m.curso_id='{$_GET[cursos_id]}'";
}
if(!empty($_GET[de])&&!empty($_GET[ate])){
	$t.=" AND m.data_criacao BETWEEN '".DataBrToUsa($_GET[de])."' AND '".DataBrToUsa($_GET[ate])."'";
}
if(!empty($_GET[horario])){
	$t.=" AND m.horario_id='{$_GET[horario]}'";
}
if(!empty($_GET[sala])){
	$t.=" AND m.sala_id='{$_GET[sala]}'";
}
if(!empty($_GET[modulo])){
	$t.=" AND m.modulo_id='{$_GET[modulo]}'";
}
//alert($t);
$q=mysql_query($t) or die ( mysql_error());

$alteralinha ="0";
	$info[] = strtoupper("Número do título;Cod. Aluno;Cod. Resp;CPF Aluno;Nome Aluno;Data de Vencimento;Valor do Título;Curso;Escola;Nome Resp.;CPF Resp;Data Emissao\n");
  while( $r=mysql_fetch_object($q)){
	  /*
	 Nosso Número
	 Número no Banco
	 Número do título
	 Cliente
	 Data de emissão
	 Data do vencimento
	 Vencimento Real 
	 Valor do Título*/
	 $aluno = mysql_fetch_object(mysql_query("SELECT * FROM escolar_alunos WHERE id ='$r->aluno_id'"));
	 $responsavel = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id ='$r->responsavel_id'"));
	 $curso = mysql_fetch_object(mysql_query("SELECT * FROM escolar_cursos WHERE id ='$r->curso_id'"));
	 $escola = mysql_fetch_object(mysql_query("SELECT * FROM escolar_escolas WHERE id ='$r->escola_id'"));
	 $bolsista = @mysql_result(mysql_query("SELECT * FROM escolar_alunos_bolsistas WHERE codigo_totvs ='$r->cod'"),0,0);
	if($bolsista>0){
		$valor = $r->valor_bolsista;
	}else{
		$valor = $r->valor;
	}
	
	$cpf = $r->aluno_cpf;
	//alert(strlen($cpf));
	if(!(strlen($cpf)>1)){
		//alert('passou');
		$cpf = $r->cnpj_cpf;
	}
	
	$cpf = str_replace(".","",$cpf);
	$cpf = str_replace("-","",$cpf);
	
	$cpf_responsavel = str_replace(".","",$r->cnpj_cpf);
	$cpf_responsavel = str_replace("-","",$cpf_responsavel);
	$cpf = str_pad($cpf,11,0,STR_PAD_LEFT);
	$cpf_responsavel = str_pad($cpf_responsavel,11,0,STR_PAD_LEFT);
	
		
	$boleto = $sis['geral']['nosso_numero']+$r->matricula_id;
	
	$boleto2 = 90000000+$r->matricula_id;
	
	$info[] = strtoupper(trataTxt("$boleto2;$r->aluno_id;$responsavel->id;$cpf;$aluno->nome;$r->data_vencimento;".MoedaUsaToBr($r->valor).";$curso->nome;$escola->nome;$r->razao_social;$cpf_responsavel;$r->data_criacao\n"));
	 
  }
  
	$infos = implode("",$info);
	
	$file = "modulos/escolar/exportacao/muraki_boletos.csv";
	@unlink("$file");
	$handle = fopen($file, 'a');
	fwrite($handle,$infos);
	fclose($handle);

	$i =date("Ymdhis");
	echo "<script>location='$file?$i'</script>";


//}
?><table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	
	
      <td></td>
        </tr>
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td></td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'>
</div>