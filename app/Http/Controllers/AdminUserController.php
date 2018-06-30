<?php
	
	namespace App\Http\Controllers;
	
	use App\Group;
	use App\Http\Requests\AdminUserRequest;
	use App\User;
	
	class AdminUserController extends AdminController{
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index(){
			if( !\Auth::user()->canDo('VIEW_USERS') ){
				return redirect()->back()->with([ 'message' => __('system.not_allowed_view') ])->withInput();
			}
			$users = User::paginate(config('settings.admin_pagination', 15));
			$users->load('groups');
			
			$this->vars['users'] = $users;
			$this->title         = __('system.users_list');
			$this->template      = 'admin.users';
			
			return $this->renderOutput();
			
		}
		
		/**
		 * Show the form for creating a new resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function create(){
			if( !\Auth::user()->canDo('ADD_USERS') ){
				return redirect()->back()->with([ 'message' => __('system.not_allowed_create') ]);
			}
			
			$this->vars['user']   = new User();
			$this->vars['groups'] = Group::all();
			$this->title          = __('system.create_user');
			$this->template       = 'admin.user';
			
			return $this->renderOutput();
			
		}
		
		/**
		 * Store a newly created resource in storage.
		 *
		 * @param  \App\Http\Requests\AdminUserRequest $request
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function store(AdminUserRequest $request){
			if( !\Auth::user()->canDo('ADD_USERS') ){
				return redirect()->back()->with([ 'message' => __('system.not_allowed_create') ])->withInput();
			}
			
			$user = new User();
			$data = $request->all();
			$user->fill($data);
			$user->password = bcrypt($data['password']);
			
			$user->save();
			
			$new_groups = $request->get('groups', []);
			if( $new_groups ){
				$user->groups()->attach($new_groups);
			}
			
			return task_route($data['task'], 'admin.users', __('system.user_created'), $user->id);
			
		}
		
		/**
		 * Show the form for editing the specified resource.
		 *
		 * @param  int $id
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function edit($id){
			if( !\Auth::user()->canDo('EDIT_USERS') ){
				return redirect()->back()->with([ 'message' => __('system.not_allowed_update') ]);
			}
			
			$this->vars['user']   = User::find($id);
			$this->vars['groups'] = Group::all();
			$this->title          = __('system.update_user');
			$this->template       = 'admin.user';
			
			return $this->renderOutput();
			
		}
		
		/**
		 * Update the specified resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @param  int                      $id
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function update(AdminUserRequest $request, $id){
			if( !\Auth::user()->canDo('EDIT_USERS') ){
				return redirect()->back()->with([ 'message' => __('system.not_allowed_update') ])->withInput();
			}
			$user = User::findOrFail($id);
			$data = $request->all();
			if( $request->filled('password') ){
				$data['password'] = bcrypt($data['password']);
			}
			else{
				unset($data['password']);
			}
			$user->fill($data);
			$user->save();
			
			$new_groups = $request->get('groups', []);
			
			$user->groups()->sync($new_groups);
			
			return task_route($data['task'], 'admin.users', __('system.user_updated'), $user->id);
		}
		
		/**
		 * Remove the specified resource from storage.
		 *
		 * @param  int $id
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function destroy($id){
			if( !\Auth::user()->canDo('DELETE_USERS') ){
				return redirect()->back()->with([ 'message' => __('system.not_allowed_delete') ]);
			}
			
			$user = User::findOrFail($id);
			if( $user->hasRole('Super User') ){
				return redirect()->back()->with([ 'message' => __('system.not_allowed_delete_SU') ]);
			}
			
			$user->destroy($id);
			
			return redirect()->back()->with([ 'message' => __('system.user_deleted') ]);
		}
	}
