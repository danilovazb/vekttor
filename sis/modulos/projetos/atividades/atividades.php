<?
// funções do modulo empreendimento
include("_function_atividade.php");
include("_ctrl_atividade.php"); 
//echo "<pre>";
//print_r($_POST);
//echo "</pre>";


?>
<style>
#formstar{width:23px; height:30px; float:left; margin-right:5px; cursor:pointer}
.star{ background:url(../fontes/img/st.png);  width:23px; height:30px; float:left; margin-right:10px;}
#tabela_dados td{ height:30px; line-height:30px;}
#tabela_dados tr td:nth-child(2){ text-align:right; padding-left:0; padding-right:10px}
tbody tr:hover td{background-image:none; background:#F0F0F0; color:#000;}
.redb td{ color:#F00}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />

<div id='conteudo'>
<div id='carregaform2' class='exibe_formulario'></div>
<div id='navegacao'>
	<div id="some">»</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
<a href="?" class='s2'>
  	Controle de Atividades
</a>
<a href="?tela_id=92" class='navegacao_ativo'>
<span></span>    <?=$tela->nome?>
</a>
</div>

<script>
$(".opt").live("click",function(){
	window.open("<?=$tela->caminho?>/form_tempo.php?id="+$(this).attr('i'),'carregador')
	
	})
$(".selhora").live("click",function(){
	valor = $(this).val();
	if(valor=='fim'){
		$("#tempo").attr("disabled", "disabled");
		$("#df").removeAttr('disabled');
		$("#hf").removeAttr('disabled');

	}else{
		$("#tempo").removeAttr('disabled');
		$("#df").attr("disabled", "disabled");
		$("#hf").attr("disabled", "disabled");
	}
	
});
	
$("#formstar").live("click",function(){
	val =$(this).find("input").val();
	
	if(val=='0'){
		$(this).find("input").val('1');
		$(this).css('background','url(../fontes/img/st.png)')	
	}else{
		$(this).find("input").val('0');
		$(this).css('background','url(../fontes/img/st2.png)')	
	}
});
$(document).ready(function(){
	var antes=[];
	
		$('#tabela_dados tr').each(function(){
			antes.push($(this).attr('id'));
		});
		//antes=antes.join(',');
		//alert("Antes"+antes);
		$('#tabela_dados').sortable({
			cursor:'move',
			opacity:0.6,
			update:function(){
				
				var ordem=$(this).sortable('toArray').join(',');
				//alert("Antes"+antes);
				//alert("Depois"+ordem);
				
				window.open('modulos/projetos/atividades/atualiza_ordem.php?ordem='+ordem+'&antes='+antes,'carregador');
				tabela = document.getElementById('tabela_dados');
				trs=tabela.getElementsByTagName('tr');
				for(var i=0;i<trs.length;i++){
					if(i%2==0){
						trs[i].className='al';
					}else{trs[i].className='';}
				}
			},
			items:'tr'
	});
		$('#tabela_dados').disableSelection();
})
$(".cr").live("click",function(){
	id = $(this.parentNode.parentNode).attr('id')

	if($(this).is(":checked")) {
		aprovado =1;
	}else{
		aprovado =0;
	}
	window.open("modulos/projetos/atividades/atualiza_aprovacao.php?atividade_id="+id+"&responsal_aprovou="+aprovado,'carregador');
	
	});


$("#formfiltro #projeto_id,#formfiltro #tipo_atividade_id,#formfiltro #funcionario_id,#formfiltro #status").live("change",function(){
	
	if($("#atividade_nova").val()=='Nova Atividade' ||$("#atividade_nova").val()==''){
		$("#formfiltro").submit();
	}
});

</script>
<div id="barra_info">
<form method="get" id='formfiltro'>
<input type="hidden" name="tela_id" value="92" />
<!-- select na tabela projetos -->

<select name="projeto_id" id='projeto_id' >
<?php 
	if(strlen($_GET['projeto_id'])>0){$projeto_id= $_GET['projeto_id'];}
	if(strlen($_POST['projeto_id'])>0){$projeto_id=$_POST['projeto_id'];}
	$cliente_forecedor = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='$usuario_cliente_fornecedor_id'"));

	if($cliente_forecedor->tipo== 'Cliente'){
		$qp_add= " and cliente_fornecedor_id='$usuario_cliente_fornecedor_id' ";
	}
	$sql = mysql_query("SELECT * FROM projetos where vkt_id='$vkt_id' $qp_add ORDER BY nome ");
	
		while($p=mysql_fetch_object($sql)){
		if($projeto_id==$p->id){$projeto_sel='selected="selected"';}else{$projeto_sel='';}
?>
	<option <?=$projeto_sel?> value="<?php echo $p->id;?>"><?php echo $p->nome;?></option>
<?php 	}
		if($projeto_id=='0'){$projeto_sel='selected="selected"';}else{$projeto_sel='';}
?>
	<option <?=$projeto_sel?> value="0">Todos os Projetos</option>

</select>

<!-- select na tabela projetos_atividades_tipos -->
<select name="tipo_atividade_id" id='tipo_atividade_id' >
<? 
	$sql = mysql_query("SELECT * FROM projetos_atividades_tipos WHERE vkt_id='$vkt_id'");
	
		while($ptt=mysql_fetch_object($sql)){
		if($_GET['tipo_atividade_id']==$ptt->id||$_POST[tipo_atividade_id]==$ptt->id){$ptt_sel='selected="selected"';}else{$ptt_sel='';}
?>
	<option <?=$ptt_sel?> value="<?=$ptt->id;?>"><?=$ptt->nome; ?></option>
<? }?>
</select>

<!-- select na tabela usuarios -->
<select name="funcionario_id" id='funcionario_id' >
<option value="0">Todos os Funcionário</option>
<? 
	$sql = mysql_query("SELECT * FROM usuario WHERE cliente_vekttor_id='$vkt_id' ");
	
		while($u=mysql_fetch_object($sql)){
		if($_GET['funcionario_id']==$u->id||$_POST['funcionario_id']==$u->id){$usuario_sel='selected="selected"';}else{$usuario_sel='';}
?>
	<option <?=$usuario_sel?> value="<?=$u->id;?>"><?=$u->nome; ?></option>
<? }?>
<? $ultimo_q=mysql_fetch_object(mysql_query("SELECT MAX(ordenacao_principal) as ord FROM projetos_atividades")); ?>
</select>
<select name="status" id='status' >
    <option <? if($_GET['status']=='99'){echo 'selected';} ?> value="99">Status</option>
    <option <? if($_GET['status']=='0'){echo 'selected';} ?> value="0">Para ser Executada</option>
    <option <? if($_GET['status']=='3'){echo 'selected';} ?> value="3">Em Espera por alguem</option>
    <option <? if($_GET['status']=='2'){echo 'selected';} ?> value="2">Em Andamento</option>
    <option <? if($_GET['status']=='1'){echo 'selected';} ?> value="1">Completo</option>
    <option <? if($_GET['status']=='10'){echo 'selected';} ?> value="10">Não Conferidos</option>
    <option <? if($_GET['status']=='11'){echo 'selected';} ?> value="11">Conferidos</option>
</select>
<input type="hidden" name="ultima_posicao" value="<?=$ultimo_q->ord?>" />
<input type="submit" name="filtrar" value="Filtrar" />
</form>
</div>
<div id="barra_info">
<form id="nova_atividade">
<input type="text" id="atividade_nova" name="atividade_nova" value="Nova Atividade" size="80" onkeyup="if(event.keyCode==13)insereAtividade();" onfocus="if(this.value=='Nova Atividade')this.value=''" title='Aperte enter para cadastrar uma nova atividade' />
<input type="text" id="tempo_estimado" name="tempo_estimado" mascara="__:__" value="01:00" title='Tempo Estimado' sonumero='1' size="4" onkeyup="if(event.keyCode==13)insereAtividade();" onfocus="this.value=''" /> 

<span style="float:right; margin-right:10px;"><span style="color:#900"><?

	$atv = mysql_fetch_object(mysql_query($trace="
	SELECT 
		count(*) as total
		FROM 
			projetos_atividades 
		WHERE 
			vkt_id='$vkt_id' 
			AND
			funcionario_id = '$usuario_id'
			AND situacao='0' 
		"));
		
	echo $atv->total;	
?></span> <span style="color:#999;cursor:pointer;" onClick="location='?tela_id=96&projeto_id=<?=$_GET[projeto_id]?>'">Para Executar</span></span>


<span style="float:right; margin-right:10px;"><span style="color:#900"><?

	$atv = mysql_fetch_object(mysql_query($trace="
	SELECT 
		count(*) as total
		FROM 
			projetos_atividades 
		WHERE 
			vkt_id='$vkt_id' 
			AND
			usuario_id_cadastrou = '$usuario_id'
			AND situacao='1' AND aprovado_pelo_responsavel='0'
		"));
		
	echo $atv->total;	
?></span> <span style="color:#999; cursor:pointer;"onClick="location='?tela_id=92&projeto_id=0&tipo_atividade_id=0&funcionario_id=0&status=10'">Para aprovar</span></span>
</form>
</div>
<script>
function insereAtividade(){
	nome_atividade=document.getElementById('atividade_nova').value;
	tempo_estimado=document.getElementById('tempo_estimado').value;
	projeto_id=document.getElementById('projeto_id').value*1;
	tipo_atividade_id=document.getElementById('tipo_atividade_id').value*1;
	funcionario_id=document.getElementById('funcionario_id').value;
	ultima_posicao=document.getElementById('ultima_posicao').value*1;
	erro=0;
	if(projeto_id<1){erro++; document.getElementById('projeto_id').focus()}
	if(tipo_atividade_id<1){erro++;document.getElementById('tipo_atividade_id').focus()}
	if(funcionario_id<1){erro++;document.getElementById('funcionario_id').focus()}
	if(nome_atividade.length<3){erro++;document.getElementById('atividade_nova').focus()}
	
	if(erro>0){
		//	alert('Preencha os campos acima');
	}else{

	window.open('modulos/projetos/atividades/insere_atividade.php?atividade='+nome_atividade+'&tempo='+tempo_estimado+"&projeto_id="+projeto_id+"&tipo_atividade_id="+tipo_atividade_id+"&funcionario_id="+funcionario_id+'&ultima_posicao='+ultima_posicao,'carregador');
	}
}


$("#tabela_dados tr span").live("click",function(){
	var atividade_id = $(this.parentNode.parentNode).attr('id');
	if(atividade_id>0){
		window.open('<?=$tela->caminho?>/form.php?id='+atividade_id+'&oldstatus=<?=$_GET[status]?>','carregador');
	}
});

</script>
<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
        	<td width="20"></td>
          <td width="50">Tempo</td>
          <td width="600">Atividade</td>
          <td width="120">Funcionário</td>
          <td > Tempo que foi Cadastrada</td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados"  >
   <tbody >
	<?php 
	
	if(isset($_GET['projeto_id'])&&$_GET['projeto_id']!='0'){
		$filtro_projeto=" AND projeto_id='{$_GET['projeto_id']}' ";
	}
	
	if(isset($_GET['tipo_atividade_id'])&&$_GET['tipo_atividade_id']!='0'){
		$filtro_tipo_atividade=" AND atividade_tipo_id='{$_GET['tipo_atividade_id']}' ";
	}
	
	if(isset($_GET['funcionario_id'])&&$_GET['funcionario_id']!='0'){
		$filtro_funcionario=" AND funcionario_id='{$_GET['funcionario_id']}' ";
	}
	
	if(strlen($_GET['status'])>0&&$_GET['status']!='99'){
		$filtro_status=" AND situacao='{$_GET['status']}' ";
		if($_GET['status']==10){
			$filtro_status=" AND situacao='1' AND aprovado_pelo_responsavel='0'  ";
		}
		if($_GET['status']==11){
			$filtro_status=" AND situacao='1' AND aprovado_pelo_responsavel='1'  ";
		}
	}
	
			echo mysql_error();
	
	
	$q_total=mysql_fetch_object(mysql_query($trace="SELECT TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(tempo_estimado_horas))),'%H:%i') AS horas FROM projetos_atividades WHERE vkt_id='$vkt_id' $filtro_funcionario $filtro_projeto $filtro_tipo_atividade"));
	$projetoAnterior = '';
	$ordem_situacao = array(3,0,1,2);
	
	
	
	for($i=0;$i<4;$i++){
	
	
	$q = mysql_query($t="
	SELECT 
		*,
		TIME_FORMAT(tempo_estimado_horas,'%H:%i:00') as tempo ,
	DATEDIFF(NOW(),data_cadastro) as dias , 
	TIME_FORMAT(TIMEDIFF(NOW(),data_cadastro ),'%H:%i') as horas ,
	DATEDIFF(data_hora_fim,data_cadastro ) as dias_concluidas,
	TIME_FORMAT(TIMEDIFF(data_hora_fim,data_cadastro ),'%H:%i') as horas_concluidas,
	TIME_FORMAT(TIMEDIFF(data_hora_fim,data_cadastro ),'%H:%i') as horas_concluidas,
	TIME_FORMAT(TIMEDIFF(tempo_estimado_horas,tempo_finalizado_hora),'%H:%i') as saldo
		
		FROM 
			projetos_atividades 
		WHERE 
			vkt_id='$vkt_id' 
			AND
			usuario_id_cadastrou = '$usuario_id'
			AND 
			situacao='".$ordem_situacao[$i]."'
			$filtro_projeto 
			$filtro_funcionario 
			$filtro_tipo_atividade 
			$filtro_status 
		
		ORDER BY 
			projeto_id,
			ordenacao_funcionario ASC ");

	while($r=mysql_fetch_object($q)){
		$total++;
		$p=mysql_fetch_object(mysql_query("SELECT nome FROM projetos WHERE id='{$r->projeto_id}' "));
		$t=mysql_fetch_object(mysql_query("SELECT nome FROM projetos_atividades_tipos WHERE id='{$r->atividade_tipo_id}' "));
		$f=mysql_fetch_object(mysql_query("SELECT nome FROM usuario WHERE id='{$r->funcionario_id}' "));
		
		$totalx += $tempo_dessa_atividade=mysql_result(mysql_query($x="SELECT TIME_TO_SEC('$r->tempo')"),0);
		$totalx2 += $tempo_dessa_atividade=mysql_result(mysql_query($x="SELECT TIME_TO_SEC('$r->tempo_finalizado_hora')"),0);
		$totalx3 += $tempo_dessa_atividade=mysql_result(mysql_query($x="SELECT TIME_TO_SEC('$r->saldo')"),0);
		//echo $x;
		//echo mysql_error();
		$ultima_posicao = $r->ordenacao_funcionario;
		$projetoatual = $p->nome;
		
		if(substr($r->data_limite,0,1)>0&& $r->data_limite>=date("Y-m-d")){
			$data_limite = "redb";
		}else{
			$data_limite = "";
		}
		if($total%2){$sel='class="al $data_limite"';}else{$sel='class="$data_limite"';}
		
		
		
		if($projetoAnterior!=$projetoatual){
			$projetoAnterior=$p->nome;
			echo "<tr class='sublista'><td colspan='5'>$p->nome</td></tr>";
		}
?>
	
	<tr <?=$sel?> id="<?=$r->id?>">
<td width="20"><?php
if($r->situacao == 0){ 
	echo "<img src='../fontes/img/accept2.png'>";
} elseif($r->situacao == 1){ 
	echo "<img src='../fontes/img/accept.png'>";
} else if($r->situacao == 2){
	echo "<img src='../fontes/img/exclamation.png'>";
} else if($r->situacao == 3){
	echo "<img src='../fontes/img/_error.png'>";
}
?></td>
<td width="50"><?=$r->saldo?></td>
<td width="600"><?
	 if($r->prioridade==1){
      ?><div class='star'></div><?
	}
	if($r->situacao==1){
		if($r->aprovado_pelo_responsavel==1){
			
			$check = 'checked="checkeds"';
		}else{
			$check = '';	
		}
		echo '<input type="checkbox" class="cr" title="Conferencia como responsável pela atividade" '.$check.'>';	
	}
	  ?><span><?=$r->nome?></span></td>
<td width="120"><?=$f->nome?></td>
<td><?
if($r->situacao==1){
	if($r->dias_concluidas>1){
		echo "$r->dias_concluidas dias";
	}else{
		echo "$r->horas_concluidas horas";
	}
}else{
	if($r->dias>1){
		echo "$r->dias dias";
	}else{
		echo "$r->horas horas";
	}
}
?></td></tr>
<?
	}}
?>    </tbody>
</table>

<input type="hidden" id='ultima_posicao' value='<?=$ultima_posicao?>'/>
<?
//print_r($_POST);
?>
</div>
<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black">
    <thead>
    	<tr>
        	<td> 
            Estimado: <?=substr(mysql_result(mysql_query("SELECT SEC_TO_TIME($totalx)"),0),0,5);?>
            Executado:<?=substr(mysql_result(mysql_query("SELECT SEC_TO_TIME($totalx2)"),0),0,5);?>
            Saldo:<?=substr(mysql_result(mysql_query("SELECT SEC_TO_TIME($totalx3)"),0),0,5);?>
            </td>
        </tr>
    </thead>
</table>


</div>

<div id='rodape'>
	
</div>
