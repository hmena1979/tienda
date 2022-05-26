// var base = location.protocol+'//'+location.host;

// var route = document.getElementsByName('routeName')[0].getAttribute('content');

// document.addEventListener('DOMContentLoaded',function(){
// 	if(route == 'producto_add'){
// 		var btn_search = document.getElementById('btn_search');
// 		var form_search = document.getElementById('form_search');
// 		if(btn_search){
// 			btn_search.addEventListener('click', function(e){
// 				e.preventDefault();
// 				if(form_search.style.display === 'block'){
// 					form_search.style.display = 'none';
// 				}else{
// 					form_search.style.display = 'block';
// 				}
// 			});
// 		}
// 		var btn_galeria = document.getElementById('btn_galeria');
// 		var img_galeria = document.getElementById('img_galeria');
// 		btn_galeria.addEventListener('click', function(){
// 			img_galeria.click();
// 		}, false);

// 		img_galeria.addEventListener('change', function(){
// 			document.getElementById('form_galeria').submit();
// 		});
// 	}
// 	route_active = document.getElementsByClassName('lk-'+route)[0].classList.add('active');
// });

// $(document).ready(function(){
// 	editor_init('editor');
// })

// $(document).ready(function(){
// 	editor_init('editor1');
// })

// function editor_init(field){	
// 	CKEDITOR.replace(field,{
// 		toolbar:[
// 		{ name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
// 		{ name: 'editing', items: [ 'Scayt' ] },
// 		{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
// 		{ name: 'insert', items: [ 'EasyImageUpload', 'Table', 'HorizontalRule', 'SpecialChar' ] },
// 		{ name: 'tools', items: [ 'Maximize' ] },
// 		{ name: 'document', items: [ 'Source' ] },
// 		'/',
// 		{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Strike', '-', 'RemoveFormat' ] },
// 		{ name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote' ] },
// 		{ name: 'styles', items: [ 'Styles', 'Format' ] }
// 		]
// 	});
// }

function NaNToCero(valor){
	if(isNaN(valor)){
		return 0.00;
	}else{
		return valor;
	}
}

function Redondea(valor, decimal){
	var resul = Math.round(valor*Math.pow(10,decimal))/Math.pow(10,decimal);
	return resul;
}

function sumarDias(pfecha,pdias){
	if(pdias==''){
		return pfecha;
	}
	var dias = parseInt(pdias);
	var dia = String(parseInt(pfecha.substr(8,2)));
	var mes = pfecha.substr(5,2);
	var anio = pfecha.substr(0,4);
	var fecha = new Date(anio+'/'+mes+'/'+dia);
	
	var tmpfecha = new Date();
	fecha.setDate(fecha.getDate() + dias);
	var nfecha = String(fecha.getFullYear()) + '-' + (String(fecha.getMonth() + 1)).padStart(2,0) + '-' + (String(fecha.getDate())).padStart(2,0);
	return nfecha;
}

function numeroOperacion(fecha){
	var dia = fecha.substr(8,2);
	var mes = fecha.substr(5,2);
	var anio = fecha.substr(0,4);
	return dia + mes + anio;
}

function hoy(){
	var tmpfecha = new Date();
	var nfecha = String(tmpfecha.getFullYear()) + '-' + (String(tmpfecha.getMonth() + 1)).padStart(2,0) + '-' + (String(tmpfecha.getDate())).padStart(2,0);
	return nfecha;
}

function numDoc(serie,numero){
	if(serie.length == 0){
		return(numero.trim());
	}else{
		return(serie.trim() + '-' + numero.trim());
	}
}

function busCadena(cadena, bus, ocurrencia){
	var c = 0;
	for(var i = 0; i < cadena.length; i++){
		if(cadena[i] == bus){
			c++;
		}
		if(c == ocurrencia){
			return i;
		}

	}
}

function Empty(e){
	switch(e){
		case "":
		case 0:
		case "0":
		case null:
		case false:
		case typeof(e)=="undefined":
			return true;
		default:
			return false;
	}
}

function NumberFormat(number, decimals, dec_point, thousands_point) {

    if (number == null || !isFinite(number)) {
        throw new TypeError("number is not valid");
    }

    if (!decimals) {
        var len = number.toString().split('.').length;
        decimals = len > 1 ? len : 0;
    }

    if (!dec_point) {
        dec_point = '.';
    }

    if (!thousands_point) {
        thousands_point = ',';
    }

    number = parseFloat(number).toFixed(decimals);

    number = number.replace(".", dec_point);

    var splitNum = number.split(dec_point);
    splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_point);
    number = splitNum.join(dec_point);

    return number;
}