<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BusquedaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\CatembarqueController;
use App\Http\Controllers\Admin\CatproductoController;
use App\Http\Controllers\Admin\CcostoController;
use App\Http\Controllers\Admin\ImportController;
use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Admin\ConsumoController;
use App\Http\Controllers\Admin\ContrataController;
use App\Http\Controllers\Admin\CotizacionController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\CuentaController;
use App\Http\Controllers\Admin\DespieceController;
use App\Http\Controllers\Admin\DestinoController;
// use App\Http\Controllers\Admin\TipoProductoController;
use App\Http\Controllers\Admin\UMedidaController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\TipoComprobanteController;
use App\Http\Controllers\Admin\DetraccionController;
use App\Http\Controllers\Admin\EmbarcacionController;
use App\Http\Controllers\Admin\EmbarqueController;
use App\Http\Controllers\Admin\EmpAcopiadoraController;
use App\Http\Controllers\Admin\EnvasadoController;
use App\Http\Controllers\Admin\EnvasadocrudoController;
use App\Http\Controllers\Admin\EquipoenvasadoController;
use App\Http\Controllers\Admin\ExcelController;
use App\Http\Controllers\Admin\GuiaController;
use App\Http\Controllers\Admin\IngcamaraController;
use App\Http\Controllers\Admin\IngresoController;
use App\Http\Controllers\Admin\LoteController;
use App\Http\Controllers\Admin\MailController;
use App\Http\Controllers\Admin\MasivoController;
use App\Http\Controllers\Admin\MateriaPrimaController;
use App\Http\Controllers\Admin\MensajeriaController;
use App\Http\Controllers\Admin\MpobtenidaController;
use App\Http\Controllers\Admin\MuelleController;
use App\Http\Controllers\Admin\OrdcomprasController;
use App\Http\Controllers\Admin\ParametroController;
use App\Http\Controllers\Admin\ParteController;
use App\Http\Controllers\Admin\PDFController;
use App\Http\Controllers\Admin\PedidoController;
use App\Http\Controllers\Admin\PprocesoController;
use App\Http\Controllers\Admin\ProductoterminadoController;
use App\Http\Controllers\Admin\RcompraController;
use App\Http\Controllers\Admin\ResiduoController;
use App\Http\Controllers\Admin\RventaController;
use App\Http\Controllers\Admin\SalcamaraController;
use App\Http\Controllers\Admin\SaldoController;
use App\Http\Controllers\Admin\SolcompraController;
use App\Http\Controllers\Admin\SunatController;
use App\Http\Controllers\Admin\SupervisorController;
use App\Http\Controllers\Admin\TesoreriaController;
use App\Http\Controllers\Admin\TransferenciaController;
use App\Http\Controllers\Admin\TransportistaController;

// Route::get('/', function () {
//     return 'Hola';
// });

Route::get('/', [DashboardController::class, 'getDashboard'])->name('admin.inicio');
Route::post('/cargainicial', [DashboardController::class, 'cargainicial'])->name('admin.cargainicial');
Route::get('/permisosfaltantes', [DashboardController::class, 'permisosfaltantes'])->name('admin.permisosfaltantes');

//Lotes
Route::resource('lotes', LoteController::class)->except('show')->names('admin.lotes');

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
Route::get('/clientes/{detcliente}/detcliente', [ClienteController::class,'detcliente'])->name('admin.clientes.detcliente');
Route::get('/clientes/{cliente}/cuentas', [ClienteController::class,'cuentas'])->name('admin.clientes.cuentas');
Route::get('/clientes/actualizacuenta', [ClienteController::class,'actualizacuenta'])->name('admin.clientes.actualizacuenta');
Route::resource('clientes', ClienteController::class)->except('show')->names('admin.clientes');
// Route::get('/usuario', UsuarioController::class);

// Route::resource('tipoproductos', TipoProductoController::class)->names('admin.tipoproductos');

Route::resource('umedidas', UMedidaController::class)->names('admin.umedidas');

