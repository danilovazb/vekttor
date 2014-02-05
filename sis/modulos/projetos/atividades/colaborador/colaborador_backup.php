<?
session_start();
// funçoes do modulo empreendimento
include("_function_colaborador.php");
include("_ctrl_colaborador.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
?>
<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
.atv{border-right:0; padding-left:5px;}
.brp{ width:10px; height:11px; background:url(../fontes/img/pp.png) }
.brp:hover{ background-position:0 -22px; }

.brp0{ width:10px; height:11px;  }

.brp2{ width:10px; height:11px; background:url(../fontes/img/pp.png) 0 -11px; }
.brp2:hover{ background-position:0 -33px; }

.azul td{ color:#0066FF; font-weight:bold;  }
#tabela_dados input{ width:15px; height:15px;}
#tabela_dados td{ border:0;}
.bgpr{clear:both; height:34px; line-height:34px; overflow:hidden; font-weight:bold; font-size:11px; color:#464646; background:url(../fontes/img/bga.png);}
.bgpr_sel{clear:both; height:34px; line-height:34px; overflow:hidden; font-weight:bold; font-size:11px; color:#FFF; background:url(../fontes/img/bga2.png);text-shadow:#000 0 0 3px;}
.bgpr,.bgpr_sel{cursor:pointer;}
.bgpr div,.bgpr_seldiv{float:left;}
.infd{float:left; width:30px; text-align:center;}
</style>
<script type="text/javascript">


function resize2(){
	h =document.body.clientHeight;
	document.getElementById('sis_coluna2').style.height=(h-78)+'px';
}
function resize3(){
	h =document.body.clientHeight;
	document.getElementById('dados').style.height=(h-413)+'px';
}


window.onresize=function() {
	resize3();
	resize2();
}
$(document).ready(function(){	
		$("#situ3").live("click",function(){
			
		$('#tempo_gasto').attr('disabled','disabled');
		$('#data_fim').attr('disabled','disabled');
		$('#hora_fim').attr('disabled','disabled');
		$('#v2').attr('disabled','disabled');
		$('#data_inicio').attr('disabled','disabled');
		$('#hora_inicio').attr('disabled','disabled');
		$('#v1').attr('disabled','disabled');
		
		$('#situ2').attr('checked',false);
	});
	
	$("#situ2").live("click",function(){
		$('#data_inicio').attr('disabled','disabled');
		$('#hora_inicio').attr('disabled','disabled');
		$('#v1').attr('disabled','disabled');
		//$('#situ3').attr('disabled','disabled');
		$('#situ3').attr('checked',false);
		//desabilitar
		$('#tempo_gasto').removeAttr('disabled');
		$('#data_fim').removeAttr('disabled');
		$('#hora_fim').removeAttr('disabled');
		$('#v2').removeAttr('disabled');
	});	
	
});

$(".exa").live("click",function(){
	var atividade_id = $(this).attr('id');
	
	window.open('<?=$tela->caminho?>/form.php?id='+atividade_id,'carregador');
});
// checa
$("#tabela_dados input").live("click",function(){
	id = $(this.parentNode.parentNode).attr('ri');
	atividade = $(this.parentNode.getElementsByTagName('span')[0]).text();
	t1 = $('#f'+id).text();
	t2 =$('#g'+id).text();
	t3 =$('#h'+id).text();
	if($(this).is(':checked')){
		$(this.parentNode.parentNode.parentNode).find('tr').removeClass('azul');
		$(this.parentNode.parentNode.parentNode).find('input').css("visibility","visible");
		$(this.parentNode.parentNode.parentNode).find('img').removeClass('brp2');
		$(this.parentNode.parentNode.parentNode).find('img').addClass('brp');
		$(this.parentNode.parentNode).hide(100)
		document.getElementById("g"+id).setAttribute('pause','1');
		
		window.open('<?=$tela->caminho?>/_actions.php?action=conclui_atividade&atividade_id='+id,'carregador');
		$('#tabela_dados2').append('<tr  ri="'+id+'"><td ><input type="checkbox" checked="checked" style="visibility:visible"><span id="80" class="exa">'+atividade+'</span></td><td width="60"  id="f'+id+'">'+t1+'</td><td width="60"  id="g'+id+'">'+t2+'</td><td width="60" id="h'+id+'">'+t3+'</td></tr>');

		$("#tabela_dados2 tr:even").addClass('al');

	}else{
		$(this.parentNode.parentNode.parentNode).find('tr').removeClass('azul');
		$(this.parentNode.parentNode.parentNode).find('input').css("visibility","visible");
		$(this.parentNode.parentNode.parentNode).find('img').removeClass('brp2');
		$(this.parentNode.parentNode.parentNode).find('img').addClass('brp');
		
		document.getElementById("g"+id).setAttribute('pause','1');
		window.open('<?=$tela->caminho?>/_actions.php?action=ativa_atividade&atividade_id='+id,'carregador');
	}
});

$("#tabela_dados2 input").live("click",function(){
	id = $(this.parentNode.parentNode).attr('ri');
	atividade = $(this.parentNode.getElementsByTagName('span')[0]).text();
	t1 = $('#f'+id).text();
	t2 =$('#g'+id).text();
	t3 =$('#h'+id).text();
	
	if($(this).is(':checked')){
		window.open('<?=$tela->caminho?>/_actions.php?action=conclui_atividade&atividade_id='+id,'carregador');

		
	}else{
		window.open('<?=$tela->caminho?>/_actions.php?action=ativa_atividade&atividade_id='+id,'carregador');
		$(this.parentNode.parentNode).hide(100)
		$('#tabela_dados').append('<tr ri="'+id+'"><td class="atv"><input type="checkbox" style="visibility:visible"><img class="brp" align="bottom" src="../fontes/img/b.gif"><span id="80" class="exa">'+atividade+'</span></td><td width="60"  id="f'+id+'">'+t1+'</td><td width="60"  id="g'+id+'">'+t2+'</td><td width="60" id="h'+id+'">'+t3+'</td></tr>');
		$("#tabela_dados tr:even").addClass('al');

	}
})
///inicia a atividade
$(".brp").live("click",function(){
	id = $(this.parentNode.parentNode).attr('ri');
	$(this).removeClass('brp');
	$(this.parentNode.parentNode.parentNode).find('tr').removeClass('azul');
	$(this.parentNode.parentNode.parentNode).find('img').removeClass('brp2');
	$(this.parentNode.parentNode.parentNode).find('img').removeClass('brp');
	$(this.parentNode.parentNode.parentNode).find('img').addClass('brp0');
	$(this.parentNode.parentNode.parentNode).find('input').css("visibility","hidden");
	$(this.parentNode.parentNode).addClass('azul');
	$(this.parentNode).find('input').css("visibility","visible");
;
	$(this).addClass('brp2');
	document.getElementById("g"+id).setAttribute('pause','0');
	cronometro("g"+id);
	window.open('<?=$tela->caminho?>/_actions.php?action=starta&atividade_id='+id,'carregador');

});

// Para a a tividade
$(".brp2").live("click",function(){
	id = $(this.parentNode.parentNode).attr('ri');
	$(this).removeClass('brp2');
	 $(this).addClass('brp');
	$(this.parentNode.parentNode.parentNode).find('tr').removeClass('azul');
	$(this.parentNode.parentNode.parentNode).find('input').css("visibility","visible");
	$(this.parentNode.parentNode.parentNode).find('img').removeClass('brp2');
	$(this.parentNode.parentNode.parentNode).find('img').addClass('brp');
	document.getElementById("g"+id).setAttribute('pause','1');
	window.open('<?=$tela->caminho?>/_actions.php?action=pausa&atividade_id='+id,'carregador');


});
function cronometro(origem){
	horasMinutos = document.getElementById(origem).innerHTML;
	
	splitTime = horasMinutos.split(":");
	
	horas = splitTime[0]*1;
	minutos = splitTime[1]*1;
	segundos = splitTime[2]*1;
//	alert(segundos)
	if(horas>0){}else{horas=0;}
	if(minutos>0){}else{minutos=0;}
	if(segundos>0){}else{segundos=0;}
	
	segundos++;
	if(segundos>59){
		minutos++;
		segundos=0;	
	}
	if(minutos>59){
		horas++;
		minutos=0;	
	}
	
	
	if(document.getElementById(origem).getAttribute('pause')!=1){
	
		document.getElementById(origem).innerHTML=ct(horas)+":"+ct(minutos)+":"+ct(segundos);
		setTimeout("cronometro(\""+origem+"\")",1000);
	}else{
		idlinhe = document.getElementById(origem).parentNode.getAttribute('ri');
		planejado = document.getElementById('f'+idlinhe).innerHTML;
		realizado = document.getElementById(origem).innerHTML
		
		saldo =calc_saldo(planejado,realizado);
		document.getElementById('h'+idlinhe).innerHTML=saldo;
		
	}
}

function time_to_sec(t){
	splitTime =t.split(":");
	horas = splitTime[0]*1;
	minutos = splitTime[1]*1;
	segundos = splitTime[2]*1;

	if(horas>0){}else{horas=0;}
	if(minutos>0){}else{minutos=0;}
	if(segundos>0){}else{segundos=0;}
	
	h_seg = horas*60*60;
	m_seg = minutos*60;
	s_seg = segundos;
	
	return h_seg+m_seg+s_seg;
	
}
function sec_to_time(secs){
    var hours = Math.floor(secs / (60 * 60));
   
    var divisor_for_minutes = secs % (60 * 60);
    var minutes = Math.floor(divisor_for_minutes / 60);
 
    var divisor_for_seconds = divisor_for_minutes % 60;
    var seconds = Math.ceil(divisor_for_seconds);
   
    return ct(hours)+":"+ct(minutes);
}


function calc_saldo(previsto,realizado){
	pr =time_to_sec(previsto);
	re =time_to_sec(realizado);
	
	if(pr>re){
		tempo_saldo = pr-re;
		sinal = '&nbsp;';
	}else{
		tempo_saldo = re-pr;
		sinal ='-';
	}
	
	return sinal+sec_to_time(tempo_saldo);

}
function ct(i){
	if(i<10){
		return '0'+i;
	}else{
		return i;	
	}
}



</script>

<div id='conteudo'>

<div id='navegacao'>
<a href="?" class='s1'>
  	Sistema NV
</a>
<a href="?" class='s2'>
  	Projetos
</a>
<a href="?tela_id=96" class='navegacao_ativo'>
<span></span>    Colaborador
</a>
</div>

<div id="barra_info"></div>


<div id='sis_coluna2' style="width:200px; position:absolute; border-right:1px solid #CCC; background:#F4F5F7;  z-index:0; border-bottom:1px solid #CCC; border-left:1px solid #999; ">
<?php 
	$sql = mysql_query("SELECT *, DATEDIFF(data_limite,date(now())) as limite FROM projetos WHERE status <> 'finalizado'  ORDER BY data_limite ");
	
		while($p=mysql_fetch_object($sql)){
			$conta_projeto++;
			if($_GET[projeto_id]==$p->id){
				$projeto_prioridade=$p->id;
				$bga='bgpr_sel';
			}else{
				$bga='bgpr';
			}
			if(!$_GET[projeto_id]&&$conta_projeto==1){
				$projeto_prioridade=$p->id;
				$bga='bgpr_sel';
			}
			
			
			
			
			
            
			//<?php echo str_pad($p->limite,3," ",STR_PAD_LEFT).$p->nome; ? >
?>
	<div class="<?=$bga?>" onclick="location='?tela_id=96&projeto_id=<?=$p->id?>'">
    	<div id='' class="infd" title="Dias para conclusao"><?=$p->limite?></div>
        <div id='' ><?=$p->nome?></div>
    </div>
<?php 	}?>

</div>
<script>
resize2()
</script>
<div style=" margin-left:200px;">
<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
    	  <td >Atividade</td>
          <td width="60">Estimado</td>
          <td width="60">Gasto</td>
          <td width="60">Saldo</td>
        </tr>
    </thead>
</table>
<div id='dados' >

<script>resize3()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
  <tbody>
    <?php 
	if(isset($_GET['projeto_id'])&&$_GET['projeto_id']!='0'){
		$filtro_projeto=" AND projeto_id='{$_GET['projeto_id']}' ";
	}
	
	if(isset($_GET['tipo_atividade_id'])&&$_GET['tipo_atividade_id']!='0'){
		$filtro_tipo_atividade=" AND atividade_tipo_id='{$_GET['tipo_atividade_id']}' ";
	}
	
	
	// SQL PARA LISTAR TODOS OS REGISTROS
	
	
	if(isset($_GET['projeto_id'])&&$_GET['projeto_id']!='0'){
		$filtro_projeto=" AND projeto_id='{$_GET['projeto_id']}' ";
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
	
			
	$q_total=mysql_fetch_object(mysql_query("
	SELECT
		TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(tempo_estimado_horas))),'%H:%i') AS horas,

		TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(tempo_finalizado_hora))),'%H:%i') AS hora_final	
	FROM 
		projetos_atividades 
	WHERE 
		vkt_id='$vkt_id' 
	AND 
		funcionario_id = $login_id 
		$filtro_funcionario 
		$filtro_projeto 
		$filtro_tipo_atividade"));
		
	
	$q = mysql_query($t="
			SELECT 
				* 
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
      <td  class='atv'><input type="checkbox" style="visibility:<?=$visibility?>" /> 
        <img src="../fontes/img/b.gif" class="<?=$exibe_cass_img?>" align="bottom" /> <span class='exa' id="<?=$r->id?>" ><?= $r->nome."($r->situacao)";?></span></td>
      <td width="60" id='f<?=$r->id?>' ><?php
          $estimado = substr($r->tempo_estimado_horas,0,5); echo $estimado;
		  ?></td>
      <td width="60" id='g<?=$r->id?>' "><?php
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
    	  <td>Tarefas Concluidas 
    	    <input id='data_conclusao' style="font-size:10px; height:8px; border:0; background:none; width:75px; font-weight:bold;" value="<?
	  if($_GET[data_conclusao]){
		  echo $data_conclusao=$_GET[data_conclusao];
	}else{
	 echo  $data_conclusao=date("d/m/Y");
	}
	  ?>" calendario='1' onblur="setTimeout('location=\'?tela_id=96&amp;data_conclusao=\'+document.getElementById(\'data_conclusao\').value',200)" /></td>
        </tr>
    </thead>
</table>

<div style="height:280px; overflow:auto;">
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados2" style="border-top:1px solid #999" >
  <tbody>
    <?php 
	if(isset($_GET['projeto_id'])&&$_GET['projeto_id']!='0'){
		$filtro_projeto=" AND projeto_id='{$_GET['projeto_id']}' ";
	}
	
	if(isset($_GET['tipo_atividade_id'])&&$_GET['tipo_atividade_id']!='0'){
		$filtro_tipo_atividade=" AND atividade_tipo_id='{$_GET['tipo_atividade_id']}' ";
	}
	
	
	// SQL PARA LISTAR TODOS OS REGISTROS
	
	
	if(isset($_GET['projeto_id'])&&$_GET['projeto_id']!='0'){
		$filtro_projeto=" AND projeto_id='{$_GET['projeto_id']}' ";
	}
	
	if(isset($_GET['tipo_atividade_id'])&&$_GET['tipo_atividade_id']!='0'){
		$filtro_tipo_atividade=" AND atividade_tipo_id='{$_GET['tipo_atividade_id']}' ";
	}
	if(isset($_GET['situacao_id']) && $_GET['situacao_id'] != '99'   ){
		$filtro_tipo_situacao=" AND situacao='{$_GET['situacao_id']}'  ";
	}
	
	
	$q_total=mysql_fetch_object(mysql_query($t="
	SELECT
		TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(tempo_estimado_horas))),'%H:%i') AS horas,

		TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(tempo_finalizado_hora))),'%H:%i') AS hora_final	
	FROM 
		projetos_atividades 
	WHERE 
		vkt_id='$vkt_id' 
	AND 
		funcionario_id = $login_id 
	
		$filtro_funcionario 
		$filtro_projeto 
		$filtro_tipo_atividade"));
	
	if($_GET['data_conclusao']){
		$data_conclusao = dataBrToUsa($_GET['data_conclusao']);		
		$data_conclusao = "'$data_conclusao'"	;
	}else{
		$data_conclusao = "date(now())"	;
	}
	
	$q = mysql_query($t="
			SELECT 
				* 
			FROM 
				projetos_atividades 
			WHERE 
				vkt_id='$vkt_id' 
			AND
				situacao ='1'
			AND 
				funcionario_id = '$login_id'
			AND
			date(data_hora_fim)=$data_conclusao
		/*	AND */
			/*	date(data_hora_fim) = date(now()) */
			ORDER BY 
				data_hora_fim DESC ");
			
	while($r=mysql_fetch_object($q)){
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
		$atividade=mysql_fetch_object(mysql_query("SELECT nome FROM projetos_atividades_tipos WHERE id='{$r->atividade_tipo_id}'"));
		if($r->situacao=='1'){$ch='checked="chekced"';}else{$ch='';}
	?>
    <tr <?=$sel?> ri="<?=$r->id?>"  >
      <td ><input type="checkbox" <?=$ch?> style="visibility:<?=$visibility?>" /> <span class='exa' id="<?=$r->id?>" ><?=$r->situacao. $r->nome;?></span></td>
      <td width="60" id='f<?=$r->id?>'><?php
          $estimado = substr($r->tempo_estimado_horas,0,5); echo $estimado;
		  ?></td>
      <td width="60" id='g<?=$r->id?>'><?php
		  $gasto = substr($r->tempo_finalizado_hora,0,5); echo $gasto;
          ;?></td>
      <td width="60" id='h<?=$r->id?>'><?php
		  $gasto = substr($r->tempo_finalizado_hora,0,5); echo $gasto;
          ;?></td>
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
	  Produtivo 
	  <?
 	  if($_GET[data_conclusao]){
		   $data_conclusao=$_GET[data_conclusao];
	}else{
	   $data_conclusao=date("d/m/Y");
	}     
echo 	  soma_horas_dia(dataBrToUsa($data_conclusao));
	  ?>
      
      </td>
      <td width="60" >03:22</td>
      <td width="60" >03:22</td>
      <td width="60" >02:00</td>
      </tr>
  </tfoot>
</table>
</div>
</div>
<div id='rodape'>
	
</div>
<script>
// Fecha aba de menu

		$("#menu").animate({
			'marginLeft': -210,
			
		  }, 0);
		$("#conteudo").animate({
			'marginLeft': 10
		  }, 0);
		$("#rodape").animate({
			'marginLeft': 10
		  }, 0);
				   $("#some").html("&raquo;")

////

</script>

