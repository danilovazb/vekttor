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
	
	if (d.value == "Caixa Econ�mica") {
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
        Barra de Navega��o
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
        <div id="some">�</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s2'>Escolar</a>
        <a href="?tela_id=<?=$_GET[tela_id]?>" class="navegacao_ativo"><span></span><?=$tela->nome?></a>
    </div>
    
    <!--
        ///////////////////////////////////////
        Barra de A��es
        ///////////////////////////////////////
    -->
    <div id="barra_info">
        <a href="<?php echo $caminho; ?>form.php" target="carregador" class="mais"></a>	
    </div>
        
    <!--
        ///////////////////////////////////////
        Cabe�alho da tabela
        ///////////////////////////////////////
    -->
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <td width="260"><?php echo linkOrdem( "Nome", "nome", 1 ); ?></td>
                <td width="130"><?php echo linkOrdem( "N� Salas", "salas", 0 ); ?></td>
                <td width="200"><?php echo linkOrdem( "N� de vagas", "email", 0); ?></td>
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
	$escolas=array(
		array('Escola Municipal de Manacapuru',12,242),
		array('Escola Municipal de Grito da Mata',8,96),
		array('Escola Municipal Eurinice Cunha Mendes',11,186),
		array('Escola da Fam�lia',20,300),
		array('Escola Ant�nio Telles',30,400),
		array('Escola Municipal Pequeno G�nio',7,84),
		array('Escola Municipal Pequeno Gafanhoto',8,120),
		array('Escola Municipal Manacapuru Inteligente',5,72),
		array('Escola Municipal de Manacapuru II',15,164),
		array('Escola Municipal Antonio Reis',7,84),
		array('Escola Municipal Futuro de Manacapuru',10,100),
		array('Escola do Futuro',7,84),
		array('Escola Municipal Cacilda Neves',20,280),
		array('Escola Municipal do Sangue Sagrado',15,184),
		array('Escola Municipal Cora��o Puro',12,155),
		array('Escola Municipal Jo�o Beckenbauer',13,170),
		array('Escola Municipal Zico',20,400),
	);
	?>
		<script>resize()</script><!-- Isso � Necess�rio para a cria��o o resize -->
        <table cellpadding="0" cellspacing="0" width="100%">
            <tbody>
            
        <?
		$i=0;
		foreach($escolas as $escola){
			$i++;
			if($i%2==0){$cl='class="al"';}else{$cl='';}
		?>
                <tr <?=$cl?> onclick="window.open('<?=$caminho?>form.php','carregador')">
                    <td width="260"><?=$escola[0]?></td>
                    <td width="130"><?=$escola[1]?></td>
                    <td width="200"><?=$escola[2]?></td>
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
    Rodap�
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
	$("#preenchimento_salas").html('')
	val=parseInt($(this).val());
	console.log(val)
	obj="<div class='sala'><label style=\"width:100px;\">Nome da sala<input name='nome[]' type=\"text\" /></label><label style=\"width:110px;\">Capacidade m�xima<input name='capacidade_max[]' type=\"text\" /></label><label style=\"width:130px;\">Capacidade Pedag�gica<input name='capacidade_ped[]' type=\"text\" /></label></div>";
	//console.log(obj)
	
	for(i=0;i<val;i++){
		$("#preenchimento_salas").append(obj);
	}
	//$("#preenchimento_salas").append(obj);
	
	
})

    
    </script>
</div>