Route::get('/productos/registro', [ProductoController::class, 'registro'])->name('admin.productos.registro');
Route::get('/productos/{producto}/tabla_dp', [ProductoController::class, 'tabla_dp'])->name('admin.productos.tabla_dp');
Route::get('/productos/{envio}/adddp', [ProductoController::class, 'adddp'])->name('admin.productos.adddp');
Route::get('/productos/{producto}/showdetp', [ProductoController::class, 'showdetp'])->name('admin.productos.showdetp');
Route::get('/productos/{detproducto}/destroydetp', [ProductoController::class, 'destroydetp'])->name('admin.productos.destroydetp');
Route::get('/productos/seleccionado/{grupo?}', [ProductoController::class, 'seleccionado'])->name('admin.productos.seleccionado');
Route::get('/productos/seleccionadov/{moneda?}/{grupo?}', [ProductoController::class, 'seleccionadov'])->name('admin.productos.seleccionadov');
Route::get('/productos/seleccionadoc/{moneda?}/{grupo?}', [ProductoController::class, 'seleccionadoc'])->name('admin.productos.seleccionadoc');
Route::get('/productos/seleccionadot', [ProductoController::class, 'seleccionadot'])->name('admin.productos.seleccionadot');
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

Route::post('/materiaprimas/change', [MateriaPrimaController::class,'change'])->name('admin.materiaprimas.change');
Route::get('/materiaprimas/{materiaprima}/tablaitem', [MateriaPrimaController::class,'tablaitem'])->name('admin.materiaprimas.tablaitem');
Route::get('/materiaprimas/{envio}/aedet', [MateriaPrimaController::class, 'aedet'])->name('admin.materiaprimas.aedet');
Route::get('/materiaprimas/{detmateriaprima}/detmateriaprima', [MateriaPrimaController::class,'detmateriaprima'])->name('admin.materiaprimas.detmateriaprima');
Route::get('/materiaprimas/{detmateriaprima}/destroyitem', [MateriaPrimaController::class,'destroyitem'])->name('admin.materiaprimas.destroyitem');
Route::resource('/materiaprimas', MateriaPrimaController::class)->names('admin.materiaprimas');
Route::get('/materiaprimas/{periodo?}', [MateriaPrimaController::class,'index'])->name('admin.materiaprimas.index');

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
Route::get('/consumos/{rventa}/tabladevol', [ConsumoController::class,'tabladevol'])->name('admin.consumos.tabladevol');
Route::get('/consumos/{rventa}/tablatotales', [ConsumoController::class,'tablatotales'])->name('admin.consumos.tablatotales');
Route::get('/consumos/{tmpdetsalida}/destroyitem', [ConsumoController::class,'destroyitem'])->name('admin.consumos.destroyitem');
Route::get('/consumos/{detconsumo}/detconsumo', [ConsumoController::class,'detconsumo'])->name('admin.consumos.detconsumo');
Route::get('/consumos/{envio}/devolucion', [ConsumoController::class,'devolucion'])->name('admin.consumos.devolucion');
Route::resource('consumos', ConsumoController::class)->names('admin.consumos');
Route::get('/consumos/{periodo?}', [ConsumoController::class,'index'])->name('admin.consumos.index');

Route::post('/ingresos/change', [IngresoController::class,'change'])->name('admin.ingresos.change');
Route::post('/ingresos/{ingreso}/adddet', [IngresoController::class,'adddet'])->name('admin.ingresos.adddet');
Route::delete('/ingresos/{detingreso}/destroydet', [IngresoController::class,'destroydet'])->name('admin.ingresos.destroydet');
Route::get('/ingresos/{ingreso}/{ordcompra}/cargaoc', [IngresoController::class,'cargaoc'])->name('admin.ingresos.cargaoc');
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

