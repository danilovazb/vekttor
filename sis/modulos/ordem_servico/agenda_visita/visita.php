<?
session_start();
// funçoes do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

$(document).ready(function(){	
});

$("#data_visita").live("blur",function(){
	var tecnico = $("#tecnico_id").val();
	if(tecnico>0){ 
		horasTecnico();
	}
});

$("#tecnico_id").live("change",function(){
	var data = $("#data_visita").val();
	if(data!='00/00/0000'){
		horasTecnico();
	}
});

function horasTecnico(){
	
	var data = $("#data_visita").val();
	var tecnico = $("#tecnico_id").val();
	var id = $("#id").val();
	//alert(id);
	$("#hora_inicial").removeAttr("disabled");
	$("#hora_final").removeAttr("disabled");	
	window.open("modulos/ordem_servico/agenda_visita/form.php?tecnico_id="+tecnico+"&data="+data+"&id="+id,"carregador");

}
</script>

<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
<a href="?tela_id=281" class='s1'>
  	SISTEMA
</a>
<a href="?tela_id=281" class='s2'>
  	OS
</a>
<a href="?tela_id=281" class='navegacao_ativo'>
<span></span>   Agenda de Visitas
</a>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
</div>

<div id="barra_info">
<form method="get">
  Data: <input type="text" name="data" id="data" calendario="1" sonumero="1" size="8" value="<?=$_GET['data']?>" style="height:8px;"/>
  <label style="width:150px;">
        <select name="status_visita">
		<option value="">STATUS</option>
		<option <?php if($_GET['status_visita']=='Pendente'){echo 'selected=selected';}?>>Pendente</option>
        <option <?php if($_GET['status_visita']=='Cancelado'){echo 'selected=selected';}?>>Cancelado</option>
        <option <?php if($_GET['status_visita']=='Visitado'){echo 'selected=selected';}?>>Visitado</option>
        </select>
   </label>
   <select name="tecnico_id">
		<option value="">TÉCNICO</option>
		<?php
        	$tecnicos = mysql_query("SELECT * FROM rh_funcionario WHERE vkt_id='$vkt_id'");
			while($t=mysql_fetch_object($tecnicos)){
				if($_GET['tecnico_id']==$t->id){$selected='selected=selected';}
				else{$selected='';}
				echo "<option value='$t->id' $selected>$t->nome</option>";
			
			}
		?>
        </select>
         Hora Inicial
		<input type="text" name="hora_inicial" id="hora_inicial" mascara="__:__"
        sonumero="1"
        value="<?=$_GET['hora_inicial']?>" size="6" autocomplete="off" style="height:8px;"/>
         Hora Final
		<input type="text" name="hora_final" id="hora_final" mascara="__:__"
        sonumero="1" autocomplete="off"
        value="<?=$_GET['hora_final']?>" size="6" style="height:8px;"/>
        <input type="submit" value="Filtrar" />
        <input type="hidden" name="tela_id" id="tela_id" value="281" />
  <a href="modulos/ordem_servico/agenda_visita/form.php" target="carregador" class="mais"></a>
</form>
</div>
<script>
$(document).ready(function (){ 
	$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
	
		window.open('modulos/ordem_servico/agenda_visita/form.php?id='+id,'carregador');
	});
});
</script>
<script>
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
</script>
<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="60"><?=linkOrdem("Codigo","Codigo",1)?></td>
          <td width="70">Data</td>
          <td width="200">Cliente</td>
          <td width="200">Técnico</td>
          <td width="70">Hora Inicial</td>
          <td width="70">Hora Final</td>
          <td width="70">Status</td>
           <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
	<?php 
		$filtro='';
		if(!empty($_GET[data])){
			$filtro.=" AND os.data_visita='".DataBrToUsa($_GET[data])."'";
		}
		if(!empty($_GET[status_visita])){
			$filtro.=" AND os.status_visita='".$_GET[status_visita]."' ";
		}
		if(!empty($_GET[tecnico_id])){
			$filtro.=" AND os.funcionario_id='".$_GET[tecnico_id]."' ";
		}
		if(!empty($_GET[hora_inicial]) && !empty($_GET[hora_final])){
			$filtro.=" AND os.hora_inicial >= '".$_GET[hora_inicial]."' AND os.hora_final <= '".$_GET[hora_final]."' ";
		
		}else if(!empty($_GET[hora_inicial])){
			$filtro.=" AND os.hora_inicial >= '".$_GET[hora_inicial]."' ";
			
		}else if(!empty($_GET[hora_final])){
			$filtro.=" AND os.hora_final <= '".$_GET[hora_final]."' ";
		}
		
		if(!empty($_GET[busca])){
			$busca = " AND os.id='".$_GET[busca]."' OR cf.razao_social LIKE '%".$_GET[busca]."%'";
		}
		$registros= mysql_result(mysql_query("SELECT count(*) FROM os_agenda_visita os
							JOIN rh_funcionario f ON os.funcionario_id=f.id
							JOIN cliente_fornecedor cf ON os.cliente_id=cf.id
							WHERE os.vkt_id='$vkt_id' $filtro $busca"),0,0);
		$sql = mysql_query($t="SELECT
								*, os.id as os_id
							FROM os_agenda_visita os
							JOIN rh_funcionario f ON os.funcionario_id=f.id
							JOIN cliente_fornecedor cf ON os.cliente_id=cf.id
							WHERE os.vkt_id='$vkt_id' $filtro $busca
							ORDER BY os.id DESC
							LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
		//echo $t;			
		echo mysql_error();	
				while($r=mysql_fetch_object($sql)){
		
	?>      
    	<tr <?=$sel?> id="<?=$r->os_id?>" >
          <td width="60"><?=$r->os_id?></td>
           <td width="70"><?=dataUsaToBr($r->data_visita)?></td>
          <td width="200"><?=$r->razao_social?></td>
          <td width="200"><?=$r->nome?></td>
          <td width="70"><?=$r->hora_inicial?></td>
          <td width="70"><?=$r->hora_final?></td>
          <td width="70"><?=$r->status_visita?></td>
          <td></td>
        </tr>
<?php
				}
?>
    	
    </tbody>
</table>
<script>


</script>
<?
//print_r($_POST);
?>
</div>

<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black">
    <thead>
    	<tr>
        	<td width="20"></td>
          <td width="120">&nbsp;</td>
          <td width="120">&nbsp;</td>
          <td width="50"><?=$q_total->horas?></td>
          <td width="580"><?=$q_total->hora_final?></td>
          <td width="80">&nbsp;</td>
          <td ></td>
        </tr>
    </thead>
</table>

</div>

<div id='rodape'>
	<?=$registros?> Registros 
    <?
	if($_GET[limitador]<1){
		$limitador= 30;	
	}else{
		$limitador= $_GET[limitador];
	}
    $qtd_selecionado[$limitador]= 'selected="selected"'; 
	?>
    <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&pagina=<?=$_GET[pagina]?>&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&limitador='+this.value">
        <option <?=$qtd_selecionado[15]?> >15</option>
        <option <?=$qtd_selecionado[30]?>>30</option>
        <option <?=$qtd_selecionado[50]?>>50</option>
        <option <?=$qtd_selecionado[100]?>>100</option>
  </select>
  Por P&aacute;gina 
  
  
    <div style="float:right; margin:0px 20px 0 0">
    <?=paginacao_links($_GET[pagina],$registros,$_GET[limitador])?>
    </div>
</div>
