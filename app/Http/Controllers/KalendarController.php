<?php

namespace App\Http\Controllers;

use App\Kalendar;
use App\Mjesta;
use Illuminate\Http\Request;

class KalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($datum)
    {
        $date = date('Y-m-d', time());
        $test = array('termini' => [], 'obavijesti' => []);
        $datum = date('Y-m-d h:i:s', strtotime($datum));
        $start = date('Y-m-01', strtotime($datum));
        $end = date('Y-m-t', strtotime($datum));
        $termini = Kalendar::where('user_id', auth()->user()->id)->where('Datum', '>=', $start)->where('Datum', '<=', $end)->get();
        $obavijesti = Kalendar::where('user_id', auth()->user()->id)->where('Datum', '<=', $date)->take(2)->get();
        foreach ($termini as $item){
            array_push($test['termini'], array(
                "id" => $item['id'],
                "Id_Mjesta" => $item['Id_Mjesta'],
                "Datum" => date('Y-m-d', strtotime($item['Datum'])),
                "NazivMjesta" => Mjesta::select('NazivMjesta')->where('id', $item['Id_Mjesta'])->where('user_id', auth()->user()->id)->first()["NazivMjesta"]
            ));
        }
        foreach ($obavijesti as $item){
            array_push($test['obavijesti'], array(
                "id" => $item['id'],
                "Id_Mjesta" => $item['Id_Mjesta'],
                "Datum" => date('Y-m-d', strtotime($item['Datum'])),
                "NazivMjesta" => Mjesta::select('NazivMjesta')->where('id', $item['Id_Mjesta'])->where('user_id', auth()->user()->id)->first()["NazivMjesta"]
            ));
        }
        return response()->json($test);
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
        $temp = $request->input('datumi');
        $database_list = Kalendar::where('Id_Mjesta', $request->input('Id_Mjesta'))->get();
        $i = 0;
        if(sizeof($database_list) != 0){
            foreach ($database_list as $item){
                if($temp[$i] == $item['id'])
                    continue;
                else
                    Kalendar::destroy($item['id']);
            }
        }

        foreach($temp as $item) {
            $record = new Kalendar([
                'Id_Mjesta' => $request->input('Id_Mjesta'),
                'Datum' => $item['Datum'],
                'user_id' => auth()->user()->id
            ]);
            $record->save();
        }
        return response()->json($database_list);
    }

    public function getDetails($id)
    {
        $temp = Kalendar::where('Id_Mjesta', $id)->get();
        $test = [];
        foreach ($temp as $item) {
            array_push($test, array(
                "id" => $item['id'],
                "Sifra" => $item['Sifra'],
                "Id_Mjesta" => $item['Id_Mjesta'],
                "Datum" => date('Y-m-d', strtotime($item['Datum']))
            ));
        }
        return response()->json($test);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Kalendar  $Kalendar
     * @return \Illuminate\Http\Response
     */
    public function show(Kalendar $Kalendar)
    {
        $record = Kalendar::find($Kalendar);
        return response()->json($record);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Kalendar  $Kalendar
     * @return \Illuminate\Http\Response
     */
    public function edit(Kalendar $Kalendar)
    {
        $record = Kalendar::find($Kalendar);
        return response()->json($record);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kalendar  $Kalendar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        /*$temp = $request->input('datumi');
        foreach ($temp as $item){
            $record = Kalendar::find($item['id']);
            $record->name = $item['Datum'];

            $record->save();
            $record->update($item['Datum']->all());
        }*/

        return response()->json($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kalendar  $Kalendar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kalendar $Kalendar)
    {
        $record = Kalendar::find($Kalendar);
        $record->delete();

        return response()->json('The book successfully deleted');
    }
}
