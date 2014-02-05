<?
//Includes
// configuraçao inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho = $tela->caminho; 
print_r($_POST);
print_r($_GET);
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js" type="text/javascript"></script>


<div id='exibe_formulario' class='exibe_formulario'  style="top:30px; left:50px;">
<div id='aSerCarregado'>
<div>
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    <span>Politicos</span></div>
    </div>
<form onsubmit="return validaForm(this)" class="form_float" method="post" autocomplete="off">
<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
<fieldset id='campos_1' >
<legend>
 		<a onclick="aba_form(this,0)"><strong>Dados Principais</strong></a>
		<a onclick="aba_form(this,1)">Dados Politicos</a>
</legend>
  <label style="width:400px;">
    Nome
    <input type="text" id='nome' name="nome" autocomplete='off' maxlength="44" value="<?= $vereador_q->nome ?>"/>
  </label>
  <div style="clear:both"></div>
  <label style="width:120px"> 
  Data de Nascimento
  <input type="text" id='data_nascimento' name="data_nascimento" value="<?= DataUsaToBr($vereador_q->data_nascimento) ?>" autocomplete='off' maxlength="44" mascara='__/__/____'/>
  </label>
  <label style="width:120px">Telefone1 
    <input type="text" id='telefone1' name="telefone1" value="<?= $vereador_q->telefone1 ?>" autocomplete='off' maxlength="44" mascara="(__)____-____"/> 
  </label>
  <label style="width:120px">Telefone 2
  <input type="text" id='telefone2' name="telefone2" value="<?= $vereador_q->telefone2 ?>" maxlength="44" mascara="(__)____-____"/>
  </label>
  <div style="clear:both"</div>
  <label style="width:120px">E-mail
  <input type="text" id='email' name="email" value="<?= $vereador_q->email ?>" maxlength="44"/>
  </label>
  <label style="width:99px">Estado Civil
  <select name="estado_civil" id="estado_civil">
    <option value="casado" <? if($vereador_q->estado_civil=="casado"){echo "selected";}?> >casado(a)</option>
    <option value="divorciado" <? if($vereador_q->estado_civil=="divorciado"){echo "selected";}?>>divorciado(a)</option>
    <option value="separado" <? if($vereador_q->estado_civil=="separado"){echo "selected";}?>>separado(a)</option>
    <option value="solteiro" <? if($vereador_q->estado_civil=="solteiro"){echo "selected";}?>>solteiro(a)</option>
    <option value="ue" <? if($vereador_q->estado_civil=="ue"){echo "selected";}?>>Uniao Estavel</option>
    <option value="viuvo" <? if($vereador_q->estado_civil=="viuvo"){echo "selected";}?>>Viuvo(a)</option>
  </select>
  </label>
  
  <label style="width:142px">
  Naturalidade
  <input type="text" id='naturalidade' name="naturalidade" value="<?= $vereador_q->naturalidade?>" autocomplete='off' maxlength="44"/>
  </label>
  <div style="clear:both"></div>
  <label style="width:80px">
   CEP<input type="text" id='cep' name="cep" value="<?= $vereador_q->cep?>" maxlength="44" busca='modulos/eleitoral/colaborador/busca_endereco.php,@r0,@r0-value>cep|@r1-value>endereco|@r2-value>bairro|@r3-value>cidade|@r4-value>estado|@r5->value>estado'/>
   </label>
  <label style="width:300px">
    Endere&ccedil;o<input type="text" id='endereco' name="endereco" value="<?= $vereador_q->endereco?>" maxlength="44"/>
    </label>
    <div style="clear:both">
   <label   >
    Bairro<input type="text" id='bairro' name="bairro" value="<?= $vereador_q->bairro?>" maxlength="44"/>
    </label>
    <label style="width:150px">
    Cidade<input type="text" id='cidade' name="cidade" value="<?= $vereador_q->cidade?>" maxlength="44"/>
    </label>
    <label style="width:75px">
   	UF<input name="estado" id="estado" type="text"  value="<?= $vereador_q->uf?>"/>
   </label>
</fieldset>

