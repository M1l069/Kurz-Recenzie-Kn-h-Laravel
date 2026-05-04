@extends('layouts.app')

@section('content')
    <h1 class="mb-10 text-2xl">Pridať recenziu pre {{ $book->title }}</h1>

    <form method="POST" action="{{ route('books.reviews.store', $book) }}">
        @csrf
        <label for="review">Recenzia: </label>
        <textarea name="review" id="review" required class="input mb-4"></textarea>
        <label for="rating">Hodnotenie: </label>
        <select name="rating" id="rating" class="input mb-4" required>
            <option value="">Výber hodnotenia</option>
            @for($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select>
        <button type="submit" class="btn">Pridať recenziu</button>
    </form>
@endsection
