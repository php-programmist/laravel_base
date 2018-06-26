@extends('layouts.admin')

@section('toolbar')
    <a href="{{ route('admin.categories.create') }}">
        <button class="btn btn-success m-2">{{__('system.add')}}</button>
    </a>
@endsection

@section('content')

    @if ($categories)
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Id</th>
                    <th>{{__('system.title')}}</th>
                    <th>{{__('system.alias')}}</th>
                    <th>{{__('system.children_num')}}</th>
                    <th>{{__('system.articles_num')}}</th>
                    <th>{{__('system.state')}}</th>

                    <th>{{__('system.link')}}</th>
                    <th></th>
                </tr>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td class="left"><a
                                    href="{{ route('admin.categories.edit',$category->id) }}">{{ $category->title }}</a>
                        </td>
                        <td>{{ $category->alias }}</td>
                        <td>{{ $category->children_num }}</td>
                        <td>{{ count($category->articles) }}</td>
                        <td>
                            {{ $category->state?Html::image(asset('icons/tick.png'),__('system.published')) :Html::image(asset('icons/publish_x.png'),__('system.unpublished')) }}
                        </td>

                        <td><a target="_blank"
                               href="{{ route('articlesCat',$category->id.'-'.$category->alias) }}">{{ __('system.preview') }}</a>
                        </td>
                        <td>
                            {!! Form::open([
                                'url'=>route('admin.categories.destroy',['category'=>$category->id]),
                                'class'=>'form-horizontal',
                                'method'=>'DELETE'
                            ]) !!}
                            {!! Form::button(__('system.delete'),['class'=>'btn btn-xs btn-danger','type'=>'submit']) !!}

                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        {{--<div class="center">{{ $categories->links() }}</div>--}}
    @endif


@endsection