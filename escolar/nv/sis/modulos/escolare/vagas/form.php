<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id="exibe_formulario" class="exibe_formulario"  style="top:30px; left:50px;">
<style>
label#responsavel:hover{ cursor:crosshair;}
</style>
<div id='aSerCarregado'>
<div style="width:850px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Salas</span></div>
</div>
	<form onsubmit="return validaForm(this)" class="form_float"  method="post" enctype="multipart/form-data">

		<input type="hidden" id="aluno_id" name="aluno_id" value="<?=$_GET['aluno_id']; ?>" />

		<fieldset>
          <legend>
            <a onclick="aba_form(this,0)"><strong>Salas da Escola</strong></a>
          </legend>
			
            <div style="float:left; width:650px;">
           	
			<label style="width:278px;">
				Escola
				  <br />
			  <strong>Nossa Senhora do Carmo </strong>
              </label>
			<label style="width:100px;">
				Ano
				  <br />
			  <strong>2013 </strong>
              </label>
			<label style="width:128px;">
				Série
				  <br />
			  <strong>1º Série </strong>
              </label>
			<div style="clear:both"></div>
             <div>
               <div style="width:40px; float:left"><strong>Sala</strong></div>
               <div style="width:140px; float:left"><strong>Capacidade máxima</strong></div>
               <div style="width:160px; float:left"><strong>Capacidade Pedagogica</strong></div>
                <div style="width:300px; float:left"></div>
                <div style="clear:both;"></div>
                
                <div style="width:40px; float:left; text-align:center">1</div>
                <div style="width:140px; float:left; text-align:center">24</div>
                <div style="width:160px; float:left; text-align:center">20</div>
                <div style="width:300px; float:left"></div>
                <div style="clear:both;"></div>
                
                
                <div style="width:40px; float:left; text-align:center">2</div>
                <div style="width:140px; float:left; text-align:center">24</div>
                <div style="width:160px; float:left; text-align:center">20</div>
                <div style="width:300px; float:left"></div>
                <div style="clear:both;"></div>
                
                
                <div style="width:40px; float:left; text-align:center">3</div>
                <div style="width:140px; float:left; text-align:center">24</div>
                <div style="width:160px; float:left; text-align:center">20</div>
                <div style="width:300px; float:left"></div>
                <div style="clear:both;"></div>
                
                
                <div style="width:40px; float:left; text-align:center">4</div>
                <div style="width:140px; float:left; text-align:center">24</div>
                <div style="width:160px; float:left; text-align:center">20</div>
                <div style="width:300px; float:left"></div>
                <div style="clear:both;"></div>
                
                
                <div style="width:40px; float:left; text-align:center">5</div>
                <div style="width:140px; float:left; text-align:center">24</div>
                <div style="width:160px; float:left; text-align:center">20</div>
                <div style="width:300px; float:left"></div>
                <div style="clear:both;"></div>
                
                
                <div style="width:40px; float:left; text-align:center">6</div>
                <div style="width:140px; float:left; text-align:center">24</div>
                <div style="width:160px; float:left; text-align:center">20</div>
                <div style="width:300px; float:left"></div>
                <div style="clear:both;"></div>
                
                
                <div style="width:40px; float:left; text-align:center">7</div>
                <div style="width:140px; float:left; text-align:center">24</div>
                <div style="width:160px; float:left; text-align:center">20</div>
                <div style="width:300px; float:left"></div>
                <div style="clear:both;"></div>
                
                
                <div style="width:40px; float:left; text-align:center">8</div>
                <div style="width:140px; float:left; text-align:center">24</div>
                <div style="width:160px; float:left; text-align:center">20</div>
                <div style="width:300px; float:left"><img src="../fontes/img/mais.png" width="18" height="18" class="<?=$class?>" modulo_id='<?=$m->id?>' /></div>
                <div style="clear:both;"></div>
                
                
                <div style="width:40px; float:left; text-align:center">9</div>
                <div style="width:140px; float:left; text-align:center">24</div>
                <div style="width:160px; float:left; text-align:center">20</div>
                <div style="width:300px; float:left"><img src="../fontes/img/mais.png" width="18" height="18" class="<?=$class?>" modulo_id='<?=$m->id?>' /></div>
                <div style="clear:both;"></div>
                
                
                <div style="width:40px; float:left; text-align:center">10</div>
                <div style="width:140px; float:left; text-align:center">24</div>
                <div style="width:160px; float:left; text-align:center">20</div>
                <div style="width:300px; float:left"><img src="../fontes/img/mais.png" width="18" height="18" class="<?=$class?>" modulo_id='<?=$m->id?>' /></div>
                <div style="clear:both;"></div>
                
                
                <div style="width:40px; float:left; text-align:center">11</div>
                <div style="width:140px; float:left; text-align:center">24</div>
                <div style="width:160px; float:left; text-align:center">20</div>
                <div style="width:300px; float:left"><img src="../fontes/img/mais.png" width="18" height="18" class="<?=$class?>" modulo_id='<?=$m->id?>' /></div>
                <div style="clear:both;"></div>
                
                
                <div style="width:40px; float:left; text-align:center">12</div>
                <div style="width:140px; float:left; text-align:center">24</div>
                <div style="width:160px; float:left; text-align:center">20</div>
                <div style="width:300px; float:left"><img src="../fontes/img/mais.png" width="18" height="18" class="<?=$class?>" modulo_id='<?=$m->id?>' /></div>
                <div style="clear:both;"></div>
                
                
                <div style="width:40px; float:left; text-align:center">13</div>
                <div style="width:140px; float:left; text-align:center">24</div>
                <div style="width:160px; float:left; text-align:center">20</div>
                <div style="width:300px; float:left"><img src="../fontes/img/mais.png" width="18" height="18" class="<?=$class?>" modulo_id='<?=$m->id?>' /></div>
                <div style="clear:both;"></div>
                
                
                <div style="width:40px; float:left; text-align:center">14</div>
                <div style="width:140px; float:left; text-align:center">24</div>
                <div style="width:160px; float:left; text-align:center">20</div>
                <div style="width:300px; float:left"><img src="../fontes/img/mais.png" width="18" height="18" class="<?=$class?>" modulo_id='<?=$m->id?>' /></div>
                <div style="clear:both;"></div>
                
                
                <div style="width:40px; float:left; text-align:center">15</div>
                <div style="width:140px; float:left; text-align:center">24</div>
                <div style="width:160px; float:left; text-align:center">20</div>
                <div style="width:300px; float:left"><img src="../fontes/img/mais.png" width="18" height="18" class="<?=$class?>" modulo_id='<?=$m->id?>' /></div>
                <div style="clear:both;"></div>
                
                
               <div style="width:40px; float:left; text-align:center">16</div>
               <div style="width:140px; float:left; text-align:center">24</div>
               <div style="width:160px; float:left; text-align:center">20</div>
                <div style="width:300px; float:left"><img src="../fontes/img/mais.png" width="18" height="18" class="<?=$class?>" modulo_id='<?=$m->id?>' /></div>
                <div style="clear:both;"></div>
                
                
             </div><br>

             </label>
             <div style="clear:both;"></div>
            </div>
		</fieldset>
		<!-- --><!-- --><!-- -->
      <!-- --><!-- -->

       <div style="width:100%; text-align:center" >
         <div style="clear:both"></div>
      </div>
    </form>
</div>
</div>
</div>
<script>top.openForm()</script>
<? if(strlen($d->senha)<1){echo "<script>top.newPass('senha')</script>";} ?>