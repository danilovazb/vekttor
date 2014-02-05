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
$("#empresa_id2").live('change',function(){
	location.href='?tela_id=<?=$_GET['tela_id']?>&empresa_id='+$(this).val();
});
</script>

<div id='conteudo'>
<div id='navegacao'>

<div id="some">«</div>

<a href="" class='s1'>
  	Sistema
</a>
<a href="" class='s2'>
  	RH
</a>
<a href="?tela_id=<?=$tela->id?>" class='navegacao_ativo'>
<span></span>    <?=$tela->nome?><form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
</div>

<div id="barra_info">
	<label>
    
    	Empresa
        <?php
			$empresas = mysql_query("
				SELECT *, cf.id as cliente_forencedor_id FROM 
					rh_empresas re,
					cliente_fornecedor cf 
				WHERE 
					re.cliente_fornecedor_id = cf.id AND
					cf.tipo='Cliente' AND 
					cf.tipo_cadastro='Jurídico' AND 
					re.vkt_id ='$vkt_id' AND 
					re.status='1'
			");
			
		?>
        <select name="empresa_id2" id="empresa_id2">
        	<option value="">SELECIONE UMA EMPRESA</option>
        <?php
			while($r=mysql_fetch_object($empresas)){
				if($_GET['empresa_id']==$r->cliente_forencedor_id){
					$selected="selected='selected'";
				}
		?>
        	<option value="<?=$r->id?>" <?=$selected?>><?=$r->razao_social?></option>
        <?php
				$selected='';
			}
		?>
        </select>
    </label>
  <a href="modulos/rh/cargos_salarios/form.php" target="carregador" class="mais"></a>
</div>
<script>
$(document).ready(function (){ 
	$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
	
		window.open('modulos/rh/cargos_salarios/form.php?id='+id,'carregador');
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
          <td width="100">CBO</td>
          <td width="200">Cargo</td>
          <td width="50">Sal&aacute;rio</td>
           <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
	<?php 
		/*if($cliente_tipo_id!='7'){
			$filtro_servicos=" WHERE c.imobiliaria_id='$login_id' ";
		}else{
			$filtro_corretores=' WHERE 1=1 ';
		}*/
		if(!empty($_GET['busca'])){
			$filtro = " AND cargo like '%".$_GET['busca']."%'";
		}
		
		if($_GET['empresa_id']>0){
			$filtro=" AND empresa_id=".$_GET['empresa_id'];
		}
		
		$registros= mysql_result(mysql_query($t="SELECT count(*) FROM cargo_salario WHERE vkt_id='$vkt_id'
							$filtro"),0,0);
		
		$sql = mysql_query($t="SELECT
								*
							FROM cargo_salario WHERE vkt_id='$vkt_id'
							$filtro
						");
						
		echo mysql_error();	
				while($r=mysql_fetch_object($sql)){
		
	?>      
    	<tr <?=$sel?> id="<?=$r->id?>" >
          <td width="60"><?=$r->id?></td>
          <td width="100"><?=$r->cbo?></td>
          <td width="200"><?=$r->cargo;?></td>
          <td width="50"><?=moedaUsaToBr($r->valor_salario);?></td>
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
