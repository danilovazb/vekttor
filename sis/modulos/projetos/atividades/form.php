<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("_function_atividade.php");
include("_ctrl_atividade.php"); 
pr($_GET);
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:700px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Atividade</span></div>
    </div>
	<form onSubmit="return validaForm(this)" autocomplete='off' class="form_float" method="post" target="carregador" action="modulos/projetos/atividades/form.php?id=<?=$_GET[id]?>&tela_id=<?=$_GET[tela_id]?>">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
            <a onclick="aba_form(this,0)" id='marcadoraba'><strong>Informações</strong></a>
    <a onclick="aba_form(this,1)">Tempos</a>

		</legend>
        <input type="hidden" id="id" name="id" value="<?=$registro->id?>" />
        <input type="hidden" id="oldstatus" name="oldstatus" value="<?=$_GET[oldstatus]?>" />
        

        <label style="width:150px;">
			<strong style="display:block;">Cliente</strong>
<span><?=$razao_social?></span>
		</label>
        <label style="width:250px; " > Nome do Projetosx
            
            <select name= 'projeto_id'>
            <?

$q=mysql_query($as="SELECT * FROM projetos WHERE vkt_id ='$vkt_id' AND nome LIKE '%$_GET[busca_auto_complete]%' ORDER BY nome");
echo $as;
$i=0;
while($r= mysql_fetch_object($q)){
			if($r->id==$registro->projeto_id){ $select="selected='selected'";}else{$select='';}
	?>
    <option value="<?=$r->id?>"<?=$select?>><?=$r->nome?></option>
    <?
}
	?>
            </select>
     </label>
        
        
        <label style="width:150px; margin-right:0px;"   >Tipo Atividade
        	<select name="tipo_atividade_id">
            
            <? 
			$a_q = mysql_query("SELECT nome,id FROM projetos_atividades_tipos ");
			while($a=mysql_fetch_object($a_q)){ 
			
			if($a->id==$registro->atividade_tipo_id){ $select="selected='selected'";}else{$select='';}
			?>
            <option <?=$select?> value="<?=$a->id?>"><?=$a->nome?></option>
            <? } ?>
            </select>
        </label>
        

