@extends('layouts.app')

@section('content')
    <div class="mx-auto w-full max-w-4xl px-4 min-[801px]:px-0">
        <a href="{{ route('books.index') }}" class="reset-link inline-block mb-4">← Naspäť</a>

        <div class="mb-6 space-y-3">

            <h1 class="text-2xl font-semibold leading-tight text-slate-900 sm:sticky sm:top-0 sm:z-10 sm:bg-white sm:py-2">{{ $book->title }}</h1>

            <div class="book-info flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-4">
                <div class="book-author text-base font-semibold text-slate-700 sm:text-lg">od {{ $book->author }}</div>
                <div class="book-rating flex flex-wrap items-center gap-x-2 gap-y-1">
                    <x-star-rating :rating="$book->reviews_avg_rating" />
                    <span class="book-review-count text-sm text-slate-500">
          {{ $book->reviews_count }} recenzií
        </span>
                </div>
            </div>
            <a href="{{ route('books.edit', ['book' => $book]) }}" class="btn mt-4 inline-block sm:mt-6">Upraviť knihu</a>
            <div>
                <form action="{{ route('books.destroy', $book) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete inline-block">Vymazať knihu</button>
                </form>
            </div>
        </div>

        <div>
            <div class="mb-4">
                <a href="{{ route('books.reviews.create', $book) }}" class="reset-link">Pridať recenziu !</a>
            </div>
        </div>

        <div>
            <h2 class="mb-4 text-xl font-semibold text-slate-900">Recenzie</h2>
            <ul class="space-y-4">
            @forelse ($book->reviews as $review)
                    <li class="book-item p-4 sm:p-5">
                        <div class="space-y-3">
                            <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                                <div class="font-semibold text-slate-800">Hodnotenie: <x-star-rating :rating="$review->rating" /></div>
                                <div class="book-review-count text-xs sm:text-sm">
                                    {{ $review->created_at->format('M j, Y') }}</div>
                            </div>
                            <p class="wrap-break-word leading-6 text-slate-700">{{ $review->review }}</p>
                        </div>
                    </li>
            @empty
                    <li>
                        <div class="empty-book-item">
                            <p class="empty-text text-lg font-semibold">Žiadne recenzie</p>
                        </div>
                    </li>
            @endforelse
            </ul>
        </div>
    </div>
@endsection
