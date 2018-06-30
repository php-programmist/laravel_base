@extends('layouts.admin')

@section('toolbar')
    <a href="{{ route('admin.menus.create') }}">
        <button class="btn btn-success m-2">{{__('system.add')}}</button>
    </a>
@endsection

@section('content')
    
    @if ($menus)
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Id</th>
                    <th>{{__('system.title')}}</th>

                    <th>{{__('system.link')}}</th>
                    <th>{{__('system.element')}}</th>
                    <th></th>
                </tr>
                @foreach($menus as $menu)
                    <tr>
                        <td>{{ $menu->id }}</td>
                        <td class="left">
                            {!! $menu->level_delimiter !!}
                            <a href="{{ route('admin.menus.edit',$menu->id) }}">{{ $menu->title }}</a>
                        </td>
                        <td><a href="{{ $menu->link }}" target="_blank">{{ $menu->link }}</a></td>
                        <td>{{ __('system.'.$menu->element) }}</td>
    
                        <td>
                            {!! Form::open([
                                'url'=>route('admin.menus.destroy',['menu'=>$menu->id]),
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
        {{--<div class="center">{{ $menus->links() }}</div>--}}
    @endif


@endsection