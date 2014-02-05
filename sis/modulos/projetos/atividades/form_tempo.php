<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
pr($_GET);


if($_POST[di]){
	$di = dataBrToUsa($_POST[di]);
	$hi	= $_POST[hi].':00';
	
	$df = dataBrToUsa($_POST[df]);
	$hf	= $_POST[hf].':00';
	
	$tempo = $_POST[tempo].':00';
	
	$inicio = "$di $hi";
	$fim = "$df $hf";	
	
	
	if($_POST[usar]=='tempo'){
		/// calcula o hora fim
		$fim = mysql_result(mysql_query($t="SELECT ADDTIME('$inicio','$tempo')"),0,0);
		//echo "$t<br>";
	}else{
		// calcula tempo	
		$tempo = mysql_result(mysql_query($t="SELECT TIMEDIFF('$fim','$inicio')"),0,0);
		//echo $t."<br>";
	}
	$sql = "UPDATE projetos_atividades_tempo SET inicio='$inicio',fim='$fim',tempo='$tempo' WHERE id='$_POST[id]'";
	//echo $sql."<br>";
	mysql_query($sql);
	
	$soma_horas = @mysql_result(mysql_query($t="SELECT SEC_TO_TIME(sum(TIME_TO_SEC(`tempo`))) FROM projetos_atividades_tempo WHERE atividade_id='$_POST[atividade_id]'"),0,0);

		mysql_query($t="UPDATE projetos_atividades SET	tempo_finalizado_hora='$soma_horas' WHERE id='$_POST[atividade_id]' ");
		//echo $t;
	
	echo "<script>
	top.document.getElementById('carregaform2').innerHTML='';
	window.open('form.php?id=$_POST[atividade_id]&abreaba=1','carregador');
	</script>";
	
	exit();
	
}


$registro = mysql_fetch_object(mysql_query("SELECT *,

		 DATE_FORMAT(inicio,'%d/%m/%Y') AS di,
		 DATE_FORMAT(inicio,'%H:%i') AS hi,
		 DATE_FORMAT(fim,'%H:%i') AS hf,
		 DATE_FORMAT(fim,'%d/%m/%Y') AS df

FROM projetos_atividades_tempo WHERE id='$_GET[id]'"))

?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:400px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Tempo</span></div>
    </div>
	<form onSubmit="return validaForm(this)" target="carregador" action="modulos/projetos/atividades/form_tempo.php" autocomplete='off' class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
            <strong>Informações</strong>

		</legend>
        <input type="hidden" id="id" name="id" value="<?=$registro->id?>" />
        <input type="hidden" id="atividade_id" name="atividade_id" value="<?=$registro->atividade_id?>" />
        

        
        
        
        
        <label style="width:80px;" >Data Inicio
          <input name="di" id="di" calendario='1' value="<?=$registro->di;  ?>" mascara='__/__/____'  />
        </label>
        
        <label style="width:70px;" >Hora Inicio
          <input name="hi" id="hi" value="<?=$registro->hi;  ?>" maxlength="5" mascara='__:__'  />
        </label>
              <div style="clear:both; width:100%"></div>
    <label style="width:265px;" >Tempo
          <input name="tempo"  id="tempo" style="width:35px;"  value="<?=substr($registro->tempo,0,5);  ?>" size="5" maxlength="5"  mascara='__:__'  /> 
          <input type="radio" class='selhora' name="usar" style="width:auto; display:inline" value="tempo" checked>
          Usar para calcular hora fim    </label>
       
        <div style="clear:both; width:100%"> </div>
        
        
        <label style="width:80px;" >Data Fim
          <input name="df" id="df" disabled='disabled'   value="<?=$registro->df;  ?>" mascara='__/__/____' calendario='1' />
        </label>
        <label style="width:215px; margin-right:0" >Hora Fim
          <br>
          <input name="hf"disabled='disabled'   id="hf"  style="width:35px;"  value="<?=$registro->hf;  ?>" size="5" maxlength="5"  mascara='__:__'  /> 
          
          <input type="radio" class='selhora'  name="usar" style="width:auto; display:inline" value="fim">Usar para calcular Tempo
      </label>
        <div style="clear:both; width:100%">
        </div>
        

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
<script>top.document.getElementById('carregaform2').innerHTML=document.getElementById('aSerCarregado').innerHTML</script>