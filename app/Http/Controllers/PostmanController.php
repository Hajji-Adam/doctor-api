<?php

namespace App\Http\Controllers;

use App\Models\Postman;
use Illuminate\Http\Request;


class PostmanController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Postman::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required| max: 255',
            'age' => 'required'
            ]);

            $postman = Postman::create($fields);
            return $postman;
    }

    /**
     * Display the specified resource.
     */
    public function show(Postman $postman)
    {
        return $postman;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Postman $postman)
    {
        Gate::authorize('modify', $post);
        $fields = $request->validate([
            'name' => 'required| max: 255',
            'age' => 'required'
            ]);

            $postman->update($fields);
            return $postman;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Postman $postman)
    {
        Gate::authorize('modify', $post);
        $postman->delete();
        return ['message' => 'postman deleted'];
    }
}
