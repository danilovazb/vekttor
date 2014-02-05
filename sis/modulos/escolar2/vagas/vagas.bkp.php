<?php

$tela = mysql_fetch_object ( mysql_query ( "SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'" ) );
$caminho = $tela->caminho; 

include ("_functions.php");
include ("_ctrl.php");

$_SESSION["url_voltar"] =  $_SERVER['REQUEST_URI'];
?>
<script>
	<!--------funções referentes ao período letivo----->
	$("#periodo_letivo_id").live('change',function(){
		
		if($(this).val()=='adicionar'){
			window.open('modulos/escolar2/vagas/form_periodo_letivo.php',"carregador");
		}
		
		if($(this).val()=='editar'){
			window.open('modulos/escolar2/vagas/form_periodo_letivo.php?acao=editar_periodo_letivo',"carregador");
		}
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
	
	$(".adicionar_sala").live('click',function(){
		var escola_id = $(this).attr('f_escola_id');
		var serie_id  = $(this).attr('f_serie_id');
		var sala_id   = $(this).attr('f_sala_id');
		var turno     = $(this).attr('f_turno');
		var horario_id     = $(this).attr('f_horario_id');
		console.log(serie_id);
		var periodo_letivo_id = $(this).attr('f_periodo_letivo_id');
		var turma = $(this).attr('f_turma');
		var menos = $(this.parentNode.parentNode).find('.retirar_sala');
		var cadastrar_horarios = $(this.parentNode.parentNode).find('.botao_cadastrar_turma');
		var vlr_matricula = $(this.parentNode.parentNode).find('.valor_matricula').val();
		var vlr_mensalidade = $(this.parentNode.parentNode).find('.valor_mensalidade').val();
		turma = $("#nome_turma"+turma).val();
		$.ajax({
			url:'modulos/escolar2/vagas/acao.php?acao=cadastrar_turma&escola_id='+escola_id+'&serie_id='+serie_id+'&sala_id='+sala_id+'&turno='+turno+'&horario_id='+horario_id+'&periodo_letivo_id='+periodo_letivo_id+'&nome_turma='+turma+'&valor_matricula='+vlr_matricula+'&valor_mensalidade='+vlr_mensalidade,
			cache:false,
			success: function(data){
				menos.attr('id',data);
					cadastrar_horarios.click(function(){
						location.href='?tela_id=474&turma_id='+data;
					});
			}
		})
		
		$(this).hide();
		$(this.parentNode).find('.retirar_sala').show();
		$(this.parentNode.parentNode).find('.botao_cadastrar_turma').show();
		$(this.parentNode.parentNode).find('.msg_cadastre_turma').hide();
		
	});
	
	$(".retirar_sala").live('click',function(){
		turma_id=$(this).attr('id')
		window.open('modulos/escolar2/vagas/acao.php?acao=excluir_turma&turma_id='+turma_id,'carregador');
		$(this.parentNode.parentNode).find('.nome_turma').val('');
		$(this.parentNode.parentNode).find('.valor_mensalidade').val('');
		$(this.parentNode.parentNode).find('.valor_matricula').val('');
		$(this).hide();
		$(this.parentNode).find('.adicionar_sala').show();
		$(this.parentNode.parentNode).find('.botao_cadastrar_turma').hide();
		$(this.parentNode.parentNode).find('.msg_cadastre_turma').show();
	});
	
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

</script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
.obs{ display:none;}
.obs p{background:#F3F1D0; padding:4px; border:1px solid #999; font-size:11px}
.text-extra-combina-horario{
	display:none; font-family:Verdana, Geneva, sans-serif; 
}
.caret {
	display: inline-block;
	width: 0;
	height: 0;
	vertical-align: top;
	border-top: 4px solid #000000;
	border-right: 4px solid transparent;
	border-left: 4px solid transparent;
	content: "";
	opacity:0.6;
}
button > .caret, a > .caret{margin-top: 5px;margin-left: 0;}

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
     <div style="float:right; padding-right:5px; margin-top:1px;"><a  href="#" class="btn" id="import-periodo" > <!--<img src="../fontes/img/menu-alt.png" style="width:13px;"> <span class="caret"></span>--> importar periodo letivo  </a>
     </div>    
    <!-- 
          <a href="<?=$caminho?>/form.php" target="carregador" class="mais"></a>
       -->
       <form>   
          
          <select name="horario_id" id="horario_id" style="float:right; margin:3px 10px 0 0 ">
          	<option value="">Horário</option>
            <option value="adicionar">Adicionar Horário</option>
            <?
				$horarios = mysql_query("SELECT * FROM escolar2_horarios WHERE vkt_id='$vkt_id'");
				
				$c=0;
				
				$array_horario = array();
				
				while($horario = mysql_fetch_object($horarios)){
				
					$array_horario[$c]['id'] =$horario->id;
					$array_horario[$c]['nome'] =$horario->nome; 
					
					if($_GET['horario_id']==$horario->id){
						$selected = "selected='selected'";
					}
					
					echo "<option value='$horario->id'>$horario->nome</option>";
					
					$selected='';
				
					$c++;
				}
				unset($c);
			?>
          </select>
          
          <select name="periodo_letivo_id" id="periodo_letivo_id">
          	<option value="">Período Letivo</option>
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
          	<option>Selecione uma Escola</option>
          	<?php
				$escolas = mysql_query("SELECT * FROM escolar2_unidades WHERE vkt_id='$vkt_id'");
				
				while($escola = mysql_fetch_object($escolas)){
					
					if($_GET['escola_id']==$escola->id){
						$selected="selected='selected'";
					}
					
					echo "<option value='$escola->id' $selected>$escola->nome</option>";
				
					$selected='';
				}
			?>
          
      </select>
      	<input type="submit" value="Organizar turmas na escola" id="selecionar"/>
        <input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />  
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
                <td width="200">Escola</td>
                <td width="80">S&eacute;rie</td>
              	<?php
				
				foreach($array_horario as $h){
					
					echo " <td width='80'>".$h['nome']."</td>";
					
				}
				
			  	?>
                <td width="80">Salas</td>
                <td width="80">Vagas</td>
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
        <?
        if($_GET[escola_id]>0){
			$escola_id = $_GET[escola_id];
			
			$escola = mysql_fetch_object(mysql_query("SELECT * FROM escolar2_unidades WHERE id='$escola_id'"));
			
			$periodo_letivo = mysql_fetch_object(mysql_query($t="SELECT * FROM escolar2_periodo_letivo WHERE id='".$_GET['periodo_letivo_id']."'"));
						
			$ensinos = mysql_query("SELECT * FROM escolar2_ensino WHERE vkt_id='$vkt_id' ORDER BY ordem_ensino");
		
			$c=0;
			
			$i=1;
		?>
        <table cellpadding="0" cellspacing="0" width="100%">
            <tbody>
                        
                <tr <?=$cl?>>
                <td width="200"><strong><?=$escola->nome?></strong></td>
                <td width="80"><?=$periodo_letivo->nome?></td>
               	<?php
                foreach($array_horario as $h){
					
						echo " <td width='80'></td>";
					
					}
				?>
                <td width="80">&nbsp;</td>
                <td width="80"><?=$qtd_vagas?></td>
                <td></td>
                </tr>
                
                <?php
					$total_vagas=0;
					while($ensino = mysql_fetch_object($ensinos)){
						
						$series = mysql_query("SELECT * FROM escolar2_series WHERE ensino_id = '$ensino->id' ORDER BY ordem_ensino");
						$exibe_ensino = 1;
						
						while($serie = mysql_fetch_object($series)){
						
						$i++;
						if($i%2==0){$cl='class="al"';}else{$cl='';}
						
				?>
                <tr <?=$cl?>>
                  <td align="right"><strong><?php if($exibe_ensino){ echo $ensino->nome;}?></strong></td>
                  <td><?=$serie->nome?></td>
                  
				  <?php
					$qtd_salas = 0;
					$qtd_vagas = 0;
					foreach($array_horario as $h){					
			  	  ?>
                  
                  <td onclick="window.open('<?=$caminho?>/form.php?escola_id=<?=$escola_id?>&ensino_id=<?=$ensino->id?>&horario_id=<?=$h['id']?>&ano=<?=$_GET['ano']?>&serie_id=<?=$serie->id?>&periodo_letivo_id=<?=$periodo_letivo->id?>','carregador')">
                  	<?php
						$salas_manha = mysql_query("SELECT *, es.nome as sala FROM
													escolar2_turmas et,
													escolar2_salas es 
													WHERE
													et.sala_id = es.id AND
													et.unidade_id = ".$_GET['escola_id']." AND 
													et.serie_id='$serie->id' AND
													et.horario_id='".$h['id']."' AND
													periodo_letivo_id='".$_GET['periodo_letivo_id']."'
													");
						
						$qtd_salas += mysql_num_rows($salas_manha);
						$turmas=array();
						while($sala = mysql_fetch_object($salas_manha)){
							$qtd_vagas += $sala->capacidade_maxima;
							$turmas[]=$sala->sala;
						}
						echo implode(', ',$turmas);
					}
					$total_vagas+=$qtd_vagas;
					?>
                  </td>
                  <td><?=$qtd_salas?></td>
                  <td><?=$qtd_vagas?></td>
                  <td></td>
                </tr>
                <?
						
							$exibe_ensino = 0;
						
						}//while($serie = mysql_fetch_object($series))					
						
					}//while($ensino = mysql_fetch_object($ensinos))
				?>
             
         
            </tbody>
        </table>
        <?
		}
		?>
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