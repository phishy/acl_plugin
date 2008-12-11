<?php

class AclAppController extends AppController {
	function success() {
		header("HTTP/1.0 200 Success", null, 200);
		exit;
	}

	function failure() {
		header("HTTP/1.0 404 Failure", null, 404);
		exit;
	}

}

?>