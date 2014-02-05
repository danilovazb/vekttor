<?php

$tela = mysql_fetch_object ( mysql_query ( "SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'" ) );
$caminho = $tela->caminho; 

include ("_functions.php");
include ("_ctrl.php");

$_SESSION["url_voltar"] =  $_SERVER['REQUEST_URI'];

	$sql_ensino = mysql_query(" SELECT * FROM escolar2_ensino WHERE vkt_id = '$vkt_id' ORDER BY ordem_ensino ASC ");
    
?>
<link href="../fontes/css/select2.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../fontes/js/select2.min.js"></script>

<script type="text/javascript">
$(function(){
	
	$("tr:odd").addClass('al');
	$("body").mouseup(function(){
		$(".menu_adicional").hide();
	});
	/*$("#periodo_letivo_id").select2({
		placeholder: "Selecione periodo letivo",
		allowClear: true	
	});*/
});

	<!--------funções referentes ao período letivo----->
	$("#periodo_letivo_id").live('change',function(){
		
		if($(this).val()=='adicionar')
			window.open('modulos/escolar2/vagas/form_periodo_letivo.php',"carregador");
		
		if($(this).val()=='editar')
			window.open('modulos/escolar2/vagas/form_periodo_letivo.php?acao=editar_periodo_letivo',"carregador");
	});
	
	$("#periodo_letivo").live("change",function(){
		periodo_letivo_id = $(this).val();
		window.open('modulos/escolar2/vagas/form_periodo_letivo.php?periodo_letivo_id='+periodo_letivo_id,"carregador");
	});
	
	<!--------funções referentes ao período letivo----->
	
	$("#horario_id").live('change',function(){
		if($(this).val()=='adicionar'){
			window.open('modulos/escolar2/vagas/form_horario.php',"carregador");
		}else{
			horario_id = $(this).val();
			window.open('modulos/escolar2/vagas/form_horario.php?acao=editar_horario&horario_id='+horario_id,"carregador");
		}
	});
	
	$("#horario").live("change",function(){
		horario_id = $(this).val();
		window.open('modulos/escolar2/vagas/form_horario.php?horario_id='+horario_id,"carregador");
		
	});
	
	<!------------------------------------------------>
	
	$(".tem_turma input").live('blur',function(){
		var turma_id = $(this.parentNode.parentNode.parentNode).attr('data-rel');
		var nome_turma= ($(this.parentNode.parentNode.parentNode).find('.nome_turma').val());
		var vlr_matricula = $(this.parentNode.parentNode.parentNode).find('.valor_matricula').val();
		var vlr_mensalidade = $(this.parentNode.parentNode.parentNode).find('.valor_mensalidade').val();
		
		$.ajax({
			url:'modulos/escolar2/vagas/acao.php?acao=editar_turma&turma_id='+turma_id+'&valor_matricula='+vlr_matricula+'&valor_mensalidade='+vlr_mensalidade+'&nome_turma='+nome_turma,
			cache:false
		})
	})
	
	$("input").live("keyup",function(){
		foco = $(this).attr("id");
		foco_turma_id = $(this).parent().parent().parent().attr('data-rel');
		foco_nome_turma = $(this).parent().parent().parent().find('.nome_turma').val();
		foco_vlr_matricula = $(this).parent().parent().parent().find('.valor_matricula').val();
		foco_vlr_mensalidade = $(this).parent().parent().parent().find('.valor_mensalidade').val();
	});
	$("#fecha_form").live('click',function(){
		form_x(this);
		escola_id = $("#escola_id").val();
		
		var turma_id = foco_turma_id;
		var nome_turma= foco_nome_turma;
		var vlr_matricula = foco_vlr_matricula;
		var vlr_mensalidade = foco_vlr_mensalidade;
				
		location.href='?tela_id=460&escola_id='+escola_id+'&periodo_letivo_id=<?=$_GET['periodo_letivo_id']?>&acao=editar_turma&turma_id='+turma_id+'&valor_matricula='+vlr_matricula+'&valor_mensalidade='+vlr_mensalidade+'&nome_turma='+nome_turma;
		
	});
	
	
