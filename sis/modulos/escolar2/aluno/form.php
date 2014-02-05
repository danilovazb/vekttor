<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");

$array_situacao = array ('aprovado'=>'Aprovado','reprovado'=>'Reprovado','dependencia'=>'Dependência','cursando'=>'Cursando');
$array_boletim = array('reprovado','dependencia','cursando');
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id="exibe_formulario" class="exibe_formulario"  style="top:30px; left:50px;">
<style>
label#responsavel:hover{ cursor:crosshair;}
</style>
<div id='aSerCarregado'>
<div style="width:850px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Alunos Inscritos</span></div>
</div>
	<form onsubmit="return validaForm(this)" class="form_float"  method="post" enctype="multipart/form-data">

		<input type="hidden" id="aluno_id" name="aluno_id" value="<?=$_GET['aluno_id']; ?>" />

		<fieldset>
          <legend>
            <a onclick="aba_form(this,0)"><strong>Dados dos alunos</strong></a>
    		<a onclick="aba_form(this,1)">Filiaçao</a>
    		<a onclick="aba_form(this,2)">Transporte</a>
    		<a onclick="aba_form(this,3)">Emergencia</a>
            <a onclick="aba_form(this,4)">Matricula</a>
            <a onclick="aba_form(this,5)">Observaçao</a>
            <a onclick="aba_form(this,6)">Financeiro</a>
          </legend>
			
            <div style="float:left; width:650px;">
           	
			<label style="width:478px;">
				Nome
				<input type="text" id="nome" name="nome" value="<?=$aluno->nome; ?>" />
			</label>
            <label style="width:120px;">
				Data de Nascimento
				<input type="text" id="data_nascimento" name="data_nascimento" mascara="__/__/____" sonumero="1" value="<?=dataUsaToBr($aluno->data_nascimento); ?>" />
			</label>
            
            
            <div style="clear:both"></div>
             <div>
            	Cor<br/>
                <input type="radio" name="cor" value="branco" <? if($aluno->cor == 'branco') echo 'checked="checked"';?>>Branco
                <input type="radio" name="cor" value="pardo-moreno" <? if($aluno->cor == 'pardo-moreno') echo $checked = 'checked="checked"';?>>Pardo/Moreno
                <input type="radio" name="cor" value="negro" <? if($aluno->cor == 'negro') echo $checked = 'checked="checked"';?>>Negro
                <input type="radio" name="cor" value="amarelo" <? if($aluno->cor == 'amarelo') echo $checked = 'checked="checked"'; ?>>Amarelo
                <input type="radio" name="cor" value="indigena" <? if($aluno->cor == 'indigena') echo $checked = 'checked="checked"';?>>Indígena
                <input type="radio" name="cor" value="naodeclarado" <? if($aluno->cor == 'naodeclarado') echo $checked = 'checked="checked"';?>>N&atilde;o Declarado
             </div><br>
             
            
            <label style="width:220px;">
				Escolaridade
				<input type="text" id="escolaridade" name="escolaridade" value="<?=$aluno->escolaridade;?>" />
			</label>
            <label style="width:220px;">
				Profissão
				<input type="text" id="profissao" name="profissao"  value="<?=$aluno->profissao;?>" />
			</label>
            
            
            <label style="width:340px;">
				Endereço
				<input type="text" id="endereco" name="endereco" value="<?=$aluno->endereco; ?>" />
			</label>
            
            <label style="width:120px;">
				Bairro
				<input type="text" id="bairro" name="bairro" value="<?=$aluno->bairro; ?>" />
			</label>
            
            <label style="width:120px;">
				Complemento
				<input type="text" id="complemento" name="complemento" value="<?=$aluno->complemento; ?>" />
			</label>
            
            <label style="width:120px;">
				Telefone Residencial
				<input type="text" id="telefone1" name="telefone1" mascara='(__)____-____' value="<?=$aluno->telefone1; ?>" />
			</label>
            
            <label style="width:120px;">
				Telefone Celular
				<input type="text" id="telefone2" name="telefone2" mascara='(__)____-____' value="<?=$aluno->telefone2; ?>" />
			</label>
            
            <label style="width:100px;">
				CEP
				<input type="text" id="cep" name="cep" mascara='_____-___' sonumero='1' value="<?=$aluno->cep; ?>" />
			</label>
			
            <label style="width:150px;">
				Cidade
				<input type="text" id="cidade" name="cidade" value="<?=$aluno->cidade; ?>" />
			</label>
            
            <label style="width:50px;">
				UF
				<input type="text" id="uf" name="uf" value="<?=$aluno->uf; ?>" />
			</label>
            
            <label style="width:120px;">
				RG
				<input type="text" id="rg" name="rg" sonumero='1' value="<?=$aluno->rg; ?>" />
			</label>
            
            <label style="width:120px;">
				Data Expedição
				<input type="text" id="rg_dt_expedicao" name="rg_dt_expedicao" mascara='__/__/____' value="<?=dataUsaToBr($aluno->rg_dt_expedicao); ?>" />
			</label>
            
            <label style="width:120px;">
				CPF
				<input type="text" id="cpf" name="cpf" value="<?=$aluno->cpf; ?>" mascara='___.___.___-__' />
			</label>
            
            <label style="width:202px;">
				E-Mail 
				<input type="text" id="email" name="email" retorno='focus|Coloque o email corretamente' value="<?=$aluno->email; ?>" />
			</label>
            
           <!-- <label style="width:250px;">Turma
            	<input type="text" name="turma" id="turma" value="<?$aluno->turma?>">
            </label>
            
            <label style="width:250px;">Turno
            	<input type="text" name="turno" id="turno" value="<?$aluno->turno?>">
            </label>
            <label>-->
            
            	<input type="hidden" name="responsavel_id" id="responsavel_id" value="<?=$responsavel->id?>">
            </label>
            <label style="width:250px;"> Responsável
            	<input type="text" name="responsavel" id="responsavel" busca='modulos/escolar/alunos_inscritos/busca_clientes.php,@r0 @r2,@r1-value>responsavel_id,0' autocomplete='off' value="<?=$responsavel->nome_fantasia?>">
            </label>
            <label>Código Interno<br/>
            	<input type="text" name="codigo_interno" id="codigo_interno" style="width:90px;" value="<?=$aluno->codigo_interno;?>">
            </label>
            <label style="width:60px;">Cod.Aluno: <?=$aluno->id?>
            </label>
            <label style="width:60px;">Senha
            	<input type="text" name="senha" id="senha" value="<?=$aluno->senha?>" />
            </label>
                  <label  style="width:100px">
            Tipo de Aluno<br />
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
            	<input type="text" name="restricao_alimentar" id="restricao_alimentar" size="55" value="<?=$aluno->restricao_alimentar?>">
            </label>
                  

            <div style="clear:both;"></div>
            <label>
            		<input type="file" name="file[]" >
            </label>
            
            </div>
            <div style="width:120px;float:left; height:160px;border:1px solid #999; background:#FFF; overflow:hidden">
            
            		<div style="clear:both; padding:2px;" id='img_curso' >
                <?
                if(strlen($aluno->extensao)>=3){
				?>
                <img src='modulos/escolar2/aluno/img/<?=$aluno->id?>.<?=$aluno->extensao?>' height="100" /><br />
                <?
				}
				?>
                </div>
            
            </div>
    <?
                if(strlen($aluno->extensao)>=3){
				?>
                <a href="#" onclick="this.style.display='none'" class='remove_imagem' aluno_id='<?=$aluno->id?>'>Remover</a>
                   <?
				}
				?>
         		</fieldset>
		
      
      <fieldset id="campos_2" style="display:none"> 
      <legend>
      	<a onclick="aba_form(this,0)">Dados dos alunos</a>
    	<a id="filiacao" onclick="aba_form(this,1)"><strong>Filiaçao</strong></a>
    	<a onclick="aba_form(this,2)">Transporte</a>
    	<a onclick="aba_form(this,3)">Emergencia</a>
        <a onclick="aba_form(this,4)">Matricula</a>
        <a onclick="aba_form(this,5)">Observaçao</a>
        <a onclick="aba_form(this,6)">Financeiro</a>
      </legend>
      				
                    <label style="width:250px;">Mae
                    	<input type="text" name="mae" id="mae" value="<?=$aluno->mae?>">                    	
                    </label>
                    
                    <label style="width:95px;"> CPF
                    	<input type="text" id="cpf_mae" name="cpf_mae" sonumero='1' value="<?=$aluno->cpf_mae?>" autocomplete="off" mascara="___.___.___-__"
                       onkeyup="cp=this.value.replace(/\_/g,'' );
            document.title=cp;if(cp.length==14){return  vkt_ac(this,event,'undefined','modulos/escolar/alunos_inscritos/busca_cpf.php',
            '@r0','funcao_bsc(this,\'@r0-value>mae|@r1-value>cpf_mae|@r2-value>telefone_mae|@r3-value>profissao_mae|@r5-value>email_mae\',\'cpf_mae\')')}"/>   
                    </label>
                    
                    <label style="width:95px;"> Telefone
                    	<input type="text" name="telefone_mae" mascara='(__) ____-____' id="telefone_mae" value="<?=$aluno->tel_mae?>">
                    </label>
                    
                    <label> Profissao
                    	<input type="text" name="profissao_mae" id="profissao_mae" value="<?=$aluno->profissao_mae?>">
                    </label><br><br><br>
                    <label> Local de Trabalho
                    	<input type="text" name="local_trabalho_mae" value="<?=$aluno->local_trabalho_mae?>">
                    </label>
                    <label style="width:92px;">Telefone
                    	<input type="text" name="tel_trabalho_mae" sonumero='1' mascara='(__)____-____' id="tel_trabalho_mae" value="<?=$aluno->tel_trabalho_mae?>">
                    </label>
                    <label style="width:203px;">Email
                    	<input type="text" name="email_mae" id="email_mae" retorno='focus|Coloque o email corretamente' value="<?=$aluno->email_mae?>">
                    </label>
                    <!-- -->
                    <label style="width:250px;">Pai
                    	<input type="text" name="pai" id="pai" value="<?=$aluno->pai?>">                    	
                    </label>
                    <label style="width:95px;"> CPF
                    	<input type="text" name="cpf_pai" sonumero='1' mascara='___.___.___-__' id="cpf_pai" value="<?=$aluno->cpf_pai?>" 
                        onkeyup="cp=this.value.replace(/\_/g,'' );
            			document.title=cp;if(cp.length==14){return  vkt_ac(this,event,'undefined','modulos/escolar/alunos_inscritos/busca_cpf.php',
            			'@r0','funcao_bsc(this,\'@r0-value>pai|@r1-value>cpf_pai|@r2-value>telefone_pai|@r3-value>profissao_pai|@r5-value>email_pai\',\'cpf_pai\')')}"/>
                    </label>
                    
                    <label style="width:95px;"> Telefone
                    	<input type="text" name="telefone_pai" mascara='(__)____-____' id="telefone_pai" value="<?=$aluno->tel_pai?>">
                    </label>
                    
                    <label> Profissao
                    	<input type="text" name="profissao_pai" id="profissao_pai" value="<?=$aluno->profissao_pai?>"> 
                    </label>
                    <label> Local de Trabalho
                    	<input type="text" name="local_trabalho_pai" value="<?=$aluno->local_trabalho_pai?>">
                    </label>
                    <label style="width:92px;">Telefone
                    	<input type="text" name="tel_trabalho_pai" sonumero='1' id="tel_trabalho_pai" mascara='(__)____-____' value="<?=$aluno->tel_trabalho_pai?>">
                    </label>
                    <label style="width:203px;">Email
                    	<input type="text" name="email_pai" id="email_pai" retorno='focus|Coloque o email corretamente' value="<?=$aluno->email_pai?>">
                    </label>
      
      </fieldset>
      <!-- -->
      <fieldset id="campos_3" style="display:none"> 
      <legend>
      	<a onclick="aba_form(this,0)">Dados dos alunos</a>
        <a onclick="aba_form(this,1)">Filiaçao</a>
        <a onclick="aba_form(this,2)"><strong>Transporte</strong></a>
        <a onclick="aba_form(this,3)">Emergencia</a>
        <a onclick="aba_form(this,4)">Matricula</a>
        <a onclick="aba_form(this,5)">Observaçao</a>
        <a onclick="aba_form(this,6)">Financeiro</a>
      </legend>
        	<div>Pessoa(as) que virá(ao) trazer e buscar a criança?  (Nome e documento)</div>
            <label style="width:290px;">1.
            	<input type="text" name="pessoa_trazer_buscar_1" id="pessoa_trazer_buscar_1" value="<?=$aluno->pessoa_trazer_buscar_1?>">
            </label>
            <label style="width:290px;">2.
            	<input type="text" name="pessoa_trazer_buscar_2" id="pessoa_trazer_buscar_2" value="<?=$aluno->pessoa_trazer_buscar_2?>">	
            </label><br/><br/><br/>
            <label style="width:290px;">3.
            	<input type="text" name="pessoa_trazer_buscar_3" id="pessoa_trazer_buscar_3" value="<?=$aluno->pessoa_trazer_buscar_3?>">	
            </label>
           <label style="width:290px;">4.
            	<input type="text" name="pessoa_trazer_buscar_4" id="pessoa_trazer_buscar_4" value="<?=$aluno->pessoa_trazer_buscar_4?>">	
            </label>
            <div style="clear:both;"></div>
            <div style="font-size:10px;">Obs: Pessoas nao autorizadas nesta lista nao irao retirar a criança da escola</div>
      
       </fieldset>
      <!-- -->
      <fieldset id="campos_4" style="display:none"> 
      <legend>
    <a onclick="aba_form(this,0)">Dados dos alunos</a>
    <a onclick="aba_form(this,1)">Filiaçao</a>
    <a onclick="aba_form(this,2)">Transporte</a>
    <a onclick="aba_form(this,3)"><strong>Emergencia</strong></a>
    <a onclick="aba_form(this,4)">Matricula</a>
    <a onclick="aba_form(this,5)">Observaçao</a>
    <a onclick="aba_form(this,6)">Financeiro</a>
      </legend>
        	<div>No caso de emergencia ou ocorrencia , chamar por:</div>
            <label style="width:290px;">1.
            	<input type="text" name="pessoa_emergencia_1" id="pessoa_emergencia_1" value="<?=$aluno->pessoa_caso_emergencia_1?>">
            </label>
            <label style="width:290px;">Fones
            	<input type="text" name="fone_emergencia_1" id="fone_emergencia_1" value="<?=$aluno->telefone_caso_emergencia_1?>">	
            </label><br/><br/><br/>
            <label style="width:290px;">2.
            	<input type="text" name="pessoa_emergencia_2" id="pessoa_emergencia_2" value="<?=$aluno->pessoa_caso_emergencia_2?>">	
            </label>
           <label style="width:290px;">Fones
            	<input type="text" name="fone_emergencia_2" id="fone_emergencia_2" value="<?=$aluno->telefone_caso_emergencia_2?>">	
            </label>      
       </fieldset>
       <!-- -->
      <!-- -->
      <fieldset id="campos_5" style="display:none"> 
      <legend>
      <a onclick="aba_form(this,0)">Dados dos alunos</a>
      <a onclick="aba_form(this,1)">Filiaçao</a>
      <a onclick="aba_form(this,2)">Transporte</a>
      <a onclick="aba_form(this,3)">Emergencia</a>
      <a onclick="aba_form(this,4)"><strong>Matricula</strong></a>
      <a onclick="aba_form(this,5)">Observaçao</a>
      <a onclick="aba_form(this,6)">Financeiro</a>
      </legend>
        		<table cellpadding="0" cellspacing="0" style="width:100%" >
        <thead>
            <tr>
                <td style="width:150px;">Unidade</td>
                <td style="width:80px;">Turma</td>
                <td style="width:80px;">Sala</td>
                <td style="width:80px;">Série</td>
                <td style="width:60px;">Situacao</td>
                <td style="width:70px;">Boletim Final</td>
                <td style="width:70px;">Boletim Notas</td>
            </tr>
        </thead>
      <!--</table>
	  <table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">-->
        <tbody> 	
		<?php
		
		$select_matricula_1 = mysql_query($s="SELECT * FROM escolar2_matriculas WHERE aluno_id = '$aluno->id' AND vkt_id='$vkt_id'");
             
			 
			 while($matricula_lista = mysql_fetch_object($select_matricula_1)){ 
			 
			 	$total++;
				if($total%2){$sel='class="al"';}else{$sel='';}
			 
			 	$aluno_matricula = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_alunos WHERE id = '$matricula_lista->aluno_id' ")); 
				$turma_lista = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_turmas WHERE id = '$matricula_lista->turma_id' "));
				$horario = 	mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_horarios WHERE id = '$turma_lista->horario_id' "));
				$sala = 	mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_salas WHERE id = '$turma_lista->sala_id' "));
				$serie = 	mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_series WHERE id = '$turma_lista->serie_id' "));
				$unidade = 	mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_unidades WHERE id = '$turma_lista->unidade_id' "));
				$periodo = 	mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_periodo_letivo WHERE id = '$turma_lista->periodo_letivo_id' "));
				
				$responsavel_lista = mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor WHERE id = '$matricula_lista->responsavel_id' "));
		?>
        <tr <?=$sel?> id="<?=$matricula_lista->id;?>" style="background:#FFF;">
            	
                <td><?=($unidade->nome)." - ".$periodo->nome;?></td>
            	<td><?=($turma_lista->nome);?></td>
            	<td style="width:80px;"><?=utf8_encode($sala->nome);?></td>
                <td style="width:80px;"><?=($serie->nome);?></td>
                
                <td style="width:60px;"><?= $array_situacao[$matricula_lista->situacao];?></td>
            	<td style="width:60px;">
                	
					<?php
                    //if(in_array($matricula_lista->situacao,$array_boletim)){
					?>
                	<!--<a href="#"><strong>Indisponível</strong></a>-->
                    <? //} else { ?>
                    <!--<a href="#"><strong>Imprimir</strong></a>-->
					<?
					//}
					?>
                    <a href="modulos/escolar2/aluno/boletim_escolar.php?aluno_id=<?=$aluno_matricula->id?>" target="_blank"><strong>Imprimir</strong></a>
                </td>
                <td> <a href="modulos/escolar2/aluno/boletim_escolar_notas.php?aluno_id=<?=$aluno_matricula->id?>" target="_blank"><strong>Imprimir</strong></a> </td>
        </tr>
        <tr <?=$sel?> style="display:none;" id="res_<?=$matricula_lista->id;?>">
            	<td style="width:10px;"></td>
                <td colspan="7" style="border-top:1px solid #CCC;"><strong> RESPONSÁVEL: </strong> <?=utf8_encode($responsavel_lista->razao_social);?> | <strong> CNPJ/CPF: </strong> <?=$responsavel_lista->cnpj_cpf;?></td> 	
            	
        </tr>          
		<?php
			  }
        ?>
         </tbody>
       </table>
       </fieldset>
       <!-- -->
      <fieldset id="campos_6" style="display:none"> 
      <legend>
    <a onclick="aba_form(this,0)">Dados dos alunos</a>
    <a onclick="aba_form(this,1)">Filiaçao</a>
    <a onclick="aba_form(this,2)">Transporte</a>
    <a onclick="aba_form(this,3)">Emergencia</a>
    <a onclick="aba_form(this,4)">Matricula</a>
    <a onclick="aba_form(this,5)"><strong>Observaçao</strong></a> 
    <a onclick="aba_form(this,6)">Financeiro</a>