// Cotizaciones
Route::post('/cotizacions/change', [CotizacionController::class,'change'])->name('admin.cotizacions.change');
Route::get('/cotizacions/{cotizacion}/tablaitem', [CotizacionController::class,'tablaitem'])->name('admin.cotizacions.tablaitem');
Route::get('/cotizacions/{detcotizacion}/destroyitem', [CotizacionController::class,'destroyitem'])->name('admin.cotizacions.destroyitem');
Route::post('/cotizacions/additem', [CotizacionController::class,'additem'])->name('admin.cotizacions.additem');
Route::get('/cotizacions/{detcotizacion}/edititem', [CotizacionController::class,'edititem'])->name('admin.cotizacions.edititem');
Route::get('/cotizacions/{cotizacion}/genoc', [CotizacionController::class,'genoc'])->name('admin.cotizacions.genoc');
Route::resource('cotizacions', CotizacionController::class)->names('admin.cotizacions');
Route::get('/cotizacions/{periodo?}', [CotizacionController::class,'index'])->name('admin.cotizacions.index');

// Pedidos
Route::post('/pedidos/change', [PedidoController::class,'change'])->name('admin.pedidos.change');
Route::get('/pedidos/{pedido}/tablaitem', [PedidoController::class,'tablaitem'])->name('admin.pedidos.tablaitem');
Route::get('/pedidos/{detpedido}/destroyitem', [PedidoController::class,'destroyitem'])->name('admin.pedidos.destroyitem');
Route::post('/pedidos/additem', [PedidoController::class,'additem'])->name('admin.pedidos.additem');
Route::get('/pedidos/{pedido}/enviar', [PedidoController::class,'enviar'])->name('admin.pedidos.enviar');
Route::get('/pedidos/{envio}/recepcionado', [PedidoController::class,'recepcionado'])->name('admin.pedidos.recepcionado');
Route::get('/pedidos/{envio}/rechazar', [PedidoController::class,'rechazar'])->name('admin.pedidos.rechazar');
Route::get('/pedidos/{envio}/atender', [PedidoController::class,'atender'])->name('admin.pedidos.atender');
Route::get('/pedidos/{detpedido}/detpedido', [PedidoController::class,'detpedido'])->name('admin.pedidos.detpedido');
Route::get('/pedidos/{envio}/editdetpedido', [PedidoController::class,'editdetpedido'])->name('admin.pedidos.editdetpedido');
Route::resource('pedidos', PedidoController::class)->names('admin.pedidos');
Route::get('/pedidos/{periodo?}', [PedidoController::class,'index'])->name('admin.pedidos.index');

//Orden de Compra
Route::post('/ordcompras/change', [OrdcomprasController::class,'change'])->name('admin.ordcompras.change');
Route::get('/ordcompras/busproducto/{producto_id?}', [OrdcomprasController::class,'busproducto'])->name('admin.ordcompras.busproducto');
Route::get('/ordcompras/{detcotizacion}/genoc', [OrdcomprasController::class,'genoc'])->name('admin.ordcompras.genoc');
Route::get('/ordcompras/{producto_id}/consumos', [OrdcomprasController::class,'consumos'])->name('admin.ordcompras.consumos');
Route::get('/ordcompras/{producto_id}/compras', [OrdcomprasController::class,'compras'])->name('admin.ordcompras.compras');
Route::get('/ordcompras/{producto_id}/cotizaciones', [OrdcomprasController::class,'cotizaciones'])->name('admin.ordcompras.cotizaciones');
Route::get('/ordcompras/{ordcompra}/tablaitem', [OrdcomprasController::class,'tablaitem'])->name('admin.ordcompras.tablaitem');
Route::get('/ordcompras/{detordcompra}/destroyitem', [OrdcomprasController::class,'destroyitem'])->name('admin.ordcompras.destroyitem');
Route::get('/ordcompras/{detordcompra}/edititem', [OrdcomprasController::class,'edititem'])->name('admin.ordcompras.edititem');
Route::get('/ordcompras/{ordcompra}/finalizar', [OrdcomprasController::class,'finalizar'])->name('admin.ordcompras.finalizar');
Route::get('/ordcompras/{ordcompra}/autorizar', [OrdcomprasController::class,'autorizar'])->name('admin.ordcompras.autorizar');
Route::get('/ordcompras/{ordcompra}/abrir', [OrdcomprasController::class,'abrir'])->name('admin.ordcompras.abrir');
Route::post('/ordcompras/additem', [OrdcomprasController::class,'additem'])->name('admin.ordcompras.additem');
Route::resource('ordcompras', OrdcomprasController::class)->names('admin.ordcompras');
Route::get('/ordcompras/{periodo?}', [OrdcomprasController::class,'index'])->name('admin.ordcompras.index');

