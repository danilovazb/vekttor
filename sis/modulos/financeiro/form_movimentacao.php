<?

//Includes
// configuração inicial do sistema
include("../../_config.php");
// funções base do sistema
include("../../_functions_base.php");
// funções do modulo empreendimento
include("_functions_financeiro.php");
include("_ctrl_financeiro.php"); 
criaFormaPagamento($forma_pagamento);
//pr($_GET);
$data_cadastro = DataUsatoBr($obj->data_registro)."<br/>";
gettype($data_cadastro);
if($obj->status==1){
	$desabilita_finalizado 	= 'disabled="disabled"';
}

if($_GET[conciliacao]==1){
	$descricao=$_GET[descricao];
	$vencimento=$_GET[vencimento];
	$ano_mes_referencia=$_GET[ano_mes_referencia];
	$valor=abs(moedaBrToUsa($_GET[valor]));
	$data_info_movimento=$_GET[vencimento];
	$pagar_receber=$_GET[pagar_receber];
	$origem_id=$_GET[origem_id];
	$origem_tipo='conciliação';
}else{
	$origem_id=$obj->origem_id;
	$origem_tipo=$obj->origem_tipo;
	$descricao=$obj->descricao;
	$valor=$obj->valor_cadastro;
	$info_pgto=$obj->tipo;

	if($obj->id>0){
	  	$ano_mes_referencia =$obj->ano_mes_referencia;
	}else{
		$ano_mes_referencia =date("m/Y");
	}
	if(strlen($obj->data_info_movimento)<10||$obj->data_info_movimento=='0000-00-00'){
		$data_info_movimento= date("d/m/Y");
	}else{
		$data_info_movimento= dataUsaToBr($obj->data_info_movimento);
	}
	if($obj->id>0){
		$vencimento = dataUsaToBr($obj->data_vencimento);
	}else{
		$vencimento = date("d/m/Y");
	}	
}
	if($info_pgto=='pagar'){
		$infocor ='#FFC0CB';
	}else{
		$infocor ='#BAE7BE';
	}
