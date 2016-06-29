//EL ARCHIVO SE ENCUENTRA INICIALIZADO DESDE EL ARCHIVO main.PHP 
//El archivo "mantenedores.js" fue creado pensando en las necesidades de los mantenedores del sitio y 
	//NO necesariamente es el archivo principal de la aplicación 
	//por contener funciones que sólo son usadas en los mantenedores
$.yiimailbox={};
var baseURL ="";
$(document).ready(function() {
	baseURL = $("#urlSitioWeb").val();
	asignacionModals();
	//changeImageDependingAccess();
	validarAnchoTabla();
});


//var baseURL = '/gore';
/*function changeImageDependingAccess(){
	$("table.items td.changeImage").each(function(){
		if($(this).html()=='1'){
			$(this).siblings('.button-column').children('a').children('img').attr('src',$("#urlSitioWeb").val()+'/images/view.png')
		}
	});
}*/


/*function successDeleteRow(){
	mensajeParaMantenedor('El registro se elimino correctamente.');
	asignacionModals();
}*/

//Validando que el ancho de la tabla no supere los valores asignados como máximo. Esto puede pasar al colocar un link demasiado largo
function validarAnchoTabla(){
	//En caso de utilizar mas de una grilla en la misma página
	$('.grid-view').each(function(){
		if($(this).children('table').width() > $(this).width()){
			$(this).children('table').children('tbody').children('tr').each(function(){				
				$(this).children('td').each(function(){					
					var words=$(this).text().split(' ');
					for (var i = 0; i < words.length; i++){
						if(words[i].length >40){	
							//Debemos validar que sea solo texto antes de realizar un replace
							if($(this).find('input, textarea, select').length==0)
								 $(this).html($(this).html().replace(words[i],words[i].substring(0, 40)+'...'));					
						}
			        }
				});
			});
		}
	});	
}

function afterAjaxUpdateSuccess(){
	//mensajeParaMantenedor('La solicitud se ha procesado con exito.');
	validarAnchoTabla();
	asignacionModals();
}

function asignacionModals(){
	$(".update,.button-column .view").colorbox({overlayClose:false,iframe:true,fastIframe:false, width:"990", height:"90%", title:true,
		onComplete: function(){
			var x= $('.cboxIframe')[0].contentWindow.document.body;
			var title = $(x).find('.form').eq(0).find('h3').eq(0).html();
			if($(x).find('.form').eq(0).find('h3').eq(0).attr('rel')){
				title=$(x).find('.form').eq(0).find('h3').eq(0).attr('rel');
			}    
            $('#cboxTitle').text(title);
        }
	});
	
	$(".modalIndice").colorbox({overlayClose:false,iframe:true,fastIframe:false, width:"990", height:"90%", title:true,
		onComplete: function(){
			var x= $('.cboxIframe')[0].contentWindow.document.body;
			var title = $(x).find('.form').eq(0).find('h3').eq(0).html();
			if(!$(x).find('.form').eq(0).find('h3').eq(0).attr('rel')){
				title=$(x).find('.form').eq(0).find('h3').eq(0).attr('rel');
			} 
			$('#cboxTitle').text(title);
        }
	});
	
	$(".MenuOperations").not('.NoModal').find('li a').colorbox({overlayClose:false,iframe:true,fastIframe:false, width:"990",height:"90%",  
		onComplete: function(){
			var x= $('.cboxIframe')[0].contentWindow.document.body;
			var title = $(x).find('.form').eq(0).find('h3').eq(0).html();
			if(!$(x).find('.form').eq(0).find('h3').eq(0).attr('rel')){
				title=$(x).find('.form').eq(0).find('h3').eq(0).attr('rel');
			} 
			$('#cboxTitle').text(title);
        }
	});
}

/*function cambiarTituloModal(){
	$.colorbox({rel: 'gal', title:true});
}*/

//Al momento de actualizar un dato al interior de un formulario con un grilla, esta pantalla no se cierre automatica, 
//se debe cerrar con el boton cerrar respectivo del modal, en este caso debemos actualizar la grilla principal cuando 
//se cierre la página que se actualizo. Un ejemplo se encuentra en el formulario de edición de Actividades.
function actualizarCierreModal(){
	$(document).bind('cbox_closed', function(){
	       $(document).unbind('cbox_closed');
	       actualizarDatosDeListasYGrillas();       
	});
}

function cerrarModal(){
	$.colorbox.close();
	actualizarDatosDeListasYGrillas();
}

function actualizarDatosDeListasYGrillas(){
	 $('.grid-view').each(function(){
		 $.fn.yiiGridView.update(''+$(this).attr('id'),{
		        complete: function(jqXHR, status) {
		            if (status=='success'){
		            	mensajeParaMantenedor('Los datos han sido actualizados exitosamente.');
		            }
		        }
		 });
	 });
	 $('.list-view').each(function(){
		 $.fn.yiiListView.update(''+$(this).attr('id'),{
		        complete: function(jqXHR, status) {
		            if (status=='success'){
		            	mensajeParaMantenedor('Los datos han sido actualizados exitosamente.');
		            }
		        }
		 });
	 });
}

//Actualizar campo de asociación de elementos de gestión con Responsables

function actualizarElementosDeGestionConResponsables(){//
	$.colorbox.close();
	$.fn.yiiGridView.update('elementos-gestion-responsables',{
	        complete: function(jqXHR, status) {
	            if (status=='success'){
	            	if(!$("#mensajeSuccess").html()){
	            	    $("#tabs2 h3").eq(0).after('<span id="mensajeSuccess" class="required">Los datos han sido actualizados exitosamente.</span>');
	            	}
	            	$("#mensajeSuccess").fadeOut(6000).delay(1000).queue(function() { $(this).remove(); });
	            }
	        }
	 });
}

function mostrarElementosDeGestion(id){
	
	var action = baseURL + '/elementosGestionPriorizados/obtenerElementosDeGestion/'+id;
	
	// se pide al action la lista de productos de la categoria seleccionada
	$.getJSON(action, function(listaJson) {
		
		// el action devuelve los productos en su forma JSON, el iterador "$.each" los separará.
		// limpiar el combo
		$('#elementoGestion').find('option').each(function(){ $(this).remove(); });
		$('#elementoGestion').append("<option value='0'>Seleccione Elemento de Gestion</option>");
		
		if(listaJson!=''){
			$.each(listaJson, function(key, scriterio) {
	
				$('#elementoGestion').append("<option value='"+scriterio.id+"'>"
				+scriterio.nombre+"</option>");
			});
		}else{
			mensajeParaMantenedor("No se encuentran Elementos de Gestión");
		}		
	}).error(function(e){ 
			mensajeParaMantenedor(e.responseText);
		});

	
}

function agregarElementodeGestion(periodoActual, idElementoGestion){
	
	//console.log(periodoActual);
	
	
	if(!periodoActual)
	{
		mensajeParaMantenedor("Periodo actual no está definido, No es realizar la operación.");
		return false;
	}else if(idElementoGestion == 0){
		mensajeParaMantenedor("Selector de elemento de gestión, Se encuentra vacio");
		return false;
	}else{

		var action = baseURL + '/elementosGestionPriorizados/create/'+idElementoGestion;
		$.getJSON(action, function(listaJson) {
		if(listaJson ==true){
			mensajeParaMantenedor("Registros Guardados!!!");
			$.fn.yiiGridView.update("elementos-gestion-priorizados-grid");
		}else{
			mensajeParaMantenedor("Existen un elemento de gestión asociado a los datos ingresados");
		}		
		}).error(function(e){ 
			mensajeParaMantenedor(e.responseText);
		});
		
		
	}
	
	
}

function mensajeParaMantenedor(mensaje){
	if(!$("#mensajeSuccess").html()){
	    $("#content h3").eq(0).after('<span id="mensajeSuccess" class="required">'+mensaje+'</span>');
	}
	$("#mensajeSuccess").fadeOut(6000).delay(1000).queue(function() { $(this).remove(); });


}