//Materia Prima Obtenidas
// Route::resource('mpobtenidas', MpobtenidaController::class)->names('admin.mpobtenidas');
Route::get('/mpobtenidas', [MpobtenidaController::class,'index'])->name('admin.mpobtenidas.index');
Route::get('/mpobtenidas/{envio}/aedet', [MpobtenidaController::class, 'aedet'])->name('admin.mpobtenidas.aedet');
Route::get('/mpobtenidas/{producto}/tablaitem', [MpobtenidaController::class,'tablaitem'])->name('admin.mpobtenidas.tablaitem');
Route::get('/mpobtenidas/{mpobtenida}/mpobtenida', [MpobtenidaController::class,'mpobtenida'])->name('admin.mpobtenidas.mpobtenida');
Route::get('/mpobtenidas/{mpobtenida}/destroyitem', [MpobtenidaController::class,'destroyitem'])->name('admin.mpobtenidas.destroyitem');

//Despice
Route::get('/despieces/{envio}/aedet', [DespieceController::class, 'aedet'])->name('admin.despieces.aedet');
Route::get('/despieces/{despiece}/tablaitem', [DespieceController::class,'tablaitem'])->name('admin.despieces.tablaitem');
Route::get('/despieces/{detdespiece}/detdespiece', [DespieceController::class,'detdespiece'])->name('admin.despieces.detdespiece');
Route::get('/despieces/{detdespiece}/destroyitem', [DespieceController::class,'destroyitem'])->name('admin.despieces.destroyitem');
Route::get('/despieces/{despiece}/listdetalle', [DespieceController::class,'listdetalle'])->name('admin.despieces.listdetalle');
Route::resource('despieces', DespieceController::class)->names('admin.despieces');

//Productos Proceso
Route::get('/pprocesos/{envio}/aedet', [PprocesoController::class, 'aedet'])->name('admin.pprocesos.aedet');
Route::get('/pprocesos/{pproceso}/tablaitem', [PprocesoController::class,'tablaitem'])->name('admin.pprocesos.tablaitem');
Route::get('/pprocesos/{trazabilidad}/trazabilidad', [PprocesoController::class,'trazabilidad'])->name('admin.pprocesos.trazabilidad');
Route::post('/pprocesos/aetrazabilidad', [PprocesoController::class,'aetrazabilidad'])->name('admin.pprocesos.aetrazabilidad');
Route::get('/pprocesos/{trazabilidad}/tablaitem', [PprocesoController::class,'tablaitem'])->name('admin.pprocesos.tablaitem');
Route::post('/pprocesos/addeditdet', [PprocesoController::class,'addeditdet'])->name('admin.pprocesos.addeditdet');
Route::get('/pprocesos/{dettrazabilidad}/dettrazabilidad', [PprocesoController::class,'dettrazabilidad'])->name('admin.pprocesos.dettrazabilidad');
Route::get('/pprocesos/{trazabilidad}/trazabilidad', [PprocesoController::class,'trazabilidad'])->name('admin.pprocesos.trazabilidad');
Route::get('/pprocesos/{trazabilidad}/destroytrazabilidad', [PprocesoController::class,'destroytrazabilidad'])->name('admin.pprocesos.destroytrazabilidad');
Route::get('/pprocesos/{dettrazabilidad}/destroyitem', [PprocesoController::class,'destroyitem'])->name('admin.pprocesos.destroyitem');
Route::get('/pprocesos/{trazabilidad}/listdetalle', [PprocesoController::class,'listdetalle'])->name('admin.pprocesos.listdetalle');
Route::resource('pprocesos', PprocesoController::class)->names('admin.pprocesos');
Route::get('/pprocesos/edit/{pproceso}/{trazabilidad?}', [PprocesoController::class,'edit'])->name('admin.pprocesos.edit');

