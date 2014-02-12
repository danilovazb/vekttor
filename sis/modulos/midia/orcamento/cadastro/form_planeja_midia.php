<meta charset="utf-8">
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='exibe_formulario' class='exibe_formulario'>
<div id='aSerCarregado'>
<div  style="width:800px" >
	<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
		<a class='f_x' onClick="form_x(this)"></a>
    	<span>Planejamento de Mídia</span>
    </div>
    </div>
	<form id="form_planejamento_midia" onSubmit="return validaForm(this)"  class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_0' >
    <input type="hidden" name="painel_orcamento_item" />
    <input type="hidden" id="total_insercoes" value="<?=$total_insercoes?>" />
    <input type="hidden" id="segundos_vt" name="segundos_vt" value="<?=$orcamento->segundos_vt?>" />
		<legend> <span><strong>Dados</strong></span> </legend>
		
        <label style="width:100px;"><strong>N&ordm; P.I.</strong> <br/> &nbsp;
			<?=$orcamento->numero_proposta?>
			<input type="hidden" id='numero_proposta' name="numero_proposta" value="<?=$orcamento->numero_proposta?>" autocomplete='off' maxlength="30"/>
		</label>
        
        <label style=""><strong>Cliente</strong> <br/> &nbsp;
			<?=$orcamento->cliente?>
            </label>
        <div style="clear:both;"></div>
        <label style="width:200px;"><strong>Descrição</strong><br />
        <?=$orcamento->descricao?>
		</label>
        <div style="clear:both;"></div>
       <label>
       <strong>Data Início:</strong> <?=dataUsaToBr($menor)?>
       </label>
       <label>
       <strong>Data Fim:</strong> <?=dataUsaToBr($maior)?>
       </label>
       <label>
       <strong>Dias:</strong> <?=$intervalo?>
       </label>
       <div style="clear:both;"></div>
       <label>
       Duração do VT:<br />
		<?=$orcamento->segundos_vt?>
       </label>
       <label>
       Inserções: <br />
		<?=$total_insercoes?>
       </label>
       <label>
       Inserções diárias:
       </label>
       <div style="clear:both;"></div>
       <div style=" width:722px; overflow:scroll;">
      
       	<table style="background-color:white;" width="<?=$largura_tabela?>" cellspacing="0"   cellpadding="1">
        	<thead>
            	<tr>
                <td width="150">Painéis</td>
                  	<? 
					for($i=0;$i<=$intervalo;$i++){
						
						$dia_coluna = calculo_dia($menor,$i);
					?>
                	<td width="80" align="center" style="padding:0;">
                    <input type="text" name="datas[]" style="font-size:9px; background-color:transparent;  text-decoration:underline;cursor:pointer; border:none;" id="insercaoData<?=$i?>" calendario="1"  value="<?=dataUsaToBr($dia_coluna)?>" size="8">
                    </td>
                    <?
					}
					?>
                    <td></td>
                </tr>
            </thead>
            <tbody>
            
            
            	<? 
				$iterador_data=0;
				for($i=0;$i<count($item_orcamento);$i++){ 
					if($i%2==0){$al=" al ";}else{$al=" ";}
				?>
            	<tr class="<?=$al?>" id="insercao<?=$i?>">
                
                    <td width="150">
						<?=$item_orcamento[$i]->painel?> - <span id="total_painel_<?=$item_orcamento[$i]->id?>"><?=$insercoes_painel[$item_orcamento[$i]->id]?></span>
                        <input type="hidden" name="tipo_midia[<?=$item_orcamento[$i]->id?>]" value="<?=$item_orcamento[$i]->painel_tipo_midia_id?>" />
                    </td>
                    <?
					for($z=0;$z<=$intervalo;$z++){
						
						$dia_coluna = calculo_dia($menor,$z);
					?>
                    <td width="80">
                    	<input type="text" name="painel_insercao[<?=$item_orcamento[$i]->id?>][]" class="insercao" data="<?=$dia_coluna?>" data-rel="<?=$item_orcamento[$i]->id?>" sonumero="1" id="insercaoCampo<?=$iterador_data?>"  value="<?=$insercao_ocupada[$item_orcamento[$i]->id][$dia_coluna]?>" size="5">
                    </td>
                    <? 
					$iterador_data++;
					} ?>
                    <td></td>
                </tr>
                
                
                <? } ?>
               
               
            </tbody>
            <tfoot>
            	<tr>
                	<td width="150">Total</td>
                    <? 
					for($i=0;$i<=$intervalo;$i++){
						
						$dia_coluna = calculo_dia($menor,$i);
                    ?>
                        <td width="80" id="total_dia_<?=$dia_coluna?>"><?=$insercoes_dia[$dia_coluna]?></td>
                   <? } ?> 
                   <td></td>  
                </tr>
            </tfoot>
        </table>
       </div>
	   <label>
        <strong>Total de inserções: <span><?=$total_insercoes?></span></strong><br />
	    <strong>Inserções Planejadas: <span id="insercoes_planejadas"><?=$total_planejadas?></span></strong><br />
      	<strong>Diferença de inserções: <span id="diferenca_insercoes"><?=$total_insercoes-$total_planejadas?></span></strong><br />
       </label>
    
    
       
	</fieldset>
	<input name="id" type="hidden" value="<?=$conta->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >

<? if($conta->id>0){ ?>
<input name="action" type="submit" value="Excluir" style="float:left" />
<? } ?>

<input name="action" type="button" id="submit-inserir"  value="Inserir" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>

</div>
</div>
</div>

