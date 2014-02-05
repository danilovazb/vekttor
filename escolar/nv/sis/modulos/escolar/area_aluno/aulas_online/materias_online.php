<?
$aluno_id= $_SESSION['aluno']->id;

?>
<script>
$('.ops').live('click',function(){
	materia_id=$(this).attr('id');
	location = '?tela_id=328&materia_id='+materia_id;
});

</script>
<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'><div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s2'>Escolar</a>
<a href="?tela_id=231" class="navegacao_ativo">
<span></span>Matérias
</a>
</div>
<div id="barra_info">

</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="250">Mat&eacute;rias</td>
           <td>Aulas</td>
         </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">
    
			<tr class="ops">
               <td width="250" id="descricao">Computação Gráfica</td>
               <td>15</td>
            </tr>
            <tr class="al ops">
               <td width="250"  id="descricao">PHP Básico</td>
               <td>12</td>
            </tr>
            <tr class="ops">
               <td width="250" id="descricao">PHP Avançado</td>
               <td>18</td>
            </tr>
            <tr class="al ops">
               <td width="250"  id="descricao">PHP Profissional</td>
               <td>22</td>
            </tr>
            <tr class="ops">
               <td width="250" id="descricao">Web Design</td>
               <td>5</td>
            </tr>
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="230">&nbsp;</td>
           <td></td>
      </tr>
    </thead>
</table>

</div>
<script>
$("#modulo_id").change(function(t){
	modulo_id=$(this).val();
	location='?tela_id=327&modulo_id='+modulo_id;
})
</script>
<div id='rodape'>
  <div style="float:right; margin:0px 20px 0 0"></div>
</div>
