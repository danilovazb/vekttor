 <? 
include("folha_pagamento_configuracao/_functions.php");
include("folha_pagamento_configuracao/_ctrl.php");
include("_functions.php");
include("_ctrl.php"); 

$caminho = $tela->caminho;
//echo $diasemana->dia_semana;
$numero_diasemana = $diasemana->dia_semana;
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
	$(".acao_funcionario").live('change',function(){
		var funcionario_id = $(this).parent().parent().find('.funcionario_id').val();
		var opcao = $(this).val();
		
		switch(opcao){
		
			case "1":
				window.open('modulos/rh/hora_extra/impressao_folha_ponto.php?mes=<?=substr($_GET['data'],3,2)?>&ano=<?=substr($_GET['data'],6,4)?>&empresa_id=<?=$_GET['empresa1id']?>&funcionario_id='+funcionario_id,'_blank');
			break;
			case "2":
				window.open('modulos/rh/hora_extra/impressao_hora_extra.php?mes=<?=substr($_GET['data'],3,2)?>&ano=<?=substr($_GET['data'],6,4)?>&empresa_id=<?=$_GET['empresa1id']?>&funcionario_id='+funcionario_id,'_blank');
			break;
			case "3":
				window.open('modulos/rh/hora_extra/impressao_adicional_noturno.php?mes=<?=substr($_GET['data'],3,2)?>&ano=<?=substr($_GET['data'],6,4)?>&empresa_id=<?=$_GET['empresa1id']?>&funcionario_id='+funcionario_id,'_blank');
			break;
			case "4":
				window.open('modulos/rh/hora_extra/impressao_hora_domingo.php?mes=<?=substr($_GET['data'],3,2)?>&ano=<?=substr($_GET['data'],6,4)?>&empresa_id=<?=$_GET['empresa1id']?>&funcionario_id='+funcionario_id,'_blank');
			break;
			case "5":
				window.open('modulos/rh/hora_extra/impressao_recibo.php?mes=<?=substr($_GET['data'],3,2)?>&ano=<?=substr($_GET['data'],6,4)?>&empresa_id=<?=$_GET['empresa1id']?>&funcionario_id='+funcionario_id+"&tipo=noturno",'_blank');
			break;
			case "6":
				location='?tela_id=442&empresa1id=<?=$_GET[empresa1id]?>&ano=<?=substr($_GET['data'],6,4)?>&mes=<?=substr($_GET['data'],3,2)?>&funcionario_id='+funcionario_id+'&data=<?=$_GET['data']?>';
			break;
			case "7":
				window.open('modulos/rh/hora_extra/impressao_recibo.php?mes=<?=substr($_GET['data'],3,2)?>&ano=<?=substr($_GET['data'],6,4)?>&empresa_id=<?=$_GET['empresa1id']?>&funcionario_id='+funcionario_id+"&tipo=domingo",'_blank');
			break;
			case "8":
				window.open('modulos/rh/hora_extra/impressao_recibo.php?mes=<?=substr($_GET['data'],3,2)?>&ano=<?=substr($_GET['data'],6,4)?>&empresa_id=<?=$_GET['empresa1id']?>&funcionario_id='+funcionario_id+"&tipo=extra",'_blank');
			break;
		}
	});
	$(".hora_entrada, .hora_saida_almoco, .hora_retorno_almoco, .hora_saida").live('blur',function(){
		
		var hora_entrada = $(this).parent().parent().find('.hora_entrada').val();
		var hora_saida_almoco = $(this).parent().parent().find('.hora_saida_almoco').val();
		var hora_retorno_almoco = $(this).parent().parent().find('.hora_retorno_almoco').val();
		var hora_saida = $(this).parent().parent().find('.hora_saida').val();
		var faltas = $(this).parent().parent().find('.faltas');
		/*var horas_50  = $(this).parent().parent().find('.horas_50').val();
		var horas_100 = $(this).parent().parent().find('.horas_100').val();
		var horas_not = $(this).parent().parent().find('.horasnoturnas').val();*/
		var falta_justificada = $(this).parent().parent().find('.falta_justificada');
		var funcionario_id = $(this).parent().parent().find('.funcionario_id').val();
		var empresa_id = $("#empresa_id").val();
		var listagem = $("#listagem").val();
		var faltas1 = 0;
		var falta_justificada1 = 0;
		//alert(listagem);
		if(listagem==1){
			var data_hora_extra = $("#data_hora_extra").val();	
		}else{
			var data_hora_extra = $(this).parent().parent().find(".data_hora_extra").val();
		}
		if(faltas.is(":checked")||falta_justificada.is(":checked")){
			if(faltas.is(":checked")){
				faltas1 = 1;
			}else{
				faltas1 = 0;
			}
			
			if(falta_justificada.is(":checked")){
				falta_justificada1 = 1;
			}else{
				falta_justificada1 = 0;
			}
			
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
		}
		
		calcula_hora_extra(hora_entrada,hora_saida_almoco,hora_retorno_almoco,hora_saida,faltas,funcionario_id,empresa_id,data_hora_extra,faltas1,falta_justificada1,listagem);
					
		
	 	
	 });
	 $(".faltas, .falta_justificada").live('click',function(){
	 	
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
		var falta_justificada = $(this).parent().parent().find('.falta_justificada');
		if(listagem==1){
			var data_hora_extra = $("#data_hora_extra").val();	
		}else{
			var data_hora_extra = $(this).parent().parent().find(".data_hora_extra").val();
		}
		
		//alert(data_hora_extra);
		
		if(faltas.is(":checked")||falta_justificada.is(":checked")){
			if(faltas.is(":checked")){
				
				faltas1 = 1;
				
			}else{
				faltas1 = 0;
			}
			
			if(falta_justificada.is(":checked")){
				
				falta_justificada1 = 1;
			}else{
				falta_justificada1 = 0;
			}
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
			faltas1 = 0;
			falta_justificada1 = 0;
		}
	
		calcula_hora_extra(hora_entrada,hora_saida_almoco,hora_retorno_almoco,hora_saida,faltas,funcionario_id,empresa_id,data_hora_extra,faltas1,falta_justificada1,listagem);
	    
	 });

	function calcula_hora_extra(hora_entrada,hora_saida_almoco,hora_retorno_almoco,hora_saida,faltas,funcionario_id,empresa_id,data_hora_extra,faltas,falta_justificada,listagem){
		
			
		$.post("modulos/rh/hora_extra/calcula_hora_extra.php",{
			hora_entrada:hora_entrada,
			hora_saida_almoco:hora_saida_almoco,
			hora_retorno_almoco:hora_retorno_almoco,
			hora_saida:hora_saida,
			empresa_id:empresa_id,
			funcionario_id:funcionario_id,
			data_hora_extra:data_hora_extra,
			falta_justificada:falta_justificada,
			faltas:faltas
			},
			function(data){
									
			//id_numbers = JSON.parse(data);
			console.log(data);
			total_dia = data.total_dia;
			
			horas50   = data.horas50;
			//alert(data.dia_semana+" "+data.feriado+" "+data.numero_diasemana);
			horas100   = data.horas100;
			
			saldo     = data.saldo_dia;	
			
			adicional_noturno = data.adicional_noturno;
			//alert(total_dia);
			//alert($(this).val());
			
			if(listagem == 1){ 
				
				$('#t'+funcionario_id).html(total_dia);
				$('#s'+funcionario_id).html(saldo);
				$('#r'+funcionario_id).val(horas50);
				$('#x'+funcionario_id).val(horas100);
				$('#n'+funcionario_id).val(adicional_noturno);	
			}else{
				dia = data_hora_extra.slice(0,2);
					
				$('#t'+dia).html(total_dia);
				$('#s'+dia).html(saldo);
				$('#r'+dia).val(horas50);
				$('#x'+dia).val(horas100);
				$('#n'+dia).val(adicional_noturno);

			}
		    //alert(data);
			return data;
		},'json');
		
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
	
	$("#data_hora_extra").live('keyup',function(e){
		
		if(e.which==13){
		
			var empresa_id = $("#empresa_id").val();
			var data = $(this).val();
		
			location.href='?tela_id=442&empresa1id='+empresa_id+'&data='+data;
	
		}
		//alert(e.which);
	});
	
	$(".menu_actions").live('click',function(){
		$(".menu_adicional").toggle();
	
	})
	
	$(".horas_50, .horas_100, .horasnoturnas").live('blur',function(){
		
		
		var funcionario_id = $(this).parent().parent().find('.funcionario_id').val();
		var horas_50       = $(this).parent().parent().find(".horas_50").val();
		var horas_100       = $(this).parent().parent().find(".horas_100").val();
		var horasnoturnas       = $(this).parent().parent().find(".horasnoturnas").val();
		var empresa_id     = $("#empresa_id").val();
		var listagem       = $("#listagem").val();
		
		if(listagem==1){
			var data_hora_extra = $("#data_hora_extra").val();	
		}else{
			var data_hora_extra = $(this).parent().parent().find(".data_hora_extra").val();
		}
		
		window.open("modulos/rh/hora_extra/_ctrl.php?acao=atualiza_horas&funcionario_id="+funcionario_id+"&horas_50="+horas_50+"&horas_100="+horas_100+"&horas_noturnas="+horasnoturnas+"&empresa_id="+
		empresa_id+"&data_hora_extra="+data_hora_extra,"carregador");
	});
	
</script>
<style>
	.menu_adicional{border:1px solid #CCC;  background:#FFF; position:absolute; right:27px; top:30px; box-shadow:#999 0 0 10px}
	.menu_adicional a{ display:block; padding:0px 10px 0px 10px; cursor:pointer; font-size:11px; text-decoration:none;}
	.menu_adicional a:hover{ background-color:#F2F5FA;}
</style>
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
	<input type="button" onclick="location.href='?tela_id=442&empresa1id=<?=$_GET['empresa1id']?>&data=<?=$_GET['data']?>'" value="<<">
    	<!--<input type="button" value="Hora Extra Por Dia" onclick="location.href='?tela_id=442&empresa1id=<?=$_GET['empresa1id']?>&data=<?=$_GET['data']?>'"/>-->
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
	
	<div class='menu_adicional' style="display:none" >
    
    	<a href="modulos/rh/hora_extra/impressao_folha_ponto.php?mes=<?=substr($data_folha,5,2)?>&ano=<?=substr($data_folha,0,4)?>&empresa_id=<?=$_GET['empresa1id']?>&funcionario_id=<?=$_GET['funcionario_id']?>" target="_blank">Imprimir Folha de Ponto</a>
    	<a href="modulos/rh/hora_extra/impressao_hora_extra.php?mes=<?=substr($data_folha,5,2)?>&ano=<?=substr($data_folha,0,4)?>&empresa_id=<?=$_GET['empresa1id']?>&funcionario_id=<?=$_GET['funcionario_id']?>" target="_blank">Imprimir Hora Extra</a>
    	<a href="modulos/rh/hora_extra/impressao_adicional_noturno.php?mes=<?=substr($data_folha,5,2)?>&ano=<?=substr($data_folha,0,4)?>&empresa_id=<?=$_GET['empresa1id']?>&funcionario_id=<?=$_GET['funcionario_id']?>" target="_blank">Imprimir Hora Ad. Noturno</a>
    	<a href="modulos/rh/hora_extra/impressao_hora_domingo.php?mes=<?=substr($data_folha,5,2)?>&ano=<?=substr($data_folha,0,4)?>&empresa_id=<?=$_GET['empresa1id']?>&funcionario_id=<?=$_GET['funcionario_id']?>" target="_blank">Impressão Hora Domingo</a>
        
    	<a href="modulos/rh/hora_extra/impressao_recibo.php?mes=<?=substr($data_folha,5,2)?>&ano=<?=substr($data_folha,0,4)?>&empresa_id=<?=$_GET['empresa1id']?>&funcionario_id=<?=$_GET['funcionario_id']?>&tipo=noturno" target="_blank">Imprimir Recibo Adicional Noturno</a>
    	<a href="modulos/rh/hora_extra/impressao_recibo.php?mes=<?=substr($data_folha,5,2)?>&ano=<?=substr($data_folha,0,4)?>&empresa_id=<?=$_GET['empresa1id']?>&funcionario_id=<?=$_GET['funcionario_id']?>&tipo=domingo" target="_blank">Imprimir Recibo Horas Domingo</a>
        <a href="modulos/rh/hora_extra/impressao_recibo.php?mes=<?=substr($data_folha,5,2)?>&ano=<?=substr($data_folha,0,4)?>&empresa_id=<?=$_GET['empresa1id']?>&funcionario_id=<?=$_GET['funcionario_id']?>&tipo=extra" target="_blank">Imprimir Recibo Hora Extra</a>
    </div>
		
   	<?php
		//echo "<strong>Mês de Lançamento: </strong>".$mes_extenso[substr($_GET['data'],3,2)-1];
	}else{
	?>
	<a class="bt_left" id="anterior"></a>
       <input type="hidden"  name="data_anterior_hora_extra" id="data_anterior_hora_extra" style="width:75px;height:9px;margin-top:4px;" mascara="__/__/____" value="<?=DataUsaToBr($dia_anterior->dia_anterior)?>"/> 
       <input type="text" class="nPaginacao" name="data_hora_extra" id="data_hora_extra" style="width:75px;height:9px;margin-top:4px;" mascara="__/__/____" value="<?=DataUsaToBr($data_folha)?>" calendario="1"/>
       <input type="hidden" name="data_proximo_hora_extra" id="data_proximo_hora_extra" style="width:75px;height:9px;margin-top:4px;" mascara="__/__/____" value="<?=DataUsaToBr($proximo_dia->proximo_dia)?>"/>  
    <a class="bt_rigth" id="proximo"></a>
	<?=$diasemana?>
    
    <div class='menu_adicional' style="display:none" >
    
    	<a  href="<?=$caminho?>/folha_pagamento_configuracao/form.php?empresa_id=<?=$empresa->id?>" target="carregador">
        	
            Configuração de Folha de ponto
        </a>
    	<a href="modulos/rh/hora_extra/impressao_folha_ponto.php?mes=<?=substr($data_folha,5,2)?>&ano=<?=substr($data_folha,0,4)?>&empresa_id=<?=$_GET['empresa1id']?>" target="_blank">Imprimir Folha de Ponto</a>
    	<a href="modulos/rh/hora_extra/impressao_hora_extra.php?mes=<?=substr($data_folha,5,2)?>&ano=<?=substr($data_folha,0,4)?>&empresa_id=<?=$_GET['empresa1id']?>" target="_blank">Imprimir Hora Extra</a>
    	<a href="modulos/rh/hora_extra/impressao_adicional_noturno.php?mes=<?=substr($data_folha,5,2)?>&ano=<?=substr($data_folha,0,4)?>&empresa_id=<?=$_GET['empresa1id']?>" target="_blank">Imprimir Hora Ad. Noturno</a>
    	<a href="modulos/rh/hora_extra/impressao_hora_domingo.php?mes=<?=substr($data_folha,5,2)?>&ano=<?=substr($data_folha,0,4)?>&empresa_id=<?=$_GET['empresa1id']?>" target="_blank">Impressão Hora Domingo</a>
        <a href="modulos/rh/hora_extra/impressao_recibo.php?mes=<?=substr($data_folha,5,2)?>&ano=<?=substr($data_folha,0,4)?>&empresa_id=<?=$_GET['empresa1id']?>&tipo=noturno" target="_blank">Imprimir Recibo Adicional Noturno</a>
    	<a href="modulos/rh/hora_extra/impressao_recibo.php?mes=<?=substr($data_folha,5,2)?>&ano=<?=substr($data_folha,0,4)?>&empresa_id=<?=$_GET['empresa1id']?>&tipo=domingo" target="_blank">Imprimir Recibo Horas Domingo</a>
        <a href="modulos/rh/hora_extra/impressao_recibo.php?mes=<?=substr($data_folha,5,2)?>&ano=<?=substr($data_folha,0,4)?>&empresa_id=<?=$_GET['empresa1id']?>&tipo=extra" target="_blank">Imprimir Recibo Hora Extra</a>
    </div>
    <!--<input type="button" value="Hora Extra Por Funcionário" onclick="window.open('modulos/rh/hora_extra/form_hora_funcionario.php?empresa1id=<?=$_GET['empresa1id']?>&data=<?=$_GET['data']?>','carregador')"/>-->
	<?php
    }
	echo "<strong>Mes de Lançamento:</strong> ".$mes_extenso[substr($_GET['data'],3,2)-1];
	?>
	
    <strong>EMPRESA:</strong> <?=$cliente_fornecedor->nome_fantasia?>
    
   <!--<button style="float:right;" onclick="window.open('<?=$caminho?>/folha_pagamento_configuracao/form.php?empresa_id=<?=$empresa->id?>','carregador')">Configurar controle de ponto</button> -->
   <button type="button" class="menu_actions" style="float:right; padding:0px; margin:3px 2px 0 0"> <img src="../fontes/img/menu-alt.png"></button>
 
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
            <td width="100" >Saída Intervalo</td>
            <td width="110" >Retorno Intervalo</td>
       	 	<td width="60" >Saída</td>
            <td width="35" >Faltas</td>
            <td width="100" >Falta Justificada</td>
            <td width="35" >Total</td>
            <td width="35" >Saldo</td>
             <td width="80" >Horas 50%</td>
            <td width="80" >Horas 100%</td>
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
		$falta_justificada   = $hora_extra->falta_justificada;
		$faltas     = $hora_extra->falta_integral;
		$horas_50   = substr($hora_extra->hora_extra50,0,-3);
		$horas_100  = substr($hora_extra->hora_extra_100,0,-3);
		$horas_adicional_noturno = (int)($hora_extra->adicional_noturno/60/60);
		if($horas_adicional_noturno<10){
			$horas_adicional_noturno = "0".$horas_adicional_noturno;
		}
		$minutos_adicional_noturno = ($hora_extra->adicional_noturno/60%60);
		if($minutos_adicional_noturno<10){
			$minutos_adicional_noturno = "0".$minutos_adicional_noturno;
		}
		$adicional_noturno = $horas_adicional_noturno.":".$minutos_adicional_noturno;
		
		/*if($hora_extra->saldo_horas>0&&!$feriado->id>0&&$numero_diasemana!=0){
			if($hora_extra->adicional_noturno>0){
				$horas_50 = $hora_extra->saldo_horas - $hora_extra->adicional_noturno;
			}else{
				$horas_50 = $hora_extra->saldo_horas;
			}
			$horas_50 = $horas_50*60*60;
												
			$horas_50 = mysql_result(mysql_query("SELECT TIME_FORMAT(SEC_TO_TIME('$horas_50'),'%H:%i')"),0,0);
		}
		if($hora_extra->saldo_horas>0&&($feriado->id>0||$numero_diasemana==0)){
			if($hora_extra->adicional_noturno>0){
				$horas_100 = $hora_extra->saldo_horas - $hora_extra->adicional_noturno;
			}else{
				$horas_100 = $hora_extra->saldo_horas;
			}
			$horas_100 = $horas_100*60*60;
												
			$horas_100 = mysql_result(mysql_query("SELECT TIME_FORMAT(SEC_TO_TIME('$horas_100'),'%H:%i')"),0,0);
		}*/
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
            <td width="100" align="center"><input type="text" class="hora_saida_almoco" style="width:40px;height:10px;" sonumero="1" mascara="__:__" value="<?=$hora_saida_almoco?>"></td>
            <td width="110" align="center"><input type="text" class="hora_retorno_almoco" style="width:40px;height:10px;" sonumero="1" mascara="__:__" value="<?=$hora_retorno_almoco?>"></td>
       	 	<td width="60" ><input type="text" name="hora_saida" class="hora_saida" style="width:40px;height:10px;" sonumero="1" mascara="__:__" value="<?=$hora_saida?>"></td>
            <td width="35" ><input type="checkbox" name="faltas" class="faltas" <?php if($faltas==1){echo "checked='checked'";}?>></td>
            <td width="100" ><input type="checkbox" name="falta_justificada" class="falta_justificada" <?php if($falta_justificada==1){echo "checked='checked'";}?>/></td>
            <td width="35" id="t<?=$r->id?>"><?=decimal_hora($hora_extra->total)?></td>
            <td width="35" id="s<?=$r->id?>"><?=decimal_hora($hora_extra->saldo_horas)?></td>
            <td width="80" ><input type="text" id="r<?=$r->id?>" name="horas50[]" class="horas_50" value="<?=$horas_50?>" mascara="__:__" sonumero="1" style="width:50px; height:10px;"/></td>
            <td width="80"><input type="text" id="x<?=$r->id?>" name="horas100[]" class="horas_100" value="<?=$horas_100?>" mascara="__:__" sonumero="1" style="width:50px; height:10px;"/></td>
            <td width="100"><input type="text" id="n<?=$r->id?>" name="horasnoturnas[]" class="horasnoturnas" value="<?=$adicional_noturno?>" mascara="__:__" sonumero="1"
            style="width:50px; height:10px;"/></td>
          	<td width="">
            	<select class="acao_funcionario" style="width:80px;">
                	<option value="">Selecione uma ação</option>
                    <option value="6">Lançar horas no mês <?=$mes_extenso[substr($_GET['data'],3,2)-1]?></option>
                    <option value="1">Imprimir Folha de Ponto</option>
                    <option value="2">Imprimir Hora Extra</option>
                    <option value="3">Imprimir Ad. Noturno</option>
                    <option value="4">Imprimir Hora Domingo</option>
                    <option value="5">Imprimir Recibo Adicional Noturno</option>
                    <option value="7">Imprimir Recibo Horas Domingo</option>
                    <option value="8">Imprimir Recibo Horas Extras</option>
                </select>
            </td>
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