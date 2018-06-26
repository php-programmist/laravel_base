<?php
	
	namespace App\Http\Controllers;
	
	use Illuminate\Http\Request;
	use App\Group;
	class AdminGroupController extends Controller {
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index() {
			$groups = Group::orderBy('id')->paginate(config('settings.admin_pagination', 15));
			$groups->load('users');
			$title = __('system.groups_list');
			
			return view('admin.groups', [
				'title'  => $title,
				'groups' => $groups,
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
			
			$group = new Group();
			
			return view('admin.group', [
				'title' => __('system.group_create'),
				'group' => $group,
			
			]);
		}
		
		/**
		 * Store a newly created resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function store(Request $request) {
			if ( !\Auth::user()->hasRole('Super User') ) {
				return redirect()->back()->with([ 'message' => __('system.not_allowed_create') ]);
			}
			$group = new Group();
			
			$request->validate([
				'name' => 'required|max:255|unique:groups',
			]);
			$data        = $request->except('_token');
			$group->name = $data['name'];
			$group->save();
			
			return task_route($data['task'], 'admin.groups', __('system.group_created'), $group->id);
		}
		
		
		/**
		 * Show the form for editing the specified resource.
		 *
		 * @param  int $id
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function edit($id) {
			$group = Group::find($id);
			if ( !\Auth::user()->hasRole('Super User') ) {
				return redirect()->back()->with([ 'message' => __('system.not_allowed_update') ]);
			}
			
			if ( $group->name == 'Super User' ) {
				return redirect()->back()->with([ 'message' => __('system.not_allowed_update') ])->withInput();
			}
			
			
			return view('admin.group', [
				'title' => __('system.group_edit'),
				'group' => $group,
			
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
		public function update(Request $request, $id) {
			$group = Group::find($id);
			if ( !\Auth::user()->hasRole('Super User') ) {
				return redirect()->back()->with([ 'message' => __('system.not_allowed_update') ]);
			}
			if ( $group->name == 'Super User' ) {
				return redirect()->back()->with([ 'message' => __('system.not_allowed_update') ])->withInput();
			}
			
			$request->validate([
				'name' => 'required|max:255|unique:groups,name,' . $id,
			]);
			$data        = $request->except('_token');
			$group->name = $data['name'];
			$group->save();
			
			return task_route($data['task'], 'admin.groups', __('system.group_updated'), $group->id);
		}
		
		/**
		 * Remove the specified resource from storage.
		 *
		 * @param  int $id
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function destroy($id) {
			$group = Group::find($id);
			if ( !\Auth::user()->hasRole('Super User') ) {
				return redirect()->back()->with([ 'message' => __('system.not_allowed_delete') ]);
			}
			if ( $group->name == 'Super User' ) {
				return redirect()->back()->with([ 'message' => __('system.not_allowed_delete_SU') ])->withInput();
			}
			
			try {
				$group->delete();
			}
			catch (\Exception $e) {
				\Session::flash('error', $e->getMessage());
			}
			
			return redirect()->back()->with([ 'message' => __('system.group_deleted') ]);
			
		}
	}
