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
	//$("table tr td").css("font-size","8px");
	window.open('modulos/tela_impressao.php?url=');
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
            <input type="hidden" name="ano" id="ano" value="<?=$ano?>"/>
        </form>
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
  		Ano: <input type="text" name="ano" id="ano" style="width:50px;height:10px;text-align:right" value="<?=$ano?>"/>
        <input type="submit" value="Ir"/>
        <input type="hidden" id="tela_id" name="tela_id" value="<?=$_GET['tela_id']?>" />
         <input type="hidden" value="<?php echo $_GET[busca]; ?>" name="busca"/>
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
    	<strong>Faturamento Por Salas</strong>
    	<div style="clear:both"></div>
    	<strong>Ano:</strong> <?=$ano?>
    	
    	</div> 
	</div> 
		<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
        <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
            	<td width="150">Sala</td>
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
            	
				if(!empty($_GET['busca'])){
					$filtro = "AND nome LIKE '%".$_GET['busca']."%'";
				}
				
				$salas = mysql_query($t="SELECT * FROM 
										escolar2_salas
									WHERE 
										vkt_id='$vkt_id' $filtro");
            	while($r=mysql_fetch_object($salas)){
					
					
				
            ?>
                <tr onclick="location.href='?tela_id=539&sala_id=<?=$r->id?>&ano=<?=$ano	?>'">
                    <td width="150"><?=$r->nome?></td>
                	<?php
						$c=1;
						foreach($mes_extenso as $mes){
								$pendentes = mysql_result(mysql_query($t="SELECT 
											SUM(fm.valor_cadastro) as valor_total
											FROM 
												escolar2_matriculas em,
												escolar2_turmas et,
												cliente_fornecedor cf,
												financeiro_movimento fm
											WHERE
												em.vkt_id='$vkt_id' AND
												em.turma_id = et.id AND
												em.responsavel_id = cf.id AND
												em.id = fm.doc AND
												cf.id = fm.internauta_id AND
												fm.origem_tipo='Mensalidade escolar' AND
												fm.status='0' AND
												MONTH(fm.data_vencimento)='$c' AND
												YEAR(fm.data_vencimento)='$ano' AND
												et.sala_id='$r->id'"),0,0);
									$pagos = mysql_result(mysql_query($t="SELECT 
											SUM(fm.valor_cadastro) as valor_total
											FROM 
												escolar2_matriculas em,
												escolar2_turmas et,
												cliente_fornecedor cf,
												financeiro_movimento fm
											WHERE
												em.vkt_id='$vkt_id' AND
												em.turma_id = et.id AND
												em.responsavel_id = cf.id AND
												em.id = fm.doc AND
												cf.id = fm.internauta_id AND
												fm.origem_tipo='Mensalidade escolar' AND
												fm.status='1' AND
												MONTH(fm.data_vencimento)='$c' AND
												YEAR(fm.data_vencimento)='$ano' AND
												et.sala_id='$r->id'"),0,0);
							$total_pago[$c-1]     += $pagos;
							$total_pendente[$c-1] += $pendentes;
							$c++;
							
																						
					?>
                    <td width="29" style="font-size:10px;" onclick=""><? if(!$pagos>0){echo "0,00";}else{echo moedaUsaToBr($pagos);}?></td>
                    <td width="30" style="font-size:10px;"><? if(!$pendentes>0){echo "0,00";}else{echo moedaUsaToBr($pendentes);}?></td>                    
                    <?
						}
					?>
                	<td></td>
                 </tr>
              <?php
					
			  ?> 
            	
            <?php
              }
            ?>	
            </tbody>    
        </table>
   		 <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
             <tr >
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
   

</div

><!--
    ///////////////////////////////////////
    Rodapé
    ///////////////////////////////////////
-->
<div id="rodape">

	
    
</div>