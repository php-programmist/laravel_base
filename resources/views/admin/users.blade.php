@extends('layouts.admin')

@section('sidebar')
    <a href="{{ route('admin.users.create') }}">
        <button class="btn-success">{{__('system.add')}}</button>
    </a>
@endsection

@section('content')

    <div class="col-md-9">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif

        @if ($users)
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
                            <form action="{{ route('admin.users.destroy',['user'=>$user->id]) }}" method="post">
                                {{csrf_field()}}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-xs btn-danger">{{ __('system.delete') }}</button>
                            </form>
                        </td>
                        {{--TODO Вывести группы пользователей--}}
                    </tr>
                @endforeach
            </table>
            <div class="center">{{ $users->links() }}</div>
        @endif

    </div>
@endsection