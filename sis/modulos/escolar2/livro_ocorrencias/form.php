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


echo $mt;
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
    
    <span>Transferência de Aluno</span></div>
</div>
	<form onsubmit="return validaForm(this)"  class="form_float" id='frmcontrato'  method="post" enctype="multipart/form-data">
		<input type="hidden" name="responsavel_id" id="responsavel_id"  value="<?=$responsavel->id?>">
        <input type="hidden" name="matricula_id" id="matricula_id" value="<?=$matricula_aluno->id?>">
       <input type="hidden" name="tipo" id="tipo" value="Cliente">
      
      <fieldset >
        <legend>
          
          <a onclick="aba_form(this,0)"><strong>Dados dos alunos</strong></a>
          <a onclick="aba_form(this,1)"> Transferência </a>
          <a onclick="aba_form(this,2)"> Contrato </a>
         
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
              Nome do aluno *
              <input type="text" valida_minlength='10' name="nome_aluno" id="nome_aluno" busca='modulos/escolar2/busca/busca_aluno.php,@r1,@r0-value>aluno_id_busca|@r1-value>nome_aluno,0' value="<?=utf8_encode($aluno->nome);?>" disabled="disabled"/>
          </label>
          <label style="width:80px;">
              Nascimento *
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
          
           <label style="width:105px;" >
              CPF *
              <input type="text" id="cpf_aluno" name="cpf_aluno"  value="<?=$aluno->cpf; ?>" mascara='___.___.___-__' <?
              $idade = calcula_idade( $aluno->data_nascimento );
              if($idade<=18&&$aluno->id>0){
                  //echo " valida_cpf='1' retorno='focus|Digite o CPF corretamente do aluno'";
              }
              ?> disabled="disabled"/> <!-- valida_cpf='1' retorno='focus|Digite o CPF do aluno corretamente'-->
          </label>
          <label style="width:95px;" >
              RG *
              <input type="text" id="rg_aluno" name="rg_aluno" maxlength="13" sonumero='1' value="<?=$aluno->rg;?>"  disabled="disabled"/> <!-- valida_minlength='5' retorno='focus|Informe RG do Aluno' -->
          </label>
          
          <label style="width:95px;">
          Data Expedição *
          <input type="text" id="rg_dt_expedicao" name="rg_dt_expedicao" mascara='__/__/____' value="<?=dataUsaToBr($aluno->rg_dt_expedicao);?>"disabled="disabled" />
          </label>
          <label style="width:165px;">
              Profissão
              <input type="text" id="profissao" name="profissao"  value="<?=$aluno->profissao;?>" disabled="disabled"/>
          </label>
          <div style="clear:both"></div>
          <label style="width:255px;">
          E-Mail *
          <input type="text" id="email" name="email"  value="<?=$aluno->email;?>" disabled="disabled"/>
          </label>
          <label style="width:105px;">
              Tel. Residencial *
              <input type="text" id="telefone1" name="telefone1" mascara='(__)____-____' value="<?=$aluno->telefone1;?>" valida_minlength='8' retorno='focus|Informe Telefone Aluno' disabled="disabled"/>
          </label>
          <label style="width:105px;">
              Tel. Celular
              <input type="text" id="telefone2" name="telefone2" mascara='(__)____-____' value="<?=$aluno->telefone2;?>" disabled="disabled"/>
          </label>
          <div style="clear:both"></div>
          <label style="width:88px;">
          CEP *
          <input type="text" id="cep" name="cep" mascara='_____-___' sonumero='1' value="<?=$aluno->cep; ?>" valida_minlength='9' retorno='focus|Informe CEP Aluno' disabled="disabled"/>
          </label>
          <label style="width:238px;">
          Endereço *
          <input type="text" id="endereco" name="endereco" value="<?=$aluno->endereco; ?>" valida_minlength='8' retorno='focus|Informe Endereço do Aluno' disabled="disabled"/>
          </label>
          
          <label style="width:137px;">
          Bairro * 
          <input type="text" id="bairro" name="bairro" value="<?=$aluno->bairro; ?>" valida_minlength='4' retorno='focus|Informe Bairro' disabled="disabled"/>
          </label>  
          <div style="clear:both"></div>
          <label style="width:130px;">
              Complemento
              <input type="text" id="complemento" name="complemento" value="<?=utf8_encode($aluno->complemento);?>" disabled="disabled"/>
          </label>
          <label style="width:100px;">
              Cidade
              <input type="text" id="cidade" name="cidade" value="<?=$aluno->cidade; ?>" disabled="disabled"/>
          </label>
          <label style="width:25px;">
              UF
              <input type="text" id="uf" name="uf" value="<?=$aluno->uf;?>" disabled="disabled"/>
          </label>
          
          <label style="width:190px;">
              Portador Necessidades Especiais
              <input type="text" id="portador_necessidade" name="portador_necessidade" value="<?=utf8_encode($aluno->portador_necessidade);?>" disabled="disabled"/>
          </label>
          
         <div style="clear:both"></div>
          <label style="width:160px;">
              Escolaridade
              <input type="text" id="escolaridade_aluno" name="escolaridade_aluno" value="<?=$aluno->escolaridade; ?>" disabled="disabled"/>
          </label>
          
          <label>Código Interno<br/>
              <input type="text" name="codigo_interno" id="codigo_interno" style="width:90px;" value="<?=$aluno->codigo_interno;?>" disabled="disabled">
          </label>
          <label style="width:60px;">Cod.Aluno: <?=$aluno->id?>
          </label>
          <label style="width:60px;">Senha
              <input type="text" name="senha" id="senha" value="<?=$aluno->senha?>" disabled="disabled"/>
          </label>
                <label  style="width:100px">
          Tipo de Aluno <br />
          <?
          
          $bolsista = mf(mq("
          SELECT * FROM escolar_alunos_bolsistas WHERE aluno_id = '$aluno->id'
          "));
          if($bolsista->aluno_id>0){
              echo "<strong>Bolsista</strong>";	
          }else{
              echo "<strong>Integral</strong>";	
          }
          ?>
          </label>
          <label><? if($cliente_id==13){ ?> Universidades/Áreas <?   }else{ ?>  Restriçao Alimentar / Alergia <?  } ?>
              <input type="text" name="restricao_alimentar" id="restricao_alimentar" size="25" value="<?=utf8_encode($aluno->restricao_alimentar)?>" disabled="disabled">
          </label>
          
          <label style="width:90px;">Tipo Matrícula *
            <select name="tipo_matricula" id="tipo_matricula" disabled="disabled">
                <option value="matricula" <? if($matricula_aluno->matricula_rematricula == "matricula"){ echo 'selected="selected"';} ?>>Matrícula</option>
                <option value="rematricula" <? if($matricula_aluno->matricula_rematricula == "rematricula"){ echo 'selected="selected"';} ?>>Rematricula</option>
            </select>
          </label>     
		
        <div style="clear:both"></div> 
        
    <!--    <div style="width:550px;">
        <legend style="padding:5px;"> Matrícula atual</legend>
        <hr><br/>
        
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <td style="width:40px;">Período</td>
                <td style="width:160px;">Unidade</td>
                <td style="width:20px;">Série</td>
                <td style="width:20px;">Turma</td>
                <td style="width:20px;">Horário</td>
            </tr>
        </thead>
        <tbody>
        	<tr style="background:#FFF;">
            	<td><?php echo utf8_encode($mat_atual->nome_periodo);?></td>
                <td><?php echo utf8_encode($mat_atual->nome_unidade);?></td>
                <td><?php echo utf8_encode($mat_atual->nome_serie);?></td>
                <td><?php echo utf8_encode($mat_atual->nome_turma);?></td>
                <td><?php echo utf8_encode($mat_atual->nome_horario);?></td>
            </tr>
        </tbody>
    </table>
       
                
      -->  
       
      </fieldset>
      
      <fieldset id="campos_2" style="display:none" >
        <legend>
          <a onclick="aba_form(this,0)">Dados dos alunos</a>
          <a onclick="aba_form(this,1)"> <strong>Transferência</strong> </a>
          <a onclick="aba_form(this,2)"> Contrato </a>
        </legend>
        
         <!-- SELECT PARA PERIODO LETIVO -->
        <span class="status_mat"> Aguarde... </span>
        <br/>
        <label>Periodo Letivo
        	<select name="periodo_letivo_transferencia" id="periodo_letivo_transferencia">
            <option value="0">Selecione</option>
            <?
            	$sql_periodo_letivo = mysql_query(" SELECT * FROM escolar2_periodo_letivo WHERE vkt_id = '$vkt_id' ");
				while($periodo_letivo=mysql_fetch_object($sql_periodo_letivo)){
					if($mat_atual->periodo_id==$periodo_letivo->id){
						$selected="selected='selected'";
					}
			?>
            <option value="<?=$periodo_letivo->id?>" <?=$selected?>><?=utf8_encode($periodo_letivo->nome)?></option>
            <?
					$selected='';
				}
			?>
            </select>
        </label>
        
        <label style="width:100px;">UNIDADE
        	<select name="unidade_transferencia" id="unidade_transferencia">
            	<option value="0">Selecione</option>
            	<?
            		$sql_unidade = mysql_query(" SELECT * FROM escolar2_unidades WHERE vkt_id = '$vkt_id' ");
					while($unidade=mysql_fetch_object($sql_unidade)){
						//echo $matricula_turma->unidade_id." ".$unidade->id;
						if($matricula_turma->unidade_id==$unidade->id){
							$selected="selected='selected'";
						}
				?>
            	<option value="<?=$unidade->id?>" <?=$selected?>><?=utf8_encode($unidade->nome)?></option>
            	<?
					$selected='';
					}
				?>

            </select>
        </label>
        
        <!-- SELECT PARA SERIE -->
        <label style="width:100px;">Série
        	<select name="serie_transferencia" id="serie_transferencia">
           		<option value="0">Selecione</option>
            	<?
            		$sql_serie = mysql_query(" SELECT * FROM escolar2_series WHERE vkt_id = '$vkt_id' ");
					while($serie=mysql_fetch_object($sql_serie)){
						//echo $matricula_turma->unidade_id." ".$unidade->id;
						if($matricula_serie->id==$serie->id){
							$selected="selected='selected'";
						}
				?>
            	<option value="<?=$serie->id?>" <?=$selected?>><?=utf8_encode($serie->nome)?></option>
            	<?
					$selected='';
					}
				?>
           
            </select>
        </label>
        
         <!-- SELECT PARA TURMA -->
        <label style="width:100px;">Turma
      	<select name="turma_transferencia" id="turma_transferencia">
        	
            <option value="0">Selecione</option>
            	<?
            		$sql_turma = mysql_query(" SELECT * FROM escolar2_turmas WHERE vkt_id = '$vkt_id' ");
					while($turma=mysql_fetch_object($sql_turma)){
						//echo $matricula_turma->unidade_id." ".$unidade->id;
						if($matricula_turma->id==$turma->id){
							$selected="selected='selected'";
						}
				?>
            	<option value="<?=$turma->id?>" <?=$selected?>><?=utf8_encode($turma->nome)?></option>
            	<?
					$selected='';
					}
				?>
            
        </select>
        </label>
        <input type="hidden" name="fazer_transferencia" id="fazer_transferencia" retorno="focus|Não existe turma" valida_minlength='1'>
        
        
        
      </fieldset>
      
      <fieldset id="campos_3" style="display:none" >
        <legend>
          <a onclick="aba_form(this,0)"> Dados dos alunos </a>
          <a onclick="aba_form(this,1)"> Transferência </a>
          <a onclick="aba_form(this,2)"> <strong>Contrato</strong> </a>
        </legend>
        
        <label style="width:300px;"> <!-- INICIO CONTRATO -->
        	Modelo de Contrato:
			<select name="modelo_id" id="modelo_id" retorno="focus|Selecione o Modelo do Contrato" valida_minlength='1'>
            	<option value=''></option>
				<?php
					$modelos = mysql_query($t="SELECT * FROM odontologo_contrato_modelo WHERE vkt_id = '$vkt_id'"); 
					//alert($contrato->contrato_modelo_id);
					while($modelo = mysql_fetch_object($modelos)){
						if($modelo->id == $matricula->modelo_contrato_id){
							$selected="selected='selected'";
						}
						echo "<option value='$modelo->id' $selected>$modelo->nome</option>";
						$selected='';
					}
				?>
            </select>
		</label >
        <div style="clear:both"></div>
        <label style="display:none">
		<textarea name="texto" cols="25" rows="29" id="tx_html">
		<?php
			//$contrato = mysql_fetch_object(mysql_query($t="SELECT * FROM odontologo_contrato_modelo WHERE id='".$_GET['id']."'"));
   			echo utf8_encode($matricula_aluno->contrato);

		?>
        </textarea>
              </label >
  
        <label style="width:40px">
<select name="select"class="in"style="margin-right:5px; w"onchange="ti('fontsize',this.options[this.selectedIndex].value)"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option>  </select>
</label>

<a onclick="ti('bold',null)" href="#" class='btf bold'></a>
<a onclick="ti('italic',null)" href="#" class='btf italic'></a>
<a onclick="ti('underline',null)" href="#" class='btf underline'></a>

<a onclick="ti('justifyleft',null)" href="#" class='btf justifyleft'></a>
<a onclick="ti('justifycenter',null)" href="#" class='btf justifycenter'></a>
<a onclick="ti('justifyright',null)" href="#" class='btf justifyright'></a>
<a onclick="ti('justifyfull',null)" href="#" class='btf justifyfull'></a>

<a onclick="ti('insertunorderedlist',null)" href="#" class='btf insertunorderedlist'></a>
<a onclick="ti('insertorderedlist',null)" href="#" class='btf insertorderedlist'></a>
<div style="clear:both"></div>

       <iframe id='ed' name='ed' width="75%" style="height:375px; background:#FFF;  overflow:scroll;float:left" onload="this.contentWindow.document.designMode='on'; this.contentWindow.document.body.innerHTML=document.getElementById('tx_html').value;" frameborder="0"class="edtx"></iframe>

 
       <div id="esquerda" style="float:right;overflow:auto">
        	
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratante_razaosocial</strong></a>
        	<div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratante_cnpj</strong></a>
        	<div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratante_endereco</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratante_nomecontato</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratante_cpf</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratante_rg</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_nome</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_ctps</strong></a>
            
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_remuneracao</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_hr_inicio</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_hr_fim</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_cargo</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_duracao</strong></a>
        	<div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_cnpj</strong></a>
        	<div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_endereco</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_nomecontato</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_cpf</strong></a>
            <div style="clear:both"></div>
              <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_rg</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@valor_mensalidade</strong></a>
            
 			<!-- ADICIONADO -->	 
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@turma</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@serie</strong></a>
             <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@periodo_letivo</strong></a>
            
        </div> <!-- FIM CONTRATO -->
       
      
      <div style="clear:both;"></div>
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
        <?
        if(empty($matricula->id)){
		?>
      	<input type="checkbox" name="imprimir_boleto" id="imprimir_boleto" value="1">Imprimir Boleto
        <input type="checkbox" name="imprimir_contrato" id="imprimir_contrato" value="1">Imprimir Contrato
        <?
		}
        if(!empty($matricula->id)){
		?>
        <button type="button" id="boleto_matricula"><strong>Imprimir Boleto</strong></button>
        <button type="button" id="impressao_contrato"><strong>Imprimir Contrato</strong></button>
        <button type="button" onclick="window.open('modulos/escolar2/aluno/impressao_aluno.php?id=<?=$aluno->id?>','_BLANK')"><strong>Imprimir Ficha</strong></button>
        <?
		}
		?>
        
      </div>     
      <input name="salva_formulario_contrato_cliente" type="hidden" value="1" />    
      <!--<input type="submit" name="action" value="Confirmar" style="float:right; display:none;" id="confirmar_matricula">-->
      <input name="action" type="button"  id='confirmar_matricula' value="Confirmar"  style="float:right;display:none;"  />
      <div style="clear:both"></div>
        
        </div>
       
    </form>
</div>
</div>
</div>
<script>top.openForm()</script>
<? if(strlen($aluno->senha)<1){echo "<script>top.newPass('senha')</script>";} ?>