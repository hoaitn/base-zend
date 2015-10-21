<?php
/**
 *
 * @author Thuydx
 * @version 
 */
require_once 'Zend/View/Interface.php';
/**
 * PaginationFront helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_PaginationFront extends Zend_View_Helper_Abstract
{
    /**
     * @var Zend_View_Interface 
     */
    public $view;
    /**
     * 
     */

public function PaginationFront($pager, $text = '', $Condition = array()) {
		
		unset ( $Condition ['page'] );
		unset ( $Condition ['msg'] );
		$_t = '';
		if ($Condition) {
			foreach ( $Condition as $key => $item ) {
				if (is_array ( $item ))
					foreach ( $item as $a => $b )
						$_t .= '&' . $key . '[' . $a . ']=' . $b;
				else
					$_t .= '&' . $key . '=' . $item;
			}
			$text = str_replace ( '{%Condition}', $_t, $text );
		}		
		$pager_layout = new Doctrine_Pager_Layout ( $pager, new Doctrine_Pager_Range_Sliding ( array ('chunk' => 10 ) ), $text );
		$pager_layout->setTemplate ( '<a href="{%url}">{%page}</a>' );
		$pager_layout->setSelectedTemplate ( '<span class="current">{%page}</span>' );		
		$str .= '<a href="' . str_replace ( '{%page}', $pager->getFirstPage (), $text ) . '">First</a>';
		$str .= '<a href="' . str_replace ( '{%page}', $pager->getPreviousPage (), $text ) . '"><<</a>';
		$str .= $pager_layout->display ( array (), true );
		$str .= '<a href="' . str_replace ( '{%page}', $pager->getNextPage (), $text ) . '" class="arr_right">>></a>';
		$str .= '<a href="' . str_replace ( '{%page}', $pager->getLastPage (), $text ) . '">Last</a>';
		//$str .= '<div class="pages">Total of pages '.$pager->getNumResults() / $pager->_maxPerPage.'</div>';
		return $str;
			
//			
//<a href="/state/1/new-south-wales">First</a> ...
//
//<a href="/state/1/new-south-wales/50/100">«</a>
//
//
//<a href="/state/1/new-south-wales/50/0">1</a>

//
//
//
//<a href="/state/1/new-south-wales/50/200">»</a>
//
//... <a href="/state/1/new-south-wales/50/1000">Last</a>
//<div class="pages">Total of pages</div>			
	}	    
    /**
     * Sets the view field 
     * @param $view Zend_View_Interface
     */
    public function setView (Zend_View_Interface $view)
    {
        $this->view = $view;
    }
}
