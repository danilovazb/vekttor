 <?
include("_functions.php");
include("_ctrl.php"); 

//echo $diasemana->dia_semana;
$diasemana = $semana_extenso[$diasemana->dia_semana];
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<div id='form_documento'></div>
<div id="some">«</div>
<a href="?" class='s1'>
  	Sistema
</a>
<a href="?" class='s2'>
  	RH
</a>
<a href="?tela_id=<?=$tela->id?>" class='navegacao_ativo'>
<span></span>    <?=$tela->nome?>
</a>

<script>
	$(".hora_entrada, .hora_saida_almoco, .hora_retorno_almoco, .hora_saida").live('blur',function(){
		
		var hora_entrada = $(this).parent().parent().find('.hora_entrada').val();
		var hora_saida_almoco = $(this).parent().parent().find('.hora_saida_almoco').val();
		var hora_retorno_almoco = $(this).parent().parent().find('.hora_retorno_almoco').val();
		var hora_saida = $(this).parent().parent().find('.hora_saida').val();
		var faltas = $(this).parent().parent().find('.faltas');
		var funcionario_id = $(this).parent().parent().find('.funcionario_id').val();
		var empresa_id = $("#empresa_id").val();
		var listagem = $("#listagem").val();
		//alert(listagem);
		if(listagem==1){
			var data_hora_extra = $("#data_hora_extra").val();	
		}else{
			var data_hora_extra = $(this).parent().parent().find(".data_hora_extra").val();
		}
		if(faltas.is(":checked")){
			faltas = 1;
			$(this).parent().parent().find('.hora_entrada').val('00:00');
			hora_entrada =0;
			$(this).parent().parent().find('.hora_saida_almoco').val('00:00');
			hora_saida_almoco=0;
			$(this).parent().parent().find('.hora_retorno_almoco').val('00:00');
			hora_retorno_almoco=0;
			$(this).parent().parent().find('.hora_saida').val('00:00');
			hora_saida=0;
			$('#t'+funcionario_id).html('0');
			$('#s'+funcionario_id).html('0');
			$('#n'+funcionario_id).html('0');
		}else{
			faltas = 0;
		}
		
		calcula_hora_extra(hora_entrada,hora_saida_almoco,hora_retorno_almoco,hora_saida,faltas,funcionario_id,empresa_id,data_hora_extra,faltas,listagem);
					
		
	 	
	 });
	 $(".faltas").live('click',function(){
	 	
		var hora_entrada = $(this).parent().parent().find('.hora_entrada').val();
		var hora_saida_almoco = $(this).parent().parent().find('.hora_saida_almoco').val();
		var hora_retorno_almoco = $(this).parent().parent().find('.hora_retorno_almoco').val();
		var hora_saida = $(this).parent().parent().find('.hora_saida').val();
		var faltas = $(this).parent().parent().find('.faltas');
		//var faltas = 0;
		var funcionario_id = $(this).parent().parent().find('.funcionario_id').val();
		var empresa_id = $("#empresa_id").val();
		var listagem = $("#listagem").val();
		//var data_hora_extra = $("#data_hora_extra").val();
		var faltas = $(this).parent().parent().find('.faltas');
		if(listagem==1){
			var data_hora_extra = $("#data_hora_extra").val();	
		}else{
			var data_hora_extra = $(this).parent().parent().find(".data_hora_extra").val();
		}
		
		//alert(data_hora_extra);
		if(faltas.is(":checked")){
			faltas = 1;
			$(this).parent().parent().find('.hora_entrada').val('00:00');
			hora_entrada =0;
			$(this).parent().parent().find('.hora_saida_almoco').val('00:00');
			hora_saida_almoco=0;
			$(this).parent().parent().find('.hora_retorno_almoco').val('00:00');
			hora_retorno_almoco=0;
			$(this).parent().parent().find('.hora_saida').val('00:00');
			hora_saida=0;
			
			if(listagem == 1){
				
			  $('#t'+funcionario_id).html('0');
			  $('#s'+funcionario_id).html('0');
			  $('#n'+funcionario_id).html('0');
			}else{
			  dia = data_hora_extra.slice(0,2);
			  //alert(dia);								
		      $('#t'+dia).html('0');
			  $('#s'+dia).html('0');
			  $('#n'+dia).html('0');	
			}
		
		}else{
			faltas = 0;
		}
	
		calcula_hora_extra(hora_entrada,hora_saida_almoco,hora_retorno_almoco,hora_saida,faltas,funcionario_id,empresa_id,data_hora_extra,faltas,listagem);
	    
	 });

	function calcula_hora_extra(hora_entrada,hora_saida_almoco,hora_retorno_almoco,hora_saida,faltas,funcionario_id,empresa_id,data_hora_extra,faltas,listagem){
		//alert(hora_entrada+" "+hora_saida_almoco+" "+hora_retorno_almoco+" "+hora_saida);
		$.post('modulos/rh/hora_extra/calcula_hora_extra.php',{hora_entrada:hora_entrada,hora_saida_almoco:hora_saida_almoco,hora_retorno_almoco:hora_retorno_almoco,hora_saida:hora_saida,empresa_id:empresa_id,funcionario_id:funcionario_id,data_hora_extra:data_hora_extra,faltas:faltas},function(data){
		
						
			id_numbers = JSON.parse(data);
			
			total_dia = id_numbers.total_dia;
			
			saldo     = id_numbers.saldo_dia;	
			
			adicional_noturno = id_numbers.adicional_noturno;
			//alert(total_dia);
			//alert($(this).val());
			if(listagem == 1){ 
				
				$('#t'+funcionario_id).html(total_dia);
				$('#s'+funcionario_id).html(saldo);
				$('#n'+funcionario_id).html(adicional_noturno);	
			}else{
				dia = data_hora_extra.slice(0,2);
								
				$('#t'+dia).html(total_dia);
				$('#s'+dia).html(saldo);
				$('#n'+dia).html(adicional_noturno);

			}
		//alert(data);
			return id_numbers;
		});
		
	}

	$("#anterior").live('click',function(){
		
		var empresa_id = $("#empresa_id").val();
		var data = $("#data_anterior_hora_extra").val();
		
		location.href='?tela_id=442&empresa1id='+empresa_id+'&data='+data;
	});
	
	$("#proximo").live('click',function(){
		
		var empresa_id = $("#empresa_id").val();
		var data = $("#data_proximo_hora_extra").val();
		
		location.href='?tela_id=442&empresa1id='+empresa_id+'&data='+data;
	});
	
