<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $title = $request->input('title');
        $filter = $request->input('filter', '');
        /*$books = Book::when($title, function ($query, $title){
        return $query->title($title);
        })->get();*/
        $books = Book::when($title, fn($query, $title) => $query->title($title));



        $books = match($filter) {
            default => $books->latest()->withAvgRating()->withReviewsCount(),
            'popular_last_month' => $books->popularLastMonth(),
            'popular_last_6months' => $books->popularLast6Months(),
            'highest_rated_last_month' => $books->highestRatedLastMonth(),
            'highest_rated_last_6months' => $books->highestRatedLast6Months()
        };

        $books = $books->paginate(10)->withQueryString();

//        $cacheKey = 'books:' . $filter . ':' . $title;
//        $books = cache()->remember($cacheKey, 3600, fn() => $books->get());

        return view('books.index', /*compact('books') - používa sa ak nepotrebujem posunúť do templatu viac ako jeden parameter (subor udajov)*/
            ['books' => $books]);
    }

//    public function index(Request $request)
//    {
//        $title = $request->input('title');
//        $filter = $request->input('filter', 'latest');
//
//        $query = Book::query()
//            ->when($title, fn ($query, $title) => $query->title($title));
//
//        $query = match ($filter) {
//            'popular_last_month' => $query->popularLastMonth(),
//            'popular_last_6months' => $query->popularLast6Months(),
//            'highest_rated_last_month' => $query->highestRatedLastMonth(),
//            'highest_rated_last_6months' => $query->highestRatedLast6Months(),
//            default => $query->latest(),
//        };
//
//        $cacheKey = 'books:' . md5(json_encode([
//                'filter' => $filter,
//                'title' => $title ?? '',
//            ]));
//
//        $bookIds = cache()->remember($cacheKey, 3600, fn () => $query->pluck('id')->toArray());
//
//        if (! is_array($bookIds)) {
//            cache()->forget($cacheKey);
//            $bookIds = $query->pluck('id')->toArray();
//            cache()->put($cacheKey, $bookIds, 3600);
//        }
//
//        $books = Book::query()
//            ->whereIn('id', $bookIds)
//            ->withCount('reviews')
//            ->withAvg('reviews', 'rating')
//            ->get()
//            ->sortBy(fn ($book) => array_search($book->id, $bookIds))
//            ->values();
//
//        return view('books.index', [
//            'books' => $books,
//        ]);
//    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        $book = Book::create($request->validated());

        return redirect()->route('books.show', ['book' => $book])->with('success', 'Kniha úspešne vytvorená !');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id) {
        /*$cacheKey = 'book:' .$book->id;

        $book = cache()->remember($cacheKey, 3600, fn() => $book->load(['reviews' => fn($query) => $query->latest()]));

        return view('books.show', ['book' => $book/*$book->load(['reviews' => fn($query) => $query->latest()]) ]);*/
        return view('books.show', ['book' => Book::with(['reviews' => fn($query) => $query->latest()])->withAvgRating()->withReviewsCount()->findOrFail($id) ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book) {
        return view('books.edit', ['book' => $book]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, Book $book) {
        $book->update($request->validated());

        return redirect()->route('books.show' , ['book' => $book])->with('success', 'Kniha úspešne aktualizovaná !');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book) {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Kniha úspešne vymazaná !');
    }
}