//Supervisores
Route::resource('supervisors', SupervisorController::class)->names('admin.supervisors');

//Equipo de Envasado
Route::resource('equipoenvasados', EquipoenvasadoController::class)->names('admin.equipoenvasados');

//Planilla de Envasado
Route::post('/envasados/change', [EnvasadoController::class,'change'])->name('admin.envasados.change');
Route::get('/envasados/{envasado}/tablaitem', [EnvasadoController::class,'tablaitem'])->name('admin.envasados.tablaitem');
Route::post('/envasados/additem', [EnvasadoController::class,'additem'])->name('admin.envasados.additem');
Route::get('/envasados/{detenvasado}/detenvasado', [EnvasadoController::class,'detenvasado'])->name('admin.envasados.detenvasado');
Route::get('/envasados/{detenvasado}/destroyitem', [EnvasadoController::class,'destroyitem'])->name('admin.envasados.destroyitem');
Route::get('/envasados/{envasado}/aprobar', [EnvasadoController::class,'aprobar'])->name('admin.envasados.aprobar');
Route::get('/envasados/{envasado}/abrir', [EnvasadoController::class,'abrir'])->name('admin.envasados.abrir');
Route::resource('envasados', EnvasadoController::class)->names('admin.envasados');
Route::get('/envasados/{periodo?}', [EnvasadoController::class,'index'])->name('admin.envasados.index');

//Planilla de Envasado Crudo
Route::post('/envasadocrudos/change', [EnvasadocrudoController::class,'change'])->name('admin.envasadocrudos.change');
Route::get('/envasadocrudos/{envasado}/tablaitem', [EnvasadocrudoController::class,'tablaitem'])->name('admin.envasadocrudos.tablaitem');
Route::post('/envasadocrudos/additem', [EnvasadocrudoController::class,'additem'])->name('admin.envasadocrudos.additem');
Route::get('/envasadocrudos/{detenvasado}/detenvasado', [EnvasadocrudoController::class,'detenvasado'])->name('admin.envasadocrudos.detenvasado');
Route::get('/envasadocrudos/{detenvasado}/destroyitem', [EnvasadocrudoController::class,'destroyitem'])->name('admin.envasadocrudos.destroyitem');
Route::get('/envasadocrudos/{envasado}/aprobar', [EnvasadocrudoController::class,'aprobar'])->name('admin.envasadocrudos.aprobar');
Route::get('/envasadocrudos/{envasado}/abrir', [EnvasadocrudoController::class,'abrir'])->name('admin.envasadocrudos.abrir');
Route::resource('envasadocrudos', EnvasadocrudoController::class)->parameters(['envasadocrudos' => 'envasado'])->names('admin.envasadocrudos');
Route::get('/envasadocrudos/{periodo?}', [EnvasadocrudoController::class,'index'])->name('admin.envasadocrudos.index');

//Parte de Producción
Route::post('/partes/change', [ParteController::class,'change'])->name('admin.partes.change');
Route::get('/partes/{parte}/tablaitem', [ParteController::class,'tablaitem'])->name('admin.partes.tablaitem');
Route::get('/partes/{parte}/tablaitemcamara', [ParteController::class,'tablaitemcamara'])->name('admin.partes.tablaitemcamara');
Route::get('/partes/{parte}/tablaitemconsumo', [ParteController::class,'tablaitemconsumo'])->name('admin.partes.tablaitemconsumo');
Route::get('/partes/{parte}/generar', [ParteController::class,'generar'])->name('admin.partes.generar');
Route::get('/partes/{parte}/finalizar', [ParteController::class,'finalizar'])->name('admin.partes.finalizar');
Route::get('/partes/{parte}/abrir', [ParteController::class,'abrir'])->name('admin.partes.abrir');
Route::resource('partes', ParteController::class)->names('admin.partes');
Route::get('/partes/{periodo?}', [ParteController::class,'index'])->name('admin.partes.index');

//Equipo de Envasado
Route::resource('contratas', ContrataController::class)->names('admin.contratas');

