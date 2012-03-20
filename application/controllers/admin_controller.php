<?php

require_once('application/controllers/abstract_restricted.php');
require_once('application/models/admin/status.php');

abstract class AbstractAdminController extends AbstractRestrictedController {


	public function getAuth() {
		return new AdminAuthorizationModel();
	}

}