if($info_pgto!='pagar' &&$info_pgto!='receber' ){
	if($_GET['info_pgto']=='pagar'){
		$info_pgto ='pagar';
		$infocor ='#FFC0CB';
	}else{
		$info_pgto ='receber';
		$infocor ='#BAE7BE';
	}
}		
$select_tipo[$info_pgto]='checked="checked"';
?>
<style>
input,select,textarea{display:block; }
label{ float:left;}
</style>
<link href="../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style=" width:830px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Movimenta&ccedil;&atilde;o no Caixa</span></div>
    </div>
    
	<form onsubmit="return validaForm(this)" class="form_float" id='form_movimento_caixa' method="post" enctype="multipart/form-data" autocomplete='off'>
	<input type="hidden" name="limite_mensal" id="limite_mensal" value="">
    
    <!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informações</strong>
		</legend>
        
		
		<label style="width:292px;">
			Cliente/Fornecedor
            
            	<input name="internauta_id"  type="hidden" id="internauta_id" title='<?=$cliente->razao_social?>' value="<?=$obj->internauta_id?>" />
			    <input name="cliente" id="cliente" value="<?=$cliente->razao_social?>" busca='modulos/financeiro/busca_clientes.php,@r0 @r2 @r3,@r1-value>internauta_id|@r0-title>internauta_id|@r3-value>limite_mensal,0' autocomplete="off">
                    
        </label>
             
        <label style="width:32px;"><br/>
       		<button type="button" name="cad_cliente"  id="cad_cliente" title="Cadastro de Clientes" rel="tip" ><img  src="../fontes/img/adm.png" ></button>
         </label>
            
              <label style="width:150px; ">
			Vencimento
			  <input name="data_vencimento" id="data_vencimento" onchange="mudaFormaPagamento()" value="<?=$vencimento?>"  mascara='__/__/____' calendario='1' sonumero='1'
              valida_data='01/01/0001,31/12/9999' retorno='focus|Preencha a Data Correta'  >
              <span id="obs_vencimento"></span>
        </label>
		
		<label style=" margin-left:0;display:none" title="Ano / Mês de Referencia da Movimentação Financeira" >
			Mês/Ano Ref.
			  <input name="ano_mes_referencia" id="ano_mes_referencia" value="<?=$ano_mes_referencia?>"   mascara='__/____'  sonumero='1'
              onfocus="
              if(this.value==''&&document.getElementById('data_vencimento').value!=''){
                mesbase=document.getElementById('data_vencimento').value.split('/');
              	 this.value=mesbase[1]+'/'+mesbase[2]
              };document.getElementById('calendario').style.display='none'
              "  >
        </label>
          
 <div style="float:left; margin-top:15px; width:150px">
   	      <input name="tipo_f" type="radio" id="pagar"  <?=$desabilita_finalizado?>  value="pagar" <?=$select_tipo[pagar]?> onFocus="document.getElementById('calendario').style.display='none'" />
        	
        	 Pagar
            
            <input type="radio" name="tipo_f" id="receber"  <?=$desabilita_finalizado?>  value="receber" <?=$select_tipo[receber]?> onFocus="document.getElementById('calendario').style.display='none'" />
          Receber 
          
          </div>         
                     
          <!-- modal -->
           <div style="position:absolute;  margin-top:51px; margin-left:298px;">
              <div class="modal" style="display:none">
              <div class="modal-header-2">
              	<a href="#" style="color:#CCC; font-weight:bold; float:right;" class="modal_close">x</a>
                <span>Cadastro de Cliente</span>
              </div>
                    <div class="modal-body">
                    	<p>
                        	<div class="atl_natureza" style="padding:3px; height:30px;">
                            	<div style="float:left"><input type="radio" name="natureza" id="cpf" value="1" style="width:20px;">CPF</div>
                            	<div style="float:left"><input type="radio" name="natureza" id="cnpj" value="2" style="width:20px;">CNPJ</div>
                                <div style="margin-left:120px;">
                                	<select name="tipo" id="tipo" disabled="disabled">
                                    	<option value="Cliente">Cliente</option>
                                        <option value="Fornecedor">Fornecedor</option>
                                    </select>
                                </div>
                            </div>
                            <div style="clear:both;"></div>
                        	<div style=" float:left;"><label style="width:175px;">Nome<br/><input type="text" name="atl_nome" id="atl_nome" style="height:15px;" disabled="disabled"></label></div>
                            <div><label style="width:120px;">CNPJ/CPF <br/><input type="text" name="atl_cnpf_cpf" id="atl_cnpf_cpf" style="height:15px;" disabled="disabled"></label></div>      
                         </p>
                         <!--<button type="button" name="atl_cadastrar" id="atl_cadastrar" disabled="disabled" style="margin-top:8px;" >cadastrar</button>-->
                         <div><small style=" color:#999999; font-size:11px;">ap&oacute;s cadastro v&aacute; para tela clientes para completar as informa&ccedil;&otilde;es </small></div>
                    </div>
              <div class="modal-footer">
              	<!--<div style="padding:3px;"><span>ap&oacute;s o cadastro vá para tela cliente</span></div>999999-->
                <button type="button" name="atl_cadastrar" id="atl_cadastrar" disabled="disabled" >cadastrar</button>
                
              </div>
			</div>
    		</div>
        <!-- fim modal -->
        <div style="clear:both"></div>
		<label style="width:300px;">
			Descricao
			  <input name="descricao" id="descricao" value="<?=$descricao?>" maxlength="200" valida_minlength='3' retorno='focus|Preencha a Descrição' onFocus="document.getElementById('calendario').style.display='none'">
        </label>
         <label style="width:84px;">
              Nº. Doc
              <input name="doc" id="doc" value="<?=$obj->doc?>" >
        </label>
         
       <!--  <div style="clear:both"></div> -->
       <?
       criaFormaPagamento($forma_pagamento);
	   ?>
       <label style="width:145px;">
			Forma 
			  <select name="forma_pagamento" onchange="mudaFormaPagamento()" id="forma_pagamento">
          <?
		  $formas_pagamento_q=mysql_query("SELECT * FROM financeiro_formas_pagamento WHERE vkt_id='$vkt_id'");
		  while($f=mysql_fetch_object($formas_pagamento_q)){
		  
			if($obj->forma_pagamento==$f->id){ $sel = 'selected';}else{$sel = '';}
			?>
			  <option value='<?=$f->id?>' prazo="<?=$f->prazo_efetivacao?>" taxa_pct="<?=$f->valor_percentual?>" taxa_fix="<?=$f->valor_fixo?>"  <?=$sel?> ><?=$f->nome?></option>
			<? 
			}
