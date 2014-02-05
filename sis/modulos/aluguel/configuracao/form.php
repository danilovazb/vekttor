<?php
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
include("../../../modulos/financeiro/_functions_financeiro.php");
// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php"); 
$sql=mysql_fetch_object(mysql_query("SELECT * FROM aluguel_configuracao WHERE id='$vkt_id'"));
$sqlConta = mysql_fetch_object(mysql_query(" SELECT * FROM aluguel_conta WHERE vkt_id = '$vkt_id'"));
	if(empty($sql->img_cabecalho)){
		$img_c=$logo;
	}else{
		$img_c="modulos/aluguel/configuracao/img/".$vkt_id."_c.".$sql->img_cabecalho;
	}
	if(empty($sql->img_rodape)){
		$img_r=$logo;
	}else{
		$img_r="modulos/aluguel/configuracao/img/".$vkt_id."_r.".$sql->img_cabecalho;
	}
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:650px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Configuraçao Aluguel</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post" enctype="multipart/form-data">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset>
		<legend>
            <a onclick="aba_form(this,0)"> <strong>Informa&ccedil;&otilde;es</strong> </a>
    		<a onclick="aba_form(this,1)"> Configura&ccedil;&atilde;o de Conta </a>           
		</legend>
        
		<label style="width:200px;">
        <strong>Imagem do cabeçalho</strong>
		<input type="file" name="img1" id="img1" />
        </label>
        <div style="clear:both"></div>
        <? if(!empty($sql->img_cabecalho)){ ?>
        <img id="img_cabecalho" src="<?="modulos/aluguel/configuracao/img/".$sql->id."_c.".$sql->img_cabecalho?>" height="90" width="100%"/>
        <a style="display:block;" href="#" onclick="document.getElementById('img_cabecalho').setAttribute('src',''); document.getElementById('img_cabecalho').style.display='none';this.style.display='none';window.open('modulos/aluguel/configuracao/deletarfoto.php?img=cabecalho&extensao=<?=$sql->img_cabecalho?>&id=<?=$obj->id?>','carregador')">Remover Foto</a>
        <? } ?>
        <div style="clear:both"></div>
        <label style="width:200px;">
        <strong>Imagem do rodapé</strong>
		<input type="file" name="img2" id="img2"/>
        </label>
         <? if(!empty($sql->img_rodape)){ ?>
        <img id="img_rodape" src="<?="modulos/aluguel/configuracao/img/".$sql->id."_r.".$sql->img_rodape?>" height="90" width="100%"/>
        <a style="display:block;" href="#" onclick="document.getElementById('img_rodape').setAttribute('src','');document.getElementById('img_rodape').style.display='none';this.style.display='none'; window.open('modulos/aluguel/configuracao/deletarfoto.php?img=rodape&extensao=<?=$sql->img_rodape?>&id=<?=$obj->id?>','carregador')">Remover Foto</a>
        <? } ?>
        <div style="clear:both"></div>
        <label style="width:550px;">
        <strong>Texto Adicional</strong>
		<textarea name="texto" cols="25" rows="10"><?=$sql->texto_adicional?></textarea>
        </label>
          <div style="clear:both"></div>
        <label style="width:120px;">
        <strong>% do Vendedor</strong>
		<input type="text" decimal="2" name="comissao_vendedor" id="comissao_vendedor" value="<?=moedaUsaToBr($sql->comissao_vendedor)?>">
        </label>
</fieldset>
<!-- ABA CONFIG CONTA -->
<fieldset id="campos_2" style="display:none;">
    	<legend>
            <a onclick="aba_form(this,0)">Informa&ccedil;&otilde;es</a>
    		<a onclick="aba_form(this,1)"> <strong>Configura&ccedil;&atilde;o de Conta</strong> </a>           
		</legend>
        <label style="width:150px;">
			Conta
			  <select name="conta_id" id="conta_id" >
					<option value='0'  >Selecione 1 Conta</option> 
              <?
              $q= mysql_query("select * from financeiro_contas WHERE  cliente_vekttor_id ='".$_SESSION[usuario]->cliente_vekttor_id ."'order by preferencial DESC,nome");
			  while($r= mysql_fetch_object($q)){
				$saldo=checaSaldo($r->cliente_vekttor_id ,$r->id );
				$saldo=number_format($saldo,2,',','.');
				if($obj->id>0){
					if($r->id==$obj->conta_id){$sel = "selected='selected'";}else{$sel = "";}
				}else{
					if($r->id==$sqlConta->conta_id){$sel = "selected='selected'";}else{$sel = "";}
				}
					echo "<option value='$r->id' $sel >$r->nome   $saldo</option>";  
				}
			  ?>
			    
		    </select>
        </label>    
    	 <label style="width:120px;">
            
			Centro de Custos
			<select name="centro_custo_id[]" id=''>
              	<?
					exibe_option_sub_plano_ou_centro('centro',0,$sqlConta->centro_custo_id,0);
				?>
              </select>
        </label>
        <label style="width:120px;">
			Plano de Conta
			<select name="plano_de_conta_id[]">
              	<?

			exibe_option_sub_plano_ou_centro('plano',0,$sqlConta->plano_conta_id,0);

				?>
              </select>
        </label>
        <div style="clear:both;"></div>
    	<label>
    			Informaçoes da Conta<br/>
    				<textarea name="obsConta" id="obsConta" cols="40"><?=$sqlConta->obs_conta?></textarea>
    	</label>    
</fieldset>

<input type="hidden" name="ContaID" id="ContaID" value="<?=$sqlConta->id?>">
<input name="id" type="hidden" value="<?=$sql->id?>" />
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<input name="action" type="submit"  value="Salvar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>