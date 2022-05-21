<?php

use App\Http\Controllers\Admin\BusquedaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\CatproductoController;
use App\Http\Controllers\Admin\CcostoController;
use App\Http\Controllers\Admin\ImportController;
use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Admin\ConsumoController;
use App\Http\Controllers\Admin\CuentaController;
use App\Http\Controllers\Admin\DestinoController;
use App\Http\Controllers\Admin\TipoProductoController;
use App\Http\Controllers\Admin\UMedidaController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\TipoComprobanteController;
use App\Http\Controllers\Admin\DetraccionController;
use App\Http\Controllers\Admin\EmbarcacionController;
use App\Http\Controllers\Admin\EmpAcopiadoraController;
use App\Http\Controllers\Admin\ExcelController;
use App\Http\Controllers\Admin\GuiaController;
use App\Http\Controllers\Admin\IngresoController;
use App\Http\Controllers\Admin\MasivoController;
use App\Http\Controllers\Admin\MateriaPrimaController;
use App\Http\Controllers\Admin\MuelleController;
use App\Http\Controllers\Admin\ParametroController;
use App\Http\Controllers\Admin\PDFController;
// use App\Http\Controllers\Admin\RegistroCompraController;
use App\Http\Controllers\Admin\RcompraController;
use App\Http\Controllers\Admin\RventaController;
use App\Http\Controllers\Admin\SunatController;
use App\Http\Controllers\Admin\TesoreriaController;
use App\Http\Controllers\Admin\TransferenciaController;
use App\Http\Controllers\Admin\TransportistaController;

// Route::get('/', function () {
//     return 'Hola';
// });

Route::get('/', [DashboardController::class, 'getDashboard'])->name('admin.inicio');
Route::post('/cargainicial', [DashboardController::class, 'cargainicial'])->name('admin.cargainicial');
Route::get('/permisosfaltantes', [DashboardController::class, 'permisosfaltantes'])->name('admin.permisosfaltantes');

//Usuarios
Route::get('/usuarios/{status?}',[UsuarioController::class,'index'])->name('admin.usuarios.index');
Route::get('/usuario/create',[UsuarioController::class,'create'])->name('admin.usuarios.create');
Route::post('/usuario',[UsuarioController::class,'store'])->name('admin.usuarios.store');
Route::get('/usuario/{user}/edit',[UsuarioController::class,'edit'])->name('admin.usuarios.edit');
Route::put('/usuario/{user}/update',[UsuarioController::class,'update'])->name('admin.usuarios.update');
Route::get('/usuario/{user}/editpermission',[UsuarioController::class,'editpermission'])->name('admin.usuarios.editpermission');
Route::put('/usuario/{user}/updatepermission',[UsuarioController::class,'updatepermission'])->name('admin.usuarios.updatepermission');
Route::get('/usuario/{user}/password',[UsuarioController::class,'editpassword'])->name('admin.usuarios.editpassword');
Route::put('/usuario/{user}/password',[UsuarioController::class,'updatepassword'])->name('admin.usuarios.updatepassword');

Route::resource('roles', RoleController::class)->except('show')->names('admin.roles');

Route::get('/categorias/{module?}',[CategoriaController::class,'index'])->name('admin.categorias.index');
Route::get('/categorias/{module}/create',[CategoriaController::class,'create'])->name('admin.categorias.create');
Route::post('/categorias/store',[CategoriaController::class,'store'])->name('admin.categorias.store');
Route::get('/categorias/{categoria}/edit',[CategoriaController::class,'edit'])->name('admin.categorias.edit');
Route::put('/categorias/{categoria}/update',[CategoriaController::class,'update'])->name('admin.categorias.update');
Route::delete('/categorias/{categoria}/destroy',[CategoriaController::class,'destroy'])->name('admin.categorias.destroy');
// Route::resource('categorias', CategoriaController::class)->except('show')->names('admin.categorias');

