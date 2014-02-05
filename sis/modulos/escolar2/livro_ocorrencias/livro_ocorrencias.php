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
	<div id="some">&laquo;</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s2'>Escolar</a>
        <a href="../../../../../inscricao_online/sis/modulos/administrativo/alunos_inscritos/?tela_id=15" class="navegacao_ativo"><span></span>Alunos Inscritos</a>
    </div>
    
    <!--
        ///////////////////////////////////////
        Barra de Ações
        ///////////////////////////////////////
    -->
  <div id="barra_info">
    <form autocomplete="off" method="get">
    <?
		if(empty($_GET['de'])){$de="01/".date("m")."/".date("Y");}else{$de=$_GET["de"];}
		if(empty($_GET['ate'])){$ate=date("t")."/".date("m")."/".date("Y");}else{$ate=$_GET["ate"];}
	?>
	De:<input type="text" style="height:8px;width:80px;" value="<?=$de?>" calendario="1" mascara="__/__/____"  autocomplete="off" name="de" id="de" sonumero="1">
    Ate:<input type="text" style="height:8px;width:80px;" value="<?=$ate?>" calendario="1" mascara="__/__/____"  autocomplete="off" name="ate" id="ate" sonumero="1">
    <input type="submit" data-placement="right" id="filtrar" value="Filtrar" data-original-title="Filtrar">
    <input type="hidden" value="536" name="tela_id">
<!--<button type="button" onclick="window.open('modulos/tela_impressao.php?url=')" class="botao_imprimir" style="float:right; margin-top:2px; margin-right:5px;" >
	<img src="../fontes/img/imprimir.png" />
</button>-->
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
            	<td width="200">Sala</td>
                <td width="40">Ocorrencias</td>
               
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
           
            <?php
            	
				$horarios = mysql_query("SELECT * FROM escolar2_horarios WHERE vkt_id='$vkt_id'");
            	while($r=mysql_fetch_object($horarios)){
					
					$turmas = mysql_query($t="SELECT * FROM escolar2_turmas WHERE horario_id='$r->id' AND vkt_id='$vkt_id'");
					//echo $t." ".mysql_error();
					
					
            ?>   
            	<thead>         	
            	<tr>
                    <td class="divisor" colspan="3"><?=$r->nome?></td>
                	
                </tr>
                </thead>
                <tbody>
              <?php
			  		$total=0;
			  		while($turma = mysql_fetch_object($turmas)){
						$qtd_ocorrencias = mysql_result(mysql_query(
						$t="SELECT 
							COUNT(*) as qtd 
						FROM 
							escolar2_obs_aluno_aula ocorrencia,
							escolar2_aula aula,
							escolar2_professor_has_turma professor_has_turma,
							escolar2_turmas turma
						WHERE
							aula.vkt_id='$vkt_id' AND
							ocorrencia.aula_id = aula.id AND
							aula.professor_as_turma_id = professor_has_turma.id AND
							professor_has_turma.turma_id = turma.id AND
							turma.id = '$turma->id' AND
							aula.data BETWEEN '".DataBrToUsa($de)."' AND '".DataBrToUsa($ate)."'"),0,0);												
			  			
			  ?>
                <tr onclick="location.href='?tela_id=537&turma_id=<?php echo $turma->id; ?>&de=<?=$de?>&ate=<?=$ate?>'">
                    <td width="200"><?=$turma->nome?></td>
                	<td width="66"><?=$qtd_ocorrencias?></td>
                	<td></td>
                 </tr>
              <?php
					}
			  ?> 
            	</tbody>    
            <?php
              }
            ?>	
            
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