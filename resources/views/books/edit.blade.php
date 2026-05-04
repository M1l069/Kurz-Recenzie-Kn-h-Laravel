@extends('layouts.app')

@section('content')
    <div class="mx-auto w-full max-w-lg px-4 sm:px-0">
        <a href="{{ route('books.show', $book) }}" class="reset-link inline-block mb-4">← Naspäť</a>

        <div class="mb-4">
            <h1 class="mb-3 text-2xl font-semibold text-slate-900">Upraviť knihu</h1>

            <form action="{{ route('books.update', ['book' => $book->id]/*$book - aj toto by fungovalo*/) }}" method="POST" class="space-y-5 rounded-lg border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
                @csrf
                @method('PUT')
                <div class="space-y-2">
                    <label for="title" class="block text-sm font-medium text-slate-700">Názov</label>
                    <input type="text" name="title" id="title" required
                           class="block h-11 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ $book->title }}">
                </div>

                <div class="space-y-2">
                    <label for="author" class="block text-sm font-medium text-slate-700">Autor</label>
                    <input type="text" name="author" id="author" required
                           class="block h-11 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ $book->author }}">
                </div>

                <div class="flex flex-col gap-2 sm:flex-row sm:justify-end">
                    <button type="submit"
                            class="inline-flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-3 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto sm:py-2">
                        Upraviť knihu
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
