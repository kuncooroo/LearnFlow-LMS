@extends('layouts.admin', ['title' => 'Edit User'])

@section('content')
    <livewire:admin.users.user-form :user="$user" />
@endsection
