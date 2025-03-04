<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function list(){

        $books = Book::all();

        return view('/admin.index',compact('books'));
    }
}
