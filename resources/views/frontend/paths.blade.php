@extends('layouts.landing')

@include('layouts.partials.title', ['title' => $path['name']])

@section('content')
    <section class=" py-32">
        @livewire('frontend.workshops-list', ['path_id' => $id])
    </section>
@endsection
