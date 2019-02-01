<?php

namespace App\Http\Controllers\Admin;
	
	use App\Group;
    use Illuminate\Http\Request;
    
    class GroupController extends AdminController
    {
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index(){
			if( !\Auth::user()->canDo('VIEW_GROUPS') ){
                return redirect()->back()->with(['warning' => __('system.not_allowed_view')])->withInput();
			}
			$groups = Group::orderBy('id')->paginate(config('settings.admin_pagination', 15));
			$groups->load('users');
			$groups->load('permissions');
			
			$this->vars['groups'] = $groups;
			$this->title          = __('system.groups_list');
			$this->template       = 'admin.groups';
			
			return $this->renderOutput();
			
		}
		
		/**
		 * Show the form for creating a new resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function create(){
			if( !\Auth::user()->canDo('ADD_GROUPS') ){
                return redirect()->back()->with(['warning' => __('system.not_allowed_create')]);
			}
			
			$this->vars['group'] = new Group();
			$this->title         = __('system.group_create');
			$this->template      = 'admin.group';
			
			return $this->renderOutput();
			
		}
		
		/**
		 * Store a newly created resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function store(Request $request){
			if( !\Auth::user()->canDo('ADD_GROUPS') ){
                return redirect()->back()->with(['warning' => __('system.not_allowed_create')]);
			}
			$group = new Group();
			
			$request->validate([
				                   'name' => 'required|max:255|unique:groups',
			                   ]);
			$data        = $request->except('_token');
			$group->name = $data['name'];
			$group->save();
			
			$new_permissions = $request->get('permissions', []);
			if( $new_permissions ){
				$group->permissions()->attach($new_permissions);
			}
			
			return task_route($data['task'], 'admin.groups', __('system.group_created'), $group->id);
		}
		
		/**
		 * Show the form for editing the specified resource.
		 *
		 * @param  int $id
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function edit($id){
			$group = Group::find($id);
			if( !\Auth::user()->canDo('EDIT_GROUPS') ){
                return redirect()->back()->with(['warning' => __('system.not_allowed_update')]);
			}
			
			if( $group->name == 'Super User' ){
                return redirect()->back()->with(['warning' => __('system.not_allowed_update')])->withInput();
			}
			
			$this->vars['group']       = $group;
			$this->vars['group_perms'] = $group->permissions->pluck('id')->all();
			$this->vars['permissions'] = \App\Permission::all();
			$this->title               = __('system.group_edit');
			$this->template            = 'admin.group';
			
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
		public function update(Request $request, $id){
			$group = Group::find($id);
			if( !\Auth::user()->canDo('EDIT_GROUPS') ){
                return redirect()->back()->with(['warning' => __('system.not_allowed_update')]);
			}
			if( $group->name == 'Super User' ){
                return redirect()->back()->with(['warning' => __('system.not_allowed_update')])->withInput();
			}
			
			$request->validate([
				                   'name' => 'required|max:255|unique:groups,name,' . $id,
			                   ]);
			$data        = $request->except('_token');
			$group->name = $data['name'];
			$group->save();
			
			$new_permissions = $request->get('permissions', []);
			
			$group->permissions()->sync($new_permissions);
			
			
			return task_route($data['task'], 'admin.groups', __('system.group_updated'), $group->id);
		}
		
		/**
		 * Remove the specified resource from storage.
		 *
		 * @param  int $id
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function destroy($id){
			$group = Group::find($id);
			if( !\Auth::user()->canDo('DELETE_GROUPS') ){
                return redirect()->back()->with(['warning' => __('system.not_allowed_delete')]);
			}
			if( $group->name == 'Super User' ){
                return redirect()->back()->with(['warning' => __('system.not_allowed_delete_SU')])->withInput();
			}
			
			try{
				$group->delete();
			}
			catch( \Exception $e ){
				\Session::flash('error', $e->getMessage());
			}
            
            return redirect()->back()->with(['success' => __('system.group_deleted')]);
			
		}
	}
