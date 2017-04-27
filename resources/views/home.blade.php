@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Chat options</div>

                <div class="panel-body">
                    <a href="{{ route('group.chat.index') }}" class="btn">Group chat</a>
                    <a href="{{ route('user.list') }}" class="btn">Private chat</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
