<?
// funçoes do modulo empreendimento
include("_function_colaborador.php");
include("_ctrl_colaborador.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
	$rprojeto = mysql_fetch_object(mysql_query("SELECT * FROM projetos_ultimos WHERE usuario_id='$usuario_id' ORDER BY id desc"));


if($_GET[projeto_id]){
	$projeto_id = $_GET[projeto_id];
	if($rprojeto->id>0){
		mysql_query($t="UPDATE projetos_ultimos SET projeto_id='$_GET[projeto_id]' WHERE id='$rprojeto->id'");
	}else{
		mysql_query($t="INSERT INTO projetos_ultimos SET projeto_id='$_GET[projeto_id]', usuario_id='$usuario_id' ");

	}
}else{
	$projeto_id = $rprojeto->projeto_id;
}

//
if(strpos($_SERVER[HTTP_USER_AGENT],'iPhone')>0){
	$div_sis_coluna2 = "display:none;";
	$div_dados = "";
?>
<style>
tbody td{float:left;}
thead td{display:none}
#dados tbody tr td:nth-child(1){width:352px; border-top:1px solid #CCC; font-size:14px }
#dados tbody td{ background:#FFF;}
#dados tbody td:hover{ background:#F4F4F4;}

#dados tbody tr td:nth-child(2){width:50px; margin:0; padding:0 0 0 10px;color:#999; height:17px; padding-top:10px; }
#dados tbody tr td:nth-child(3){width:50px; margin:0; padding:0 ;color:#999;height:17px;padding-top:10px;}
#dados tbody tr td:nth-child(4){width:50px; margin:0; padding:0;color:#999;height:17px;padding-top:10px;}
#dados tbody tr td:nth-child(5){width:194px; margin:0; padding:0;color:#999;height:17px;padding-top:10px;}
#dados tbody tr td:nth-child(5) div{border:0;}
#dados tbody tr td:nth-child(6){display:none;height:17px;padding-top:10px;}

#dados .atv{ height:auto;}
#dados .atv input{ height:30px; float:left;}
#dados .atv img{ float:left; margin:10px 10px 10px; }
#dados .exa{ display:block; float:left; width:255px;}
#dados .ha{ display:none}
</style>
<meta name="viewport" content="initial-scale=1.0; maximum-scale=0.9; user-scalable=1.0;"/>
<?
}else{
	$div_sis_coluna2 = "";
	$div_dados = "margin-left:200px";
}


?>
<style>
.bars{height:8px;border:1px solid #666; background:#FFF;}
</style>

<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<link href="<?=$tela->caminho?>/colaborador.css" rel="stylesheet" type="text/css" />
<script src="<?=$tela->caminho?>/colaborador.js" type="text/javascript"></script>
<script>
var pressedCtrl = false; 
$(document).keyup(function (e) {
	if(e.which == 18)
		pressedCtrl=false; 
})

function abremais(){
	window.open('<?=$tela->caminho?>/form_add.php?projeto_id=<?=$projeto_id?>','carregador');
}
$(document).keydown(function (e) {
	if(e.which == 18) 
	pressedCtrl = true; 
	//document.title=e.which;
	
	if(e.which == 27){
		$("#exibe_formulario").html('');
	}
	if(e.which == 71 && pressedCtrl == true){
		location='?tela_id=92&projeto_id=<?=$projeto_id?>&status=0';
	}
	if(e.which == 61 && pressedCtrl == true) { 
		//Aqui vai o código e chamadas de funções para o ctrl+s
		abremais(); 
	}
});
</script>
<div id='conteudo'>
<div id='navegacao'>
	<div id="some">»</div>

<a href="?" class='s1'>
  	Inicio
</a>
<a href="?" class='s2'>
  	Controle de Atividades
</a>
<a href="?tela_id=96" class='navegacao_ativo' tt='<?=$tela->nome?>'>
<span id='infotela' caminho='<?=$tela->caminho?>' tela_id='<?=$tela->id?>'></span>    <?=$tela->nome?>
</a>
</div>

<div id="barra_info" >
 <a href="#" onClick="abremais()" class="mais"></a>

<span id="tarefasref">
	<a href="?tela_id=96&projeto_id=<?=$_GET[projeto_id]?>&filtro=atrasadas"><span style="color:#900"><?=tarefasAtrazadas()?></span> Atrasadas</a>
	<a href="?tela_id=96&projeto_id=<?=$_GET[projeto_id]?>&filtro=excedido"><span style="color:#900"><?=tarefasTempoExedido()?></span> Tempo Excedido</a>
	<a href="?tela_id=96&projeto_id=<?=$_GET[projeto_id]?>&filtro=pendentedeaprovacao"><span style="color:#900"><?=tarefasASeremAprovadas()?></span> A serem aprovadas</a>
    
    
    
    <a href='?tela_id=92&projeto_id=0&tipo_atividade_id=0&funcionario_id=0&status=10'><span style="color:#900"><?

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
?></span><span> Para aprovar</span></a>

</span>



</div>


<div id='sis_coluna2' style="width: 200px; position: absolute; border-right: 1px solid #CCC; background: #F4F5F7; z-index: 0; border-bottom: 1px solid #CCC; border-left: 1px solid #999; top: 51px;<?=$div_sis_coluna2?>">



<?
			if($_GET[projeto_id]=='todas'){
				$projeto_prioridade=$p->id;
				$bga='bgpr_sel';
			}else{
				$bga='bgpr';
			}

?>

	<div class="<?=$bga?>" onclick="location='?tela_id=96&projeto_id=todas'">
    	<div id='' class="infd" title="Dias para conclusao"><?=@mysql_result(mysql_query("SELECT count(*) FROM projetos_atividades WHERE funcionario_id='$usuario_id' AND situacao in ('0','2','3')"),0,0);
?></div>
        <div id='' >Totas Atividades</div>
    </div>

<?php 
	$sql = mysql_query($t="SELECT p.nome,p.id,count(a.id) as quantidade, DATEDIFF(p.data_limite,date(now())) as limite FROM projetos_atividades as a, projetos as p WHERE a.projeto_id=p.id  AND a.funcionario_id = '$usuario_id' AND a.situacao in ('0','2','3') GROUP BY a.projeto_id  ORDER BY p.data_limite,p.nome  ");
//	echo $t;
		while($p=mysql_fetch_object($sql)){
			$conta_projeto++;
			
				//$quantidade = mysql_result(mysql_query("SELECT count(*) FROM projetos_atividades WHERE projeto_id='$p->id' AND funcionario_id='$usuario_id' AND situacao <=1"),0,0);
			
			if($projeto_id==$p->id){
				$projeto_prioridade=$p->id;
				$bga='bgpr_sel';
				
				
				
			}else{
				$bga='bgpr';
			}
			
			
			
			
			
            
			//<?php echo str_pad($p->limite,3," ",STR_PAD_LEFT).$p->nome; ? >
?>
	<div class="<?=$bga?>" onclick="location='?tela_id=96&projeto_id=<?=$p->id?>'" onDblClick="location='?tela_id=92&projeto_id=<?=$p->id?>&tipo_atividade_id=0&funcionario_id=0&status=0'">
    	<div id='' class="infd" title="Dias para conclusao"><?=$p->quantidade?></div>
        <div id='' ><?=$p->nome?></div>
    </div>
<?php 	}?>

</div>
<script>
resize2()
</script>
<div style=" <?=$div_dados?>">
<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
    	  <td >Atividade</td>
    	  <td width="60">Estimado</td>
          <td width="60">Gasto</td>
          <td width="60">Saldo</td>
          <td width="100">Progresso</td>
          <td width="30">&nbsp;</td>
        </tr>
    </thead>
</table>
<div id='dados' >

<script>resize3()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
  <tbody>
    <?php 
	
	
	// SQL PARA LISTAR TODOS OS REGISTROS
	
	
	if($projeto_id>0&&$_GET[projeto_id]!='todas'){
		$filtro_projeto=" AND projeto_id='{$projeto_id}' ";
	}
	
	
	$verifica_se_algum_em_andamento = mysql_fetch_object(mysql_query("SELECT * FROM projetos_atividades WHERE situacao='2' AND funcionario_id='$usuario_id'"));
	if($verifica_se_algum_em_andamento->id>0){
		$cass_img = 'brp0';
		$visibility = 'hidden';
	}else{
		$cass_img = 'brp';
		$visibility = 'visible';
	}
	
			
	
	$q = mysql_query($t="
			SELECT 
				* ,
				time_to_sec(tempo_estimado_horas) as segundos,
				DATEDIFF(NOW() ,data_cadastro) as dias , 
				TIMEDIFF(NOW(),data_cadastro ) as horas ,
				DATEDIFF(data_limite,NOW() ) as dias_falta

			FROM 
				projetos_atividades 
			WHERE 
				vkt_id='$vkt_id' 
			AND
				situacao <>'1'
			AND 
				funcionario_id = '$login_id'
				$filtro_projeto 
				$filtro_tipo_atividade 
				$filtro_tipo_situacao  
			ORDER BY 
				ordenacao_funcionario ASC ");
/*
atrasadas
excedido
pendentedeaprovacao
*/

	if($_GET[filtro]){
		
		if($_GET[filtro]=='atrasadas' ){
			$sql_filtro = "funcionario_id='$usuario_id' AND data_limite <> '0000-00-00' AND data_limite > NOW()";
		}
		
		if($_GET[filtro]=='excedido' ){
			$sql_filtro = "funcionario_id='$usuario_id' AND tempo_estimado_horas<tempo_finalizado_hora AND situacao in('0','2','3')";
		}
		
		if($_GET[filtro]=='pendentedeaprovacao' ){
			$sql_filtro = "funcionario_id='$usuario_id' AND aprovado_pelo_responsavel='0' AND situacao='1'";
		}
		
		$q = mysql_query($t="
			SELECT 
				* ,
				time_to_sec(tempo_estimado_horas) as segundos,
				DATEDIFF(NOW() ,data_cadastro) as dias , 
				TIMEDIFF(NOW(),data_cadastro ) as horas ,
				DATEDIFF(data_limite,NOW() ) as dias_falta
			FROM 
				projetos_atividades 
			WHERE 
				$sql_filtro
			ORDER BY 
				ordenacao_funcionario ASC ");
	}				
//			echo $t;	
				
				
	while($r=mysql_fetch_object($q)){
		$total++;
		$usuario_cadastrou = mysql_fetch_object(mysql_query("SELECT id,nome FROM usuario WHERE id='".$r->usuario_id_cadastrou."'"));
		$ordenacao_funcionario= $r->ordenacao_funcionario;
		if($r->id==$verifica_se_algum_em_andamento->id){
			$exibe_cass_img= 'brp2';
			$class_linha = ' azul';
			$visibility = 'visible';
		}else{
			$exibe_cass_img=$cass_img;
			$class_linha = '';
			$visibility = $visibility;
		}
		
		if($r->prioridade==1){
			$nome = "<b>$r->nome</b>";
			$clsadd = " bgst";
		}else{
			$nome = "$r->nome";	
			$clsadd = "";
		}
		
		if(substr($r->data_limite,0,1)>0&& $r->data_limite<=date("Y-m-d")){
			$data_limite = " redb";
			$falta_ou_passaram = " Passaram ($r->dias_falta) dias";
		}else{
			$data_limite = " ";
			if($r->dias_falta){
				$falta_ou_passaram = " Faltam ($r->dias_falta) dias";
			}else{
				$falta_ou_passaram = "";
			}
		}
		
		if($total%2){$sel="class=\"al$class_linha$data_limite\"";}else{$sel="class=\"$class_linha$data_limite\"";}
		$atividade=mysql_fetch_object(mysql_query("SELECT nome FROM projetos_atividades_tipos WHERE id='{$r->atividade_tipo_id}'"));	
		
		if($r->usuario_id_cadastrou==$usuario_id ){
			$podeAlterar='1';
		}else{
			$podeAlterar='0';
		}
		
	?><tr <?=$sel?>  ri="<?=$r->id?>" title="<?=$atividade->nome."$falta_ou_passaram por $usuario_cadastrou->nome"?>" >
      <td  class='atv '><?
	 if($r->prioridade==1){
      ?><div class='star'></div><?
	}
	  ?><div class='ha'><? if($r->dias>1){ ?>
    há <?=$r->dias?> d
    <?
	}else{
	?>
    há <?=substr($r->horas,0,2);?> h
    <?
	}
	?></div><input type="checkbox" style="visibility:<?=$visibility?>" /> 
        <img src="../fontes/img/b.gif" class="<?=$exibe_cass_img?>" align="bottom" /> <span class='exa' id="<?=$r->id?>" p="<?=$podeAlterar?>" ><?=$nome;?></span></td>
      
      <td width="60" id='f<?=$r->id?>' ><?php
          $estimado = substr($r->tempo_estimado_horas,0,5); echo $estimado;
		  ?></td>
      <td width="60" id='g<?=$r->id?>' ><?php
			if($r->id!=$verifica_se_algum_em_andamento->id){
				  $gasto = substr($r->tempo_finalizado_hora,0,5); 
				  echo $temporel=$gasto;
			}else{
				$ultimo_timer = verifica_ultima_situacao($r->id);
				$segundos_atividades = mysql_result(mysql_query("select TIME_TO_SEC('$r->tempo_finalizado_hora')"),0,0);
				$segundos_ultimo_timer = mysql_result(mysql_query("select TIME_TO_SEC(TIMEDIFF(now(),'$ultimo_timer->inicio')) "),0,0);
				$soma_de_tempo = $segundos_atividades+$segundos_ultimo_timer;
				$tempo_parcial = mysql_result(mysql_query("select SEC_TO_TIME('$soma_de_tempo') "),0,0);
				echo $temporel=$tempo_parcial;
				
			}
          ;?></td><td width="60" id='h<?=$r->id?>' ><?
      	echo  mysql_result(mysql_query($t="select TIME_FORMAT(TIMEDIFF('$r->tempo_estimado_horas','$temporel'),'%H:%i')"),0,0);



	  ?></td>
      <td width="100" ><?
      $segundos = $r->segundos;
	  
	  $segundos_gasto = mysql_result(mysql_query($t="select time_to_sec('$temporel:00')"),0,0);
	  $percentual_conc = @($segundos_gasto/$segundos)*100;
	  $percentul_atingido = number_format($percentual_conc,2,',','.');
	  if($percentual_conc>100){
		  $percentual_concx=100;
		  $colorp='#990000';
		 }else{
			$colorp='#009900';
		  $percentual_concx=$percentual_conc;
		}
	  ?><div class="bars"><div id='p<?=$r->id?>' style="height:8px;width:<?=$percentual_concx?>%; background:<?=$colorp?>"></div>
      </div></td>
      <td width="30"id='pp<?=$r->id?>' ><?=$percentul_atingido?></td>
      </tr>
    <?
	}
?>
    <?php 
	if(isset($projeto_id)&&$projeto_id!='0'){
		$filtro_projeto=" AND projeto_id='{$projeto_id}' ";
	}
	
	if(isset($_GET['tipo_atividade_id'])&&$_GET['tipo_atividade_id']!='0'){
		$filtro_tipo_atividade=" AND atividade_tipo_id='{$_GET['tipo_atividade_id']}' ";
	}
	
	
	// SQL PARA LISTAR TODOS OS REGISTROS
	
	
	if(isset($projeto_id)&&$projeto_id!='0'){
		$filtro_projeto=" AND projeto_id='{$projeto_id}' ";
	}
	
	if(isset($_GET['tipo_atividade_id'])&&$_GET['tipo_atividade_id']!='0'){
		$filtro_tipo_atividade=" AND atividade_tipo_id='{$_GET['tipo_atividade_id']}' ";
	}
	if(isset($_GET['situacao_id']) && $_GET['situacao_id'] != '99'   ){
		$filtro_tipo_situacao=" AND situacao='{$_GET['situacao_id']}'  ";
	}
	
	
	$verifica_se_algum_em_andamento = mysql_fetch_object(mysql_query("SELECT * FROM projetos_atividades WHERE situacao='2' AND funcionario_id='$usuario_id'"));
	if($verifica_se_algum_em_andamento->id>0){
		$cass_img = 'brp0';
		$visibility = 'hidden';
	}else{
		$cass_img = 'brp';
		$visibility = 'visible';
	}
	
			
	
	$q = mysql_query($t="
			SELECT 
				* ,
				time_to_sec(tempo_estimado_horas) as segundos,
				DATEDIFF(NOW() ,data_cadastro) as dias , 
				TIMEDIFF(NOW(),data_cadastro ) as horas 
			FROM 
				projetos_atividades 
			WHERE 
				vkt_id='$vkt_id' 
			AND
				situacao ='1'
			AND
				date(data_hora_fim )=date(now())
			AND 
				funcionario_id = '$login_id'
				$filtro_projeto 
				$filtro_tipo_atividade 
				$filtro_tipo_situacao  
			ORDER BY 
				ordenacao_funcionario ");

	while($r=mysql_fetch_object($q)){
		$total++;
		if($r->id==$verifica_se_algum_em_andamento->id){
			$exibe_cass_img= 'brp2';
			$class_linha = ' azul';
			$visibility = 'visible';
		}else{
			$exibe_cass_img=$cass_img;
			$class_linha = '';
			$visibility = $visibility;
		}
		if($total%2){$sel="class=\"al$class_linha\"";}else{$sel="class=\"$class_linha\"";}
		$atividade=mysql_fetch_object(mysql_query("SELECT nome FROM projetos_atividades_tipos WHERE id='{$r->atividade_tipo_id}'"));	
	?>
    <tr <?=$sel?> ri="<?=$r->id?>" title="<?=$atividade->nome?>" >
      <td  class='atv'><div class='ha'><? if($r->dias>1){ ?>
    há <?=$r->dias?> d
    <?
	}else{
	?>
    há <?=substr($r->horas,0,2);?> h
    <?
	}
	?></div><input type="checkbox" style="visibility:<?=$visibility?>" checked="checked" /> 
        <img src="../fontes/img/b.gif" class="brp0" align="bottom" /> <span class='exa' id="<?=$r->id?>" ><?= $r->nome?></span></td>
      
      <td width="60" id='f<?=$r->id?>' ><?php
          $estimado = substr($r->tempo_estimado_horas,0,5); echo $estimado;
		  ?></td>
      <td width="60" id='g<?=$r->id?>' ><?php
			if($r->id!=$verifica_se_algum_em_andamento->id){
				  $gasto = substr($r->tempo_finalizado_hora,0,5); 
				  echo $temporel=$gasto;
			}else{
				$ultimo_timer = verifica_ultima_situacao($r->id);
				$segundos_atividades = mysql_result(mysql_query("select TIME_TO_SEC('$r->tempo_finalizado_hora')"),0,0);
				$segundos_ultimo_timer = mysql_result(mysql_query("select TIME_TO_SEC(TIMEDIFF(now(),'$ultimo_timer->inicio')) "),0,0);
				$soma_de_tempo = $segundos_atividades+$segundos_ultimo_timer;
				$tempo_parcial = mysql_result(mysql_query("select SEC_TO_TIME('$soma_de_tempo') "),0,0);
				echo $temporel=$tempo_parcial;
				
			}
          ;?></td><td width="60" id='h<?=$r->id?>' ><?
      	echo  mysql_result(mysql_query($t="select TIME_FORMAT(TIMEDIFF('$r->tempo_estimado_horas','$temporel'),'%H:%i')"),0,0);



	  ?></td>
      <td ><?
		 $percentual_concx=100;
			$colorp='#009900';
	  ?>
        <div class="bars">
          <div id='p<?=$r->id?>' style="height:8px;width:<?=$percentual_concx?>%; background:<?=$colorp?>"></div>
        </div></td>
      <td id='pp<?=$r->id?>' >100%</td>
      </tr>
    <?
	}
?>
  </tbody>
</table>
<script>

<?
	if($verifica_se_algum_em_andamento->id>0){
		echo "cronometro('g$verifica_se_algum_em_andamento->id')";
	}
?>
</script>
<?
//print_r($_POST);
?>


</div>
<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black">
    <thead>
    	<tr>
    	  <td>Tarefas em adamento em
    	    <input id='data_conclusao' ultima_ordem='<?=$ordenacao_funcionario?>' style="font-size:10px; height:8px; border:0; background:none; width:75px; font-weight:bold;" value="<?
	  if($_GET[data_conclusao]){
		  echo $data_conclusao=$_GET[data_conclusao];
	}else{
	 echo  $data_conclusao=date("d/m/Y");
	}
	  ?>" calendario='1' onblur="setTimeout('location=\'?tela_id=96&amp;data_conclusao=\'+document.getElementById(\'data_conclusao\').value',200)" /></td>
        </tr>
    </thead>
</table>

<div style="height:120px; overflow:auto;">
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados2" style="border-top:1px solid #999" >
  <tbody>
    <?php 
	if(isset($projeto_id)&&$projeto_id!='0'){
		$filtro_projeto=" AND projeto_id='{$projeto_id}' ";
	}
	
	if(isset($_GET['tipo_atividade_id'])&&$_GET['tipo_atividade_id']!='0'){
		$filtro_tipo_atividade=" AND atividade_tipo_id='{$_GET['tipo_atividade_id']}' ";
	}
	
	
	// SQL PARA LISTAR TODOS OS REGISTROS
	
	
	if(isset($projeto_id)&&$projeto_id!='0'){
		$filtro_projeto=" AND projeto_id='{$projeto_id}' ";
	}
	
	if(isset($_GET['tipo_atividade_id'])&&$_GET['tipo_atividade_id']!='0'){
		$filtro_tipo_atividade=" AND atividade_tipo_id='{$_GET['tipo_atividade_id']}' ";
	}
	if(isset($_GET['situacao_id']) && $_GET['situacao_id'] != '99'   ){
		$filtro_tipo_situacao=" AND situacao='{$_GET['situacao_id']}'  ";
	}
	
	
	
	if($_GET['data_conclusao']){
		$data_conclusao = dataBrToUsa($_GET['data_conclusao']);		
		$data_conclusao = "'$data_conclusao'"	;
	}else{
		$data_conclusao = "date(now())"	;
	}
	
	
	$q = mysql_query($t="
	
	SELECT * FROM 
		projetos_atividades_tempo as t,
		projetos_atividades as a
		
	WHERE
		t.usuario_id ='$usuario_id'
	AND
		date(t.fim)=$data_conclusao
	AND
		t.atividade_id=a.id
	group by 
		t.atividade_id
	ORDER BY
		a.data_hora_fim , a.ordenacao_funcionario 
	");

			
	while($r=mysql_fetch_object($q)){
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
		$atividade=mysql_fetch_object(mysql_query("SELECT nome FROM projetos_atividades_tipos WHERE id='{$r->atividade_tipo_id}'"));
		if($r->situacao=='1'){$ch='checked="chekced"';}else{$ch='';}
	?>
    <tr <?=$sel?> ri="<?=$r->id?>"  >
      <td ><input type="checkbox" <?=$ch?> style="visibility:<?=$visibility?>" disabled="disabled" /> <span class='exa' id="<?=$r->id?>" ><?=$r->nome;?></span></td>
      <td width="60" id='f<?=$r->id?>'><?php
          $estimado = substr($r->tempo_estimado_horas,0,5); echo $estimado;
		  ?></td>
      <td width="60" id='g<?=$r->id?>'><?php
		  $gasto = substr($r->tempo_finalizado_hora,0,5); echo $gasto;
          ;?></td>
      <td width="60" id='h<?=$r->id?>'><?
      	echo  mysql_result(mysql_query($t="select TIME_FORMAT(TIMEDIFF('$r->tempo_estimado_horas','$temporel'),'%H:%i')"),0,0);



	  ?></td>
      </tr>
    <?
	}
?>
  </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%" style="border-top:1px solid #999" >

  <tfoot>
    <tr>
      <td >
      Tempo
	  Produtivo do dia
	  <?
 	  if($_GET[data_conclusao]){
		   $data_conclusao=$_GET[data_conclusao];
	}else{
	   $data_conclusao=date("d/m/Y");
	}     
echo 	  soma_horas_dia(dataBrToUsa($data_conclusao));
	  ?>
      
      </td>
      <td width="60" >&nbsp;</td>
      <td width="60" >&nbsp;</td>
      <td width="60" >&nbsp;</td>
      </tr>
  </tfoot>
</table>
</div>
</div>
<div id='rodape'>
<script>

		$("#rodape").animate({
			'marginLeft': 0
		  }, 0);
</script> 
<span style="font-size:9px; color:#666; line-height:22px;">Atalhos: <strong>ESC</strong> Some Formulário <strong>ALT+(+)</strong> Adiciona Atividade <strong>ALT+ G </strong> Gerencia Atividades</span>
</div>
