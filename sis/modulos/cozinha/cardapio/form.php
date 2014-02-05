<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
 $refeicoes=array('cafe'=>'Café','almoco'=>'Almoço','lanche'=>'Lanche','janta'=>'Janta','seia'=>'Seia');
$dia_semana=mysql_result(mysql_query("SELECT DATE_FORMAT('{$_GET[data]}','%w')"),0,0);
$data_completa=mysql_result(mysql_query("SELECT DATE_FORMAT('{$_GET[data]}','%d/%m/%Y')"),0,0);

$pessoas=mysql_result(mysql_query("SELECT {$_GET[refeicao]}_dia FROM cozinha_contratos WHERE id='{$_GET[contrato_id]}' "),0,0);
?>
<script></script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />

<div>
<div id='aSerCarregado'>
<div>
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
   
    <span>Card&aacute;pio</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong><?=$refeicoes[$_GET[refeicao]]?> - <?=$semana_extenso[$dia_semana]?>  - <?=$data_completa?></strong>
		</legend>
        <div style="clear:both;">
        <input type="hidden" id="qtd_pessoas_contrato_refeicao" value="<?=$pessoas?>" />
        <b>
        <? echo $refeicoes[$_GET[refeicao]].' para ';?><input type="text" value="<?=$pessoas?>" size="3" maxlength="4" class='qtd_pessoas_ficha' > <?=' pessoas' ;?>
        </b><br />
          <table style=" float:left; clear:both;  " cellpadding="0" cellspacing="0">
            
            <thead>
        <tr>
        	<td width="150">Ficha</td>
            <td>Pessoas</td>
            <td width="15"></td>
            </tr>
        </thead>
        <tbody style="background-color:white;" id="fichas">
        <? 
		$itens_dia_q=mysql_query("
		SELECT 
			f.nome as ficha, f.id as ficha_id, c.pessoas as pessoas 
		FROM 
			cozinha_cardapio_dia_refeicao as c, cozinha_fichas_tecnicas as f 
		WHERE 
			f.id=c.ficha_tecnica_id
			AND contrato_id='{$_GET[contrato_id]}' 
			AND data='{$_GET[data]}'
			AND c.vkt_id='$vkt_id'
			AND  FIND_IN_SET('{$_GET[refeicao]}',tipo_refeicao)
			ORDER BY f.nome ASC "); 
			
			$num_itens_dia = mysql_num_rows($itens_dia_q);
			while($item=mysql_fetch_object($itens_dia_q)){
			?>
            <tr>
                <td>
                    <select name="ficha_id[]" onkeyup="adicionaFicha(this)" style=" width:130px;  margin:0; padding:0;" >
                    <option value="0">Escolha uma ficha</option>
                    <? 
	 $mq = mq($t="SELECT * FROM cozinha_cardapios_grupos WHERE vkt_id='$vkt_id' ORDER BY ordem, nome ASC");
	while($r=mf($mq)){
								echo "<optgroup label='$r->nome'>";

						$fichas_q=mysql_query($t="
							SELECT 
								*,cft.id as ficha_id, ccg.nome as grupo_nome,cft.nome as ficha_tecnica_nome 
							FROM 
								cozinha_fichas_tecnicas cft,
								cozinha_cardapios_grupos ccg 
							WHERE 
							ccg.id='$r->id' AND
							ccg.vkt_id='$vkt_id' AND
							ccg.id=cft.grupo_cardapio_id AND
							cft.exibir_cliente='1' AND 
								FIND_IN_SET 
							('{$_GET[refeicao]}',refeicao)							
							ORDER BY ccg.nome,cft.nome ASC ");
							echo mysql_error();
						while($ficha=mysql_fetch_object($fichas_q)){
							if($item->ficha_id==$ficha->ficha_id){$sel='selected="selected"';}else{$sel='';}

					?>
                    	<option <?=$sel?> value="<?=$ficha->ficha_id?>"><?=$ficha->ficha_tecnica_nome?></option>
                    <? 
					
							}
								echo "</optgroup>";
					} ?>
                    </select>
                </td>
                <td>
                    <input type="text" name="pessoas[]"  onkeyup="adicionaFicha(this)" sonumero="1" value="<?=$item->pessoas?>"  size="5" class='ficha_imput' />
                </td>
                <td onclick="retiraFicha(this)"><a href="#"  style="color:red;">X</a></td>
            </tr>
            <? } ?>
            <tr>
                <td>
                    <select onkeyup="adicionaFicha(this)" name="ficha_id[]" style="width:130px;  margin:0; padding:0;">
                    <option value="0">Escolha uma ficha</option>
                    <? 
	 $mq = mq($t="SELECT * FROM cozinha_cardapios_grupos WHERE vkt_id='$vkt_id' ORDER BY ordem, nome ASC");
	while($r=mf($mq)){
								echo "<optgroup label='$r->nome'>";

						$fichas_q=mysql_query("SELECT * FROM cozinha_fichas_tecnicas WHERE FIND_IN_SET ('{$_GET[refeicao]}',refeicao) AND vkt_id='$vkt_id' AND  grupo_cardapio_id='$r->id' ORDER BY nome ASC ");
							$grupo_anterior='';
						while($ficha=mysql_fetch_object($fichas_q)){

					?>
                    	<option value="<?=$ficha->id?>"><?=$ficha->nome?></option>
                    <? 
					} 
					echo"</optgroup>";
	}
					?>
                    </select>
                </td>
                <td>
                    <input type="text" name="pessoas[]"  onkeyup="adicionaFicha(this)" sonumero="1" value="<?=$pessoas?>"  size="5" class='ficha_imput'   />
                </td>
                <td onclick="retiraFicha(this)"><a href="#" style="color:red;">X</a></td>
            </tr>
            
           
            
        </tbody>
        </table>
        </div>

	</fieldset>
    <input type="hidden" name="data"  value="<?=$_GET[data]?>" />
    <input type="hidden" name="refeicao" value="<?=$_GET[refeicao]?>" />
    <input type="hidden" name="contrato_id" value="<?=$_GET[contrato_id]?>" />
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?php
	if($num_itens_dia>0){
?>
<input name="exportar" type="button"  value="Exportar" style="float:left"  onclick="window.open('modulos/cozinha/cardapio/form_exportacao.php?data_inicio=<?=$_GET['data_inicio']?>&data_fim=<?=$_GET['data_fim']?>&data_selecionada=<?=$data_completa?>&refeicao=<?=$_GET[refeicao]?>&contrato_id=<?=$_GET['contrato_id']?>','carregador')"/>
<?php
	}
?>
<input type="button" value="Importar do Dia Anterior" onclick="importarDiaAnterior('<?=$_GET[contrato_id]?>','<?=$_GET[data]?>','<?=$_GET[refeicao]?>')" />


<input name="action" type="submit"  value="Salvar" style="float:right"  />
<input name="actionCardapio" type="hidden"  value="1" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>

<script>top.openForm()</script>
<script>
top.$("#fichas tr:odd").addClass('al');
</script>