?>
			   
		      </select>
              <span id="obs_forma_pagamento">
              <?=$data_vencimento_info?><br />
              <?=$taxas?>
              </span>
		   </label>
		
           <!-- <div style="width:100%; clear:both"></div> -->        

		<label style="width:150px; margin-left:0">
			Valor
			  <input name="valor_cadastro" onblur="mudaFormaPagamento()" id="valor_cadastro" value='<?=moedaUsaToBr($valor)?>'  onkeyup="
              document.getElementById('centro_valor').value=this.value;
              document.getElementById('centro_porcentagem').value=100;
              document.getElementById('plano_valor').value=this.value;
              document.getElementById('plano_porcentagem').value=100;
              " valida_minlength='1' style=" text-align:right;font-size:26px;background:<?=$infocor?>" retorno='focus|Valor Incorreto'  <?=$desabilita_finalizado?> onfocus="document.getElementById('calendario').style.display='none'"   >
              <span id="obs_valor"><?=$valor_taxas?></span>
              
        </label>
        
          

<div style="width:100%; clear:both"></div>

<div id="result_val_diferente"></div>

<div style="float:left; width:360px; border:0px solid #333;" id='centro_de_custos'>
	<?
			$q_cp = mysql_query($ct="SELECT * from financeiro_centro_has_movimento WHERE movimento_id ='$obj->id' ORDER BY id ");

    if($id<1 || mysql_num_rows($q_cp)<1 ){
		$q_cp = mysql_query("SELECT 1+1,'$valor' as valor");
	
	}
	$linhas = mysql_num_rows($q_cp);
	$list_cont = 0 ;
	while($rcp=mysql_fetch_object($q_cp)){
        if(!empty($rcp->plano_id)){
				$centro = mysql_fetch_object(mysql_query($ty=" SELECT * FROM financeiro_centro_custo WHERE id = '$rcp->plano_id' AND plano_ou_centro = 'centro' "));
		}
		if($id<1){
			$centro_custo_id= $_COOKIE[centro_custo_id];
			$centro_custo= $_COOKIE[centro_custo];
		}else{
			$centro_custo_id= $rcp->plano_id;
			$centro_custo= $centro->nome;
		}

		$quanti++;
		
		$porcentagem = moedaUsaToBr(@($rcp->valor/$obj->valor_cadastro)*100);
	?>
   <div class='listacentro' id='listacentro_<?=$list_cont?>' style="clear:both; display:block">     
        
      
       <label style="width:170px;" id="select_plano" >
        	<select name="centro_custo_id[]" id="centro_custo_id<?=$list_cont?>" class="select_plano" style="width:175px; margin:12px 0;" >
            	<option></option>
                 <?php 
				 if($rcp->plano_id>0){
					$rcp_id= $rcp->plano_id;
	 
				 }else{
					$rcp_id= $_COOKIE["centro_custo_id"];	 
				 }
				 exibe_option_sub_plano_ou_centro_1('centro',0,$rcp_id,0); 
				 ?>
            </select>
        </label>   
        
 		<label style="width:75px; margin-right:0;">
			Valor <input name="centro_valor[]" id="centro_valor" style="width:65px;" value="<?=moedaUsaToBr($rcp->valor) ?>"    > <!-- onkeyup="calc_plano_centro_valor(this)" -->  
       </label>
  		<label style="width:30px;">
        %
         <input name="centro_porcentagem[]" id="centro_porcentagem" value="<?=$porcentagem?>"  > <!-- onkeyup="calc_plano_centro_porcentagem(this)" -->
       </label>
      
      <? if($quanti == 1 ){ ?>
      <button type="button" onclick="addPlc(this)" id="add-plano" style="font-weight:bold; margin-top:18px;">+</button>
      <? } else { ?>
      <button type="button" onclick="addPlc(this)" id="add-plano" style="font-weight:bold; margin-top:18px;">-</button>
	  <? } ?>
      
    </div>
    <?
	$list_cont++;
	}
	?>
