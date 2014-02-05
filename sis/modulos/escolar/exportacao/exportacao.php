<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho;
function converte_numeros_comvirgula_em_dias_semanas($dias,$semana_abreviado){
	
	$dias = explode(',',$dias );
	
	for($i=0;$i<count($dias);$i++){
		$dias_semana[] = $semana_abreviado[$dias[$i]];	
	}
	return implode(', ',$dias_semana);
} 
?>
<script>
$(function(){
	some_menu();	
});

function change(){
	de = $("#de").val();
	ate = $("#ate").val();
	escola = $('#escola').val();
	curso = $('#curso').val();
	modulo = $('#modulo').val();
	horario = $('#horario').val() 
	sala= $('#sala').val();
	location.href='?tela_id=216&de='+de+'&ate='+ate+'&escola='+escola+'&curso='+curso+'&modulo='+modulo+'&sala='+sala+'&horario_id='+horario+'&carregador=1';
}
</script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
 <div id="navegacao">
       
         <div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s2'>Escolar</a>
        <a href="?tela_id=216" class="navegacao_ativo"><span></span>Exportação</a>
    </div>
</div>
<div id="barra_info">
De<input type="text" name="de" id="de" sonumero="1" calendario="1" value="<?=$_GET['de']?>" mascara="__/__/____" size="7"/>
Ate<input type="text" name="ate" id="ate" sonumero="1" calendario="1" value="<?=$_GET['ate']?>" mascara="__/__/____" size="7"/>

<select id='escola' style="width:150px;" onchange="change()">
<?
echo "<option value='0'>Selecione Uma Escola</option>";
$q=mysql_query("SELECT * FROM escolar_escolas WHERE vkt_id='$vkt_id' ORDER BY nome");
while($r=mysql_fetch_object($q)){
?>
<option value='<?=$r->id?>' <? if($_GET['escola']==$r->id){echo "selected=selected";}?>><?=$r->nome?></option>
<?
}
?>
</select>

<select id='curso' style="width:150px;" onchange="change()">
<option value='0'>Selecione Um Curso</option>
<?
$escola="AND em.escola_id=".$_GET['escola'];
$q=mysql_query($t="SELECT DISTINCT(nome), em.curso_id as c_id FROM escolar_cursos ec INNER JOIN escolar_matriculas em ON ec.id=em.curso_id WHERE em.vkt_id='$vkt_id' $escola ORDER BY ec.nome");
			
while($r=mysql_fetch_object($q)){
?>
<option value='<?=$r->c_id?>' <? if($_GET['curso']==$r->c_id){echo 'selected==selected';}?>><?=$r->nome?></option>
<?
}
?>
</select>
 
<select id='modulo' name='modulo' style="width:150px;" onchange="change()">
<option value='0'>Selecione Um Modulo</option>
<?
$curso="AND curso_id=".$_GET['curso'];
$q=mysql_query("SELECT * FROM escolar_modulos WHERE vkt_id='$vkt_id' $curso ORDER BY nome");
while($r=mysql_fetch_object($q)){
?>
<option value='<?=$r->id?>' <? if($_GET['modulo']==$r->id){echo 'selected==selected';}?>><?=$r->nome?></option>
<?
}
?>
</select>
</div>
<div id="barra_info">
<select id='horario' name='horario' style="width:150px;">
<option value=''>Selecione Um Horário</option>
<?
//$sala = "AND es.id=".$_GET['sala'];
$modulo="AND modulo_id=".$_GET['modulo'];
$q=mysql_query($t="SELECT id,nome as horario FROM escolar_horarios 
				WHERE vkt_id='$vkt_id' AND escola_id='".$_GET['escola']."' AND curso_id='".$_GET['curso']."' AND modulo_id='".$_GET['modulo']."' ORDER BY nome");
// SELECT h.* FROM escolar_horarios as h WHERE h.periodo_id = '1' AND h.escola_id='5' AND h.curso_id='47' AND h.modulo_id ='1' 
//echo $t;
//alert($t."<br>");
while($r=mysql_fetch_object($q)){
?>
<option value='<?=$r->h_id?>' <? if($_GET['horario']==$r->h_id){echo 'selected==selected';}?>><?=$r->horario?></option>
<?
}
?>
</select>

<select id='sala' name='sala'style="width:150px;" onchange="change()">
<option value='0'>Selecione Uma Sala</option>
<?
//$modulo="AND modulo_id=".$_GET['modulo'];
$q=mysql_query($t="SELECT * FROM escolar_salas WHERE vkt_id='$vkt_id' AND curso_id='".$_GET['curso']."' AND escola_id='".$_GET['escola']."' AND modulo_id='".$_GET['modulo']."' ORDER BY nome");

while($r=mysql_fetch_object($q)){
	
?>
<option value='<?=$r->id?>' <? if($_GET['sala']==$r->id){echo 'selected==selected';}?>><?=$r->nome?></option>
<?
}
?>
</select>

<input type="button" name="exp_aluno" value="Exportar Aluno" onclick="location='?tela_id=216&escola_id='+document.getElementById('escola').value+'&cursos_id='+document.getElementById('curso').value+'&de='+document.getElementById('de').value+'&ate='+document.getElementById('ate').value+'&modulo='+document.getElementById('modulo').value+'&sala='+document.getElementById('sala').value+'&horario='+document.getElementById('horario').value+'&acao='+this.value"/>
<input type="button" name="exp_reponsavel" value="Exportar Responsável" onclick="location='?tela_id=216&escola_id='+document.getElementById('escola').value+'&cursos_id='+document.getElementById('curso').value+'&de='+document.getElementById('de').value+'&ate='+document.getElementById('ate').value+'&modulo='+document.getElementById('modulo').value+'&sala='+document.getElementById('sala').value+'&horario='+document.getElementById('horario').value+'&acao='+this.value"/>
<input type="button" name="exp_boleto" value="Exportar Boleto" onclick="location='?tela_id=216&escola_id='+document.getElementById('escola').value+'&cursos_id='+document.getElementById('curso').value+'&de='+document.getElementById('de').value+'&ate='+document.getElementById('ate').value+'&modulo='+document.getElementById('modulo').value+'&sala='+document.getElementById('sala').value+'&horario='+document.getElementById('horario').value+'&acao='+this.value"/>
<script>
document.getElementById('escola').value='<?=$_GET[escola_id]?>'
document.getElementById('curso').value='<?=$_GET[cursos_id]?>'
</script>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           
          <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<?
if($_GET[acao]=="Exportar Aluno"){
	include('exportar_alunos.php');
}
if($_GET[acao]=="Exportar Responsável"){
	include('exportar_reponsaveis.php');
}
if($_GET[acao]=="Exportar Boleto"){
	include('exportar_boleto.php');
}
?>

<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	
	
      <td></td>
        </tr>
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td></td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'>
</div>


