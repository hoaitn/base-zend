<?php
class My_Plugin_Upload extends Zend_Controller_Plugin_Abstract {
	public $fileName;
	public $dirUpload;
	public function uploadImageFile($File,$W,$H,$S,$Accept,$Dir){ 													   	    
    	/** Set properties file**/
    	$filename = $File['name'];
    	$filetype = end(explode(".",$File['type']));
    	$filesize = $File['size'];
    	/** Get dimension file**/
    	list($width, $height) = @getimagesize($File['tmp_name']);
    	/** Set Dimension, Size and  File type**/
    	$maxWidth = $W;
		$maxHieght = $H;
		$maxFileSize = $S;
		$accept = $Accept;	
			foreach ($accept as $key=>$value){
				$alert_filetype[$key] = end(explode("/",$value));
			}
			$alert_filetype = implode(',',$alert_filetype);			
			/** Check file upload and upload file**/
			$error = array();
			if($width > $maxWidth || $height > $maxHieght){
				$error[] = 'You must be upload a file have dimension : '.$maxWidth."x".$maxHieght;				
			}elseif($filesize > $maxFileSize){
				$error[] = 'You must be upload a file have max size: '.$maxFileSize."kb";			
			}elseif(in_array($filetype,$accept) == false){				
				$error[] = 'You must be upload a file have file type: '.$alert_filetype; 				
			}else{								
				if (! is_dir( $Dir )) {					
					@mkdir( $Dir );
					chmod( $Dir, 0777 );				
				}				
				$image = new Zend_File_Transfer_Adapter_Http();
				$image->setDestination( $Dir );
				$image->addValidator( 'Count', false, 1 );
				/** Get name by random number **/	
				//$this->randomGetName($filename);
				/** Get name by random string **/				
				//$this->randomGetNameByString();				
				$this->setDirPath($Dir);					
				$image->addFilter( 'Rename', array ('target' => $Dir . DIRECTORY_SEPARATOR . $this->randomGetName($filename), 'overwrite' => true ) );
				$image->receive();							
			}			
			return $error;	
    }
	public function uploadGalleryImage($File,$W,$H,$S,$Accept,$Dir,$i){ 																   	    
    	/** Set properties file**/
    	$filename = $File['name'];
    	$filetype = end(explode(".",$File['type']));
    	$filesize = $File['size'];
    	/** Get dimension file**/
    	list($width, $height) = @getimagesize($File['tmp_name']);
    	/** Set Dimension, Size and  File type**/
    	$maxWidth = $W;
		$maxHieght = $H;
		$maxFileSize = $S;
		$accept = $Accept;	
			foreach ($accept as $key=>$value){
				$alert_filetype[$key] = end(explode("/",$value));
			}
			$alert_filetype = implode(',',$alert_filetype);			
			/** Check file upload and upload file**/
			$error = array();
			if($width > $maxWidth || $height > $maxHieght){
				$error[] = 'You must be upload a file have dimension : '.$maxWidth."x".$maxHieght;				
			}elseif($filesize > $maxFileSize){
				$error[] = 'You must be upload a file have max size: '.$maxFileSize."kb";			
			}elseif(in_array($filetype,$accept) == false){				
				$error[] = 'You must be upload a file have file type: '.$alert_filetype; 				
			}else{								
				if (! is_dir( $Dir )) {					
					@mkdir( $Dir );
					chmod( $Dir, 0777 );				
				}								
				$image = new Zend_File_Transfer_Adapter_Http();
				$image->setDestination( $Dir );
				$image->addValidator( 'Count', false, 1 );
				/** Get name by random number **/	
				//$this->randomGetName($filename);
				/** Get name by random string **/				
				//$this->randomGetNameByString();				
				$this->setDirPath($Dir);					
				$image->addFilter( 'Rename', array ('target' => $Dir . DIRECTORY_SEPARATOR . $File['name'], 'overwrite' => true ) );
				$image->receive();							
			}			
			return $error;	
    }
    
    public function randomGetName($name){
    	$name = str_replace('-','_',$name);
		$name = str_replace(' ','_',$name);	
		$name = rand(1,1000000000)."_".$name;
		$this->fileName = $name;
		return $this->fileName;	
    }
    public function randomGetNameByString(){
    	$length = 10;
	    $characters = "0123456789abcdefghijklmnopqrstuvwxyz";
	    $string = ""; 
	    for ($p = 0; $p < $length; $p++) {
	        $string .= $characters[mt_rand(0, strlen($characters))];
	    }  	
    	$this->fileName = $string.".jpg";
		return $this->fileName;	   	
    }
    public function setDirPath($dir_path){
    	$this->dirUpload = $dir_path;    		  
    }
    public function getDirPath(){
    	return $this->dirUpload;
    } 
    public function uploadMultiFile($File,$W,$H,$S,$Accept,$Dir){
    	$maxWidth = $W;
		$maxHieght = $H;
		$maxFileSize = $S;
		$accept = $Accept;
		/**Get file tpye accept**/
		foreach ($accept as $key=>$value){
				$alert_filetype[$key] = end(explode("/",$value));
		}
		$alert_filetype = implode(',',$alert_filetype);
		/** Check file upload**/
		$error = array();
    	for($i=0;$i<count($File);$i++){
    		/** Set properties file**/
	    	$filename = $File['name'][$i];
	    	$filetype = end(explode(".",$File['type'][$i]));
	    	$filesize = $File['size'][$i];
	    	/** Get dimension file**/
	    	list($width, $height) = getimagesize($File['tmp_name'][$i]);    		
			if($width > $maxWidth || $height > $maxHieght){
				$error[] = 'You must be upload a file have dimension : '.$maxWidth."x".$maxHieght;
			}elseif($filesize > $maxFileSize){
				$error[] = 'You must be upload a file have max size: '.$maxFileSize."kb";			
			}elseif(in_array($filetype,$accept) == false){
				$error[] = 'You must be upload a file have file type: '.$alert_filetype; 
			}else{								
				if (! is_dir( $Dir )) {					
					@mkdir( $Dir );
					chmod( $Dir, 0777 );				
				}
				$image = new Zend_File_Transfer_Adapter_Http();
				$image->setDestination( $Dir );
				$image->addValidator( 'Count', false, 1 );
				/** Get name by random number **/	
				//$this->randomGetName($filename);
				/** Get name by random string **/				
				//$this->randomGetNameByString();				
				$this->setDirPath($Dir);					
				//$image->addFilter( 'Rename', array ('target' => $Dir . DIRECTORY_SEPARATOR . $this->randomGetName($filename), 'overwrite' => true ) );
				$images->setMultiFile( count( $File) );
				$image->receive();				
			}
    	} 
    		    	
    	return $error;	    	
    }   
}
?>