<?php

namespace App\Http\Controllers;

use App\Mjesta;
use Illuminate\Http\Request;

class MjestaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Mjesta::where('user_id', auth()->user()->id)->get();
        return $records;
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
        $record = new Mjesta([
            'NazivMjesta' => $request->input('NazivMjesta'),
            'Adresa' => $request->input('Adresa'),
            'hasDetails' => $request->input('hasDetails'),
            'user_id' => auth()->user()->id
        ]);
        $record->save();

        return response()->json(array('success' => true, 'last_insert_id' => $record->id), 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mjesta  $Mjesta
     * @return \Illuminate\Http\Response
     */
    public function show(Mjesta $Mjesta)
    {
        $record = Mjesta::find($Mjesta);
        return response()->json($record);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mjesta  $Mjesta
     * @return \Illuminate\Http\Response
     */
    public function edit(Mjesta $Mjesta)
    {
        $record = Mjesta::find($Mjesta);
        return response()->json($record);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mjesta  $Mjesta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $record = Mjesta::find($id);
        $record->update($request->all());

        return response()->json(array('success' => true, 'last_insert_id' => $record->id), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mjesta  $Mjesta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mjesta $Mjesta)
    {
        $record = Mjesta::find($Mjesta);
        $record->delete();

        return response()->json('The book successfully deleted');
    }
}
