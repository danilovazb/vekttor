<?php

$tela = mysql_fetch_object ( mysql_query ( "SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'" ) );
$caminho = $tela->caminho; 

//include ("_functions.php");
//include ("_ctrl.php");
$mes_corrente = "AND MONTH(ea.data_nascimento) = '".date('m')."'";
$ano_corrente = date('Y');
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
        <a href="../../../../../inscricao_online/sis/modulos/administrativo/alunos_inscritos/?tela_id=221" class="navegacao_ativo"><span></span>Aniversariantes</a>
    </div>
    
    <!--
        ///////////////////////////////////////
        Barra de Ações
        ///////////////////////////////////////
    -->
    <div id="barra_info">
        <!--<a href="modulos/escolar/alunos_inscritos/form.php" target="carregador" class="mais"></a>-->	
        <form method="get">
        <input type="hidden" name="tela_id" value="<?php echo $_GET['tela_id']; ?>" />
        
        
        				<select name="mes" id="mes">
                        	<option value="0">Mes</option>
                        	<option value="1" <? if($_GET['mes'] == '1') echo 'selected="selected"';?> >Janeiro</option>
                            <option value="2" <? if($_GET['mes'] == '2') echo 'selected="selected"';?>>Fevereiro</option>
                            <option value="3" <? if($_GET['mes'] == '3') echo 'selected="selected"';?>>Março</option>
                            <option value="4" <? if($_GET['mes'] == '4') echo 'selected="selected"';?>>Abril</option>
                            <option value="5" <? if($_GET['mes'] == '5') echo 'selected="selected"';?>>Maio</option>
                            <option value="6" <? if($_GET['mes'] == '6') echo 'selected="selected"';?>>Junho</option>
                            <option value="7" <? if($_GET['mes'] == '7') echo 'selected="selected"';?>>Julho</option>
                            <option value="8" <? if($_GET['mes'] == '8') echo 'selected="selected"';?>>Agosto</option>
                            <option value="9" <? if($_GET['mes'] == '9') echo 'selected="selected"';?>>Setembro</option>
                            <option value="10" <? if($_GET['mes'] == '10') echo 'selected="selected"';?>>Outubro</option>
                            <option value="11" <? if($_GET['mes'] == '11') echo 'selected="selected"';?>>Novembro</option>
                            <option value="12" <? if($_GET['mes'] == '12') echo 'selected="selected"';?>>Dezembro</option>
                        </select>     
        <!--Ano:
        	<input type="text" name="ano" id="ano" value="<?$_GET['ano']?>" style="width:50px;">-->
        
        <select style="margin-top:1px; margin-left:5px;" name="escola_id" id="escola_id">
        		<option value="0">Escola</option>
                	<?
                    	$s_escola= mysql_query(" SELECT * FROM escolar_escolas WHERE vkt_id='$vkt_id'");
								while($escolas=mysql_fetch_object($s_escola)){
										if($_GET['escola_id'] == $escolas->id){$sel='selected="selected"';} else{$sel='';}
					?>
                    	<option  <?=$sel?> value="<?=$escolas->id?>"><?=$escolas->nome?></option>
                    <?
								}
					?>
        </select>
        <input type="submit" value="Filtrar">
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
                <td width="260"><?php echo linkOrdem( "Nome", "nome", 1 ); ?></td>
                <td width="90"><?php echo linkOrdem( "CPF", "cpf", 0 ); ?></td>
                <td width="80"><?php echo linkOrdem( "Nascimento", "data_nascimento", 0); ?></td>
                <td width="130">Curso</td>
                <td width="130">Modulo</td>
                <td width="170">Horario</td>
                <td width="130">Sala</td>
                <td width="50">Idade</td>
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
            <tbody>
            
            <?php
            
           		if(!empty($_GET['mes'])){
					$and_mes = "AND MONTH(ea.data_nascimento) = '".$_GET['mes']."'";
					$mes_corrente = "";
				}
				
				if(!empty($_GET['ano'])){
					$and_ano = "AND YEAR(ea.data_nascimento) = '".$_GET['ano']."'";	
				}
				
				if(!empty($_GET['escola_id'])){
					$and_escola = 'AND  ee.id = '.$_GET['escola_id'];	
				}
			
				$sql = mysql_query($t=" SELECT 
										*,ea.nome as aluno, ec.nome as curso, ed.nome as modulo, 
										eh.nome as horario,
									    es.nome as sala, ea.id as aluno_id
				 FROM 
				 	escolar_matriculas as em, 
					escolar_escolas  as ee, 
					escolar_alunos   as ea, 
					escolar_cursos   as ec,
				    escolar_modulos  as ed,
					escolar_horarios as eh,
					escolar_salas    as es

							WHERE
								em.escola_id = ee.id
							AND
								em.aluno_id = ea.id
							AND 
								em.vkt_id = '$vkt_id'
							AND 
								em.curso_id=ec.id 
							AND 
								em.modulo_id=ed.id
							AND 
								em.horario_id=eh.id
							AND 
								em.sala_id=es.id
							$mes_corrente
							$and_mes
							$and_escola
			
			");	
           // echo $t;
      
            
            // colocar a funcao da paginação no limite
            /*$q= mysql_query("SELECT * FROM alunos $busca_add ORDER BY ".$ordem." ".$_GET['ordem_tipo']." LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador])) or die ( mysql_error() );*/
            
            while($r=mysql_fetch_object($sql)){
				$nascimento = explode("-",$r->data_nascimento);
				$idade = ($ano_corrente - $nascimento[0]);
                
            ?>
            
                <tr <?php echo $cl; ?> onclick="window.open('modulos/escolar/alunos_inscritos/form.php?aluno_id=<?php echo $r->aluno_id; ?>','carregador')">
                    <td width="260"><?php echo $r->aluno;?></td>
                    <td width="90"><?php echo $r->cpf; ?></td>
                    <td width="80"><?php echo dataUsaToBr($r->data_nascimento)?></td>
                    <td width="130"><?php echo $r->curso;?></td>
                    <td width="130"><?php echo $r->modulo?></td>
                    <td width="170"><?php echo $r->horario?></td>
                    <td width="130"><?php echo $r->sala?></td>
                    <td width="50"><?php echo $idade;?></td>
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