</legend>
      	<label>
      	Observaçao
        <textarea name="observacao" cols="40" rows="20"><?php echo $aluno->observacao?></textarea>
      	</label>
      </fieldset>
      
      <!-- fieldset financeiro -->
      <fieldset id="campos_1" style="display:none"> 
          <legend>
            <a onclick="aba_form(this,0)">Dados dos alunos</a>
            <a onclick="aba_form(this,1)">Filiaçao</a>
            <a onclick="aba_form(this,2)">Transporte</a>
            <a onclick="aba_form(this,3)">Emergencia</a>
            <a onclick="aba_form(this,4)">Matricula</a>
            <a onclick="aba_form(this,5)">Observaçao</a> 
            <a onclick="aba_form(this,6)"><strong>Financeiro</strong></a>
          </legend>
          
          
          <table cellpadding="0" cellspacing="0" style="width:100%" >
        <thead>
            <tr>
                <td style="width:150px;">Descrição</td>
                <td style="width:80px;">Valor</td>
                <td style="width:80px;">Vencimento</td>
                <td style="width:120px;">Responsável</td>
                <td style="width:50px;">Status</td>
                <td style="width:60px;">DOC</td>
            </tr>
        </thead>
      <!--</table>
	  <table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">-->
        <tbody> 	
		<?php
		
             while($matricula = mysql_fetch_object($select_matricula)){ 
			 
			 	$total++;
				if($total%2){$sel='class="al"';}else{$sel='';}
			 
			 	$financeiro = mysql_fetch_object(mysql_query(" SELECT * FROM financeiro_movimento WHERE cliente_id='$vkt_id' AND doc = '$matricula->id' "));
				$responsavel = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE cliente_vekttor_id='$vkt_id' AND id = '$matricula->responsavel_id' "));
				
				if($financeiro->status == 0)
					$status = "Pendente";
				else if($financeiro->status == 1) 
					$status = "Pago";
				else 
					$status = "Cancelado";
		?>
        <tr <?=$sel?> id="<?=$matricula_lista->id;?>" style="background:#FFF;">
            	
                <td><?=utf8_encode($financeiro->descricao);?></td>
            	<td><?=moedaUsaToBr($financeiro->valor_cadastro);?></td>
            	<td style="width:80px;"><?=dataUsaToBr($financeiro->data_vencimento);?></td>
                <td style="width:120px;"><?=($responsavel->razao_social);?></td>
                <td style="width:50px;"><?=$status?></td>
                <td style="width:60px;"><a href="#" onclick="window.open('../sis/modulos/cobranca/mensalidades_escolar/mensalidade_escolar_impressao_massa//tela_impressao_massa.php?filtro_matricula=<?=$matricula->id?>')"> <strong>Imprimir</strong> </a></td>
            	
        </tr>
        <tr <?=$sel?> style="display:none;" id="res_<?=$matricula_lista->id;?>">
            	<td style="width:10px;"></td>
                <td colspan="7" style="border-top:1px solid #CCC;"><strong> RESPONSÁVEL: </strong> <?=utf8_encode($responsavel_lista->razao_social);?> | <strong> CNPJ/CPF: </strong> <?=$responsavel_lista->cnpj_cpf;?></td>
            	
            	
               
                
            	
            	
        </tr>          
		<?php
			  }
        ?>
         </tbody>
       </table> 
          
          
      </fieldset>
   
      
        
        <div style="width:100%; text-align:center" >
        <input type="button" value="Imprimir" onclick="window.open('modulos/escolar2/aluno/impressao_aluno.php?id=<?=$_GET['aluno_id']?>','_BLANK')">
        <?
        if($_GET['aluno_id'] > 0){
        ?>
        <input name="action" type="submit" disabled="disabled" value="Excluir" style="float:left" />
        <?
        }
        ?>
        
        <input name="action" type="submit" disabled="disabled"  value="Salvar" style="float:right"  />
        <div style="clear:both"></div>
        </div>
    </form>
</div>
</div>
</div>
<script>top.openForm()</script>
<? if(strlen($aluno->senha)<1){echo "<script>top.newPass('senha')</script>";} ?>