<?php

class AclAco extends AclAppModel {
	var $useTable = 'acos';
	var $actsAs = array('Tree');
	
	function getStringPath($id) {
		$pieces = $this->getPath($id);
		$path = array();
		foreach ($pieces as $p) {
			$path[] = $p['AclAco']['alias'];
		}
		$path = implode(' > ', $path);
		return $path;
	}
	
}

?>