<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Solcompra;
use Illuminate\Http\Request;

class SolcompraController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
		$this->middleware('can:admin.solcompras.index')->only('index');
		$this->middleware('can:admin.solcompras.create')->only('create','store');
		$this->middleware('can:admin.solcompras.edit')->only('edit','update');
		// $this->middleware('can:admin.categorias.permission')->only('editpermission','updatepermission');
		// $this->middleware('can:admin.categorias.password')->only('editpassword','updatepassword');
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Solcompra $solcompra)
    {
        //
    }

    public function edit(Solcompra $solcompra)
    {
        //
    }

    public function update(Request $request, Solcompra $solcompra)
    {
        //
    }

    public function destroy(Solcompra $solcompra)
    {
        //
    }
}
