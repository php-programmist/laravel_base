<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    protected $template;
    protected $title;
    protected $vars;
    
    public function renderOutput()
    {
        $this->vars = array_add($this->vars, 'title', $this->title);
        
        $menu = $this->getMenu();
        
        $this->vars['navigation'] = view('admin.navigation')->with('menu', $menu)->render();
        
        return view($this->template)->with($this->vars);
        
    }
    
    public function getMenu()
    {
        $user = \Auth::user();
        
        return \Menu::make('adminMenu', function ($menu) use ($user) {
            if ($user->canDo('VIEW_USERS')) {
                $users = $menu->add('Пользователи', array('route' => 'admin.users.index'));
                if ($user->canDo('VIEW_GROUPS')) {
                    $users->add('Группы', array('route' => 'admin.groups.index'));
                }
            }
            if ($user->canDo('VIEW_ARTICLES')) {
                $articles = $menu->add('Статьи', array('route' => 'admin.articles.index'));
                if ($user->canDo('VIEW_CATEGORIES')) {
                    $articles->add('Категории', array('route' => 'admin.categories.index'));
                }
                
                if ($user->canDo('VIEW_COMMENTS')) {
                    $articles->add('Комментарии', array('route' => 'admin.comments.index'));
                }
                $articles->add('Тэги', array('route' => 'admin.tags.index'));
            }
            
            if ($user->canDo('VIEW_MENU')) {
                $menu->add('Меню', array('route' => 'admin.menus.index'));
            }
            
        });
    }
}
