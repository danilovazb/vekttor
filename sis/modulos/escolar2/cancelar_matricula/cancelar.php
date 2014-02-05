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
	//=======
	$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
		window.open('modulos/escolar2/cancelar_matricula/form.php?aluno_id='+id,'carregador');
	});
	
});
//

$("#cancelar_matricula").live("click",function(){
	var matricula_id = $(this).parent().parent().parent().attr("id");
	var item_matricula = $(this).parent().parent().parent();
	var result = confirm("Deseja realmente Cancelar a Matricula?");
	if(result == true){
	
	  $.post("modulos/escolar2/cancelar_matricula/requisicoes.php",{acao:"cancelar_matricula",matricula_id:matricula_id},function(data){
		  if(data == "sucesso"){
			item_matricula.find("#situacao_matricula").html("<span>Cancelada</span>");
			item_matricula.find("#situacao_matricula span").addClass("situacao"); 
			item_matricula.find("#situacao_matricula span").addClass("cancelada");
			item_matricula.find("#status_matricula button").attr("disabled","disabled");
		  }	
	  });
		
	} else if(result == false) {
	 	return false;
	}
});

$("#click_resp").live("click",function(){
		var  matricula_id  = $(this).parent().parent().attr("id");
		var sinal = $(this).text();
			if(sinal == "+")
			  $(this).html("<strong>-</strong>");
			else 
			   $(this).html("<strong>+</strong>")
		
		$("#res_"+matricula_id).toggle();
})
</script>
<style>
.situacao, .status{
  padding: 2px 4px 2px;
  font-size: 9.844px;
  font-weight: bold;
  color: #ffffff;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
  vertical-align: baseline;
  width:60px;
  text-align:center;
}
.aprovado{ background-color: #468847;}
.cancelada{ background-color: #b94a48;}
{background-color: #f89406;}

</style>
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
        <a href="./" class='s1'>Escolar</a>
        <a href="./" class='s2'>Administração Escolar</a>
        <a href="../../../../../inscricao_online/sis/modulos/administrativo/alunos_inscritos/?tela_id=15" class="navegacao_ativo"><span></span>Cancelar Matrícula</a>
    </div>
    
    <!--
        ///////////////////////////////////////
        Barra de Ações
        ///////////////////////////////////////
    -->
    <div id="barra_info">
        <!--<a href="modulos/escolar/alunos_inscritos/form.php" target="carregador" class="mais"></a>-->	
    </div>
        
    <!--
        ///////////////////////////////////////
        Cabeçalho da tabela
        ///////////////////////////////////////
    -->
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <td width="70">MAT.</td>
                <td width="260"><?php echo linkOrdem( "Nome", "nome", 1 ); ?></td>
                <td width="120"><?php echo linkOrdem( "CPF", "cpf", 0 ); ?></td>
                <td width="90"><?php echo linkOrdem( "Nascimento", "data_nascimento", 0); ?></td>
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
        <table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">
            <tbody>
            
            <?php
				$filter = "";
				
           		if(isset($_GET['busca'])){ 
				
					 $filter .=" JOIN escolar2_alunos AS aluno ON aluno.id = matricula.aluno_id ";
					
					if(!is_numeric($_GET['busca'])){
					 $and_busca = " AND aluno.nome like '%".$_GET['busca']."%' ";
					 
					} else {
					 
					 $and_busca = " AND matricula.id = '".$_GET['busca']."' ";
					 
					}
				
			    }
			
				$sql = mysql_query($tu=" SELECT *,matricula.id AS matricula_id FROM escolar2_matriculas AS matricula $filter
				
				WHERE 1 AND matricula.vkt_id = '$vkt_id' $and_busca  GROUP BY matricula.aluno_id ");	
            	
				while($matricula=mysql_fetch_object($sql)){
					$aluno = mysql_fetch_object(mysql_query( " SELECT * FROM escolar2_alunos WHERE id = '$matricula->aluno_id' " ));
            ?>
            
                <tr id="<?php echo $matricula->aluno_id;?>">
                	<td width="70"><?php echo $matricula->matricula_id;?></td>
                    <td width="260"><?php echo $aluno->nome;?></td>
                    <td width="120"><?php echo $aluno->cpf; ?></td>
                    <td width="90"><?php echo dataUsaToBr($aluno->data_nascimento)?></td>
                    <td></td>
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