<fieldset id='campos_2' style="display: none" >
  <legend>
		<a onclick="aba_form(this,0)">Dados Principais</a>
		<a onclick="aba_form(this,1)"><strong>Dados Politicos</strong></a>
  </legend>
	<label>
    	Cargo Pretendido<select name="cargo">
        	<option value="vereador" <? if($vereador_q->cargo=="vereador"){echo "selected";}?>>Vereador</option>
            <option value="prefeito" <? if($vereador_q->cargo=="prefeito"){echo "selected";}?>>Prefeito</option>
            <option value="Deputado Estadual" <? if($vereador_q->cargo=="Deputado Estadual"){echo "selected";}?>>Deputado Estadual</option>
            <option value="Deputado Federal" <? if($vereador_q->cargo=="Deputado Federal"){echo "selected";}?>>Deputado Federal</option>
            <option value="governador" <? if($vereador_q->cargo=="governador"){echo "selected";}?>>Governandor</option>
            <option value="senador" <? if($vereador_q->cargo=="senador"){echo "selected";}?>>Senador</option>
            <option value="presidente" <? if($vereador_q->cargo=="presidente"){echo "selected";}?>>Presidente</option>
        </select>
    </label>
    <label style="width:170px;">
        Partido<select name="partido_id">
		<?
			$partidovereador='';
			if($vereador_q->id>0){
				$partidovereador=mysql_fetch_object(mysql_query($trace="SELECT * FROM eleitoral_partidos WHERE id=".$vereador_q->partido_id));
				//echo $trace;
		?> 
        	<option value="<?= $partidovereador->id?>"><?=$partidovereador->sigla." ".$partidovereador->nome ?></option>
        <?
			}else{
		?>
        	<option value="0">Selecione Um Partido</option>
		<?
			}
			$query_q = mysql_query("SELECT * FROM eleitoral_partidos WHERE vkt_id=$vkt_id ORDER BY nome");
			while($partido=mysql_fetch_object($query_q)){
				if($partidovereador->id!=$partido->id){
		?>
               	<option value="<?= $partido->id?>"><?=$partido->sigla." ".$partido->nome ?></option>
        <?
				}
			}
		?>
    	</select>
    </label>
    <div style="clear:both"></div>
    <label style="50px">
    	Slogan <input type="text" name="slogan" id="slogan" value="<?= $vereador_q->slogan?>"/>
    </label>
     <label style="50px">
    	Numero <input type="text" name="numero" id="numero" value="<?= $vereador_q->numero?>"/>
    </label>
    <div style="clear:both"></div>
    <label style="50px">
    	Quantidade de Votos <input type="text" name="qtd_votos" id="qtd_votos" value="<?= $vereador_q->quantidade_votos?>"/>
    </label>
    <label style="width:195px;">
    	Coligacao <select name="coligacao_id">
		<?
			$politicocoligacao='';
			if($vereador_q->id>0){
				$politicocoligacao=mysql_fetch_object(mysql_query($trace="SELECT * FROM eleitoral_coligacoes WHERE id=".$vereador_q->coligacao_id));
				//echo $trace;
		?> 
        	<option value="<?= $politicocoligacao->id?>"><?=$politicocoligacao->nome ?></option>
        <?
			}else{
		?>
        	<option value="0">Selecione Uma Coligacao</option>
		<?
			}
			$query_col = mysql_query("SELECT * FROM eleitoral_coligacoes WHERE vkt_id=$vkt_id ORDER BY nome");
			while($coligacao=mysql_fetch_object($query_col)){
				if($politicocoligacao->id!=$coligacao->id){
		?>
               	<option value="<?= $coligacao->id?>"><?=$coligacao->nome ?></option>
        <?
				}
			}
		?>
    	</select>
    </label>
</fieldset>
<input name="idvereador" type="hidden" value="<?=$vereador_q->id?>" />

<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" ></div>
<!---------------------------------------------------Dados cadastrais----------------------->
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >

<?
if($vereador_q->id>0){
?>
<input name="actionvereador" type="submit" value="Excluir" style="float:left" />
<?
}
?>
<input name="actionvereador" type="submit" value="Salvar" style="float:right"/>
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>