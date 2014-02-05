<?php

date_default_timezone_set('America/Manaus');



include("../../../../_config.php");

include("../../../../modulos/sysms/InstanceWindow.php");

	

	$disponivel = $statusSMS->SMSDisponivel($vkt_id);

	$eleitores   = $statusSMS->NumeroEleitores();   //Retorna o numero de eleitores

	$politico    = $statusSMS->NumeroPoliticos();   //Retorna o numero de ladrao

	

	$colaborador = $statusSMS->SelectNumTable(1,'eleitoral_colaboradores'); //Retorna o numero de Colaborador

			

	

?>

<style>

input,textarea{ display:block;}

</style>



<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />

<div>

<div id='aSerCarregado'>

<div style="width:400px">

<div>

	<div class='t3'></div>

	<div class='t1'></div>

    <div  class="dragme" >

	<a class='f_x' onClick="form_x(this)"></a>

    

    <span>Atividade</span></div>

    </div>

	<form onSubmit="return validaForm(this)"  autocomplete='off' class="form_float" method="post" name="smsEnvia" id="smsEnvia" >

    <input type="hidden" name="vkt" value="<?php echo $vkt_id;?>">

	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->

	<fieldset  id='campos_1' >

    

		<legend>

			<strong id='escreve'>Enviar SMS</strong>

		</legend>

       

        

        

        <div id="inicio" style="#">

        

        		<div style="margin:3px; padding:3px;">Mensagem</div>

                <div>

                    <textarea name="msg" id="msg" rows="5" cols="30"></textarea>

                </div>

        

       

        </div>

        

        <div style="padding:5px; margin:5px;"> Grupos: </div>

        <div>

        	<div>

                <input type="checkbox" name="eleitor" class="items" value="1" id="grupo">Eleitores

                <span style="float:right">N&ordm;: <?php echo $eleitores; ?></span>

            </div>

            

            <div>

            	<input type="checkbox" name="politico" class="items" value="2" id="grupo">Pol&iacute;ticos

                <span style="float:right">N&ordm;: <?php echo $politico; ?></span>

            </div>

        	<div>

            	<input type="checkbox" name="colaborador" class="items" value="3" id="grupo">Colaboradores

                <span style="float:right">N&ordm;: <?php echo $colaborador; ?></span>

            </div>

            

        </div>

        

  

             		

	</fieldset>



<!--Fim dos fiels set-->



<div style="width:100%; text-align:center" >



<div id="resultSMS" style="position:relative;background:#28C15E; display:none; margin:2px; padding:0px;"></div>





<button type="button" style="float:right" id="enviaAdd" >Enviar</button>



<div style="clear:both"></div>

</div>

</form>

</div>

</div>

</div>

<script>top.openForm()</script>