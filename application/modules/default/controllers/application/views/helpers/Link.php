<?php

/**
 * WDS Project - WDS
 * @name Link
 * @package WDS/View/Helper
 * @author Thuy Dinh Xuan
 * @version $1.0.1$
 * 11:51:57 PM - Aug 13, 2010
 * License http://wds.vn/license
 */
 
 

require_once('Zend/View/Helper/Abstract.php');

class App_View_Helper_Link extends \Zend_View_Helper_Abstract
{
    public function link($href = '#', $text = '', $isBlank = false, $options = array())
    {
        $html = '';
        if (!empty($options)) {
            foreach ($options as $attrib => $value) {
                $html .= ' ' . $attrib . '="' . $value . '" ';
            }
        }

        $html .= ' onfocus="this.blur();" ';

        if ($isBlank) {
            $html .= ' rel="external" ';
        }

        $link = '<a href="' . $href . '" ' . $html . '>' . $text . '</a>';
        return $link;
    }
}