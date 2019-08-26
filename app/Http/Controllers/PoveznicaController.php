<?php

namespace App\Http\Controllers;

use App\Poveznica;
use App\Skladiste;
use Illuminate\Http\Request;

class PoveznicaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Poveznica::where('user_id', auth()->user()->id)->get();
        return array_reverse($records);
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
        $temp = $request->input('materijali');
        foreach($temp as $item){
            $record = new Poveznica([
                'Sifra' => rand(10,100),
                'Id_Evidencija' => $request->input('Id_Evidencija'),
                'Id_Materijala' => $item['id'],
                'Kolicina' => $item['Kolicina'],
                'Cijena' => rand(10,100),
                'user_id' => auth()->user()->id
            ]);
            $record->save();
            $old = Skladiste::select('Kolicina')->where('id', $item['id'])->first()["Kolicina"];
            Skladiste::where('id', $item['id'])->update(array('Kolicina' => $old + $item['Kolicina']));
        }

        return response()->json($temp);
    }

    public function getDetails($id)
    {
        $temp = Poveznica::where('Id_Evidencija', $id)->get();
        $test = [];
        foreach ($temp as $item) {
            array_push($test, array(
                "id" => $item['id'],
                "Sifra" => $item['Sifra'],
                "Id_Evidencija" => $item['Id_Evidencija'],
                "Id_Materijala" => $item['Id_Materijala'],
                "Kolicina" => $item['Kolicina'],
                "Cijena" => $item['Cijena'],
                "Skladiste" => Skladiste::where('id', $item['Id_Materijala'])->first()
            ));
        }
        return response()->json($test);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Poveznica  $Poveznica
     * @return \Illuminate\Http\Response
     */
    public function show(Poveznica $Poveznica)
    {
        $record = Poveznica::find($Poveznica);
        return response()->json($record);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Poveznica  $Poveznica
     * @return \Illuminate\Http\Response
     */
    public function edit(Poveznica $Poveznica)
    {
        $record = Poveznica::find($Poveznica);
        return response()->json($record);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Poveznica  $Poveznica
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Poveznica $Poveznica)
    {
        $record = Poveznica::find($Poveznica);
        $record->update($request->all());

        return response()->json('The book successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Poveznica  $Poveznica
     * @return \Illuminate\Http\Response
     */
    public function destroy(Poveznica $Poveznica)
    {
        $record = Poveznica::find($Poveznica);
        $record->delete();

        return response()->json('The book successfully deleted');
    }
}
