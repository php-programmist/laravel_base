<?php
	
	namespace App\Http\Controllers;
	
	use Illuminate\Http\Request;
	use App\User;
	use App\Group;
	use App\Http\Requests\AdminUserRequest;
	
	class AdminUserController extends Controller {
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index() {
			$users = User::paginate(10);
			$users->load('groups');
			
			return view('admin.users', [
				'title' => __('system.users_list'),
				'users' => $users,
			]);
		}
		
		/**
		 * Show the form for creating a new resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function create() {
			if ( !\Auth::user()->hasRole('Super User') ) {
				return redirect()->back()->with([ 'message' => __('system.not_allowed_create') ]);
			}
			$user   = new User();
			$groups = Group::all();
			
			return view('admin.user', [
				'title'  => __('system.create_user'),
				'user'   => $user,
				'groups' => $groups,
			]);
		}
		
		/**
		 * Store a newly created resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function store(AdminUserRequest $request) {
			if ( !$request->user()->hasRole('Super User') ) {
				return redirect()->back()->with([ 'message' => __('system.not_allowed_create') ])->withInput();
			}
			
			$user = new User();
			$data = $request->all();
			$user->fill($data);
			$user->password = \Hash::make($data['password']);
			
			$user->save();
			
			$user_id = $user->id;
			
			$new_groups = $request->get('groups', []);
			if ( $new_groups ) {
				$user->groups()->attach($new_groups);
			}
			
			if ( $data['task'] == 'apply' ) {
				return redirect()->route('admin.users.edit', [ 'id' => $user_id ])->with([ 'message' => __('system.user_created') ]);
			}
			else {
				return redirect()->route('admin.users.index')->with([ 'message' => __('system.user_created') ]);
			}
		}
		
		/**
		 * Display the specified resource.
		 *
		 * @param  int $id
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function show($id) {
			$user = User::find($id);
			
			return view('admin.user', [
				'title' => __('system.update_user'),
				'user'  => $user,
			]);
		}
		
		/**
		 * Show the form for editing the specified resource.
		 *
		 * @param  int $id
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function edit($id) {
			if ( !\Auth::user()->hasRole('Super User') ) {
				return redirect()->back()->with([ 'message' => __('system.not_allowed_update') ]);
			}
			$user   = User::find($id);
			$groups = Group::all();
			
			return view('admin.user', [
				'title'  => __('system.update_user'),
				'user'   => $user,
				'groups' => $groups,
			]);
		}
		
		/**
		 * Update the specified resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @param  int                      $id
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function update(AdminUserRequest $request, $id) {
			if ( !$request->user()->hasRole('Super User') ) {
				return redirect()->back()->with([ 'message' => __('system.not_allowed_update') ])->withInput();
			}
			$user = User::findOrFail($id);
			$data = $request->all();
			if ( $request->filled('password') ) {
				$data['password'] = \Hash::make($data['password']);
			}
			else {
				unset($data['password']);
			}
			$user->fill($data);
			$user->save();
			
			$new_groups = $request->get('groups', []);
			$old_groups = $user->groups->pluck('id')->all();
			
			$detach_ids = array_diff($old_groups, $new_groups);
			$attach_ids = array_diff($new_groups, $old_groups);
			
			if ( count($attach_ids) ) {
				$user->groups()->attach($attach_ids);
			}
			
			if ( count($detach_ids) ) {
				$user->groups()->detach($detach_ids);
			}
			
			$user_id = $user->id;
			
			if ( $data['task'] == 'apply' ) {
				return redirect()->route('admin.users.edit', [ 'id' => $user_id ])->with([ 'message' => __('system.user_updated') ]);
			}
			else {
				return redirect()->route('admin.users.index')->with([ 'message' => __('system.user_updated') ]);
			}
		}
		
		/**
		 * Remove the specified resource from storage.
		 *
		 * @param  int $id
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function destroy($id) {
			if ( !\Auth::user()->hasRole('Super User') ) {
				return redirect()->back()->with([ 'message' => __('system.not_allowed_delete') ]);
			}
			
			$user = User::findOrFail($id);
			if ( $user->hasRole('Super User') ) {
				return redirect()->back()->with([ 'message' => __('system.not_allowed_delete_SU') ]);
			}
			
			$user->destroy($id);
			
			return redirect()->back()->with([ 'message' => __('system.user_deleted') ]);
		}
	}