Route::get('/catproductos/{module?}',[CatproductoController::class,'index'])->name('admin.catproductos.index');
Route::get('/catproductos/{module}/create',[CatproductoController::class,'create'])->name('admin.catproductos.create');
Route::post('/catproductos/store',[CatproductoController::class,'store'])->name('admin.catproductos.store');
Route::get('/catproductos/{catproducto}/edit',[CatproductoController::class,'edit'])->name('admin.catproductos.edit');
Route::put('/catproductos/{catproducto}/update',[CatproductoController::class,'update'])->name('admin.catproductos.update');
Route::delete('/catproductos/{catproductos}/destroy',[CatproductoController::class,'destroy'])->name('admin.catproductos.destroy');
// Route::resource('categorias', CategoriaController::class)->except('show')->names('admin.categorias');

Route::get('/clientes/registro', [ClienteController::class, 'ClienteRegistro'])->name('admin.clientes.registro');
Route::get('/clientes/{tipo}/{numero}/{id?}/busapi', [ClienteController::class, 'BusApi'])->name('admin.clientes.busapi');
Route::get('/clientes/{cliente}/valores', [ClienteController::class, 'valores'])->name('admin.clientes.valores');
Route::get('/clientes/{numdoc}/repetido', [ClienteController::class, 'repetido'])->name('admin.clientes.repetido');
Route::post('/clientes/storeAjax', [ClienteController::class, 'storeAjax'])->name('admin.clientes.storeAjax');
Route::post('/clientes/{cliente}/storedetalle', [ClienteController::class, 'storedetalle'])->name('admin.clientes.storedetalle');
// Route::get('/clientes/seleccionado/{search?}', [ClienteController::class, 'seleccionado'])->name('admin.clientes.seleccionado');
Route::get('/clientes/seleccionado/{tipo?}', [ClienteController::class, 'seleccionado'])->name('admin.clientes.seleccionado');
Route::get('/clientes/{cliente}/tablaitem', [ClienteController::class,'tablaitem'])->name('admin.clientes.tablaitem');
Route::get('/clientes/{detcliente}/destroyitem', [ClienteController::class,'destroyitem'])->name('admin.clientes.destroyitem');
Route::resource('clientes', ClienteController::class)->except('show')->names('admin.clientes');
// Route::get('/usuario', UsuarioController::class);

Route::resource('tipoproductos', TipoProductoController::class)->names('admin.tipoproductos');

Route::resource('umedidas', UMedidaController::class)->names('admin.umedidas');

Route::get('/productos/registro', [ProductoController::class, 'registro'])->name('admin.productos.registro');
Route::get('/productos/{producto}/tabla_dp', [ProductoController::class, 'tabla_dp'])->name('admin.productos.tabla_dp');
Route::get('/productos/{envio}/adddp', [ProductoController::class, 'adddp'])->name('admin.productos.adddp');
Route::get('/productos/{producto}/showdetp', [ProductoController::class, 'showdetp'])->name('admin.productos.showdetp');
Route::get('/productos/{detproducto}/destroydetp', [ProductoController::class, 'destroydetp'])->name('admin.productos.destroydetp');
Route::get('/productos/seleccionado/{grupo?}', [ProductoController::class, 'seleccionado'])->name('admin.productos.seleccionado');
Route::get('/productos/seleccionadov/{moneda?}/{grupo?}', [ProductoController::class, 'seleccionadov'])->name('admin.productos.seleccionadov');
Route::get('/productos/seleccionadoc/{moneda?}/{grupo?}', [ProductoController::class, 'seleccionadoc'])->name('admin.productos.seleccionadoc');
Route::get('/productos/{vencimiento}/selectlote', [ProductoController::class, 'selectlote'])->name('admin.productos.selectlote');
Route::get('/productos/{producto}/{bus}/findlote', [ProductoController::class, 'findlote'])->name('admin.productos.findlote');
Route::get('/productos/{producto}/{lote}/buslote', [ProductoController::class, 'buslote'])->name('admin.productos.buslote');
Route::resource('productos', ProductoController::class)->names('admin.productos');


Route::get('/cuentas/{moneda}/moneda', [CuentaController::class, 'moneda'])->name('admin.cuentas.moneda');
Route::resource('cuentas', CuentaController::class)->names('admin.cuentas');

