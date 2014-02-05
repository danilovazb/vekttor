<?php

$tela = mysql_fetch_object ( mysql_query ( "SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'" ) );
$caminho = $tela->caminho; 


?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id="conteudo">
<script>
$(".opm").live('click',function(){
	retorno_id =$(this).attr('id')
	window.location= '?tela_id=263&retorno_id='+retorno_id;
	
});
</script>
<?
include ("_functions.php");
include ("_ctrl.php");

?>
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

        <a href="./" class='s2'>Administrativo</a>
        <a href="../../../../../inscricao_online/sis/modulos/administrativo/importacao/?tela_id=15" class="navegacao_ativo"><span></span>Importação</a>
    </div>
    
    
  <!--
        ///////////////////////////////////////
        Barra de Ações
        ///////////////////////////////////////
    -->
    <div id="barra_info"><a href="<?php echo $caminho; ?>form.php" target="carregador" class="mais"></a>	
    </div>
        
    <!--
        ///////////////////////////////////////
        Cabeçalho da tabela
        ///////////////////////////////////////
    -->
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
            	<td width="150"><?php echo linkOrdem( "Data da importação", "data_hora", 1 ); ?></td>
                <td width="100"><?php echo linkOrdem( "Tipo", "tipo", 0 ); ?></td>
                <td width="90">Boletos</td>
                <td>Nome do Arquivo</td>                
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
                $busca_add = "AND tipo LIKE '%{$_GET[busca]}%'";
            }
            
            
            // necessario para paginacao
            $q = mysql_query ("SELECT count(*) FROM $tabela WHERE vkt_id='$vkt_id'  $busca_add ORDER BY data_hora");
            $registros = mysql_result ($q,0,0);
            
            if( $_GET['ordem'] ){
                $ordem = $_GET['ordem'];
            } else {
                $ordem = "id DESC";
            }
            
            // colocar a funcao da paginação no limite
            $q= mysql_query($t="SELECT *, DATE_FORMAT(data_hora, '%d/%m/%Y - %h:%i:%s') data_hora FROM $tabela WHERE vkt_id='$vkt_id' $busca_add ORDER BY ".$ordem." ".$_GET['ordem_tipo']." LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador])." ") or die ( mysql_error() );
           // echo $t;
            while( $r=mysql_fetch_object($q)){
                $total++;
                if( $total % 2 ){ $cl = "class='al'"; } else { $cl = ''; }
            ?>
            
                <tr <?php echo $cl; ?> >
                    <td width="150"><?=$r->data_hora; ?></td>
                    <td width="100"><?=$r->tipo; ?></td>
                    <td width="90" class="opm" id='<?=$r->id?>'><?=$r->matriculas?></td>
                    <td><?=$r->nome_arquivo;?>(<?=$r->id;?>)</td>
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