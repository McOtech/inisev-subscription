<?php

namespace App\Http\Controllers;

use App\Models\subscriber;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SubscribersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscribers = subscriber::all();
        return response()->json($subscribers, 200);
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
            $validSubscriber = $request->validate([
                'website_id' => ['required', 'exists:websites,id'],
                'email' => ['required', 'email', 'max:255']
            ]);
            // Check for any duplicate records in the system.
            $subscriber = subscriber::where(['email' => $validSubscriber['email'], 'website_id' => $validSubscriber['website_id']])->get();

            if (count($subscriber) > 0) {
                return response()->json(['message' => "You have already subscribed to this website. Thank you."], 200);
            }
            // Stores the website record
            $storedSubscriber = subscriber::create([
                'website_id' => $validSubscriber['website_id'],
                'email' => $validSubscriber['email']
            ]);
            return response()->json($storedSubscriber, 201);
        } catch (ValidationException $th) {
            return response()->json(['error' => $th->errors()], 400);
        } catch (Exception $th) {
            dd($th);
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
            $subscriber = subscriber::find($id);
            return response()->json($subscriber, 200);
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
            $validSubscriber = $request->validate([
                'email' => ['required', 'email', 'max:255']
            ]);
            $subscriber = subscriber::find($id);
            if (isset($subscriber)) {
                $isUpdated = $subscriber->update([
                    'email' => $validSubscriber['email']
                ]);
                return response()->json($subscriber, 201);
            } else {
                return response()->json(['error' => 'Invalid Subscriber reference!'], 400);
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
            $subscriber = subscriber::find($id);
            if (isset($subscriber)) {
                if ($subscriber->destroy($id)) {
                    return response()->json(['message' => "'$subscriber->email' unsubscribed successfully"], 200);
                } else {
                    return response()->json(['message' => "Error unsubscribing $subscriber->email!"], 400);
                }
            } else {
                return response()->json(['error' => 'Invalid Subscriber reference!'], 400);
            }
        } catch (\Throwable $th) {
            dd($th);
            return response()->json(['error' => 'Something went wrong!'], 400);
        }
    }
}
