<?

//Includes
// configuração inicial do sistema
include("../../_config.php");
// funções base do sistema
include("../../_functions_base.php");
// funções do modulo empreendimento
include("_functions_financeiro.php");
include("_ctrl_financeiro.php"); 

if($obj->status==1){
	$desabilita_finalizado 	= 'disabled="disabled"';
}

?>
<style>
input,select,textarea{display:block; }
label{ float:left}
</style>
<link href="../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style=" width:680px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Movimenta&ccedil;&atilde;o no Caixa</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" id='form_movimento_caixa' method="post" enctype="multipart/form-data" autocomplete='off'>
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informações</strong>
		</legend>
        
		<label style="width:150px;">
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
		<label style="width:300px;">
			Cliente/Fornecedor
            	<input name="internauta_id"  type="hidden" id="internauta_id" title='<?=$cliente->razao_social?>' value="<?=$obj->internauta_id?>" />
			  <input name="cliente" id="cliente" value="<?=$cliente->razao_social?>" busca='modulos/financeiro/busca_clientes.php,@r0 @r2,@r1-value>internauta_id|@r0-title>internauta_id,0' valida_minlength='3'retorno='focus|Busque o nome do Cliente' autocomplete="off">         
              </label>
        <label style="width:32px;"><br/>
       		<button type="button" name="cad_cliente"  id="cad_cliente" title="Cadastro de Clientes" rel="tip" ><img  src="../fontes/img/adm.png" ></button>
         </label>
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
		<label style="width:465px;">
			Descricao
			  <input name="descricao" id="descricao" value="<?=$obj->descricao?>" maxlength="200" valida_minlength='3' retorno='focus|Preencha a Descrição'>
        </label>
         <label style="width:100px;">
              Nº. Doc
              <input name="doc" id="doc" value="<?=$obj->doc?>" >
        </label>
         
        <div style="clear:both"></div>
		<label style="width:100px;">
			Forma 
			  <select name="forma_pagamento">
              <?
              $select_pagamento[$obj->forma_pagamento]='selected="selected"';
			  ?>
			    <option value="1" <?=$select_pagamento[1]?>>Dinheiro</option>
			    <option value="2" <?=$select_pagamento[2]?>>Cheque</option>
			    <option value="3" <?=$select_pagamento[3]?>>Cartao</option>
			    <option value="4" <?=$select_pagamento[4]?>>Boleto</option>
			    <option value="5" <?=$select_pagamento[5]?>>Permuta</option>
			    <option value="6" <?=$select_pagamento[6]?>>Outros</option>
		      </select>
		   </label>
           <!-- <div style="width:100%; clear:both"></div> -->        

		<label style="width:80px;">
			Vencimento
			  <input name="data_vencimento" id="data_vencimento" value="<?
			  if($obj->id>0){
			  	echo dataUsaToBr($obj->data_vencimento);
			  }else{
				echo date("d/m/Y");
				}
			  
			  ?>"  mascara='__/__/____' calendario='1'
              valida_data='01/01/0001,31/12/9999' retorno='focus|Preencha a Data Correta'
              >
        </label>
		<label style="width:80px;" title="Ano / Mês de Referencia da Movimentação Financeira">
			Mês/Ano Ref.
			  <input name="ano_mes_referencia" id="ano_mes_referencia" value="<?
			  if($obj->id>0){
			  	echo $obj->ano_mes_referencia;
			  }else{
				echo date("m/Y");
				}
			  
			  ?>"   mascara='__/____' 
              onfocus="
              if(this.value==''&&document.getElementById('data_vencimento').value!=''){
                mesbase=document.getElementById('data_vencimento').value.split('/');
              	 this.value=mesbase[1]+'/'+mesbase[2]
              };document.getElementById('calendario').style.display='none'
              " valida_minlength='7'retorno='focus|Prenncha mes e ano de referencia' >
        </label>
		<label style="width:100px;">
			Valor
			  <input name="valor_cadastro" decimal="2" sonumero='1' moeda='1'  id="valor_cadastro" value='<?=moedaUsaToBr($obj->valor_cadastro)?>'  onkeyup="
              document.getElementById('centro_valor').value=this.value;
              document.getElementById('centro_porcentagem').value=100;
              document.getElementById('plano_valor').value=this.value;
              document.getElementById('plano_porcentagem').value=100;
              " valida_minlength='3' style="text-align:right" retorno='focus|Valor Incorreto'  <?=$desabilita_finalizado?> onfocus="document.getElementById('calendario').style.display='none'">
        </label>
        <div style="float:left; margin-top:15px; width:150px">
        <?
			
			$info_pgto=$obj->tipo;
			if($info_pgto!='pagar' &&$info_pgto!='receber' ){
				if($_GET['info_pgto']=='pagar'){
					$info_pgto ='pagar';
				}else{
					$info_pgto ='receber';
				}
			}
			
        	$select_tipo[$info_pgto]='checked="checked"';
		?>
   	      <input name="tipo" type="radio" id="pagar"  <?=$desabilita_finalizado?>  value="pagar" <?=$select_tipo[pagar]?> />
        	
        	 Pagar
            
            <input type="radio" name="tipo" id="receber"  <?=$desabilita_finalizado?>  value="receber" <?=$select_tipo[receber]?> />
          Receber 
          
          </div>
          

   
 <div style="width:100%; clear:both"></div>         
