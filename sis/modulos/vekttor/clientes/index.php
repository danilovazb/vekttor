<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
?>
<style>
.exibe_formulario fieldset div.submodulos label{margin:0;}
.formcheck a:hover{background:#E0E0E0;}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />

<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
     
     <label style="width:300px;">
	
    </label>
    <input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<script>
	$(document).ready(function(){
			$("tr:odd").addClass ('al');
	});
	
	$(".exibe_modulos").live('click',function(){
		id = $(this).attr('r');
		$(".exibe_modulos").css('font-weight','normal');
		$(this).css('font-weight','bold');
		$(".submodulos").hide();

		$("#div"+id).show();
			
	
	})
	
	$("#marcarTodos").live("click",function(){
		//alert(this.checked);
		if(this.checked==true){
			$(this).parent().parent().find(".modulo_id").attr("checked","checked");			
		}else{
			$(this).parent().parent().find(".modulo_id").removeAttr("checked");
			
		}
	});
	
	$(".modulo_id").live("click",function(){
		id = $(this).val();

		if(this.checked==true){
			$(".sub"+id).attr("checked","checked");			
		}else{
			$(".sub"+id).removeAttr("checked");						
		}
		
	});
	/*$("#revendedor_id").live("change",function(){
		var status = $("#status").val();
		
		location.href='?tela_id=<?=$_GET['tela_id']?>&revendedor_id='+$(this).val()+'&status='+status;
	});
	
	$("#status").live("change",function(){
		var revendedor_id = $("#revendedor_id").val();
		
		location.href='?tela_id=<?=$_GET['tela_id']?>&revendedor_id='+revendedor_id+'&status='+$(this).val();
	});*/
	$("#cliente_grupo_id").live('change',function(){
		if($(this).val()=='novo'){
			window.open('modulos/vekttor/clientes/form_grupo.php','carregador');
		}else
		if($(this).val()=='editar'){
			window.open('modulos/vekttor/clientes/form_grupo.php?actionGrupo=edicao_grupo','carregador');
		}
	});
	$("#edicao_grupo").live('change',function(){
		var grupo_id = $(this).val();
		window.open('modulos/vekttor/clientes/form_grupo.php?grupo_id='+grupo_id,'carregador');
	});
</script>
<div id="some">«</div>
<a href="./" class='s1' >
  	Sistema
</a>
<a href="./" class='s2'>
    Vekttor 
</a>
<a href="?tela_id=<?=$tela->id?>" class="navegacao_ativo">
<span></span>    <?=$tela->nome?> 
</a>
</div>
<div id="barra_info">
    <a href="<?=$caminho?>form.php" target="carregador" class="mais"></a>
<form method="get">
	<select name="cliente_grupo_id" id="cliente_grupo_id" style="float:left; margin-top:5px;">
    	<option value="" style="font-weight:bold;color:#000;">Grupos</option>
        <option value="novo" style="margin-left:10px;">Adicionar</option>
        <option value="editar" style="margin-left:10px;">Editar</option>
        <option value="" disabled="disabled" style="font-weight:bold;color:#000;">Selecione Um Grupo</option>
		<?php
			$grupos = mysql_query("SELECT * FROM clientes_vekttor_grupos WHERE vkt_id='$vkt_id' ORDER BY nome");
			while($grupo = mysql_fetch_object($grupos)){
					$clientes = @mysql_result(mysql_query($t="SELECT COUNT(*) FROM clientes_vekttor where grupo_id='$grupo->id' AND status='1'"),0,0);
		?>
        	<option value="<?=$grupo->id?>" <?php if($grupo->id==$_GET['cliente_grupo_id']){ echo "selected='selected'";}?> style="margin-left:10px;"><?=$grupo->nome." ($clientes)"?></option>
        <?php
			}
		?>
    </select>
	<?php
	 	$revendedoras = mysql_query($t="SELECT *, rf.id as rf_id FROM revenda_franquia rf, cliente_fornecedor cf
														WHERE rf.cliente_fornecedor_id = cf.id
														");
	 	//echo $t;
	 ?>
    <select name="revendedor_id" id="revendedor_id">
    	<option>Revendedoras</option>
    	<?php
			while($revendedora = mysql_fetch_object($revendedoras)){
				if($_GET['revendedor_id']==$revendedora->rf_id){
					$select="selected=selected";
				}
				echo "<option value='$revendedora->rf_id' $select>$revendedora->razao_social</option>";
				$select = '';
			}
			
		?>
    </select>
    
    <select name="status" id="status">
    	<option value="">Status</option>
    	<option value='1' <? if($_GET['status']=='1'){echo "selected='selected'";}?>>Ativo</option>
		<option value='2' <? if($_GET['status']=='2'){echo "selected='selected'";}?>>Inativo</option>	
	<input type="submit" name="acao" value="Filtrar" />	
    </select>
    <input type="hidden" name="tela_id" id="tela_id" value="160" />
</form>

	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="230"><?=linkOrdem("Nome","nome_fantasia",1)?></td>
            <td width="130">Usu&aacute;rio</td>
          	<td width="130"><?=linkOrdem("Grupo","grupo_id",0)?></td>
          	<td width="130"><?=linkOrdem("Revendedora","cnpj_cpf",0)?>/SMS</td>
            <td><?=linkOrdem("Último Login","ultimo_acesso",0)?></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	
	<?php
	$filtro = '';
	if(strlen($_GET[busca])>0){
		$busca_add = "AND clientes_vekttor.nome like '%{$_GET[busca]}%'";
	}
	if($_GET['revendedor_id']>0){
		$filtro_revendedora= ", vekttor_venda";
		$filtro.= " AND
					vekttor_venda.cliente_vekttor_id = clientes_vekttor.id AND
					vekttor_venda.revenda_franquia_id='".$_GET['revendedor_id']."'";
	}
	
	if($_GET['cliente_grupo_id']>0){
		$filtro .= "AND grupo_id='".$_GET['cliente_grupo_id']."'";
	}
	if($_GET['sataus']){
		$filtro .= "AND status='".$_GET['status']."'";
	}else{
		$filtro .= "AND status='1'";
		}
	
	if($_GET[ordem]){
		$ordem ="$_GET[ordem] $_GET[ordem_tipo]";
	}else{
		$ordem ='ultimo_acesso DESC';
	}
	
	// colocar a funcao da paginação no limite
	$registros= mysql_result(mysql_query("SELECT COUNT(*) FROM clientes_vekttor WHERE  1=1 $busca_add $filtro"),0,0);
	//$q= mysql_query($t="SELECT * FROM clientes_vekttor $filtro LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	$q=mysql_query($t="SELECT 
	*,
	DATE_FORMAT(ultimo_acesso,'%d/%m/%Y às %H:%i') as data_ultimo_acesso,
	DATEDIFF(NOW(),ultimo_acesso) as dias, 
	TIMEDIFF(NOW(),ultimo_acesso) as horas
	
	FROM clientes_vekttor $filtro_revendedora WHERE 1=1 $busca_add $filtro ORDER BY $ordem LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));	
	//echo $t.mysql_error();
