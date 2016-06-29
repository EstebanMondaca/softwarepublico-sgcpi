//V2.0-05062013 MCP

$.yiimailbox={};
var baseURL="";
$(document).ready(function() {		
	baseURL = $("#urlSitioWeb").val();
	dominio = top.location.hostname;
	AltoModaldentroDeModal();	
	addStringAfterLabel();
	changeImageDependingAccess();
});


function changeImageDependingAccess(){
	$("table.items td.changeImage").each(function(){
		if($(this).html()=='1'){
			$(this).siblings('.button-column').children('a').children('img').attr('src',$("#urlSitioWeb").val()+'/images/view.png')
		}
	});
}

function addStringAfterLabel(){
	$("label.required .required").remove();
	$("input[type='text'],textarea,select,input[type='password']").prev('label').each(function(){
		$(this).html($.trim($(this).html())+": ");
		$(this).addClass('colon');
	});
	//Debemos agregar los dos puntos en caso de encontrarse el label dentro de un TR
	$("input[type='text'],textarea,select,input[type='password']").parent('td').prev('td').children('label').each(function(){
		$(this).html($.trim($(this).html())+": ");
		$(this).addClass('colon');
	});
	$(".blockLabel").not('.colon').each(function(){
		$(this).html($.trim($(this).html())+": ");
		$(this).addClass('colon');
	});
	//Debemos agregar al principio el asterisco de requerido
	
	$("label.required").prepend('<span class="required"> * </span>');
}

function AltoModaldentroDeModal(){
	//Calculando el alto disponible
	if($(window).height()<$("html").height()){
		alto="90%";
	}else{
		alto=$("html").height();
	}
	if(typeof parent.$.fn.colorbox=='function'){		
	    parent.$.fn.colorbox.resize({
	    	innerHeight: alto
	    });  
	}else if (typeof parent.parent.$.fn.colorbox=='function'){
		if(parent.$(window).height()<parent.$("html").height()){
			alto="90%";
		}else{
			alto=parent.$("html").height();
		}
		//parent.$("html").height($(document).height());
		parent.parent.$.fn.colorbox.resize({
	    	innerHeight: alto
	    }); 
	}
}

function cambiarEstadoInputSegunCheckbox(){
	$(".toggleEnabled:checked").each(function(){
		if($(this).val()=='1'){
			$("#"+$(this).attr('nametextarea')).parent().show();
		}else{
			$("#"+$(this).attr('nametextarea')).parent().hide();
		}	
	});	
}

function actualizarSRCIframe(id){
	var url="";
	if(typeof id=='string'){
		url=id;
	}else{
		url=$(id).attr('href');
	}
    $('#iframeModal').html('<iframe  src="'+url+'" height="100%" width="100%" scrolling="no" frameborder="0"></iframe>');
    $('#iframeModal').show();
}


function cerrarPanelIframe(){
	$('#iframeModal').hide('slow');
	actualizarDatosDeListasYGrillasWithIframe();
	AltoModaldentroDeModal();
}

function cerrarModalSinCambios(){
	$('#iframeModal').hide('slow');
	AltoModaldentroDeModal();
}

function cerrarModalWithIframe(){
	$.colorbox.close();
	actualizarDatosDeListasYGrillasWithIframe();
}


