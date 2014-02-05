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
        <a href="?tela_id=<?=$_GET[tela_id]?>" class="navegacao_ativo"><span></span>Cursos</a>
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
                <td width="200">Curso</td>
                <td width="200">Modulos</td>
                <td>Escolas</td>
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
            $q = mysql_query ("SELECT count(*) FROM $tabela WHERE vkt_id='$vkt_id' $busca_add ORDER BY nome");
            $registros = mysql_result ($q,0,0);
            
            if( $_GET['ordem'] ){
                $ordem = $_GET['ordem'];
            } else {
                $ordem = "id";
            }
            
            // colocar a funcao da paginação no limite
            $q= mysql_query("SELECT * FROM  $tabela WHERE vkt_id='$vkt_id' $busca_add ORDER BY ".$ordem." ".$_GET['ordem_tipo']." LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador])) or die ( mysql_error() );
            
            while( $r = mysql_fetch_object($q) ){
				// Vagas totais no curso
				$q1 = mysql_query("SELECT sum(vagas_total_horario) FROM horarios WHERE curso_id = '$r->id'");
				$d1 = @mysql_result($q1, 0);
				if(empty($d1)) { $d1 = 0; }
                $total++;
                if( $total % 2 ){ $cl = "class='al'"; } else { $cl = ''; }
				
				
				$qm = mq("SELECT * FROM escolar_modulos WHERE vkt_id='$vkt_id' AND curso_id='$r->id' ORDER BY id");
				
				$modulos =mysql_num_rows($qm);
				if($modulos<1){
				$qm = mq("SELECT 1=1");
				}
				$modulo=$r->nome;
				$modulocount=0;
				while($m=mf($qm)){
					$modulocount++;
					if($modulocount>1){
						$modulo='&nbsp;';
					}
            ?>
            
                <tr <?php echo $cl; ?> onclick="window.open('<?php echo $caminho; ?>form.php?curso_id=<?php echo $r->id; ?>','carregador')">
                    <td width="200" title='<?=$r->id?>'><?php echo substr($modulo, 0, 40); ?></td>                  
                    <td width="200" title="<?=$m->id?>"><?=$m->nome; ?></td>
                    <td><?
                    if($modulocount==1){
						$q0 = mq($qs="SELECT c.*,u.nome as unidade FROM escolar_cursos_unidades_contas as c, escolar_escolas as u WHERE curso_id='$r->id' AND c.unidade_id=u.id ")	;
						//echo $qs;
						$unidadesx= array();
						while($rc=mf($q0)){
							$unidadesx[]= "$rc->unidade";	
						}
						echo implode(' , ',$unidadesx);
					}
					?></td>
                </tr>
                
            <?php
				}
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