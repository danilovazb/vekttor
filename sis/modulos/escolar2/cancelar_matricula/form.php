<?php

//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
$disabled = "";
$array_situacao = array ('aprovado'=>'Aprovado','reprovado'=>'Reprovado','dependencia'=>'Dependência','cursando'=>'Cursando');
$array_status = array('pre-matricula'=>'<span>Pré-Matrícula</span>','matricula'=>'<span class="status aprovado">Matrícula</span>','cancelada'=>'<span class="status cancelada">Cancelada</span>','transferencia'=>'<span>Tranferência</span>','abandono'=>'<span>Abono</span>');
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div style="top:30px; left:50px;" class="exibe_formulario" id="exibe_formulario">
<style>
#label_materia input{ color:#999; }
#serie_materia tr { background:#FFF;}
</style>
<div id='aSerCarregado'>
    <div style="width:650px;">
    
        <div>
            <div class='t3'></div>
            <div class='t1'></div>
            <div class="dragme">
                <a class='f_x' onclick="form_x(this)"></a>        
                <span>Cancelar Matrícla</span>
            </div>
        </div>
        
		<form onsubmit="return validaForm(this)" class="form_float" method="post" enctype="multipart/form-data">

            <input name="curso_id" type="hidden" value="<?php echo $_GET['curso_id']; ?>" />
            <input type="hidden" name="ensino_id" id="ensino_id" value="<?=$ensino_id?>" valida_minlength="1" retorno="focus|Não existe ensino Cadastrado">
            
            <fieldset id="campos_1">
                <legend><a onclick="aba_form(this,0)"><strong>Cancelar Matrícula</strong></a></legend>
                
                <label style="width:250px; margin-right:23px;">
                    Aluno
                    <input type="text" id="nome" readonly="readonly" name="nome" valida_minlength="5" retorno="focus|Coloque no minimo 5 caracteres" value="<?=$aluno->nome?>" />
                </label>
                
                <table cellpadding="0" cellspacing="0" style="width:100%" id="info_aluno" >
        <thead>
            <tr>
                <td style="width:10px;">&nbsp;</td>
                <td style="width:50px;">MAT.</td>
                <td style="width:150px;">Unidade</td>
                <td style="width:80px;">Turma</td>
                <td style="width:80px;">Série</td>
                <td style="width:60px;">Status</td>
                <td style="width:60px;">Status</td>
            </tr>
        </thead>
      <!--</table>
	  <table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">-->
        <tbody> 	
		<?php
		
		$select_matricula_1 = mysql_query($s="SELECT * FROM escolar2_matriculas WHERE aluno_id = '$aluno_id' AND vkt_id='$vkt_id'");
             
			
			 while($matricula_lista = mysql_fetch_object($select_matricula_1)){ 
			 
			 	$total++;
				if($total%2){$sel='class="al"';}else{$sel='';}
			 
			 	$aluno_matricula = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_alunos WHERE id = '$matricula_lista->aluno_id' ")); 
				
				$turma_lista = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_turmas WHERE id = '$matricula_lista->turma_id' "));
				$sala = 	mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_salas WHERE id = '$turma_lista->sala_id' "));
				$serie = 	mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_series WHERE id = '$turma_lista->serie_id' "));
				$unidade = 	mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_unidades WHERE id = '$turma_lista->unidade_id' "));
				$periodo = 	mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_periodo_letivo WHERE id = '$turma_lista->periodo_letivo_id' "));
				$responsavel_lista = mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor WHERE id = '$matricula_lista->responsavel_id' "));
				
				
				if($matricula_lista->status == "cancelada") {
				  $disabled = 'disabled="disabled"'; 	
				} else {
				  $disabled = '';	
				}
				
		?>
        <tr <?=$sel?> id="<?=$matricula_lista->id;?>" style="background:#FFF;">
            	<td style="width:10px; padding-left:1px;"><div style="text-align:center;" id="click_resp" ><strong>+</strong></div></td>
                <td style="width:50px;"><?=$matricula_lista->id?></td>
                <td><?=utf8_encode($unidade->nome)." - ".$periodo->nome;?></td>
            	<td><?=utf8_encode($turma_lista->nome);?></td>
                <td style="width:60px;"><?=($serie->nome);?></td>
                
            	<td style="width:80px;" id="situacao_matricula"><span><?=$array_status[$matricula_lista->status];?></span></td>
                <td style="width:60px;" align="center" id="status_matricula"><div style="margin-left:-9px;"><button type="button" <?=$disabled?> id="cancelar_matricula">Cancelar</button></div></td>
        </tr>
        
        <tr <?=$sel?> style="display:none; background:#FFF;" id="res_<?=$matricula_lista->id;?>" >
            	<td style="width:10px;"></td>
                <td colspan="7" style="border-top:1px solid #CCC;">
                <div style="padding:5px;"><strong> RESPONSÁVEL </strong> <br/> <?=($responsavel_lista->razao_social);?> <br/> <strong> CNPJ/CPF </strong> <br/><?=$responsavel_lista->cnpj_cpf;?></div>
                </td>
            	
            	
        </tr>
              
		<?php
			  }
        ?>
         </tbody>
       </table>
               
               
          </fieldset>
          
           
            <!--Fim dos fiels set-->
            <div style="width:100%; text-align:center" >
                <?php if( $d->id > 0 ){ ?>
                <input name="action" type="submit" value="Excluir" style="float:left" />
                <?php } ?>
                
                <input type="hidden" name="acao" value="atualizar_ensino">
                <input name="action" type="submit" value="Salvar" style="float:right;visibility:hidden;" />
              
              <div style="clear:both"></div>
            </div>
    	</form>
	</div>
</div>
<script>
	top.openForm();
</script></div>