Route::get('/destinos/{envio}/aedet', [DestinoController::class, 'aedet'])->name('admin.destinos.aedet');
Route::get('/destinos/{destino}/tablaitem', [DestinoController::class,'tablaitem'])->name('admin.destinos.tablaitem');
Route::get('/destinos/{detdestino}/detdestino', [DestinoController::class,'detdestino'])->name('admin.destinos.detdestino');
Route::get('/destinos/{detdestino}/destroyitem', [DestinoController::class,'destroyitem'])->name('admin.destinos.destroyitem');
Route::get('/destinos/{destino}/listdetalle', [DestinoController::class,'listdetalle'])->name('admin.destinos.listdetalle');
Route::resource('destinos', DestinoController::class)->names('admin.destinos');

Route::get('/empacopiadoras/{envio}/aedet', [EmpAcopiadoraController::class, 'aedet'])->name('admin.empacopiadoras.aedet');
Route::get('/empacopiadoras/{empacopiadora}/tablaitem', [EmpAcopiadoraController::class,'tablaitem'])->name('admin.empacopiadoras.tablaitem');
Route::get('/empacopiadoras/{acopiador}/acopiador', [EmpAcopiadoraController::class,'acopiador'])->name('admin.empacopiadoras.acopiador');
Route::get('/empacopiadoras/{acopiador}/destroyitem', [EmpAcopiadoraController::class,'destroyitem'])->name('admin.empacopiadoras.destroyitem');
Route::get('/empacopiadoras/{empacopiadora}/listdetalle', [EmpAcopiadoraController::class,'listdetalle'])->name('admin.empacopiadoras.listdetalle');
Route::resource('empacopiadoras', EmpAcopiadoraController::class)->names('admin.empacopiadoras');

Route::get('/transportistas/{envio}/aedet', [TransportistaController::class, 'aedet'])->name('admin.transportistas.aedet');
Route::get('/transportistas/{envio}/aedetcamara', [TransportistaController::class, 'aedetcamara'])->name('admin.transportistas.aedetcamara');
Route::get('/transportistas/{transportista}/tablaitem', [TransportistaController::class,'tablaitem'])->name('admin.transportistas.tablaitem');
Route::get('/transportistas/{transportista}/tablaitemcamara', [TransportistaController::class,'tablaitemcamara'])->name('admin.transportistas.tablaitemcamara');
Route::get('/transportistas/{chofer}/chofer', [TransportistaController::class,'chofer'])->name('admin.transportistas.chofer');
Route::get('/transportistas/{camara}/camara', [TransportistaController::class,'camara'])->name('admin.transportistas.camara');
Route::get('/transportistas/{chofer}/destroyitem', [TransportistaController::class,'destroyitem'])->name('admin.transportistas.destroyitem');
Route::get('/transportistas/{camara}/destroyitemcamara', [TransportistaController::class,'destroyitemcamara'])->name('admin.transportistas.destroyitemcamara');
Route::get('/transportistas/{transportista}/listdetalle', [TransportistaController::class,'listdetalle'])->name('admin.transportistas.listdetalle');
Route::get('/transportistas/{transportista}/listdetallecamara', [TransportistaController::class,'listdetallecamara'])->name('admin.transportistas.listdetallecamara');
Route::resource('transportistas', TransportistaController::class)->names('admin.transportistas');

Route::resource('/embarcaciones', EmbarcacionController::class)->names('admin.embarcaciones');

Route::resource('/muelles', MuelleController::class)->names('admin.muelles');

Route::get('/materiaprimas/{materiaprima}/tablaitem', [MateriaPrimaController::class,'tablaitem'])->name('admin.materiaprimas.tablaitem');
Route::get('/materiaprimas/{envio}/aedet', [MateriaPrimaController::class, 'aedet'])->name('admin.materiaprimas.aedet');
Route::get('/materiaprimas/{detmateriaprima}/detmateriaprima', [MateriaPrimaController::class,'detmateriaprima'])->name('admin.materiaprimas.detmateriaprima');
Route::get('/materiaprimas/{detmateriaprima}/destroyitem', [MateriaPrimaController::class,'destroyitem'])->name('admin.materiaprimas.destroyitem');
Route::resource('/materiaprimas', MateriaPrimaController::class)->names('admin.materiaprimas');

Route::resource('ccostos', CcostoController::class)->names('admin.ccostos');

Route::get('/detraccions/{codigo}/tasa', [DetraccionController::class, 'tasa'])->name('admin.detraccions.tasa');
Route::resource('detraccions', DetraccionController::class)->names('admin.detraccions');

