<?php
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
?>
<div id='form_socio'></div>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
.btf{ display:block; float:left; width:15px; height:15px; background-image:url(../fontes/img/formatacao.gif);margin-top:5px;text-decoration:none;}
	.bold{ background-position:-2px -17px;}
	.italic{ background-position:-20px -17px; }
	.underline{ background-position:-58px -16px;}
	.justifyleft{ background-position:-2px 0px;margin-left:50px}
	.justifycenter{ background-position:-20px 0px;}
	.justifyright{ background-position:-38px 0px;}
	.justifyfull{ background-position:-57px 0px;}
	.insertunorderedlist{background-position:-19px -51px;margin-left:50px;}
	.insertorderedlist{ background-position:-37px -51px;}
</style>
<script>
	
	$("#impressao_relatorio").live('click',function(){
		window.open('modulos/rh/hora_extra/form.php','carregador')
	});
	
	$("#empresa_id").live('change',function(){
		var empresa_id = $(this).val();
		if(empresa_id>0){
			$("#divfuncionario").show();
			$("#divfuncionario").load("modulos/rh/solicitacao_hora_extra/_ctrl.php?action=SelFuncionario&empresa_id="+empresa_id);
		}else{
			$("#divfuncionario").html('');
			$("#divfuncionario").hide();
		}
	});
	
	$("#fempresa_id").live('change',function(){
		var empresa_id = $(this).val();
		
		if(empresa_id>0){
			$("#fdivfuncionario").show();
			$("#fdivfuncionario").load("modulos/rh/solicitacao_hora_extra/_ctrl.php?action=SelFuncionario&empresa_id="+empresa_id);
		}else{
			$("#fdivfuncionario").html('');
			$("#fdivfuncionario").hide();
		}
	});
	
</script>
<div id='conteudo'>
<div id='navegacao'>
<!--<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>-->
<div id="some">«</div>
<a href="./" class='s1'>
  	Sistema 
</a>
<a href="./" class='s2'>
    RH 
</a>
<a href="#" class="navegacao_ativo">
<span></span>    <?=$tela->nome?> 
</a>
</div>
<div id="barra_info">

	<a href="<?=$caminho?>form.php" target="carregador" class="mais"></a>

	<form method="get">
    	<label style="width:170px;float:left;margin-top:4px;">
        <select name="fempresa_id" id="fempresa_id" valida_minlength="2" retorno"focus|Selecione uma Empresa">
          	
            <option value="">Selecione uma Empresa</option>  	
            
            <?php
				while($r=mysql_fetch_object($q)){
					if($r->id==$_GET['fempresa_id']){$selected="selected='selected'";}
					if($solicitacao_hora_extra->empresa_id==$r->id){
						$selected="selected='selected'";
					}
					echo "<option value='$r->id' $selected>$r->razao_social</option>";				
					$selected='';
				}
				
			?>    
                
            </select>
        </label>
        <?php
			if($_GET['funcionario_id']>0){
				$display="block";
				
				$funcionarios=selecionaFuncionario($_GET['fempresa_id'],$_GET['funcionario_id']);	
			}else{
				$display="none";
			}
		?>
    	<div id="fdivfuncionario" style="width:170px;display:<?=$display?>;float:left;margin-top:4px;">
        	
			<?=$funcionarios?>
      </div>
      
      <label style="float:left;width:120px;">
      	De
      	<input type="text" name="f_data_inicio" id="f_data_inicio" value="<?=$_GET['f_data_inicio']?>" calendario="1" sonumero="1" style="width:80px;height:9px;"/>
      </label>
      <label style="float:left;">
      	Ate
      	<input type="text" name="f_data_fim" id="f_data_fim" value="<?=$_GET['f_data_fim']?>" calendario="1" sonumero="1" style="width:80px;height:9px;"/>
      </label>
      
      <input type="submit" value="ir" style="float:left;margin-top:3px;margin-left:3px;"/>
      <input type="hidden" name="tela_id" value="<?=$tela->id?>" />
    </form>  
 
  	 
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="200">Funcionário</td>
            <td width="200">Empresa</td>
          	<td width="80">Data</td>
            <td width="60">Início</td>
            <td width="60">Fim</td>
            <td width="60">Total</td>
          	<td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	
	<?
	
	$filtro = '';
	if($_GET[fempresa_id]>0){
		$filtro.= " AND she.empresa_id=$_GET[fempresa_id]";
	}
	if($_GET[funcionario_id]>0){
		$filtro.= " AND she.funcionario_id=$_GET[funcionario_id]";
	}
	if(isset($_GET['data_inicio'])&&isset($_GET['data_fim'])){
		$filtro=" AND data BETWEEN '".$_GET['data_inicio']."' AND '".$_GET['data_inicio']."'";
	}
	
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="she.data DESC";
	}
	$registros= mysql_result(mysql_query("SELECT COUNT(*) FROM 
			rh_empresas re,
			cliente_fornecedor cf
		WHERE 
			re.cliente_fornecedor_id = cf.id AND
			cf.tipo='Cliente' AND 
			cf.tipo_cadastro='Jurídico' AND 
			re.vkt_id ='$vkt_id' AND 
			re.status='1'
		"),0,0);
	// colocar a funcao da paginaçao no limite
	$q= mysql_query($t="SELECT *, she.id as she_id
	
	FROM 
		rh_solicitacao_hora_extra she,
		cliente_fornecedor cf,
		rh_funcionario rh_f 
		WHERE 
		she.vkt_id='$vkt_id' AND
		she.empresa_id = cf.id AND
		she.funcionario_id=rh_f.id
		$filtro 
		ORDER BY ".$ordem." ".$_GET['ordem_tipo']." LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	echo mysql_error();
	while($r=mysql_fetch_object($q)){
		$total_hora = mysql_fetch_object(mysql_query("SELECT TIMEDIFF('$r->hora_fim','$r->hora_inicio') as total"));
		
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}

	?>
<tr <?=$sel?>>
<td width="200" onclick="window.open('<?=$caminho?>form.php?id=<?=$r->she_id?>','carregador')"><?=$r->nome?></td>
<td width="200" onclick="window.open('<?=$caminho?>form.php?id=<?=$r->she_id?>','carregador')"><?=$r->nome_fantasia?></td>
<td width="80"><?=DataUsaToBr($r->data)?></td>
<td width="60"><?=substr($r->hora_inicio,0,5)?></td>
<td width="60"><?=substr($r->hora_fim,0,5)?></td>
<td width="60"><?=substr($total_hora->total,-8,5)?></td>
<td><a href="<?=$caminho?>/impressao_solicitacao.php?id=<?=$r->she_id?>" target="_blank">Imprimir</a></td>
</tr>
<?
	}
	?>	
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="50">&nbsp;</td>
           <td width="230"><a>Total: <?=$total?></a></td>
           <td width="130">&nbsp;</td>
           <td width="110">&nbsp;</td>
           <td width="80">&nbsp;</td>
		   <td width="110">&nbsp;</td>
           <td></td>
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
