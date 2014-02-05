<?php

$tela = mysql_fetch_object ( mysql_query ( "SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'" ) );
$caminho = $tela->caminho; 

include ("_functions.php");
include ("_ctrl.php");

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script>
function trocaBanco(d) {
	var caixa = document.getElementById('caixaf');
	var bb = document.getElementById('bbf');
	
	if (d.value == "Caixa Econômica") {
		bb.style.display = "none";
		caixa.style.display = "";
	} else {
		bb.style.display = "";
		caixa.style.display = "none";
	}
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
        <div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s2'>Escolar</a>
        <a href="?tela_id=<?=$_GET[tela_id]?>" class="navegacao_ativo"><span></span><?=$tela->nome?></a>
    </div>
    
    <!--
        ///////////////////////////////////////
        Barra de Ações
        ///////////////////////////////////////
    -->
    <div id="barra_info">
        
        <select name="unidade_id" id="unidade_id" style="margin-top:3px;">
        	<option value="">SELECIONE UMA UNIDADE</option>
            
            <?php
				$unidades = mysql_query("SELECT * FROM escolar2_unidades WHERE vkt_id='$vkt_id'");
				
				while($unidade = mysql_fetch_object($unidades)){
				
					echo "<option value='$unidade'>SELECIONE UMA UNIDADE</option>";		
				
				}
			?>
            
        </select>
        
        <a href="<?php echo $caminho; ?>form.php" target="carregador" class="mais"></a>	
    </div>
        
    <!--
        ///////////////////////////////////////
        Cabeçalho da tabela
        ///////////////////////////////////////
    -->
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <td width="260"><?php echo linkOrdem( "Nome", "nome", 1 ); ?></td>
                <td width="130"><?php echo linkOrdem( "Nº Salas", "salas", 0 ); ?></td>
                <td width="200"><?php echo linkOrdem( "Nº de vagas", "email", 0); ?></td>
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
    <?
		// necessario para paginacao
    	$registros= mysql_result(mysql_query("SELECT COUNT(*) FROM escolar2_unidades WHERE vkt_id='$vkt_id'"),0,0);
		
		$escolas=mysql_query("SELECT * FROM escolar2_unidades WHERE vkt_id='$vkt_id' LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	?>
		<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
        <table cellpadding="0" cellspacing="0" width="100%">
            <tbody>
            
        <?
		$i=0;
		while($escola=mysql_fetch_object($escolas)){
			
			$qtd_salas = mysql_result(mysql_query("SELECT COUNT(*) FROM escolar2_salas WHERE vkt_id='$vkt_id' AND unidade_id = '$escola->id'"),0,0);
			$qtd_vagas = mysql_result(mysql_query("SELECT SUM(capacidade_maxima) FROM escolar2_salas WHERE vkt_id='$vkt_id' AND unidade_id = '$escola->id'"),0,0);
			
			$i++;
			if($i%2==0){$cl='class="al"';}else{$cl='';}
		?>
                <tr <?=$cl?> onclick="window.open('<?=$caminho?>form.php?id=<?=$escola->id?>','carregador')">
                    <td width="260"><?=$escola->nome?></td>
                    <td width="130"><?=$qtd_salas?></td>
                    <td width="200"><?=$qtd_vagas?></td>
                    <td></td>
                </tr>
          <? } ?>
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
                <td width="130">&nbsp;</td>
                <td width="130">&nbsp;</td>
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
    <script>
    $("#qtd_salas").live('keyup',function(){
	
	var id = $("#id").val();
	var qtd_salas = $(this).val();
	
	$("#preenchimento_salas").html('')
	
	if(!id>0){
		val=parseInt($(this).val());
		console.log(val)
		obj="<div class='sala'><label style=\"width:100px;\">Nome da sala<input name='nome[]' type=\"text\" /></label><label style=\"width:110px;\">Capacidade máxima<input name='capacidade_max[]' type=\"text\" /></label><label style=\"width:130px;\">Capacidade Pedagógica<input name='capacidade_ped[]' type=\"text\" /></label></div>";
		//console.log(obj)
	
		for(i=0;i<val;i++){
			$("#preenchimento_salas").append(obj);
		}
		$("#preenchimento_salas").append(obj);
	
	}else{
		$("#preenchimento_salas").load('modulos/escolar2/escolas/busca_salas.php',{id:id, qtd_salas:qtd_salas});
	
	}//if(!id>0)
})

    
    </script>
</div>