</script>

<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
</div>
<div id="barra_info"> 
	
	<input type="hidden" name="empresa_id" id="empresa_id" value="<?=$cliente_fornecedor->id?>">
    
    <?php
    if($_GET['funcionario_id']>0&&$_GET['empresa1id']>0&&$_GET['mes']>0&&$_GET['ano']>0	){ 
	?>
		<input type="button" value="Hora Extra Por Dia" onclick="location.href='?tela_id=442&empresa1id=<?=$_GET['empresa1id']?>&data=<?=$_GET['data']?>'"/>
        <select name="funcionario_id" id='funcionario_id' style="width:150px;" 
        onchange="location='?tela_id=442&empresa1id=<?=$_GET[empresa1id]?>&ano=<?=$_GET['ano']?>&mes=<?=$_GET['mes']?>&funcionario_id='+$('#funcionario_id').val()+'&data=<?=$_GET['data']?>'">
			<?
            
            $rs=mysql_query("SELECT * FROM 
                                    rh_funcionario
                                    
                                  WHERE
                                    empresa_id='".$_GET['empresa1id']. "' AND 
                                    status!='demitidos' AND
                                    vkt_id='$vkt_id'
                                    $filtro
                                    ORDER BY nome
                                    ");
            while($r= mysql_fetch_object($rs)){
                
                if($_GET[funcionario_id]== $r->id){$selec ='selected="selected"';}else{$selec ='';}
            ?>
					<option  value="<?=$r->id?>" <?=$selec?>><?=$r->nome?></option>
    		<?
			}
			?>
</select>
		</label>
   	<?php
	}else{
	?>
	<a class="bt_left" id="anterior"></a>
       <input type="hidden"  name="data_anterior_hora_extra" id="data_anterior_hora_extra" style="width:75px;height:9px;margin-top:4px;" mascara="__/__/____" value="<?=DataUsaToBr($dia_anterior->dia_anterior)?>"/> 
       <input type="text" class="nPaginacao" name="data_hora_extra" id="data_hora_extra" style="width:75px;height:9px;margin-top:4px;" mascara="__/__/____" value="<?=DataUsaToBr($data_folha)?>"/>
       <input type="hidden" name="data_proximo_hora_extra" id="data_proximo_hora_extra" style="width:75px;height:9px;margin-top:4px;" mascara="__/__/____" value="<?=DataUsaToBr($proximo_dia->proximo_dia)?>"/>  
    <a class="bt_rigth" id="proximo"></a>
	<?=$diasemana?>
    <input type="button" value="Hora Extra Por Funcionário" onclick="window.open('modulos/rh/hora_extra/form_hora_funcionario.php?empresa1id=<?=$_GET['empresa1id']?>&data=<?=$_GET['data']?>','carregador')"/>
	<?php
    }
	
	?>
	
    <strong>EMPRESA:</strong> <?=$cliente_fornecedor->razao_social?>
    
    
 
  </div>
  <div style="clear:both"></div>
 <?php
  		if($_GET[mes]<10){
				$mes = '0'.$_GET[mes];	
			}else{
				$mes = $_GET[mes];
			}
	if($_GET['funcionario_id']>0&&$_GET['empresa1id']>0&&$_GET['mes']>0&&$_GET['ano']>0	){
		include('hora_extra_funcionario2.php');
		exit;
	}
	?>

 <table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="209">Funcionário</td>
          	<td width="60" >Entrada</td>
            <td width="90" >Saída Almoço</td>
            <td width="90" >Retorno Almoço</td>
       	 	<td width="60" >Saída</td>
            <td width="35" >Faltas</td>
            <td width="35" >Total</td>
            <td width="35" >Saldo</td>
            <td width="100" >Adicional noturno</td>
          	<td width=""></td>
			
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<input type="hidden" name="listagem" id="listagem" value="1" />
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    <?
	
	if(!empty($_GET['busca'])){
		$filtro = " AND nome like '%".$_GET['busca']."%'";
	}
	$registros= mysql_result(mysql_query("SELECT count(*) FROM 
					  	rh_funcionario 
					  WHERE
					  	empresa_id='$cliente_fornecedor->id' AND 
					  	vkt_id='$vkt_id'
						$filtro"),0,0);
	$q = mysql_query($t="SELECT * FROM 
					  	rh_funcionario
					  	
					  WHERE
					   	empresa_id='$cliente_fornecedor->id' AND 
					  	status!='demitidos' AND
						vkt_id='$vkt_id'
						$filtro
						ORDER BY nome
						LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	//echo $t;
	
	while($r=mysql_fetch_object($q)){
		$hora_extra = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_hora_extra WHERE empresa_id='$cliente_fornecedor->id' AND funcionario_id='$r->id' AND data='$data_folha' AND vkt_id='$vkt_id'"));
		$hora_entrada = substr($hora_extra->hora_entrada,0,-3);
		$hora_saida_almoco = substr($hora_extra->hora_saida_almoco,0,-3);
		$hora_retorno_almoco = substr($hora_extra->hora_retorno_almoco,0,-3);
		$hora_saida = substr($hora_extra->hora_saida,0,-3);
		$faltas     = $hora_extra->falta_integral;
		//echo $t.mysql_error();
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
	?>       
    	<tr <?=$sel ?>>
          	<td width="209">
				<?=$r->nome?>
            	<input type="hidden" name="funcionario_id" class="funcionario_id" value="<?=$r->id?>">
            </td>
          	<td width="60" ><input type="text" name="hora_entrada" class="hora_entrada" style="width:40px;height:10px;" sonumero="1" mascara="__:__" value="<?=$hora_entrada?>"></td>
            <td width="90" align="center"><input type="text" class="hora_saida_almoco" style="width:40px;height:10px;" sonumero="1" mascara="__:__" value="<?=$hora_saida_almoco?>"></td>
            <td width="90" align="center"><input type="text" class="hora_retorno_almoco" style="width:40px;height:10px;" sonumero="1" mascara="__:__" value="<?=$hora_retorno_almoco?>"></td>
       	 	<td width="60" ><input type="text" name="hora_saida" class="hora_saida" style="width:40px;height:10px;" sonumero="1" mascara="__:__" value="<?=$hora_saida?>"></td>
            <td width="35" ><input type="checkbox" name="faltas" class="faltas" <?php if($faltas==1){echo "checked='checked'";}?>></td>
            <td width="35" id="t<?=$r->id?>"><?=MoedaUsaToBr($hora_extra->total)?></td>
            <td width="35" id="s<?=$r->id?>"><?=MoedaUsaToBr($hora_extra->saldo_horas)?></td>
            <td width="100" id="n<?=$r->id?>"><?=MoedaUsaToBr($hora_extra->adicional_noturno)?></td>
          	<td width=""></td>
        </tr>
      
<?
	}
?>
    	
    </tbody>
</table>
<?
//print_r($_POST);
?>
</div>

<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="209"></td>
            <td width="98"align="right"></td>
            <td width=""></td>
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
<script>
$('#sub93').show();
$('#sub418').show()
</script>