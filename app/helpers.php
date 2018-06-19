<?php
	if ( !function_exists('classActivePath') ) {
		function classActivePath($path) {
			$path    = explode('.', $path);
			$segment = 1;
			foreach ($path as $p) {
				if ( (request()->segment($segment) == $p) == false ) {
					return '';
				}
				$segment++;
			}
			
			return ' active';
		}
	}