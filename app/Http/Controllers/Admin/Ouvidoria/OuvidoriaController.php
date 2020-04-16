<?php

namespace App\Http\Controllers\Admin\Ouvidoria;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ouvidoria;
use Auth;

class OuvidoriaController extends Controller
{
    private $ouvidoria = null;


    public function __construct(Ouvidoria $ouvidoria)
    {
        $this->ouvidoria = $ouvidoria;
    }

    public function index()
    {
        $ouvidorias = (Auth::user()->setor_id == 4) ? $this->ouvidoria->listAllOccurrencesInOmbudsman() : $this->ouvidoria->listAllOccurrencesWithCondition(Auth::user()->setor_id);
        return view('admin.ouvidoria.home', compact('ouvidorias'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