</div>
        
	<div style="float:left; width:390px; border:0px solid #666;" id='plano_de_contas'>
    <?
		$q_cp = mysql_query($tt="SELECT * from financeiro_plano_has_movimento WHERE movimento_id ='$obj->id' ORDER BY id ");
		
		if($id<1||mysql_num_rows($q_cp)<1){
			$q_cp = mysql_query("SELECT 1+1,'$valor' as valor");
		}
		
		$linhas = mysql_num_rows($q_cp);
		$quanti=0;
		$list_plano = 0;
		while($rcp=mysql_fetch_object($q_cp)){
        	if(!empty($rcp->plano_id)){
				$plano = mysql_fetch_object(mysql_query(" SELECT * FROM financeiro_centro_custo WHERE id = '$rcp->plano_id' AND plano_ou_centro = 'plano' "));
			}
			if($id<1){
				$plano_id= $_COOKIE[plano_de_contas_id];
				$plano_info= $_COOKIE[plano_de_contas];
			}else{
				$plano_id= $rcp->plano_id;
				$plano_info= $plano->nome;
			}

		$quanti++;
		
		$porcentagem = moedaUsaToBr(@($rcp->valor/$obj->valor_cadastro)*100);
	?>
    <div style="clear:both; display:block" class='listaplano' id='listaplano_<?=$list_plano?>'>
        
        <label style="width:190px;" id="select_plano" >
        	<select name="plano_de_conta_id[]" id="sel_plano_contas<?=$list_plano?>" class="select_plano" style="width:200px; margin:11px 0;" >
            	<option></option>
                 <?php 
					if($rcp->plano_id>0){
						$rcp_id = $rcp->plano_id;
					}else{
						$rcp_id = $_COOKIE["plano_de_contas_id"];	 
					}
					exibe_option_sub_plano_ou_centro_1('plano',0,$rcp_id,0); ?>
            </select>
        </label>   
        
        <label style="width:75px; margin-right:0;"> Valor
			<input name="plano_valor[]" id="plano_valor" style="width:65px;"  value="<?=moedaUsaToBr($rcp->valor)?>" > <!-- onkeyup="calc_plano_centro_valor(this)" -->
        </label>
  		<label style="width:30px;">%
        	<input name="plano_porcentagem[]" id="plano_porcentagem"  value="<?=$porcentagem?>" > <!-- onkeyup="calc_plano_centro_porcentagem(this)" --> 
        </label> 
      
	  <? if($quanti == 1 ){ ?>
      <button type="button" onclick="addPlc(this)" id="add-plano" style="font-weight:bold; margin-top:18px;">+</button>
      <? } else { ?>
      <button type="button" onclick="addPlc(this)" id="add-plano" style="font-weight:bold; margin-top:18px;">-</button>
	  <? } ?>
      
      </div>
    <?
	$list_plano++;
	}
	?>
        </div>
        
        
		<label style="width:661px;">
        Nota Adicional
			<textarea name="nota" id="nota"><?=$obj->nota?></textarea>
		</label>
        
        
        <?
        if($obj->status==0){
			$datamovimentoinfo_lb='display:none';
		}else{
			$efetivar_movimento_lb = 'disabled="disabled"';
			
		}
		?>
		<label style="width:155px" >
        <br />
			<input <?=$efetivar_movimento_lb?> name="efetivar_movimento" type="checkbox" id="efetivar_movimento" style="display:compact; float:left; width:20px; background:none; " onchange="
            if(this.checked){
            	document.getElementById('lbdata_movimento').style.display='';
                
            	document.getElementById('repetirlb').style.display='none';
            	document.getElementById('data_info_movimento').value=document.getElementById('data_info_movimento').title;
                  
             }else{
                 
            	document.getElementById('repetirlb').style.display='';
                document.getElementById('lbdata_movimento').style.display='none';
                /* document.getElementById('data_info_movimento').value='';*/
              }" value="1"> Efetivar 
