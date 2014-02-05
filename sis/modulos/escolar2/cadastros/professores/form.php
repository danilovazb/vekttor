<?
//Includes
include("../../../../_config.php");
include("../../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
?>

<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='exibe_formulario' class='exibe_formulario'  style="top:30px; left:50px;">
<div id='aSerCarregado'>
<div style="width:850px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Funcionários</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post" autocomplete="off">
	<fieldset  id='campos_1' >
			
        <input type="hidden" name="j_tipo" value="<? if($cliente_fornecedor->tipo_cadastro=="Físico") echo $cliente_fornecedor->tipo?>">
            
        <legend>
			<a onclick="aba_form(this,0); document.getElementById('tipo_cadastro').value='Jurídico';"><strong>Funcionário</strong></a>
			<a onclick="aba_form(this,1); document.getElementById('tipo_cadastro').value='Físico';">Usuário</a>
		</legend>
            <div style="float:left; width:650px;">
		<label style="width:100px; margin-right:22px;">
			CPF
			<input type="text" id='cpf' name="cpf" value="<?=$funcionario->cpf?>" mascara="___.___.___-__" sonumero='1' 
            retorno="focus|Digite o CPF corretamente" valida_minlength='3' onkeyup="checa_cpf(this)"/>
		</label>
            			
		<label style="width:294px; margin-right:23px;">
			Nome
			<input type="text" id='nome' name="nome" value="<?=$funcionario->nome?>" retorno="focus|Digite o nome corretamente"validamin_length='3'/>
		</label>
            
        <label style="width:100px;">
			Data Nascimento
			<input type="text" mascara='__/__/____' id='data_nascimento' name="data_nascimento" value="<?=dataUsaToBr($funcionario->data_nascimento)?>" 
            retorno="focus|Digite a data de nascimento" valida_minlength='1' />
		</label>
            
    	<label style="width:100px; margin-right:23px;">
			RG
			<input type="text" id='rg' name="rg" value="<?=$funcionario->rg?>"  sonumero='1' />
		</label>
          
    	<label style="width:100px; margin-right:22px;">
			Orgão Emissor
			<input type="text" id='rg_orgao_emissor' name="rg_orgao_emissor" value="<?=$funcionario->rg_orgao_emissor?>" />
		</label>
    	
        <label style="width:100px; margin-right:22px;">
			Data Emissão
			<input type="text" mascara='__/__/____' calendario='1' id='rg_data_emissao' name="rg_data_emissao" value="<?=dataUsaToBr($funcionario->rg_data_emissao)?>" />
		</label>	
    	
        <label style="width:200px;">
  			Grau de Instrução
    		<select name="grau_instrucao" >
    			<option></option>
        		<option <? if($funcionario->grau_instrucao=='1')echo "selected='selected'"; ?> value="1">Analfabeto</option>
        		<option <? if($funcionario->grau_instrucao=='4')echo "selected='selected'"; ?> value="4">Fundamental Incompleto</option>
        		<option <? if($funcionario->grau_instrucao=='5')echo "selected='selected'"; ?> value="5">Fundamental Completo</option>
        		<option <? if($funcionario->grau_instrucao=='6')echo "selected='selected'"; ?> value="6">Ensino Médio Incompleto</option>
        		<option <? if($funcionario->grau_instrucao=='7')echo "selected='selected'"; ?> value="7">Ensino Médio Completo</option>
        		<option <? if($funcionario->grau_instrucao=='8')echo "selected='selected'"; ?> value="8">Superior Incompleto</option>
        		<option <? if($funcionario->grau_instrucao=='9')echo "selected='selected'"; ?> value="9">Superior Completo</option>
        		<option <? if($funcionario->grau_instrucao=='10')echo "selected='selected'"; ?> value="10">Outros</option>
    		</select>
  		</label>
		<div style="clear:both"></div>
		<label style="width:80px">
		  Estado Civil
		  <select name="estado_civil" retorno="focus|Digite o nome corretamente" valida_minlength='3'>
			<?
				if($funcionario->estado_civil=="Casado"){
					$casado='selected="selected"';
				}else{
					$solteiro='selected="selected"';
				}
			?>
				<option value="Solteiro" <?=$solteiro?> >Solteiro</option>
				<option value="Casado" <?=$casado?> >Casado</option>
			</select>
		</label>
		
        <label style="width:100px;">
			Naturalidade
			<input type="text" id='naturalidade' name="naturalidade" value="<?=$funcionario->naturalidade?>" />
		</label>
        
        <label style="width:126px;">
			Nacionalidade
			<input type="text" id='nacionalidade' name="nacionalidade" value="<?=$funcionario->nacionalidade?>" />
		</label>
        <label style="width:80px;" >
        Salário
        	<input name="salario" type="text" sonumero="1" value="<?=moedaUsaToBR($funcionario->salario)?>" decimal="2" />
        </label>
        <div style="clear:both"></div>
        
        <label style="width:194px; margin-right:23px;">
			Email
			<input type="text" id='email' name="email" value="<?=$funcionario->email?>"  retorno="focus|Digite o email corretamente" valida_minlength='3' />
		</label>
            
		<label style="width:90px; margin-right:23px;">
			Telefone
			<input type="text" id='telefone1' name="telefone1" value="<?=$funcionario->telefone1?>" mascara="(__)____-____" sonumero='1' valida_minlength='3' retorno='focus|Por favor, insira um telefone para contato' />
		</label>
		
        <label style="width:90px; margin-right:22px;">
			Celular
			<input type="text" id='telefone2' name="telefone2" value="<?=$funcionario->telefone2?>" mascara="(__)____-____" sonumero='1' />
		</label>
        <label style="width:75px; margin-right:22px;">
          Cep
          <input type="text" id='cep' name="cep" value="<?=$funcionario->cep?>" mascara="_____-___" sonumero='1' 
            autocomplete="off" onkeyup="cp=this.value.replace(/\_/g,'' );
            document.title=cp;if(cp.length==9){return  vkt_ac(this,event,'undefined','modulos/escolar/professor/busca_endereco.php',
            '@r0','funcao_bsc(this,\'@r0-value>cep|@r1-value>endereco|@r2-value>bairro|@r3-value>cidade|@r4-value>estado\',\'cep\')')}"/>
		</label>
		
        <label style="width:190px; margin-right:23px;">
			Endereço
			<input type="text" id='endereco' name="endereco" value="<?=$funcionario->endereco?>" />
		</label>
        
        <label style="width:136px; margin-right:23px;">
			Bairro
			<input type="text" id='bairro' name="bairro" value="<?=$funcionario->bairro?>"/>
		</label>
		
        <label style="width:136px; margin-right:22px;">
			Cidade
			<input type="text" id='cidade' name="cidade" value="<?=$funcionario->cidade?>" retorno="focus|Digite a cidade corretamente" valida_minlength='2'/>
		</label>
		
        <label style="width:30px; margin-right:23px;">
			Estado
			<input type="text" id='estado' name="estado" value="<?=$funcionario->estado?>" retorno="focus|Digite o estado corretamente" valida_minlength='2'/>
		</label>
        <label style="width:100px; margin-right:22px;">
          Data Admissão
          <input type="text" mascara='__/__/____' calendario='1' id='data_admissao' name="data_admissao" value="<?=dataUsaToBr($funcionario->data_admissao)?>" />
		</label>
        
        <label style="width:100px; margin-right:22px;">
			Fim do Contrato
			<input type="text" mascara='__/__/____' calendario='1' id='data_termino_contrato' name="data_termino_contrato" value="<?=dataUsaToBr($funcionario->data_termino_contrato)?>" />
		</label>
        
      

    
        <div style="clear:both"></div>
         
        </div>
        <? /* ?>
            <div style="width:120px;float:left; height:160px;border:1px solid #999; background:#FFF; overflow:hidden">
            
            		<div style="clear:both; padding:2px;" id='img_curso' >
                <?
				
                if(strlen($d->extensao)>=3){
				?>
                <img src='modulos/escolar2/cadastros/professores/img/<?=$d->id?>.<?=$d->extensao?>' height="100" /><br />
                <?
				}
				?>
                </div>
            
            </div>
    <?
                if(strlen($d->extensao)>=3){
				?>
                <a href="#" onclick="this.style.display='none'" class='remove_imagem' aluno_id='<?=$d->id?>'>Remover</a>
                   <?
				}*/
				?>
		<div style="clear:both"></div>
           
           <? 
		   
		   if($professor->id>0){ $s="display:block"; $s2="display:none"; $eh_prof="checked='checked' "; }else{$s="display:none"; $s2="display:block"; $eh_prof='';}
		   ?>
           <label>
           Professor? <input type="checkbox" <?=$eh_prof?> id="eh_professor" onchange="exibeTurnos(this)" name="eh_professor" value="1" />
           </label>
           <label style=" <?=$s2?>" id="cargo_id">
           Cargo 
           	<select name="cargo_id">
            <option>Selecione 1 cargo</option>
            <? $cargos_q=mysql_query($a="SELECT * FROM cargo_salario WHERE vkt_id='$vkt_id' ORDER BY cargo ASC"); 
				while($cargo=mysql_fetch_object($cargos_q)){
					if($funcionario->cargo_id == $cargo->id) { $sel = 'selected="selected"';} else {$sel = '';}
			?>
            		<option <?=$sel?> value="<?=$cargo->id?>" ><?=$cargo->cargo?></option>
            <? } ?>
            </select>
           </label>
           <label style=" <?=$s2?>" id="escola_id">Escola
           	<select  name="escola_id">
            	<option>Selecione 1 escola</option>
            	<? 
				$escolas_q=mysql_query($a="SELECT * FROM escolar2_unidades WHERE vkt_id='$vkt_id' ORDER BY nome ASC"); 
				while($e=mysql_fetch_object($escolas_q)){
					if($funcionario->unidade_id == $e->id) { $sel_und = 'selected="selected"';} else {$sel_und = '';}
						
				?>
            	<option <?=$sel_und?>  value="<?=$e->id?>"><?=$e->nome?></option>
                <? } ?>
            </select>
           </label>
           <div style="clear:both;"></div>
           <div id="dados_professor" style=" <?=$s?>">
		   <?
           $escola= array();
           
           $c=0;
		   $escolas_q=mysql_query($a="SELECT * FROM escolar2_unidades WHERE vkt_id='$vkt_id' ORDER BY nome ASC"); 
           while($e=mysql_fetch_object($escolas_q)){
               $escola[$c]['id']=$e->id;
               $escola[$c]['nome']=$e->nome;
               $c++;
           }
           $horario_escola_q=mysql_query("SELECT * FROM escolar2_unidade_has_professor_horario WHERE vkt_id='$vkt_id' AND professor_id='{$professor->id}' ");
           while($h=mysql_fetch_object($horario_escola_q)){
               $select_horario[$h->horario_id][$h->unidade_id]="selected='selected'";
           }
           ?>
           
           <? 
           $horarios_q=mysql_query("SELECT * FROM escolar2_horarios WHERE vkt_id='$vkt_id'");
           while($h=mysql_fetch_object($horarios_q)){
               ?>
               <label>
                    Escola no turno <?=$h->nome?>
                    <select class="escolas_horarios" id="<?=$h->id?>" onchange="validaescolas(this)" name="horario_escola[]">
                      <option value="">Escolha 1 escola</option>
                      <? foreach($escola as $e){ ?>
                      <option class="<?=$e['id']?>" <?=$select_horario[$h->id][$e['id']]?> value="<?=$h->id?>_<?=$e['id']?>">
                        <?=$e['nome']?>
                      </option>
                      <? } ?>
                    </select>
               </label>
               <div style="clear:both"></div>
               <?
           }
           ?>
       </div>

	</fieldset>
    <fieldset  id='campos_2' style="display:none" >
		<legend>
			<a onclick="aba_form(this,0); document.getElementById('tipo_cadastro').value='Jurídico';">Funcionários</a>
			<a onclick="aba_form(this,1); document.getElementById('tipo_cadastro').value='Físico';"><strong>Usuário</strong></a>
		</legend>        
		<label style="width:151px">
			Tipo de Usuário
            <select name="usuario_tipo_id">
				<?php
					$q=mysql_query("SELECT * FROM usuario_tipo WHERE vkt_id='$vkt_id'");
					while($r=mysql_fetch_object($q)){
				?>
            	
                <option <? if($r->id==$usuario->usuario_tipo_id)echo 'selected="selected"'; ?>  value="<?=$r->id?>"><?=$r->nome?></option>
				
				<?
					}//$r
				?>
            </select>
        </label>
		
        <div style="clear:both"></div>
        
        <label style="width:144px; margin-right:23px;">
			Login
			<input type="text" name="login" id="login" value="<?=$usuario->login?>" maxlength="23" />
		</label>
        <input type="hidden" name="login_antigo" value="<?=$usuario->login?>">
		<label style="width:144px">
			Senha
			<input name="senha" id='senha' type="password" value="<?=$usuario->senha?>" maxlength="23" />
		</label>
        
		<input name="usuario_id" type="hidden" value="<?=$usuario->id?>" />
        
	</fieldset>
    
    
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	<?
	if($funcionario->id>0){
	?>
	<input name="action" type="submit" value="Excluir" style="float:left" />
	<?
	}
	?>
	<input name="professor_id" type="hidden" value="<?=$professor->id?>"/>
    <input name="usuario_id" type="hidden" value="<?=$usuario->id?>"/>
    <input name="funcionario_id" type="hidden" value="<?=$funcionario->id?>"/>
    <input name="action" type="submit"  value="Salvar" style="float:right"  />
	<div style="clear:both"></div>
	</div>
    
    
</form>
</div>
</div>
</div>
<script>top.openForm()</script>