<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($websiteId)
    {
        $posts = Post::where('website_id', $websiteId)->get();
        return response()->json($posts, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Validates user data
            $validPost = $request->validate([
                'website_id' => ['required', 'exists:websites,id'],
                'title' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string']
            ]);
            // Stores the website record
            $storedPost = Post::create([
                'website_id' => $validPost['website_id'],
                'title' => $validPost['title'],
                'description' => $validPost['description']
            ]);
            return response()->json($storedPost, 201);
        } catch (ValidationException $th) {
            return response()->json(['error' => $th->errors()], 400);
        } catch (Exception $th) {
            return response()->json(['error' => 'Something went wrong!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $post = Post::find($id);
            return response()->json($post, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Something went wrong!']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $validPost = $request->validate([
                'title' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string']
            ]);
            $post = Post::find($id);
            if (isset($post)) {
                $isUpdated = $post->update([
                    'title' => $validPost['title'],
                    'description' => $validPost['description']
                ]);
                return response()->json($post, 201);
            } else {
                return response()->json(['error' => 'Invalid Post reference!'], 400);
            }
        } catch (ValidationException $th) {
            return response()->json(['error' => $th->errors()], 400);
        } catch (Exception $th) {
            return response()->json(['error' => 'Something went wrong!'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $post = Post::find($id);
            if (isset($post)) {
                if ($post->destroy($id)) {
                    return response()->json(['message' => "'$post->title' deleted successfully"], 200);
                } else {
                    return response()->json(['message' => "Error deleteing $post->title!"], 400);
                }
            } else {
                return response()->json(['error' => 'Invalid Post reference!'], 400);
            }
        } catch (\Throwable $th) {
            dd($th);
            return response()->json(['error' => 'Something went wrong!'], 400);
        }
    }
}