function mostrarProductosEstrategicos(id)
{
	//oculta Boton agregar
	$("#btnAgregar").hide();
	$("#labelSubproducto").hide();
	var idcategoria = id; // el "value" de ese <option> seleccionado

	// limpiar el combo productoEspecifico
	$("#subProducto option:not(:eq(0))").remove();
	$('#productoEspecifico option:not(:eq(0))').remove();
	$('#productoEstrategico').empty().append("<option value='0'>Cargando...</option>");
	$('#grillaDatos').hide('slow');
	
	var action = baseURL + '/indicadores/obtenerProductos/'+idcategoria;
	
	// se pide al action la lista de productos de la categoria seleccionada
	$.getJSON(action, function(listaJson) {
		//
		// el action devuelve los productos en su forma JSON, el iterador "$.each" los separará.
		//
		// limpiar el combo productoEstrategico		
		$('#productoEstrategico').empty().append("<option value='0'>Producto Estratégico</option>");
		
		$.each(listaJson, function(key, producto) {
			$('#productoEstrategico').append("<option value='"+producto.id+"'>"+producto.nombre+"</option>");
		});
		
	}).error(function(e){ 
		mensajeParaMantenedor(e.responseText);
		$('#productoEspecifico').append("<option value='0'>Productos Específicos</option>");
		});

}
function mostrarSubProductos(id)
{
		//oculta Boton agregar
		$("#btnAgregar").hide();
		$("#labelSubproducto").hide();	
		// limpiar el combo productoEspecifico

		$('#productoEspecifico').empty().append("<option value='0'>Productos Específicos</option>");
		$('#subProducto').empty().append("<option cc='0' value='0'>Cargando...</option>");
	
		//$('#productoEspecifico').find('option').each(function(){ $(this).remove(); });
		//$('#productoEspecifico').append("<option value='0'>Productos Específicos</option>");
		$('#grillaDatos').hide('slow');
	
	var action = baseURL + '/indicadores/obtenerSubProductos/'+id;
	

	$.getJSON(action, function(listaJson) {		
		
		// limpiar el combo de  subproductos
		$('#subProducto').empty().append("<option cc='0' value='0'>SubProducto</option>");
		
		//Preguntamos si la lista contiene datos
		if(listaJson!=''){
			$.each(listaJson, function(key, producto) {
				$('#subProducto').append("<option cc='"+producto.centro_costo_id+"' value='"+producto.id+"'>"
				+producto.nombre+"</option>");
			});
			

		}else{
			mensajeParaMantenedor("No se encuentran registros para SubProducto");
		}
	}).error(function(e){ 
		mensajeParaMantenedor(e.responseText);
		$('#subProducto').append("<option cc='0' value='0'>SubProducto</option>");
		});
	
}
function mostrarProductosEspecificos(id)
{	
	//oculta Boton agregar
	$("#btnAgregar").hide();
	$("#labelSubproducto").hide();
	var action = baseURL + '/indicadores/obtenerProductosEspecificos/'+id;
	$('#productoEspecifico').empty().append("<option value='0'>Cargando...</option>");
	$.getJSON(action, function(listaJson) {
		//console.debug(listaJson);
		// limpiar el combo de  subproductos
		$('#productoEspecifico').empty().append("<option value='0'>Productos Específicos</option>");
		
		//Preguntamos si la lista contiene datos
		if(listaJson!=''){
			$.each(listaJson, function(key, producto) {
				$('#productoEspecifico').append("<option value='"+producto.id+"'>"
				+producto.nombre+"</option>");
			});
			
		}else{
			mensajeParaMantenedor("No se encuentran registros para Productos Específicos");
		}
	}).error(function(e){ 
		$('#productoEspecifico').empty().append("<option value='0'>Productos Específicos</option>");
		mensajeParaMantenedor(e.responseText);
		});	
}
/**************************************
 * mostrarIndicadores
 * 
 * **********************************/
function mostrarIndicadores(id)
{
	$("#labelSubproducto").hide();
	if(id != 0) {
		//Centro de Costo del SubProducto
		var cc= $("#subProducto option:selected").attr('cc');
		
		
		var action = baseURL + '/centrosCostos/centroCostoPorIdUsuario/';
	
	// se pide al action la lista de productos de la categoria seleccionada
	$.getJSON(action, function(data) {
		//console.debug(data);
		$.each(data, function(key, items) {
			
			if (items.centro_id==cc){
				//Mostrar Boton agregar
				$("#btnAgregar").show();				
			}
		});
		
		if(!$("#btnAgregar").is(':visible')){
			$("#labelSubproducto").show();
		}
		
	}).error(function(e){ 
		console.debug(e);
		});
		
		
		
		
		//Actualizar Grilla con el filtro del producto especifico
		$.fn.yiiGridView.update('indicadores-grid', {
              data: '&Indicadores[producto_especifico_id]='+id });
              
		//eliminar los datos
		$("#indicadores-grid tbody").remove();
		$("#indicadores-grid .pager").remove();
		
		//Mostramos la grilla y el boton guardar
		$('#grillaDatos').show('slow');	 	
		return;
	}else{
		$('#grillaDatos').hide('slow');
		
	}
	
}
function abrirModal(url){
	var direccion = baseURL+url;
	 $.fn.colorbox({width:"80%", height:"80%",overlayClose:false, iframe:true, href:direccion});
}
function createIndicador(agregar){
	
	
	if(agregar == 0 ){

		mensajeParaMantenedor("Selector Productos Especificos Se Encuentra Vacio.");
	
	}else{
			
	//	var indice_productoEstrategico = productoEstrategico.selectedIndex
	//	var indice_subProducto = subProducto.selectedIndex
	
	//	var nombre_productoEstrategico = productoEstrategico.options[indice_productoEstrategico].text
	//	var nombre_subProducto = productoEstrategico.options[indice_subProducto].text
		var url = '/indicadores/create/'+$("#productoEspecifico").val();	
		//var url = '/indicadores/create/'+productoEspecifico.value;
		abrirModal(url);
	}
	
	
}

function sumarMetasParciales(objeto)
{
	 var total = 0;
	$(".meses").each(function(i,data){
		var valor = $(data).get(0).value;
		//solo sumanos los input con valores
		if(valor != ''){
			total += parseInt(valor);
		}
	});
	if(total > 100){
		alert('La sumatoria de metas parciales son superiores al 100%');
			objeto.value="";
			setTimeout(function(){objeto.focus()}, 10);

	}
	
}
//Si existe problemas al eliminar registros... el sistema mostrará la información por medio del siguiente DIV
function mostrarMensajes(data){
	//$('body').append('<div id="cboxOverlay" style="display: block; opacity: 0.9; cursor: auto;"></div>');
	$("#statusMsg").show("slow").html(data);

}

function mostrarSubcriterios2(id)
{		
	if(id != 0) {
		$("#yw0 li").eq(0).children('a').attr('href',$("#urlSitioWeb").val()+'/subcriterios/create?idCriterio='+id);
		$("#subcriterios-grid tbody").remove();
		$("#subcriterios-grid thead").remove();
		$("#subcriterios-grid .pager").remove();
		$("#subcriterios-grid .summary").html('');
		$('#yw0').show();
		//Actualizar Grilla con el filtro de Criterio
		$.fn.yiiGridView.update('subcriterios-grid', {
              data: '&Subcriterios[id_criterio]='+id});
		//Mostramos la grilla y el boton guardar
		$('#botonGuardar').show();
		$('#grillaDatos').show();	 	
		return;
	}else{
		$('#yw0').hide();
		$('#botonGuardar').hide('slow');
		$('#grillaDatos').hide('slow');
	}
	
}

