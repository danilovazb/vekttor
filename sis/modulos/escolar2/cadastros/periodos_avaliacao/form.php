<?
//Includes
include("../../../../_config.php");
include("../../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
$definir_avaliacao = " style='display:none' ";

 if( count($array_av) > 0 )
	$definir_avaliacao = " style='display:block' ";
?>

<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='exibe_formulario' class='exibe_formulario'  style="top:30px; left:50px;">
<div id='aSerCarregado'>
<div style="width:510px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Período de Avaliação</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post" autocomplete="off">
	<fieldset  id='campos_1' >
			
        <legend>
			<a onclick="aba_form(this,0); document.getElementById('tipo_cadastro').value='Jurídico';"><strong>Informações</strong></a>
		</legend>
		<label>Nome
        	<input name="nome" value="<?=$periodo->nome?>" type="text" valida_minlength='5' retorno='focus|Coloque no minimo 5 caracter'>
        </label>
        
        <label style="width:80px;">
        	Data Inicio
            <input type="text" name="data_inicio" id="data_inicio" calendario="1" value="<? if( !empty($periodo->data_inicio) ) echo dataUsaToBr($periodo->data_inicio);?>">
        </label>
        <label style="width:80px;">
        	Data Final
            <input type="text" name="data_final" id="data_final" calendario="1" value="<? if( !empty($periodo->data_final) ) echo dataUsaToBr($periodo->data_final);?>">
        </label>
        <div style="clear:both"></div>
        <label>
        Escola<br/>
        	<select name="unidade_id" style="width:220px;" id="unidade_id" aceita_nulo='0' retorno='focus|Data Simples'>
            <?
            $selecionado[$periodo->unidade_id]="selected='selected'";
			$selecionado[$unidade_id]="selected='selected'";
			?>
            <option value="">Escolha uma escola</option>
            <?
            $escolas_q=mysql_query("SELECT * FROM escolar2_unidades WHERE vkt_id='$vkt_id ORDER BY nome'"); 
			while($e=mysql_fetch_object($escolas_q)){
			?>
            	<option <?=$selecionado[$e->id]?>  value="<?=$e->id?>"><?=$e->nome?></option>
            <? } ?>
            </select>
        </label>
        
        <? 
		$trava = "";
		if( !empty($periodo->id) ){ 
			if( $periodo->travado == "sim" )
				$trava = 'checked="checked"';
		?>
       		<br/>
        	<input type="checkbox" <?=$trava?> name="travar_bimestre" id="travar_bimestre" value="sim"> <span style="font-size:11px; color:#666;">Travar bimestre? </span>
       
        <? } ?>
        
        <div style="clear:both;"></div>
       
        <?
			
        	if( !empty($periodo->id) ){
		?>
        
        <div class="text-extra"> Avaliaç&otilde;es </div>
        <div style="clear:both;"></div>
        <label>Ensino
        	<select name="ensino_id" id="ensino_id">
            	<option value="0">Escolha o ensino:</option>
                <?
                $sql_ensino = mysql_query(" SELECT * FROM escolar2_ensino WHERE vkt_id = '$vkt_id' ORDER BY ordem_ensino ASC ");
				while($ensino=mysql_fetch_object($sql_ensino)){
				?>
                <option value="<?=$ensino->id?>" ><?=$ensino->nome?></option>
            	<?
				}
				?>
            </select>
        </label><br/><span class="carrega_av"> Aguarde... </span>
        <div style="clear:both"></div>
        
        <div class="definir-avaliacao" <?=$definir_avaliacao?>>
          
          <label style="width:150px;">
              Nome Avaliaç&atilde;o
              <input type="text" name="nome_avaliacao" id="nome_avaliacao" maxlength="70">
          </label>
          
          <label style="width:50px;">
              Ordem
              <input type="text" name="ordem" id="ordem" sonumero="1" maxlength="5">
          </label>
          
          <label style="width:70px;">
              Tipo
              <select name="tipo_av" id="tipo_av">
                  <option value="nota" >Nota</option>
                  <option value="letra" >Letra</option>
                  <option value="conceito">Conceito</option>
              </select>
          </label>          
          <label><br/>
             <button type="button" name="add-av" id="add-av" rel="tip" title="Adicionar Avaliaç&atilde;o"> adicionar </button>
          </label>
          <div style="clear:both;"></div>
          <label style="width:350px; display:none;" class="tipo_conceito"> Ex.: (Bom, Regular, Ótimo ...)
          	<input type="text" name="texto_tipo_avaliacao" id="texto_tipo_avaliacao" maxlength="70">
          </label>
          <br/>
          <div class="tbody-add-av-dados" style="width:100%;" id="tbody-add-av-dados-2">
          <table width="100%" cellpadding="0" cellspacing="0"  class="table-av" >
            <thead>
            	<tr>
                	<td style="width:150px;">Nome Avaliaçao</td>
                    <td style="width:30px;">Ordem</td>
                    <td style="width:60px;">Tipo</td>
                    <td style="width:40px;"></td>
                </tr>
            </thead>
          <!--</table>
          </div>
         <div class="tbody-add-av-dados" id="tbody-add-av-dados-2" style="width:100%">
         	<table width="100%" cellpadding="0" cellspacing="0"  class="table-av">-->
            	<tbody id="add-av-dados"></tbody>
                <tbody>
                    
                	<?
                    if( !empty($periodo_id) and count($array_av) > 0 ){	
						for($i=0;$i < count($array_av);$i++ ){
							$total++;
							if($total%2){$sel='class="al"';}else{$sel='';}
							$tipo = $array_av[$i]["tipo"];
								
							if( !empty($array_av[$i]["texto_tipo_avaliacao"] ) )
								$tipo = $array_av[$i]["texto_tipo_avaliacao"];
								
					?> 
                    <tr id="<?=$array_av[$i]["id"]?>" <?=$sel?>>
                    	<td style="width:150px;"><?=$array_av[$i]["nome"]?></td>
                        <td style="width:30px;"><?=$array_av[$i]["ordem"]?></td>
                        <td style="width:60px;"><?=$tipo?></td>
                    	<td style='width:33px;' class='td_ex'><a href='#' id='remove_av'> excluir </a></td>
                        
                    </tr>	
                	<?
						}
					}
					?>
                </tbody>
         	</table>
         </div>
        </div>
        <?
			}
		?>
        

	</fieldset>
    
    
    
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	<?
	if($periodo->id>0){
	?>
	<input name="action" type="submit" value="Excluir" style="float:left" />
	<?
	}
	?>
	<input name="id" id="bimestre_id" type="hidden" value="<?=$periodo->id?>"/>
    <input name="action" type="submit" id="salvar" onclick="if(document.getElementById('unidade_id').value=='' ){alert('Escolha uma escola.');return false; }"  value="Salvar" style="float:right"  />
	<div style="clear:both"></div>
	</div>
    
    
</form>
</div>
</div>
</div>
<script>top.openForm()</script>