function actualizarDatosDeListasYGrillasWithIframe(){
	 $('.grid-view').each(function(){
		 $.fn.yiiGridView.update(''+$(this).attr('id'),{
		        complete: function(jqXHR, status) {
		            if (status=='success'){
		            	if(!$("#mensajeSuccess").html()){
		            	    $(".form h3").eq(0).after('<span id="mensajeSuccess" class="required">Los datos han sido actualizados exitosamente.</span>');
		            	}
		            	$("#mensajeSuccess").fadeOut(6000).delay(1000).queue(function() { $(this).remove(); });
		            }
		        }
		 });
	 });
	 $('.list-view').each(function(){
		 $.fn.yiiListView.update(''+$(this).attr('id'),{
		        complete: function(jqXHR, status) {
		            if (status=='success'){
		            	if(!$("#mensajeSuccess").html()){
		            	    $(".form h3").eq(0).after('<span id="mensajeSuccess" class="required">Los datos han sido actualizados exitosamente.</span>');
		            	}
		            	$("#mensajeSuccess").fadeOut(6000).delay(1000).queue(function() { $(this).remove(); });
		            }
		        }
		 });
	 });
}
function metasParcialesInput(id)
{
	var nombre_frecuenciaControl;
	
	if(id=='Mensual' || id=="Trimestral"){
		nombre_frecuenciaControl = id;
		
	}else{	
		//Obtenemos el texto del selector
		var indice_frecuenciaControl = frecuenciaControl.selectedIndex
		nombre_frecuenciaControl = frecuenciaControl.options[indice_frecuenciaControl].text
	}
	//Creamos un arreglo con los meses del año
	var meses=new Array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre", "noviembre","diciembre");
	
	//Todos los input debe ser hidden y disable
	$(".meses").each(function(i,data){
		$(data).attr("disabled","disabled");
		$(data).get(0).type = 'hidden';
		$(data).attr("size",'1');
		$(data).attr("maxlength",'9');
		$(data).attr("max",'100');
		//$(data).attr("value",'');
		$(data).attr("onkeyDown",'validarNumeros(event)');
		
	});
	

  	//Consultamos si es mensual o trimestral	 
	if (nombre_frecuenciaControl=='Mensual'){
  		$(".meses").each(function(i,data){
			$(data).removeAttr("disabled");
			$(data).get(0).type = 'text';
	
		});
  		
	}else if (nombre_frecuenciaControl=='Trimestral'){

		for (var i = 0; i < meses.length; i++) {
			i=i+2;//para mostrar solo cada 3 meses los input
  			element = meses[i];
  			$('#'+element).removeAttr("disabled");
  			$('#'+element).get(0).type = 'text';
 
		}

		
	}else{
		alert('La frecuencia de control, contiene un parámetro selecionado inadecuado');
	}
}

function modificarUnidad(idformula){
	
	var action = baseURL + '/indicadores/obtenerUnidad/'+idformula;

	$.getJSON(action, function(data) {
		if (data){
			$("#Indicadores_unidad_id").val(data.unidad.id);
			$("#nombre_unidad").html(data.unidad.nombre);
			$("#formula_para_calculo").html(data.formula);
			
			var formula =data.formula;
	
			if(formula.indexOf('A') != -1 ){
				$("#Indicadores_conceptoa").css("display", "block");
			}else{
				$("#Indicadores_conceptoa").css("display", "none");
			}
			if(formula.indexOf('B') != -1 ){
				$("#Indicadores_conceptob").css("display", "block");
			}else{
				$("#Indicadores_conceptob").css("display", "none");
			}
			
			if(formula.indexOf('C') != -1 ){
				$("#Indicadores_conceptoc").css("display", "block");
			}else{
				$("#Indicadores_conceptoc").css("display", "none");
			}
				}
			calcularFormulaIndicadores(data.unidad.tipo_resultado);
			
		});
	
	
		
	
	
}
	