<div style="float:left; width:300px" id='centro_de_custos'>
	<?
			$q_cp = mysql_query("SELECT * from financeiro_centro_has_movimento WHERE movimento_id ='$obj->id'");

    if($id<1 || mysql_num_rows($q_cp)<1 ){
		$q_cp = mysql_query("SELECT 1+1");
	
	}
	$linhas = mysql_num_rows($q_cp);
	while($rcp=mysql_fetch_object($q_cp)){
		$quanti++;
		if($quanti<$linhas){
			$img= 'menos';	
		}else{
			$img= 'mais';	
		}
		$porcentagem = moedaUsaToBr(@($rcp->valor/$obj->valor_cadastro)*100);
	?>
   <div style="clear:both; display:block">     
        <label style="width:120px;">
            
			Centro de Custos
			<select name="centro_custo_id[]" id=''>
              	<?
    
				exibe_option_sub_plano_ou_centro('centro',0,$rcp->plano_id,0);

				?>
              </select>
        </label>
 		<label style="width:80px;">
			Valor <input name="centro_valor[]" id="centro_valor" value="<?=moedaUsaToBr($rcp->valor) ?>"  onkeyup="calc_plano_centro_valor(this)"  >  
       </label>
  		<label style="width:30px;">
        %
         <input name="centro_porcentagem[]" id="centro_porcentagem" onkeyup="calc_plano_centro_porcentagem(this)" value="<?=$porcentagem?>"  >
       </label>
      <img src="../fontes/img/<?=$img?>.png" onclick="addPlc(this)" width="18" height="18" style=" margin-top:20px" />
    </div>
    <?
	}
	?>
</div>
        
        
        
        
        
		<div style="float:left; width:300px" id='plano_de_contas'>
        <?
		$q_cp = mysql_query("SELECT * from financeiro_plano_has_movimento WHERE movimento_id ='$obj->id'");
    if($id<1||mysql_num_rows($q_cp)<1){
		$q_cp = mysql_query("SELECT 1+1");
	
	}
	$linhas = mysql_num_rows($q_cp);
		$quanti=0;
	while($rcp=mysql_fetch_object($q_cp)){
		$quanti++;
		if($quanti<$linhas){
			$img= 'menos';	
		}else{
			$img= 'mais';	
		}
		$porcentagem = moedaUsaToBr(@($rcp->valor/$obj->valor_cadastro)*100);
	?>
        <div style="clear:both; display:block">
        <label style="width:120px;">
			Plano de Conta
			<select name="plano_de_conta_id[]">
              	<?

			exibe_option_sub_plano_ou_centro('plano',0,$rcp->plano_id,0);

				?>
              </select>
        </label>
 		<label style="width:80px;">
			Valor
			  <input name="plano_valor[]" id="plano_valor" onkeyup="calc_plano_centro_valor(this)" value="<?=moedaUsaToBr($rcp->valor)?>" >
       </label>
  		<label style="width:30px;">
        %
         <input name="plano_porcentagem[]" id="plano_porcentagem" onkeyup="calc_plano_centro_porcentagem(this)" value="<?=$porcentagem?>" >
       </label>
      <img src="../fontes/img/<?=$img?>.png" onclick="addPlc(this)" width="18" height="18" style=" margin-top:20px" />
      </div>
    <?
	}
	?>
        </div>
        
        
        
		<label style="width:561px;">
        Descricao
			<textarea name="nota" id="nota"><?=$obj->nota?></textarea>
		</label>
        
        
        <?
        if($obj->status==0){
			$datamovimentoinfo_lb='display:none';
		}else{
			$efetivar_movimento_lb = 'disabled="disabled"';
			
		}
		?>
		<label >
        <br />
			<input <?=$efetivar_movimento_lb?> name="efetivar_movimento" type="checkbox" id="efetivar_movimento" style="display:compact; width:inherit; background:none; width:inherit" onchange="
            if(this.checked){
            	document.getElementById('lbdata_movimento').style.display='';
                
            	document.getElementById('repetirlb').style.display='none';
            	document.getElementById('data_info_movimento').value=document.getElementById('data_info_movimento').title;
              }else{
             	document.getElementById('repetirlb').style.display='';
                 document.getElementById('lbdata_movimento').style.display='none';
                 document.getElementById('data_info_movimento').value='';
              }" value="1"> Efetivar 
