<?php
class My_Plugin_Form extends Zend_Form {
	public function renderFormText($fields=array(),$style = array(),$class=array(),$option=array()){		
		foreach ($fields as $id=>$label){			
		        if($input[$id] == "password"){
		        	${$input[$id]} = new Zend_Form_Element_Password($id);			
					${$input[$id]}->class = $class; 
					${$input[$id]}->setAttribs($style);
					${$input[$id]}->setAttribs($option);        
					${$input[$id]}->setRequired ( true );
		        	${$input[$id]}->setLabel($label)
		                 ->setDecorators(array(
		                     array('ViewHelper',
		                           array('helper' => 'formPassword')),
		                     array('Label',$style)
		                 ));
		        }else{
		        	${$input[$id]} = new Zend_Form_Element_Text($id);			
					${$input[$id]}->class = $class; 
					${$input[$id]}->setAttribs($style);
					${$input[$id]}->setAttribs($option);        
					${$input[$id]}->setRequired ( true ); 
		        	${$input[$id]}->setLabel($label)
	                 ->setDecorators(array(
	                     array('ViewHelper',
	                           array('helper' => 'formText')),
	                     array('Label',$style)
	                 ));
		        }         
	        $element[] = ${$input[$id]};          			
		}
		return $element;        
	}		
}
?>