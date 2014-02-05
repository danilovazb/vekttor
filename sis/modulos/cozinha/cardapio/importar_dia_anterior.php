<?
include '../../../_config.php';
$itens_dia_q=mysql_query("SELECT 
			f.nome as ficha, f.id as ficha_id, c.pessoas as pessoas 
		FROM 
			cozinha_cardapio_dia_refeicao as c, cozinha_fichas_tecnicas as f 
		WHERE 
			f.id=c.ficha_tecnica_id
			AND contrato_id='{$_GET[contrato_id]}' 
			AND data=DATE_SUB('{$_GET[data]}', INTERVAL 1 DAY)
			AND c.vkt_id='$vkt_id'
			AND  FIND_IN_SET('{$_GET[refeicao]}',tipo_refeicao) ");
			while($item=mysql_fetch_object($itens_dia_q)){
?>
<tr>
    <td>
        <select name="ficha_id[]" style=" width:130px;  margin:0; padding:0;" >
                    <option value="0">Escolha uma ficha</option>
                    <? 
						$fichas_q=mysql_query($t="
							SELECT 
								*,cft.id as ficha_id, ccg.nome as grupo_nome,cft.nome as ficha_tecnica_nome 
							FROM 
								cozinha_fichas_tecnicas cft,
								cozinha_cardapios_grupos ccg 
							WHERE 
							ccg.vkt_id='$vkt_id' AND
							ccg.id=cft.grupo_cardapio_id AND
							cft.exibir_cliente='1' AND 
								FIND_IN_SET 
							('{$_GET[refeicao]}',refeicao)							
							ORDER BY ccg.nome,cft.nome ASC ");
							echo mysql_error();
							$grupo_anterior='';
						while($ficha=mysql_fetch_object($fichas_q)){
							if($item->ficha_id==$ficha->ficha_id){$sel='selected="selected"';}else{$sel='';}
							if($ficha->grupo_cardapio_id!=$grupo_anterior){
								echo utf8_encode("<optgroup label='$ficha->grupo_nome'></optgroup>");
								$grupo_anterior=$ficha->grupo_cardapio_id;
							}
					?>
                    	<option <?=$sel?> value="<?=$ficha->ficha_id?>"><?=utf8_encode($ficha->ficha_tecnica_nome)?></option>
                    <? } ?>
                    </select>
    </td>
    <td>
    	<input type="text" name="pessoas[]" style="height:10px;" onkeyup="adicionaFicha(this)" sonumero="1" value="<?=$item->pessoas?>"  size="5" />
    </td>
    <td><a href="#" onclick="retiraFicha(this)" style="color:red;">X</a></td>
</tr>
<?  } ?>
<tr>
                <td>
                    <select name="ficha_id[]" style=" width:130px;  margin:0; padding:0;" >
                    <option value="0">Escolha uma ficha</option>
                    <? 
						$fichas_q=mysql_query($t="
							SELECT 
								*,cft.id as ficha_id, ccg.nome as grupo_nome,cft.nome as ficha_tecnica_nome 
							FROM 
								cozinha_fichas_tecnicas cft,
								cozinha_cardapios_grupos ccg 
							WHERE 
							ccg.vkt_id='$vkt_id' AND
							ccg.id=cft.grupo_cardapio_id AND
							cft.exibir_cliente='1' AND 
								FIND_IN_SET 
							('{$_GET[refeicao]}',refeicao)							
							ORDER BY ccg.nome,cft.nome ASC ");
							echo mysql_error();
							$grupo_anterior='';
						while($ficha=mysql_fetch_object($fichas_q)){
							if($item->ficha_id==$ficha->ficha_id){$sel='selected="selected"';}else{$sel='';}
							if($ficha->grupo_cardapio_id!=$grupo_anterior){
								echo "<optgroup label='$ficha->grupo_nome'></optgroup>";
								$grupo_anterior=$ficha->grupo_cardapio_id;
							}
					?>
                    	<option <?=$sel?> value="<?=$ficha->ficha_id?>"><?=$ficha->ficha_tecnica_nome?></option>
                    <? } ?>
                    </select>
                </td>
                <td>
                    <input type="text" name="pessoas[]" style="height:10px;" onkeyup="adicionaFicha(this)" sonumero="1" value=""  size="5" />
                </td>
                <td><a href="#" onclick="retiraFicha(this)" style="color:red;">X</a></td>
            </tr>