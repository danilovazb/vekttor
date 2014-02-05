<?

//include('../../../../_config.php');
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<style>
.deletar_horario{ color:red; font-weight:bold;}
.deletar_horario:hover{ text-decoration:underline;}
.form_horario .deletar_horario{ display:none;}
</style>
<script>
	$(document).ready(function(){
		$("#dados tr:nth-child(2n+1)").addClass('al');
		
		
		$(".deletar_horario").click(function(){
			
			if(confirm('Deletar horário cadastrado?')){
				id = $(this).attr('data-rel')
				var celula = $(this).parent();
				$.ajax({
					type:'POST',
					url:"modulos/escolar2/cadastros/preenchimento_horarios/preenchimento_horarios.php",
					data:'id='+id+'&action=deletar_horario',
					success: function (data){
						console.log(data);
						celula.html('');
					}
				})
			}
		})
	})
</script>
  <div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s1'>Escolar</a>
        <a href="./" class='s1'>Cadastros</a>
        <a href="./" class='s2'>Organizar Turmas</a>
        <a href="?tela_id=232" class="navegacao_ativo">
			<span></span><?=ucwords($tela->nome)?>
		</a>
</div>
<div id="barra_info">
	<button onclick="location.href='<?=$_SESSION["url_voltar"]?>'">&laquo; Voltar </button>
	<strong>Turma <?=$turma->turma?> | <?=$turma->ensino?> - <?=$turma->serie?> -<?=$turma->horario?> - <?=$turma->sala?> </strong> 
    <? /* ?>
    <form style="float:left;"> 
    <label>Professor
        <select name="professor_id">
        <option value="">Filtre por professor</option>
        <? 
		$prof_q=mysql_query("SELECT DISTINCT(ep.id) as id, rh.nome as nome FROM escolar2_professor_has_turma as ept, escolar2_professores as ep, rh_funcionario as rh WHERE ept.vkt_id='$vkt_id' AND ept.turma_id='$turma->turma_id' AND ep.id=ept.professor_id AND rh.id = ep.funcionario_id ");
		while($p=mysql_fetch_object($prof_q)){
		?>
            <option value="<?=$p->id?>"><?=$p->nome?></option>
        <? } ?>
        </select>
    </label> 
    <label>Matéria
    	<select name="materia_id">
        	<option>Filtre por matéria</option>
        <? 
		$materia_q= mysql_query("SELECT DISTINCT(em.id) AS id, em.nome as materia FROM escolar2_professor_has_turma as ept, escolar2_serie_has_materias as esm, escolar2_materias as em WHERE ept.vkt_id='$vkt_id' AND esm.id = ept.serie_has_materia_id AND em.id = esm.materia_id ");
		while($m=mysql_fetch_object($materia_q)){
		?>
        	<option value="<?=$m->id?>"><?=$m->materia?></option>
        <? } ?>
        </select>
    </label>
    <input type="submit" value="Filtrar" />
    </form>
	<? */ ?>
    <a onclick="escolheProfessor()" target="carregador" class="mais"></a>
	<label style="float:right; margin-right:15px; margin-top:-2px;">Professor
        <select id="professor_id">
        <option>Selecione um professor</option>
        <?
        $professores_q=mysql_query($a="
		SELECT rh.nome as nome, ep.id as id 
		FROM escolar2_unidade_has_professor_horario as eph, escolar2_professores as ep, rh_funcionario as rh
		WHERE eph.vkt_id='$vkt_id' AND eph.unidade_id='{$turma->unidade_id}' AND eph.horario_id='{$turma->horario_id}' AND ep.id = eph.professor_id AND rh.id = ep.funcionario_id ");
		while($p=mysql_fetch_object($professores_q)){
		?>
            <option value="<?=$p->id?>"><?=$p->nome?></option>
        <? } ?>
        </select>
    </label> 
    <script>
    function escolheProfessor(){
		prof_id=$("#professor_id").val()
		if(prof_id>0){
			window.open('<?=$caminho?>/form.php?turma_id=<?=$turma->turma_id?>&professor_id='+prof_id,'carregador');
		}else{
			alert('Selecione um professor');
		}
	}
    </script>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
   <tr>
   	   <td width="50">Tempo</td>
       <td width="200">Segunda</td>
       <td width="200">Terça</td>
       <td width="200">Quarta</td>
       <td width="200">Quinta</td>
       <td width="200">Sexta</td>
       <td width="200">Sábado</td>
       <td width="200">Domingo</td>
       <td></td>
   </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    <? $materias=array("Portugês","Matemática","Física","Química","Inglês","Biologia","Filosofia","Literatura"); ?>
    <? for($i=0;$i<$turma->qtd_materias; $i++){ ?>
			<tr>
            	<td width="50"><?=$i+1?>º</td>
            	<td width="200"><?=$materias_horarios_turma[1][$i]?></td>
                <td width="200"><?=$materias_horarios_turma[2][$i]?></td>
                <td width="200"><?=$materias_horarios_turma[3][$i]?></td>
                <td width="200"><?=$materias_horarios_turma[4][$i]?></td>
                <td width="200"><?=$materias_horarios_turma[5][$i]?></td>
                <td width="200"><?=$materias_horarios_turma[6][$i]?></td>
                <td width="200"><?=$materias_horarios_turma[0][$i]?></td>
                <td></td>
            </tr>
    <? } ?>
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="200">&nbsp;</td>
           <td></td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'>
	Registros 
    <?
	if($_GET[limitador]<1){
		$limitador= 30;	
	}else{
		$limitador= $_GET[limitador];
	}
    $qtd_selecionado[$limitador]= 'selected="selected"'; 
	?>
    <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&pagina=<?=$_GET[pagina]?>&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&limitador='+this.value">
        <option <?=$qtd_selecionado[15]?> >15</option>
        <option <?=$qtd_selecionado[30]?>>30</option>
        <option <?=$qtd_selecionado[50]?>>50</option>
        <option <?=$qtd_selecionado[100]?>>100</option>
  </select>
  Por P&aacute;gina 
  
  
    <div style="float:right; margin:0px 20px 0 0">
    </div>
</div>
