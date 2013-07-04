<?php
/* YOo Slim | 2013 | https://bitbucket.org/YOoSlim */

class Pagination {
	const DEFAULT_CURRENT_PAGE = 1;
	const DEFAULT_ELEM_PER_PAGE = 5;
	const DEFAULT_MIN_ELEM_PER_PAGE = 4;
	const DEFAULT_ALL = 'All';
	private $DEFAULT_ELEM_PER_PAGE_LIST = array(self::DEFAULT_ELEM_PER_PAGE, 10, 20, 50, 100, self::DEFAULT_ALL);
	
	private $currentPage = 1;
	private $elemPerPage = 5;
	private $elemPerPageList = array();
	
	private $getParam = 'p';
	
	private $totalElem = null;

	/* *********************************************************************************************** */
	
	// The constructor, the first argument is the only obligatory one
	public function __construct($totalElem, $elemPerPageList = array(), $elemPerPage = null, $g = null, $currentPage = null) {
		$this->setTotalElem($totalElem);
		$this->setElemPerPageList($elemPerPageList);
		$this->setElemPerPage($elemPerPage);
		$this->setGetParam($g);
		$this->setCurrentPage($this->getParam, $currentPage);
	}
	
	// Set the total number of elements, if any problem, set to zero
	private function setTotalElem($t) {
		try {
			$t = intval($t);
			$this->totalElem = $t;
		}
		catch(Exception $e) {
			$this->totalElem = 0;
		}
	}
	
	// Set the model(list) of page organisation
	public function setElemPerPageList(array $list) {
		if(is_array($list) AND !empty($list)) {
			$this->cleanArray($list);
			$this->elemPerPageList = $list;
			$tmp = self::DEFAULT_ELEM_PER_PAGE;
			if(!in_array($tmp, $this->elemPerPageList)) array_push($this->elemPerPageList, $tmp);
			
			usort($this->elemPerPageList, function($a, $b) {
				if(is_string($a) AND is_string($b)) return (strcmp($a, $b) >= 0) ? true : false;
				elseif(is_string($a)) return true;
				elseif(is_string($b)) return false;
				else return ($a >= $b); 
			});
		}
		else $this->elemPerPageList = $this->DEFAULT_ELEM_PER_PAGE_LIST;
	}
	
	// Removes values that are inferior to "self::DEFAULT_MIN_ART_PER_PAGE", and redundancy
	private function cleanArray(array &$tab) {
		$tabTmp = array();
		
		foreach($tab AS $id=>$val) {
			if($val != self::DEFAULT_ALL AND $val < self::DEFAULT_MIN_ELEM_PER_PAGE) unset($tab[$id]);
			elseif(!in_array($val, $tabTmp)) array_push($tabTmp, $val);
		}
		
		$tab = $tabTmp;
	}
	
	// Set the current page parameter name
	private function setGetParam($g) {
		if(!empty($g) AND is_string($g)) $this->getParam = $g;
	}
	
	// Set the current user page organisation, if unknown, set to default
	public function setElemPerPage($t) {
		if($t != null AND in_array($t, $this->elemPerPageList)) $this->elemPerPage = $t;
		else $this->elemPerPage = self::DEFAULT_ELEM_PER_PAGE;
	}
	
	// Set the current page, if any problem, set to default value
	public function setCurrentPage($g, $p) {
		$this->setPagesNumber();
		$this->setGetParam($g);
		
		try {
			if($p != null) $p = intval($p);
			
			if($p > 0 AND $p <= $this->pagesNbr) $this->currentPage = $p;
			else {
				if($p !== null) {
					header('Location: ' . $this->formatURL() . $this->getParam . '=' . self::DEFAULT_CURRENT_PAGE);
					die();
				}
				else $this->currentPage = self::DEFAULT_CURRENT_PAGE;
			}
		}
		catch(Exception $e) {
			header('Location: ' . $this->formatURL() . $this->getParam . '=' . self::DEFAULT_CURRENT_PAGE);
			die();
		}
	}
	
	// Calculates the number of pages needed
	private function setPagesNumber() {
		if($this->elemPerPage == self::DEFAULT_ALL) $elemPerP = $this->totalElem;
		else $elemPerP = $this->elemPerPage;
		
		$this->pagesNbr = ceil($this->totalElem/$elemPerP);
	}
	
	/* *********************************************************************************************** */
	
	// Returns a select list containing the "Number of articles per page" list
	public function getElemPerPageList($selectName) {
		$str = '<select name="' . $selectName . '">';
		
		foreach($this->elemPerPageList AS $val) {
			if($val == $this->elemPerPage) $str .= '<option value="' . $val . '" selected>' . $val . '</option>';
			else $str .= '<option value="' . $val . '">' . $val . '</option>';
		}
			
		$str .= '</select>';
		
		return $str;
	}
	
	// Set the new URL
	private function formatURL() {
		$url = '';
		
		if(isset($_GET[$this->getParam])) {
			unset($_GET[$this->getParam]);
			$url = http_build_query($_GET);
		}

		$url = $_SERVER['SCRIPT_NAME'] . '?' . (!empty($url) ? $url . '&' : '');
		
		return $url;
	}
	
	// Returns the pagination
	public function getPagination() {
		$str = '';
		
		for($i = 1; $i <= $this->pagesNbr; $i++) {
			if($i == $this->currentPage) $str .= '<p style="display:inline;">' . $i . '</p> ';
			else $str .= '<p style="display:inline;"><a href="' . $this->formatURL() . $this->getParam . '=' . $i . '">' . $i . '</a></p> ';
		}
		
		return $str;
	}
}
?>