<!-- 
background:url(../fontes/img/st2.png);  -->
<div style="clear:both;"></div>
        <div id='formstar' style="<? if($registro->prioridade==1){echo "background:url(../fontes/img/st.png);";}else{echo "background:url(../fontes/img/st2.png);";}?> float: left; margin-top:14px; "><input style="width:auto" type="hidden" name="prioridade" value='<?=$registro->prioridade?>'></div><label style="width:590px; margin-right: 0px;display:block;" >Atividade<br>
          
          <input name="nome_atividade" value="<?=str_replace('"','`',$registro->nome);?>" style="font-size:16px;  width:564px; float:left" />
        </label>
        <div style="clear:both; width:100%"></div>
        <label style="width:600px;">
          Descricao
          <textarea name="descricao_atividade" id="descricao_atividade"><?=$registro->descricao;?></textarea>
		</label>
        <label style="width:600px;">
          Texto por quem executo
         <div style="color:#555; padding:5px; margin-top:14px; font-size:12px; background:#F4F1D6; border:1px solid #CDCDCD; border-radius:5px; max-height:200px; overflow:auto"><?=nl2br($registro->comentario_executor);?></div>
		</label>
        
		<label style="width:50px;" >Tempo
               <input name="tempo" value="<?=substr($registro->tempo_estimado_horas,0,5);?>" />
        </label>

        <label style="width:100px;" >
	Situação
       
       <select name="situacao">
<option <? if($registro->situacao=='0'){echo 'selected';} ?> value="0">Para ser executada</option>
 <option <? if($registro->situacao=='2'){echo 'selected';} ?> value="2">Em Andamento</option>
   <option <? if($registro->situacao=='2'){echo 'selected';} ?> value="3">Em Espera por alguem</option>
   <option <? if($registro->situacao=='1'){echo 'selected';} ?> value="1">Completo</option>
    
       </select>
		</label>
        
        
        <label style="width:150px;" >
        Quem executar&aacute;
          <select name="funcionario_id">
        <?
        $funcionarios_q=mysql_query("SELECT * FROM usuario WHERE cliente_vekttor_id ='$vkt_id'");
		while($f=mysql_fetch_object($funcionarios_q)){
			if($registro->funcionario_id==$f->id){ $select="selected='selected'";}else{$select='';}

		?>
        <option value="<?=$f->id?>"<?=$select?>><?=$f->nome?></option>
        <? } ?>
        </select>
        </label>
        <label style="width:150px;" >
        Quem é o Responsável
          <select name="usuario_id_cadastrou">
        <?
        $funcionarios_q=mysql_query("SELECT * FROM usuario WHERE cliente_vekttor_id ='$vkt_id'");
		while($f=mysql_fetch_object($funcionarios_q)){
			if($registro->usuario_id_cadastrou==$f->id){ $select="selected='selected'";}else{$select='';}

		?>
        <option value="<?=$f->id?>"<?=$select?>><?=$f->nome?></option>
        <? } ?>
        </select>
        <div style="color:#CCC; font-size:10px">Somente o responsável poderá alterar os dados</div>
        </label>

        
        
        
        
        <label style="width:70px; margin-left:0" >Data Limite
          <input name="data_limite" id="data_limite" value="<?=dataUsaToBr($registro->data_limite);  ?>" mascara='__/__/____' calendario='1' />
        </label>
        <div style="clear:both; width:100%"></div>
         <label style="width:70px; margin-left:0" >Sequancia
          <input name="ordenacao_funcionario" id="ordenacao_funcionario" value="<?=$registro->ordenacao_funcionario;  ?>" />
        </label>
       <?
        if($registro->situacao==1){ 
		 ?>       
         Atividade concluida em 
		 <? if($registro->dias_concluidas>0){ 
		 		
		 ?> 
		      <strong><?=$registro->dias_concluidas;?></strong>   dias e 
         <? } ?>
		 <strong><?=substr($registro->horas_concluidas,0,5);?></strong> horas depois de ser cadastrada
         <?
		}
		 ?>
	</fieldset>
    <fieldset  id='campos_2' style="display:none">
        <legend>
            <a onclick="aba_form(this,0)">Informações</a>
    		<a onclick="aba_form(this,1)"><strong>Tempos</strong></a>
        </legend>
        <table width="253">
         <tr>
           <td align="center"><strong>Data</strong></td>
         	<td align="center"><strong>Inicio</strong></td>
         	<td align="center"><strong>Fim</strong></td>
         	<td align="center"><strong>Tempo</strong></td>
         </tr>
         <?
         
		 $qt = mysql_query($t="SELECT 
		 *,
		 DATE_FORMAT(inicio,'%H:%i') AS i,
		 DATE_FORMAT(fim,'%H:%i') AS f,
		 DATE_FORMAT(fim,'%d/%m') AS d,
		 DATE_FORMAT(fim,'%w') AS s,
		 TIMEDIFF(fim,inicio) as t,
		 TIME_TO_SEC(TIMEDIFF(fim,inicio)) as tempo
		 
		 
		  FROM projetos_atividades_tempo WHERE atividade_id ='$registro->id' ");
		  $tttt=0;
		 while($rt= mysql_fetch_object($qt)){
		  $tttt += $rt->tempo ; 
		 ?>
         <tr  class='opt' i='<?=$rt->id?> '>
           <td align="center"><?=$semana_abreviado[$rt->s]?> <?=$rt->d?></td>
         	<td align="center"><?=$rt->i?></td>
         	<td align="center"><?=$rt->f?></td>
         	<td align="center"><?=substr($rt->t,0,5)?></td>
         </tr>
         <?
         }
		 ?>
         <tr>
           <td colspan="3" align="right"><strong>Total</strong></td>
           <td align="center"><strong><?=substr(mysql_result(mysql_query("SELECT SEC_TO_TIME($tttt)"),0,0),0,5)?></strong></td>
         </tr>
         </table>
    </fieldset>
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($registro->id>0){
?>
<input name="action" type="submit" value="Excluir" style="float:left" />
<?
}
?>
<input name="action" type="submit"  value="Salvar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>
top.openForm();
<?
if($_GET[abreaba]){
?>
top.aba_form(top.document.getElementById('marcadoraba'),<?=$_GET[abreaba]?>);
<?
}
?>
</script>