Movimentação
		</label>
       

 
        
  <label style="width:135px; <?
              if($obj->id>0){
				echo "display:none;"  ;
				}
			  ?>" id='repetirlb' title="Será repetido essa conta nos póximos meses com o mesmo dado">Repetir
			
			  <select name="repetir" style="display:compact;  width:100%;" >
			    <option value="0"> Não</option>
			    <option value="1">+1 Mes</option>
			    <option value="2">+2 Meses</option>
			    <option value="3">+3 Meses</option>
			    <option value="4">+4 Meses</option>
			    <option value="5">+5 Meses</option>
			    <option value="6">+6 Meses</option>
			    <option value="7">+7 Meses</option>
			    <option value="8">+8 Meses</option>
			    <option value="9">+9 Meses</option>
			    <option value="10">+10 Meses</option>
			    <option value="11">+11 Meses</option>
			    <option value="12">+12 Meses</option>
		    </select>
        </label>
        <label style="width:135px; <?=$datamovimentoinfo_lb?>" id='lbdata_movimento'>
			Data Movimentacao
			  <input name="data_info_movimento"  id="data_info_movimento"  mascara='__/__/____' calendario='1' title="<?
			  if(strlen($obj->data_info_movimento)<10||$obj->data_info_movimento=='0000-00-00'){
			  	$data_info_movimento= date("d/m/Y");
			  }else{
			  	$data_info_movimento= dataUsaToBr($obj->data_info_movimento);
			}
			  echo $data_info_movimento;
			  ?>" <?
              
			  if($obj->status==1){
				  echo "value='$data_info_movimento'";
				 }
			  
			  ?>>
        </label>
        <label style="width:90px;">
			Codigo Origem
			  <input name="origem_id"  value="<?=$obj->origem_id?>">
        </label>
        <label style="width:120px;">
			Tipo Origem
			  <select name="origem_tipo" id="origem_tipo">
               <?
               $origem_tipo["$obj->origem_tipo"]= "selected='selected'";
			   ?>
                   <option value="Lançamento Direto" <?=$origem_tipo["Lançamento Direto"]?>>Lançamento Direto</option>
              	  <option value="Contrato" <?=$origem_tipo["Contrato"]?>>Contrato</option>
                  <option value="Ordem de compra" <?=$origem_tipo["Ordem de compra"]?>>Ordem de compra</option>
                  <option value="Contratos" <?=$origem_tipo["Contratos"]?>>Contratos</option>
                  <option value="Folha de Pagamento" <?=$origem_tipo["Folha de Pagamento"]?>>Folha de Pagamento</option>
                  <option value="Conta Fixa" <?=$origem_tipo["Conta Fixa"]?>>Conta Fixa</option>
                <option value="Extorno" <?=$origem_tipo["Extorno"]?>>Extorno</option>
                  <option value="Transferencia" <?=$origem_tipo["Transferencia"]?>>Transferencia</option>
              </select>
        </label>
        <label style="width:270px" title="O Arquivo terá que ser: jpg, pdf, gif, png">Documento
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
<?
if($obj->id>0 &&  $obj->status==0){
?>
<input name="action" type="submit" value="Excluir" style="float:left" />
<?
}
if($obj->status==1&&$obj->extorno!=1){
?>	
<input type="button" value="Extornar lançamento" onclick="if(confirm('Confirma o extorno dessa movimentação financeira ?')){if(confirm('Deseja também criar um novo lançamento em contas a pagar ou receber com os mesmo dados?')){location='?tela_id=54&conta_id=<?=$obj->conta_id?>&extorno=<?=$obj->id?>&recria=1'}else{location='?tela_id=54&conta_id=<?=$obj->conta_id?>&extorno=<?=$obj->id?>'}}" style="float:left"  />
<?
}
if($obj->transferencia==0){
?>

<input  type="button"  value="Salvar" style="float:right" onclick="confirma_calculor()"  />
<?
}
if($obj->id>0 && $obj->transferencia==0){
?>

<input type="button" value="Imprimir Recibo" onclick="window.open('modulos/financeiro/recibo.php?movimento_id=<?=$obj->id?>','_BLANK')" style="float:right"  />
<?
}
?><div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()
</script>