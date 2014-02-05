<?php
$tela = mysql_fetch_object ( mysql_query ( "SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'" ) );
$caminho = $tela->caminho; 

include ("_functions.php");
include ("_ctrl.php");

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script>
$(document).ready(function(){
			$("tr:odd").addClass('al');
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
            <input type="hidden" name="pagina" value="<?php echo $_GET['pagina']; ?>"/>
            <input type="text" value="<?php echo $_GET[busca]; ?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
        </form>
	<div id="some">&laquo;</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s2'>Escolar</a>
        <a href="../../../../../inscricao_online/sis/modulos/administrativo/alunos_inscritos/?tela_id=15" class="navegacao_ativo"><span></span>Ocorrencias</a>
    </div>
    
    <!--
        ///////////////////////////////////////
        Barra de Ações
        ///////////////////////////////////////
    -->
    <div id="barra_info">
       <input type="button" onClick="location.href='?tela_id=536'" value="<<"> 
       <strong>Turma:</strong><?=$turma->nome?>	
       <strong>Período:</strong> <?=$_GET['de']?> até <?=$_GET['ate']?>
       <button style="float:right; margin-top:2px; margin-right:5px;" class="botao_imprimir" onclick="window.open('modulos/tela_impressao.php?url=')" type="button">
	<img src="../fontes/img/imprimir.png">
	</button>
    </div>
        
    <!--
        ///////////////////////////////////////
        Cabeçalho da tabela
        ///////////////////////////////////////
    -->
  
    
    
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
    <strong>Relatório de Ocorrências</strong>
    <div style="clear:both"></div>
    <strong>Turma:</strong> <?=$turma->nome?>
    <div style="clear:both"></div>
    <strong>Período:</strong> <?=$_GET['de']?> até <?=$_GET['ate']?> 
    </div> 
</div>    
		<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
          <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
            	<td width="200">Aluno</td>
                <td width="80">Data</td>
                <td>Ocorrencia</td>
               
            </tr>
        </thead>
    </table>
        <table cellpadding="0" cellspacing="0" width="100%">
           
            <?php
				$alunos_turmas = mysql_query("
										SELECT *, ea.id as id_aula, eal.nome as nome_aluno, eaa.observacao as observacao_aluno FROM 
											escolar2_professor_has_turma pht,
											escolar2_aula ea,
											escolar2_obs_aluno_aula eaa,
											escolar2_matriculas em,
											escolar2_alunos eal
										WHERE
											pht.turma_id='$turma->id' AND
											pht.id = ea.professor_as_turma_id AND
											ea.id = eaa.aula_id AND
											eaa.matricula_aluno_id = em.id AND
											em.aluno_id = eal.id AND
											ea.data BETWEEN '".DataBrToUsa($_GET['de'])."' AND '".DataBrToUsa($_GET['ate'])."'
										");echo mysql_error();
				while($aluno = mysql_fetch_object($alunos_turmas)){
			?>	
            <tr>
            <td width="200"><?=$aluno->nome_aluno?></td>
            <td width="80"><?=DataUsaToBr($aluno->data)?></td>
            <td ><?=$aluno->observacao_aluno?></td>
          	</tr>
            <?
				}
			?>
        </table>
        
    </div>
    
    <!--
        ///////////////////////////////////////
        Linha de layout
        ///////////////////////////////////////
    -->
<div id="total">    
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
               <td width="100%">&nbsp;</td>
            </tr>
        </thead>
    </table>
</div>
</div>

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
    
</div>