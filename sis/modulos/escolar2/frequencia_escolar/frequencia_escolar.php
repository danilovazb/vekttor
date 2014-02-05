<?php

$tela = mysql_fetch_object ( mysql_query ( "SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'" ) );
$caminho = $tela->caminho; 

include ("_functions.php");
include ("_ctrl.php");

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script>
$("#turma_id").live('change',function(){
	var turma_id = $(this).val();
	var acao     = 'consulta_materias';
	if(turma_id>0){
	$.post('modulos/escolar2/frequencia_escolar/_ctrl.php',{acao:acao,turma_id:turma_id},
		function(data){
		
			materias = data;
			
			$("#materias_turma").html(materias);			
		
		});
	}else{
		$("#materias_turma").html('');
	}
});
$(".botao_imprimir").live('click',function(){
	window.open("modulos/tela_impressao.php?url=");
});
$("#imprimir_todas_turmas").live('click',function(){
	var periodo_id = $("#periodo_avaliacao_id").val();
	if(!periodo_id>0){
		alert("Selecione um Período");
	}else{
		window.open("modulos/escolar2/frequencia_escolar/impressao_frequencias.php?periodo_id="+periodo_id);
	}
});
</script>
<div id="conteudo">

	<!--
        ///////////////////////////////////////
        Barra de Navegação
        ///////////////////////////////////////
    -->
    <div id="navegacao">
        <form class='form_busca' action="" method="get">
             <a></a>
            <input type="hidden" name="limitador" value="<?php echo $_GET['limitador']; ?>" />
            <input type="hidden" name="tela_id" value="<?php echo $_GET['tela_id']; ?>" />
            <input type="hidden" name="pagina" value="<?php echo $_GET['pagina']; ?>" />
            <input type="text" value="<?php echo $_GET[busca]; ?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
        </form>
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
       <form method="get"> 
        <button style="float:right; margin-top:2px; margin-right:5px;" class="botao_imprimir" type="button">
			<img src="../fontes/img/imprimir.png">
		</button>
        
        
        
        <select name="turma_id" id="turma_id" style="margin-top:3px;">
        	<option value="">SELECIONE UMA TURMA</option>
            
            <?php
				$turma_selecionada = $_GET['turma_id'];
				
				$ensinos = mysql_query("SELECT * FROM escolar2_ensino WHERE vkt_id='$vkt_id'"); 
				
				while($ensino=mysql_fetch_object($ensinos)){	
					
								
					$horarios = mysql_query("SELECT * FROM escolar2_horarios WHERE vkt_id='$vkt_id'");					
									
					while($horario= mysql_fetch_object($horarios)){
						
									
							
				
						$turmas = mysql_query($t="SELECT *, et.id as turma_id, et.nome as nome_turma FROM 
													escolar2_turmas et,
													escolar2_series es,
													escolar2_ensino ens
												WHERE
												et.vkt_id='$vkt_id' AND 
												et.serie_id = es.id AND
												es.ensino_id = ens.id AND
												ens.id = '$ensino->id' AND 
												et.horario_id='$horario->id' ORDER BY 
												et.nome");
						
						if(mysql_num_rows($turmas)>0){
						echo "<optgroup label='$ensino->nome - $horario->nome'>";
						while($turma = mysql_fetch_object($turmas)){
							if($turma->turma_id==$turma_selecionada){
								$selected   = "selected='selected'";
								$nome_turma = $turma->nome_turma;
							}
							echo "<option value='$turma->turma_id' $selected>$turma->nome_turma</option>";
							$selected='';
						}
						echo "</optgroup>";
						}
					}
					
				}
			?>
            
        </select>
       
       	  <span id="materias_turma">
        <?php
          $materia_selecionada =$_GET['materia_id']; 
		  if($materia_selecionada>0){	
			$materias_turma = mysql_query($t="
		SELECT 
			*, em.id as materia_id, em.nome as nome_materia 
		FROM 
			escolar2_serie_has_materias shm,
			escolar2_materias em,
			escolar2_series es,
			escolar2_turmas et
		WHERE
			shm.vkt_id ='$vkt_id' AND
			shm.serie_id = es.id AND
			shm.materia_id = em.id AND
			et.serie_id = es.id AND
			et.id = '$turma_selecionada'");
		
		echo "Materia: <select name='materia_id' id='materia_id'>";
		
		while($materia_turma = mysql_fetch_object($materias_turma)){
			if($materia_selecionada==$materia_turma->materia_id){
				$selected="selected='selected'";
				$nome_materia = $materia_turma->nome_materia;
			}
			echo "<option value='$materia_turma->materia_id' $selected>$materia_turma->nome_materia</option>";
			$selected="";
		}
		
		echo "</select>";
		  }
		 ?> 
		  </span>
        
        <select name="periodo_avaliacao_id" id="periodo_avaliacao_id" style="margin-top:3px;">
        	<option value="">SELECIONE UM PERÍODO DE AVALIAÇÃO</option>
            
            <?php
				$periodo_selecionado = $_GET['periodo_avaliacao_id'];
				$periodos_avaliacao = mysql_query("SELECT * FROM escolar2_periodos_avaliacao WHERE vkt_id='$vkt_id' ORDER BY nome");
				
				while($periodo_avaliacao = mysql_fetch_object($periodos_avaliacao)){
					if($periodo_selecionado==$periodo_avaliacao->id){
						$selected="selected='selected'";
						$nome_periodo = $periodo_avaliacao->nome;
					}
					echo "<option value='$periodo_avaliacao->id' $selected>$periodo_avaliacao->nome</option>";		
					$selected='';
				}
			?>
            
        </select>
        
              
        <input type="submit" value="Filtrar" />
        <input type="button" id="imprimir_todas_turmas" name="imprimir_todas_turmas" value="Listas de Todas as Turmas" rel="tip" title="Imprime de acordo com o semestre selecionado"/>
          
        <input type="hidden" id="tela_id" name="tela_id" value="<?=$_GET['tela_id']?>" />
        </form>
        	
    </div>
        
    <!--
        ///////////////////////////////////////
        Cabeçalho da tabela
        ///////////////////////////////////////
    -->
    <div style="overflow:auto">
        
        
    <!--
        ///////////////////////////////////////
        Tabela de Dados
        ///////////////////////////////////////
    -->
    <div id="dados">
    <div id="info_filtro">
	<div style="float:left">
    	<img src="vekttor/clientes/img/<?=$vkt_id?>.png">
    </div>
	<div style="float:left" style="padding-top:5px;height:100%">
		<strong><?=strtoupper($empresa[nome])?></strong>
		<div style="clear:both"></div>
    	<strong>Lista de Chamada</strong>
    	<div style="clear:both"></div>
    	<strong>Turma:</strong> <?=$nome_turma?>
    	<div style="clear:both"></div>
    	<strong>Período:</strong> <?=$nome_periodo?>
        <div style="clear:both"></div>
    	<strong>Matéria:</strong> <?=$nome_materia?> 
    </div> 
	</div> 
    	<table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <td width="260"><?php echo linkOrdem( "Nome", "nome", 1 ); ?></td>
                <?php
					$aulas = mysql_query($t="SELECT *, ea.id as aula_id FROM 
												escolar2_aula ea,
												escolar2_professor_has_turma pht,
												escolar2_serie_has_materias shm
											WHERE 
												ea.vkt_id='$vkt_id' AND
												ea.professor_as_turma_id = pht.id AND
												pht.serie_has_materia_id = shm.id AND
												ea.periodicidade_id='$periodo_selecionado' AND
												pht.turma_id = '$turma_selecionada' AND
												shm.materia_id = '$materia_selecionada'
												ORDER BY ea.data
												");
					
					$aulas_turma_materia = array();
					$c=0;
					while($aula = mysql_fetch_object($aulas)){
						echo "<td width='40'>".substr(DataUsaToBr($aula->data),0,5)."</td>";
						$aulas_turma_materia[$c] = $aula->aula_id;
						$c++;
					}
				?>
                <td></td>
            </tr>
        </thead>
    </table>
	<?
		// necessario para paginacao
    	$registros= mysql_result(mysql_query("SELECT COUNT(*) FROM escolar2_unidades WHERE vkt_id='$vkt_id'"),0,0);
		
		$alunos=mysql_query("SELECT *, em.id as matricula_aluno_id FROM 
							escolar2_matriculas em,
							escolar2_alunos ea
							WHERE 
							em.turma_id='$turma_selecionada' AND
							em.aluno_id=ea.id AND
							em.vkt_id='$vkt_id'");
	?>
		<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
        <table cellpadding="0" cellspacing="0" width="100%">
            <tbody>
            
        <?
		$i=0;
		while($aluno=mysql_fetch_object($alunos)){
			
			$i++;
			if($i%2==0){$cl='class="al"';}else{$cl='';}
		?>
                <tr <?=$cl?>>
                    <td width="260"><?=$aluno->nome?></td>
                   	
					<?php
                    	foreach($aulas_turma_materia as $aula_materia){
							$frequencia = mysql_fetch_object(mysql_query($t="SELECT * FROM escolar2_frequencia_aula WHERE aula_id='$aula_materia' AND matricula_aluno_id='$aluno->matricula_aluno_id'"));
							echo "<td width='40'>";
								if($frequencia->presenca=='1'){ echo "P";}else{echo "F";}
							echo "</td>";
						}
                    ?>
                    </td>
					<td></td>
                </tr>
          <? } ?>
            </tbody>
        </table>
        
    </div>
    
    <!--
        ///////////////////////////////////////
        Linha de layout
        ///////////////////////////////////////
    -->
    </div>
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
  <td width="260">&nbsp;</td>
                <td width="130">&nbsp;</td>
                <td width="130">&nbsp;</td>
          <td >&nbsp;</td>            
          </tr>
        </thead>
    </table>
    


<!--
    ///////////////////////////////////////
    Rodapé
    ///////////////////////////////////////
-->
<div id="rodape">

	<?php echo $registros; ?> Registros 
    <?php
	
		if( $_GET[limitador] < 1 ){
			$limitador = 30;
		} else {
			$limitador = $_GET[limitador];
		}
		$qtd_selecionado[$limitador] = 'selected="selected"';
	
	?>
    
    <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&pagina=<?=$_GET[pagina]?>&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&limitador='+this.value">
        <option <?php echo $qtd_selecionado[15]; ?>>15</option>
        <option <?php echo $qtd_selecionado[30]; ?>>30</option>
        <option <?php echo $qtd_selecionado[50]; ?>>50</option>
        <option <?php echo $qtd_selecionado[100]; ?>>100</option>
    </select>
    Por P&aacute;gina 
  
    <div style="float:right; margin:0px 20px 0 0">
        <?php echo paginacao_links( $_GET[pagina], $registros, $_GET[limitador] ); ?>
    </div>
    <script>
    $("#qtd_salas").live('keyup',function(){
	
	var id = $("#id").val();
	var qtd_salas = $(this).val();
	
	$("#preenchimento_salas").html('')
	
	if(!id>0){
		val=parseInt($(this).val());
		console.log(val)
		obj="<div class='sala'><label style=\"width:100px;\">Nome da sala<input name='nome[]' type=\"text\" /></label><label style=\"width:110px;\">Capacidade máxima<input name='capacidade_max[]' type=\"text\" /></label><label style=\"width:130px;\">Capacidade Pedagógica<input name='capacidade_ped[]' type=\"text\" /></label></div>";
		//console.log(obj)
	
		for(i=0;i<val;i++){
			$("#preenchimento_salas").append(obj);
		}
		$("#preenchimento_salas").append(obj);
	
	}else{
		$("#preenchimento_salas").load('modulos/escolar2/escolas/busca_salas.php',{id:id, qtd_salas:qtd_salas});
	
	}//if(!id>0)
})

    
    </script>
</div>