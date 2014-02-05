<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");

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

		<input  disabled="disabled"  type="hidden" id="aluno_id" name="aluno_id" value="<?=$_GET['aluno_id']; ?>" />

		<fieldset <? if(1==2){ ?> style="display:none"<? }?>>
          <legend>
            <a onclick="aba_form(this,0)"><strong>Dados dos alunos</strong></a>
    		<a onclick="aba_form(this,1)">Filiaçao</a>
    		<a onclick="aba_form(this,2)">Transporte</a>
    		<a onclick="aba_form(this,3)">Emergencia</a>
            <a onclick="aba_form(this,4)">Matricula</a>
            <a onclick="aba_form(this,5)">Observaçao</a>
                  <a onclick="aba_form(this,6)">Consultas</a>

          </legend>
			
            <div style="float:left; width:650px;">
           	
			<label style="width:478px;">
				Nome ss
				<input  disabled="disabled"  type="text" id="nome" name="nome" value="<?=$d->nome; ?>" />
			</label>
            <label style="width:120px;">
				Data de Nascimento
				<input  disabled="disabled"  type="text" id="data_nascimento" name="data_nascimento" mascara="__/__/____" sonumero="1" value="<?=dataUsaToBr($d->data_nascimento); ?>" />
			</label>
            
            
            <div style="clear:both"></div>
             <div>
            	Cor<br/>
                <input  disabled="disabled"  type="radio" name="cor" value="branco" <? if($d->cor == 'branco') echo 'checked="checked"';?>>Branco
                <input  disabled="disabled"  type="radio" name="cor" value="pardo-moreno" <? if($d->cor == 'pardo-moreno') echo $checked = 'checked="checked"';?>>Pardo/Moreno
                <input  disabled="disabled"  type="radio" name="cor" value="negro" <? if($d->cor == 'negro') echo $checked = 'checked="checked"';?>>Negro
                <input  disabled="disabled"  type="radio" name="cor" value="amarelo" <? if($d->cor == 'amarelo') echo $checked = 'checked="checked"'; ?>>Amarelo
                <input  disabled="disabled"  type="radio" name="cor" value="indigena" <? if($d->cor == 'indigena') echo $checked = 'checked="checked"';?>>Indígena
                <input  disabled="disabled"  type="radio" name="cor" value="naodeclarado" <? if($d->cor == 'naodeclarado') echo $checked = 'checked="checked"';?>>N&atilde;o Declarado
             </div><br>
             
            
            <label style="width:220px;">
				Escolaridade
				<input  disabled="disabled"  type="text" id="escolaridade" name="escolaridade" value="<?=$d->escolaridade; ?>" />
			</label>
            <label style="width:220px;">
				Profissão
				<input  disabled="disabled"  type="text" id="profissao" name="profissao"  value="<?=$d->profissao; ?>" />
			</label>
            
            
            <label style="width:340px;">
				Endereço
				<input  disabled="disabled"  type="text" id="endereco" name="endereco" value="<?=$d->endereco; ?>" />
			</label>
            
            <label style="width:120px;">
				Bairro
				<input  disabled="disabled"  type="text" id="bairro" name="bairro" value="<?=$d->bairro; ?>" />
			</label>
            
            <label style="width:120px;">
				Complemento
				<input  disabled="disabled"  type="text" id="complemento" name="complemento" value="<?=$d->complemento; ?>" />
			</label>
            
            <label style="width:120px;">
				Telefone Residencial
				<input  disabled="disabled"  type="text" id="telefone1" name="telefone1" mascara='(__)____-____' value="<?=$d->telefone1; ?>" />
			</label>
            
            <label style="width:120px;">
				Telefone Celular
				<input  disabled="disabled"  type="text" id="telefone2" name="telefone2" mascara='(__)____-____' value="<?=$d->telefone2; ?>" />
			</label>
            
            <label style="width:100px;">
				CEP
				<input  disabled="disabled"  type="text" id="cep" name="cep" mascara='__.___-___' sonumero='1' value="<?=$d->cep; ?>" />
			</label>
			
            <label style="width:150px;">
				Cidade
				<input  disabled="disabled"  type="text" id="cidade" name="cidade" value="<?=$d->cidade; ?>" />
			</label>
            
            <label style="width:50px;">
				UF
				<input  disabled="disabled"  type="text" id="uf" name="uf" value="<?=$d->uf; ?>" />
			</label>
            
            <label style="width:120px;">
				RG
				<input  disabled="disabled"  type="text" id="rg" name="rg" sonumero='1' value="<?=$d->rg; ?>" />
			</label>
            
            <label style="width:120px;">
				Data Expedição
				<input  disabled="disabled"  type="text" id="rg_dt_expedicao" name="rg_dt_expedicao" mascara='__/__/____' value="<?=dataUsaToBr($d->rg_dt_expedicao); ?>" />
			</label>
            
            <label style="width:120px;">
				CPF
				<input  disabled="disabled"  type="text" id="cpf" name="cpf" value="<?=$d->cpf; ?>" mascara='___.___.___-__' />
			</label>
            
            <label style="width:202px;">
				E-Mail
				<input  disabled="disabled"  type="text" id="email" name="email" retorno='focus|Coloque o email corretamente' value="<?=$d->email; ?>" />
			</label>
            
           <!-- <label style="width:280px;">Turma
            	<input  disabled="disabled"  type="text" name="turma" id="turma" value="<?$d->turma?>">
            </label>
            
            <label style="width:280px;">Turno
            	<input  disabled="disabled"  type="text" name="turno" id="turno" value="<?$d->turno?>">
            </label>
            <label>-->
            
            	<input  disabled="disabled"  type="hidden" name="responsavel_id" id="responsavel_id" value="<?=$responsavel->id?>">
            </label>
            <label style="width:280px;"> Responsável
            	<input  disabled="disabled"  type="text" name="responsavel" id="responsavel" busca='modulos/escolar/alunos_inscritos/busca_clientes.php,@r0 @r2,@r1-value>responsavel_id,0' autocomplete='off' value="<?=$responsavel->nome_fantasia?>">
            </label>
            <label>Código Interno<br/>
            	<input  disabled="disabled"  type="text" name="codigo_interno" id="codigo_interno" style="width:90px;" value="<?=$d->codigo_interno;?>">
            </label>
            <label style="width:60px;">Cod.Aluno: <?=$d->id?>
            </label>
            <label style="width:60px;">Senha
            	<input  disabled="disabled"  type="text" name="senha" id="senha" value="<?=$d->senha?>" />
            </label>
                  <label  style="width:100px">
            Tipo de Aluno <br />
            <?
			
			$bolsista = mf(mq("
			SELECT * FROM escolar_alunos_bolsistas WHERE aluno_id = '$d->id'
			"));
            if($bolsista->aluno_id>0){
				echo "<strong>Bolsista</strong>";	
			}else{
				echo "<strong>Integral</strong>";	
			}
			?>
			</label>
            <label><? if($cliente_id==13){ ?> Universidades/Áreas <?   }else{ ?>  Restriçao Alimentar / Alergia <?  } ?>
            	<input  disabled="disabled"  type="text" name="restricao_alimentar" id="restricao_alimentar" size="55" value="<?=$d->restricao_alimentar?>">
            </label>
                  

            <div style="clear:both;"></div>
            <label>
            		<input  disabled="disabled"  type="file" name="file[]" >
            </label>
            
            </div>
            <div style="width:120px;float:left; height:160px;border:1px solid #999; background:#FFF; overflow:hidden">
            
            		<div style="clear:both; padding:2px;" id='img_curso' >
                <?
                if(strlen($d->extensao)>=3){
				?>
                <img src='modulos/escolar/alunos_inscritos/img/<?=$d->id?>.<?=$d->extensao?>' height="100" /><br />
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
         <a onclick="aba_form(this,6)">Consultas</a>
      </legend>
      				
                    <label style="width:280px;">Mae
                    	<input  disabled="disabled"  type="text" name="mae" id="mae" value="<?=$d->mae?>">                    	
                    </label>
                    
                    <label style="width:95px;"> CPF
                    	<input  disabled="disabled"  type="text" id="cpf_mae" name="cpf_mae" sonumero='1' value="<?=$d->cpf_mae?>" autocomplete="off" mascara="___.___.___-__"
                       onkeyup="cp=this.value.replace(/\_/g,'' );
            document.title=cp;if(cp.length==14){return  vkt_ac(this,event,'undefined','modulos/escolar/alunos_inscritos/busca_cpf.php',
            '@r0','funcao_bsc(this,\'@r0-value>mae|@r1-value>cpf_mae|@r2-value>telefone_mae|@r3-value>profissao_mae|@r5-value>email_mae\',\'cpf_mae\')')}"/>   
                    </label>
                    
                    <label style="width:95px;"> Telefone
                    	<input  disabled="disabled"  type="text" name="telefone_mae" mascara='(__) ____-____' id="telefone_mae" value="<?=$d->tel_mae?>">
                    </label>
                    
                    <label> Profissao
                    	<input  disabled="disabled"  type="text" name="profissao_mae" id="profissao_mae" value="<?=$d->profissao_mae?>">
                    </label><br><br><br>
                    <label> Local de Trabalho
                    	<input  disabled="disabled"  type="text" name="local_trabalho_mae" value="<?=$d->local_trabalho_mae?>">
                    </label>
                    <label style="width:92px;">Telefone
                    	<input  disabled="disabled"  type="text" name="tel_trabalho_mae" sonumero='1' mascara='(__)____-____' id="tel_trabalho_mae" value="<?=$d->tel_trabalho_mae?>">
                    </label>
                    <label style="width:203px;">Email
                    	<input  disabled="disabled"  type="text" name="email_mae" id="email_mae" retorno='focus|Coloque o email corretamente' value="<?=$d->email_mae?>">
                    </label>
                    <!-- -->
                    <label style="width:280px;">Pai
                    	<input  disabled="disabled"  type="text" name="pai" id="pai" value="<?=$d->pai?>">                    	
                    </label>
                    <label style="width:95px;"> CPF
                    	<input  disabled="disabled"  type="text" name="cpf_pai" sonumero='1' mascara='___.___.___-__' id="cpf_pai" value="<?=$d->cpf_pai?>" 
                        onkeyup="cp=this.value.replace(/\_/g,'' );
            			document.title=cp;if(cp.length==14){return  vkt_ac(this,event,'undefined','modulos/escolar/alunos_inscritos/busca_cpf.php',
            			'@r0','funcao_bsc(this,\'@r0-value>pai|@r1-value>cpf_pai|@r2-value>telefone_pai|@r3-value>profissao_pai|@r5-value>email_pai\',\'cpf_pai\')')}"/>
                    </label>
                    
                    <label style="width:95px;"> Telefone
                    	<input  disabled="disabled"  type="text" name="telefone_pai" mascara='(__)____-____' id="telefone_pai" value="<?=$d->tel_pai?>">
                    </label>
                    
                    <label> Profissao
                    	<input  disabled="disabled"  type="text" name="profissao_pai" id="profissao_pai" value="<?=$d->profissao_pai?>"> 
                    </label>
                    <label> Local de Trabalho
                    	<input  disabled="disabled"  type="text" name="local_trabalho_pai" value="<?=$d->local_trabalho_pai?>">
                    </label>
                    <label style="width:92px;">Telefone
                    	<input  disabled="disabled"  type="text" name="tel_trabalho_pai" sonumero='1' id="tel_trabalho_pai" mascara='(__)____-____' value="<?=$d->tel_trabalho_pai?>">
                    </label>
                    <label style="width:203px;">Email
                    	<input  disabled="disabled"  type="text" name="email_pai" id="email_pai" retorno='focus|Coloque o email corretamente' value="<?=$d->email_pai?>">
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
     <a onclick="aba_form(this,6)">Consultas</a>
      </legend>
        	<div>Pessoa(as) que virá(ao) trazer e buscar a criança?  (Nome e documento)</div>
            <label style="width:290px;">1.
            	<input  disabled="disabled"  type="text" name="pessoa_trazer_buscar_1" id="pessoa_trazer_buscar_1" value="<?=$d->pessoa_trazer_buscar_1?>">
            </label>
            <label style="width:290px;">2.
            	<input  disabled="disabled"  type="text" name="pessoa_trazer_buscar_2" id="pessoa_trazer_buscar_2" value="<?=$d->pessoa_trazer_buscar_2?>">	
            </label><br/><br/><br/>
            <label style="width:290px;">3.
            	<input  disabled="disabled"  type="text" name="pessoa_trazer_buscar_3" id="pessoa_trazer_buscar_3" value="<?=$d->pessoa_trazer_buscar_3?>">	
            </label>
           <label style="width:290px;">4.
            	<input  disabled="disabled"  type="text" name="pessoa_trazer_buscar_4" id="pessoa_trazer_buscar_4" value="<?=$d->pessoa_trazer_buscar_4?>">	
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
     <a onclick="aba_form(this,6)">Consultas</a>
      </legend>
        	<div>No caso de emergencia ou ocorrencia , chamar por:</div>
            <label style="width:290px;">1.
            	<input  disabled="disabled"  type="text" name="pessoa_emergencia_1" id="pessoa_emergencia_1" value="<?=$d->pessoa_caso_emergencia_1?>">
            </label>
            <label style="width:290px;">Fones
            	<input  disabled="disabled"  type="text" name="fone_emergencia_1" id="fone_emergencia_1" value="<?=$d->telefone_caso_emergencia_1?>">	
            </label><br/><br/><br/>
            <label style="width:290px;">2.
            	<input  disabled="disabled"  type="text" name="pessoa_emergencia_2" id="pessoa_emergencia_2" value="<?=$d->pessoa_caso_emergencia_2?>">	
            </label>
           <label style="width:290px;">Fones
            	<input  disabled="disabled"  type="text" name="fone_emergencia_2" id="fone_emergencia_2" value="<?=$d->telefone_caso_emergencia_2?>">	
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
      <a onclick="aba_form(this,4)"><strong>Matriculas</strong></a>
      <a onclick="aba_form(this,5)">Observaçao</a>
      <a onclick="aba_form(this,6)">Consultas</a>
      </legend>
      <label style="width:280px;">Escola<br>
            	<strong>2013 - Nossa Senhora do Carmo</strong><br>
            </label>
            <label  style="width:40px;">
            	Sala<br/>
                <strong>1</strong>
            </label>
            <label style="width:40px;">
            	S&eacute;rie<br>
                <strong>4</strong>&ordm;<br/>
            </label>
            <label style="width:120px">
            	Situaçao do Curso<br/>
                <strong>Em Curso</strong>
            </label>
                      <label><br />
<strong  > <a href="modulos/escolare/aluno/botetim_escolar.html"  target="_blank">Impressão de Boletim Parcial</a></strong></label>

          <div style="clear:both;"></div>
      <label style="width:280px;"><strong>2012 - Nossa Senhora do Carmo</strong><br>
          </label>
            <label  style="width:40px;"><strong>3</strong>
            </label>
            <label  style="width:40px;"><strong>3</strong>&ordm;<br/>
          </label>
          <label   style="width:120px"><strong>Aprovado</strong>(a)</label>
          <label><strong><a href="modulos/escolare/aluno/botetim_escolar.html"  target="_blank">Impressão de Boletim</a></strong></label>

          <div style="clear:both;"></div>
      <label style="width:280px;"><strong>2011 - Escola Municipal João Beckenbauer</strong><br>
          </label>
            <label  style="width:40px;"><strong>1</strong>
          </label>
          <label  style="width:40px;"><strong>2</strong>&ordm;<br/>
            </label>
            <label  style="width:120px"><strong>Aprovado</strong> (a)</label>
            <label><strong><a href="modulos/escolare/aluno/botetim_escolar.html" target="_blank">Impressão de Boletim</a></strong></label>

          <div style="clear:both;"></div>
      <label style="width:280px;"><strong>2010 - Nossa Senhora do Carmo</strong><br>
          </label>
            <label  style="width:40px;"><strong>1</strong>
          </label>
          <label  style="width:40px;"><strong>1</strong>&ordm;<br/>
            </label>
            <label  style="width:120px"><strong>Aprovado</strong> (a)</label>
                      <label><strong><a href="modulos/escolare/aluno/botetim_escolar.html" target="_blank">Impressão de Boletim</a></strong></label>

          <div style="clear:both;"></div>
            <!--<label>Cursos
            	<input  disabled="disabled"  type="text" name="escola" id="escola" disabled="disabled">
            </label>
            <label>Modulos
            	<input  disabled="disabled"  type="text" name="modulo" id="modulo">
            </label>
            <label>Horarios
            	<input  disabled="disabled"  type="text" name="horarios" id="horarios">
            </label>
            <label>Salas
            	<input  disabled="disabled"  type="text" name="horarios" id="horarios">
            </label>
            <label>Data Vencimento
            	<input  disabled="disabled"  type="text" name="horarios" id="horarios">
            </label>
            <label>Data Pagamento
            	<input  disabled="disabled"  type="text" name="horarios" id="horarios">
            </label>
             <label>Situa&ccedil;ao Curso
            	<input  disabled="disabled"  type="text" name="horarios" id="horarios">
            </label>
            <label>
            	Situa&ccedil;&atilde;o Pagemento
                	<input  disabled="disabled"  type="text" name="pago">
            </label>
            <label>
            	Situa&ccedil;&atilde;o Matricula
                	<input  disabled="disabled"  type="text" name="pago">
            </label>
            <label>
            	Situa&ccedil;&atilde;o Matricula
                	<input  disabled="disabled"  type="text" name="pago">
            </label>-->
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
     <a onclick="aba_form(this,6)">Consultas</a>
      </legend>
      	<label>
      	Observaçao
        <textarea name="observacao" cols="40" rows="20"><?php echo $d->observacao?></textarea>
      	</label>
      </fieldset>
      <fieldset id="campos_7" style="display:none"> 
      <legend>
    <a onclick="aba_form(this,0)">Dados dos alunos</a>
    <a onclick="aba_form(this,1)">Filiaçao</a>
    <a onclick="aba_form(this,2)">Transporte</a>
    <a onclick="aba_form(this,3)">Emergencia</a>
    <a onclick="aba_form(this,4)">Matricula</a>
    <a onclick="aba_form(this,5)">Observaçao</a>
     <a onclick="aba_form(this,6)"><strong>Consultas</strong></a>
      </legend>
      	<div style="height:400px">
        
        <br />
        <a href="modulos/escolare/aluno/botetim_escolar.html" target="_blank">        <strong>Impressão de Historico Escolar</strong></a><br />
        <strong><br />
        <a href="modulos/escolare/aluno/botetim_escolar.html" target="_blank">Impressão de Certificado</a></strong> </div>
        
        
        
      </fieldset>
      
   
      
        
        <div style="width:100%; text-align:center" >
        <input type="button" value="Imprimir" onclick="window.open('modulos/escolare/alunos_inscritos/impressao_aluno.php?id=<?=$_GET['aluno_id']?>','_BLANK')">
        <div style="clear:both"></div>
        </div>
    </form>
</div>
</div>
</div>
<script>top.openForm()</script>
<? if(strlen($d->senha)<1){echo "<script>top.newPass('senha')</script>";} ?>