Movimentação
		</label>
       
		<label style="width:150px;" id='label_conta'>
			Conta
			  <select name="conta_id" id="conta_id" <?=$desabilita_finalizado?> >
				<option value='0'  >Selecione 1 Conta</option> 
              <?
              
			  $q= mysql_query("select * from financeiro_contas WHERE  cliente_vekttor_id ='".$_SESSION[usuario]->cliente_vekttor_id ."'order by preferencial DESC,nome");
			  while($r= mysql_fetch_object($q)){
					$saldo=checaSaldo($r->cliente_vekttor_id ,$r->id );
					$saldo=number_format($saldo,2,',','.');
					if($obj->id>0){
						if($r->id==$obj->conta_id){$sel = "selected='selected'";}else{$sel = "";}
					}else{
						if($r->id==$_GET['conta_id']){$sel = "selected='selected'";}else{$sel = "";}
					}
						echo "<option value='$r->id' $sel >$r->nome   $saldo</option>";  
				}
			  
			  ?>
			    
		    </select>
        </label>

        
       <label style="width:135px; <?
              if($obj->id>0){
				echo "display:none;"  ;
				}
			  ?>" id='repetirlb' title="Será repetido essa conta nos póximos meses com o mesmo dado">Repetir
			  <select name="repetir" style="display:compact;  width:100%;" >
			    <option value="0">Não</option>
			    <option value="1">+1 </option>
			    <option value="2">+2 </option>
			    <option value="3">+3 </option>
			    <option value="4">+4 </option>
			    <option value="5">+5 </option>
			    <option value="6">+6 </option>
			    <option value="7">+7 </option>
			    <option value="8">+8 </option>
			    <option value="9">+9 </option>
			    <option value="10">+10</option>
			    <option value="11">+11</option>
			    <option value="12">+12</option>
		    </select>
        </label>
        <label id="result-repetir"></label>
        <label style="width:111px; <?=$datamovimentoinfo_lb?>" id='lbdata_movimento'>
			Data Movimentacao
			  <input name="data_info_movimento"  id="data_info_movimento"  mascara='__/__/____' calendario='1' value="<?=$data_info_movimento?>" title="<?
			  echo $data_info_movimento;
			  ?>" <?
              
			  if($obj->status==1){
				  echo "value='$data_info_movimento'";
				 }
			  
			  ?>>
        </label>
        <label style="width:85px; margin-left:9px">
			Codigo Origem<br>
            <?=$origem_id?>
			  <input name="origem_id" type="hidden"  value="<?=$origem_id?>">
        </label>
        <label style="width:102px;margin-left:0px">
			Tipo Origem<br><?=$origem_tipo?>
			  <input type="hidden" value="<?=$origem_tipo?>" name="origem_tipo" id="origem_tipo">
              
        </label>
        <div style="clear:both; width:100%"></div>
        <label style="width:270px;" title="O Arquivo terá que ser: jpg, pdf, gif, png">Documento
        	<?
            if(strlen($obj->arquivo_conta_ext)>0){
	 			$pasta 	= 'modulos/financeiro/arquivo_conta/';
				$arquivo = "$obj->id.$obj->arquivo_conta_ext";
				$arquivo_p = $pasta.$arquivo;
				echo "<span><br><img border='0' class='deldoc' src='../fontes/img/del.png' tipo='arquivo' extencao='$obj->arquivo_conta_ext' identificador='$obj->id' title='Remover Arquivo'> <a href='$arquivo_p' target='_blank'><img border='0' src='../fontes/img/doc.png'></a></span>";	
				$arquivodisplay ='none';
			}
			?>
           <input name="arquivo" id="arquivo" type="file"style="display:<?=$arquivodisplay?>" />
        </label>
        <label style="width:270px" title="O Arquivo terá que ser: jpg, pdf, gif, png">Autenticação
        	<?
            if(strlen($obj->arquivo_autentica_ext)>0){
	 			$pasta 	= 'modulos/financeiro/arquivo_autenticacao/';
				$arquivo = "$obj->id.$obj->arquivo_autentica_ext";
				$arquivo_p = $pasta.$arquivo;
				echo "<span><br><img border='0' class='deldoc' src='../fontes/img/del.png' tipo='autenticacao' extencao='$obj->arquivo_autentica_ext' identificador='$obj->id' title='Remover Arquivo'> <a title='Baixar Arquivo' href='$arquivo_p' target='_blank'><img border='0' src='../fontes/img/doc.png'></a></span>";
				$autenticadisplay ='none';
			}
			?><input name="autenticacao" id="autenticacao" type="file"  style="display:<?=$autenticadisplay?>"/>
			
        </label>
	</fieldset>
	<input name="id" type="hidden" value="<?=$obj->id?>" />
	
	<input name="movimentacao" type="hidden" value="financeiro" />
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<input name="action" type="hidden" id='salva'  value="Salvar"   />
<span style="font-size:9px; color:#999"><?=$obj->dtregistro?></span>
<?

