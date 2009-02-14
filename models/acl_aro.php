<?php

class AclAro extends AclAppModel {
	var $useTable = 'aros';
	var $actsAs = array('Tree');
	
	function getStringPath($id) {
		$pieces = $this->getPath($id);
		$path = array();
		foreach ($pieces as $p) {
			if (!empty($p['AclAro']['alias'])) {
				$path[] = $p['AclAro']['alias'];
			} else {
				$path[] = $p['AclAro']['model'] . ' - ' . $p['AclAro']['foreign_key'];
			}
		}
		$path = implode(' > ', $path);
		return $path;
	}	

}

?>