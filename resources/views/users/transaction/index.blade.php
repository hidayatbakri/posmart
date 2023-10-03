@extends('users.template.main')
@section('content')

<livewire:transaction-live />

@livewireScripts
@stack('js')

@endsection