if($obj->id>0 &&  $obj->status==0){
?>
<input name="action" type="submit" value="Excluir" style="float:left" />
<?
}
if($obj->status==1&&$obj->extorno!=1){
?>	
<input type="button" value="Estornar lançamento" onclick="if(confirm('Confirma o extorno dessa movimentação financeira ?')){if(confirm('Deseja também criar um novo lançamento em contas a pagar ou receber com os mesmo dados?')){location='?tela_id=54&conta_id=<?=$obj->conta_id?>&extorno=<?=$obj->id?>&recria=1'}else{location='?tela_id=54&conta_id=<?=$obj->conta_id?>&extorno=<?=$obj->id?>'}}" style="float:left"  />

<?
echo "<span style='font-size:9px; color:#999'>movimentado em $obj->dtmov</span>";
}
if($obj->transferencia==0){
?>

<input  type="button"  value="Salvar" style="float:right" onclick="confirma_calculor()"  />

<? if( $obj->id> 0 && $obj->status != 1 ){  ?>
<input type="submit" name="Action_Duplicar" id="duplicar" style="float:right" value="Duplicar">
<?
	}
}
if($obj->id>0 && $obj->transferencia==0){
?>

<input type="button" value="Imprimir Recibo" onclick="window.open('modulos/financeiro/recibo.php?movimento_id=<?=$obj->id?>','_BLANK')" style="float:right"  />
<?
}
if($obj->forma_pagamento==4){ $show_boleto="block";}else{$show_boleto="none";}
if($select_tipo[receber]){
?>
<!--<input type="button" id="imprimir_boleto" value="Imprimir Boleto" onclick="window.open('modulos/cobranca/financeiro_boleto/boleto_unico//boletos.php?filtro_movimentacao=<?=$obj->id?>','_BLANK')" style="float:right; display:<?=$show_boleto?>"  />-->
<input type="button" id="imprimir_boleto" value="Imprimir Boleto" onclick="window.open('modulos/financeiro/boleto/index.php?filtro_movimentacao=<?=$obj->id?>','_BLANK')" style="float:right; display:<?=$show_boleto?>"  />
<?php }?>
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>
top.openForm();
top.document.getElementById('cliente').focus();
 
	<?php
	
	if( !empty($obj->id) ){
	
	$sqlSelectPlano = mysql_query($tyt="SELECT * from financeiro_plano_has_movimento WHERE movimento_id ='$obj->id'");
	$list_planoSelect2 = 0;
	while($rcpp=mysql_fetch_object($sqlSelectPlano) ){
		$plano = mysql_fetch_object(mysql_query(" SELECT * FROM financeiro_centro_custo WHERE id = '$rcpp->plano_id' AND plano_ou_centro = 'plano' "));
	?>  
	  top.$("#sel_plano_contas<?=$list_planoSelect2?>").select2({
		  placeholder: "Selecione plano de contas",
		  formatResult: top.format,
		  allowClear: true
	  });
	  top.$("#sel_plano_contas<?=$list_planoSelect2?>").on("select2-selecting",function(e) { 	
		e.preventDefault();
		var string = top.format_text(e.object.text);
		var data = { id:e.object.id, text:string };
	  	top.$(this).select2("data",data);
		top.$(this).select2("close");
		top.setCookie('plano_de_contas',e.added.text,30);
		top.setCookie('plano_de_contas_id',e.added.id,30);
	  });
	  
	  var textEdit = top.$("#sel_plano_contas<?=$list_planoSelect2?>").select2('data').text; //pega o texto selecionado
	  var idEdit = top.$("#sel_plano_contas<?=$list_planoSelect2?>").select2('data').id; //pega o ID selecionado
	  var valEdit = top.format_text(textEdit);
	  
	  top.$("#sel_plano_contas<?=$list_planoSelect2?>").select2("data",{id:'<?=$rcpp->plano_id?>',text:valEdit});
	 
	  <?php
		$list_planoSelect2++;
	   }
	  } else{
	  ?>
	   top.$("#sel_plano_contas0").select2({
		  placeholder: "Selecione plano de contas",
		  formatResult: top.format,
		  allowClear: true
	   });
	   
	   <? if(!empty($_COOKIE["plano_de_contas_id"])) {?>
		var textEdit = top.$("#sel_plano_contas0").select2('data').text; //pega o texto selecionado
		var idEdit = top.$("#sel_plano_contas0").select2('data').id; //pega o ID selecionado
		var valEdit = top.format_text(textEdit);
		top.$("#sel_plano_contas0").select2("data",{id:'<?=$_COOKIE["plano_de_contas_id"]?>',text:valEdit});
	   <? }?>
	   
	   top.$("#sel_plano_contas0").on("select2-selecting",function(e) { 	
		e.preventDefault();
		var string = top.format_text(e.object.text);
		var data = { id:e.object.id, text:string };
	  	top.$(this).select2("data",data);
		top.$(this).select2("close");
		
		top.setCookie('plano_de_contas',e.added.text,30);
		top.setCookie('plano_de_contas_id',e.added.id,30);
		
	  });
	  
	  <?php }?>
	  
	<?php
	
	/* CENTRO DE CUSTOS */
	
	if( !empty($obj->id) ){
	
	$sqlSelectCentro = mysql_query($tyt=" SELECT * from financeiro_centro_has_movimento WHERE movimento_id ='$obj->id' ");
	$listCentroSelect2 = 0;
	while($regCentro=mysql_fetch_object($sqlSelectCentro) ){
		$centro = mysql_fetch_object(mysql_query(" SELECT * FROM financeiro_centro_custo WHERE id = '$regCentro->plano_id' AND plano_ou_centro = 'centro' "));
	?>  
	  top.$("#centro_custo_id<?=$listCentroSelect2?>").select2({
		  placeholder: "Selecione Centro de custos",
		  formatResult: top.format,
		  allowClear: true
	  });

	  top.$("#centro_custo_id<?=$listCentroSelect2?>").on("select2-selecting",function(e) { 	
		e.preventDefault();
		
		var string = top.format_text(e.object.text);
		var data = { id:e.object.id, text:string };
	  	console.log(data);
		top.$(this).select2("data",data);
		top.$(this).select2("close");
		
		top.setCookie('centro_custo',e.object.text,30);
		top.setCookie('centro_custo_id',e.object.id,30);
	  });
	  
	 
	  var textEdit = top.$("#centro_custo_id<?=$listCentroSelect2?>").select2('data').text; //pega o texto selecionado
	  var idEdit = top.$("#centro_custo_id<?=$listCentroSelect2?>").select2('data').id; //pega o ID selecionado
	  var valEdit = top.format_text(textEdit);
	  top.$("#centro_custo_id<?=$listCentroSelect2?>").select2("data",{id:'<?=$regCentro->plano_id?>',text:valEdit});
	  
	  <?php
		$listCentroSelect2++;
	    }
	  } else {  //novo add
	  ?>
	  
	  top.$("#centro_custo_id0").select2({
		  placeholder: "Selecione Centro de Custo",
		  formatResult: top.format,
		  allowClear: true
	   });
	   
	  <?  if(!empty($_COOKIE["centro_custo_id"])) { // ?>
	  var textEdit = top.$("#centro_custo_id0").select2('data').text; //pega o texto selecionado
	  var idEdit = top.$("#centro_custo_id0").select2('data').id; //pega o ID selecionado
	  var valEdit = top.format_text(textEdit);
	  top.$("#centro_custo_id0").select2("data",{id:'<?=$_COOKIE["centro_custo_id"]?>',text:valEdit});
	  <? }?>
	   
	   top.$("#centro_custo_id0").on("select2-selecting",function(e) { 	
		e.preventDefault();
		var string = top.format_text(e.object.text);
		var data = { id:e.object.id, text:string };
		
	  	top.$(this).select2("data",data);
			top.$(this).select2("close");
		
		top.setCookie('centro_custo',e.object.text,30);
		top.setCookie('centro_custo_id',e.object.id,30);
	   });
	  
	  <?php } ?>
	  
	  
</script>