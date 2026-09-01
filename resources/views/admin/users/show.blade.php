@extends('layouts.admin', ['title' => $user->name])

@section('content')
    <livewire:admin.users.show-user :user="$user" />
@endsection