Route::get('/tipocomprobantes/{codigo}/search', [TipoComprobanteController::class, 'search'])->name('admin.tipocomprobantes.search');
Route::resource('tipocomprobantes', TipoComprobanteController::class)->names('admin.tipocomprobantes');


Route::get('/rcompras/{fecha}/bustc', [RcompraController::class,'BusTc'])->name('admin.rcompras.bustc');
Route::post('/rcompras/change', [RcompraController::class,'change'])->name('admin.rcompras.change');
Route::get('/rcompras/{proveedor}/pendiente', [RcompraController::class,'pendiente'])->name('admin.rcompras.pendiente');
Route::get('/rcompras/{proveedor}/{lote}/materiaprima', [RcompraController::class,'materiaprima'])->name('admin.rcompras.materiaprima');
Route::get('/rcompras/{rcompra}/detrcompra', [RcompraController::class,'detrcompra'])->name('admin.rcompras.detrcompra');
Route::post('/rcompras/adddestino', [RcompraController::class,'adddestino'])->name('admin.rcompras.adddestino');
Route::get('/rcompras/{rcompra}/tablaitem', [RcompraController::class,'tablaitem'])->name('admin.rcompras.tablaitem');
Route::get('/rcompras/{detrcompra}/destroyitem', [RcompraController::class,'destroyitem'])->name('admin.rcompras.destroyitem');
Route::post('/rcompras/leerxml', [RcompraController::class,'leerXML'])->name('admin.rcompras.leerxml');
Route::resource('rcompras', RcompraController::class)->names('admin.rcompras');
Route::get('/rcompras/{periodo?}', [RcompraController::class,'index'])->name('admin.rcompras.index');
// Route::get('/registrocompra/create', [RegistroCompraController::class,'create'])->name('admin.registrocompras.create');
// Route::get('/registrocompra/create', [RegistroCompraController::class,'create'])->name('admin.registrocompras.create');

Route::post('/rventas/change', [RventaController::class,'change'])->name('admin.rventas.change');
Route::get('/rventas/{cliente}/pendiente', [RventaController::class,'pendiente'])->name('admin.rventas.pendiente');
Route::post('/rventas/additem', [RventaController::class,'additem'])->name('admin.rventas.additem');
Route::get('/rventas/{key}/{moneda}/tablaitem', [RventaController::class,'tablaitem'])->name('admin.rventas.tablaitem');
Route::get('/rventas/{rventa}/tablatotales', [RventaController::class,'tablatotales'])->name('admin.rventas.tablatotales');
Route::get('/rventas/{tmpdetsalida}/destroyitem', [RventaController::class,'destroyitem'])->name('admin.rventas.destroyitem');
Route::resource('rventas', RventaController::class)->names('admin.rventas');
Route::get('/rventas/{periodo?}', [RventaController::class,'index'])->name('admin.rventas.index');

Route::post('/masivos/change', [MasivoController::class,'change'])->name('admin.masivos.change');
Route::get('/masivos/{masivo}/tablaitem', [MasivoController::class,'tablaitem'])->name('admin.masivos.tablaitem');
Route::get('/masivos/{masivo}/pendientes', [MasivoController::class,'pendientes'])->name('admin.masivos.pendientes');
Route::post('/masivos/procesa', [MasivoController::class,'procesa'])->name('admin.masivos.procesa');
Route::get('/masivos/actualiza', [MasivoController::class,'actualiza'])->name('admin.masivos.actualiza');
Route::get('/masivos/{masivo}/autorizar', [MasivoController::class,'autorizar'])->name('admin.masivos.autorizar');
Route::get('/masivos/{masivo}/generar', [MasivoController::class,'generar'])->name('admin.masivos.generar');
Route::get('/masivos/{masivo}/download_macro', [MasivoController::class,'download_macro'])->name('admin.masivos.download_macro');
Route::get('/masivos/{masivo}/revertir', [MasivoController::class,'revertir'])->name('admin.masivos.revertir');
Route::get('/masivos/{detmasivo}/destroyitem', [MasivoController::class,'destroyitem'])->name('admin.masivos.destroyitem');
Route::resource('masivos', MasivoController::class)->names('admin.masivos');
Route::get('/masivos/{periodo?}', [MasivoController::class,'index'])->name('admin.masivos.index');

