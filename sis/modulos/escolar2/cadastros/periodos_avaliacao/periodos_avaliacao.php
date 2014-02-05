<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
.text-extra{
	color:#999; font-size:13px; margin-bottom:5px;	
}
.definir-avaliacao{
	/*display:none;*/	
}
.carrega_av{ display:none;}
.tbody-add-av-dados{ max-height:150px; overflow:auto; padding:0; margin:0;border: 1px solid #CCC;}
.table-av{border-left:1px solid #CCC; background:#FFFFFF;}
.table-av td{}
.td_ex { padding:2px; text-align:center;}
</style>
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<script>
	$(document).ready(function(){
		$("#dados tr:nth-child(2n+1)").addClass('al');
	});
	function checa_cpf(t){
	ultima = t.value.substr(13,1);
	//alert(id);
	if(ultima!='_' && t.value.length=='14' ){
		window.open('modulos/escolar2/cadastros/funcionarios/form.php?cnpj_cpf='+t.value,'carregador')	
		}
	}
	
$(document).ready(function(){
	$("tr:odd").addClass('al');		
});

$("#ensino_id").live("change",function(){
	
	if( $(this).val() != 0 )
		$(".definir-avaliacao").show(100);
	else
		$(".definir-avaliacao").hide(100);
	
});

$("#remove_av").live("click",function(){
	var id = $(this).closest("tr").attr("id");
	var tr = $(this).closest("tr");
	
	$.post("modulos/escolar2/cadastros/periodos_avaliacao/dados_avaliacao.php",{dados_avaliacao:"del", id:id},function(data){
		tr.remove();
	});
	 	 
});

$("#tipo_av").live("change",function(){
	var tipo = $(this).val();
	 if( tipo == "conceito")
	 	$(".tipo_conceito").show(100);
	 else
	   $(".tipo_conceito").hide(100);
	 
});

$("#add-av").live("click",function(){
	var erro = 0;
	var msg = "";
	
	var html_lista = "";
	var arrayAv = { 
	"bimestre": $("#bimestre_id").val(), "ensino"  : $("select#ensino_id").val(), 
	"unidade" : $("select#unidade_id").val(),"nome_av" : $("#nome_avaliacao").val(), 
	"ordem"   : $("#ordem").val(),"tipo" : $("select#tipo_av").val(),
	"texto_tipo_avaliacao" : $("#texto_tipo_avaliacao").val()
	};
	
	arrayAv["tipo_avaliacao"] = arrayAv["tipo"]; 
	
	if( $.trim(arrayAv["ensino"]) == 0 ) { 
		erro++;
		msg += " Informe o Ensino \n";	
	}
	
	if( $.trim(arrayAv["nome_av"]) == "" ){
		erro++;
		msg += " Informe nome Avaliacao \n";
	}
	
	if( $.trim(arrayAv["ordem"]) == "" ){
		erro++;
		msg += " Informe a Ordem \n";
	}
	
	if( (arrayAv["tipo"] == "conceito") && ( $.trim(arrayAv["texto_tipo_avaliacao"]) == "" ) )	{
		erro++;
		msg += " Informe o texto do Conceito \n";	
	}
	
	if( $.trim(arrayAv["texto_tipo_avaliacao"]) != "" ){
		arrayAv["tipo_avaliacao"] = arrayAv["texto_tipo_avaliacao"];
	}	
	
	if( erro > 0 ) {
		alert(msg);
	} else {
	
	
		$(".carrega_av").show(100);
		$.post("modulos/escolar2/cadastros/periodos_avaliacao/dados_avaliacao.php",{dados_avaliacao:"add", dados:arrayAv},function(data){
		  
		  html_lista = "\
		  <tr id='"+data+"' style='background:#CAE0F5; color:#000;'>\
			  <td style='width:150px;'>"+arrayAv["nome_av"]+"</td>\
			  <td style='width:30px;'>"+arrayAv["ordem"]+"</td>\
			  <td style='width:60px;'>"+arrayAv["tipo_avaliacao"]+"</td>\
			  <td style='width:25px;' class='td_ex'><a href='#' id='remove_av'> excluir </a></td>\
		  </tr>";
		  $(".carrega_av").hide(100);
		  $("#add-av-dados").append(html_lista);
		  $("#texto_tipo_avaliacao").val("");
		  $("#nome_avaliacao").val(""); $("#ordem").val("");
		  $("#tbody-add-av-dados-2").animate({scrollTop:0}, 200);
			
		});
	}
		
	
	
});

</script>&nbsp;
  <div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s2'>Escolar</a>
        
        <a href="?tela_id=232" class="navegacao_ativo">
			<span></span><?=ucwords($tela->nome)?>
		</a>
</div>
<div id="barra_info">
    <a href="<?=$caminho?>/form.php" target="carregador" class="mais"></a>
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
   <tr>
       <td width="200">Escola</td>
       <td width="200">Períodos de Avaliação</td>
       <td></td>
   </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	<?
	
	
	
	if(strlen($_GET[busca])>0){
		$busca_add = "AND u.nome like '%{$_GET[busca]}%'";
	}
	
	
	// necessario para paginacao
    $registros= @mysql_result(mysql_query($t="SELECT count(*) FROM rh_funcionario WHERE vkt_id='$vkt_id'"),0,0);
   //echo $t;
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="p.id DESC";
	}
				
	$escolas_q=mysql_query($a="SELECT id,nome FROM escolar2_unidades WHERE vkt_id='$vkt_id' ORDER BY nome ASC ");
	while($e=mysql_fetch_object($escolas_q)){
		
	
		
		?> 
		<tr >
        	<td width="200" onClick="window.open('<?=$caminho?>/form.php?unidade_id=<?=$e->id?>','carregador')"><span rel='tip' title='Clique aqui para adicionar período de avaliação'><?=$e->nome?></span></td>
            <td width="200"></td>
            <td><button onClick="window.open('<?=$caminho?>/form_formulas_media.php?unidade_id=<?=$e->id?>','carregador')">Definir cálculo da média final</button></td>
        </tr>
		<?
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
		$periodos_avaliacao_q=mysql_query("SELECT * FROM escolar2_periodos_avaliacao WHERE vkt_id='$vkt_id' AND unidade_id='{$e->id}' ORDER BY nome ASC ");
		
		while($p=mysql_fetch_object($periodos_avaliacao_q)){
		
				
		
		?>
		<tr onClick="window.open('<?=$caminho?>/form.php?id=<?=$p->id?>&unidade_id=<?=$e->id?>','carregador')">
            	<td width="200"></td>
                <td width="200"><?=$p->nome?></td>
                <td></td>
            </tr>
			<?
		}
	?>
   <?
	}
	?>  		
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="200">&nbsp;</td>
           <td></td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'>
	Registros 
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
  <script>
  /*
	   function validaescolas(t){
		   val=$(t).val();
		   id=$(t).attr('id');
		   if($(t).val()!=''){
			   s=$(".escolas_horarios[id!="+id+"]");
			   s.each(function() {
				  $(this).find('option[value='+val+']').hide();
				  $(this).find('option[value!='+val+']').show();
			   });
		   }
	   }
	   */
	   function exibeTurnos(t){	
				if($(t).attr('checked')){
					$("#dados_professor").show();
					$("#cargo_id").hide()
					$("#escola_id").hide()
					$("#cargo_id option").removeAttr('selected')
					$("#escola_id option").removeAttr('selected')
				}else{
					$("#cargo_id").show()
					$("#escola_id").show()
					$("#dados_professor").hide();
				}
			}
       </script>
  
    <div style="float:right; margin:0px 20px 0 0">
    <?=paginacao_links($_GET[pagina],$registros,$_GET[limitador])?>
    </div>
</div>
