<?
$aluno_id= $_SESSION['aluno']->id;

?>
<script>
$('.ops').live('click',function(){
	salamateria_id=$(this).attr('id');
	location = '?tela_id=287&salamateria_id='+salamateria_id;
});

</script>
<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'><a href="?tela_id=231" class='s1'>
  	Sistema NV
</a>
<a href="?tela_id=231" class='s2'>
    Escolar 
</a>
<a href="?tela_id=231" class="navegacao_ativo">
<span></span>Mat�rias
</a>
</div>
<div id="barra_info">
  <select name="modulo_id" id='modulo_id'  >
    <option></option>
  </select>
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
<script>resize()</script><!-- Isso � Necess�rio para a cria��o o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">
    <tbody>
    	<tr>
        	<td width="250" id="descricao">Computa��o Gr�fica</td>
            <td>15</td>
        </tr>
        <tr>
        	<td width="250" id="descricao">PHP B�sico</td>
            <td>15</td>
        </tr>
        <tr>
        	<td width="250" id="descricao">PHP Avan�ado</td>
            <td>15</td>
        </tr>
        <tr>
        	<td width="250" id="descricao">PHP Profissional</td>
            <td>15</td>
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