Route::post('/guias/change', [GuiaController::class,'change'])->name('admin.guias.change');
Route::post('/guias/additem', [GuiaController::class,'additem'])->name('admin.guias.additem');
Route::get('/guias/{key}/tablaitem', [GuiaController::class,'tablaitem'])->name('admin.guias.tablaitem');
Route::get('/guias/{tmpdetguia}/destroyitem', [GuiaController::class,'destroyitem'])->name('admin.guias.destroyitem');
Route::resource('guias', GuiaController::class)->names('admin.guias');
Route::get('/guias/{periodo?}', [GuiaController::class,'index'])->name('admin.guias.index');

Route::post('/consumos/change', [ConsumoController::class,'change'])->name('admin.consumos.change');
Route::post('/consumos/additem', [ConsumoController::class,'additem'])->name('admin.consumos.additem');
Route::get('/consumos/{key}/{moneda}/tablaitem', [ConsumoController::class,'tablaitem'])->name('admin.consumos.tablaitem');
Route::get('/consumos/{rventa}/tablatotales', [ConsumoController::class,'tablatotales'])->name('admin.consumos.tablatotales');
Route::get('/consumos/{tmpdetsalida}/destroyitem', [ConsumoController::class,'destroyitem'])->name('admin.consumos.destroyitem');
Route::resource('consumos', ConsumoController::class)->names('admin.consumos');
Route::get('/consumos/{periodo?}', [ConsumoController::class,'index'])->name('admin.consumos.index');

Route::post('/ingresos/change', [IngresoController::class,'change'])->name('admin.ingresos.change');
Route::post('/ingresos/{ingreso}/adddet', [IngresoController::class,'adddet'])->name('admin.ingresos.adddet');
Route::delete('/ingresos/{detingreso}/destroydet', [IngresoController::class,'destroydet'])->name('admin.ingresos.destroydet');
Route::resource('ingresos', IngresoController::class)->names('admin.ingresos');
Route::get('/ingresos/{periodo?}', [IngresoController::class,'index'])->name('admin.ingresos.index');
// Route::get('/registrocompra/create', [RegistroCompraController::class,'create'])->name('admin.registrocompras.create');
// Route::get('/registrocompra/create', [RegistroCompraController::class,'create'])->name('admin.registrocompras.create');

Route::post('/transferencias/change', [TransferenciaController::class,'change'])->name('admin.transferencias.change');
Route::resource('transferencias', TransferenciaController::class)->names('admin.transferencias');
Route::get('/transferencias/{periodo?}', [TransferenciaController::class,'index'])->name('admin.transferencias.index');

// Route::resource('tesorerias', TesoreriaController::class)->names('admin.tesorerias');
Route::get('/tesorerias/{periodo?}/{cuenta?}', [TesoreriaController::class,'index'])->name('admin.tesorerias.index');
Route::post('/tesoreria/change', [TesoreriaController::class,'change'])->name('admin.tesorerias.change');
Route::post('/tesoreria/store', [TesoreriaController::class,'store'])->name('admin.tesorerias.store');
Route::post('/tesoreria/{tesoreria}/detstore', [TesoreriaController::class,'detstore'])->name('admin.tesorerias.detstore');
Route::delete('/tesoreria/{dettesor}/detdestroy', [TesoreriaController::class,'detdestroy'])->name('admin.tesorerias.detdestroy');
Route::get('/tesoreria/{tesoreria}/edit', [TesoreriaController::class,'edit'])->name('admin.tesorerias.edit');
Route::put('/tesoreria/{tesoreria}/update', [TesoreriaController::class,'update'])->name('admin.tesorerias.update');
Route::delete('/tesoreria/{tesoreria}/destroy', [TesoreriaController::class,'destroy'])->name('admin.tesorerias.destroy');
Route::get('/tesoreria/{cuenta?}/create', [TesoreriaController::class,'create'])->name('admin.tesorerias.create');

