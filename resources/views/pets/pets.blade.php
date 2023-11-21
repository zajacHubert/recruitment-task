@extends('layouts.app')

@section('content')
    <h1>List of Pets</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <ul>
        @foreach($pets as $pet)
            <li>
                <a href="/pets/{{ $pet['id'] }}">{{ data_get($pet, 'name', 'Unnamed') }}</a>
                
                <a href="/pets/{{ $pet['id'] }}/edit" class="btn-edit">Edit</a>

                <form action="/pets/{{ $pet['id'] }}" method="post" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
