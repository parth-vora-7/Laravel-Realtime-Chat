@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">User list</div>
                <div class="panel-body">
                    @foreach($users as $user)
                        <p><a href="{{ route('private.chat.index', $user->id) }}">{{ $user->name }}</a></p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
