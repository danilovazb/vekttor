<?
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo interesses
include("_functions.php");
// funções do modulo interesses
include("_ctrl.php"); 

?><link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />

<div id='aSerCarregado'>
<div style="width:600px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Interesses</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post" autocomplete="off">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' style="display:" >
		<legend>
		<a onclick="aba_form(this,0); document.getElementById('tipo_cadastro').value='Jurídico';"><strong>Informações</strong></a>
				<a onclick="aba_form(this,1); document.getElementById('tipo_cadastro').value='Físico';">Agenda</a>
		</legend>
		<label style="width:250px;">
			Nome 
			<input type="text" id='nome' name="nome" valida_minlength='5'  value="<?=$r->nome?>" maxlength="255"/>
		</label>
        <label style="width:70px;">
			CEP 
			<input type="text" id='cep' name="cep"  value="<?=$r->CEP?>" maxlength="255" autocomplete="off" busca='modulos/corretor/interesses/busca_endereco.php,@r0,@r0-value>cep|@r1-value>endereco|@r2-value>bairro|@r3-value>cidade|@r4-value>estado,0'/>
		</label>
         <label style="width:40px;">
			Estado 
			<input type="text" id='estado' name="estado"  value="<?=$r->estado?>"/>
		</label>
            <label style="width:100px;">
			Cidade 
			<input type="text" id='cidade' name="cidade"  value="<?=$r->cidade?>"/>
		</label>
         <label style="width:80px;">
			Bairro 
		 <input type="text" id='bairro' name="bairro"  value="<?=$r->bairro?>"/>
		</label>
        <label style="width:200px;">
			Endereço 
			<input type="text" id='endereco' name="endereco" valida_minlength='5'  value="<?=$r->endereco?>" maxlength="255"/>
		</label>         
        <label style="width:40px;">
			Número
			<input type="text" id='numero' name="numero"  value="<?=$r->numero?>" maxlength="255"/>
		</label>
      
		<label style="width:140px;">
			Complemento 
			<input type="text" id='complemento' name="complemento" valida_minlength='5'  value="<?=$r->complemento?>" maxlength="255"/>
		</label>
        <label style="width:85px;">
			Tel Residencial
			<input type="text" id='telefone_residencial' name="telefone_residencial"  value="<?=$r->telefone_residencial?>" mascara='(__)____-____' sonumero='1'/>
		</label>
        <label style="width:120px;">
			Tel Comercial/Celular
			<input type="text" id='telefone_comercial' name="telefone_comercial"  value="<?=$r->telefone_comercial?>" mascara='(__)____-____' sonumero='1'/>
		</label>
		<label style="width:150px;">
			Email 
			<input type="text" id='email' name="email" value="<?=$r->email?>" maxlength="255"/>
		</label>
		<label style="width:109px;">
			Faixa Etária
			<select name="faixa_idade">
            	<option value='Menos de 20' <? if($r->faixa_etaria=='Menos de 20'){echo 'selected=selected';}?>>Menos de 20</option>
            	<option value='20 a 25' <? if($r->faixa_idade=='20 a 25'){echo 'selected=selected';}?>>20 a 25</option>
                <option value='26 a 30' <? if($r->faixa_idade=='26 a 30'){echo 'selected=selected';}?>>26 a 30</option>
                <option value='31 a 35' <? if($r->faixa_idade=='31 a 35'){echo 'selected=selected';}?>>31 a 35</option>
            	<option value='36 a 40' <? if($r->faixa_idade=='36 a 40'){echo 'selected=selected';}?>>36 a 40</option>
                <option value='41 a 45' <? if($r->faixa_idade=='41 a 45'){echo 'selected=selected';}?>>41 a 45</option>
            	<option value='46 a 50' <? if($r->faixa_idade=='46 a 50'){echo 'selected=selected';}?>>46 a 50</option>
            	<option value='51 a 55' <? if($r->faixa_idade=='51 a 55'){echo 'selected=selected';}?>>51 a 55</option>
                <option value='56 a 60' <? if($r->faixa_idade=='56 a 60'){echo 'selected=selected';}?>>56 a 60</option>
                <option value='Acima de 60' <? if($r->faixa_idade=='Acima de 60'){echo 'selected=selected';}?>>Acima de 60</option>
            </select>
		</label>
            <label style="width:80px;">
			Estado Civil
			<select name="estado_civil">
            	<option value='solteiro' <? if($r->estado_civil=='solteiro'){echo 'selected=selected';}?>>Solteiro</option>
            	<option value='noivo' <? if($r->estado_civil=='noivo'){echo 'selected=selected';}?>>Noivo</option>
                <option value='uniao estavel' <? if($r->estado_civil=='uniao estavel'){echo 'selected=selected';}?>>Uniao Estavel</option>
                <option value='casado' <? if($r->estado_civil=='casado'){echo 'selected=selected';}?>>Casado</option>
            	<option value='divorciado' <? if($r->estado_civil=='divorciado'){echo 'selected=selected';}?>>Divorciado</option>
                <option value='viuvo' <? if($r->estado_civil=='41 a 45'){echo 'selected=selected';}?>>Viuvo</option>
            </select>
		</label>
        <label style="width:30px;">
			Filhos
			<input type="text" name="filhos" value="<? if(empty($r->filhos)){echo 0;}else{echo $r->filhos;} ?>">
		</label>
        <label style="width:90px;">
			Sexo
			<select name="sexo">
            	<option value='masculino' <? if($r->sexo=='masculino'){echo 'selected=selected';}?>>Masculino</option>
            	<option value='feminino' <? if($r->propaganda=='feminino'){echo 'selected=selected';}?>>Feminino</option>
            </select>
		</label>
        <label style="width:120px;">
			Grau de Instruçao
			<select name="grau_instrucao">
            	<option value='Nao Alfabetizado' <? if($r->grau_instrucao=='Nao Alfabetizado'){echo 'selected=selected';}?>>Nao Alfabetizado</option>
            	<option value='Ensino Fundamental' <? if($r->grau_instrucao=='Ensino Fundamental'){echo 'selected=selected';}?>>Ensino Fundamental</option>
                <option value='Ensino Médio' <? if($r->grau_instrucao=='Ensino Médio'){echo 'selected=selected';}?>>Ensino Médio</option>
                <option value='Superior' <? if($r->grau_instrucao=='Superior'){echo 'selected=selected';}?>>Superior</option>
                <option value='Especializaçoes' <? if($r->grau_instrucao=='Especializações'){echo 'selected=selected';}?>>Especializaçoes</option>
            </select>
		</label>
        <label style="width:120px;">
			Renda Familiar
			<select name="renda_familiar">
            	<option value='1500' <? if($r->renda_familiar=='1500'){echo 'selected=selected';}?>>Até R$ 1.500,00</option>
            	<option value='1500-2000' <? if($r->renda_familiar=='1500-2000'){echo 'selected=selected';}?>>R$ 1.500,00 a R$ 2.000,00</option>
       			<option value='2001-3000' <? if($r->renda_familiar=='2001-3000'){echo 'selected=selected';}?>>R$ 2.001,00 a R$ 3.000,00</option>
            	<option value='3001-4000' <? if($r->renda_familiar=='3001-4000'){echo 'selected=selected';}?>>R$ 3.001,00 a R$ 4.000,00</option>
				<option value='4001-5000' <? if($r->renda_familiar=='4001-5000'){echo 'selected=selected';}?>>R$ 4.001,00 a R$ 5.000,00</option>
            	<option value='5001-6000' <? if($r->renda_familiar=='5001-6000'){echo 'selected=selected';}?>>R$ 5.001,00 a R$ 6.000,00</option>
                <option value='6001-7000' <? if($r->renda_familiar=='6001-7000'){echo 'selected=selected';}?>>R$ 6.001,00 a R$ 7.000,00</option>
            	<option value='7001-8000' <? if($r->renda_familiar=='3001-4000'){echo 'selected=selected';}?>>R$ 7.001,00 a R$ 8.000,00</option>
				<option value='9001-10000' <? if($r->renda_familiar=='9001-10000'){echo 'selected=selected';}?>>R$ 9.001,00 a R$ 10.000,00</option>
            	<option value='10000' <? if($r->renda_familiar=='10000'){echo 'selected=selected';}?>>Acima de R$ 10.000,00</option>
            </select>
         </label>
        
        <label style="width:75px;">
			Computador
			<select name="computador">
            	<option value="sim" <? if($r->computador=='sim'){echo 'selected=selected';}?>>SIM</option>
                <option value="nao" <? if($r->computador=='nao'){echo 'selected=selected';}?>>NAO</option>
            </select>
		</label>
        <label style="width:60px;">
			Internet
			<select name="internet">
            	<option value="sim" <? if($r->internet=='sim'){echo 'selected=selected';}?>>SIM</option>
                <option value="nao" <? if($r->internet=='nao'){echo 'selected=selected';}?>>NAO</option>
            </select>
		</label>
        <label style="width:100px;">
			Acesso ao Site NV
			<select name="site_nv">
            	<option value="sim" <? if($r->site_nv=='sim'){echo 'selected=selected';}?>>SIM</option>
                <option value="nao" <? if($r->site_nv=='nao'){echo 'selected=selected';}?>>NAO</option>
            </select>
		</label>
        <label style="width:80px;">
			Residencia
			<select name="residencia">
            	<option value="Propria" <? if($r->residencia=='Propria'){echo 'selected=selected';}?>>Propria</option>
                <option value="Alugada" <? if($r->residencia=='Alugada'){echo 'selected=selected';}?>>Alugada</option>
                <option value="Pais/Parentes" <? if($r->residencia=='Pais/Parentes'){echo 'selected=selected';}?>>Pais/Parentes</option>
            	<option value="outro" <? if($r->residencia=='outro'){echo 'selected=selected';}?>>Outro</option>
            </select>
		</label>
         <label style="width:50px;">
			Quartos
			<select name="qtd_quartos">
            	<option value="1" <? if($r->qtd_quartos=='1'){echo 'selected=selected';}?>>1</option>
                <option value="2" <? if($r->qtd_quartos=='2'){echo 'selected=selected';}?>>2</option>
                <option value="3" <? if($r->qtd_quartos=='3'){echo 'selected=selected';}?>>3</option>
            </select>
		</label>
         <label style="width:120px;">
			Finalidade da compra
			<select name="finalidade_compra">
            	<option value="uso proprio" <? if($r->finalidade_compra=='uso proprio'){echo 'selected=selected';}?>>Uso Proprio</option>
                <option value="investimento" <? if($r->finalidade_compra=='investimento'){echo 'selected=selected';}?>>Investimento</option>
            </select>
		</label>
        <label style="width:120px;">
			Faixa de preços
			<select name="faixa_interesse">
            	<option value="100000" <? if($r->faixa_interesse=='100000'){echo 'selected=selected';}?>>Até R$100.000</option>
                <option value="100001 a 150000" <? if($r->faixa_interesse=='100001 a 150000'){echo 'selected=selected';}?>>De R$100.001 a R$ 150.000</option>
                <option value="150001 a 200000" <? if($r->faixa_interesse=='150001 a 200000'){echo 'selected=selected';}?>>De R$150.001 a R$ 200.000</option>
                <option value="200001 a 250000" <? if($r->faixa_interesse=='200001 a 250000'){echo 'selected=selected';}?>>De R$200.001 a R$ 250.000</option>
                <option value="250001 a 300000" <? if($r->faixa_interesse=='250001 a 300000'){echo 'selected=selected';}?>>De R$250.001 a R$ 300.000</option>
                <option value="Acima de 300000" <? if($r->faixa_interesse=='Acima de 300000'){echo 'selected=selected';}?>>Acima de R$ 300.000</option>
            </select>
		</label>
       <div style="clear:both"></div>
       <label style="width:140px;">
			Característica do Imóvel
			<select name="caracteristica_imovel" onchange="exibeCampo(this,outra_caracteristica)">
            	<option value="Banheiro de Empregada" <? if($r->caracteristica_imovel=='Banheiro de Empregada'){echo 'selected=selected';}?>>Banheiro de Empregada</option>
                <option value="Despensa" <? if($r->caracteristica_imovel=='Despensa'){echo 'selected=selected';}?>>Despensa</option>
                <option value="Forma de Pagamento" <? if($r->caracteristica_imovel=='Forma de Pagamento'){echo 'selected=selected';}?>>Forma de Pagamento</option>
                <option value="Lazer Completo" <? if($r->caracteristica_imovel=='Lazer Completo'){echo 'selected=selected';}?>>Lazer Completo</option>
                <option value="Localizaçao" <? if($r->caracteristica_imovel=='Localizaçao'){echo 'selected=selected';}?>>Localizaçao</option>
                <option value="Prazo de Entrega" <? if($r->caracteristica_imovel=='Prazo de Entrega'){echo 'selected=selected';}?>>Prazo de Entrega</option>
                <option value="Qualidade de Acabamento" <? if($r->caracteristica_imovel=='Qualidade de Acabamento'){echo 'selected=selected';}?>>Forma de Pagamento</option>
                <option value="Solidez na Construtora" <? if($r->caracteristica_imovel=='Solidez na Construtora'){echo 'selected=selected';}?>>Solidez na Construtora</option>
                <option value="Vaga de Garagem" <? if($r->caracteristica_imovel=='Vaga de Garagem'){echo 'selected=selected';}?>>Vaga de Garagem</option>
                <option value="Área Contruível" <? if($r->caracteristica_imovel=='Área Contruível'){echo 'selected=selected';}?>>Área Contruível</option>
                <option value="outro" <? if($r->caracteristica_imovel=='outro'){echo 'selected=selected';}?>>Outra</option>
            </select>
       </label>
           <label style="width:100px;">
			Propaganda
			<select name="propaganda" onchange="exibeCampo(this,outra_propaganda)">
            	<option value='bandeira' <? if($r->propaganda=='bandeira'){echo 'selected=selected';}?>>Bandeira</option>
            	<option value='carreata' <? if($r->propaganda=='carreata'){echo 'selected=selected';}?>>Carreata</option>
                <option value='panfleto' <? if($r->propaganda=='panfleto'){echo 'selected=selected';}?>>Panfleto</option>
                <option value='email' <? if($r->propaganda=='email'){echo 'selected=selected';}?>>E-mail</option>
            	<option value='cavalete' <? if($r->propaganda=='cavalete'){echo 'selected=selected';}?>>Cavalete</option>
                <option value='jornal' <? if($r->propaganda=='jornal'){echo 'selected=selected';}?>>Jornal</option>
            	<option value='mala' <? if($r->propaganda=='mala'){echo 'selected=selected';}?>>Mala Direta</option>
            	<option value='consultor' <? if($r->propaganda=='consultor'){echo 'selected=selected';}?>>Consultor</option>
                <option value='stand' <? if($r->propaganda=='stand'){echo 'selected=selected';}?>>Stand</option>
                <option value='shopping' <? if($r->propaganda=='shopping'){echo 'selected=selected';}?>>Shopping</option>
            	<option value='indicacao' <? if($r->propaganda=='indicacao'){echo 'selected=selected';}?>>Indicacao</option>
                <option value='tdoor' <? if($r->propaganda=='outdoor'){echo 'selected=selected';}?>>Outdoor</option>
                <option value='carro' <? if($r->propaganda=='carro'){echo 'selected=selected';}?>>Carro</option>
                <option value='internet' <? if($r->propaganda=='internet'){echo 'selected=selected';}?>>Internet</option>
            	<option value='tv' <? if($r->propaganda=='tv'){echo 'selected=selected';}?>>TV</option>
                <option value='outro' <? if($r->propaganda=='outro'){echo 'selected=selected';}?>>Outro</option>
            </select>
		</label>
        <label style="width:120px;">
			Fechou Negócio?
			<select name="fecha_negocio" onchange="exibeCampo(this,outro_negocio)">
            	<option value="Fechou Negocio" <? if($r->fecha_negocio=='Fechou Negocio'){echo 'selected=selected';}?>>Fechou Negocio, Comprou</option>
                <option value="Nao encontrou" <? if($r->fecha_negocio=='Nao encontrou'){echo 'selected=selected';}?>>Nao encontrou o que procurava</option>
                <option value="Condicoes Pagamento" <? if($r->fecha_negocio=='Condicoes Pagamento'){echo 'selected=selected';}?>>Condiçoes de Pagamento</option>
                <option value="Continua Procurando" <? if($r->fecha_negocio=='Continua Procurando'){echo 'selected=selected';}?>>Continua Procurando</option>
                <option value="outro" <? if($r->fecha_negocio=='outro'){echo 'selected=selected';}?>>Outra</option>
            </select>
       </label>
        <label style="width:90px;">
			Outras Regioes
			<select name="interesse_regioes" onchange="exibeCampo(this,outra_regiao)">
            	<option value="nao" <? if($r->interesse_regioes=='nao'){echo 'selected=selected';$display='none';}?>>NAO</option>
            	<option value="outro" <? if($r->interesse_regioes=='outro'){echo 'selected=selected';$display='block';}?>>SIM</option>
            </select>
		</label>
       <label style="width:150px;" onchange="exibeCampo(this,outra_caracteristica)">
       <? if($r->caracteristica_imovel=='outro'){$display='block';}else{$display='none';}?>
        <br>
        <input type="text" name="outra_caracteristica" id="outra_caracteristica" value="<?=$r->outra_caracteristica?>" style="display:<?=$display?>;"/>
        </label>
             <label style="width:100px;">
        <br>
        <? if($r->propaganda=='outro'){$display='block';}else{$display='none';}?>
        <input type="text" name="outra_propaganda" id="outra_propaganda" value="<?=$r->outra_propaganda?>" style="display:<?=$display;?>;"/>
        </label>
      <label style="width:100px;">
        <br>
        <? if($r->fecha_negocio=='outro'){$display='block';}else{$display='none';}?>
        <input type="text" name="outro_negocio" id="outro_negocio" value="<?=$r->outro_negocio?>" style="display:<?=$display;?>;"/>
        </label>
          <label style="width:100px;">
        <br>
        <input type="text" name="outra_regiao" id="outra_regiao" value="<?=$r->outra_regiao?>" style="display:<?=$display?>"/>
        </label>
        <div style="clear:both"></div>
        <label style="width:140px;">
			Avaliaçao Atendimento
			<select name="avaliacao_atendimento">
            	<option value="otimo" <? if($r->avaliacao_atendimento=='otimo'){echo 'selected=selected';}?>>Otimo</option>
                <option value="bom" <? if($r->avaliacao_atendimento=='bom'){echo 'selected=selected';}?>>Bom</option>
                <option value="regular" <? if($r->avaliacao_atendimento=='regular'){echo 'selected=selected';}?>>Regular</option>
                <option value="Ruim" <? if($r->avaliacao_atendimento=='ruim'){echo 'selected=selected';}?>>Ruim</option>
            </select>
       </label>
        <label style="width:515px;">
			Observaçao
			<textarea name="observacoes" id="observacoes"><?=$r->observacoes?></textarea>
		</label>
		<input name="id" type="hidden" value="<?=$r->id?>" />
	</fieldset>
	
	<fieldset  id='campos_1' style="display:none" >
		<legend>
		<a onclick="aba_form(this,0); document.getElementById('tipo_cadastro').value='Jurídico';">Informações</a>
				<a onclick="aba_form(this,1); document.getElementById('tipo_cadastro').value='Físico';"><strong>Agenda</strong></a>
		</legend>
		<label style="width:170px;">
			Data da Próxima Interação 
			<?
			$data=mysql_fetch_object(mysql_query("SELECT data,hora FROM interesse_interacao WHERE interesse_id='".$r->id."' AND status='0' ORDER BY id DESC"));
			?>
			<input name="data" id='data' type="text" value="<?=dataUsaToBr($data->data)?>" maxlength="23" calendario='1' sonumero='1' mascara='__/__/____' retorno='focus|Data Simples' />
		</label>
		<label style="width:170px;">
			Hora
			<?
			$hora=explode(":",$r->hora);
			?>
			<input name="hora" id='hora' type="text" value="<?=$hora[0].":".$hora[1].":".$hora[2]?>" maxlength="5" sonumero='1' mascara='__:__:__' />
		</label>
		<label>
        	<input name="interacao_status" style=" width:auto" type="checkbox" value="<? if(!empty($r->interacao)){echo $r->interacao;}else{ echo '0';} ?>" <? if($r->interacao==1){echo "checked=\"checked\"";} ?> 
            onclick="if(interacao_status.value==1){interacao_status.value=0}else{interacao_status.value=1}">
            Interação já Realizada.
        </label>
		
		<div class="divisao_options" style="margin-top:10px;">
			<?
			$interacoes=mysql_fetch_object(mysql_query("SELECT COUNT(*) as total FROM interesse_interacao WHERE interesse_id='".$r->id."' AND status='1' ORDER BY id DESC"));
			?>
			<span class="titulo_options"><b>Interações Realizadas(<?=$interacoes->total?>): </b>
			<?
			$in=mysql_query("SELECT * FROM interesse_interacao WHERE interesse_id='".$r->id."' AND status='1' ORDER BY id DESC");
			while($interacoes=mysql_fetch_object($in)){
				$hora=explode(":",$interacoes->hora);
				echo dataUsaToBr($interacoes->data)."(".$hora[0].":".$hora[1]."), ";
			}
			?>
			</span>
			<br />
		</div>
        <label style="width:180px;">
        Consultor
        <select name="corretor_id">
        	<?
				$corretores = mysql_query("SELECT * FROM corretor WHERE vkt_id='$vkt_id' ");
				while($corretor=mysql_fetch_object($corretores)){

			?>
            <option value="<?=$corretor->id?>" <? if($corretor->id==$r->corretor_id){echo "selected=selected";}?>><?=$corretor->nome?></option>
        	<?
				}
			?>
        </select>
		</label>
        <input name="id" type="hidden" value="<?=$r->id?>" />
	</fieldset>
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<input name="action" type="submit"  value="Salvar" style="float:right"  />
<input name="action" type="button"  value="Imprimir" style="float:right"  onclick="ficha_venda(<?=$id?>)"/>
<?
if($r->id>0){
?>
<input name="action" type="submit" value="Excluir" style="float:left" />
<?
}
?>
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
<script>top.openForm()</script>