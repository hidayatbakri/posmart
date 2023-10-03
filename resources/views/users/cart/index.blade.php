@extends('users.template.main')
@section('content')

<livewire:cart-live />

@livewireScripts
@stack('js')


@endsection