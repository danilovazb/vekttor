<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php"); 


include("../_functions_financeiro.php");



if($obj->status==1){
	$desabilita_finalizado 	= 'disabled="disabled"';
}

?>
<style>
input,select,textarea{display:block; }
label{ float:left}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
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
	<form onsubmit="return validaForm(this)" class="form_float" id='form_movimento_caixa' method="post" autocomplete="off">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informa&ccedil;&otilde;es</strong>
		</legend>
		
		<label style="width:300px;">
			Cliente
           	  <input name="internauta_id" type="hidden" id="internauta_id" title='<?=$cliente->razao_social?>' value="<?=$conta->fornecedor_id?>" />
			  <input  name="cliente" id="cliente" value="<?=$cliente->razao_social?>" busca='modulos/financeiro/busca_clientes.php,@r0 @r2,@r1-value>internauta_id|@r0-title>internauta_id,0' valida_minlength='1'retorno='focus|Busque o nome do Cliente' autocomplete='off'>         </label>
         
        <div style="clear:both"></div>
		
          <div style="width:100%; clear:both"></div>         

		<label style="width:120px;">
			Dia de Vencimento
			  <input name="dia_vencimento" id="data_vencimento" value="<? if($conta->dia_vencimento<10)echo '0'.$conta->dia_vencimento;else echo $conta->dia_vencimento?>"  mascara='__' valida_minlength='2' sonumero='1' retorno='focus|Preencha a Data Correta'>
        </label>
		
		<label style="width:100px;">
			Valor
			  <input name="valor" decimal="2" sonumero='1'  id="valor_cadastro" value='<?=moedaUsaToBr($conta->valor)?>' moeda='1' valida_minlength='3' style="text-align:right" retorno='focus|Valor Incorreto'  <?=$desabilita_finalizado?> >
        </label>        
<div style="float:left; width:150px" id='centro_de_custos'>
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
			<select name="centro_custo_id">
                          <?
				
				 exibe_option_sub_plano_ou_centro('centro',0,$conta->centro_custo_id,0);
				?>

              </select>
        </label>
   </div>
    <?
	}
	?>
</div>
        
        
        
        
        
		<div style="float:left; width:150px" id='plano_de_contas'>
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
			<select name="plano_conta_id">
            
            <?
				
				 exibe_option_sub_plano_ou_centro('plano',0,$conta->plano_conta_id,0);
				?>
              </select>
        </label>
        </div>
    <?
	}
	?>
        </div>
        
        
        
		<label style="width:561px;">
        Descricao
			<textarea name="descricao" id="nota"><?=$conta->descricao?></textarea>
		</label>
        
        
        <?
        if($obj->status==0){
		?>
		
        <?
		$datamovimentoinfo_lb='display:none';
		}
		?>


 
        
  
               
	</fieldset>
	<input name="id" type="hidden" value="<?=$conta->id?>" />
	
	<input name="movimentacao" type="hidden" value="financeiro" />
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<input name="action" type="hidden" id='salva'  value="Salvar"   />
<?
if($conta->id>0){
?>
<input name="acao" type="submit" value="Excluir" style="float:left" />
<?
}
?>

<input name="acao" type="submit"  value="Salvar" style="float:right"  />

<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()
</script>