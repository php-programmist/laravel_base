@extends('layouts.admin')

@section('toolbar')
    <a href="{{ route('admin.groups.create') }}">
        <button class="btn btn-success m-2">{{__('system.add')}}</button>
    </a>
@endsection

@section('content')

    @if ($groups)
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Id</th>
                    <th>{{__('system.title')}}</th>

                    <th>{{__('system.users_num')}}</th>
                    <th>{{__('system.permissions')}}</th>

                    <th></th>
                </tr>
                @foreach($groups as $group)
                    <tr>
                        <td>{{ $group->id }}</td>
                        <td class="left"><a
                                    href="{{ route('admin.groups.edit',$group->id) }}">{{ $group->name }}</a>
                        </td>

                        <td>{{ count($group->users) }}</td>
                        <td>{{ count($group->permissions) }}</td>
                        <td>
                            @if($group->name!='Super User')
                            {!! Form::open([
                                'url'=>route('admin.groups.destroy',['group'=>$group->id]),
                                'class'=>'form-horizontal',
                                'method'=>'DELETE'
                            ]) !!}
                            {!! Form::button(__('system.delete'),['class'=>'btn btn-xs btn-danger','type'=>'submit']) !!}

                            {!! Form::close() !!}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="center">{{ $groups->links() }}</div>
    @endif


@endsection