function mostrarElementosdeGestion2(idc, id)
{	
	if(id != 0) {
		$("#yw0 li").eq(0).children('a').attr('href',$("#urlSitioWeb").val()+'/elementosGestion/create?idSubcriterio='+id+'&idCriterio='+idc);
		$("#elementos-gestion-grid tbody").remove();
		$("#elementos-gestion-grid thead").remove();
		$("#elementos-gestion-grid .pager").remove();
		$("#elementos-gestion-grid .summary").html('');
		$('#yw0').show();
		//Actualizar Grilla con el filtro de Criterio
		$.fn.yiiGridView.update('elementos-gestion-grid', {
              data: '&ElementosGestion[id_subcriterio]='+id});

		//Mostramos la grilla y el boton guardar
		$('#botonGuardar').show();
		$('#grillaDatos').show();
	 	
		return;
	}else{
		$('#yw0').hide();
		$('#botonGuardar').hide('slow');
		$('#grillaDatos').hide('slow');
	}
	
}

function funcionalidadNoHabilitada(){
	jAlert("Funcionalidad aún no disponible","Mensaje"); 
}

function mostrarSubCriterios(id){
 	var action = baseURL + '/elementosGestionPriorizados/obtenerSubCriterios/'+id;
 	$('#subcriterio option').remove();
 	$('#subcriterio').append('<option value="0">Cargando...</option>');
 	//Validamos si existe ese ID ya que la función es utilizada por mas de un controller.
 	if($('#grillaDatos')){
 		$('#grillaDatos').hide();
 	}
	// se pide al action la lista de productos de la categoria seleccionada
	$.getJSON(action, function(listaJson) {		
		// el action devuelve los productos en su forma JSON, el iterador "$.each" los separará.
		// limpiar el combo
		$('#subcriterio').find('option').each(function(){ $(this).remove(); });
		$('#subcriterio').append("<option value='0'>Seleccione SubCriterio</option>");
		
		if(listaJson!=''){
			$.each(listaJson, function(key, scriterio) {
	
				$('#subcriterio').append("<option value='"+scriterio.id+"'>"
				+scriterio.nombre+"</option>");
			});
		}else{
			mensajeParaMantenedor("No se encuentran SubCriterios");
		}		
		//$('#siguiente').show('slow');
	}).error(function(e){ 
			mensajeParaMantenedor(e.responseText);
			$('#subcriterio').append("<option value='0'>Seleccione SubCriterio</option>");
		});
}	

//Al momento de almacenar un indicador desde una vista que lo ocupa como 
//iframe(lineas de accion) debemos cerrar el modal y actualizar su contenido
function indicadorAlmacenadoDesdeLineasDeAccion(id){
	$.colorbox.close();
	$("#agregarIndicador").attr('href',baseURL+'/indicadores/updatenew/'+id+'/?referer=lineasdeaccion');
	$("#agregarIndicador span").html('Editar Indicador');
	$("#informacionCumplimiento").before('<div id="loadingCumplimiento"><img src="'+baseURL+'/images/loading.gif"/></div>');
	$("#informacionCumplimiento").hide();
	$("#LineasAccion_id_indicador").val(id);
	$.ajax({
		  url: baseURL+'/indicadores/obtenerIndicador/'+id,
		  success: function(data) {
			  $("#loadingCumplimiento").remove();
			  $.each(data, function(i, item) {
				  $('#LineasAccion_idIndicador_descripcion').val(item.descripcion);
				  $('#LineasAccion_idIndicador_medio_verificacion').val(item.medio_verificacion);
				  $('#LineasAccion_idIndicador_meta_anual').val(item.meta_anual);
				  $('#LineasAccion_idIndicador_frecuencia_control_id').val(item.nombre);
			  });
			 
			  $("#informacionCumplimiento").show('slow');
		  }
	});		
}


function agregarElementoGestionAsociadoLAEventKeyUp(){
	$('.puntaje_esperado input').unbind("keyup");	
	$('.puntaje_esperado input').keyup(function(){
		console.log('b');
		$('.labelpuntaje_elemento').each(function(){
			console.log('c');
             var total=(parseFloat($(this).parent('td').parent('tr').children('.puntaje_esperado').children('input').val()) - parseFloat($(this).parent('td').parent('tr').children('.puntaje_actual').html()))*parseFloat($(this).prev('input.puntaje_elemento').val());
             total=Math.round(total*100)/100;//con 2 decimales                 
             if(isNaN(parseFloat(total))){
                 $(this).html('0');
             }else{
                 $(this).html(total);
             }	                 
        });          
    });
}

function agregarElementoGestionAsociadoLA(thisCheck,id,nelemento_gestion,puntaje_actual,puntaje_elemento){
	var isChecked=$(thisCheck).is(':checked');
	var nombre=$(thisCheck).parent('td').parent('tr').children('td').eq(0).html();
	if(isChecked){
		//Ocultando mensaje "No se encontraron resultados"
		parent.$("#la-elem-gestion-grid tbody td.empty").parent('tr').hide();
		
		var idExiste=false;
		parent.$("#la-elem-gestion-grid tbody td.id_elem_gestion input").each(function(){
			if(parseInt($(this).val())==parseInt(id)){
				idExiste=true;
				if($(this).parent('td').parent('tr').hasClass('deleteRecord')){
					$(this).parent('td').parent('tr').children('td').eq(0).children('input').remove();
					$(this).parent('td').parent('tr').removeClass('deleteRecord');
				}
			}
		});
		if(!idExiste){
			var TrActual=parent.$("#la-elem-gestion-grid tbody tr").length+1;
			if(parent.$("#la-elem-gestion-grid tbody tr.newRecord2:first").length>0){
				TrActual=parseInt(parent.$("#la-elem-gestion-grid tbody tr.newRecord:last").attr('valueActualTr'))+1;
			}
			var classCSS="odd";
			if(TrActual%2) classCSS="even";
			var htmlTemp='<tr id="la-elem-gestion-grid_'+id+'" class="newRecord '+classCSS+'" valueActualTr="'+TrActual+'"><td width="90">'+nelemento_gestion+'</td>';
					htmlTemp+='<td>'+nombre+'</td>';
					if(typeof puntaje_actual=='undefined') puntaje_actual='';
					htmlTemp+='<td class="puntaje_actual" width="90">'+puntaje_actual+'</td>';
					htmlTemp+='<td class="puntaje_esperado" width="90"><input type="text" id="LaElemGestion_'+TrActual+'_puntaje_esperado_" name="LaElemGestion['+TrActual+'][puntaje_esperado][]" value="" style="width:40px;"></td>';
					htmlTemp+='<td class="id_elem_gestion" style="width:0%; display:none"><input type="hidden" id="LaElemGestion_'+TrActual+'_id_elem_gestion" name="LaElemGestion['+TrActual+'][id_elem_gestion]" value="'+id+'"></td>';
					if(typeof puntaje_elemento=='undefined') puntaje_elemento='';
					htmlTemp+='<td width="90"><input type="hidden" id="puntaje_elemento" name="puntaje_elemento" value="'+puntaje_elemento+'" class="puntaje_elemento"> <label for="puntaje_elemento" class="labelpuntaje_elemento"></label></td>';
					//htmlTemp+='<td class="button-column"><a href="#" title="" class="update cboxElement"><img alt="" src="'+$("#urlSitioWeb").val()+'/images/edit.png"></a></td>';
					htmlTemp+='<td class="id_la_elem_gestion" style="width:0%; display:none"><input type="hidden" id="LaElemGestion_'+TrActual+'_id" name="LaElemGestion['+TrActual+'][id]" value="'+id+'"></td>';
					htmlTemp+='<td class="button-column"></td>';
					htmlTemp+='</tr>';
			htmlTemp+='';
			parent.$("#la-elem-gestion-grid tbody").append(htmlTemp);	
			parent.agregarElementoGestionAsociadoLAEventKeyUp();
			
		}
	}else{
		
		if(parent.$("#la-elem-gestion-grid_"+id).html()){
			//Elimiando TR que fueron agregados a mano
			parent.$("#la-elem-gestion-grid_"+id).remove();
		}else{
			var posicion="";
			var idLa_elem_gestion="";
			//Debemos buscar y agregar la clase al TR que esta almacenado en la base de datos
			parent.$("#la-elem-gestion-grid tbody td.id_elem_gestion input").each(function(){
				if(parseInt($(this).val())==parseInt(id)){
						$(this).parent('td').parent('tr').addClass('deleteRecord');
						posicion=$(this).parent('td').parent('tr').index();
						idLa_elem_gestion=$(this).parent('td').parent('tr').children('td.id_la_elem_gestion').children('input').val();
				}
			});
			parent.$("#la-elem-gestion-grid tbody tr").eq(posicion).children('td').eq(0).append('<input type="hidden" id="LaElemGestion_'+posicion+'_delete" name="LaElemGestion['+posicion+'][delete]" value="'+idLa_elem_gestion+'">');
		}
		if(parent.$("#la-elem-gestion-grid tbody tr").length==1){
			//Mostrando resultados "No se encontraron resultados"
			parent.$("#la-elem-gestion-grid tbody td.empty").parent('tr').show();
		}
	}
	
	//Debemos actualizar el link con los id's de elementos de gestión que necesitamos enviar para que aparescan como checkeados
	var atributos="";
	parent.$("#la-elem-gestion-grid tbody td.id_elem_gestion").children('input').each(function(){
			if(!$(this).parent('td').parent('tr').hasClass('deleteRecord')){
				atributos+="el[]="+$(this).val()+"&";
			}
	});	
	
	if($("#idLa")){
		parent.$("#agregarLA").attr('href',$("#urlSitioWeb").val()+'/ElementosGestion/indexLA/?idLA='+parent.$("#idLa").val()+'&'+atributos);
	}else{
		parent.$("#agregarLA").attr('href',$("#urlSitioWeb").val()+'/ElementosGestion/indexLA/?'+atributos);
	}
	
}

