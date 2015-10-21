<?php
define ( INPUT_DATETIME_FORMAT, 'd-m-Y' );
define ( UPLOAD_TO, '/upload/images' );
define ( Base_Url_Image, '/upload/images' );
class Form_Element {
	public function createInputText($label, $name, $value, $option = array(), $is_pass, $required = false) {
		if ($option) {
			foreach ( $option as $key => $val ) {
				$attr .= ' ' . $key . '=' . $val;
			}
		} else {
			$attr = '';
		}
		$input = '<label>' . $label . '</label><input placeholder=' . $label . ' name' . $name . ' id=' . $name . ' type="' . ($is_pass ? 'password' : 'text') . '" value="' . $value . '" ' . $attr . ' ' . ($required ? 'required' : '') . '></input>';
		
		return $input;
	}
	
	public function createSelectBox($label, $name, $value = array(), $option = array(), $required = false) {
		if ($option) {
			foreach ( $option as $key => $val ) {
				$attr .= ' ' . $key . '=' . $val;
			}
		} else {
			$attr = '';
		}
		if ($value) {
			foreach ( $value as $key => $val ) {
				$opt = '<option value=' . $key . '>' . $val . '</potion>';
			}
		}
		$select = '<label>' . $label . '</label><select name=' . $name . ' id=' . $name . ' ' . $attr . ' ' . ($required ? 'required' : '') . '>' . $opt . '</select>';
		
		return $select;
	}
	
	public function createCheckBox($label, $name, $value = array(), $option = array(), $required = false) {
		if ($option) {
			foreach ( $option as $key => $val ) {
				$attr .= ' ' . $key . '=' . $val;
			}
		} else {
			$attr = '';
		}
		$label = '<label>' . $label . '</label>';
		foreach ( $value as $key => $val ) {
			$ckb .= '<input name=' . $name . '[] id=' . $name . '[] type="checkbox" value="' . $key . '" ' . $attr . ' ' . ($required ? 'required' : '') . '>' . $val . '</input>';
		}
		$checkbox = $label . $ckb;
		
		return $checkbox;
	}
	
	public function createTextarea($label, $name, $value, $option = array(), $required = false) {
		if ($option) {
			foreach ( $option as $key => $val ) {
				$attr .= ' ' . $key . '=' . $val;
			}
		} else {
			$attr = '';
		}
		$textarea = '<label></label><textarea name=' . $name . ' id=' . $name . ' value="' . $value . '" ' . $attr . ' ' . ($required ? 'required' : '') . '></textarea>';
		
		return $textarea;
	}
	
	public function createRadio($label, $name, $value = array(), $option = array(), $required = false) {
		if ($option) {
			foreach ( $option as $key => $val ) {
				$attr .= ' ' . $key . '=' . $val;
			}
		} else {
			$attr = '';
		}
		$label = '<label>' . $label . '</label>';
		foreach ( $value as $key => $val ) {
			$rd .= '<input name=' . $name . ' id=' . $name . ' type="radio" value="' . $key . '" ' . $attr . ' ' . ($required ? 'required' : '') . '>' . $val . '</input>';
		}
		$radio = $label . $rd;
		
		return $radio;
	}
	
	public function createDatepicker($label, $name, $value, $option = array(), $dateFormat = INPUT_DATETIME_FORMAT, $buttonImages = Base_Url_Image, $required = false) {
		if ($option) {
			foreach ( $option as $key => $val ) {
				$attr .= ' ' . $key . '=' . $val;
			}
		} else {
			$attr = '';
		}
		$script = '<script>
						$("#' . $name . '").datepicker($.extend({}, 
						{ 
							dateFormat: "' . $dateFormat . '",
							defaultDate: "' . $value . '",
							showOn: "button", 
							buttonImage: "' . $buttonImages . '", 
							buttonImageOnly: true 
						})); 
				  </script>';
		$label = '<label>' . $label . '</label>';
		$datePicker = '<input name=' . $name . ' id=' . $name . ' type="text" value="' . $value . '" readonly="readonly" ' . $attr . '></input>';
		
		$dateInput = $script . $label . $datePicker;
		return $dateInput;
	}
	
	public function createHiddenField($name, $value) {
		$hidden = '<input name=' . $name . ' id=' . $name . ' type="hidden" value="' . $value . '"></input>';
	}
	
	public function createHtmlTags($value) {
		return $value;
	}
	
	public function createButton($name, $type, $label, $option = array()) {
		if ($option) {
			foreach ( $option as $key => $val ) {
				$attr .= ' ' . $key . '=' . $val;
			}
		} else {
			$attr = '';
		}
		$button = '<button name="' . $name . '" id="' . $name . '" type="' . $type . '" ' . $attr . '>' . $label . '</button>';
		return $button;
	}
	
	public function creatJsStatement($js){
		$statement = '$(document).ready(function(){'.$js.'})';
		return $statement;
	}
	
	public function createJsUrl($file = array(),$Url_JS){
		foreach ($file as $key=>$name){
			$js_file .= '<script type="text/javascript" src="'.$Url_JS.$name.'"></script>';		
		}
		return $js_file;
	}
	public function createInputUpload() {
	
	}
}