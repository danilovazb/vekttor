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
			r.id,
			r.nome_fantasia,
			r.endereco,
			r.bairro,
			r.cidade,
			r.estado,
			r.cep,
			r.telefone1,
	r.cnpj_cpf responsavel_cpf,
	r.email
FROM
	escolar_matriculas m,
	cliente_fornecedor r,
	escolar_cursos c,
	escolar_modulos md,
	escolar_escolas e,
	escolar_horarios h
WHERE
	r.id = m.responsavel_id AND
	c.id = m.curso_id AND
	md.id = m.modulo_id AND
	e.id = m.escola_id AND
	h.id = m.horario_id AND
	m.pago LIKE 'S'
	GROUP BY m.responsavel_id
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
$q=mysql_query($t) or die ( mysql_error());

  $alteralinha ="0";
	 $info[] = strtoupper("Codigo;Nome;Endereco;Bairro;Cidade;UF;CEP;Telefone;CPF;Email\n");
  while( $r=mysql_fetch_object($q)){
	
	  $cpf = str_replace(".","",$r->responsavel_cpf);
	  $cpf = str_replace("-","",$cpf);
	
	 $info[] = strtoupper(trataTxt("$r->id;$r->nome_fantasia;$r->endereco;$r->bairro;$r->cidade;$r->estado;$r->cep;$r->telefone1;$cpf;$r->email\n"));
	 
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
