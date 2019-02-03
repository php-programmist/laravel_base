<?php

namespace App\Providers;

use App\Article;
use App\Observers\ArticleObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Form::component('bsText', 'components.form.text', ['name', 'value', 'label', 'attributes' ]);
        \Form::component('bsEmail', 'components.form.email', ['name', 'value', 'label', 'attributes' ]);
        \Form::component('bsTextarea', 'components.form.textarea', ['name', 'value', 'label', 'attributes' ]);
        \Form::component('bsFile', 'components.form.file', ['name', 'label', 'attributes' ]);
        \Form::component('bsSelect', 'components.form.select', ['name', 'options', 'selected', 'label', 'attributes' ]);
        Article::observe(ArticleObserver::class);
        
    }
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
