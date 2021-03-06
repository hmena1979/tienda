<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\AcopiadorImport;
use App\Imports\AfectacionImport;
use App\Imports\CamaraImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

use App\Imports\CategoriaImport;
use App\Imports\CatembarqueImport;
use App\Imports\CatproductoImport;
use App\Imports\ChoferImport;
use App\Imports\UMedidaImport;
use App\Imports\TipoComprobanteImport;
use App\Imports\DetraccionImport;
use App\Imports\DepartamentoImport;
use App\Imports\EmbarcacionImport;
use App\Imports\EmpacopiadoraImport;
use App\Imports\MpdImport;
use App\Imports\ProductoImport;
use App\Imports\ProvinciaImport;
use App\Imports\SaldoImport;
use App\Imports\TransportistaImport;
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

    public function Transportista(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo Transportista.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new TransportistaImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
    }

    public function camara(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo Cámara.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new CamaraImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
    }

    public function empacopiadora(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo EmpAcopiadora.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new EmpacopiadoraImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
    }

    public function acopiador(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo EmpAcopiadora.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new AcopiadorImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
    }

    public function chofer(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo Chofer.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new ChoferImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
    }

    public function embarcacion(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo Embarcaciones.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new EmbarcacionImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
    }

    public function producto(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo Productos.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new ProductoImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
    }

    public function saldo(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo Saldo.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new SaldoImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
    }

    public function mpd(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo MPD.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new MpdImport, $file);

    		return redirect('/admin/import')->with('message', 'Archivo importado')->with('typealert', 'success');
    	endif;
    }

    public function catembarque(Request $request)
    {
    	$rules = [
			'archivo' => 'required'
    	];
    	$messages = [
			'archivo.required' => 'No ha selecionado archivo CatEmbarque.xlsx'
    	];

    	$validator = validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
		else:
    		$file = $request->file('archivo');
    		Excel::import(new CatembarqueImport, $file);

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
