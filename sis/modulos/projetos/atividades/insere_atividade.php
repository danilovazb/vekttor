<?
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
include("_function_atividade.php");
$ord=$_GET['ultima_posicao']+1;


$sql=" INSERT INTO projetos_atividades 
	SET nome ='". urldecode($_GET['atividade'])."', 
	tempo_estimado_horas='{$_GET['tempo']}', 
	vkt_id='$vkt_id',
	projeto_id = '{$_GET['projeto_id']}',
	atividade_tipo_id = '{$_GET['tipo_atividade_id']}',
	funcionario_id   = '{$_GET['funcionario_id']}',
	ordenacao_principal='$ord',
	ordenacao_funcionario='$ord',
	usuario_id_cadastrou='$usuario_id',
	data_cadastro=now()
	";
	$projeto = mf(mq("SELECT * FROM projetos WHERE id='{$_GET[projeto_id]}'"));

	$msg = 
"Nova Atividade : ".urldecode($_GET['atividade'])." em ".date("d/m/Y H:m")."
Em: ".$projeto->nome."
Por: ".$_SESSION[usuario]->login."
";
registra_atividade($_GET['funcionario_id'],$msg,urldecode($_GET['atividade']));
mysql_query($sql);
//echo $sql;
//pr($_GET);

$projetos_atividades_id=  mysql_insert_id();
$projeto_nome=mysql_fetch_object(mysql_query("SELECT nome FROM projetos WHERE id='{$_GET['projeto_id']}'"));
$atividade_tipo=mysql_fetch_object(mysql_query("SELECT nome FROM projetos_atividades_tipos WHERE id='{$_GET['tipo_atividade_id']}'"));
$funcionario=mysql_fetch_object(mysql_query("SELECT nome FROM usuario WHERE id='{$_GET['funcionario_id']}'"));


?>
<script>
	
	tabela=top.document.getElementById('tabela_dados').getElementsByTagName('tbody')[0];
	primeira_linha=tabela.getElementsByTagName('tr');
	var novo_elemento = top.document.createElement('tr');
	
	novo_elemento.setAttribute('id',"<?=$projetos_atividades_id?>");
	nome_atividade=top.document.getElementById('atividade_nova').value;
	tempo_estimado=top.document.getElementById('tempo_estimado').value;
	
	var novo_td=top.document.createElement('td');
	var nova_horas=top.document.createElement('td');
	var novo_dado=top.document.createElement('td');
	var novo_funcionario=top.document.createElement('td');
	
	novo_td.setAttribute('width','20')
	nova_horas.setAttribute('width','50')
	novo_dado.setAttribute('width','500')
	novo_funcionario.setAttribute('width','120')
	
	novo_elemento.appendChild(novo_td);
	novo_elemento.appendChild(nova_horas);
	novo_elemento.appendChild(novo_dado);
	novo_elemento.appendChild(novo_funcionario);
	novo_elemento.appendChild(top.document.createElement('td'));
	
	
	novo_dado.innerHTML="<span>"+nome_atividade+"</span>";
	nova_horas.innerHTML=tempo_estimado;
	novo_funcionario.innerHTML="<?=$funcionario->nome?>";
	
	tabela.appendChild(novo_elemento);
	trs=top.document.getElementById('tabela_dados').getElementsByTagName('tr');
	for(var i=0;i<trs.length;i++){
		if(i%2==0){
			trs[i].className='al';
		}else{
			trs[i].className='';
		}
	}
	top.document.getElementById('atividade_nova').value='';
	top.document.getElementById('ultima_posicao').value='<?=$ord?>';
	top.document.getElementById('atividade_nova').focus();
</script>