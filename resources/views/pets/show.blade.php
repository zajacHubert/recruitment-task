@extends('layouts.app')

@section('content')
    <h1>{{ $pet['name'] ?? 'Unnamed' }}</h1>
@endsection