//Planilla de Ingreso a Camaras
Route::post('/ingcamaras/change', [IngcamaraController::class,'change'])->name('admin.ingcamaras.change');
Route::get('/ingcamaras/{ingcamara}/tablaitem', [IngcamaraController::class,'tablaitem'])->name('admin.ingcamaras.tablaitem');
Route::post('/ingcamaras/additem', [IngcamaraController::class,'additem'])->name('admin.ingcamaras.additem');
Route::get('/ingcamaras/{detingcamara}/detingcamara', [IngcamaraController::class,'detingcamara'])->name('admin.ingcamaras.detingcamara');
Route::get('/ingcamaras/{detingcamara}/destroyitem', [IngcamaraController::class,'destroyitem'])->name('admin.ingcamaras.destroyitem');
Route::get('/ingcamaras/{ingcamara}/aprobar', [IngcamaraController::class,'aprobar'])->name('admin.ingcamaras.aprobar');
Route::get('/ingcamaras/{ingcamara}/abrir', [IngcamaraController::class,'abrir'])->name('admin.ingcamaras.abrir');
Route::resource('ingcamaras', IngcamaraController::class)->names('admin.ingcamaras');
Route::get('/ingcamaras/{periodo?}', [IngcamaraController::class,'index'])->name('admin.ingcamaras.index');

//Residuos Sólidos
Route::post('/residuos/change', [ResiduoController::class,'change'])->name('admin.residuos.change');
Route::resource('residuos', ResiduoController::class)->names('admin.residuos');
Route::get('/residuos/{periodo?}', [ResiduoController::class,'index'])->name('admin.residuos.index');

//Ciudades
Route::resource('countries', CountryController::class)->names('admin.countries');

//Planilla de Salida a Camaras
Route::post('/salcamaras/change', [SalcamaraController::class,'change'])->name('admin.salcamaras.change');
Route::post('/salcamaras/aedetsalcamara', [SalcamaraController::class,'aedetsalcamara'])->name('admin.salcamaras.aedetsalcamara');
Route::get('/salcamaras/{detsalcamara}/tablaitem', [SalcamaraController::class,'tablaitem'])->name('admin.salcamaras.tablaitem');
Route::get('/salcamaras/{detsalcamara}/listdetalle', [SalcamaraController::class,'listdetalle'])->name('admin.salcamaras.listdetalle');
Route::post('/salcamaras/addeditdet', [SalcamaraController::class,'addeditdet'])->name('admin.salcamaras.addeditdet');
Route::get('/salcamaras/{detdetsalcamara}/detdetsalcamara', [SalcamaraController::class,'detdetsalcamara'])->name('admin.salcamaras.detdetsalcamara');
Route::get('/salcamaras/{detsalcamara}/detsalcamara', [SalcamaraController::class,'detsalcamara'])->name('admin.salcamaras.detsalcamara');
Route::get('/salcamaras/{detsalcamara}/destroydetsalcamara', [SalcamaraController::class,'destroydetsalcamara'])->name('admin.salcamaras.destroydetsalcamara');
Route::get('/salcamaras/{detdetsalcamara}/destroyitem', [SalcamaraController::class,'destroyitem'])->name('admin.salcamaras.destroyitem');
Route::get('/salcamaras/{productoterminado}/productoterminado', [SalcamaraController::class,'productoterminado'])->name('admin.salcamaras.productoterminado');
Route::get('/salcamaras/{salcamara}/aprobar', [SalcamaraController::class,'aprobar'])->name('admin.salcamaras.aprobar');
Route::get('/salcamaras/{salcamara}/abrir', [SalcamaraController::class,'abrir'])->name('admin.salcamaras.abrir');
Route::resource('salcamaras', SalcamaraController::class)->names('admin.salcamaras');
Route::get('/salcamaras/{periodo?}', [SalcamaraController::class,'index'])->name('admin.salcamaras.index');
Route::get('/salcamaras/edit/{salcamara}/{detsalcamara?}', [SalcamaraController::class,'edit'])->name('admin.salcamaras.edit');

