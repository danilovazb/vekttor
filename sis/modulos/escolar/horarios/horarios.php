<?php

$tela = mysql_fetch_object ( mysql_query ( "SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'" ) );
$caminho = $tela->caminho;

include ("_functions.php");
include ("_ctrl.php");


?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id="conteudo">
<script>


function calcula_vagas(){
	vagas_por_sala 			   = document.getElementById("vagas_por_sala").value*1;
	vagas_por_sala_rematricula = document.getElementById("vagas_por_sala_rematricula").value*1;
	qtde_salas	  	 		   = document.getElementById("qtde_salas").value*1;// alunos por sala
		
	vagas_total =vagas_por_sala+vagas_por_sala_rematricula;
	
	qt_de_salas = vagas_total / qtde_salas;
	 // Salaas
	document.getElementById("vagas_total_horario").innerHTML =vagas_total;
	document.getElementById("inputvagas_total_horario").value =vagas_total;
	if(qt_de_salas!=Infinity){
		document.getElementById("total_salas_rematricula").innerHTML =qt_de_salas.toFixed(0);
	}

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
        <a href="./?tela_id=<?=$_GET[tela_id]?>" class="navegacao_ativo">Horários<span></span></a>
    </div>
    
    <!--
        ///////////////////////////////////////
        Barra de Ações
        ///////////////////////////////////////
    -->
    <div id="barra_info">
        <select name="periodo_id[]" class="periodo_id" style="margin-top:3px;" onchange="location='?tela_id=<?=$_GET[tela_id]?>&periodo_id='+this.value">
            	<option value="0">Selecione 1 Período</option>
            	<?
				
				$q = mq("SELECT * FROM  escolar_periodos WHERE vkt_id='$vkt_id' ORDER BY nome");
				while($r=mf($q)){
					if($_GET[periodo_id]==$r->id){$s="selected='selected'";}else{$s='';}
					echo "<option value='$r->id'$s>$r->nome</option>";
					$periodo_id= $r->id;
				}
				
				?>
            </select>
        <a href="<?php echo $caminho; ?>form.php?curso_id=<?php echo $_GET['curso_id']; ?>&modulo_id=<?php echo $_GET['modulo_id']; ?>&periodo_id=<?
		if($_GET[periodo_id]>0){
			echo $_GET[periodo_id];
		}else{
			echo $periodo_id;
		}
		?>" target="carregador" class="mais"></a>	
        
        
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
                <td width="90">Horario Inicio</td>
                <td width="90">Horario Fim</td>
                <td>Dias</td>
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
				$filtro_p=" AND escolar_periodos.id=".$_GET['periodo_id'];
			}else{
				$filtro_p=" AND escolar_periodos.id='$periodo_id'";
				
			}
			 $s_periodo = (mysql_query($t=" SELECT * FROM escolar_periodos  WHERE vkt_id='$vkt_id' $filtro_p ORDER BY nome"));
            			
							while($periodo=mysql_fetch_object($s_periodo)){
							/*---------------------*/
?>
                <tr <?php echo $cl; ?> >
                	<td width="360" class='cz'><?php echo $periodo->nome; ?></td>                   
                	<td width="90">&nbsp;</td>                   
                	<td width="90" >&nbsp;</td>
                	<td >&nbsp;</td>
               	</tr>

<?												
							
							
								$s_escola = (mysql_query($t="SELECT distinct(h.escola_id),e.nome FROM escolar_horarios as h, escolar_escolas as e WHERE h.escola_id =e.id AND h.periodo_id='$periodo->id'  AND h.vkt_id='$vkt_id' "));
									while($escola=mysql_fetch_object($s_escola)){
								/*----------------------*/
?>
                <tr <?php echo $cl; ?> >
                	<td width="360" class="cz" ><blockquote><?php echo $escola->nome; ?></blockquote></td>                   
                	<td width="90">&nbsp;</td>                   
                	<td width="90" >&nbsp;</td>
                	<td >&nbsp;</td>
               	</tr>

<?												
									$s_cursos = (mysql_query(" SELECT distinct(h.curso_id),c.nome FROM escolar_horarios as h, escolar_cursos as c WHERE h.curso_id=c.id  AND h.periodo_id='$periodo->id' AND escola_id='$escola->escola_id'"));		
										while($curso=mysql_fetch_object($s_cursos)){
										/*-------------------------*/
?>
                <tr <?php echo $cl; ?> >
                	<td width="360" class="cz"><blockquote><blockquote><?php echo $curso->nome; ?></blockquote></blockquote></td>                   
                	<td width="90">&nbsp;</td>                   
                	<td width="90" >&nbsp;</td>
                	<td >&nbsp;</td>
               	</tr>

<?												
										$s_modulos =mysql_query($t =" SELECT distinct(h.modulo_id),m.nome FROM escolar_horarios as h, escolar_modulos  as m  WHERE  h.modulo_id=m.id AND h.periodo_id='$periodo->id' AND escola_id='$escola->escola_id' AND h.curso_id='$curso->curso_id'");
											while($modulos=mysql_fetch_object($s_modulos)){
												/*----------------------*/
?>
                <tr <?php echo $cl; ?> >
                	<td width="360" class="cz"><blockquote><blockquote><blockquote><?php echo $modulos->nome; ?></blockquote></blockquote></blockquote></td>                   
                	<td width="90">&nbsp;</td>                   
                	<td width="90" >&nbsp;</td>
                	<td >&nbsp;</td>
               	</tr>

<?												
														$s_horario = mq($t=" SELECT * FROM escolar_horarios WHERE modulo_id = '$modulos->modulo_id' AND periodo_id='$periodo->id' AND curso_id='$curso->curso_id' AND escola_id='$escola->escola_id'");

																	while($horarios=mf($s_horario)){

?>
                <tr <?php echo $cl; ?> onclick="window.open('<?php echo $caminho; ?>form.php?horario_id=<?php echo $horarios->id; ?>','carregador')" >
                	<td width="360"><blockquote><blockquote><blockquote><blockquote><strong><?
					 if(strlen($horarios->nome)>0){
						 echo $horarios->nome; 
					 }else{
					 	echo converte_numeros_comvirgula_em_dias_semanas($horarios->dias_semana ,$semana_abreviado)." ".substr($horarios->horario_inicio,0,5)." às ".substr($horarios->horario_fim ,0,5); 
					 }
					 
					 ?></strong></blockquote></blockquote></blockquote></blockquote></td>                   
                	<td width="90"><?=substr($horarios->horario_inicio,0,5)?></td>                   
                	<td width="90" ><?=substr($horarios->horario_fim,0,5)?></td>
                	<td ><?=converte_numeros_comvirgula_em_dias_semanas($horarios->dias_semana ,$semana_abreviado)?></td>
               	</tr>

<?															} /* fecha while sala */
											}
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
               <td width="100%">&nbsp;</td>
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