<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\AfectacionImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

use App\Imports\CategoriaImport;
use App\Imports\CatproductoImport;
use App\Imports\UMedidaImport;
use App\Imports\TipoComprobanteImport;
use App\Imports\DetraccionImport;
use App\Imports\DepartamentoImport;
use App\Imports\ProvinciaImport;
use App\Imports\UbigeoImport;

class ImportController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth');
		$this->middleware('isadmin');
        $this->middleware('can:admin.imports.index')->only('index');
    }

    public function index()
    {
        return view('admin.import.index');
    }

    public function categoria(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo Categoría.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new CategoriaImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
    }

    public function catproducto(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo Catproducto.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new CatproductoImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
    }

    public function umedida(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo UMedida.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new UMedidaImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
    }

    public function tipocomprobante(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo Comprobantes.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new TipoComprobanteImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
    }

    public function detraccion(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo Detracciones.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new DetraccionImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
	}

	public function afectacion(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo Afectacion.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new AfectacionImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
	}

	public function Departamento(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo Departamento.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new DepartamentoImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
    }

    public function Provincia(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo Provincia.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new ProvinciaImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
    }

    public function Ubigeo(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo Ubigeo.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new UbigeoImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
    }

    // public function postImportComprobante(Request $request)
    // {
    // 	$rules = [
	// 		'archivo' => 'required'
    // 	];
    // 	$messages = [
	// 		'archivo.required' => 'No ha selecionado archivo Comprobantes.xlsx'
    // 	];

    // 	$validator = validator::make($request->all(), $rules, $messages);
    // 	if($validator->fails()):
    // 		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
	// 	else:
    // 		$file = $request->file('archivo');
    // 		Excel::import(new ComprobanteImport, $file);

    // 		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    // 	endif;
	// }

    

    // public function postImportTipoNota(Request $request)
    // {
    // 	$rules = [
	// 		'archivo' => 'required'
    // 	];
    // 	$messages = [
	// 		'archivo.required' => 'No ha selecionado archivo TipoNota.xlsx'
    // 	];

    // 	$validator = validator::make($request->all(), $rules, $messages);
    // 	if($validator->fails()):
    // 		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
	// 	else:
    // 		$file = $request->file('archivo');
    // 		Excel::import(new TiponotaImport, $file);

    // 		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    // 	endif;
	// }


}