function validarCentroCostoConLA(){
	
	if($("#centroCostoOriginal").val()==$("#LineasAccion_centro_costo_id").val()){		
		return true;
	}else{
		//$.colorbox.remove();		
		 $(document).bind('cbox_open', function(){$.colorbox.close();$(document).unbind('cbox_open'); });
		jAlert("Antes de agregar nuevos elementos de gestión, es necesario guardar los cambios.","Mensaje");
		return false;
	}
}

function eliminandoElementoGestionAsociadoLA(idLink){	
	var posicion=$(idLink).parent('td').parent('tr').index();

	var idLa_elem_gestion=$(idLink).parent('td').parent('tr').children('td.id_la_elem_gestion').children('input').val();
	$(idLink).parent('td').parent('tr').addClass('deleteRecord');
	$("#la-elem-gestion-grid tbody tr").eq(posicion).children('td').eq(0).append('<input type="hidden" id="LaElemGestion_'+posicion+'_delete" name="LaElemGestion['+posicion+'][delete]" value="'+idLa_elem_gestion+'"/>');
	//Debemos actualizar el link con los id's de elementos de gestión que necesitamos enviar para que aparescan como checkeados
	var atributos="";
	$("#la-elem-gestion-grid tbody td.id_elem_gestion").children('input').each(function(){
			if(!$(this).parent('td').parent('tr').hasClass('deleteRecord')){
				atributos+="el[]="+$(this).val()+"&";
			}
	});	
	$("#agregarLA").attr('href',$("#urlSitioWeb").val()+'/ElementosGestion/indexLA/?idLA='+$("#idLa").val()+'&'+atributos);
	
	return false;
}


function activarTextField(check){
	//obtenemos el nombre del texField a partir del ID del checkbox
	//var nombreText = check.id+"textField";
	

	//Habilitamos y deshabilitamos el textField asociado al checkbox 
	//document.getElementById(nombreText).disabled = !check.checked
	
	//Mostramos o ocultamos el textField asociado al checkbox
	if(check.checked){
		$(check).parent().children("input[type=\'text\']").removeAttr("disabled").show();
		//despstyle.display = 'inherit';
	}else{
		$(check).parent().children("input[type=\'text\']").attr("disabled","disabled").hide();
		//document.getElementById(nombreText).style.display = 'none';
	}
	//Actualiza grilla superior con el resumen de los campos
	resumenIndicadoresAsignadosInstrumentos();

	
}

function crearGraficoBarra(){
	
	$('.graficoProgressbar').each(
	    	function(){   

	    		$(this).progressbar({value:parseInt($(this).attr('valIndicador'))});
	    		
	    		var selector = '#' + this.id + ' > div';
	    	
	    		   var value = parseInt($(this).attr('valIndicador'));
			         if (value > 99){
			            $(selector).css({ 'background': '#009e0f' });
			        } 
			        else{
			        
			        	if(value < 99 && value > 50){
			        	
			        		$(selector).css({ 'background': '#ffff00' });
			        	}
			        	else{
			        	
			        		$(selector).css({ 'background': '#cc0000' });
			        	
			        	}
			        }
			     
	  				$(this).css({ 'height': '25px' });
	  				$(this).css({ 'width': '150px' });
	  			
	  				
	    
	    	});
	
}
function mostrarCentrosCostos(id, bandera)
{
	
	var idivision = id; 
	
	var action = baseURL + '/ejecucionPresupuestaria/obtenerCentros/'+idivision;
	

	$.getJSON(action, function(listaJson) {
		$('#combo2').find('option').each(function(){ $(this).remove(); });
		$('#combo2').append("<option value='0'>Seleccione Centro de Costos</option>");
		if(listaJson!=''){
			$.each(listaJson, function(key, centro) {
				$('#combo2').append("<option value='"+centro.id+"'>"
				+centro.nombre+"</option>");
			});
			
			if(bandera !=0){
				
				$('#combo2').val(bandera);
			}
			
		}else{
			mensajeParaMantenedor("No se encuentran registros para el centro de responsabilidad seleccionado");
		}
	}).error(function(e){ 
		mensajeParaMantenedor(e.responseText);
		});	


}

function mostrarEjecucionPresupuestaria(id, id_division)
{

	
	if(parseInt(id) != 0&& parseInt(id_division)!=0) {


		$.fn.yiiGridView.update('items-grid', {
              data: '&EjecucionPresupuestaria[id_centro_costo]='+parseInt(id)+'&EjecucionPresupuestaria[id_division]='+parseInt(id_division) });
	
		$("#items-grid tbody").remove();
		$("#items-grid.pager").remove();
		$('#grillaDatos').show('slow');
			 	
		return;
	}else{
	
		$('#grillaDatos').hide('slow');
		
	}
	
}

function mostrarEjecucionPresupuestaria2(id, id2)
{
	
	
	
	if(parseInt(id) != 0) {


		$.fn.yiiGridView.update('items-grid', {
              data: '&EjecucionPresupuestaria[id_centro_costo]='+parseInt(id)+'&EjecucionPresupuestaria[id_division]='+parseInt(id2) });
	
		$("#items-grid tbody").remove();
		$("#items-grid.pager").remove();
		$('#grillaDatos').show('slow');
			 	
		return;
	}else{
	
		$('#grillaDatos').hide('slow');
		
	}
	
}

function mostrarIndicadoresFiltro(id)
{
	
	//if(parseInt(id) != 0) {


		$.fn.yiiGridView.update('indicadores-grid', {
              data: '&EjecucionPresupuestaria[id_centro_costo]='+parseInt(id) });
	
		$("#indicadores-grid tbody").remove();
		$("#items-grid.pager").remove();
		//$('#grillaDatos').show('slow'); este es el div para hacerla visible
		/*	 	
		return;
	}else{
	
		$('#grillaDatos').hide('slow');
		
	}*/
	
}


