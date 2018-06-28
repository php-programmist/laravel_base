<?php
	
	namespace App\Exceptions;
	
	use Exception;
	use Illuminate\Database\Eloquent\ModelNotFoundException;
	use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
	
	class Handler extends ExceptionHandler{
		/**
		 * A list of the exception types that are not reported.
		 *
		 * @var array
		 */
		protected $dontReport = [
			//
		];
		
		/**
		 * A list of the inputs that are never flashed for validation exceptions.
		 *
		 * @var array
		 */
		protected $dontFlash = [
			'password',
			'password_confirmation',
		];
		
		/**
		 * Report or log an exception.
		 *
		 * @param  \Exception $exception
		 *
		 * @return void
		 */
		public function report(Exception $exception){
			parent::report($exception);
		}
		
		/**
		 * Render an exception into an HTTP response.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @param  \Exception               $exception
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function render($request, Exception $exception){
			if( $this->isHttpException($exception) OR $exception instanceof ModelNotFoundException ){
				if( method_exists($exception, 'getStatusCode') ){
					$statusCode = $exception->getStatusCode();
				}
				else{
					$statusCode = '404';
				}
				
				switch( $statusCode ){
					case '404' :
						$controller                = new \App\Http\Controllers\SiteController();
						$controller->template      = 'errors.404';
						$controller->vars['title'] = '404 - ' . __('system.page_not_found');
						
						\Log::alert(__('system.page_not_found') . ' - ' . $request->url());
						
						return response($controller->renderOutput());
					case '403' :
						$controller                = new \App\Http\Controllers\SiteController();
						$controller->template      = 'errors.403';
						$controller->vars['title'] = '403 - ' . __('system.Restricted access');
						
						\Log::alert(__('system.Restricted access') . ' - ' . $request->url());
						
						return response($controller->renderOutput());
				}
			}
			
			return parent::render($request, $exception);
		}
	}