//Embarques
Route::post('/embarques/change', [EmbarqueController::class,'change'])->name('admin.embarques.change');
Route::get('/embarques/{lote}/valores',[EmbarqueController::class,'valores'])->name('admin.embarques.valores');
Route::resource('embarques', EmbarqueController::class)->names('admin.embarques');
Route::get('/embarques/{periodo?}', [EmbarqueController::class,'index'])->name('admin.embarques.index');

//Categoria Embarques
Route::get('/catembarques/{module?}',[CatembarqueController::class,'index'])->name('admin.catembarques.index');
Route::get('/catembarques/{module}/create',[CatembarqueController::class,'create'])->name('admin.catembarques.create');
Route::post('/catembarques/store',[CatembarqueController::class,'store'])->name('admin.catembarques.store');
Route::get('/catembarques/{catembarque}/edit',[CatembarqueController::class,'edit'])->name('admin.catembarques.edit');
Route::put('/catembarques/{catembarque}/update',[CatembarqueController::class,'update'])->name('admin.catembarques.update');
Route::delete('/catembarques/{catembarque}/destroy',[CatembarqueController::class,'destroy'])->name('admin.catembarques.destroy');

// Solicitud de Compra
Route::post('/solcompras/change', [SolcompraController::class,'change'])->name('admin.solcompras.change');
Route::get('solcompras/{solcompra}/tablaitem', [SolcompraController::class,'tablaitem'])->name('admin.solcompras.tablaitem');
Route::get('solcompras/{solcompra}/buscapedidos', [SolcompraController::class,'buscapedidos'])->name('admin.solcompras.buscapedidos');
Route::get('/solcompras/{detsolcompra}/detsolcompra', [SolcompraController::class,'detsolcompra'])->name('admin.solcompras.detsolcompra');
Route::get('/solcompras/{envio}/editdetsolcompra', [SolcompraController::class,'editdetsolcompra'])->name('admin.solcompras.editdetsolcompra');
Route::get('/solcompras/{detsolcompra}/destroyitem', [SolcompraController::class,'destroyitem'])->name('admin.solcompras.destroyitem');
Route::post('/solcompras/additem', [SolcompraController::class,'additem'])->name('admin.solcompras.additem');
// Route::get('/solcompras/{solcompra}/enviar', [SolcompraController::class,'enviar'])->name('admin.solcompras.enviar');
// Route::get('/solcompras/{envio}/recepcionado', [SolcompraController::class,'recepcionado'])->name('admin.solcompras.recepcionado');
// Route::get('/solcompras/{envio}/rechazar', [SolcompraController::class,'rechazar'])->name('admin.solcompras.rechazar');
// Route::get('/solcompras/{envio}/atender', [SolcompraController::class,'atender'])->name('admin.solcompras.atender');
Route::resource('solcompras', SolcompraController::class)->names('admin.solcompras');
Route::get('/solcompras/{periodo?}', [SolcompraController::class,'index'])->name('admin.solcompras.index');

//Saldo Inicial Producto Terminado
Route::resource('productoterminados', ProductoterminadoController::class)->names('admin.productoterminados');

//Regenera Saldos de Productos
Route::get('/saldos/gregenera', [SaldoController::class,'gregenera'])->name('admin.saldos.gregenera');
Route::post('/saldos/pregenera', [SaldoController::class,'pregenera'])->name('admin.saldos.pregenera');
Route::get('/saldos/cierremes/{periodo?}', [SaldoController::class,'cierremes'])->name('admin.saldos.cierremes');
Route::resource('saldos', SaldoController::class)->names('admin.saldos');

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

