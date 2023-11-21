@extends('layouts.app')

@section('content')
    <h1>Edit Pet</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('pets.update', ['id' => $pet['id']]) }}" method="post">
        @csrf
        @method('PUT')

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="{{ old('name', $pet['name'] ?? 'Unnamed') }}" required>

        <label for="status">Status:</label>
        <input type="text" id="status" name="status" value="{{ old('status', $pet['status'] ?? 'available') }}" required>

        <button type="submit">Save Changes</button>
    </form>
@endsection
