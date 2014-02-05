<?php

date_default_timezone_set('America/Manaus');



include("../../../../_config.php");

include("../../../../modulos/sysms/InstanceWindow.php");

	

	

	

	//$disponivel = $statusSMS->SMSDisponivel($vkt_id);

	



	

		if(isset($_GET['msg']))

			$msg = $_GET['msg'];

			

		if(isset($_GET['idMsg'])){

				$id_msg = $_GET['idMsg'];

				

			$dados = $statusSMS->SelectTableWhere('eleitoral_sms_falhou','eleitoral_sms_id',$id_msg,2);

			

				if($dados){

				} else{

					exit;

					}

				

		}

				

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

	<form onSubmit="return validaForm(this)"  autocomplete='off' class="form_float" method="post" name="smsEnviaEdit" id="smsEnviaEdit" >

    <input type="hidden" name="vkt" value="<?php echo $vkt_id;?>">

    <input type="hidden" name="id_msg" value="<?php echo $id_msg;?>">

    

    	<?php foreach($dados as $id => $list): ?>

        		<input type="hidden" name="colaborador_id[]" value="<?php echo $list['colaborador_id'];?>">

                <input type="hidden" name="politico_id[]" value="<?php echo $list['politico_id'];?>">

                <input type="hidden" name="eleitor_id[]" value="<?php echo $list['eleitor_id'];?>">

		<?php

				endforeach;

		?>

	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->

	<fieldset  id='campos_1' >

    

		<legend>

			<strong id='escreve'>Edi&ccedil;&atilde;o : Enviar SMS</strong>

		</legend>

       

        

        

        <div id="inicio" style="#">

        

        		<div style="margin:3px; padding:3px;">Mensagem</div>

                <div>

                    <textarea name="msg" id="msg" rows="5" cols="30" readonly="readonly"><?php echo $msg;?></textarea>

                </div>

        

       

        </div>

        

        

        <div style="padding:5px; margin:5px;"> Grupos: N&atilde;o Enviados </div>

        <div>

        	<div>

            <?php $t_eleitor = $statusSMS->VerificaNumMsg($id_msg,'eleitor_id','eleitoral_sms_falhou');?>

            	<div> Eleitor: <?php echo $t_eleitor;?> </div>

            </div>

            

            <div>

            <?php $t_politico = $statusSMS->VerificaNumMsg($id_msg,'politico_id','eleitoral_sms_falhou');?>

            	<div> Pol&iacute;tico: <?php echo $t_politico;?> </div>

            </div>

            

        	<div>

            <?php $t_colaborador = $statusSMS->VerificaNumMsg($id_msg,'colaborador_id','eleitoral_sms_falhou');?>

            	<div> Colaborador: <?php echo $t_colaborador?> </div>

            </div>

            

        </div>

        

  

             		

	</fieldset>



<!--Fim dos fiels set-->



<div style="width:100%; text-align:center" >



<div id="resultSMS" style="position:relative;background:#28C15E; display:none; margin:2px; padding:0px;"></div>





<button type="button" style="float:right" id="reenviaform" >Reenviar</button>



<div style="clear:both"></div>

</div>

</form>

</div>

</div>

</div>

<script>top.openForm()</script>