//Parámetros: Empresa | Sede
Route::get('/parametros/empresacreate', [ParametroController::class,'empresaCreate'])->name('admin.parametros.empresaCreate');
Route::post('/parametros/empresastore', [ParametroController::class,'empresaStore'])->name('admin.parametros.empresaStore');
Route::get('/parametros/{empresa}/empresaedit', [ParametroController::class,'empresaEdit'])->name('admin.parametros.empresaEdit');
Route::put('/parametros/{empresa}/empresaupdate', [ParametroController::class,'empresaUpdate'])->name('admin.parametros.empresaUpdate');
Route::get('/parametros/sedecreate', [ParametroController::class,'sedeCreate'])->name('admin.parametros.sedeCreate');
Route::post('/parametros/sedestore', [ParametroController::class,'sedeStore'])->name('admin.parametros.sedeStore');
Route::get('/parametros/{sede}/sedeedit', [ParametroController::class,'sedeEdit'])->name('admin.parametros.sedeEdit');
Route::put('/parametros/{sede}/sedeupdate', [ParametroController::class,'sedeUpdate'])->name('admin.parametros.sedeUpdate');
Route::get('/parametros/{empresa?}', [ParametroController::class,'index'])->name('admin.parametros.index');

//Sunat
Route::get('/sunat/{rventa}/ventas', [SunatController::class, 'ventas'])->name('admin.sunat.ventas');
Route::get('/sunat/{guia}/guias', [SunatController::class, 'guias'])->name('admin.sunat.guias');

//PDF
Route::get('/pdf/{rventa}/facturacion', [PDFController::class,'facturacion'])->name('admin.pdf.facturacion');
Route::get('/pdf/{guia}/guia', [PDFController::class,'guia'])->name('admin.pdf.guia');
Route::get('/pdf/{rcompra}/ingresos', [PDFController::class,'ingresos'])->name('admin.pdf.ingresos');
Route::get('/pdf/{tesoreria}/tesoreria', [PDFController::class,'tesoreria'])->name('admin.pdf.tesoreria');
Route::get('/pdf/{masivo}/masivos', [PDFController::class,'masivos'])->name('admin.pdf.masivos');
Route::get('/pdf/{materiaprima}/materiaprima', [PDFController::class,'materiaprima'])->name('admin.pdf.materiaprima');

//EXCEL
Route::get('/excel/{desde}/{hasta}/materiaprima', [ExcelController::class,'materiaprima'])->name('admin.excel.materiaprima');

//Modulo importaciones
Route::get('/import', [ImportController::class,'index'])->name('admin.imports.index');
Route::post('/import/categoria', [ImportController::class,'categoria'])->name('admin.imports.categoria');
Route::post('/import/catproducto', [ImportController::class,'catproducto'])->name('admin.imports.catproducto');
Route::post('/import/umedida', [ImportController::class,'umedida'])->name('admin.imports.umedida');
Route::post('/import/tipocomprobante', [ImportController::class,'tipocomprobante'])->name('admin.imports.tipocomprobante');
Route::post('/import/detraccion', [ImportController::class,'detraccion'])->name('admin.imports.detraccion');
Route::post('/import/afectacion', [ImportController::class,'afectacion'])->name('admin.imports.afectacion');
Route::post('/import/departamento', [ImportController::class,'departamento'])->name('admin.imports.departamento');
Route::post('/import/provincia', [ImportController::class,'provincia'])->name('admin.imports.provincia');
Route::post('/import/ubigeo', [ImportController::class,'ubigeo'])->name('admin.imports.ubigeo');
Route::post('/import/transportista', [ImportController::class,'transportista'])->name('admin.imports.transportista');
Route::post('/import/camara', [ImportController::class,'camara'])->name('admin.imports.camara');
Route::post('/import/empacopiadora', [ImportController::class,'empacopiadora'])->name('admin.imports.empacopiadora');
Route::post('/import/acopiador', [ImportController::class,'acopiador'])->name('admin.imports.empacopiadora');
Route::post('/import/chofer', [ImportController::class,'chofer'])->name('admin.imports.chofer');
Route::post('/import/embarcacion', [ImportController::class,'embarcacion'])->name('admin.imports.embarcacion');

//Modulo Busquedas
Route::get('/busquedas/departamento', [BusquedaController::class,'departamento'])->name('admin.busquedas.departamento');
Route::get('/busquedas/{departamento}/provincia', [BusquedaController::class,'provincia'])->name('admin.busquedas.provincia');
Route::get('/busquedas/{provincia}/ubigeo', [BusquedaController::class,'ubigeo'])->name('admin.busquedas.ubigeo');
