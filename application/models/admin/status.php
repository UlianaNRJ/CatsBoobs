<?php

class ActivationState {
	const NONE				= 'none';
	const ADMIN			    = 'admin';

	static public function getDescription($state) {
		switch ($state) {
			case self::NONE: return 'None';
			case self::ADMIN: return 'Admin';
			default: return '';
		}
	}
}