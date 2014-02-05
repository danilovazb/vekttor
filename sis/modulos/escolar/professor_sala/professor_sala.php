<?php

$tela = mysql_fetch_object ( mysql_query ( "SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'" ) );
$caminho = $tela->caminho;

include ("_functions.php");
include ("_ctrl.php");


?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id="conteudo">
<script>
function limpaCampo(c){
	//alert($('#professor'+c).val());
	$('#professor'+c).val('');
	id=$("#id"+c).val();
	//alert(id);
	$("#id"+c).val('');
	window.open('modulos/escolar/professor_sala/remove.php?id='+id,'carregador');
	$('#professor_id'+c).val('');
}
</script>
<style>
	blockquote{margin-top:0; margin-bottom:0; margin-right:0; margin-left:15px; padding:0;}
	tbody td{ vertical-align:top; line-height:14px;}
	.cz{ color:#999999; cursor:default}
</style>
<?
//pr($_POST);
?>
	<!--
        ///////////////////////////////////////
        Barra de Navegação
        ///////////////////////////////////////
    -->
<div id="navegacao">
	  <div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s2'>Escolar</a>
    <a href="./?tela_id=<?=$_GET[tela_id]?>" class="navegacao_ativo">Professor por Turma<span></span></a>
</div>
    
    <!--
        ///////////////////////////////////////
        Barra de Ações
        ///////////////////////////////////////
    -->
<div id="barra_info">
</div>
        
<!--
	///////////////////////////////////////
    	Cabeçalho da tabela
    ///////////////////////////////////////
-->
<table cellpadding="0" cellspacing="0" width="100%">
	<thead>
    	<tr>
        	<td width="360">Horarios</td>
            <td width="300" align="center">Professor</td>
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
		if(!empty($_GET['periodo_id'])){
			$filtro_p="AND escolar_periodos.id=".$_GET['periodo_id'];
		}
		
		$s_periodo = (mysql_query($t=" SELECT * FROM escolar_periodos WHERE vkt_id='$vkt_id' $filtro_p ORDER BY nome"));
		
		while($periodo=mysql_fetch_object($s_periodo)){
	?>
	
    <tr <?php echo $cl; ?> >
    	<td width="360" class='cz'><?php echo $periodo->nome; ?></td>                   
        <td width="90">&nbsp;</td>                   
        <td>&nbsp;</td>
     </tr>

	<?												
		if(!empty($_GET['escola_id'])){
			$filtro_e="AND e.id=".$_GET['escola_id'];
		}			
							
		$s_escola = (mysql_query($t="SELECT distinct(h.escola_id),e.nome 
	                             FROM escolar_horarios as h, escolar_escolas as e 
								 WHERE h.escola_id =e.id AND h.periodo_id='$periodo->id' $filtro_e"));
								
			while($escola=mysql_fetch_object($s_escola)){
	?>
		<tr <?php echo $cl; ?> >
        	<td width="360" class="cz" ><blockquote><?php echo $escola->nome; ?></blockquote></td>                   
            <td width="90">&nbsp;</td>                   
            <td >&nbsp;</td>
       	</tr>

	<?									
				if(!empty($_GET['curso_id'])){
					$filtro_c="AND c.id=".$_GET['curso_id'];
				}//if
							
				$s_cursos = (mysql_query($t=" SELECT distinct(h.curso_id),c.nome 
								 FROM escolar_horarios as h, escolar_cursos as c 
								 WHERE h.curso_id=c.id  AND h.periodo_id='$periodo->id' 
								 AND escola_id='$escola->escola_id' $filtro_c"));	
									
				while($curso=mysql_fetch_object($s_cursos)){
	?>
	
    <tr <?php echo $cl; ?> >
    	<td width="360" class="cz"><blockquote><blockquote><?php echo $curso->nome; ?></blockquote></blockquote></td>                   
        <td width="90">&nbsp;</td>                   
        <td >&nbsp;</td>
	</tr>
    
	<?												
					$s_modulos =mysql_query($t =" SELECT distinct(h.modulo_id),m.nome 
			                      FROM escolar_horarios as h, escolar_modulos  as m
								  WHERE  h.modulo_id=m.id AND
								  h.periodo_id='$periodo->id'
								  AND escola_id='$escola->escola_id'
								  AND h.curso_id='$curso->curso_id'");
	
					while($modulos=mysql_fetch_object($s_modulos)){
	?>
    
	<tr <?php echo $cl; ?> >
    	<td width="360" class="cz"><blockquote><blockquote><blockquote><?php echo $modulos->nome; ?></blockquote></blockquote></blockquote></td>                   
        <td width="90">&nbsp;</td>                   
        <td >&nbsp;</td>
    </tr>

	<?												

						$s_horario = mq($t=" SELECT * FROM escolar_horarios 
									WHERE modulo_id = '$modulos->modulo_id' 
									AND periodo_id='$periodo->id' 
									AND curso_id='$curso->curso_id' 
									AND escola_id='$escola->escola_id'");
						while($horarios=mf($s_horario)){
	?>
	
    <tr>
    	<td width="360" class="cz">
        	<blockquote><blockquote><blockquote><blockquote>
	<?
							if(strlen($horarios->nome)>0){
								echo $horarios->nome; 
							}else{
								echo converte_numeros_comvirgula_em_dias_semanas($horarios->dias_semana ,$semana_abreviado)." ".substr($horarios->horario_inicio,0,5)." às ".substr($horarios->horario_fim ,0,5); 
							}// if $horarios->nome
    ?>
            </blockquote></blockquote></blockquote></blockquote>
         </td>                   
         <td width="90" class="cz"></td>                   
         <td class="cz"></td>
	</tr>
	<?
							$s_salas = mysql_query($t="SELECT *,s.id as sala 
														FROM escolar_salas s
														WHERE s.horario_id='$horarios->id' 
														AND s.vkt_id='$vkt_id' $filtro_i");
							//echo $t;
							while($sala=mysql_fetch_object($s_salas)){
								$salas++;
	?>
    <tr onclick="window.open('<?=$caminho?>/form.php?id=<?=$sala->sala?>','carregador')">
	  	<td width="360">
        	<blockquote><blockquote><blockquote><blockquote><blockquote>
			<?php echo $sala->nome; ?>
            </blockquote></blockquote></blockquote></blockquote></blockquote>
        </td>                            	
        <td class="cz"></td>
        <td class="cz"></td>                       
    </tr>
	<?
								$materias = mysql_query($t="SELECT *,m.nome as nome,m.id as materia_id FROM escolar_materias m 
														INNER JOIN escolar_modulos modulo ON m.modulo_id=modulo.id
														INNER JOIN escolar_cursos c ON modulo.curso_id=c.id
														WHERE m.modulo_id='$modulos->modulo_id' AND m.vkt_id='$vkt_id' 
														AND c.id=$curso->curso_id"
														);
								//echo $t."<br>";
								while($materia=mysql_fetch_object($materias)){
	?>
	<tr onclick="window.open('<?=$caminho?>/form.php?id=<?=$sala->sala?>','carregador')">
	<td width="360">
    	<blockquote><blockquote><blockquote><blockquote><blockquote><blockquote>
        	<strong><?php echo $materia->nome; ?></strong>
        </blockquote></blockquote></blockquote></blockquote></blockquote></blockquote>
     </td>
     <td width="300">
	<?
									$professor = mysql_fetch_object(mysql_query($t="SELECT cf.nome_contato as professor
													FROM escolar_sala_materia_professor esp
													INNER JOIN escolar_salas s ON esp.sala_id=s.id
													INNER JOIN escolar_professor p ON esp.professor_id=p.id
													INNER JOIN escolar_materias m ON esp.materia_id=m.id
													INNER JOIN cliente_fornecedor cf ON p.cliente_fornecedor_id=cf.id
													WHERE esp.sala_id=$sala->sala AND esp.materia_id=$materia->materia_id
												"));
			
									echo $professor->professor;
	?>    
    </td>
    <td></td>                   
    </tr>
	<?						
								}/*fecha while da maƒtéria*/
							} /*fecha while sala*/
						} /* fecha while horário */
					}/* fecha while módulos */
				 }
		    }
		}
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
               <td width="100%"></td>
            </tr>
        </thead>
    </table>
    <script>
    $("tr:odd").addClass('al');
    </script>
</div>

<!--
    ///////////////////////////////////////
    Rodapé
    ///////////////////////////////////////
-->
<div id="rodape">
</div>