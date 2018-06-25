@extends('layouts.admin')

@section('toolbar')
    <a href="{{ route('admin.users.create') }}">
        <button class="btn btn-success m-2">{{__('system.add')}}</button>
    </a>
@endsection

@section('content')
        @if ($users)
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>Id</th>
                        <th>{{__('system.name')}}</th>
                        <th>{{__('system.username')}}</th>
                        <th>{{__('system.email')}}</th>
                        <th>{{__('system.groups')}}</th>
                        <th>{{__('system.created_at')}}</th>
                        <th>{{__('system.updated_at')}}</th>
                        <th></th>
                    </tr>
                    @foreach($users as $k=> $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td><a href="{{ route('admin.users.edit',$user->id) }}">{{ $user->name }}</a></td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->groups->implode('name', ', ') }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>{{ $user->updated_at }}</td>
                            <td>
                                {!! Form::open([
                                    'url'=>route('admin.users.destroy',['user'=>$user->id]),
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
            {{ $users->links() }}
        @endif


@endsection