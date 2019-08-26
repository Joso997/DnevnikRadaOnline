<?php

namespace App\Http\Controllers;

use App\Poveznica;
use App\Skladiste;
use Illuminate\Http\Request;

class SkladisteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Skladiste::where('user_id', auth()->user()->id)->get();
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

    public function statistika()
    {
        $test = array('names' => [], 'values' => []);
        $skl = Skladiste::where('user_id', auth()->user()->id)->get();

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
        $record = new Skladiste([
            'Sifra' => $request->input('Sifra'),
            'NazivMaterijala' => $request->input('NazivMaterijala'),
            'Prodavac' => $request->input('Prodavac'),
            'Kolicina' => $request->input('Kolicina'),
            'MjernaJedinica' => $request->input('MjernaJedinica'),
            'Cijena' => $request->input('Cijena'),
            'user_id' => auth()->user()->id
        ]);
        $record->save();

        $recordPov = new Poveznica([
            'Sifra' => rand(10,100),
            'Id_Materijala' => $record->id,
            'Kolicina' => $request->input('Kolicina'),
            'Cijena' => rand(10,100),
            'user_id' => auth()->user()->id
        ]);
        $recordPov->save();

        return response()->json($record->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Skladiste  $Skladiste
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record = Skladiste::find($id);
        return response()->json($record);
    }


    public function check($id, $kolicina){
       $confirm = Skladiste::where('id', $id)->where('Kolicina', '>=', $kolicina)->exists();
       return response()->json($confirm);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Skladiste  $Skladiste
     * @return \Illuminate\Http\Response
     */
    public function edit(Skladiste $Skladiste)
    {
        $record = Skladiste::find($Skladiste);
        return response()->json($record);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Skladiste  $Skladiste
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $record = Skladiste::find($id);
        $record->update($request->all());

        return response()->json('The book successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Skladiste  $Skladiste
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $test = Skladiste::destroy($id);
        //$test = Skladiste::where('Id', $Id)->first();
        //$test->delete();

        return response()->json($test);
    }
}
