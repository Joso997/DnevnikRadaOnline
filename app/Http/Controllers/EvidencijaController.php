<?php

namespace App\Http\Controllers;

use App\Evidencija;
use App\Kalendar;
use App\Mjesta;
use Illuminate\Http\Request;

class EvidencijaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $temp = Evidencija::where('user_id', auth()->user()->id)->get();
        $test = [];
        foreach ($temp as $item) {
            array_push($test, array(
                "id" => $item['id'],
                "Sifra" => $item['Sifra'],
                "Id_Mjesta" => $item['Id_Mjesta'],
                "Datum" => $item['Datum'],
                "OpisPosla" => $item['OpisPosla'],
                "UtrosenoVrijeme" => $item['UtrosenoVrijeme'],
                "NazivMjesta" => Mjesta::select('NazivMjesta')->where('id', $item['Id_Mjesta'])->first()["NazivMjesta"]
            ));
        }
        return response()->json(array_reverse($test));
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

    public function statistika()
    {
        $test = array('names' => [], 'values' => []);
        $skl = Evidencija::where('user_id', auth()->user()->id)->get();

        foreach ($skl as $item){
            $temp = Poveznica::where('Id_Materijala', $item['id'])->where('user_id', auth()->user()->id)->get();
            if($temp != null){
                array_push($test['names'], $item['NazivMaterijala']);
                foreach ($temp as $t){
                    array_push($test['values'], array($item['NazivMaterijala'] => $t['Kolicina']));
                }
            }
        }
        return response()->json($test);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date = date('Y-m-d h:i:s', strtotime($request->input('Datum')));
        $record = new Evidencija([
            'Sifra' => $request->input('Sifra'),
            'Id_Mjesta' => $request->input('Id_Mjesta'),
            'Datum' => $date,
            'OpisPosla' => $request->input('OpisPosla'),
            'UtrosenoVrijeme' => $request->input('UtrosenoVrijeme'),
            'user_id' => auth()->user()->id
        ]);
        $record->save();
        $test = Kalendar::where('Id_Mjesta', $request->input('Id_Mjesta'))->where('Datum', date('Y-m-d', strtotime($request->input('Datum'))))->first();
        Kalendar::destroy($test['id']);
        return response()->json(array('success' => true, 'last_insert_id' => $record->id, 'test' => $test), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Evidencija  $evidencija
     * @return \Illuminate\Http\Response
     */
    public function show(Evidencija $evidencija)
    {
        $record = Evidencija::find($evidencija);
        return response()->json($record);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Evidencija  $evidencija
     * @return \Illuminate\Http\Response
     */
    public function edit(Evidencija $evidencija)
    {
        $record = Evidencija::find($evidencija);
        return response()->json($record);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Evidencija  $evidencija
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Evidencija $evidencija)
    {
        $record = Evidencija::find($evidencija);
        $record->update($request->all());

        return response()->json('The book successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Evidencija  $evidencija
     * @return \Illuminate\Http\Response
     */
    public function destroy(Evidencija $evidencija)
    {
        $record = Evidencija::find($evidencija);
        $record->delete();

        return response()->json('The book successfully deleted');
    }
}
