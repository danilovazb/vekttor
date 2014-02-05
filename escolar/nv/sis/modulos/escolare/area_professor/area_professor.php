<?php

$tela = mysql_fetch_object ( mysql_query ( "SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'" ) );
$caminho = $tela->caminho;

include ("_functions.php");
include ("_ctrl.php");

$professor = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_professor WHERE usuario_id = '$usuario_id'"));
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id="conteudo">
<script>
$(function(){
	some_menu();
});
</script>
<script>
$("select#options").live('change',function(){
	        var tela       = $(this).val();
			var turma      = $(this).parents().find('#sala_turma').val();
			var materia    = $(this).parents().find('#materia_id').val();
			var periodo_id = $(this).parents().find('#periodo_id').val();
			var sala_materia = $(this).parents().find('#sala_materia').val();
			//alert(sala_materia);
			//alert(periodo_materia);
			location.href='?tela_id='+tela+'&materia='+materia+'&periodo_id='+periodo_id+'&sala='+turma+'&sala_materia='+sala_materia;
			// Materia
			// Periodo
			// Sala
			// Sala Materia
})
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
       <button type="button" name="todas_perguntas" onclick="location.href='?tela_id=296&professor=<?=$professor->id?>'"> <img src="modulos/escolar/area_aluno/forum/img/group.png" align="absbottom"> Perguntas Forum</button>
       <button type="button" name="mensagens_privadas" onclick="location.href='?tela_id=297&professor=<?=$professor->id?>'">  Mensagens Privadas</button>
    </div>
        
    <!--
        ///////////////////////////////////////
        Cabeçalho da tabela
        ///////////////////////////////////////
    -->
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <td width="360"></td>
                <td width="110"></td>
                <td width="70" style="padding-left:0;" colspan="2" align="center">AULAS</td>
               
                <td></td>
            </tr>
        </thead>
         
            <tr>
                <td width="360"><strong>Escola</strong></td>
                <td width="110"><strong>A&ccedil;&atilde;o</strong></td>
                
                <td width="50" style="border-bottom:1px solid #E2E2E2;"><span style="padding-left:5px;">Dada</span></td>
                <td width="50" style="border-bottom:1px solid #E2E2E2;">Ementa</td>
                        
                <td></td>
            </tr>
        
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
            
           
                <tr <?php echo $cl; ?> >
                	<td width="360" ><span style="padding-left:20px">Colégio Orlando Garcia da Silveira</span></td>                   
                	<td width="110">&nbsp;</td>                   
                	<td width="50">&nbsp;</td>
                    <td width="50">&nbsp;</td>
                    <td >&nbsp;</td>
               	</tr>

				<tr <?php echo $cl; ?> >
                	<td width="360" ><span style="padding-left:30px"><strong>Turmas</strong></span></td>                   
                	<td width="110">&nbsp;</td>                   
                	<td width="50">&nbsp;</td>
                    <td width="50">&nbsp;</td>
                    <td >&nbsp;</td>
               	</tr>
                            
                <tr <?php echo $cl; ?> >
                	<td width="360" class="cz" ><span style="padding-left:40px;">TURMADSN01</span></td>                   
                	<td width="110">
                    <select name="options" id="options">
                            <option>Selecione</option>
                        	<option value="256">Avaliaçao</option>
                            <option value="259">Aula</option>
                          
                        </select></td>
                    <td width="50">&nbsp;</td>
                    <td width="50">&nbsp;</td>
                	<td >&nbsp;</td>
               	</tr>
                
                <!-- ======================= -->
                
                 <tr <?php echo $cl; ?> >
                	<td width="360" ><span style="padding-left:20px">Escola Agnus Dei</span></td>                   
                	<td width="110">&nbsp;</td>                   
                	<td width="50">&nbsp;</td>
                    <td width="50">&nbsp;</td>
                    <td >&nbsp;</td>
               	</tr>
                
                		<tr <?php echo $cl; ?> >
                	<td width="360" ><span style="padding-left:30px"><strong>Turmas</strong></span></td>                   
                	<td width="110">&nbsp;</td>                   
                	<td width="50">&nbsp;</td>
                    <td width="50">&nbsp;</td>
                    <td >&nbsp;</td>
               	</tr>

                <tr <?php echo $cl; ?> >
                	<td width="360" class="cz" ><span style="padding-left:40px;">TURMADSN01</span></td>                   
                	<td width="110">
                    <select name="options" id="options">
                            <option>Selecione</option>
                        	<option value="256">Avaliaçao</option>
                            <option value="259">Aula</option>
                            
                        </select></td>
                    <td width="50">&nbsp;</td>
                    <td width="50">&nbsp;</td>
                	<td >&nbsp;</td>
               	</tr>

				<!-- ========================= -->
                
                 <tr <?php echo $cl; ?> >
                	<td width="360" ><span style="padding-left:20px">Colégio Adventus</span></td>                   
                	<td width="110">&nbsp;</td>                   
                	<td width="50">&nbsp;</td>
                    <td width="50">&nbsp;</td>
                    <td >&nbsp;</td>
               	</tr>
                
                			<tr <?php echo $cl; ?> >
                	<td width="360" ><span style="padding-left:30px"><strong>Turmas</strong></span></td>                   
                	<td width="110">&nbsp;</td>                   
                	<td width="50">&nbsp;</td>
                    <td width="50">&nbsp;</td>
                    <td >&nbsp;</td>
               	</tr>

                <tr <?php echo $cl; ?> >
                	<td width="360" class="cz" ><span style="padding-left:40px;">TURMADSN01</span></td>                   
                	<td width="110">
                    <select name="options" id="options">
                            <option>Selecione</option>
                        	<option value="256">Avaliaçao</option>
                            <option value="259">Aula</option>
                        </select></td>
                    <td width="50">&nbsp;</td>
                    <td width="50">&nbsp;</td>
                	<td >&nbsp;</td>
               	</tr>
                
                <!-- ==================  -->
                 <tr <?php echo $cl; ?> >
                	<td width="360" ><span style="padding-left:20px">Colégio Ítalo Brasileiro</span></td>                   
                	<td width="110">&nbsp;</td>                   
                	<td width="50">&nbsp;</td>
                    <td width="50">&nbsp;</td>
                    <td >&nbsp;</td>
               	</tr>
                
                			<tr <?php echo $cl; ?> >
                	<td width="360" ><span style="padding-left:30px"><strong>Turmas</strong></span></td>                   
                	<td width="110">&nbsp;</td>                   
                	<td width="50">&nbsp;</td>
                    <td width="50">&nbsp;</td>
                    <td >&nbsp;</td>
               	</tr>

                <tr <?php echo $cl; ?> >
                	<td width="360" class="cz" ><span style="padding-left:40px;">TURMADSN01</span></td>                   
                	<td width="110">
                    <select name="options" id="options">
                            <option>Selecione</option>
                        	<option value="256">Avaliaçao</option>
                            <option value="259">Aula</option>
                         
                        </select></td>
                    <td width="50">&nbsp;</td>
                    <td width="50">&nbsp;</td>
                	<td >&nbsp;</td>
               	</tr>
              
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
<div id="rodape"></div>
