<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return json response
        return response()->json(
            [
                'message' => 'Todos retrieved successfully',
                'status' => 'success',
                'data' => Todo::all(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            'title' => 'required | string | max:255',
            'description' => 'required | string',
        ]);
        // check if validation fails
        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => 'Validation error',
                    'status' => 'error',
                    'data' => $validator->errors(),
                ],
                400
            );
        }
        // Insert to database
        $todo = Todo::create($request->all());
        // check if todo is created
        if ($todo) {
            // return json response
            return response()->json(
                [
                    'message' => 'Todo created successfully',
                    'status' => 'success',
                    'data' => $todo,
                ],
                201
            );
        } else {
            // return json response
            return response()->json(
                [
                    'message' => 'Todo not created',
                    'status' => 'error',
                ],
                400
            );
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // get todo by id from db
        $result = Todo::find($id);
        // check if todo is found
        if ($result) {
            // return json response
            return response()->json(
                [
                    'message' => 'Todo retrieved successfully',
                    'status' => 'success',
                    'data' => $result,
                ],
                200
            );
        } else {
            // return json response
            return response()->json(
                [
                    'message' => 'Todo not found',
                    'status' => 'error',
                ],
                404
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // validate request with validator
        $validator = Validator::make($request->all(), [
            'title' => 'string | max:255',
            'description' => 'string',
        ]);
        // check if validation fails
        if ($validator->fails()) {
            // return json response
            return response()->json([
                'message' => 'Validation failed',
                'status' => 'error',
                'data' => $validator->errors(),
            ]);
        }
        // update todo by id
        $result = Todo::where('id', $id)->update($request->all());
        // check if todo is updated
        if($result) {
            // return json response
            return response()->json([
                'message' => 'Todo updated successfully',
                'status' => 'success',
                'data' => Todo::find($id)
            ], 200);
        } else {
            // return json response
            return response()->json([
                'message' => 'Todo id not found',
                'status' => 'error',
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // delete from database
       $result = Todo::destroy($id);
         // check if todo is deleted
        if($result) {
            // return json response
            return response()->json([
                'message' => 'Todo deleted successfully',
                'status' => 'success',
            ], 200);
        } else {
            // return json response
            return response()->json([
                'message' => 'Todo id not found',
                'status' => 'error',
            ], 404);
        }
    }
}
