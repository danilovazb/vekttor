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

<style>
.adiciona{ margin-top:0px; float:right}
.remove{ margin-top:0px; float:right}
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
    <form class='form_busca' action="" method="get">
         <a></a>
        <input type="hidden" name="limitador" value="<?php echo $_GET['limitador']; ?>" />
        <input type="hidden" name="tela_id" value="<?php echo $_GET['tela_id']; ?>" />
        <input type="hidden" name="pagina" value="<?php echo $_GET['pagina']; ?>" />
        <input type="text" value="<?php echo $_GET[busca]; ?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
    </form>
     <div id="some">&laquo;</div>
    <a href="#" class='s1'>
        SISTEMA
    </a>
    <a href="./" class='s2'>Escolar</a>
    <a href="?tela_id=<?=$_GET[tela_id]?>" class="navegacao_ativo"><span></span>Alunos inadimplentes</a>
</div>   
    <!--
        ///////////////////////////////////////
        Barra de Ações
        ///////////////////////////////////////
    -->
    <div id="barra_info">
      <form method="get">
            <input type="hidden" name="tela_id" value="<?=$_GET[tela_id]?>">
        	Vencida nos últimos <input type="text" rel="tip" id="qtd_dias" title="Informe quantidade de dias" data-placement="bottom" name="qtd_dias" style="width:40px;height:8px;text-align:right;" sonumero="1" 
            value="<?php echo $_GET['qtd_dias']?>"> dias
            
            <input type="submit" value="Buscar">
            
            <button style="float:right; margin-top:2px; margin-right:5px;" class="botao_imprimir" onclick="window.open('modulos/tela_impressao.php?url=')" type="button">
	<img src="../fontes/img/imprimir.png">
	</button>
        </form>
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
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<div id="info_filtro">
Alunos Inadimplentes<br>
<?php
	if($_GET['qtd_dias']>0){
		echo "Parcelas vencidas nos últimos ".$_GET['qtd_dias']." dias";
	}
?>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <td width="190">Aluno</td>
                 <td width="190">Série</td>
                <td width="150">Descrição</td>
                <td width="100">Vencimento</td>
                <td width="50">Valor</td>
                <td>&nbsp;</td>
            </tr>
        </thead>
    </table>             
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">
    <tbody>
    <?php
		$hoje = date('Y')."-".date("m")."-".date("d");
	if(empty($_GET['qtd_dias'])){
	
		$filtro_data_vencimento = "financeiro.data_vencimento < '$hoje'";
	}else{
		$qdt_dias = $_GET['qtd_dias'];
		$filtro_data_vencimento = "data_vencimento >= (SELECT DATE_SUB(NOW(),INTERVAL $qdt_dias DAY)) AND data_vencimento < '$hoje'";
	}
	$sql = mysql_query($ain=" 
		SELECT *, aluno.nome AS nome_aluno, turma.nome as nome_turma, serie.nome AS nome_serie,
		sala.nome as nome_sala, turma.turno as turno, ensino.nome as nome_ensino
		 
		FROM escolar2_matriculas AS matricula
		
		JOIN financeiro_movimento AS financeiro
			ON financeiro.doc = matricula.id
			
		JOIN escolar2_alunos AS aluno
			ON aluno.id = matricula.aluno_id
		JOIN cliente_fornecedor AS responsavel
			ON responsavel.id = matricula.responsavel_id
		JOIN escolar2_turmas AS turma 
			ON matricula.turma_id = turma.id
		JOIN escolar2_horarios AS horario
			ON turma.horario_id = horario.id
		JOIN escolar2_salas AS sala
			ON turma.sala_id = sala.id
		JOIN escolar2_periodo_letivo AS periodo_letivo
			ON turma.periodo_letivo_id = periodo_letivo.id
		JOIN escolar2_series AS serie
			ON turma.serie_id = serie.id
		JOIN escolar2_ensino AS ensino
			ON serie.ensino_id = ensino.id						
		WHERE 
			matricula.vkt_id = '$vkt_id'
		AND
			matricula.status != 'cancelada'
		AND
			financeiro.cliente_id = '$vkt_id'
		AND
			financeiro.origem_tipo = 'Mensalidade escolar'
		AND
			financeiro.status = '0'
		AND
			$filtro_data_vencimento
	");
	
		while($lista=mysql_fetch_object($sql)){
	?>
    <tr id="<?=$ensino->id?>">
        <td width="190"><?=get_nome($lista->nome_aluno,50)?></td> 
       
        <td width="190"><?=$lista->nome_turma.", ".$lista->nome_sala.", ".$lista->turno.", ".$lista->nome_ensino?></td>
        <td width="150"><?=$lista->descricao?></td>
        <td width="100"><?=DataUsaToBr($lista->data_vencimento)?></td>
         <td width="50" style="text-align:right"><?=MoedaUsaToBr($lista->valor_cadastro)?></td>
        <td>&nbsp;</td>
    </tr>     
    <?php
			$total +=$lista->valor_cadastro;
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
<div id="total">
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
             <tr>
                <td width="190"></td>
                 <td width="190"></td>
                <td width="150"></td>
                <td width="100"></td>
                <td width="50"><?=moedaUsaToBr($total)?></td>
                <td></td>
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