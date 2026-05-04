@extends('layouts.app')

@section('content')

    @php
        $filters = [
            '' => 'Latest',
            'popular_last_month' => 'Populárne za mesiac',
            'popular_last_6months' => 'Populárne za 6m',
            'highest_rated_last_month' => 'Najlepšie hodnotené 1m',
            'highest_rated_last_6months' => 'Najlepšie hodnotené 6m',
        ];
    @endphp

    <div class="mx-auto w-full max-w-4xl">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h1 class="text-2xl font-semibold text-slate-900">Knihy</h1>
            <a href="{{ route('books.create') }}" class="btn w-full sm:w-auto">Pridať knihu</a>
        </div>

        <form action="{{ route('books.index') }}" method="GET" class="mb-6 space-y-3">
            <div class="space-y-3">
                <input
                    type="text"
                    name="title"
                    placeholder="Hľadať podľa názvu..."
                    value="{{ request('title') }}"
                    class="input h-12 w-full text-base sm:h-14 sm:text-lg"
                >

                <div class="flex flex-col gap-3 sm:flex-row sm:items-end">
                    <label class="sr-only" for="filter">Filter kníh</label>
                    <select
                        id="filter"
                        name="filter"
                        class="input h-10 w-full sm:w-72 sm:flex-none"
                        onchange="this.form.submit()"
                    >
                        @foreach($filters as $key => $label)
                            <option value="{{ $key }}" {{ request('filter', '') === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    <div class="flex flex-row justify-center gap-2 sm:ml-auto sm:justify-end">
                        <button type="submit" class="btn h-10">Hľadať</button>
                        <a href="{{ route('books.index') }}" class="btn h-10">Vyčistiť všetko</a>
                    </div>
                </div>
            </div>
        </form>

        <ul class="space-y-4">
            @forelse ($books as $book)
                <li>
                    <div class="book-item">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div class="min-w-0 flex-1">
                                <a href="{{ route('books.show', $book) }}" class="book-title block truncate">
                                    {{ $book->title }}
                                </a>
                                <span class="book-author mt-1">od {{ $book->author }}</span>
                            </div>

                            <div class="flex items-center justify-between gap-3 sm:flex-col sm:items-end sm:justify-center">
                                <div class="book-rating">
                                    <x-star-rating :rating="$book->reviews_avg_rating" />
                                </div>
                                <div class="book-review-count">
                                    z {{ $book->reviews_count }} recenzií
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @empty
                <li>
                    <div class="empty-book-item">
                        <p class="empty-text">Nenašli sa žiadne knihy</p>
                        <a href="{{ route('books.index') }}" class="reset-link">Resetovať kritérium</a>
                    </div>
                </li>
            @endforelse
        </ul>
        <div class="mt-6 sm:mt-8">
            {{ $books->withQueryString()->links() }}
        </div>
    </div>
@endsection