function calcularFormulaIndicadores(tipo_resultado_formula)
{
	//tipo_resultado_formula 0 =Promedio
	//tipo_resultado_formula 1 =Porcentaje
	
	
	var formula =$("#formula_para_calculo").html();
	
	
	var valorA = $("#Indicadores_conceptoa:visible").val();
	var valorB = $("#Indicadores_conceptob:visible").val();
	var valorC = $("#Indicadores_conceptoc:visible").val();
	
	$("#Indicadores_meta_anual").val("");
	var faltanParametros=false;
	
	if(formula.indexOf('A') != -1 ){
	      if (/^[0-9]+$/.test(valorA)){ 
		      formula= formula.replace (/A/,valorA)	
		  }else{
		      faltanParametros =true;
		  }
	}else{
		$("#Indicadores_conceptoa").css("display", "none");
	}
	
	if(formula.indexOf('B') != -1 ){
	     if (/^[0-9]+$/.test(valorB)){ 
		      formula= formula.replace (/B/,valorB)	
		     
		  }else{
		      faltanParametros =true;
		  }
	}else{
		$("#Indicadores_conceptob").css("display", "none");
	}
	
	if(formula.indexOf('C') != -1 ){
	      if (/^[0-9]+$/.test(valorC)){ 
		      formula= formula.replace (/C/,valorC)	
		  }else{
		      faltanParametros =true;
		  }
	}else{
		$("#Indicadores_conceptoc").css("display", "none");
	}
	
	
	$("#Indicadores_meta_anual").val('');
	if (faltanParametros != true){
    	with(Math) x=eval(formula);
    	
        if (x!="Infinity"){
        if (x=="NaN" ) {
            formula="";
        }
        else {
        	
        	formula=x;
        	
        	if (tipo_resultado_formula==0){
        		//var promedio=(formula * 100)/meta_anual;
        		var promedio=(formula * 100);
        		formula = promedio;
        	}
        	
        	
        	if ($.isNumeric(formula)) {
        		$("#Indicadores_meta_anual").val(formula.toFixed(2));
        	}else{
        		 $("#Indicadores_meta_anual").val("");
        	}
        		//Pegando el resultado
	        //$("#Indicadores_meta_anual").val(formula.toFixed(2));
	         	         
        }
        }else{
        	formula="";
        	 $("#Indicadores_meta_anual").val(formula);
        }
        
    }else{
        formula="";
        //Pegando el resultado
	    $("#Indicadores_meta_anual").val(formula);
    }
    
	asignarValorDiciembre();

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

function borrarArchivo(id){
	
	var action = 'http://'+dominio+baseURL + '/cierresInternos/borrar/?id='+id;
	
	var mensajeError = "Archivo No Encontrado!!";
	$.getJSON(action, function(data) {
		
		if(data){
			$('#urlPDF').hide('slow');
			$('#uploadPDF').show('slow');
		}else{
			mensajeParaFormulario(mensajeError);
		}
		
		
	}).error(function(e){ 
		
		//mensajeParaMantenedor(e.responseText);
		//mensajeParaFormulario(e.responseText)
		mensajeParaFormulario(mensajeError);
	});

}

function mostrarUploadPDF(){
	$('#uploadPDF').show('slow');
} 
function mensajeParaFormulario(mensaje){
	if(!$("#mensajeSuccess").html()){
	    $("#content h3").eq(0).after('<span id="mensajeSuccess" class="required">'+mensaje+'</span>');
	}
	$("#mensajeSuccess").fadeOut(6000).delay(1000).queue(function() { $(this).remove(); });
}

/*
 * 
 * 
 FUNCTIONES utilizadas en controlElementosGestion
 */


function validarcontrolLaElemGestion(){
	$(".errorMessage").hide();
	var submit=true;
	$("#versionesRegistro tbody tr").each(function(){
		//Validando input y textarea que no esten vacios.
		$("."+$(this).attr('valueTr')).each(function(){
			if($(this).get(0).tagName!="DIV"){//Debemos validar en caso de que no sea un tag de formulario
				if($(this).val()==""){
					if(!$(this).attr('type')=='file'){
						$(this).parent('div').children('.errorMessage:not(.typeFile)').show();
						$(this).addClass('error');
						submit=false;
					}					
				}else{
					$(this).removeClass('error');
					//Validando la extensión del archivo en caso de ser de tipo file
					console.log($(this).attr('type'));
					if($(this).attr('type')=='file'){
						if(!$(this).val().match(/.(pdf)|(doc)|(xls)|(rar)|(zip)$/)){//here your extensions (jpg)|(gif)|(png)|(bmp)|
							$(this).parent('div').children('.errorMessage.typeFile').show();
							$(this).addClass('error');
							submit=false;
					    }
					}
				}
			}
			
		});	
		//Validando el campo de fecha que tenga un formato correcto y que no este vacio.
		$(this).children('td').eq('1').children('input.datepicker').each(function(){
			if($(this).val()!=""){
				if(!validarFecha($(this).val())){
					submit=false;
					$(this).addClass('error');
					$("#mensajeVersionesRegistro").html('Fecha debe ser de tipo fecha(yyyy-mm-dd).').show();
				}else{
					$(this).removeClass('error');
				}
			}else{
				submit=false;			
				$(this).addClass('error');
				$("#mensajeVersionesRegistro").html('Fecha no puede ser nulo.').show();
			}
		});
		if(!submit){
			//Debemos realizar un click en la fecha o TR si se encuentra un error en algun input del formulario.
			cambiarSeleccionFecha($(this),true);
			return false;
		}
	});
	if(submit){
		$("#elementos-gestion-form").submit();
	}
	/*$("#versionesRegistro input.datepicker").each(function(){
		if($(this).val()!=""){
			if(validarFecha($(this).val())){				
				$("."+$(this).parent('td').parent('tr').attr('valueTr')).each(function(){
					if($(this).val()==""){
						$(this).parent('div').children('.errorMessage').show();
						$(this).addClass('error');
						submit=false;
					}
				});
			}else{		
				submit=false;
				$(this).addClass('error');
				$("#mensajeVersionesRegistro").html('Fecha debe ser de tipo fecha(yyyy-mm-dd).').show();
				//$("#mensajeVersionesRegistro").delay(6000).queue(function() { $(this).hide(); });
			}
		}else{
			submit=false;			
			$(this).addClass('error');
			$("#mensajeVersionesRegistro").html('Fecha no puede ser nulo.').show();
		}		
		if(!submit){			
			cambiarSeleccionFecha($(this).parent('td').parent('tr'),true);
			return false;
		}
		
	});*/
}


function validarEvaluacionControlLaElemGestion(){
	$(".errorMessage").hide();
	var submit=true;
	$("#versionesRegistro tbody tr").each(function(){
		//Validando input y textarea que no esten vacios.
		$("."+$(this).attr('valueTr')).each(function(){
			if($(this).get(0).tagName!="DIV"){//Debemos validar en caso de que no sea un tag de formulario
				if($(this).val()==""){
					if(!$(this).attr('type')=='file'){
						$(this).parent('div').children('.errorMessage:not(.typeFile)').show();
						$(this).addClass('error');
						submit=false;
					}					
				}else{
					$(this).removeClass('error');
					//Validando la extensión del archivo en caso de ser de tipo file
					if($(this).attr('type')=='file'){
						if(!$(this).val().match(/.(pdf)|(doc)|(xls)|(rar)|(zip)$/)){//here your extensions (jpg)|(gif)|(png)|(bmp)|
							$(this).parent('div').children('.errorMessage.typeFile').show();
							$(this).addClass('error');
							submit=false;
					    }
					}
				}
			}
			
		});	
		//Validando el campo de fecha que tenga un formato correcto y que no este vacio.
		$(this).children('td').eq('1').children('input.datepicker').each(function(){
			if($(this).val()!=""){
				if(!validarFecha($(this).val())){
					submit=false;
					$(this).addClass('error');
					$("#mensajeVersionesRegistro").html('Fecha debe ser de tipo fecha(yyyy-mm-dd).').show();
				}else{
					$(this).removeClass('error');
				}
			}else{
				submit=false;			
				$(this).addClass('error');
				$("#mensajeVersionesRegistro").html('Fecha no puede ser nulo.').show();
			}
		});
		if(!submit){
			//Debemos realizar un click en la fecha o TR si se encuentra un error en algun input del formulario.
			cambiarSeleccionFecha($(this),true);
			return false;
		}
	});
	if(submit){
		$("#elementos-gestion-form").submit();
	}	
}


function eliminarVersion(idLink){
	var ClassCss=$(idLink).parent('td').parent('tr').attr('valueTr');
	$("."+ClassCss).remove();
	$(idLink).parent('td').parent('tr').remove();
	$("#versionesRegistro tbody tr").each(function(){
			var indexPosicion=$(this).index()+1; 
			$(this).children('td').eq(0).html('V'+indexPosicion);
	});
	$(".errorMessage").hide();
	$(".error").removeClass('error');
}

function agregarNuevaVersionRegistro(){
	if($("#versionesRegistro input").length==0){
		var ultimoRegistro=$("#versionesRegistro tbody tr").length +1;
		var classCss=(ultimoRegistro%2)?"even":"odd";
		var htmlTemplate="<tr valueTr='laElemGestions_x"+ultimoRegistro+"' class='"+classCss+" newRow'><td>V"+ultimoRegistro+"</td><td><input type='text' name='laElemGestions[x"+ultimoRegistro+"][fecha]' class='datepicker' style='height: 15px; width: 85px;'/><a href='#' onclick='eliminarVersion(this);return false;'><img src='"+$("#urlSitioWeb").val()+"/images/delete.png' /></a></td></tr>";
		$("#versionesRegistro tbody").append(htmlTemplate);
		$(".datepicker").datepicker({'dateFormat':'yy-mm-dd','monthNames':['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],'monthNamesShort':['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],'dayNames':['Domingo,Lunes,Martes,Miercoles,Jueves,Viernes,Sabado'],'dayNamesMin':['Do','Lu','Ma','Mi','Ju','Vi','Sa']});	
		$("#laElemGestions_evidencia").append('<textarea class="laElemGestions_x'+ultimoRegistro+'" id="laElemGestions_x'+ultimoRegistro+'_evidencia" name="laElemGestions[x'+ultimoRegistro+'][evidencia]" rows="3" style="width: 390px;display:none;height: 169px;"></textarea>');
		$("#laElemGestions_puntaje_real").append("<select onchange='activarColorTdlaElemGestions()' class='laElemGestions_x"+ultimoRegistro+"' style='display:none;' name='laElemGestions[x"+ultimoRegistro+"][puntaje_real]' id='laElemGestions_x"+ultimoRegistro+"_puntaje_real'><option value='0'>0</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option></select>");
		
	   	$('#laElemGestions_archivo').append("<b class='laElemGestions_x"+ultimoRegistro+" file'> Subir Documentos :</b><div class='laElemGestions_x"+ultimoRegistro+" file' style='background: none repeat scroll 0 0 #DADADA; width: 248px;'><input type='file' name='laElemGestions[x" + ultimoRegistro + "][archivo][]'   value='' id='laElemGestions_file_x" + ultimoRegistro + "' class='laElemGestions_x"+ ultimoRegistro +" file '  size='19' style='width: 248px;' /></div>");
	    	
	    $("#laElemGestions_file_x"+ultimoRegistro).MultiFile({'accept':'pdf|doc|xls|rar|zip','max':10,'STRING':{'remove':' X ','denied':'Tipo de archivo no está permitido.','duplicate':'Archivo seleccionado anteriormente.'}}); 
		
	
		$('#versionesRegistro tbody tr').unbind('click');
		$('#versionesRegistro tbody tr').bind('click', function() {
	        cambiarSeleccionFecha(this);
	    });
	}else{
		jAlert("Aún existen versiones sin validar.<br/> Antes de agregar una nueva versión, es necesario validar todas las anteriores. ","Mensaje"); 
	}
	
}

function cambiarSeleccionFecha(id,fromFunction){
	$("#versionesRegistro tbody tr").removeClass('selected');
	$(id).addClass('selected');
	
	$("#laElemGestions_evidencia textarea").hide();
	$("#laElemGestions_evidencia .textareabootstrap").hide();
	
	$("#laElemGestions_puntaje_real select").hide();
	$("#laElemGestions_puntaje_real .selectbootstrap").hide();
	
	$("#laElemGestions_archivo input").hide();
	$("#laElemGestions_archivo .file").hide();
	
	$("."+$(id).attr('valueTr')).show();		
	if(!fromFunction){
		//Ocultando mensajes y eliminando clase de error, en caso de que esten visibles
		$(".errorMessage").hide();
		$(".error").removeClass('error');
	}	
	activarColorTdlaElemGestions();	
}

function activarColorTdlaElemGestions(){
	$("#despliegue"+$("#laElemGestions_puntaje_real select:visible").val()).siblings().removeClass('selected');
	$("#despliegue"+$("#laElemGestions_puntaje_real select:visible").val()).addClass('selected');
	if($("#laElemGestions_puntaje_real select:visible").length==0){
		$("#despliegue"+$("#laElemGestions_puntaje_real .selectbootstrap:visible").html()).siblings().removeClass('selected');
		$("#despliegue"+$("#laElemGestions_puntaje_real .selectbootstrap:visible").html()).addClass('selected');
	}
}


/* FIN FUNCTIONES utilizadas en controlElementosGestion */


function validarFecha(value){
	var check = false;
    var re = /^\d{4}\-\d{1,2}\-\d{1,2}$/;
    if(re.test(value)){
        var adata = value.split('-');
        var mm = parseInt(adata[1],10); // was dd (day)
        var dd = parseInt(adata[2],10); // was mm (month)
        var yyyy = parseInt(adata[0],10); // was aaaa (year)
        var xdata = new Date(yyyy,mm-1,dd);
        if (( xdata.getFullYear() == yyyy ) && ( xdata.getMonth () == mm - 1 ) && ( xdata.getDate() == dd ) )
            check = true;
        else
            check = false;
    } else
        check = false;
    
    return check;
}

/*Funciones Utilizadas en registro de avances
  ******************************************/
function calcularFormulaRegistroAvances(tipo_resultado_formula,meta_anual)
{
	//tipo_resultado_formula 0 =Promedio
	//tipo_resultado_formula 1 =Porcentaje
	
	
	var formula =$("#formula b").html();
	
	
	var valorA = $("#valorA:visible").val();
	var valorB = $("#valorB:visible").val();
	var valorC = $("#valorC:visible").val();
	
	$("#resultadoCalculoFormula").html(" ");
	var faltanParametros=false;
	
	if(formula.indexOf('A') != -1 ){
	      if (/^[0-9]+$/.test(valorA)){ 
		      formula= formula.replace (/A/,valorA)	
		  }else{
		      faltanParametros =true;
		  }
	}else{
		$("#conceptoa").css("display", "none");
	}
	if(formula.indexOf('B') != -1 ){
	     if (/^[0-9]+$/.test(valorB)){ 
		      formula= formula.replace (/B/,valorB)	
		     
		  }else{
		      faltanParametros =true;
		  }
	}else{
		$("#conceptob").css("display", "none");
	}
	if(formula.indexOf('C') != -1 ){
	      if (/^[0-9]+$/.test(valorC)){ 
		      formula= formula.replace (/C/,valorC)	
		  }else{
		      faltanParametros =true;
		  }
	}else{
		$("#conceptoc").css("display", "none");
	}
	
	
	$("#inputResultadoCalculoFormula").val('');
	if (faltanParametros != true){
    	with(Math) x=eval(formula);
    	
        if (x!="Infinity"){
        if (x=="NaN" ) {
            formula="Expresión con problemas";
        }
        else {
        	formula=x;
        	/*
        	if (tipo_resultado_formula==0){
        		var promedio=(formula * 100)/meta_anual;
        		formula = promedio;
        	}
        	*/
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
function asignarValorDiciembre(){
	
	var nombreUnidad= $("#nombre_unidad").html();
	var valorMetaAnual =$("#Indicadores_meta_anual").val()
	
	if (nombreUnidad== "Existe o No Existe"){
		if (valorMetaAnual==0 || valorMetaAnual==100){
			$("#diciembre").val($("#Indicadores_meta_anual").val());
		}else{
			alert("Meta Anual Permite Los Valores 0 o 100");
			$('#Indicadores_meta_anual').val("");
			$('#Indicadores_meta_anual').focus();
		}
		
	}else{
		$("#diciembre").val($("#Indicadores_meta_anual").val());
	}
}
function validarNumeros(event) {
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
function borrarArchivoRegistroAvance(id,campo,objeto){
	mensajeParaFormulario('Solicitando...');
	var action = 'http://'+dominio+baseURL + '/panelAvances/borrar/?id='+id+'&campo='+campo;
	
	var mensajeError = "Archivo No Encontrado!!";
	$.getJSON(action, function(data) {
		
		if(data){
			$('#'+objeto+'Link').hide('slow');
			$('#'+objeto+'Borrar').hide('slow');
			$('#'+objeto).removeAttr("disabled");
			$('#'+objeto).show('slow');
		}else{
			mensajeParaFormulario(mensajeError);
		}
		
		
	}).error(function(e){ 
		
		//mensajeParaMantenedor(e.responseText);
		//mensajeParaFormulario(e.responseText)
		mensajeParaFormulario(mensajeError);
	});

}


/*FIN-Funciones Utilizadas en registro de avances
  ******************************************/

function observacionTextArea(id){

	//var pEspeId = id; 
	
	var action = baseURL + '/seguimientoPlanMejora/obtenerObservacion/'+id;

	$.getJSON(action, function(listaJson) {

				$.each(listaJson, function(key, obs) {

					$('#IndicadoresObservaciones_observacion').val(obs.observacion);
				});
		
		
		});
	$('#btn').attr('onclick','mostrarComentarios(2,'+id+')');
	

}

function mostrarComentarios(bandera, id, b)
{

	var obs = $('#IndicadoresObservaciones_observacion').val();
	var indi =$('#IndicadoresObservaciones_id_indicador').val();
	var user = $('#IndicadoresObservaciones_id_usuario').val();
	var tipo = $('#IndicadoresObservaciones_tipo_observacion').val();
//	var b=0;
	//guarda
	if(bandera  == 1){
		
			$.fn.yiiGridView.update('coment-grid', {
	              data: '&IndicadoresObservaciones[id_indicador]='+parseInt(indi)+'&IndicadoresObservaciones[id_usuario]='
	              +parseInt(user)+'&IndicadoresObservaciones[observacion]='+obs+'&IndicadoresObservaciones[bandera]='+b+'&IndicadoresObservaciones[bandera2]=0&IndicadoresObservaciones[tipo_observacion]='+tipo});
	
			$('#IndicadoresObservaciones_observacion').val('');
	
	
	}
	//actualiza
	else{
		
	
		$.fn.yiiGridView.update('coment-grid',  {
            data: '&IndicadoresObservaciones[id]='+id+'&IndicadoresObservaciones[id_indicador]='+parseInt(indi)+'&IndicadoresObservaciones[id_usuario]='
            +parseInt(user)+'&IndicadoresObservaciones[observacion]='+obs+'&IndicadoresObservaciones[bandera]='+b+'&IndicadoresObservaciones[bandera2]=1&IndicadoresObservaciones[tipo_observacion]='+tipo});
		$('#IndicadoresObservaciones_observacion').val('');
		$('#btn').attr('onclick','mostrarComentarios(1,0)');
		
	}
	b=1;
		$("#coment-grid tbody").remove();
		$("#coment-grid.pager").remove();
	//	$('#grillaDatos').show('slow');
			 	
		return;
	
}

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

function graficoProgressbar(){
	
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


function validarPresupuesto(trySendForm){
    //Calculando valores para cada caso
    var montoTotal=0;
        $('.inputMontos:not(:disabled)').each(function(){
              if (/^([0-9])*$/.test($(this).val()) && $(this).val()!=''){
                  montoTotal+=parseInt($(this).val());
              }
        });            
        $('#totalOP').html(montoTotal);        
        //Debemos recalcular el nuevo valor para cada porcentaje
        var porcentajeTotal=0; 
        $('.inputPorcentaje').each(function(){            
           if (!/^([0-9])*$/.test($(this).val()) || $(this).val()==''){
               $(this).val(0);
           }else{
               porcentajeTotal+=parseInt($(this).val());
           }            
           var montoTotalDesdePorcentaje=parseInt($(this).val())*parseInt($('#totalOP').html())/100;
           montoTotalDesdePorcentaje=Math.round(montoTotalDesdePorcentaje); 
           $(this).parent().parent().children('.presupuestoOP').html('$'+montoTotalDesdePorcentaje);
       });
       if(porcentajeTotal>100){
            $('#errorDistribucion,.errorSummary').show();
           $('.inputPorcentaje').addClass('error');
        }else if(porcentajeTotal<100 && montoTotal!=0){        	
            $('#errorDistribucion,.errorSummary').show();
            $('.inputPorcentaje').addClass('error');
        }else{
            $('#errorDistribucion,.errorSummary').hide();
            $('.inputPorcentaje').removeClass('error');
            if(trySendForm) {$('#actividades-form').submit();}
        }
}//end function validarPresupuesto


function duplicarPeriodo(){
	if(!$("#PeriodosProcesos").val()){
		jAlert('Debe seleccionar un periodo', 'Mensaje');
	}else{
		if(!$("#nombrePeriodo").val()){
			jAlert('Debe ingresar el año del nuevo periodo', 'Mensaje');
		}else{
			if(!$("#nombrePlanificacion").val()){
				jAlert('Debe ingresar un nombre para la nueva Planificación', 'Mensaje');
				return false;
			}
			jConfirm('¿Está seguro que desea duplicar los registros asociados al periodo '+$("#PeriodosProcesos option:selected").text()+'?', 'Mensaje de confirmación', function(r) {
			    if(r){
			    	$(".fondoForm").show();
			    	$.ajax({
			    	    url: $("#urlSitioWeb").val()+"/duplicarPeriodo/create/", 
			    	    data: {periodo: $("#PeriodosProcesos").val(),nombrePeriodo:$("#nombrePeriodo").val(),nombrePlanificacion:$('#nombrePlanificacion').val()},
			    	    type: 'post',
			    	    error: function(XMLHttpRequest, textStatus, errorThrown){
			    	    	jAlert('Estimado usuario, existió un problema al momento de generar el nuevo periodo, favor volver a intentarlo. Si el problema persiste favor comunicarse con el administrador del sitio.', 'Mensaje');
			    	        $(".fondoForm").hide();
			    	    },
			    	    success: function(data){
			    	    	if(data=='ok'){
			    	    		jAlert('Estimado usuario, el periodo fue creado correctamente.', 'Mensaje');
			    	    	}else{
			    	    		jAlert('Estimado usuario, existió un problema al momento de generar el nuevo periodo, favor volver a intentarlo. Si el problema persiste favor comunicarse con el administrador del sitio.', 'Mensaje');
			    	    	}
			    	    	$(".fondoForm").hide();
			    	    }
			    	});
			    }
			});
		}
		
	}
}

function validarMetasParciales()
{
	vacio = false;
	var seleccion = $("#frecuenciaControl option:selected").text();
	
	var enero = $("#enero").val();
	var febrero = $("#febrero").val();
	var marzo = $("#marzo").val();
	var abril = $("#abril").val();
	var mayo = $("#mayo").val();
	var junio = $("#junio").val();
	var julio = $("#julio").val();
	var agosto = $("#agosto").val();
	var septiembre = $("#septiembre").val();
	var octubre = $("#octubre").val();
	var noviembre = $("#noviembre").val();
	var diciembre = $("#diciembre").val();
	meta_anual = $("#Indicadores_meta_anual").val();
	
	if (seleccion=='Mensual'){
		var mensualArray	=new Array(enero,febrero,marzo,abril,mayo,junio,julio,agosto,septiembre,octubre,noviembre,diciembre);
		for(var i in mensualArray)
		{
			if(!mensualArray[i])
			{
				vacio =  true;
			}
		}
	}else{
		var trimestralArray	=new Array(marzo,junio,septiembre,diciembre);
		for(var i in trimestralArray)
		{
			if(!trimestralArray[i])
			{
				vacio =  true;
			}
		}	
	}
	
	if(parseInt(meta_anual)<0){
		$("#Indicadores_meta_anual_em_").html("La meta anual debe ser igual o mayor a cero").show();
	    vacio =  true; 
	}
	
	if(vacio)
	{		
		$("#Indicadores_frecuencia_control_id_em_").html("Las metas parciales deben contener datos numéricos").show();
		return false;
	}
	else
	{
		$("#Indicadores_frecuencia_control_id_em_").html("").hide();
		$("#Indicadores_meta_anual_em_").html("").hide();
		$("#indicadores-form").submit();
		
	}
	

	
}
function mensajeCierreEtapa(id)
{
	jConfirm("Al realizar el cierre de la etapa no podra modificar la observacion y acta ¿Quiere realizar la accion?", "Mensaje", function(r) {  
        if(r) {  
           //SI
           $("#loadingProcesos").show();
            var action = 'http://'+dominio+baseURL + '/cierresInternos/cierreEtapa/'+id;
			//console.log(action);
			$.getJSON(action, function(data) {
				if(data.cierre){
					$("#btnguardar").html("");
					$("#btncierre").html("");
				}
				$("#loadingProcesos").hide();
			});		
        } 
    });  
    
}

function mostrarRegistroAvance(idHito){
	//avanceMensual
	$("#avanceMensual").show();
	$("#loadingAvance ").show();
	var url=$("#urlSitioWeb").val()+'/reporteAvanceIndicadores/registroavanceview/'+idHito;
	actualizarSRCIframe(url);
	//$('#avanceMensual_iframe').hide();
	//$('#avanceMensual_iframe').attr('src', $("#urlSitioWeb").val()+'/reporteAvanceIndicadores/registroavanceview/'+idHito);
    //$('#avanceMensual_iframe').reload();
}
//Funcion que se llama cuando termina de cargarse el iframe
function mostrarRegistroAvanceCargado(){
	$("#loadingAvance").hide();
	$('#iframeModal').show();
	AltoModaldentroDeModal();
}


function borrarDocEvidenciaAlmacenado(idp,ids){
	
	var action = 'http://'+dominio+baseURL + '/controlElementosGestion/borrarDocumento/?id='+idp;
	var mensajeError = "Eliminacion no realizada!!";
	jConfirm("¿Está seguro de eliminar el archivo?", "Mensaje", function(r) {  
        if(r) {  
           //SI
           	$.getJSON(action, function(data) {
		
			if(data){
				$('#laElemGestions_'+idp+'_archivo').hide('slow');
			}else{
				mensajeParaFormulario(mensajeError);
			}	
			}).error(function(e){ 
				mensajeParaFormulario(mensajeError);
			});	
        } 
    });  

}
