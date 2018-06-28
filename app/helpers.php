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
	
	if ( !function_exists('task_route') ) {
		function task_route($task, $route_basis, $msg, $id) {
			switch ($task) {
				case 'apply':
					return redirect()->route($route_basis . '.edit', [ 'id' => $id ])->with([ 'message' => $msg ]);
					break;
				case 'save':
					return redirect()->route($route_basis . '.index')->with([ 'message' => $msg ]);
					break;
				case 'save2new':
					return redirect()->route($route_basis . '.create')->with([ 'message' => $msg ]);
					break;
				default:
					return redirect()->back();
			}
		}
	}
	
	if( !function_exists('perm_translate') ){
		function perm_translate($perm_name){
			list($action, $view) = explode("_", $perm_name);
			
			return __('system.' . strtolower($view)) . ": " . __('system.' . strtolower($action));
		}
	}