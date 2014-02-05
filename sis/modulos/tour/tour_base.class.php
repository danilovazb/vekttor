<?
abstract class Tour{
	static public $modulo;
	public $titulo,$etapas,$etapas_incompletas,$etapas_completas=1;
	public $itens = array();
	
	
	static function init(){
		
		$palavras=explode(' ',self::$modulo['nome']);
		for($i=0;$i<count($palavras);$i++){
			$palavras[$i]=ucwords(removeAcentos($palavras[$i]));
		}
		$modulo_nome=implode('',$palavras);
		if(is_file("modulos/tour/".$modulo_nome."Tour.php")){
			include("modulos/tour/".$modulo_nome."Tour.php");
			$className = $modulo_nome."Tour";
			$obj = new $className;
			$obj->exibirEtapas();
		}
	}
	
	public function marcarEtapa($conteudo,$status,$tela_id){
		if($status==true){
			//etapa concluida
			$this->etapas_completas++;
			return '<div style="color:#CCC;" > 
		<img src="../fontes/img/accept.png" width="16" height="16" /> <a href="?tela_id='.$tela_id.'" style="color:#CCC; text-decoration:none"> '.$conteudo.'</a> </div>';
		}else{
			//etapa a fazer
			$this->etapas_incompletas++;
			return '<div style="color:#555"> <img src="../fontes/img/accept2.png" width="16" height="16" /> <a href="?tela_id='.$tela_id.'" style="color:black;text-decoration:none;">'. $conteudo .'</a> </div>';
		}
	}
	
	public function verificaEtapas(){
		for($i=1;$i<=$this->etapas;$i++){
			$metodo="etapa$i";
			$this->$metodo();
		}
	}
	
	public function exibirEtapas(){
		
		$this->verificaEtapas();
		
		//if($this->etapas_incompletas>0 && $this->etapas_completas<$this->etapas){
		if($this->etapas_incompletas>0){
			echo "<div  style='position:absolute; right:150px; top:30px;' class='sub-janela'>
              <span style='display:none' id='insercao'>listaplano_0</span>
              <div class='modal-header-2'>
              	<a class='modal_close' style='color:#CCC; float:right; ' href='#'>x</a>
                <span>Tour Virtual </span>
              </div>
                    <div class='modal-body'>";
			foreach($this->itens as $item){
				echo "$item</br>";
			}
			echo "</div><!-- fim modal-body -->
              <div id='result-modal'></div>
              <div class='modal-footer'>&nbsp;</div>
			</div>";
		}	
	}
}

class TourController extends Tour{
	
	public static function retornaModuloPaiID($tela_id){
		$modulo=mysql_fetch_object(mysql_query(" SELECT * FROM sis_modulos WHERE id='$tela_id' "));
		if($modulo->modulo_id==0){
			$modulo_pai=mysql_fetch_array(mysql_query($a=" SELECT * FROM sis_modulos WHERE id='$modulo->id' "));
			self::$modulo = $modulo_pai;
		}else{
			self::retornaModuloPaiID($modulo->modulo_id);
		}
	}
	public function verificaEtapas(){ /*sem implementação*/ }
}


