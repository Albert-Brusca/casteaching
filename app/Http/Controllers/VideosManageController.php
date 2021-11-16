<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideosManageController extends Controller
{
    /** R-> Retrieve -> Llista
     */
    public function index()
    {
        return view('videos.manage.index');
    }

    /** C -> Create -> Mostrara el formulari de creació
     **/
    public function create()
    {
        //
    }

    /** C -> Create -> Guardara a la base de dades el nou video
     */
    public function store(Request $request)
    {
        //
    }

    /** R -> NO LLISTA -> Individual
     */
    public function show($id)
    {
        //
    }

    /** U -> Update -> Form
     */
    public function edit($id)
    {
        //
    }

    /** U -> Update -> Processarà el Form i guardara les modificacions
     */
    public function update(Request $request, $id)
    {
        //
    }

    /** D -> DELETE
     */
    public function destroy($id)
    {
        //
    }
}