//add jaime
var countChecked = function(){
	var n = $( "input#combinar_horario:checked" ).length;
	  if(n === 1){
		  $(".text-extra-combina-horario").show();
		  $("#combine").val("sim");
		  $(".obs").show();
	  }
	  else{
		  $(".obs").hide();
		  $(".text-extra-combina-horario").hide();
		  $("#combine").val("nao");
	  }
}

$("#combinar_horario").live("click",countChecked);

$("#import-periodo").live("click",function(){
	window.open('modulos/escolar2/vagas/form-importa-periodo.php','carregador');
});

$("#realizar-importacao").live("click",function(){
	
	var periodo_exportacao_id = $("select#periodo_exportacao_id").val();
	var periodo_importacao_id = $("select#periodo_importacao_id").val();
	
	if( periodo_exportacao_id ===  periodo_importacao_id) {
		alert(" Os períodos não podem ser iguais");
		return false;	
	} else{
		$("#form_importar_periodo_letivo").submit();
	}
});

// Jaime organização de turmas
$(".add-turma").live("click",function(){
	var $tr = $(this).closest("tr");
	var unidade = $("select#escola_id").val();
	var periodo_letivo = $("select#periodo_letivo_id").val();
	var horario = $(this).attr("id");
	var serie = $tr.attr("id");
	var ensino = $tr.attr("ensino");
	
	window.open('modulos/escolar2/vagas/form-org-turma.php?horario='+horario+'&serie='+serie+'&unidade='+unidade+'&periodo_letivo='+periodo_letivo+'&ensino='+ensino+'','carregador');
});

$(".turma").live("click",function(){
	var $tr = $(this).closest("tr");
	var serie = $tr.attr("serie");
	var horario = $(this).attr("horario");
	var turma_id = $(this).attr("id");
	window.open("modulos/escolar2/vagas/form-turma.php?turma="+turma_id+"&horario="+horario+"&serie="+serie+"","carregador");
});

$(".menu_actions").live('click',function(){
	$(".menu_adicional").toggle();
});

//add horario
$("#add-horario").live("click",function(){
	window.open('modulos/escolar2/vagas/form_horario.php',"carregador");
});

//add periodo letivo
$("#add-periodo-letivo").live("click",function(){
	window.open('modulos/escolar2/vagas/form_periodo_letivo.php',"carregador");
});

//add configuracao de tela

$("#add-config-tela").live("click",function(){
	window.open('modulos/escolar2/vagas/form-configuracao.php',"carregador");
});

</script>

