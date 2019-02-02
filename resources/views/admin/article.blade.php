@extends('layouts.admin')

@section('toolbar')
	
	@include('layouts.editortoolbar',['view' => 'articles'])

@endsection

@section('content')
	@if($article->id)
		@if($article->image AND file_exists(public_path('images/articles').DIRECTORY_SEPARATOR.$article->image))
			<div class="card mb-4">
				{{ Html::image('images/articles/'.$article->image,$article->name ) }}
			</div>
		@endif
		<div class="card-body">
			{!! Form::model($article,[
				'id'=>'adminForm',
				'class'=>'form-horizontal',
				'route' => [
					'admin.articles.update',
					'article'=>$article->id,

				],
				'method'=>'put',
				'files'=>true,
			]) !!}
			@else
				{!! Form::model($article,[
					'id'=>'adminForm',
					'class'=>'form-horizontal',
					'route' => [
						'admin.articles.store',
					],
					'method'=>'post',
					'files'=>true,
				]) !!}
			@endif
			
			{{ Form::bsText('name',null,__('system.title')) }}
			{{ Form::bsText('alias') }}
			{{ Form::bsSelect('category_id',$categories,null,__('system.parent_category')) }}
			{{ Form::bsSelect(
					'tag_ids[]',
					$tags,
					$selectedTags,
					__('system.tags'),
					['multiple'=>'multiple','data-live-search'=>'true','class'=>'selectpicker form-control']
			) }}
			{{ Form::bsFile('image',__('system.image'),['class' => 'filestyle']) }}
			{{ Form::bsTextarea('intro_text',null,__('article.short_desc')) }}
			{{ Form::bsTextarea('full_text',null,__('article.full_desc'),['id'=>'editor']) }}
			{{ Form::bsSelect('state',['1' => __('system.published'), '0' => __('system.unpublished')]) }}
			{!! Form::hidden('task','',['id'=>'task']) !!}
			{!! Form::close() !!}
		
		</div>
		
		<script src="{{ asset('bootstrap/js/bootstrap-filestyle.js') }}"></script>
		
		<script>
			CKEDITOR.replace('editor', {
				language: '{{app()->getLocale()}}'
				
			});
			
			$('.filestyle').filestyle({
				badge: true,
				btnClass: 'btn-primary',
				placeholder: '{{__('system.image_not_chosed')}}',
				text: ' {{__('system.choose_file')}}'
			});
			$('.selectpicker').selectpicker();
		</script>
@endsection