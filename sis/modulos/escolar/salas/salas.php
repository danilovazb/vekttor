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
		document.getElementById("total_salas_rematricula").innerHTML =qt_de_salas;
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
         <div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s2'>Escolar</a>
        <a href="./?tela_id=<?=$_GET[tela_id]?>" class="navegacao_ativo">Salas<span></span></a>
    </div>
    
    <!--
        ///////////////////////////////////////
        Barra de Ações
        ///////////////////////////////////////
    -->
    <div id="barra_info">
        <a href="<?php echo $caminho; ?>/form.php" target="carregador" class="mais"></a>
        <?
			$periodos=mysql_query("SELECT * FROM escolar_periodos WHERE vkt_id='$vkt_id'");
		?>
        <form method="get" action="">
        <select name="periodo_id" id="periodo_id">
        	<option value="">Periodo</option>
            <?
				while($periodo=mysql_fetch_object($periodos)){
					if($periodo->id==$_GET['periodo_id']){$selected='selected=selected';}else{$selected='';}
					echo "<option value=".$periodo->id." $selected>".$periodo->nome."</option>";
				}
			?>
        </select>
        <?
			$cursos=mysql_query("SELECT * FROM escolar_cursos WHERE vkt_id='$vkt_id'");
		?>
        <select name="curso_id" id="curso_id">
        	<option value="">Curso</option>
            <?
				while($curso=mysql_fetch_object($cursos)){
					if($curso->id==$_GET['curso_id']){$selected='selected=selected';}else{$selected='';}
					echo "<option value=".$curso->id." $selected>".$curso->nome."</option>";
				}
			?>
        </select>
         <?
			$escolas=mysql_query("SELECT * FROM escolar_escolas WHERE vkt_id='$vkt_id'");
		?>
        <select name="escola_id" id="escola_id" style="width:100px;">
        	<option value="">Escola</option>
            <?
				while($escola=mysql_fetch_object($escolas)){
					if($escola->id==$_GET['escola_id']){$selected='selected=selected';}else{$selected='';}
					echo "<option value=".$escola->id." $selected>".$escola->nome."</option>";
				}
			?>
        </select>
        Idade de 
        <input type="text" name="de" id="de" value="<?=$_GET['de']?>" sonumero="1" style="width:25px;"/>
        at&eacute; 
        <input type="text" name="ate" id="ate" value="<?=$_GET['ate']?>" sonumero="1" style="width:25px;"/>
          <input type="hidden" name="tela_id" value="211" />
          Anos
        <input type="submit" value="filtrar" />
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
                <td width="360">Horarios</td>
                <td width="90">Idade Mínima</td>
                <td width="90">Idade Máxima</td>
                <td width="90">Alunos</td>
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
							/*---------------------*/
?>
                <tr <?php echo $cl; ?> >
                	<td width="360" class='cz'><?php echo $periodo->nome; ?></td>                   
                	<td width="90">&nbsp;</td>                   
                	<td width="90" >&nbsp;</td>
                	<td width="90" >&nbsp;</td>
                	<td >&nbsp;</td>
               	</tr>

