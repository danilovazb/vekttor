<?php
$tela = mysql_fetch_object ( mysql_query ( "SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'" ) );
$caminho = $tela->caminho; 

include ("_functions.php");
include ("_ctrl.php");

if(empty($_GET['ano'])){
	$ano=date('Y');
}else{
	$ano=$_GET['ano'];
}
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script>
$(document).ready(function(){
			$("tr:odd").addClass('al');
});

$(".remove_imagem").live("click", function(){
	aluno_id= $(this).attr('aluno_id');
	window.open('?tela_id=215&deleta_imagem='+aluno_id,'carregador');
	
	$("#img_curso").hide(200);
	
});
$(".adiciona").live("click", function(){

	conteudo =$(".multiplicador").html();
	$(".multiplicador").append(conteudo.replace('mais.png','menos.png').replace('adiciona','remove'));
	
});
$(".remove").live("click", function(){
	modulo_id= $(this).attr('modulo_id');
	window.open('?tela_id=210&remove_modulo='+modulo_id,'carregador');
	$(this.parentNode).remove();
});
var Password = function() {
	this.pass = "";

	this.generate = function(chars) {
	  for (var i= 0; i<chars; i++) {
		this.pass += this.getRandomChar();
	  }
	  return this.pass;
}

	this.getRandomChar = function() {
		/* 
		*	matriz contendo em cada linha indices (inicial e final) da tabela ASCII para retornar alguns caracteres.
		*	[48, 57] = numeros;
		*	[64, 90] = "@" mais letras maiusculas;
		*	[97, 122] = letras minusculas;
		*/
		var ascii = [[48, 57],[97,122]];
		var i = Math.floor(Math.random()*ascii.length);
		return String.fromCharCode(Math.floor(Math.random()*(ascii[i][1]-ascii[i][0]))+ascii[i][0]);
	} 
}

function newPass(destino) {
	var pwd = new Password();
	senha =  pwd.generate(6);
	
	document.getElementById(destino).value = senha;
}

$(".botao_imprimir").live('click',function(){
	
	window.open('modulos/escolar2/faturamento_sala/impressao_mensalidades.php?sala_id=<?=$_GET['sala_id']?>&ano=<?=$_GET['ano']?>');
});
</script>	

<div id="conteudo">

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
        <a href="../../../../../inscricao_online/sis/modulos/administrativo/alunos_inscritos/?tela_id=15" class="navegacao_ativo"><span></span>Faturamento Por Sala</a>
    </div>
    
    <!--
        ///////////////////////////////////////
        Barra de Ações
        ///////////////////////////////////////
    -->
  <div id="barra_info">
  	
   <button type="button" class="botao_imprimir" style="float:right; margin-top:2px; margin-right:5px;">
	<img src="../fontes/img/imprimir.png">
</button>
    <form autocomplete="off" method="get">
  		<input type="button" value="<<" onclick="location.href='?tela_id=538'"/>
        <strong>Ano:</strong> <?=$ano?>
        <strong>Sala:</strong> <?=$sala->nome?>
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
            	<td width="150">Aluno</td>
              	<td width="150">Responsável</td>
				<?php
					foreach($mes_extenso as $mes){
						echo "<td width='70'>".substr($mes,0,3)."</td>";
					}
				?>
                <td></td>
            </tr>
         </thead>
     </table>
     <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
            	<td width="149"></td>
              	<td width="150"></td>
              	<?php
					foreach($mes_extenso as $mes){
						echo "<td width='30' style='font-size:8px;' class='coluna_pago'>Pago</td>";
						echo "<td width='29' style='font-size:8px;' title='Pendente' rel='tip' class='coluna_pendente'>Pend.</td>";
					}
				?>
                <td></td>
            </tr>
        </thead>
    </table>
        <table cellpadding="0" cellspacing="0" width="100%">
           <tbody>
            <?php
            	
				$matriculas_salas = mysql_query(
						"
							SELECT *, ea.nome as nome_aluno, em.id as id_matricula FROM
								escolar2_turmas et,
								escolar2_matriculas em,
								cliente_fornecedor cf,
								escolar2_alunos ea
							WHERE
								et.vkt_id='$vkt_id' AND
								et.id = em.turma_id AND
								em.aluno_id = ea.id AND
								em.responsavel_id = cf.id AND
								et.sala_id = '$sala->id'								
						");
					while($matricula = mysql_fetch_object($matriculas_salas)){
						
						
				
            ?>
                <tr>
                    <td width="149"><?=$matricula->nome_aluno?></td>
              		<td width="150"><?=$matricula->razao_social?></td>
                	
					<?php
												
						$c=1;
						foreach($mes_extenso as $mes){
							$mensalidade_pendentes = mysql_result(
								mysql_query($t="SELECT SUM(valor_cadastro) as total FROM
									financeiro_movimento
								WHERE
									cliente_id='$vkt_id' AND
									doc='$matricula->id_matricula' AND
									origem_tipo = 'Mensalidade escolar' AND
									status='0' AND
									MONTH(data_vencimento)='$c' AND
									YEAR(data_vencimento)='$ano'
									"),0,0);
							$mensalidade_pagas = mysql_result(
								mysql_query($t="SELECT SUM(valor_cadastro) as total FROM
									financeiro_movimento
								WHERE
									cliente_id='$vkt_id' AND
									doc='$matricula->id_matricula' AND
									origem_tipo = 'Mensalidade escolar' AND
									status='1' AND
									MONTH(data_vencimento)='$c' AND
									YEAR(data_vencimento)='$ano'
									"),0,0);																
					?>
                    <td width="29" style="font-size:10px;" onclick=""><? if(!$mensalidade_pagas>0){echo "0,00";}else{echo moedaUsaToBr($mensalidade_pagas);}?></td>
                    <td width="30" style="font-size:10px;"><? if(!$mensalidade_pendentes>0){echo "0,00";}else{echo moedaUsaToBr($mensalidade_pendentes);}?></td>                    
                    <?
							$total_pago[$c-1] += $mensalidade_pagas;
							$total_pendente[$c-1] += $mensalidade_pendentes;
							$c++;
							 
						}
					?>
                	<td></td>
                 </tr>
              		<?
				}
					?>
            </tbody>    
        </table>
   		 <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
             <tr >
                    <td width="149"></td>
              		<td width="150"></td>
                    <?php
						for($c=0;$c<sizeof($total_pago);$c++){
					?>
                    <td width="29" style="font-size:9px;" onclick=""><? echo moedaUsaToBr($total_pago[$c])?></td>
                    <td width="30" style="font-size:9px;"><? echo moedaUsaToBr($total_pendente[$c])?></td>
            		<?php
						}
					?>
                    <td></td>
            </tr>
        </thead>
    </table>     
    </div>
    
    <!--
        ///////////////////////////////////////
        Linha de layout
        ///////////////////////////////////////
    -->
   



<!--
    ///////////////////////////////////////
    Rodapé
    ///////////////////////////////////////
-->
<div id="rodape">

	
    
</div>