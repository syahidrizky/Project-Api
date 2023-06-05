<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Models\Book;
use Exception;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();

        if ($books) {
            return ApiFormatter::createApi(200, 'success', $books);
        }else {
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'book_code' => 'required',
                'name_book' => 'required',
                'image' => 'required',
            ]);

            $books = Book::create([
                'book_code' => $request->book_code,
                'name_book' => $request->name_book,
                'image' => $request->image,
            ]);

            $getDateSaved = Book::where('id', $books->id)->first();

            if ($getDateSaved) {
                return ApiFormatter::createApi(200, 'succes', $getDateSaved);
            }else {
                return ApiFormatter::createApi(400, 'failed');
            }
        }catch (Exception $error){
            return ApiFormatter::createApi(400, 'failed', $error);
        }
    }

    public function show($id)
    {
        try {
            $bookDetail = Book::where('id', $id)->first();

            if ($bookDetail) {
                return ApiFormatter::createApi(200, 'success', $bookDetail);
            }else{
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'book_code' => 'required',
                'name_book' => 'required',
                'image' => 'required',
            ]);

            $book = Book::findOrFail($id);

            $book->update([
                'book_code' => $request->book_code,
                'name_book' => $request->name_book,
                'image' => $request->image,
            ]);


            $updatedBook = Book::where('id', $book->id)->first();
            
            if ($updatedBook) {
                return ApiFormatter::createApi(200, 'success', $updatedBook);
            }else {
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            $book = Book::findOrFail($id);
            $proses = $book->delete();

            if ($proses) {
                return ApiFormatter::createApi(200, 'success delete data');
            }else{
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    public function createToken()
    {
        return csrf_token();
    }
}
