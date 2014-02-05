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
                <td width="130"><?php echo linkOrdem( "Telefone", "telefone", 0 ); ?></td>
                <td width="130"><?php echo linkOrdem( "E-Mail", "email", 0); ?></td>
                <td width="110"><?php echo linkOrdem( "Banco", "banco", 0 ); ?></td>
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
            
            if( strlen( $_GET[busca]) > 0 ){
                $busca_add = "AND nome LIKE '%{$_GET[busca]}%'";
            }
            
            
            // necessario para paginacao
            $q = mysql_query ("SELECT count(*) FROM $tabela WHERE vkt_id = '$vkt_id' $busca_add ORDER BY nome");
            $registros = mysql_result ($q,0,0);
            
            if( $_GET['ordem'] ){
                $ordem = $_GET['ordem'];
            } else {
                $ordem = "nome";
            }
            
            // colocar a funcao da paginação no limite
            $q= mysql_query("SELECT * FROM $tabela WHERE vkt_id = '$vkt_id' $busca_add ORDER BY ".$ordem." ".$_GET['ordem_tipo']." LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador])) or die ( mysql_error() );
            
            while( $r=mysql_fetch_object($q)){
                $total++;
                if( $total % 2 ){ $cl = "class='al'"; } else { $cl = ''; }
            ?>
            
                <tr <?php echo $cl; ?> onclick="window.open('<?php echo $caminho; ?>form.php?id=<?php echo $r->id; ?>','carregador')">
                    <td width="260"><?php echo substr($r->nome, 0, 50); ?></td>
                    <td width="130"><?php echo $r->telefone; ?></td>
                    <td width="130"><?php echo $r->email ?></td>
                    <td width="110"><?php echo $r->banco; ?></td>
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