@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('books.reviews.store', $book) }}" class="mx-4 flex max-w-lg flex-col gap-4 rounded-lg border border-slate-200 bg-white p-6 shadow-sm min-[544px]:mx-auto">
        @csrf
        <h1 class="mb-10 text-2xl text-center">Pridať recenziu pre {{ $book->title }}</h1>
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
        <a href="{{ route('books.show', $book) }}" class="btn">Naspäť</a>
    </form>
@endsection