function mostrarBoton(){
	
	var datosGrid = $("#items-grid tbody tr td span").html();

	 if(datosGrid != null){
	   $('#botonGuardar').hide('slow');
	   
	   $('#contenedorExcel').hide('slow');
	 }else{

		 $('#botonGuardar').show('slow');
		 $('#contenedorExcel').show('slow');
		 
	 }
	
}

function ocultaiconos(){
	
	var datosGrid = $("#indicadores-grid tbody tr td span").html();

	 if(datosGrid != null){
	   $('#contenedoricono').hide('slow');
	 }else{
		 $('#contenedoricono').show('slow');
	 }
	
}

function calcularAcumuladoEjecucionPresupuestaria(idInput){
	var acumulado=0;
	var saldo = 0;
	var asignado =0;
	
	$(idInput).parent('td').parent('tr').children('.mes').each(function(){
		if(!isNaN(parseInt($(this).children('input').val()))){
			acumulado+=parseInt($(this).children('input').val());
		}		
	});
	$(idInput).parent('td').parent('tr').children('.acumuladoInput').children('input').val(acumulado);
	asignado = parseInt($(idInput).parent('td').parent('tr').children('.asignado').html());
	//Validando que el valor exista.
	if(isNaN(asignado)){
		asignado=$(idInput).parent('td').parent('tr').children('.asignado').html();
		asignado=asignado.replace(/\$/g,'');
		asignado=asignado.replace(/\./g,'');
		asignado=asignado.replace(/\,/g,'.');
		
	}
	saldo = asignado - acumulado;
	if(parseInt(saldo)<0){
		//jAlert('ADVERTENCIA: Saldo se encuentra en valor negativo, por favor revise sus datos.','Mensaje');
		mensajeParaMantenedor('ADVERTENCIA: Saldo se encuentra en valor negativo, por favor revise sus datos.');
		$('#botonGuardar').children().attr('disabled','disabled');
	}
	else{
		$('#botonGuardar').children().prop('disabled',false);
	}
	$(idInput).parent('td').parent('tr').children('.saldoInput').children('input').val(saldo);
	$(idInput).parent('td').parent('tr').children('.acumulado').html(acumulado);
	$(idInput).parent('td').parent('tr').children('.saldo').html(saldo);
}

function maskInput(event) {
	if ( event.keyCode == 46 || event.keyCode == 8 ) {
		// let it happen, don't do anything
	}
	else {
		// Ensure that it is a number and stop the keypress
		if (event.keyCode < 48 || event.keyCode > 57 ) {
			event.preventDefault();	
		}	
	}
}


function maskInputFloat(event) {

		if(event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 9  ){

		}else {
			
			if (event.keyCode < 48 || event.keyCode > 57 ) {
				event.preventDefault();	
			}			
		}
}


function  resumenIndicadoresAsignadosInstrumentos(desdeDonde)
{
	 //console.log("RESUMEN");
	$("#resumen_input_FH,#resumen_input_CDC,#resumen_input_T").html('');
       var obj= new Array();
       $("#indicadores-instrumentos-grid input[type='text']:visible").each(function(){
       		var className=$(this).attr('class');
       		if(!isNaN(this.value) && $(this).val().length!=0) {
	       		if(obj[className] != undefined){
	       			 
	       				obj[className]+=parseFloat($(this).val());
	       				//obj[className]= parseFloat(obj[className]) + parseFloat($(this).val());
	       		}else{
	       			 
	       				obj[className]=parseFloat($(this).val());
	       			
	       		
	       		}
       		}
       });
       
      	  if(desdeDonde=="btnGuardar"){
      	   var msg=" ";
      	   var nombreObjeto ="";
      	   for(var x in obj){
      	   		switch(x)
      	   		{
					case 'input_FH':
  						nombreObjeto='FH';
  						break;
        	   		case 'input_CDC':
  						nombreObjeto='CDC';
  						break;		
      	   			case 'input_MG':
  						nombreObjeto='MG';
  						break;
      	   			case 'input_T':
  						nombreObjeto='T';
  						break;
      	   			case 'input_PMG':
  						nombreObjeto='PMG';
  						break;  
  					default:
  						nombreObjeto='';							 						 										
      	   		}
	       		//msg += nombreObjeto +" = "+obj[x]+"\n";
	       		msg += nombreObjeto +" = "+ (Math.round(obj[x]*100)/100) +"\n";
	       }
	       		//console.log(msg);
	       		return msg;
	       
      	  }else{ 	
	       for(var x in obj){
	       		$("#resumen_"+x).html( (Math.round(obj[x]*100)/100)+'%');
	       		console.log(obj[x]);
	       }
       	 }
}

function mostrarSubCriteriosenElementosDeGestion(id){
 	var action = baseURL + '/elementosGestion/obtenerSubCriterios2/'+id;
	
	// se pide al action la lista de productos de la categoria seleccionada
	$.getJSON(action, function(listaJson) {
		
		$('#yw0').hide();
		$("#elementos-gestion-grid tbody").remove();
		$("#elementos-gestion-grid thead").remove();
		$("#elementos-gestion-grid .pager").remove();
		$("#elementos-gestion-grid .summary").html('');
		// el action devuelve los productos en su forma JSON, el iterador "$.each" los separará.
		// limpiar el combo
		$('#subcriterio').find('option').each(function(){ $(this).remove(); });
		$('#subcriterio').append("<option value='0'>Seleccione SubCriterio</option>");
		
		if(listaJson!=''){
			$.each(listaJson, function(key, scriterio) {
	
				$('#subcriterio').append("<option value='"+scriterio.id+"'>"
				+scriterio.nombre+"</option>");
			});
		}else{
			mensajeParaMantenedor("No se encuentran SubCriterios");
		}		
		//$('#siguiente').show('slow');
	}).error(function(e){ 
			mensajeParaMantenedor(e.responseText);
		});
}


function mostrarProductosEstrategicosReporteAvanceIndicadores(id){
	
	var tipoId = id; 
	var idCentro = $('#combo1').val();
	var action = baseURL + '/reporteAvanceIndicadores/obtenerProductosEstrategicos?id='+tipoId+'&idC='+idCentro;
	

	$.getJSON(action, function(listaJson) {
		$('#combo_producto_estrategico').find('option').each(function(){ $(this).remove(); });
		$('#combo_producto_estrategico').append("<option value='0'>Seleccione Producto Estratégico</option>");
		if(listaJson!=''){
			$.each(listaJson, function(key, gestor) {
				$('#combo_producto_estrategico').append("<option value='"+gestor.id+"'>"
				+gestor.nombre+"</option>");
			});

			
		}else{
			mensajeParaMantenedor("No se encuentran registros para el tipo de producto seleccionado");
		}
	}).error(function(e){ 
		mensajeParaMantenedor(e.responseText);
		});	

}

function mostrarSubproductosReporteAvanceIndicadores(id){
	
	var peId = id; 

	var action = baseURL + '/reporteAvanceIndicadores/obtenerSubproductos?id='+peId;
	

	$.getJSON(action, function(listaJson) {
		$('#combo_subproducto').find('option').each(function(){ $(this).remove(); });
		$('#combo_subproducto').append("<option value='0'>Seleccione Subproducto</option>");
		if(listaJson!=''){
			$.each(listaJson, function(key, gestor) {
				$('#combo_subproducto').append("<option value='"+gestor.id+"'>"
				+gestor.nombre+"</option>");
			});
			$('#combo_subproducto').prop('disabled',false);
		
		}else{
			$('#combo_subproducto').attr('disabled','disabled');
			mensajeParaMantenedor("No se encuentran registros para el producto estratégico seleccionado");
		}
	}).error(function(e){ 
		mensajeParaMantenedor(e.responseText);
		});	
	
}




