@extends('layouts.app')

@section('content')
    <div class="private-chat">
        <private-chat-component :room="{{ $room }}" :user="{{ $user }}"></private-chat-component>
    </div>
@endsection