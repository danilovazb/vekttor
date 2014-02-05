<?php
include("../../../_config.php");
include("../../../_functions_base.php");
global $vkt_id;
	$aluno       = mysql_fetch_object(mysql_query("select * from escolar_alunos WHERE id = ".$_GET['id']." AND vkt_id='$vkt_id'"));
	$matricula  = mysql_fetch_object(mysql_query("select * from escolar_matriculas WHERE aluno_id = ".$_GET['id']." AND vkt_id='$vkt_id' ORDER BY id DESC LIMIT 1"));
	$periodo   = mysql_fetch_object(mysql_query("select * from escolar_periodos WHERE id = ".$matricula->periodo_id." AND vkt_id='$vkt_id'"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
<title>Ficha de Matricula</title>
<style>
* { margin:0; padding:0;}
body{font-family:Tahoma, Geneva, sans-serif;background:#999999;}
div span{ padding:5px;}
table tr td#linha{border-bottom:1px solid #000;}
td{padding:4px;}
td div{ border-bottom:1px solid #000;}
#container{
	width:800px;border:1px solid #333; background:#FFF; box-shadow:1px 1px 1px #333333; padding:3px;
	margin-left:5px; max-height:100%;
	}
</style>
</head>

<body>
<div style="margin-top:8px;"></div>
<div id="container">
<div style="width:780px;">

<div style="margin-top:10px;"></div>
<div style="border:1px solid #333; float:right; width:3cm; height:4cm; overflow:hidden; text-align:center;">
                <img src='img/<?=$aluno->id?>.<?=$aluno->extensao?>'  style="height:4cm;" />
</div>
<div style=" text-align:center; margin:0px auto; font-weight:bold;">FICHA DE MATRICULA / <?=$periodo->nome?></div>

<div style="margin-top:50px;"></div>       
        <!--<div style="width:500px;"> Nome do aluno: <span style="width:400px;">JAIME BARROSO NEVES </span> Data de Nasc: 18/01/1988 </div>-->
        <div style="font-size:14px;">
        	<table style="width:84%">
            	<tr>
                	<td> Nome do Aluno:<div style="float:right; width:343px;">&nbsp;<?=$aluno->nome?></div> </td>
                    <td> Data de Nasc:<div style="float:right; width:90px; text-align:center;">&nbsp;<?=dataUsaToBr($aluno->data_nascimento)?></div></td>
                </tr>
            </table>
        </div>
        <div style="margin-top:5px;"></div>
        <!-- inicio -->
            <div style="padding:5px; font-size:14px;">
                Cor: <span>(<? if($aluno->cor == 'branco') echo 'X';?>)Branco</span> 
                     <span>(<? if($aluno->cor == 'pardo-moreno') echo 'X';?>)Pardo/Moreno</span> 
                     <span>(<? if($aluno->cor == 'negro') echo 'X';?>)Negro</span> 
                     <span>(<? if($aluno->cor == 'amarelo') echo 'X'; ?>)Amarelo</span> 
                     <span>(<? if($aluno->cor == 'indigena') echo 'X';?>)Indigena</span> 
                     <span>(<? if($aluno->cor == 'naodeclarado') echo 'X';?>)Nao Declarado</span>        
            </div>
        <!-- fim -->
        <div style="margin-top:5px;"></div>
        <div style="padding:2px; font-size:14px;">
        	<table style="width:100%">
                  <tr>
                    <td >Endereço:<div style="float:right; width:331px;">&nbsp;<?=$aluno->endereco?></div></td>
                    <td>Complemento:<div style="float:right; width:255px;">&nbsp;<?=$aluno->complemento?></div></td>
                  </tr>
                  <tr>
                    <td width="400">Bairro:<div style="float:right; width:355px;">&nbsp;<?=$aluno->bairro?></div></td>
                    <td>Telefone Res.:<div style="float:right; width:260px;">&nbsp;<?=$aluno->telefone1?></div></td>
                  </tr>
			</table>
        </div>
        <div style="padding:2px;font-size:14px;">
        	<table style="width:100%">
                  <tr>
                  	<?php
						$turma=mysql_fetch_object(mysql_query("select * from escolar_salas WHERE id = ".$matricula->sala_id));
						$horario=@mysql_fetch_object(mysql_query($t="SELECT * FROM escolar_horarios WHERE id = ".$turma->horario_id));
						//echo $t."<br>";
					?>
                    <td>Turma:<div style="float:right; width:280px;">&nbsp;<?=$turma->nome?></div></td>
                    <td>Turno:<div style="float:right; width:140px;">&nbsp;<?=$horario->nome?></div></td>
                    <td>Sexo:<div style="float:right; width:160px;">&nbsp;</div></td>
                  </tr>
				</table>
        </div>
        <div style="padding:2px; font-size:14px;"> <!-- FILIAÇAO MAE -->
        	<table style="width:100%">
                  <tr>
                    <td>Filiaçao: Mae<div style="float:right; width:475px;">&nbsp;<?=$aluno->mae?></div></td>
                    <td>CPF:<div style="float:right; width:160px;">&nbsp;<?=$aluno->cpf_mae?></div></td>
                  </tr>
             </table>
             <table style="width:100%">
                  <tr>
                    <td>Profissao:<div style="float:right; width:700px;">&nbsp;<?=$aluno->profissao_mae?></div></td>
                  </tr>
             </table>
             <table style="width:100%">
                  <tr>
                  	<td>Local de Trabalho:<div style="float:right; width:430px;">&nbsp;<?=$aluno->local_trabalho_mae?></div></td>
                    <td>Tel:<div style="float:right; width:178px;">&nbsp;<?=$aluno->tel_trabalho_mae?></div></td>
                  </tr>
                  <tr>
                  	<td>Email:<div style="float:right; width:510px;">&nbsp;<?=$aluno->email_mae?></div></td>
                    <td>Cel:<div style="float:right; width:175px;">&nbsp;<?=$aluno->tel_mae?></div></td>
                  </tr>
			</table>
        </div>
        <div style="padding:2px; font-size:14px;"> <!-- FILIAÇAO PAI -->
        	<table style="width:100%">
                  <tr>
                    <td>Filiaçao: Pai <div style="float:right; width:475px;">&nbsp;<?=$aluno->pai?></div></td>
                    <td>CPF:<div style="float:right; width:165px;">&nbsp;<?=$aluno->cpf_pai?></div></td>
                  </tr>
              </table>
              <table style="width:100%">
                  <tr>
                    <td>Profissao:<div style="float:right; width:700px;">&nbsp;<?=$aluno->profissao_pai?></div></td>
                  </tr>
               </table>
               <table style="width:100%">
                  <tr>
                  	<td>Local de Trabalho:<div style="float:right; width:430px;">&nbsp;<?=$aluno->local_trabalho_pai?></div></td>
                    <td>Tel:<div style="float:right; width:170px;">&nbsp;<?=$aluno->tel_trabalho_pai?></div></td>
                  </tr>
                  <tr>
                  	<td>Email:<div style="float:right; width:510px;">&nbsp;<?=$aluno->email_pai?></div></td>
                    <td>Cel: <div style="float:right; width:170px;">&nbsp;<?=$aluno->tel_pai?></div></td>
                  </tr>
			</table>
        </div>
        <div style="padding:8px; font-size:14px;"><!-- INICIO -->
        		<div style="font-size:12px;">Pessoa(as) que virá(ao) trazer e buscar a criança? (Nome e documento)</div>
                <div>
                	<table style="width:100%">
                          <tr>
                            <td >1.<div style="float:right; width:390px;">&nbsp;<?=$aluno->pessoa_trazer_buscar_1?></div></td>
                            <td>2.<div style="float:right; width:315px;">&nbsp;<?=$aluno->pessoa_trazer_buscar_2?></div></td>
                          </tr>
                          <tr>
                            <td>3.<div style="float:right; width:395px;">&nbsp;<?=$aluno->pessoa_trazer_buscar_3?></div></td>
                            <td>4.<div style="float:right; width:315px;">&nbsp;<?=$aluno->pessoa_trazer_buscar_4?></div></td>
                          </tr>
					</table>
                    <div style="font-size:12px; margin-left:5px;">
                    	Obs: Pessoas nao autorizadas nesta lista nao irao retirar a criança da escola  
                    </div>
                </div>
        </div><!-- FIM -->
        
        <div style="padding:8px; font-size:14px;">
        		<div style="font-size:12px;">No caso de emergencia ou ocorrencia, chamar por: </div>
                <div>
                	<table style="width:100%">
                          <tr>
                            <td>1.<div style="float:right; width:385px;">&nbsp;<?=$aluno->pessoa_caso_emergencia_1?></div></td>
                            <td >Fones:<div style="float:right; width:285px;">&nbsp;<?=$aluno->telefone_caso_emergencia_1?></div></td>
                          </tr>
                          <tr>
                            <td>2.<div style="float:right; width:390px;">&nbsp;<?=$aluno->pessoa_caso_emergencia_2?></div></td>
                            <td>Fones:<div style="float:right; width:290px;">&nbsp;<?=$aluno->telefone_caso_emergencia_2?></div></td>
                          </tr>
					</table>
                </div>
        </div>
        <div style="padding:8px; font-size:13px; margin-left:5px;">Restriçao Alimentar/Alergia?</div>
        <div style="margin-top:2px; padding:5px;"></div>
        <div style="border-bottom:1px solid #000; width:765px; margin-left:5px;"><?=$aluno->restricao_alimentar?></div>
        <div style="margin-top:10px; padding:5px;"></div>
        
        <div style="margin-top:2px; padding:5px;"></div>
        <div style="border-bottom:1px solid #000; width:300px; margin-left:5px; float:right; margin-right:10px;"></div>
        <div style="margin-top:5px; padding:5px;"></div>
        <div style="float:right; margin-right:60px;font-size:13px;">Assinatura de Responsável</div>
        <div style="margin-top:2px; padding:15px;"></div>
 </div>       
</div><!-- FIM DE CONTAINER -->
</body>
</html>