<?												
			if(!empty($_GET['escola_id'])){
				$filtro_e="AND e.id=".$_GET['escola_id'];
			}			
							
								$s_escola = (mysql_query($t="SELECT distinct(h.escola_id),e.nome FROM escolar_horarios as h, escolar_escolas as e WHERE h.escola_id =e.id AND h.periodo_id='$periodo->id' $filtro_e"));
								//echo $t;
									while($escola=mysql_fetch_object($s_escola)){
								/*----------------------*/
?>
                <tr <?php echo $cl; ?> >
                	<td width="360" class="cz" ><blockquote><?php echo $escola->nome; ?></blockquote></td>                   
                	<td width="90">&nbsp;</td>                   
                	<td width="90" >&nbsp;</td>
                	<td width="90" >&nbsp;</td>
                	<td >&nbsp;</td>
               	</tr>

<?									
			if(!empty($_GET['curso_id'])){
				$filtro_c="AND c.id=".$_GET['curso_id'];
			}			
									$s_cursos = (mysql_query($t=" SELECT distinct(h.curso_id),c.nome FROM escolar_horarios as h, escolar_cursos as c WHERE h.curso_id=c.id  AND h.periodo_id='$periodo->id' AND escola_id='$escola->escola_id' $filtro_c"));	
									//echo $t."<br>";	
										while($curso=mysql_fetch_object($s_cursos)){
										/*-------------------------*/
?>
                <tr <?php echo $cl; ?> >
                	<td width="360" class="cz"><blockquote><blockquote><?php echo $curso->nome; ?></blockquote></blockquote></td>                   
                	<td width="90">&nbsp;</td>                   
                	<td width="90" >&nbsp;</td>
                	<td width="90" >&nbsp;</td>
                	<td >&nbsp;</td>
               	</tr>

<?												
		$s_modulos =mysql_query($t =" SELECT distinct(h.modulo_id),m.nome FROM escolar_horarios as h, escolar_modulos  as m  WHERE  h.modulo_id=m.id AND 															                                      h.periodo_id='$periodo->id' AND escola_id='$escola->escola_id' AND h.curso_id='$curso->curso_id'");
				while($modulos=mysql_fetch_object($s_modulos)){
				/*----------------------*/
?>
                <tr <?php echo $cl; ?> >
                	<td width="360" class="cz"><blockquote><blockquote><blockquote><?php echo $modulos->nome; ?></blockquote></blockquote></blockquote></td>                   
                	<td width="90">&nbsp;</td>                   
                	<td width="90" >&nbsp;</td>
                	<td width="90" >&nbsp;</td>
                	<td >&nbsp;</td>
               	</tr>

<?												
			$s_horario = mq($t=" SELECT * FROM escolar_horarios WHERE modulo_id = '$modulos->modulo_id' AND periodo_id='$periodo->id' AND curso_id='$curso->curso_id' 	            AND escola_id='$escola->escola_id'");

														while($horarios=mf($s_horario)){

?>
                <tr>
                	<td width="360" class="cz"><blockquote><blockquote><blockquote><blockquote><?
					 if(strlen($horarios->nome)>0){
						 echo $horarios->nome; 
					 }else{
					 	echo converte_numeros_comvirgula_em_dias_semanas($horarios->dias_semana ,$semana_abreviado)." ".substr($horarios->horario_inicio,0,5)." às ".substr($horarios->horario_fim ,0,5); 
					 }
					 
					 ?>
                	</blockquote></blockquote></blockquote></blockquote></td>                   
                	<td width="90" class="cz"></td>                   
                	<td width="90"></td>
                	<td width="90"></td>
                	<td class="cz"></td>
               	</tr>

				<?
						if(!empty($_GET['de'])&&!empty($_GET['ate'])){
							$filtro_i = "AND idade_minima='".$_GET['de']."' AND idade_maxima='".$_GET['ate']."'";
						}
							$s_salas = mysql_query($t="SELECT * FROM escolar_salas 
							WHERE horario_id='$horarios->id' $filtro_i ORDER BY id");
							//echo $t;
							while($sala=mysql_fetch_object($s_salas)){
								$salas++;
				?>
                 <tr onclick="window.open('<?=$caminho?>/form.php?id=<?=$sala->id?>','carregador')">
                	<td width="360"><blockquote><blockquote><blockquote><blockquote><blockquote><strong><?php echo $sala->nome; ?></strong></blockquote></blockquote></blockquote></blockquote></blockquote></td>
                    <td width="90" align="center"><strong><?php echo $sala->idade_minima; ?></strong></td>                   
                	<td width="90" align="center"><strong><?php echo $sala->idade_maxima; ?></strong></td>
                	<td width="90" align="center"><?
                    
					echo @mysql_result(mq($t="SELECT count(*) FROM escolar_matriculas as m, escolar_alunos as a WHERE m.vkt_id='$vkt_id' AND m.aluno_id=a.id AND m.sala_id='$sala->id'"),0,0);
					?></td>
                	<td class="cz"></td>                   
               	</tr>
                
				<?						
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
               <td width="100%"><?=$salas?></td>
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