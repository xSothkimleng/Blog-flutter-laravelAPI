<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCrimeRequest;
use App\Http\Resources\CrimeResource;
use App\Models\Crime;
use Illuminate\Http\Request;

class CrimeReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CrimeResource::collection(Crime::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCrimeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCrimeRequest $request){
        $validatedData = $request->validated();
        $crime = Crime::create($validatedData);
        return new CrimeResource($crime);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $crime = Crime::findOrFail($id);
        return response()->json($crime);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $crime = Crime::findOrFail($id);
        $crime->update($request->all());
        return new CrimeResource($crime);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $crime = Crime::findOrFail($id);
        $crime->delete();
        return response()->json(['message' => 'CrimeReport deleted successfully']);
    }
}