<style>
.obs{ display:none;}
.obs{background:#F3F1D0; padding:6px; border:1px solid #999; font-size:11px;color:#555;}
.obs p{padding:4px; margin:0;}
.obs p h1,h2,h3,h4,h5,h6{padding:0; margin:0 0 5px; }
.text-extra-combina-horario{display:none; font-family:Verdana, Geneva, sans-serif; }
table tr td span{ padding-left:20px;}
table tr td.turma{ margin:0; padding:0; line-height:25px;}
table tr td.turma span{ padding-left:10px;}
table tbody tr:hover td{ /*background:none; color:inherit;*/ }
table tbody tr td.turma:hover{ background:#AAC4E8;}
.menu_adicional{border:1px solid #CCC;  background:#FFF; position:absolute; right:27px; top:30px; box-shadow:#999 0 0 10px}
.menu_adicional a{ display:block; padding:0px 10px 0px 10px; cursor:pointer; font-size:11px; text-decoration:none;}
.menu_adicional a:hover{ background-color:#F2F5FA;}
.menu_adicional ul{ list-style:none; margin:0; padding:0;}
body #barra_info .select2-choice{height:20px;line-height: 10px;margin-top:-4px;}
body #barra_info .select2-chosen{ display:table; margin-top:4px;overflow:auto;}
body #barra_info .select2-arrow > b{ margin-top:-3px; }
body #barra_info .select2-container .select2-choice abbr{ top:3px;}
</style>

<div id="conteudo">

	<!--
        ///////////////////////////////////////
        Barra de Navegação
        ///////////////////////////////////////
    -->
    <?
  //  pr($_POST);
	?>
    <div id="navegacao">
        <div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s2'>Escolar</a>
        <a href="?tela_id=<?=$_GET[tela_id]?>" class="navegacao_ativo"><span></span><?=$tela->nome?></a>
    </div>
    
    <!--
        ///////////////////////////////////////
        Barra de Ações
        ///////////////////////////////////////
    -->
    <div id="barra_info">
     <!--<div style="float:right; padding-right:5px; margin-top:1px;">
      <a  href="#" class="btn" id="import-periodo" > <!--<img src="../fontes/img/menu-alt.png" style="width:13px;"> <span class="caret"></span> importar periodo letivo  </a>
     </div>-->    
    <!-- 
          <a href="<?=$caminho?>/form.php" target="carregador" class="mais"></a>
       -->
       <form>   
          
          <select name="periodo_letivo_id" id="periodo_letivo_id" style="width:200px;">
          	<option></option>
            <option value="adicionar">Adicionar Período Letivo</option>
            <option value="editar">Editar Período Letivo</option>
            <option disabled="disabled">Selecione um Período Letivo</option>
            <?
				$periodos_letivos = mysql_query("SELECT * FROM escolar2_periodo_letivo WHERE vkt_id='$vkt_id'");
				
				while($periodo_letivo = mysql_fetch_object($periodos_letivos)){
				
					if($_GET['periodo_letivo_id']==$periodo_letivo->id){
						$selected = "selected='selected'";
					}
				
					echo "<option value='$periodo_letivo->id' $selected>$periodo_letivo->nome</option>";
					$selected='';
				}
			?>
          </select> 
             
          <select name="escola_id" id="escola_id">
          	<option value="0">Selecione uma Escola</option>
          	<?php
				$escolas = mysql_query("SELECT * FROM escolar2_unidades WHERE vkt_id='$vkt_id' ");
				
				while($escola = mysql_fetch_object($escolas)){
					
					if($_GET['escola_id']==$escola->id)
						$selected="selected='selected'";
					
					echo "<option value='$escola->id' $selected>$escola->nome</option>";
					$selected='';
					
				} ?>
      	  </select>
      
      	<input type="submit" value="Filtrar" id="selecionar"/>
        <input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
        
       
        
        <button type="button" class="menu_actions" style="float:right;padding:0px; margin:3px 2px 0 0"> <img src="../fontes/img/menu-alt.png"></button>
        <div class='menu_adicional' style="display:none" >
            <ul>
                <li><a  href="#" id="import-periodo" > Importar Periodo Letivo  </a></li>
                <li><a  href="#" id="add-horario" > Adicionar Horário  </a></li>
                <li><a  href="#" id="add-periodo-letivo" > Adicionar Periodo Letivo  </a></li>
            </ul>
        </div>
        
         <select name="horario_id" id="horario_id" style=" margin:3px 10px 0 0; float:right; ">
          	<option value="">Horário</option>
            <option value="adicionar">Adicionar Horário</option>
            <?
				$horarios = mysql_query("SELECT * FROM escolar2_horarios WHERE vkt_id='$vkt_id' ORDER BY id ASC ");
				
				$c=0;
				$array_horario = array();
				
				while($horario = mysql_fetch_object($horarios)){
				
					$array_horario[$c]['id'] =$horario->id;
					$array_horario[$c]['nome'] =$horario->nome; 
					
					if($_GET['horario_id']==$horario->id)
						$selected = "selected='selected'";
					
					echo "<option value='$horario->id'>$horario->nome</option>";
					
					$selected='';
				
					$c++;
				}
				unset($c);
			?>
          </select>
          
      </form>   
      
</div>
        
<!--
    ///////////////////////////////////////
    Cabeçalho da tabela
    ///////////////////////////////////////
-->

    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <td width="200">Escola/Série</td>
                <?php foreach($array_horario as $h){ ?>
                <td width="110"><?=$h["nome"]?></td>
                <? } ?>
                <td></td>
            </tr>
        </thead>
    </table> 
    
<!--
    ///////////////////////////////////////
    Tabela de Dados
    ///////////////////////////////////////
-->
<div id="dados">
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
        
        <table cellpadding="0" cellspacing="0" width="100%">
            <tbody>
              <?php
			  
			  if( !empty($_GET["periodo_letivo_id"]) and !empty($_GET["escola_id"]) ){
			  
			  while($ensino=mysql_fetch_object($sql_ensino)){
				  $sql_serie = (mysql_query(" SELECT * FROM escolar2_series WHERE vkt_id = '$vkt_id' AND ensino_id = '$ensino->id' ORDER BY ordem_ensino ASC   "));
			  ?>
                 
                 <tr id="<?=$ensino->id?>">
                    <td width="200"><b><?=$ensino->nome?></b></td> 
                    <?php foreach($array_horario as $horario){ ?> <td width="80"></td><? } ?>
                           
                    <td></td>
                 </tr>
                 
                 <?php
				  $count0 = 0;
                  while($serie=mysql_fetch_object($sql_serie)){
				 ?>
                 
                 <tr id="<?=$serie->id?>" ensino="<?=$ensino->id?>">
                    <td width="200" class="serie"><span><?=$serie->nome?></span> </td>
                    <? 
					    $count1 = 0; $turmas = array(); $consulta_turma = array();
						
						foreach($array_horario as $horario){
							
							$consulta_turma = consulta_turma($horario['id'],$serie->id,trim($_GET["periodo_letivo_id"]),trim($_GET["escola_id"]) );
							
							if( count($consulta_turma) > 0 ){
								$turmas["turmas"][] = $consulta_turma;
								$count1++;
							}
							
						?>
                		<td width="110" align="center">
                        <span style="padding-left:0px; margin-left:-10px;" ><img rel="tip" id="<?=$horario["id"]?>" title="Adicionar turma" class="add-turma" src="../fontes/img/mais.png"></span>
                        </td>
                		<? } ?>
                    
                    <td></td>
                 </tr>
                <?
				
			    $dados_turma = $turmas["turmas"];	
			    
				for($i=0; $i < count($dados_turma); $i++){
				 
				 $qtd_turma = verifica_qtd_turma($dados_turma[$i]);
				 
					for($j = 0; $j < $qtd_turma; $j++){
						
				?>
                
                 <tr ensino="<?=$ensino->id?>" serie="<?=$serie->id?>">
                   <td></td><?
				   $contador=0;
				   $title = "";
					  foreach($array_horario as $horario){ 
				       $sala = !empty($dados_turma[$contador][$j]["nome_sala"]) ? " - ".$dados_turma[$contador][$j]["nome_sala"] : NULL;
					   $class = !empty($dados_turma[$contador][$j]["nome"]) ? "turma" : NULL;
					   
					   if( !empty($class) ){
					    $title = "Valor Matricula: R$ ".moedaUsaToBr($dados_turma[$contador][$j]["valor_matricula"])."<br/>";  
					    $title .= "Valor Mensal: R$ ".moedaUsaToBr($dados_turma[$contador][$j]["valor_mensalidade"])."<br/>";
					    $title .= "Turma: ".$dados_turma[$contador][$j]["nome"]."<br/> Sala ".$sala;
					   } else {
						 $title = "";  
					   }
				   ?>
                   <td id="<?=$dados_turma[$contador][$j]["id"]?>" horario="<?=$dados_turma[$contador][$j]["horario_id"]?>" class="<?=$class?>"><div rel="tip" id="titulo" data-placement="bottom"  title="<?=$title?>">
                   	<span><? echo get_nome($dados_turma[$contador][$j]["nome"].$sala,15); ?></span></div></td>
                   <? $contador++;
				       } //end foreach
				   ?>
                  <td></td>
                 </tr>
                 
                <?   }//end for
				   break;
				 }// end for
				
			  
				  } //end while serie
			    } //end while ensino
			  } //end if 
			  ?>
            </tbody>
        </table>
    </div>
    
    <!--
        ///////////////////////////////////////
        Linha de layout
        ///////////////////////////////////////
    -->
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <td width="200"><strong>Total</strong></td>
                <td width="80">&nbsp;</td>
                <td width="90">&nbsp;</td>
                <td width="90">&nbsp;</td>
                <td width="80">&nbsp;</td>
                <td width="80"><?=$total_vagas?></td>
              <td></td>
            </tr>
        </thead>
    </table>

</div>

<!--
    ///////////////////////////////////////
    Rodapé
    ///////////////////////////////////////
-->
<div id="rodape">

	    
</div>