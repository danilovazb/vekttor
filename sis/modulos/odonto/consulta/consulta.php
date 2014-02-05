<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
$data_atual = date('d/m/Y');

?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<a href="./" class='s1'>
  	Sistema NV
</a>
<a href="./" class='s2'>
    Ondontologo 
</a>
<a href="#" class="navegacao_ativo">
<span></span>  Consulta
</a>
</div>
<div id="barra_info">
<script type="text/javascript" src="http://malsup.github.com/jquery.form.js"></script>
<script>
/*------------------Script para Receituário------------------------*/
$("#add_receituario").live("click",function(){
	
	var texto_receituario = $('#texto_receituario').val();
	var data_receituario = $('#data_receituario').val();
	
	
	var dados = "texto_receituario="+texto_receituario+"&data_receituario="+data_receituario+"&acao=add";
														
	$.ajax({
				url: 'modulos/odonto/consulta/receituario.php',
					type: 'POST',
					data: dados,
					success: function(data) {
								/*------ COLOCA O TOTAL NO FINAL DA TABELA ----*/
																					
				var id_receituario = data;
								
				$("#dados_receituario").append("<tr class='l_receituario' id_receituario="+id_receituario+"><td style='width:45px;'><img src='../fontes/img/menos.png' id='remove_receituario'>"+data_receituario+"</td><td style='width:210px;'></td><td style='width:30px;' align='center'><img src='modulos/odonto/consulta/Printer-icon.png' class='print_receituario'/></td></tr>");
				$('#nome_receituario').val('');
				$('#texto_receituario').val('');
				$('#data_receituario').val('<?=$data_atual?>');
				},
			});		
});

$(".print_receituario").live("click",function(){
	var id = $(this).parent().parent().attr('id_receituario');
	window.open('modulos/odonto/consulta/impressao_receituario.php?id='+id);
});

$("#remove_receituario").live("click",function(){
	
	var id = $(this).parent().parent().attr('id_receituario');
	var dados = "id="+id+"&acao=remove";
	//alert(id);													
	$.ajax({
				url: 'modulos/odonto/consulta/receituario.php',
					type: 'POST',
					data: dados,
					success: function(data) {
								/*------ COLOCA O TOTAL NO FINAL DA TABELA ----*/
																					
					
				},
			});
	$(this).parent().parent().remove();		
});
/*------------------Fim Script para Receituário------------------------*/
/*------------------Script para Atestado------------------------*/
$("#add_atestado").live("click",function(){
	
	var cid                  = $('#cid').val();
	var data_atestado        = $('#data_atestado').val();
	
	var hora_inicio_atestado = $('#hora_inicio_atestado').val();
	var hora_fim_atestado    = $('#hora_fim_atestado').val();
	var dias_afastamento     = $('#dias_afastamento').val();
	var nome_atestado        = 'Atestado';
	
	var dados = "cid="+cid+"&data_atestado="+data_atestado+"&hora_inicio="+hora_inicio_atestado+"&hora_fim="+hora_fim_atestado+"&dias_afastamento="+dias_afastamento+"&acao=add";
													
	$.ajax({
				url: 'modulos/odonto/consulta/atestado.php',
					type: 'POST',
					data: dados,
					success: function(data) {
								/*------ COLOCA O TOTAL NO FINAL DA TABELA ----*/
				//alert(data);															
				var id_atestado = data;
				//alert(data);
				$("#dados_atestado").append("<tr class='l_atestado' id_atestado="+id_atestado+"><td style='width:30px;'>"+data_atestado+"</td><td style='width:200px;'>"+nome_atestado+"</td><td style='width:30px;'>"+dias_afastamento+"</td><td style='width:30px;' align='center'><img src='modulos/odonto/consulta/Printer-icon.png' class='print_atestado'/></td></tr>");
				$('#cid').val('');
				$('#data_atestado').val('<?=$data_atual?>');
				$('#hora_inicio_atestado').val('');
				$('#hora_fim_atestado').val('');
				$('#dias_afastamento').val('');
				},
		});		
});

$(".print_atestado").live("click",function(){
	var id = $(this).parent().parent().attr('id_atestado');
	window.open('modulos/odonto/consulta/impressao_atestado.php?id='+id);
});

$("#remove_atestado").live("click",function(){
	
	var id = $(this).parent().parent().attr('id_atestado');
	var dados = "id="+id+"&acao=remove";
	//alert(id);													
	$.ajax({
		url: 'modulos/odonto/consulta/atestado.php',
			type: 'POST',
			data: dados,
			success: function(data) {
						/*------ COLOCA O TOTAL NO FINAL DA TABELA ----*/
																			
			
		},
	});
	$(this).parent().parent().remove();		
});
/*------------------Script para Exame------------------------*/
$("#add_exame").live("click",function(){
	var data_exame = $("#data_exame").val();
	var id_exame   = $("#proximo_exame").val()*1;
	//alert(id_exame);
	//codigo para adicionar imagem sem dar refresh
	$('#consulta').ajaxForm().submit();
	
	$('#obs_exame').val('');
	$("#data_exame").val('<?=$data_atual?>');
	$('#imagem').val('');
	$("#dados_exames").append("<tr class='l_exame' id_exame="+id_exame+"><td style='width:45px;'><img src='../fontes/img/menos.png' id='remove_exame'>"+data_exame+"</td><td style='width:210px;'></td><td style='width:30px;' align='center'><a href='modulos/odonto/consulta/download.php?id="+id_exame+"'> <img src='modulos/odonto/atendimento/img/baixar.png'/></a></td></tr>");															
	var proximo_exame = id_exame + 1;
	$('#proximo_exame').val(proximo_exame);
	
});

$("#remove_exame").live("click",function(){
	
	var id = $(this).parent().parent().attr('id_exame');
	var dados = "id="+id+"&acao=remove";
	//alert(id);													
	$.ajax({
		url: 'modulos/odonto/atendimento/funcoes_exame.php',
			type: 'POST',
			data: dados,
			success: function(data) {
						/*------ COLOCA O TOTAL NO FINAL DA TABELA ----*/
																			
			alert(data);
		},
	});
	$(this).parent().parent().remove();		
});

/*$(".baixar_exame").live("click",function(){
	
	var id = $(this).parent().parent().attr('id_exame');
	var dados = "id="+id;
	//alert(id);													
	$.ajax({
		url: 'modulos/odonto/consulta/download.php',
			type: 'POST',
			data: dados,
			success: function(data) {
						/*------ COLOCA O TOTAL NO FINAL DA TABELA ----
			alert(data);																
			
		},
	});
});*/
</script>
 <a href="<?=$caminho?>/form.php" target="carregador" class="mais"></a>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           	    	
          	<td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->


    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           
           <td></td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'>
	
</div>
