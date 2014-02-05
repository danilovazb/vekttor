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
			a.id as cod,
			a.nome,
			a.endereco,
			a.bairro ,
			a.cidade,
			a.uf,
			a.cep,
			a.telefone1,
	a.cpf aluno_cpf,
	a.email,
	cf.razao_social,
	cf.cnpj_cpf
FROM
	escolar_matriculas m,
	escolar_alunos a,
	escolar_cursos c,
	escolar_modulos md,
	escolar_escolas e,
	escolar_horarios h,
	escolar_periodos p,
	cliente_fornecedor cf
WHERE
	a.id = m.aluno_id AND
	c.id = m.curso_id AND
	md.id = m.modulo_id AND
	e.id = m.escola_id AND
	h.id = m.horario_id  AND
	p.id = m.periodo_id AND
	m.responsavel_id=cf.id AND
	a.vkt_id='$vkt_id' AND
    m.pago LIKE 'S'  
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
//echo $t; 
$q=mysql_query($t) or die ( mysql_error() );

  $alteralinha ="0";
	 $info[] = strtoupper("Codigo;Codigo Resp;Nome;Endereco;Bairro;Cidade;UF;CEP;Telefone;CPF;Email;Nome Resp;CPF Resp\n");
  while($r=mysql_fetch_object($q)){
	  
	  $cpf = str_replace(".","",$r->aluno_cpf);
	  $cpf = str_replace("-","",$cpf);
	  
	    
	 $info[] = strtoupper(trataTxt("$r->cod;$r->responsavel_id;$r->nome;$r->endereco;$r->bairro;$r->cidade;$r->uf;$r->cep;$r->telefone1;$cpf;$r->email;$r->razao_social;$r->cnpj_cpf\n"));	 
  }
  
	$infos = implode("",$info);
	
	$file = "modulos/escolar/exportacao/muraki_aluno_matriculados.csv";
	@unlink("$file");
	$handle = fopen($file, 'a');
	fwrite($handle,$infos);
	fclose($handle);

	$i =date("Ymdhis");
	echo "<script>location='$file?$i'</script>";
	exit();					
?>