//$q=mysql_query($t="SELECT * FROM clientes_vekttor");
	while($r=mysql_fetch_object($q)){
		$usuario = mysql_fetch_object(mysql_query($t="SELECT * FROM usuario WHERE cliente_vekttor_id='$r->id' ORDER BY id LIMIT 1"));
		
		//$acesso = mysql_fetch_object(mysql_query("SELECT * FROM `sis_modulos_avaliacao` WHERE vkt_id = '$r->id' ORDER BY id DESC limit 1"));
		//$ultimo_acesso = explode(" ",$acesso->datahora);
		
		if(empty($_GET['status'])||$usuario->status==$_GET['status']){
		//verifica de qual venda o cliente veio
		$venda = @mysql_fetch_object(mysql_query("SELECT * FROM vekttor_venda WHERE cliente_vekttor_id=$r->id"));
		$grupo = @mysql_fetch_object(mysql_query("SELECT * FROM clientes_vekttor_grupos WHERE id='$r->grupo_id'"));
		//echo $venda->id."<br>";
		//verifica qual é a revendedora
		$revendedora = @mysql_fetch_object(mysql_query($t="SELECT 
													* 
												FROM 
													revenda_franquia rf,
													cliente_fornecedor cf
												WHERE 
													rf.cliente_fornecedor_id=cf.id AND
													rf.id = $venda->revenda_franquia_id"));
		
		//echo $t;
		
		$total_sms = conta_sms_mes($r->id);
		if($total_sms<=$r->quantidade_sms_mes){
			$sms = $revendedora->razao_social."($r->quantidade_sms_mes/".$total_sms.")";
		}else{
			$sms = "<spam style='color:red'> $revendedora->razao_social ($r->quantidade_sms_mes/".$total_sms.")</scpan>";
		}
	?>
<tr <?=$sel?>onclick="window.open('<?=$caminho?>form.php?cliente_id=<?=$r->id?>','carregador')">
<td width="230"><?=str_pad($r->id,3,'0',STR_PAD_LEFT).'-'.$r->nome?></td>
<td width="130"><?=$usuario->login?></td>
<td width="130"><?=$grupo->nome?></td>
<td width="130"><?=$sms?></td>

<td><?=$r->data_ultimo_acesso." à $r->dias dias".' - '.$r->horas?></td>
</tr>
<?
		}
	}
	?>	
    </tbody>
</table>

<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="50">&nbsp;</td>
           <td width="230"><a>Total: <?=$total?></a></td>
           <td width="130">&nbsp;</td>
           <td width="130">&nbsp;</td>
           <td width="110">&nbsp;</td>
           <td width="80">&nbsp;</td>
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
