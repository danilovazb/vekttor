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

$(document).ready(function(){
			$("tr:odd").addClass('al');
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
                <td width="180">Ciclos</td>
                <td width="180">Series</td>
                <td width="180">Materias</td>
                <td>&nbsp;</td>
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
            
         
            
                <tr <?php echo $cl; ?> onclick="window.open('<?php echo $caminho; ?>form.php?curso_id=<?php echo $r->id; ?>','carregador')">
                    <td width="180" align="right"><strong>Ensio Infantil</strong></td>                  
                    <td width="180"></td>
                    <td width="180"></td>
                    <td></td>
                </tr>
                
                <tr <?php echo $cl; ?> onclick="window.open('<?php echo $caminho; ?>form.php?curso_id=<?php echo $r->id; ?>','carregador')">
                    <td width="180" align="right"></td>                  
                    <td width="180">Infantil</td>
                    <td width="180"></td>
                    <td></td>
                </tr>
                
   				<tr <?php echo $cl; ?> onclick="window.open('<?php echo $caminho; ?>form.php?curso_id=<?php echo $r->id; ?>','carregador')">
                    <td width="180" align="right"></td>                  
                    <td width="180">1 &deg; Período</td>
                    <td width="180"></td>
                    <td></td>
                </tr>
                
                <tr <?php echo $cl; ?> onclick="window.open('<?php echo $caminho; ?>form.php?curso_id=<?php echo $r->id; ?>','carregador')">
                    <td width="180" align="right"></td>                  
                    <td width="180">2 &deg; Período</td>
                    <td width="180"></td>
                    <td></td>
                </tr>
              <!-- ============== ensino fundamental =============================  -->
              
               <tr <?php echo $cl; ?> onclick="window.open('<?php echo $caminho; ?>form.php?curso_id=<?php echo $r->id; ?>','carregador')">
                    <td width="180" height="44" align="right"><strong>Ensio Fundamental</strong></td>                  
                    <td align="center"></td>
                    <td align="center"></td>
                    <td></td>
                </tr>
                
                
                
                    <!-- == 1 ciclo ==-->
                 <tr <?php echo $cl; ?> onclick="window.open('<?php echo $caminho; ?>form.php?curso_id=<?php echo $r->id; ?>','carregador')">
                   <td width="180" align="right" valign="top"><strong>1&deg; Ciclo</strong></td>
                    <td width="180" valign="top">1&deg; Ano</td>
                    <td width="180" valign="top"><span style=";">Portugu&ecirc;s<br />
                    Geografia                    <br />
                    Matem&aacute;tica                    </span></td>  
                    <td></td>
                 </tr>
                
   				<tr <?php echo $cl; ?> onclick="window.open('<?php echo $caminho; ?>form.php?curso_id=<?php echo $r->id; ?>','carregador')">
                    <td width="180" align="right" valign="top"></td>                  
                    <td width="180" valign="top">2&deg; Ano</td>
                    <td width="180" valign="top"><span style=";">Hisotiria<br />
                    Portugu&ecirc;s                    <br />
                    Matem&aacute;tica                    <br />
                    Ci&ecirc;ncias                    </span></td>
                    <td></td>
                </tr>
                
                <tr <?php echo $cl; ?> onclick="window.open('<?php echo $caminho; ?>form.php?curso_id=<?php echo $r->id; ?>','carregador')">
                    <td width="180" align="right" valign="top"></td>                  
                    <td width="180" valign="top">3&deg; Ano</td>
                    <td width="180" valign="top"><span style=";">Física II<br />
                    Hist&oacute;ria                    <br />
                    Matem&aacute;tica II                    <br />
                    Geografia                    </span></td>  
                    <td></td>
                </tr>
                
                <!-- == 2 ciclo ==-->
                 <tr <?php echo $cl; ?> onclick="window.open('<?php echo $caminho; ?>form.php?curso_id=<?php echo $r->id; ?>','carregador')">
                   <td width="180" align="right" valign="top"><strong>2&deg; Cilco</strong></td>
                    <td width="180" valign="top">4&deg; Ano</td>
                    <td width="180" valign="top"><span style=";">Inglês Avançado<br />
                    Ingl&ecirc;s Basico                    <br />
                    Educa&ccedil;&atilde;o Artistica                    <br />
                    Geografia                    </span></td> 
                    <td></td>
                </tr>
                            
                
   				<tr <?php echo $cl; ?> onclick="window.open('<?php echo $caminho; ?>form.php?curso_id=<?php echo $r->id; ?>','carregador')">
                    <td width="180" align="right" valign="top"></td>                  
                    <td width="180" valign="top">5&deg; Ano</td>
                    <td width="180" valign="top"><span style=";">Física II<br />
                    F&iacute;sica I                    <br />
                    Educa&ccedil;&atilde;o Artistica                    <br />
                    Geografia                    </span></td> 
                    <td></td>
                </tr>
                
                <tr <?php echo $cl; ?> onclick="window.open('<?php echo $caminho; ?>form.php?curso_id=<?php echo $r->id; ?>','carregador')">
                    <td width="180" align="right" valign="top"></td>                  
                    <td width="180" valign="top">6&deg; Ano</td>
                    <td width="180" valign="top"><span style=";">Educação Física<br />
                    F&iacute;sica I                    <br />
                    Educa&ccedil;&atilde;o Artistica<br />
                    Geografia                    </span></td> 
                    <td></td>
                </tr>
                
                <!-- == 4 ciclo ==-->
               
                 <tr <?php echo $cl; ?> onclick="window.open('<?php echo $caminho; ?>form.php?curso_id=<?php echo $r->id; ?>','carregador')">
                    <td width="180" align="right" valign="top"></td>                  
                    <td width="180" valign="top">7&deg; Ano</td>
                    <td width="180" valign="top"><span style=";">Espanhol<br />
                    Geografia                    <br />
                    Educa&ccedil;&atilde;o Artistica                    <br />
                    F&iacute;sica I                    </span></td>
                     <td></td>
                </tr>
                
   				<tr <?php echo $cl; ?> onclick="window.open('<?php echo $caminho; ?>form.php?curso_id=<?php echo $r->id; ?>','carregador')">
                    <td width="180" align="right" valign="top"></td>                  
                    <td width="180" valign="top">8&deg; Ano</td>
                    <td width="180" valign="top" ><span style=";">Portugues<br />
                    Geografia                    <br />
                    Educa&ccedil;&atilde;o Artistica                    <br />
                    F&iacute;sica I                    </span></td>
                    <td></td>
                </tr>
                
                <tr <?php echo $cl; ?> onclick="window.open('<?php echo $caminho; ?>form.php?curso_id=<?php echo $r->id; ?>','carregador')">
                    <td width="180" align="right" valign="top"></td>                  
                    <td width="180" valign="top">9&deg; Ano</td>
                    <td width="180" valign="top" ><span style=";">Geografia<br />
                    Geografia                    <br />
                    Educa&ccedil;&atilde;o Artistica                    <br />
                    F&iacute;sica I                    </span></td>
                    <td></td>
                </tr>
                
                <!-- == EJA ==-->
                 <tr <?php echo $cl; ?> onclick="window.open('<?php echo $caminho; ?>form.php?curso_id=<?php echo $r->id; ?>','carregador')">
                    <td width="180" align="right"><strong>EJA</strong></td>                  
                    <td width="180" align="center"></td>
                    <td width="180" align="center"></td>
                    <td></td>
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