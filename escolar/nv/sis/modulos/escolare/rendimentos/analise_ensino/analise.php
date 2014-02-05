<?php

$tela = mysql_fetch_object ( mysql_query ( "SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'" ) );
$caminho = $tela->caminho; 

include ("_functions.php");
include ("_ctrl.php");

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script>

$(".adiciona").live("click", function(){

	conteudo =$("#multiplicador label:first-child").html();
	$("#multiplicador").append( '<label>'+conteudo.replace('mais.png','menos.png').replace('adiciona','remove')+'</label>');
	$("#multiplicador label:last-child").find('input').val('');
});
$(".remove").live("click", function(){
	modulo_id= $(this).attr('modulo_id');
	window.open('?tela_id=210&remove_modulo='+modulo_id,'carregador');
	$(this.parentNode).remove();
});


$(".remove_imagem").live("click", function(){
	curso_id= $(this).attr('curso_id');
	window.open('?tela_id=210&deleta_imagem='+curso_id,'carregador');
	
	$("#img_curso").hide(200);
	
});

$(".undade_escolar").live('click',function(){
	if($(this).is(":checked")){
			$(this.parentNode.parentNode).find("select").removeAttr( "disabled");
	}else{
			$(this.parentNode.parentNode).find("select").attr( "disabled",'disabled');	
	}
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
         <div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s2'>Escolar</a>
        <a href="?tela_id=<?=$_GET[tela_id]?>" class="navegacao_ativo"><span></span>Rendimento por Ensino</a>
    </div>
    
    <!--
        ///////////////////////////////////////
        Barra de Ações
        ///////////////////////////////////////
-->
    <div id="barra_info">
    	<input type="button" name="Imprimir" value="Imprimir" style="float:right;margin-top:3px;" onclick="window.open('modulos/escolar/alunos_inscritos/impressao_aluno.php?id=<?=$_GET['aluno_id']?>','_BLANK')">
        

        
    <a onclick="window.open('modulos/eleitoral/eleitores/download_ficha_cadastral.php','carregador');"><img src="../fontes/img/pdf.png" height="22" style="float:right;margin-top:1px;margin-right:5px;"/></a>

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
        <?
			$cursos=mysql_query("SELECT * FROM escolar_cursos WHERE vkt_id='$vkt_id'");
		?>
                
        <select name="curso_id" id="curso_id">
        	<option value="">Turno</option>
            <option value="">Manhã</option>
            <option value="">Tarde</option>
            <option value="">Noite</option>
        </select>
        <select name="curso_id" id="curso_id">
        	<option value="">Bimestre</option>
            <option value="">1ºBimestre</option>
            <option value="">2ºBimestre</option>
            <option value="">3ºBimestre</option>
            <option value="">4ºBimestre</option>
            <option value="">Recuperação</option>
        </select>

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
                <td width="150">Ensino</td>
                <td width="150">Quantidade de Turmas</td>
                <td width="100">Aprovados</td>
                <td width="100">Reprovados</td>
                <td width="100">Abandono</td>
                <td width=""></td>
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
                <tr class="al">
                    <td  width="150">Maternal</td>
                    <td width="100">50</td>
                    <td width="100">150</td>
                    <td width="100">193</td>
                    <td width="100">61</td>
                    <td width=""></td>
                </tr>
                 <tr >
                    <td width="150">1º Periodo</td>
                    <td width="150">50</td>
                    <td width="100">250</td>
                    <td width="100">193</td>
                    <td width="100">61</td>
                    <td width=""></td>
                </tr>
                <tr>
                
                 <tr class="al">
                    <td width="150">2º periodo</td>
                    <td width="150">50</td>
                    <td width="100">210</td>
                    <td width="100">193</td>
                    <td width="100">61</td>
                    <td width=""></td>
                </tr>
                
                <tr >
                    <td width="150">1º Ciclo</td>
                    <td width="150">50</td>
                    <td width="100">150</td>
                    <td width="100">193</td>
                    <td width="100">61</td>
                    <td width=""></td>
                </tr>
                <tr class="al">
                    <td width="150">EJA</td>
                    <td width="150">50</td>
                    <td width="100">130</td>
                    <td width="100">193</td>
                    <td width="100">61</td>
                    <td width=""></td>
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
               <td width="260">&nbsp;</td>
               <td width="260">&nbsp;</td>
               <td >&nbsp;</td>
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