function mostrarReporteAvances(id)
{
	

	var datos = $("#reporte-avance-indicadores-form").serialize();

	if(parseInt(id) != 0) {


		$.fn.yiiGridView.update('items-grid', {
              data: '&'+datos});
	
		$("#items-grid tbody").remove();
		$("#items-grid.pager").remove();
		$('#grillaDatosReporteIndicadores').show('slow');
		obtenerDatosExcelReporteAvancesIndicadores(); 	
		return;
	}else{
	
		$('#grillaDatosReporteIndicadores').hide('slow');
		
	}
	
	
}


function obtenerDatosExcelReporteAvancesIndicadores()
{
	

	var datos = $('#reporte-avance-indicadores-form').serialize();
	
	
	$('#linkExcel').attr('href', baseURL+'/reporteAvanceIndicadores/create?'+datos);
	
}

function calcularFormulaRegistroAvancesPanelGeneralAvance(a, b, c, formula)
{

	
	var resultado=0;
	var faltanParametros=false;
	
	if(formula.indexOf('A') != -1 ){
	      if (/^[0-9]+$/.test(a)){ 
		      formula= formula.replace (/A/,a)	
		  }else{
		      faltanParametros =true;
		  }
	}else{
	//	$("#conceptoa").css("display", "none");
	}
	if(formula.indexOf('B') != -1 ){
	     if (/^[0-9]+$/.test(b)){ 
		      formula= formula.replace (/B/,b)	
		  }else{
		      faltanParametros =true;
		  }
	}else{
		//$("#conceptob").css("display", "none");
	}
	if(formula.indexOf('C') != -1 ){
	      if (/^[0-9]+$/.test(c)){ 
		      formula= formula.replace (/C/,c)	
		  }else{
		      faltanParametros =true;
		  }
	}else{
		//$("#conceptoc").css("display", "none");
	}
	
	//console.log(valorA);console.log(valorB);console.log(valorC);console.log(formula);console.log (faltanParametros);
	$("#inputResultadoCalculoFormula").val('');
	if (faltanParametros != true){
    	with(Math) x=eval(formula);    	
        if (x!="Infinity"){
        if (x=="NaN" ) {
            formula="Expresión con problemas";
        }
        else {
        	formula=x;
        	//Pegando el resultado
	         $("#inputResultadoCalculoFormula").val(formula.toFixed(2));
        }
        }else{
        	formula="Expresión con problemas";
        	$("#resultadoCalculoFormula").html(formula);
        }        
    }else{
        formula="Expresión con problemas";
        //Pegando el resultado
	    $("#resultadoCalculoFormula").html(formula);
    }


}


function graficoProgressBar(){
	$('.graficoProgressbar').each(
	    	function(){  

	    	
	    		var valueCadena=$(this).html();   	
	  			var valorValueArray=valueCadena.split(' ');
	  			var valIndicador = valorValueArray[0];
	    		var asc=valorValueArray[1];
	    		var meta_esperada = valorValueArray[2];
	    		var idAleatoria=Math.round(Math.random()*1000);
	    		var charAleatorio = Math.random().toString(36).substring(7);
	    		var idBarra = idAleatoria+charAleatorio;
	    	
	    		if(meta_esperada != 'S.I.' && valIndicador != 'S.I.'){
	    		
			    	
			    		$(this).html('<div class=\"grafico_indicador\"><div class=\"porcentaje_indicador\" style=\"left:63px;\">'+valIndicador+'%</div><div id=\"'+idBarra+'\" class=\"progressbar\"></div></div>');
			    		$(this).children('.grafico_indicador').children('.progressbar').progressbar({value:parseInt(valIndicador)});
			    		
			    		var selector ='#'+idBarra+'>div';
			    		var v = parseFloat(valIndicador);//valor
					    var m = parseFloat(meta_esperada);//meta
					    var x = (m*10)/100;//el 10 % de la meta
					    var total = v+x;// es la suma del valor con el 10 % calculado
			    		if(parseInt(asc) == 1){//es ascendente
			    			
			    			if (parseFloat(valIndicador) >= parseFloat(meta_esperada)){//si es igual o mayor que meta esperada es verde
			    			
			    				
					            	$(selector).css({ 'background':'#009e0f'});
					            
					   
					        } 
					        else{
					        	if(parseFloat(valIndicador)<parseFloat(meta_esperada)&&total >= parseFloat(meta_esperada)){// si no es mas baja que un 10% debe ser amarillo
					        	
					        		$(selector).css({ 'background': '#ffff00' });
					        	
					        	}
					        	else{//sino rojo
					        	
					        			$(selector).css({ 'background': '#cc0000' });
					        		
					        	
					        	}
					        }
			    		}
			    		else{// es descendente
			        		
			    			if (parseFloat(valIndicador) <= parseFloat(meta_esperada)){// si es menor o igual a la meta esperada es verde
					            
			    			
			    					$(selector).css({ 'background': '#009e0f' });
			    				
					   
					        } 
					        else{
					        
					        	if(parseFloat(valIndicador)>parseFloat(meta_esperada)&&total <= parseFloat(meta_esperada)){// es amarillo si es mayor en mas de un 10% que la meta esperada
					        	
					        		$(selector).css({ 'background': '#ffff00' });
					        	
					        	}
					        	else{// en el resto de los caso es rojo
					        	
					        		$(selector).css({ 'background': '#cc0000' });
					        		
					        	}
					        }
			    		
			    		}//fin else
			    		
			    	
	  				}//si vienen los valores necesarios
	  				else{
	  					$(this).html('<div class=\"grafico_indicador\"><div class=\"porcentaje_indicador\" style=\"left: 63px;\">S.I.</div><div id=\"'+idBarra+'\" class=\"progressbar\"></div></div>');
			    		$(this).children('.grafico_indicador').children('.progressbar').progressbar({value:0});
			    		
	  				}
	  					$(this).css({ 'height': '25px' });
			  			$(this).css({ 'width': '150px' });
	  			
	  				
	    
	    	});
}

function circulosRojosReporteAvanceIndicadores(){
   	$('.graficoProgressbar').each(
	    	function(){  

	    	
	    		var valueCadena=$(this).html();   	
	  			var valorValueArray=valueCadena.split(' ');
	  			var valIndicador = valorValueArray[0];
	    		var asc=valorValueArray[1];
	    		var meta_esperada = valorValueArray[2];
	    		var ban = parseInt(valorValueArray[3]);
	    		var idAleatoria=Math.floor(Math.random()*11)
			    var idBarra = valIndicador+idAleatoria;
	    		
	    		if(meta_esperada != '-' && valIndicador != '-'){
	    			var selector ='#'+idBarra+'>div';
		    		var v = parseFloat(valIndicador);//valor
				    var m = parseFloat(meta_esperada);//meta
				    var x = (m*10)/100;//el 10 % de la meta
				    var total = v+x;// es la suma del valor con el 10 % calculado
			    		
				    
			    		if(parseInt(asc) == 1){//es ascendente
			    			if (parseInt(valIndicador) >= parseInt(meta_esperada)){//si es igual o mayor que meta esperada es verde
			    			    				
					            	$(this).html('<div class=iconoVerde id=\"'+idBarra+'\" ></div>');
					        } 
					        else{
					        
					        	if(parseFloat(valIndicador)<parseFloat(meta_esperada)&&total >= parseFloat(meta_esperada)){// si no es mas baja que un 10% debe ser amarillo
					        	
					        		$(this).html('<div class=iconoAmarillo id=\"'+idBarra+'\" ></div>');
					        	
					        	}
					        	else{//sino rojo
					        	
					  
					        			$(this).html('<div class=iconoRojo id=\"'+idBarra+'\" ></div>');
					        		
					        	
					        	}
					        }
			    		}
			    		else{// es descendente
			    		
			    			if (parseInt(valIndicador) <= parseInt(meta_esperada)){// si es menor o igual a la meta esperada es verde
					            
			    			
			    					$(this).html('<div class=iconoVerde id=\"'+idBarra+'\" ></div>');
			    				
					   
					        } 
					        else{
					        
					        	if(parseFloat(valIndicador)>parseFloat(meta_esperada)&&total <= parseFloat(meta_esperada)){// es amarillo si es mayor en mas de un 10% que la meta esperada
					        	
					        		$(this).html('<div class=iconoAmarillo id=\"'+idBarra+'\" ></div>');
					        	
					        	}
					        	else{// en el resto de los caso es rojo
					        	
					        		
					        			$(this).html('<div class=iconoRojo id=\"'+idBarra+'\" ></div>');
					        		
					        		
					        	}
					        }
			    		
			    		}//fin else
			    		
	  			}//fin if
	  			else{
	  				if(parseInt(ban)==parseInt(9)){
	        			$(this).html('<div class=iconoVerde id=\"'+idBarra+'\" ></div>');
	        		}else{
	  					$(this).html('<div class=iconoRojo id=\"'+idBarra+'\" ></div>');
	        		}
	  			}//fin else
	  				
	    
	    	});
}

