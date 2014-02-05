<?php

$tela = mysql_fetch_object ( mysql_query ( "SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'" ) );
$caminho = $tela->caminho;

include ("_functions.php");
include ("_ctrl.php");

 $professor = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_professores WHERE usuario_id = '$usuario_id'"));
 
 $turma_id = $_GET["turma_id"];
 $periodo_letivo = $_GET["periodo_letivo"];

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id="conteudo">
<script>
$(function(){
	//some_menu();
});
</script>
<script>
$("select#options").live('change',function(){
		
	var tela       = $(this).val();
	var professor_as_turma = $(this).parents().find('#professor_as_turma').val();
	var unidade_id = $(this).parents().find('#unidade_id').val();
	var turma_id   = $(this).parents().find('#turma_id').val();
	var serie_has_materia   = $(this).parents().find('#serie_has_materia').val();
	
	location.href='?tela_id='+tela+'&professor_as_turma='+professor_as_turma+"&unidade_id="+unidade_id+"&turma_id="+turma_id+"&serie_has_materia="+serie_has_materia;
			
})
$("#impressao").live('click',function(){
	exibir_responsavel = $("#exibir_responsavel").val();
		
	window.open("modulos/escolar2/visao_geral/lista_aluno_turma_print.php?turma_id=<?=$turma_id?>&tipo=<?=trim($_GET["tipo"])?>&serie_id=<?=trim($_GET["serie_id"])?>&sala_id=<?=trim($_GET["sala_id"])?>&horario_id=<?=trim($_GET["horario_id"])?>&periodo_letivo=<?=$_GET["periodo_letivo"]?>&exibe_responsavel="+exibir_responsavel);
});
$("#exibir_responsavel").live('change',function(){
	var exibir_responsavel = $(this).val();
	
	location.href='?tela_id=524&serie_id=<?=$_GET['serie_id']?>&exibir_responsavel='+exibir_responsavel;
});
</script>
<style>
	blockquote{margin-top:0; margin-bottom:0; margin-right:0; margin-left:15px; padding:0;}
	tbody td{ vertical-align:top; line-height:14px;}
	.cz{ color:#666; cursor:default; text-transform:uppercase;}
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
    <div id="some">&laquo;</div>
        <a href="#" class='s1'>
  			SISTEMA 
		</a>
        <a href="./" class='s2'>Escolar</a>
        <a href="./?tela_id=<?=$_GET[tela_id]?>" class="navegacao_ativo"> Alunos <span></span></a>
    </div>
    
    <!--
        ///////////////////////////////////////
        Barra de Ações
        ///////////////////////////////////////
    -->
    <div id="barra_info">
       <button  onclick="location.href='<?=$_SESSION["url_voltar"]?>'">&laquo; Voltar </button>
       
       
       <label>
       Exibir Responsável:
       <select name="exibir_responsavel" id="exibir_responsavel">
       	<option value="sim" <? if($_GET['exibir_responsavel']=='sim'){echo "selected='selected'";} ?>>SIM</option>
        <option value="nao" <? if($_GET['exibir_responsavel']=='nao'){echo "selected='selected'";} ?>>N&Atilde;O</option>
       </select>
       </label>
       <button onclick="window.open('modulos/escolar2/visao_geral/boletim_escolar.php?turma_id=<?=$turma_id?>&tipo=<?=trim($_GET["tipo"])?>&serie_id=<?=trim($_GET["serie_id"])?>&sala_id=<?=trim($_GET["sala_id"])?>&turma_id=<?=trim($_GET["turma_id"])?>&horario_id=<?=trim($_GET["horario_id"])?>&periodo_letivo_id=<?=$_GET["periodo_letivo"]?>')"> Gerar boletins </button>  
       
       <a target="_blank" id="impressao" style="float:right; margin-top:3px; margin-right:10px;"> <img src="../fontes/img/imprimir.png"> </a>
    </div>
        
    <!--
        ///////////////////////////////////////
        Cabeçalho da tabela
        ///////////////////////////////////////
    -->
   
	
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <td width="40">N&ordm;</td>
                <td style="width:220px;">Aluno</td>
               	 <?php
                if(empty($_GET['exibir_responsavel'])||$_GET['exibir_responsavel']=='sim'){
                ?>
				<td style="width:180px;display:<?=$exibir_responsavel?>;">
                	Respons&aacute;vel
                	
                </td>
                <?php
				}
				?>
                <td style="width:40px; padding-left:5px;">Idade</td>
                <td style="width:150px;">Turma</td>
                <td>&nbsp;</td>
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
			 $cont = 0;
			 
			 $sql_matricula = mysql_query(" SELECT * FROM escolar2_matriculas WHERE vkt_id = '$vkt_id' 
				AND turma_id = ".trim($turma_id)." 
				AND matricula_rematricula = '".trim($_GET["tipo"])."' 
				AND status != 'cancelada' ");
			 
			 if( $_GET["tipo"] == "todos" ){
			 	$sql_matricula = mysql_query(" SELECT * FROM escolar2_matriculas WHERE 
					vkt_id = '$vkt_id' 
				AND turma_id = ".trim($turma_id)." 
				AND status != 'cancelada' ");		
			 } 
			 
			 if( !empty($_GET["serie_id"])  ){
				 
				 $sql_matricula = mysql_query($t=" 
				 SELECT * FROM escolar2_matriculas AS matricula
				
				JOIN escolar2_turmas AS turma ON turma.id = matricula.turma_id
				JOIN escolar2_series AS serie ON serie.id = turma.serie_id 
				
				WHERE matricula.vkt_id = '$vkt_id' 
				AND turma.serie_id = ".trim($_GET["serie_id"])." 
				AND matricula.status != 'cancelada' 
				AND turma.periodo_letivo_id = '".$periodo_letivo."'
				ORDER BY turma.nome ASC ");
				 
			  }
			  if( !empty($_GET["sala_id"])  ){
				 
				 $sql_matricula = mysql_query($t=" 
				 SELECT * FROM escolar2_matriculas AS matricula
				 JOIN escolar2_turmas AS turma ON turma.id = matricula.turma_id
				
				  WHERE matricula.vkt_id = '$vkt_id' 
				  AND matricula.status != 'cancelada' 
				  AND turma.sala_id = ".trim($_GET["sala_id"])." 
				  AND turma.serie_id = ".trim($_GET["serie_id"])."
				  AND turma.periodo_letivo_id = '".$periodo_letivo."'
				  ORDER BY turma.nome ASC ");
				 
			  }
			  
			  if( !empty($_GET["turma_id"]) and !empty($_GET["horario_id"]) ){
				   $sql_matricula = mysql_query($t=" 
				 SELECT * FROM escolar2_matriculas AS matricula
				
				JOIN escolar2_turmas AS turma ON turma.id = matricula.turma_id
				
				WHERE matricula.vkt_id = '$vkt_id' 
				AND matricula.status != 'cancelada' 
				AND matricula.turma_id = '".trim($_GET["turma_id"])."'	
				AND turma.horario_id = '".trim($_GET["horario_id"])."'  
				AND turma.periodo_letivo_id = '".$periodo_letivo."'
				ORDER BY turma.nome ASC ");
			  }
					
				
			 //echo $t;
			  while($turma_matricula = mysql_fetch_object($sql_matricula)){
				  $cont++;
				  //$aluno = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_alunos WHERE id = '$turma_matricula->aluno_id'  "));
				  $aluno = @mysql_fetch_object(mysql_query($al=" SELECT *,(YEAR(CURDATE())- YEAR (a.data_nascimento)) - (RIGHT(CURDATE(),5)<RIGHT(a.data_nascimento,5)) AS age FROM escolar2_alunos as a WHERE a.id = '$turma_matricula->aluno_id' "));
				  
				  $responsavel = mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor WHERE id = '$turma_matricula->responsavel_id'  "));
				  
				  $info_turma = mysql_fetch_object(mysql_query( " SELECT *, horario.nome AS nome_horario, turma.nome AS nome_turma FROM escolar2_turmas AS turma 
				  JOIN escolar2_horarios AS horario ON turma.horario_id = horario.id
				  AND turma.id = '".trim($turma_matricula->turma_id)."'" ));
        	?>
              <tr <?php echo $cl; ?> >
                  <td width="40"><strong><?=$cont;?></strong></td>
                  <td style="width:220px;" class='cz' title="<?=$aluno->nome?>"><?php echo get_nome($aluno->nome,30); ?></td>                   
                   <?php
                		if(empty($_GET['exibir_responsavel'])||$_GET['exibir_responsavel']=='sim'){
                	?>
                  <td style="width:180px;" title="<?=$responsavel->razao_social?>"><?=get_nome($responsavel->razao_social,26);?></td>
                  <?php
						}
				  ?>
                  <td style="width:40px;padding-left:5px;"><?=$aluno->age?></td>
                  <td style="width:150px;"><?=$info_turma->nome_turma." - ".$info_turma->nome_horario;?></td>                   
                  <td>&nbsp;</td>
              </tr>

		   <?php												
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
<div id="rodape"></div>
