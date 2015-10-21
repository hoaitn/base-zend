<?php

class HtmlController extends Zend_Controller_Action {
	
	public function getfillterAction() {
	
	}
	public function myviewedAction() {
	
	}
	public function quicksupportAction() {
	
	}
	public function youarehereAction() {
		$this->view->YouAreHere = $this->getRequest ()->getParam ( 'YouAreHere' );
	}
	public function footerlinkAction() {
		$Footer = new Zend_Config_Xml ( APPLICATION_PATH . '/configs/footer_link.xml', 'data' );
		//$Footer=$Footer->toArray ();
		$this->view->Footer = $Footer->toArray ();
	}
	public function advAction() {
		$this->_helper->layout->disableLayout ();
		$this->_helper->viewRenderer->setNoRender ();
		$Adv = new Zend_Config_Xml ( APPLICATION_PATH . '/data/adv.xml', 'data' );
		$Adv = $Adv->toArray ();
		$request = $this->getRequest ()->getParam ( 'adv' );
		$response = array ();
		foreach ( $request as $adv ) {
			$limit = ( int ) $Adv [$adv] ['limit'];
			$index = array_rand ( $Adv [$adv] ['adv'], $limit );
			if ($limit <= 1)
				$response [$adv] [] = $Adv [$adv] ['adv'] [$index];
			else
				for($i = 0; $i < $limit; $i ++)
					$response [$adv] [] = $Adv [$adv] ['adv'] [$index [$i]];
		}
		echo Zend_Json::encode ( $response );
	}
	
	public function sitemapAction() {
		$this->_helper->layout->disableLayout ();
		$this->_helper->viewRenderer->setNoRender ();
		$this->getResponse ()->setheader ( 'Content-Type', 'text/xml; charset=utf-8' );
		$date = date ( 'm-d-Y' );
		echo '<?xml version="1.0" encoding="UTF-8"?>';
		echo "\n\t" . '<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">';
		
		$Countries = Doctrine_Query::create ()->from ( 'countries' )->where ( 'status=?', 1 )->execute ();
		echo '<!-- START url for destination -->';
		foreach ( $Countries as $Country ) {
			echo "\n\t\t<url>  
		       	<loc>" . DOMAIN . '/' . $Country->getDestination () . "</loc>  
		        <lastmod>$date</lastmod>  
		        <changefreq>daily</changefreq>  
		        <priority>0.8</priority>  
		</url> ";
			$Cities = Doctrine_Query::create ()->from ( 'city' )->where ( 'status=?', 1 )->addWhere ( 'countries_id=?', $Country->id )->execute ();
			echo '<!-- START url for destination ' . $Country->name . '-->';
			foreach ( $Cities as $City ) {
				echo "\n\t\t<url>  
		       	<loc>" . DOMAIN . '/' . $City->getDestination () . "</loc>  
		        <lastmod>$date</lastmod>  
		        <changefreq>daily</changefreq>  
		        <priority>0.8</priority>  
		</url> ";
			}
			echo '<!-- END url for destination ' . $Country->name . '-->';
		}
		echo '<!-- END url for destination -->';
		
		$Hotels = Doctrine_Query::create ()->from ( 'Hotels' )->where ( 'status=?', 1 )->execute ();
		
		echo '<!-- START url for hotels -->';
		foreach ( $Hotels as $Hotel ) {
			echo "\n\t\t<url>  
		       	<loc>" . DOMAIN . '/' . $Hotel->getLink () . "</loc>  
		        <lastmod>$date</lastmod>  
		        <changefreq>daily</changefreq>  
		        <priority>0.8</priority>  
		</url> ";
		}
		echo '<!-- END url for hotels -->';
		echo '</urlset>';
	}
	
	public function cscAction() {
		$this->_helper->layout->disableLayout ();
	}
}