function obtieneDatosFormularioEjecucionPresupuestaria(){
	
	var datos = $("#ejecucion-presupuestaria-form").serialize();

		$.fn.yiiGridView.update('items-grid', {
				type:'POST',
              data:datos});
	
		$("#items-grid tbody").remove();
		$("#items-grid.pager").remove();
		$('#grillaDatos').show('slow');

		return false;

	
	
	
}



function tabsPanelAvance(){	
	 $(function() {
		    $( "#tabs" ).tabs({
		    select: function( evt, ui ) {
		    	
		    	if($(ui.panel).attr( 'id' )!='tabs-1'){
			    	$('#'+$(ui.panel).attr( 'id' )).html('<img src="'+$('#urlSitioWeb').val()+'/images/loading.gif"/>');
			     
		    	}
		    },
		      beforeLoad: function( event, ui ) {
		    	//console.log($(ui.panel).attr( 'id' ));
		    	
		        ui.jqXHR.error(function() {
		          ui.panel.html(
		            "Se ha producido un error al cargar el contenido. " );
		        });
		      },load:function(event,ui){
		 
		    	  asignacionModals();
		      }
		    });
		  });
	
}



function agregarDocumentosEvaluacionJornada(){
	if($("#documentosAsociados tr.empty").is(':visible')){
		$("#documentosAsociados tr.empty").hide();
	}
	ultimoRegistro=$("#documentosAsociados tr").length+1;
	
	htmlTemp='<input type="file" id="docAsociado_x'+ultimoRegistro+'_archivo" class="docAsociado_x'+ultimoRegistro+'" name="docAsociado[]"/>';
	
	$("#documentosAsociados").append('<tr estado="new"><td>'+htmlTemp+'</td><td></td><td><a href="#" onclick="eliminarDocumentosEvaluacionJornada(this);return false;"><img src="'+$("#urlSitioWeb").val()+'/images/delete.png" /></a></td></tr>');
	
}

function eliminarDocumentosEvaluacionJornada(id){
	if($("#documentosAsociados tr:visible").length==1){
		$("#documentosAsociados tr.empty").show();
	}
	if($(id).parent('td').parent('tr').attr('estado')){
		$(id).parent('td').parent('tr').remove();
	}else{
		$(id).parent('td').parent('tr').hide();
		idValue=$(id).parent('td').parent('tr').attr('valueTR');
		$(id).append('<input type="hidden" name="docAsociadoEliminado[]" value="'+idValue+'"/>');
	}
}

function mostrarCentrosCostosReporteAvanceIndicadores(id)
{
	
	var idivision = id; 
	
	var action = baseURL + '/reporteAvanceIndicadores/obtenerCentrosCostos/'+idivision;
	

	$.getJSON(action, function(listaJson) {
		$('#combo2').find('option').each(function(){ $(this).remove(); });
		$('#combo2').append("<option value='0'>Seleccione Centro de Costos</option>");
		if(listaJson!=''){
			$.each(listaJson, function(key, centro) {
				$('#combo2').append("<option value='"+centro.id+"'>"
				+centro.nombre+"</option>");
			});
			
			$('#combo2').prop('disabled',false);
		}else{
			mensajeParaMantenedor("No se encuentran registros para el centro de responsabilidad seleccionado");
			$('#combo2').attr('disabled','disabled');
		
		}
	}).error(function(e){ 
		mensajeParaMantenedor(e.responseText);
	});	

	mostrarProductosEstrategicosReporteAvanceIndicadores();

}

function mostrarProductosEstrategicosReporteAvanceIndicadores(){

	var idTipo = $('#combo_tipo_prodcuto').val();

	if(idTipo == undefined){
		idTipo = 0;
	}
	var idCR = $('#combo1').val();
	var idCC = $('#combo2').val();
	var action = baseURL + '/reporteAvanceIndicadores/obtenerProductosEstrategicos?idTipo='+idTipo+'&idCR='+idCR+'&idCC='+idCC;
	
	$.getJSON(action, function(listaJson) {
		$('#combo_producto_estrategico').find('option').each(function(){ $(this).remove(); });
		$('#combo_producto_estrategico').append("<option value='0'>Seleccione Producto Estratégico</option>");
		if(listaJson!=''){
			$.each(listaJson, function(key, centro) {
				$('#combo_producto_estrategico').append("<option value='"+centro.id+"'>"
				+centro.nombre+"</option>");
			});
			
			$('#combo_producto_estrategico').prop('disabled',false);
		}else{
			$('#combo_producto_estrategico').attr('disabled','disabled');
			mensajeParaMantenedor("No se encuentraron registros de productos estratégicos");
		}
	}).error(function(e){ 
		mensajeParaMantenedor(e.responseText);
		});	
}

function mostrarGestoresReporteAvanceIndicadores(id){
	
	var centroid = id; 
	
	var action = baseURL + '/reporteAvanceIndicadores/obtenerGestores/'+centroid;
	

	$.getJSON(action, function(listaJson) {
		$('#combo_gestor').find('option').each(function(){ $(this).remove(); });
		$('#combo_gestor').append("<option value='0'>Seleccione Gestor</option>");
		if(listaJson!=''){
			$.each(listaJson, function(key, gestor) {
				$('#combo_gestor').append("<option value='"+gestor.id+"'>"
				+gestor.nombres+"</option>");
			});

			$('#combo_gestor').prop('disabled',false);
		}else{
			$('#combo_gestor').attr('disabled','disabled');
			mensajeParaMantenedor("No se encuentran registros para el centro de costo seleccionado");
		}
	}).error(function(e){ 
		mensajeParaMantenedor(e.responseText);
		});	
	mostrarProductosEstrategicosReporteAvanceIndicadores();
}

function mostrarProductoEspecificoReporteAvanceIndicadores(id){
	
	var subId = id; 
	
	var action = baseURL + '/reporteAvanceIndicadores/obtenerProductoEspecifico/'+subId;
	
	
	$.getJSON(action, function(listaJson) {
		$('#combo_pre_especifico').find('option').each(function(){ $(this).remove(); });
		$('#combo_pre_especifico').append("<option value='0'>Seleccione Producto Específico</option>");
		if(listaJson!=''){
			$.each(listaJson, function(key, gestor) {
				$('#combo_pre_especifico').append("<option value='"+gestor.id+"'>"
				+gestor.nombre+"</option>");
			});
			$('#combo_pre_especifico').prop('disabled',false);
			
		}else{
			$('#combo_pre_especifico').attr('disabled','disabled');
			mensajeParaMantenedor("No se encuentran registros para el subproducto seleccionado");
		}
	}).error(function(e){ 
		mensajeParaMantenedor(e.responseText);
		});	

}
function asignarValorExportarExcelIndInst(valor)
{
	if(valor==null || valor==""){
		$("#contenedorExcel").hide();
	}else{
		url= $("#contenedorExcel a").attr({"href": baseURL+"/indicadoresInstrumentos/excel/?id="+valor})
		$("#contenedorExcel").show();
	}
	
    $("#cr_id").val(valor);
	//alert("LLego");

}

