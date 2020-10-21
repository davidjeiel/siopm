<?php

	class Siopm{
		
		private $ignore			= array();
		private $files 			= array();
		private $ignoreDIR 		= array();
		private $app_path		= "";
		private $charset		= "UTF-8";
		private $icone 			= "logo.ico";
		private $titulo 		= "..::: SIOPM - Sistema de Operações de Mercado :::..";
		
		public function __construct($app_path = ""){

			$this->app_path = $app_path;
		
			$this->getFiles($this->files["lib"], $this->getRootPath() . "/lib/");
			$this->getFiles($this->files["models"], $this->getRootPath() . "/models/");
			$this->getFiles($this->files["views"], $this->getRootPath() . "/views/");
			$this->getFiles($this->files["helpers"], $this->getRootPath() . "/helpers/");

			//$this->pr($this->files);

		}

		public function getErrorModal($msg, $id = ""){

			$form = "<div id ='$id' class = 'modal active in'>";
			$form .= "<div class='alert alert-error modal-header'>";
			$form .= "<h3> Alerta! </h3>";
			$form .= "</div>";
			$form .= "<div class='alert modal-body'>";
			$form .= "<h4>$msg</h4>";
			$form .= "</div>";
			$form .= "<div class='modal-footer'>";
			$form .= "<button id='btn_cancelar' class='btn' data-dismiss='modal' aria-hidden='true'>Cancelar</button>";
			$form .= "</div>";
			$form .= "</div>";

			return $form;
			

		}

		public function getHtmlError($msg){

			echo <<<HEREDOC
<html><head><title>Erro</title><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><style>
p{font-family:Arial;color:#93200d;font-size:16px;font-weight:bold;text-align: center;line-height: 90px;}
</style></head><body><p>$msg</p></body></html>
HEREDOC;
		die;
		}

		private function getFiles(&$vet, $path = '.', $level = 0){

		    $ignore = array( 'cgi-bin', '.', '..' );
		    // Directories to ignore when listing output. Many hosts
		    // will deny PHP access to the cgi-bin.

		    $dh = opendir($path);
		    // Open the directory to the handle $dh

		    while( false !== ( $file = readdir( $dh ) ) ){
		    // Loop through the directory
		    
		        if( !in_array( $file, $ignore ) ){
		        // Check that this file is not to be ignored
		            
		            //$spaces = str_repeat( '&nbsp;', ( $level * 4 ) );
		            // Just to add spacing to the list, to better
		            // show the directory tree.
		            
		            if( is_dir( "$path/$file" ) ){
		            // Its a directory, so we need to keep reading down...
		            
		                //echo "<strong>$spaces $file</strong><br />";
		                $this->getFiles($vet, "$path/$file", ($level+1) );
		                // Re-call this same function but on a new directory.
		                // this is what makes function recursive.
		            
		            } else {

		            	$extn = explode('.',$file);
      					$extn = array_pop($extn);

      					$vet[$extn][$file] = "$path";
		            
		            }
		        
		        }
		    
		    }
		    
		    closedir( $dh );
		    // Close the directory hand

		} 

		private function includeFilesPHP($diretorio){

			$ponteiro  = opendir($diretorio);
			
			while ($nome_itens = readdir($ponteiro)) {

				$extn = explode('.',$nome_itens);
      			$extn = array_pop($extn);

			    if ($nome_itens != "." && $nome_itens != ".." && $nome_itens != null && strtolower($extn) == "php") {
			    	include  $diretorio . "/" . $nome_itens;
			    }

			}

		}

		private function pr($vetor){
			echo "<pre>";
			print_r($vetor);
			echo "</pre>";
		}

		public function getAppPath(){
			return $this->app_path;
		}

		public function getRootPath(){
			return $_SERVER["DOCUMENT_ROOT"] . $this->app_path;
		}

		public function getJS($index, $file){

			foreach ($this->files[$index]["js"] as $key => $value) {

				$out =  "<script src='" . str_replace("//", "/", str_replace($_SERVER["DOCUMENT_ROOT"], "", $value)) . "/$key" . "'></script>";

				if ($file != "" && !in_array(strtolower(trim($file)), $this->ignore) && strtolower(trim($file)) == strtolower(trim($key)) ){
					$this->ignore[] = strtolower(trim($key));
					return $out;
				}

			}

		}

		public function getCSS($index, $file){

			foreach ($this->files[$index]["js"] as $key => $value) {

				$out = "<link href='" . str_replace("//", "/", str_replace($_SERVER["DOCUMENT_ROOT"], "", $value)) . "/$key" . "' rel='stylesheet'>";

				if ($file != "" && !in_array(strtolower(trim($file)), $this->ignore) && strtolower(trim($file)) == strtolower(trim($key)) ){
					$this->ignore[] = strtolower(trim($key));
					return $out;
				}

			}

		}

		public function addIngnoreDIR($ignoreDIR = array()){
			$this->ignoreDIR += $ignoreDIR;
		}

		public function includeJS($index, $file = ""){

			foreach ($this->files[$index]["js"] as $key => $value) {

				$dir = explode("//", $value);
				$dir = end($dir);

				$out =  "<script src='" . str_replace("//", "/", str_replace($_SERVER["DOCUMENT_ROOT"], "", $value)) . "/$key" . "'></script>";

				if ($file == "" && !in_array(strtolower($key), $this->ignore) && !in_array(strtolower($dir), $this->ignoreDIR)){
					$this->ignore[] = strtolower(trim($key));
					echo $out;
				} 

				if ($file != "" && !in_array(strtolower(trim($file)), $this->ignore) && strtolower(trim($file)) == strtolower(trim($key)) ){
					$this->ignore[] = strtolower(trim($key));
					echo $out;
					return;
				}

			}

		}

		public function includeCSS($index, $file = ""){

			if (isset($this->files[$index]["css"])) foreach ($this->files[$index]["css"] as $key => $value) {

				$dir = explode("//", $value);
				$dir = end($dir);

				$out = "<link href='" . str_replace("//", "/", str_replace($_SERVER["DOCUMENT_ROOT"], "", $value)) . "/$key" . "' rel='stylesheet'>";
				
				if ($file == "" && !in_array(strtolower($key), $this->ignore) && !in_array(strtolower($dir), $this->ignoreDIR)){
					$this->ignore[] = strtolower(trim($key));
					echo $out;
				} 

				if ($file != "" && !in_array(strtolower(trim($file)), $this->ignore) && strtolower(trim($file)) == strtolower(trim($key)) ){
					$this->ignore[] = strtolower(trim($key));
					echo $out;
					return;
				}
			}

		}

		public function includePHP($index, $file = ""){

			foreach ($this->files[$index]["php"] as $key => $value) {

				$dir = explode("//", $value);
				$dir = end($dir);

				$out = str_replace("//", "/", $value) . "/$key";

				if ($file == "" && !in_array(strtolower($key), $this->ignore) && !in_array(strtolower($dir), $this->ignoreDIR)){
					//$this->pr($this->ignore);
					$this->ignore[] = strtolower(trim($key));
					include $out;
				} 

				if ($file != "" && !in_array(strtolower(trim($file)), $this->ignore) && strtolower(trim($file)) == strtolower(trim($key)) ){
					$this->ignore[] = strtolower(trim($key));
					include $out;
					return;
				}

			}

		}



		public function getReportHeader($report){
			return $this->getRootPath() . "/views/reports/" . $report . ".report.header.php";
		}

		public function getReportBody($report){
			return $this->getRootPath() . "/views/reports/" . $report . ".report.body.php";
		}

		public function getReport($report){
			return $this->getRootPath() . "/views/reports/" . $report . ".report.php";
		}

		public function getTemplate($template){
			return $this->getRootPath() . "/views/templates/" . $template . ".template.php";
		}

		public function getForm($form){
			return $this->getRootPath() . "/views/forms/" . $form . ".form.php";
		}
		
		public function getController($controller){
			return $this->getRootPath() . "/controllers/" . $controller . ".controller.php";
		}
				
		public function getCharset(){
			return $this->charset;
		}
		
		public function getTitle(){
			return $this->titulo;
		}

		// Escrito por Marcos Dimitrio Silva, c059930, www.dimitrio.com
		// Para GIFUG/SP
		public function getTagImg($nome, $tag_parameters = array()){
			$relative_path =  $this->app_path . "/views/img/" . $nome;
			$especificou_width = array_key_exists("width", $tag_parameters);
			$especificou_height = array_key_exists("height", $tag_parameters);

			// Tentamos descobrir qual o tamanho da imagem
			if ((!$especificou_width or !$especificou_height) and file_exists($this->getRootPath() . $relative_path)) {
				list($img_width, $img_height, $img_type, $img_attr) = getimagesize($this->getRootPath() . $relative_path);

				// Agora que encontramos os tamanhos da imagem, colocamos na tag da imagem
				// somente se o usuário não especificou diretamente no $tag_parameters (override)
				if (!$especificou_width) {
					$tag_parameters["width"] = $img_width;
				}
				if (!$especificou_height) {
					$tag_parameters["height"] = $img_height;
				}
			}
			if (!array_key_exists("border", $tag_parameters)) {
				$tag_parameters["border"] = "0";
			}
			
			$return_str = "";
			$return_str .= "<img src=\"$relative_path\"";
			foreach ($tag_parameters as $key => $value) {
				$return_str .= " $key=\"$value\"";
			}
			$return_str .= "/>";
			return $return_str;
		}


	}
	
?>
