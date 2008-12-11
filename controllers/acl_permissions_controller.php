<?php

class AclPermissionsController extends AclAppController {
	var $name = 'AclPermissions';

	var $uses = array('Acl.AclAroAco', 'Acl.AclAro', 'Acl.AclAco');

	var $helpers = array('Html');

	function exists() {
		$conditions = array(
			'aro_id' => $this->data['AclAroAco']['aro_id'],
			'aco_id' => $this->data['AclAroAco']['aco_id']
		);
		if ($this->AclAroAco->find($conditions)) {
			return true;
		} else {
			return false;
		}
	}

	function create() {
		if ($this->exists($this->data)) {
			$this->failure();
		}
		$this->AclAroAco->set($this->data);
		$this->AclAroAco->set(array(
			'_create' => 1,
			'_read' => 1,
			'_update' => 1,
			'_delete' => 1
		));
		if (!$this->AclAroAco->save()) {
			$this->failure();
		}
		exit;
	}

	function aros($id = null) {
		Configure::write('debug', 0);
		if (!$id) {
			$this->failure();
		}
		$this->layout = '';

		$nodes = $this->AclAroAco->findAllByAroId($id);

		$aro = $this->AclAro->getStringPath($id);
		$this->set('aro', $aro);

		$reordered = array();
		foreach ($nodes as &$n) {
			$reordered[$this->AclAco->getStringPath($n['AclAroAco']['aco_id'])] = $n;
		}
		ksort($reordered);
		$this->set('nodes', $reordered);
	}

	function acos($id = null) {
		Configure::write('debug', 0);
		if (!$id) {
			$this->failure();
		}
		$this->layout = '';
		$nodes = $this->AclAroAco->getAllowedAro($id);

		$aco = $this->AclAco->getStringPath($id);
		$this->set('aco', $aco);

		$reordered = array();
		foreach ($nodes as &$n) {
			$reordered[$this->AclAro->getStringPath($n['AclAro']['id'])] = $n;
		}
		ksort($reordered);
		$this->set('nodes', $reordered);
	}

	function revoke($id) {
		if (!$this->AclAroAco->del($id)) {
			$this->failure();
		}
		exit;
	}
}

?>