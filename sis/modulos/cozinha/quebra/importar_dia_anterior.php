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
        <select name="ficha_id[]" style="height:15px; width:130px;  margin:0; padding:0;">
            <option value="0">Escolha uma ficha</option>
            <? 
            $fichas_q=mysql_query("SELECT * FROM cozinha_fichas_tecnicas WHERE FIND_IN_SET ('{$_GET[refeicao]}',refeicao) AND vkt_id='$vkt_id' ");
            while($ficha=mysql_fetch_object($fichas_q)){
            if($item->ficha_id==$ficha->id){$sel='selected="selected"';}else{$sel='';}
            ?>
            <option <?=$sel?> value="<?=$ficha->id?>"><?=$ficha->nome?></option>
            <? } ?>
        </select>
    </td>
    <td>
    	<input type="text" name="pessoas[]" style="height:10px;" onkeyup="adicionaFicha(this)" sonumero="1" value="<?=$item->pessoas?>"  size="5" />
    </td>
    <td><a href="#" onclick="retiraFicha(this)" style="color:red;">X</a></td>
</tr>
<? } ?>
<tr>
                <td>
                    <select name="ficha_id[]" style="height:15px; width:130px;  margin:0; padding:0;">
                    <option value="0">Escolha uma ficha</option>
                    <? 
						$fichas_q=mysql_query("SELECT * FROM cozinha_fichas_tecnicas WHERE FIND_IN_SET ('{$_GET[refeicao]}',refeicao) ");
						while($ficha=mysql_fetch_object($fichas_q)){
					?>
                    	<option value="<?=$ficha->id?>"><?=$ficha->nome?></option>
                    <? } ?>
                    </select>
                </td>
                <td>
                    <input type="text" name="pessoas[]" style="height:10px;" onkeyup="adicionaFicha(this)" sonumero="1" value=""  size="5" />
                </td>
                <td><a href="#" onclick="retiraFicha(this)" style="color:red;">X</a></td>
            </tr>