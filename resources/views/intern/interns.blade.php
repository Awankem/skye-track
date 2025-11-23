@extends('layout.app')
@section('title', 'Intern')
@section('content')
    @livewire('search-intern')
    @include('intern.add-intern-modal')
@endsection
