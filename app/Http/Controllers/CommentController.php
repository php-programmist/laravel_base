<?php
	
	namespace App\Http\Controllers;
	
	use Illuminate\Http\Request;
	
	class CommentController extends Controller {
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index() {
			//
		}
		
		/**
		 * Show the form for creating a new resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function create() {
			//
		}
		
		/**
		 * Store a newly created resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function store(Request $request) {
			if ( !config('settings.allow_conmments') ) {
				return \Response::json([ 'status' => 'error', 'error' => [ __('system.comments_disabled') ] ]);
			}
			$data = $request->except('_token', 'comment_post_ID', 'comment_parent');
			
			$data['article_id'] = $request->input('comment_post_ID');
			$data['parent_id']  = $request->input('comment_parent');
			
			$validator = \Validator::make($data, [
				
				'article_id' => 'integer|required',
				'parent_id'  => 'integer|required',
				'text'       => 'string|required',
			
			]);
			
			$validator->sometimes([ 'name', 'email' ], 'required|max:255', function ($input) {
				
				return !\Auth::check();
				
			});
			
			if ( $validator->fails() ) {
				return \Response::json([ 'status' => 'error', 'error' => $validator->errors()->all() ]);
			}
			
			$user = \Auth::user();
			
			$comment        = new \App\Comment($data);
			$comment->state = config('settings.comments_autopublish') ? 1 : 0;
			
			if ( $user ) {
				$comment->user_id = $user->id;
			}
			
			$post = \App\Article::find($data['article_id']);
			
			$post->comments()->save($comment);
			
			if ( !$comment->state ) {
				return \Response::json([ 'status' => 'moderate', 'msg' => __('system.comment_moderate') ]);
			}
			
			$comment->load('user');
			$data['id']    = $comment->id;
			$data['email'] = $data['email'] ?? $comment->user->email;
			$data['name']  = $data['name'] ?? $comment->user->name;
			$data['hash']  = md5($data['email']);
			
			$view_comment = view('site.one_comment')->with('data', $data)->render();
			
			return \Response::json([ 'status' => 'success', 'comment' => $view_comment, 'data' => $data ]);
			
		}
		
		/**
		 * Display the specified resource.
		 *
		 * @param  int $id
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function show($id) {
			//
		}
		
		/**
		 * Show the form for editing the specified resource.
		 *
		 * @param  int $id
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function edit($id) {
			//
		}
		
		/**
		 * Update the specified resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @param  int                      $id
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function update(Request $request, $id) {
			//
		}
		
		/**
		 * Remove the specified resource from storage.
		 *
		 * @param  int $id
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function destroy($id) {
			//
		}
	}
