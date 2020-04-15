<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;

class TestController extends Controller{

    public function showAllAuthors(){
        return response("GET ALL");
    }

    public function showOneAuthor($id){
        return response("GET ONE");
    }

    public function create(Request $request){
        return response("POST");
    }

    public function update($id, Request $request){
        return response("PUT");
    }

    public function delete($id){
        return response("DELETE");
    }

}

?>