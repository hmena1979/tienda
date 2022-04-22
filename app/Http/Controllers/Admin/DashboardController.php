<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// use App\Models\Param;
Use App\Models\Empresa;
use App\Models\Sede;

use Spatie\Permission\Models\Permission;

class DashboardController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('isadmin');
        $this->middleware('can:admin.inicio')->only('getDashboard');
    }
    
    public function getDashboard()
    {
        if(Empresa::count() <> 0 && Sede::count() <> 0){
            return view('admin.dashboard');
        }else{
            return view('admin.cargainicial');
        }
        
    }

    public function cargainicial(Request $request)
    {
        // 736483522A
        $rules = [
    		'ruc' => 'required',
    		'razsoc' => 'required',
    		'usuario' => 'required',
    		'clave' => 'required',
    		'por_igv' => 'required',
    		'por_renta' => 'required',
    		'monto_renta' => 'required',
    		'nombre' => 'required',
    		'ubigeo' => 'required',
    		'direccion' => 'required',
    		'urbanizacion' => 'required',
    		'provincia' => 'required',
    		'departamento' => 'required',
    		'distrito' => 'required',
    		'pais' => 'required',
    		'factura_serie' => 'required',
    		'boleta_serie' => 'required',
    		'ncfac_serie' => 'required',
    		'ncbol_serie' => 'required',
    		'ndfac_serie' => 'required',
    		'ndbol_serie' => 'required',
    		'consumo_serie' => 'required',
    		'nota_serie' => 'required'
    	];
    	$messages = [
    		'ruc.required' => 'Ingrese RUC.',
    		'razsoc.required' => 'Ingrese Razón Social.',
    		'usuario.required' => 'Ingrese Usuario(SUNAT - SOL).',
    		'clave.required' => 'Clave(SUNAT - SOL).',
    		'por_igv.required' => 'Ingrese Porcentaje de IGV.',
    		'por_renta.required' => 'Ingrese Porcentaje de Renta 4ta Categoría.',
    		'monto_renta.required' => 'Ingrese Monto Máximo Rentas 4ta Categoría.',
    		'nombre.required' => 'Ingrese Nombre de la Sede.',
    		'ubigeo.required' => 'Ingrese UBIGEO.',
    		'direccion.required' => 'Ingrese Dirección.',
    		'urbanizacion.required' => 'Ingrese Urbanización.',
    		'provincia.required' => 'Ingrese Provincia.',
    		'departamento.required' => 'Ingrese Departamento.',
    		'distrito.required' => 'Ingrese Distrito.',
    		'pais.required' => 'Ingrese Pais.',
    		'factura_serie.required' => 'Ingrese Serie Factura.',
    		'boleta_serie.required' => 'Ingrese Serie Boleta.',
    		'ncfac_serie.required' => 'Ingrese Serie Nota de Crédito Facturas.',
    		'ncbol_serie.required' => 'Ingrese Serie Nota de Crédito Boletas.',
    		'ndfac_serie.required' => 'Ingrese Serie Nota de Débito Facturas.',
    		'ndbol_serie.required' => 'Ingrese Serie Nota de Débito Boletas.',
    		'consumo_serie.required' => 'Ingrese Serie de Consumo.',
    		'nota_serie.required' => 'Ingrese Serie Notas Internas.',
    	];

        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
    	}else{
            if(Empresa::count() == 0){
                Empresa::create([
                    'ruc' => e($request->input('ruc')),
                    'razsoc' => e($request->input('razsoc')),
                    'usuario' => e($request->input('usuario')),
                    'clave' => e($request->input('clave')),
                    'apitoken' => e($request->input('apitoken')),
                    'servidor' => e($request->input('servidor')),
                    'dominio' => e($request->input('dominio')),
                    'cuenta' => e($request->input('cuenta')),
                    'por_igv' => e($request->input('por_igv')),
                    'por_renta' => e($request->input('por_renta')),
                    'monto_renta' => e($request->input('monto_renta')),
                    'maximoboleta' => e($request->input('maximoboleta')),
                    'icbper' => e($request->input('icbper')),
                ]);
            }
            if(Sede::count() == 0){
                Sede::create([
                    'nombre' => e($request->input('nombre')),
					'principal' => 1,
                    'periodo' => e($request->input('periodo')),
                    'ubigeo' => e($request->input('ubigeo')),
                    'direccion' => e($request->input('direccion')),
                    'urbanizacion' => e($request->input('urbanizacion')),
                    'provincia' => e($request->input('provincia')),
                    'departamento' => e($request->input('departamento')),
                    'distrito' => e($request->input('distrito')),
                    'pais' => e($request->input('pais')),
                    'factura_serie' => e($request->input('factura_serie')),
                    'boleta_serie' => e($request->input('boleta_serie')),
                    'ncfac_serie' => e($request->input('ncfac_serie')),
                    'ncbol_serie' => e($request->input('ncbol_serie')),
                    'ndfac_serie' => e($request->input('ndfac_serie')),
                    'ndbol_serie' => e($request->input('ndbol_serie')),
                    'consumo_serie' => e($request->input('consumo_serie')),
                    'nota_serie' => e($request->input('nota_serie')),
                    'factura_conting_serie' => e($request->input('factura_conting_serie')),
                    'boleta_conting_serie' => e($request->input('boleta_conting_serie')),
                ]);
            }
			if(Cliente::count() == 0){
				Cliente::create([
					'tipdoc_id'=>'0',
					'numdoc' => '00000000',
					'razsoc' => 'VARIOS'
				]);
				Cliente::create([
					'tipdoc_id'=>'0',
					'numdoc' => '99999999',
					'razsoc' => 'EMPRESA'
				]);
				Cliente::create([
					'tipdoc_id'=>'0',
					'numdoc' => '11111111',
					'razsoc' => 'TRANSFERENCIAS'
				]);
	
			}
            return redirect()->route('logout');
        }
    }

    public function agregar_permiso($module_id,$module_name,$name, $description)
	{
		Permission::create([
			'module_id' => $module_id,
			'module_name' => $module_name,
			'name' => $name,
			'description' => $description
			]);
		return true;
	}

	public function permisosfaltantes()
	{
		// $this->agregar_permiso('1','INICIO','admin.compras','Puede Realizar Compras');
		// $this->agregar_permiso('1','INICIO','admin.ventas','Puede realizar Ventas');

		// $this->agregar_permiso('2','PROVEEDOR|CLIENTE','admin.clientes.index','Puede ver listado Proveedor|Cliente');
		// $this->agregar_permiso('2','PROVEEDOR|CLIENTE','admin.clientes.create','Puede agregar Proveedor|Cliente');
		// $this->agregar_permiso('2','PROVEEDOR|CLIENTE','admin.clientes.edit','Puede editar Proveedor|Cliente');
		// $this->agregar_permiso('2','PROVEEDOR|CLIENTE','admin.clientes.destroy','Puede eliminar Proveedor|Cliente');
		
		// $this->agregar_permiso('5','CATEGORIAS','admin.categorias.index','Puede ver listado Categorías');
		// $this->agregar_permiso('5','CATEGORIAS','admin.categorias.create','Puede agregar Categorías');
		// $this->agregar_permiso('5','CATEGORIAS','admin.categorias.edit','Puede editar Categorías');
		// $this->agregar_permiso('5','CATEGORIAS','admin.categorias.destroy','Puede eliminar Categorías');
		
		// $this->agregar_permiso('6','UNIDAD DE MEDIDA','admin.umedidas.index','Puede ver listado Unidades de Medida');
		// $this->agregar_permiso('6','UNIDAD DE MEDIDA','admin.umedidas.create','Puede agregar Unidades de Medida');
		// $this->agregar_permiso('6','UNIDAD DE MEDIDA','admin.umedidas.edit','Puede editar Unidades de Medida');
		// $this->agregar_permiso('6','UNIDAD DE MEDIDA','admin.umedidas.destroy','Puede eliminar Unidades de Medida');
		
		// $this->agregar_permiso('7','PRODUCTOS','admin.productos.index','Puede ver listado Productos');
		// $this->agregar_permiso('7','PRODUCTOS','admin.productos.create','Puede agregar Productos');
		// $this->agregar_permiso('7','PRODUCTOS','admin.productos.edit','Puede editar Productos');
		// $this->agregar_permiso('7','PRODUCTOS','admin.productos.destroy','Puede eliminar Productos');
		// $this->agregar_permiso('7','PRODUCTOS','admin.productos.price','Puede Asignar Precio Productos');
		
		// $this->agregar_permiso('8','TIPO DE COMPROBANTES','admin.tipocomprobantes.index','Puede ver listado Tipo de Comprobantes');
		// $this->agregar_permiso('8','TIPO DE COMPROBANTES','admin.tipocomprobantes.create','Puede agregar Tipo de Comprobantes');
		// $this->agregar_permiso('8','TIPO DE COMPROBANTES','admin.tipocomprobantes.edit','Puede editar Tipo de Comprobantes');
		// $this->agregar_permiso('8','TIPO DE COMPROBANTES','admin.tipocomprobantes.destroy','Puede eliminar Tipo de Comprobantes');
		
		// $this->agregar_permiso('9','REGISTRO DE COMPRAS','admin.rcompras.index','Puede ver listado Registro de Compras');
		// $this->agregar_permiso('9','REGISTRO DE COMPRAS','admin.rcompras.create','Puede agregar Registro de Compras');
		// $this->agregar_permiso('9','REGISTRO DE COMPRAS','admin.rcompras.edit','Puede editar Registro de Compras');
		// $this->agregar_permiso('9','REGISTRO DE COMPRAS','admin.rcompras.destroy','Puede eliminar Registro de Compras');
		
		// $this->agregar_permiso('10','REGISTRO DE VENTAS','admin.rventas.index','Puede ver listado Registro de Ventas');
		// $this->agregar_permiso('10','REGISTRO DE VENTAS','admin.rventas.create','Puede agregar Registro de Ventas');
		// $this->agregar_permiso('10','REGISTRO DE VENTAS','admin.rventas.edit','Puede editar Registro de Ventas');
		// $this->agregar_permiso('10','REGISTRO DE VENTAS','admin.rventas.destroy','Puede eliminar Registro de Ventas');

		// $this->agregar_permiso('11','CUENTAS','admin.cuentas.index','Puede ver listado Cuentas');
		// $this->agregar_permiso('11','CUENTAS','admin.cuentas.create','Puede agregar Cuentas');
		// $this->agregar_permiso('11','CUENTAS','admin.cuentas.edit','Puede editar Cuentas');
		// $this->agregar_permiso('11','CUENTAS','admin.cuentas.destroy','Puede eliminar Cuentas');
		
		// $this->agregar_permiso('12','DETRACCIONES','admin.detraccions.index','Puede ver listado Detracciones');
		// $this->agregar_permiso('12','DETRACCIONES','admin.detraccions.create','Puede agregar Detracciones');
		// $this->agregar_permiso('12','DETRACCIONES','admin.detraccions.edit','Puede editar Detracciones');
		// $this->agregar_permiso('12','DETRACCIONES','admin.detraccions.destroy','Puede eliminar Detracciones');
		
		// $this->agregar_permiso('13','TESORERIA','admin.tesorerias.index','Puede ver listado Tesoreria');
		// $this->agregar_permiso('13','TESORERIA','admin.tesorerias.create','Puede agregar Tesoreria');
		// $this->agregar_permiso('13','TESORERIA','admin.tesorerias.edit','Puede editar Tesoreria');
		// $this->agregar_permiso('13','TESORERIA','admin.tesorerias.destroy','Puede eliminar Tesoreria');
		
		// $this->agregar_permiso('14','CATEGORÍA PRODUCTOS','admin.catproductos.index','Puede ver listado Categoría Productos');
		// $this->agregar_permiso('14','CATEGORÍA PRODUCTOS','admin.catproductos.create','Puede agregar Categoría Productos');
		// $this->agregar_permiso('14','CATEGORÍA PRODUCTOS','admin.catproductos.edit','Puede editar Categoría Productos');
		// $this->agregar_permiso('14','CATEGORÍA PRODUCTOS','admin.catproductos.destroy','Puede eliminar Categoría Productos');
		
		// $this->agregar_permiso('15','INGRESOS ALMACEN','admin.ingresos.index','Puede ver listado Ingresos');
		// $this->agregar_permiso('15','INGRESOS ALMACEN','admin.ingresos.edit','Puede editar Ingresos');
		// $this->agregar_permiso('15','INGRESOS ALMACEN','admin.ingresos.adddet','Puede agregar detalles');
		
		// $this->agregar_permiso('16','PARAMETROS','admin.parametros.index','Puede ver Parametros');
		// $this->agregar_permiso('16','PARAMETROS','admin.parametros.empresaCreate','Puede agregar Empresas');
		// $this->agregar_permiso('16','PARAMETROS','admin.parametros.empresaEdit','Puede editar Empresas');
		// $this->agregar_permiso('16','PARAMETROS','admin.parametros.empresaDestroy','Puede eliminar Empresas');
		// $this->agregar_permiso('16','PARAMETROS','admin.parametros.sedeCreate','Puede agregar Sedes');
		// $this->agregar_permiso('16','PARAMETROS','admin.parametros.sedeEdit','Puede editar Sedes');
		// $this->agregar_permiso('16','PARAMETROS','admin.parametros.sedeDestroy','Puede eliminar Sedes');

		// $this->agregar_permiso('17','CONSUMOS','admin.consumos.index','Puede ver listado Consumos');
		// $this->agregar_permiso('17','CONSUMOS','admin.consumos.create','Puede agregar Consumos');
		// $this->agregar_permiso('17','CONSUMOS','admin.consumos.edit','Puede editar Consumos');
		// $this->agregar_permiso('17','CONSUMOS','admin.consumos.destroy','Puede eliminar Consumos');

		// $this->agregar_permiso('18','DESTINOS','admin.destinos.index','Puede ver listado Destinos');
		// $this->agregar_permiso('18','DESTINOS','admin.destinos.create','Puede agregar Destinos');
		// $this->agregar_permiso('18','DESTINOS','admin.destinos.edit','Puede editar Destinos');
		// $this->agregar_permiso('18','DESTINOS','admin.destinos.destroy','Puede eliminar Destinos');
		
		// $this->agregar_permiso('19','CENTROS DE COSTO','admin.ccostos.index','Puede ver listado Centro de Costo');
		// $this->agregar_permiso('19','CENTROS DE COSTO','admin.ccostos.create','Puede agregar Centro de Costo');
		// $this->agregar_permiso('19','CENTROS DE COSTO','admin.ccostos.edit','Puede editar Centro de Costo');
		// $this->agregar_permiso('19','CENTROS DE COSTO','admin.ccostos.destroy','Puede eliminar Centro de Costo');
		
		// $this->agregar_permiso('20','TRANSFERENCIAS','admin.transferencias.index','Puede ver listado Transferencias');
		// $this->agregar_permiso('20','TRANSFERENCIAS','admin.transferencias.create','Puede agregar Transferencias');
		// $this->agregar_permiso('20','TRANSFERENCIAS','admin.transferencias.edit','Puede editar Transferencias');
		// $this->agregar_permiso('20','TRANSFERENCIAS','admin.transferencias.destroy','Puede eliminar Transferencias');
		
		// $this->agregar_permiso('21','EMP ACOPIADORAS','admin.empacopiadoras.index','Puede ver listado Emp. Acopiadoras');
		// $this->agregar_permiso('21','EMP ACOPIADORAS','admin.empacopiadoras.create','Puede agregar Emp. Acopiadoras');
		// $this->agregar_permiso('21','EMP ACOPIADORAS','admin.empacopiadoras.edit','Puede editar Emp. Acopiadoras');
		// $this->agregar_permiso('21','EMP ACOPIADORAS','admin.empacopiadoras.destroy','Puede eliminar Emp. Acopiadoras');
		
		// $this->agregar_permiso('22','TRANSPORTISTAS','admin.transportistas.index','Puede ver listado Transportistas');
		// $this->agregar_permiso('22','TRANSPORTISTAS','admin.transportistas.create','Puede agregar Transportistas');
		// $this->agregar_permiso('22','TRANSPORTISTAS','admin.transportistas.edit','Puede editar Transportistas');
		// $this->agregar_permiso('22','TRANSPORTISTAS','admin.transportistas.destroy','Puede eliminar Transportistas');
		
		// $this->agregar_permiso('23','MATERIAS PRIMAS','admin.materiaprimas.index','Puede ver listado Materias Primas');
		// $this->agregar_permiso('23','MATERIAS PRIMAS','admin.materiaprimas.create','Puede agregar Materias Primas');
		// $this->agregar_permiso('23','MATERIAS PRIMAS','admin.materiaprimas.edit','Puede editar Materias Primas');
		// $this->agregar_permiso('23','MATERIAS PRIMAS','admin.materiaprimas.destroy','Puede eliminar Materias Primas');
		
		// $this->agregar_permiso('24','EMBARCACIONES','admin.embarcaciones.index','Puede ver listado Embarcaciones');
		// $this->agregar_permiso('24','EMBARCACIONES','admin.embarcaciones.create','Puede agregar Embarcaciones');
		// $this->agregar_permiso('24','EMBARCACIONES','admin.embarcaciones.edit','Puede editar Embarcaciones');
		// $this->agregar_permiso('24','EMBARCACIONES','admin.embarcaciones.destroy','Puede eliminar Embarcaciones');

		// return redirect()->route('admin.inicio')->with('update', 'Permisos Agregados');
		// return redirect()->route('admin.inicio')->with('update', 'Registro Actualizado');		
				// $this->agregar_permiso('6','TIPO DE PRODUCTO','admin.tipoproductos.index','Puede ver listado Tipo de Productos');
				// $this->agregar_permiso('6','TIPO DE PRODUCTO','admin.tipoproductos.create','Puede agregar Tipo de Productos');
				// $this->agregar_permiso('6','TIPO DE PRODUCTO','admin.tipoproductos.edit','Puede editar Tipo de Productos');
				// $this->agregar_permiso('6','TIPO DE PRODUCTO','admin.tipoproductos.destroy','Puede eliminar Tipo de Productos');
		return redirect()->route('admin.inicio')->with('message', 'Permisos Agregados')->with('typealert', 'success');
	}
}

