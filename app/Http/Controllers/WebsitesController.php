<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class WebsitesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $websites = Website::all();
        return response()->json($websites, 200);
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
            $validWebsite = $request->validate([
                'name' => ['required', 'unique:websites,name']
            ]);
            // Stores the website record
            $storedWebsite = Website::create([
                'name' => $validWebsite['name']
            ]);
            return response()->json($storedWebsite, 201);
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
            $website = Website::find($id);
            return response()->json($website, 200);
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
            $validWebsiteName = $request->validate([
                'name' => ['required', 'unique:websites,name']
            ]);
            $website = Website::find($id);
            if (isset($website)) {
                $isUpdated = $website->update([
                    'name' => $validWebsiteName['name']
                ]);
                return response()->json($website, 201);
            } else {
                return response()->json(['error' => 'Invalid website reference!'], 400);
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
            $website = Website::find($id);
            if (isset($website)) {
                if ($website->destroy($id)) {
                    return response()->json(['message' => "$website->name deleted successfully"], 200);
                } else {
                    return response()->json(['message' => "Error deleteing $website->name!"], 400);
                }
            } else {
                return response()->json(['error' => 'Invalid website reference!'], 400);
            }
        } catch (\Throwable $th) {
            dd($th);
            return response()->json(['error' => 'Something went wrong!'], 400);
        }
    }
}
