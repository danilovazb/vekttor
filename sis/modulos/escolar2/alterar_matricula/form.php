<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");

$disabled = "";
$disabled_imprimir = 'disabled="disabled";';
if(!empty($matricula->id)){
	$disabled = 'disabled="disabled"';
} if(!empty($matricula->id)){
	$disabled_imprimir = "";
}
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id="exibe_formulario" class="exibe_formulario"  style="top:30px; left:50px;">
<style>
label#responsavel:hover{ cursor:crosshair;}
#turma_id option blockquote { padding:3px;}
</style>
<div id='aSerCarregado'>
<div style="width:815px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Alterar valor matrícula</span></div>
</div>
	<form onsubmit="return validaForm(this)"  class="form_float" id='frmcontrato'  method="post" enctype="multipart/form-data">
		<input type="hidden" name="responsavel_id" id="responsavel_id"  value="<?=$responsavel->id?>">
        <input type="hidden" name="matricula_id" id="matricula_id" value="<?=$matricula_aluno->id?>">
       <input type="hidden" name="tipo" id="tipo" value="Cliente">
      
      <fieldset >
        <legend>
          
          <a onclick="aba_form(this,0)"><strong>Dados dos alunos</strong></a>
                  
        </legend>
        
        <input type="hidden" id="aluno_id" name="aluno_id" value="<?=$aluno->id?>" />
        <input type="hidden" id="aluno_id_busca" name="aluno_id_busca" value="" />
          
          <div style="float:left; width:630px; ">
          <?
          if(empty($aluno->id)){
          ?>
          <label><input type="checkbox" id="responsavel_e_aluno" style="width:inherit" value="0" name="mesmo"><strong>Este Aluno tem os mesmos dados do responsavel</strong></label>
          
          <label><input type="checkbox" name="mesmo_endereco" id="mesmo_endereco" value="0" style="width:inherit" /><strong>Este Aluno reside no mesmo local que o responsavel</strong></label>
          <?
          }
          ?>
          <!--<div style="clear:both;"></div>
          <label>Tipo Matrícula
            <select name="tipo_matricula" id="tipo_matricula">
                <option value="matricula">Matrícula</option>
                <option value="rematricula">Rematricula</option>
            </select>
          </label>-->
          <div style="clear:both;"></div>
          <label style="width:260px;">
              Nome do aluno
              <input type="text" valida_minlength='10' name="nome_aluno" id="nome_aluno" busca='modulos/escolar2/busca/busca_aluno.php,@r1,@r0-value>aluno_id_busca|@r1-value>nome_aluno,0' value="<?=utf8_encode($aluno->nome);?>" disabled="disabled"/>
          </label>
          <label style="width:80px;">
              Nascimento
              <input type="text" id="data_nascimento_aluno" name="data_nascimento_aluno" mascara="__/__/____" sonumero="1" value="<?=dataUsaToBr($aluno->data_nascimento); ?>" disabled="disabled"/>
          </label>
          
          <label style="width:115px;">Cor <?=$aluno->cor?>
          <select name="cor" id="cor" disabled="disabled">
              <option value="branco" <? if($aluno->cor == 'branco') echo 'selected="selected"';?>  >Branco</option>
              <option value="pardo-moreno" <? if($aluno->cor == 'pardo-moreno') echo $checked = 'selected="selected"';?>>Pardo/Moreno</option>
              <option value="negro" <? if($aluno->cor == 'negro') echo $checked = 'selected="selected"';?>>Negro</option>
              <option value="amarelo" <? if($aluno->cor == 'amarelo') echo $checked = 'selected="selected"'; ?>>Amarelo</option>
              <option value="indigena" <? if($aluno->cor == 'indigena') echo $checked = 'selected="selected"';?>>Indígena</option>
              <option value="naodeclarado" <? if($aluno->cor == 'naodeclarado') echo $checked = 'selected="selected"';?>>N&atilde;o Declarado</option>
          </select>
          </label>
          <!-- -->
          <label style="width:90px;" >Sexo
            <select name="sexo_aluno" id="sexo_aluno" disabled="disabled">
                <option value="masculino" <? if($aluno->sexo == 'masculino') echo 'selected="selected"';?> >Masculino</option>
                <option value="feminino"  <? if($aluno->sexo == 'feminino') echo 'selected="selected"';?>>Feminino</option>
            </select>
          </label>
          <div style="display:none">
              Cor<br/>
              <input type="radio" name="cor" value="branco" <? if($aluno->cor == 'branco') echo 'checked="checked"';?>>Branco
              <input type="radio" name="cor" value="pardo-moreno" <? if($aluno->cor == 'pardo-moreno') echo $checked = 'checked="checked"';?>>Pardo/Moreno
              <input type="radio" name="cor" value="negro" <? if($aluno->cor == 'negro') echo $checked = 'checked="checked"';?>>Negro
              <input type="radio" name="cor" value="amarelo" <? if($aluno->cor == 'amarelo') echo $checked = 'checked="checked"'; ?>>Amarelo
              <input type="radio" name="cor" value="indigena" <? if($aluno->cor == 'indigena') echo $checked = 'checked="checked"';?>>Indígena
              <input type="radio" name="cor" value="naodeclarado" <? if($aluno->cor == 'naodeclarado') echo $checked = 'checked="checked"';?>>N&atilde;o Declarado
           </div>
             
           <div style="clear:both"></div>
          
           	<label style="width:260px;">
              Nome do Responsável
              <input type="text" valida_minlength='10' name="nome_aluno" id="nome_aluno" busca='modulos/escolar2/busca/busca_aluno.php,@r1,@r0-value>aluno_id_busca|@r1-value>nome_aluno,0' value="<?=utf8_encode($responsavel->razao_social);?>" disabled="disabled"/>
          </label>
              
		
              
        <label style="width:120px;" >
              CPF do Responsável
              <input type="text" id="cpf_aluno" name="cpf_aluno"  value="<?=$aluno->cpf; ?>" mascara='___.___.___-__' disabled="disabled"/> <!-- valida_cpf='1' retorno='focus|Digite o CPF do aluno corretamente'-->
          </label>
        
        <div style="clear:both"></div>
        
     <div style="width:550px;">
        <legend style="padding:5px;"> Matrícula</legend>
        <hr><br/>
        
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <td style="width:40px;">Período</td>
                <td style="width:160px;">Unidade</td>
                <td style="width:20px;">Série</td>
                <td style="width:20px;">Turma</td>
                <td style="width:20px;">Horário</td>
                <td style="width:140px;">Vlr. Matrícula</td>
                <td style="width:150px;">Vlr. Mensalidade</td>
            </tr>
        </thead>
        <tbody>
        	<tr style="background:#FFF;">
            	<td><?php echo utf8_encode($mat_atual->nome_periodo);?></td>
                <td><?php echo utf8_encode($mat_atual->nome_unidade);?></td>
                <td><?php echo utf8_encode($mat_atual->nome_serie);?></td>
                <td><?php echo utf8_encode($mat_atual->nome_turma);?></td>
                <td><?php echo utf8_encode($mat_atual->nome_horario);?></td>
                <td style="width:140px;text-align:center"><input type="text" name="valor_matricula" sonumero="1" decimal="2" value="<?php echo moedaUsaToBr($mat_atual->vlr_matricula)?>" style="width:40px;height:10px;text-align:right"/></td>
                <td style="width:150px;text-align:center"><input type="text" name="valor_mensalidade" sonumero="1" decimal="2" value="<?php echo moedaUsaToBr($mat_atual->vlr_mens)?>" style="width:40px;height:10px;text-align:right"/></td>
            </tr>
        </tbody>
    </table>
     </fieldset>
      
         
      <div style="width:100%; text-align:center" >   
      <?
      if($_GET['aluno_id'] > 0){
      ?>
      <input name="action" type="submit" value="Excluir" style="float:left" />
      <?
      }
      ?>	
      <input type="button"   value="Responsável" style="float:left; display:none "  class="voltar" id="btn-responsavel"  />
      <input type="submit" name="action"  value="Salvar" style="float:right; "/>
      
       <div class="carregador"> <span> Aguarde... </span> </div>
      <!-- DIV PARA OS BOTOES -->
      <div id="btn-aba" style="float:right;"></div>
      <div id="btn-aba-left" style="float:left;"></div>     
      
      <!-- DIV PARA OPÇÕES ADICIONIAS -->
      <div style="float:left;">
                
      </div>     
      <!--<input type="submit" name="action" value="Confirmar" style="float:right; display:none;" id="confirmar_matricula">-->
      <input name="action" type="submit"  id='confirmar_matricula' value="Salvar"  style="float:right;display:none;"  />
      <div style="clear:both"></div>
        
        </div>
       
    </form>
</div>
</div>
</div>
<script>top.openForm()</script>
<? if(strlen($aluno->senha)<1){echo "<script>top.newPass('senha')</script>";} ?>