function mostrarSubCriteriosResumenGeneral(idCriterio, id){
	var id_criterio = idCriterio;
	
	if(id == "subCriterioE"){
		$('#grillaElementosResumen').hide('slow');
	}
	var action = baseURL + '/resumenGeneral/obtenerSubcriterios/'+id_criterio;

	$('#'+id).empty().append("<option value='0'>Cargando...</option>");
	$.getJSON(action, function(listaJson) {
		$('#'+id).find('option').each(function(){ $(this).remove(); });
		$('#'+id).append("<option value='0'>Seleccione Sub Criterio</option>");
		if(listaJson!=''){
			$.each(listaJson, function(key, subs) {
				$('#'+id).append("<option value='"+subs.id+"'>"
				+subs.nombre+"</option>");
			});
			$('#'+id).prop('disabled',false);
			
		}else{
			$('#'+id).attr('disabled','disabled');
			mensajeParaMantenedor("No se encuentran registros para el criterio seleccionado");
		}
		
	}).error(function(e){ 
		mensajeParaMantenedor(e.responseText);
		});	
}

function mostrarElementosPorSubcriterio(id_sub){

		$.fn.yiiGridView.update('items-grid', {
              data: '&ElementosGestion[id_subcriterio]='+parseInt(id_sub)});
	
		$("#items-grid tbody").remove();
		$("#items-grid.pager").remove();
		$('#grillaDatosResumen').show('slow');
			 	
		return;

}//fin function


function mostrarResumenGeneralPorCriterio(idCriterio){

	$.fn.yiiGridView.update('items-gridS', {
        data: '&SubcriteriosPuntaje[id_criterio]='+parseInt(idCriterio)});

	$("#items-gridS tbody").remove();
	$("#items-gridS.pager").remove();
	$('#grillaDatosResumenCriterio').show('slow');
		 	
	return;
	
	
}//fin funcion

function elementosGestionSubResumenGeneral(idSub){
	var id_sub = idSub;
	var action = baseURL + '/resumenGeneral/obtenerElementos?idSub='+id_sub;
	
	$('#grillaElementosResumen').hide('slow');
	
	$('#elementoS').empty().append("<option value='0'>Cargando...</option>");
	$.getJSON(action, function(listaJson) {
		$('#elementoS').find('option').each(function(){ $(this).remove(); });
		$('#elementoS').append("<option value='0'>Seleccione Elemento de Gestión</option>");
		if(listaJson!=''){
			$.each(listaJson, function(key, ele) {
				$('#elementoS').append("<option value='"+ele.id+"'>"
				+ele.nombre+"</option>");
			});
			$('#elementoS').prop('disabled',false);
			
		}else{
			$('#elementoS').attr('disabled','disabled');
			mensajeParaMantenedor("No se encuentran registros para el sub criterio seleccionado");
		}
		
	}).error(function(e){ 
		mensajeParaMantenedor(e.responseText);
		});	
}//fin funcion

function mostrarElementosResumenGeneral(idElemento){
	console.log("mostrarElementosResumenGeneral");
	var action = baseURL + '/resumenGeneral/obtenerDatosTablaElementos?id='+idElemento;
	//var tabla = '<table width="978" border="1" cellpadding="0" cellspacing="0" bordercolor="#4882AC">';

	$('#grillaElementosResumen').hide('slow');
	for($i=0; $i<6; $i++){
		$("#despliegue"+$i).css('background-color','#FFFFFF');
	}
	$("#contenido").html(" ");
	$('#contenido2').html(" ");
	$('#contenido3').html(" ");
	$('#contenido4').html(" ");
	$('#contenido5').html(" ");
	$.getJSON(action, function(listaJson) {
		console.log(listaJson);
		$.each(listaJson, function(key, ele) {			
			$('#contenido').append('<strong>'+ele.nombre+'</strong><br/><div style="height:70px;overflow: auto;">'+ele.descripcion+'</div>');
			$('#contenido2').append('<strong>'+ele.sub+'</strong>');
			$('#contenido3').append('<strong>'+ele.elemento+'</strong>');
			$('#contenido4').append('<strong>'+ele.evidencia+'</strong>');
			
			if(ele.url=='S.I.'){
				
				$('#linkA').html('S.I.');
				//$('#linkA').html('<a href="'+baseURL+'/upload/controlElementosGestion/'+ele.url+'"><img src="'+baseURL+'/images/document_letter_download.png"/>Descargar Archivo</a>');
			}
			else{
				$('#linkA').html('');
				$.each(ele.url, function() {
					var nomhrefCorto = this.substring(14);	
					$('#linkA').append('<a href="'+baseURL+'/upload/controlElementosGestion/'+this+'" target="_blank"><img src="'+baseURL+'/images/document_letter_download.png"/>'+nomhrefCorto+'</a></br>');
				});
			}
		//	append('<strong>'+ele.url+'</strong>');
			$("#despliegue"+ele.revisado).css('background-color','#BCE774');
			
			//	tabla = tabla+'<tr><td width="123" rowspan="3">&nbsp;'+ele.sub+'</td><td width="144" bgcolor="#6095BD" class="textoReportesTablas"><center><strong>No hay despliegue</strong></center></td><td colspan="2" bgcolor="#6095BD" class="textoReportesTablas"><center><strong>Despliegue parcial</strong></center></td><td colspan="3" bgcolor="#6095BD" class="textoReportesTablas"><center><strong>Despliegue total</strong></center></td></tr><tr><td bgcolor="#6095BD" class="textoReportesTablas"><center><strong>No hay enfoque<strong></center></td><td width="123" bgcolor="#6095BD" class="textoReportesTablas"><center><strong>Enfoque incipiente</strong></center></td><td width="160" bgcolor="#6095BD" class="textoReportesTablas"><center><strong>Enfoque sistemático</strong></center></td><td width="143" bgcolor="#6095BD" class="textoReportesTablas"><center><strong>Enfoque evaluado</strong></center></td><td width="139" bgcolor="#6095BD" class="textoReportesTablas"><center><strong>Enfoque mejorado</strong></center></td><td width="130" bgcolor="#6095BD" class="textoReportesTablas"><center><strong>Enfoque efectivo</strong></center></td></tr><tr><td>0</td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td></tr><tr><td>'+ele.elemento+'</td><td colspan="6">aki evidencia</td></tr>';
		});//fin iteracion
	//	tabla = tabla+'</table>';		
	//	$('#tablaElementosSub').html(tabla);
		$('#grillaElementosResumen').show('slow');
	});
	
	
	
	
}//fin funcion

function mostrarGraficoPorCriterio(idCriterio){
	$("#graficoBarraPorCriterio").html('<br/><br/><br/><center><img src="'+baseURL+'/images/loadingEsperar.gif"/></center>');
	$.ajax({
		  url: baseURL+'/resumenGeneral/jsonGraficoPorCriterio/'+idCriterio,
		  success: function(data) {
			    var myChart = new FusionCharts(baseURL+"/swf/Column3D.swf","myChartId", "100%", "100%", "0" );
				myChart.setJSONData(data);
				myChart.render("graficoBarraPorCriterio");
		  },
		  error: function (request, status, error) {
		    	$("#graficoBarraPorCriterio").html('');
		        alert(request.responseText);
		    }
	});
}

