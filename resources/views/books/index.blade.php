@extends('layouts.app')

@section('content')

    @php
        $filters = [
            '' => 'Latest',
            'popular_last_month' => 'Popular 1M',
            'popular_last_6months' => 'Popular 6M',
            'highest_rated_last_month' => 'Top Rated 1M',
            'highest_rated_last_6months' => 'Top Rated 6M',
        ];
    @endphp

    <div class="mx-auto w-full max-w-4xl">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h1 class="text-2xl font-semibold text-slate-900">Books</h1>
            <a href="{{ route('books.create') }}" class="btn w-full sm:w-auto">Add New Book</a>
        </div>

        <form action="{{ route('books.index') }}" method="GET" class="mb-6 space-y-3">
            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                <input
                    type="text"
                    name="title"
                    placeholder="Hľadať podľa názvu..."
                    value="{{ request('title') }}"
                    class="input h-10 w-full lg:col-span-2"
                >

                <label class="sr-only" for="filter">Filter kníh</label>
                <select
                    id="filter"
                    name="filter"
                    class="input h-10 w-full"
                    onchange="this.form.submit()"
                >
                    @foreach($filters as $key => $label)
                        <option value="{{ $key }}" {{ request('filter', '') === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>

                <div class="grid grid-cols-2 gap-2 lg:col-span-4 sm:flex sm:justify-end">
                    <button type="submit" class="btn h-10 w-full sm:w-auto">Hľadať</button>
                    <a href="{{ route('books.index') }}" class="btn h-10 w-full sm:w-auto">Vyčistiť všetko</a>
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
                                    {{ number_format($book->reviews_avg_rating, 1) }}
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
    </div>
@endsection