//Mensajeria e-mail
Route::get('/mensajerias/{modulo?}',[MensajeriaController::class,'index'])->name('admin.mensajerias.index');
Route::get('/mensajerias/{modulo}/create',[MensajeriaController::class,'create'])->name('admin.mensajerias.create');
Route::post('/mensajerias/store',[MensajeriaController::class,'store'])->name('admin.mensajerias.store');
Route::get('/mensajerias/{mensajeria}/edit',[MensajeriaController::class,'edit'])->name('admin.mensajerias.edit');
Route::put('/mensajerias/{mensajeria}/update',[MensajeriaController::class,'update'])->name('admin.mensajerias.update');
Route::delete('/mensajerias/{mensajeria}/destroy',[MensajeriaController::class,'destroy'])->name('admin.mensajerias.destroy');
Route::get('/mensajerias/{masivo}/tesoreria', [MensajeriaController::class,'tesoreria'])->name('admin.mensajerias.tesoreria');
Route::get('/mensajerias/{pedido}/pedido', [MensajeriaController::class,'pedido'])->name('admin.mensajerias.pedido');

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
Route::get('/pdf/{ordcompra}/ordcompra', [PDFController::class,'ordcompra'])->name('admin.pdf.ordcompra');
Route::get('/pdf/{tipo}/{tipoproducto_id}/productos', [PDFController::class,'productos'])->name('admin.pdf.productos');
Route::get('/pdf/{envasado}/envasado', [PDFController::class,'envasado'])->name('admin.pdf.envasado');
Route::get('/pdf/{ingcamara}/ingcamara', [PDFController::class,'ingcamara'])->name('admin.pdf.ingcamara');
Route::get('/pdf/{salcamara}/salcamara', [PDFController::class,'salcamara'])->name('admin.pdf.salcamara');
Route::get('/pdf/{residuo}/residuo', [PDFController::class,'residuo'])->name('admin.pdf.residuo');
Route::get('/pdf/{pedido}/pedido', [PDFController::class,'pedido'])->name('admin.pdf.pedido');
Route::get('/pdf/{solcompra}/solcompra', [PDFController::class,'solcompra'])->name('admin.pdf.solcompra');

//EXCEL
Route::get('/excel/{desde}/{hasta}/materiaprima', [ExcelController::class,'materiaprima'])->name('admin.excel.materiaprima');
Route::get('/excel/{desde}/{hasta}/materiaprimaii', [ExcelController::class,'materiaprimaii'])->name('admin.excel.materiaprimaii');
Route::get('/excel/tolvasindex', [ExcelController::class,'tolvasindex'])->name('admin.excel.tolvasindex');
Route::get('/excel/procesoindex', [ExcelController::class,'procesoindex'])->name('admin.excel.procesoindex');
Route::post('/excel/tolvasview', [ExcelController::class,'tolvasview'])->name('admin.excel.tolvasview');
Route::post('/excel/residuos', [ExcelController::class,'residuos'])->name('admin.excel.residuos');
Route::get('/excel/{parte}/parte', [ExcelController::class,'parte'])->name('admin.excel.parte');
Route::get('/excel/resumentrazabilidad', [ExcelController::class,'resumentrazabilidad'])->name('admin.excel.resumentrazabilidad');
Route::get('/excel/resumencodigo', [ExcelController::class,'resumencodigo'])->name('admin.excel.resumencodigo');

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
Route::post('/import/producto', [ImportController::class,'producto'])->name('admin.imports.producto');
Route::post('/import/producto', [ImportController::class,'producto'])->name('admin.imports.producto');
Route::post('/import/mpd', [ImportController::class,'mpd'])->name('admin.imports.mpd');
Route::post('/import/saldo', [ImportController::class,'saldo'])->name('admin.imports.saldo');
Route::post('/import/catembarque', [ImportController::class,'catembarque'])->name('admin.imports.catembarque');

//Modulo Busquedas
Route::get('/busquedas/departamento', [BusquedaController::class,'departamento'])->name('admin.busquedas.departamento');
Route::get('/busquedas/{departamento}/provincia', [BusquedaController::class,'provincia'])->name('admin.busquedas.provincia');
Route::get('/busquedas/{provincia}/ubigeo', [BusquedaController::class,'ubigeo'])->name('admin.busquedas.ubigeo');
Route::get('/busquedas/{pproceso}/trazabilidad', [BusquedaController::class,'trazabilidad'])->name('admin.busquedas.trazabilidad');
Route::get('/busquedas/{trazabilidad}/dettrazabilidad', [BusquedaController::class,'dettrazabilidad'])->name('admin.busquedas.dettrazabilidad');
