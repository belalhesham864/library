<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Book\BookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
       public function index()
    {
        $books = Book::with('category')->active()->select('id', 'name', 'slug', 'category_id', 'cost', 'description', 'image', 'status')
            ->activeCategry()
            ->paginate(10);
        if ($books->isEmpty()) {
            return apiResponse(404, 'Not Found');
        }
        return apiResponse(200, 'Active Book', (new BookCollection($books))->response()->getData());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
        public function store(BookRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = Str::uuid() . time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('uploads/books', $filename, ['disk' => 'uploads']);
            $data['image'] = $path;
        }
        $data['slug'] = Str::slug($data['name']);
        $book = Book::create($data);
        if (!$book) {
            return apiResponse(400, 'Please try again');
        }
        return apiResponse(200, 'Book Created Success', new BookResource($book));
    }

    /**
     * Display the specified resource.
     */
       public function show($id)
    {
        $book = Book::with('category')->find($id);

        if (!$book) {
            return apiResponse(404, 'Not Found');
        }
        return apiResponse(200, 'Success', new BookResource($book));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, $id)
    {
        $data = $request->validated();
        $book = Book::find($id);
        if (!$book) {
            return apiResponse(404, 'Not Found');
        }

        if ($request->hasFile('image')) {
            if (File::exists(public_path($book->image))) {
                File::delete(public_path($book->image));
            }
            $image = $request->file('image');
            $filename = Str::uuid() . time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('uploads/books', $filename, ['disk' => 'uploads']);
            $data['image'] = $path;
        }
        if ($request->has('name')) {
            $data['slug'] = Str::slug($data['name']);
        }

        $book->update($data);
        return apiResponse(200, 'Updated Successfully', new BookResource($book));
    }

    /**
     * Remove the specified resource from storage.
     */
     public function destroy($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return apiResponse(404, 'Not Found');
        }
         $imagePath = str_replace(asset('/') , '' , $book->image);
    
        if (File::exists(public_path($imagePath))) {
            File::delete(public_path($imagePath));
        }

        $book->forceDelete();
        return apiResponse(200, 'Deleted Successfully');
    }
        public function archive($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return apiResponse(404, 'Not Found');
        }
        $book->delete();
        return apiResponse(200, 'Book Aechived Successfully');
    }
        public function return($id)
    {
        $book = Book::withTrashed()->find($id);
        if (!$book) {
            return apiResponse(404, 'Not Found in Arcvived');
        }
        $book->restore();
        return apiResponse(200, 'Book retutn Successfully', new BookResource($book->fresh()));
    }
}
