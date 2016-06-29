$(document).ready(function() {
		//Activando menus si vienen desde el breadcrums
        
});


$.yiimailbox={};
function paramPeriodo()
{
	
  var url = 'site/menuJson/'+$("#selectPeriodo").val();	
  
  if($("#selectPeriodo").val() !=''){
	$('.menusProcesos').hide();
	$("#loadingProcesos").show();
	$.ajax({
		url: url,
 		dataType:"json",
 		cache: false,
 		success: function(data) 
 		{	
 			$("#contenidoProcesosPrincipal").show();
 			//Consultamos que traiga procesos asociados 
 			if (data.procesos != '')
 			{
 				
 				$.each(data.procesos,function (i,item)
	 			{
	 				if(item.activo=='1'){
	 				   //$("#" + item.idDiv).removeClass();
	 					 $("#" + item.idDiv).addClass("amarillo")
	 					 $("#" + item.idDiv).attr("onclick",""+ $("#" + item.idDiv).attr("rel"));
	 				}else if(item.activo=='2'){
	 					$("#" + item.idDiv).addClass("verde")
	 					
	 				}else{
	 					$("#" + item.idDiv).addClass("blanco")
	 					//$("#" + item.idDiv).removeAttr("href");
	 					$("#" + item.idDiv).removeAttr("onclick").attr('onclick','return false;');
					}
	 			});
 			}else{
 				$("#contenidoProcesos div").removeClass("verde amarillo blanco")
 			}
 			$(".breadcrumbs a").eq(0).html(data.anio);
 			
 			$("#loadingProcesos").hide();
 			
 			if(getParameterByName('lvl1')!=""){
 	        	activarProceso2(getParameterByName('lvl1'));
 	        }
 	        if(getParameterByName('lvl2')!=""){
 	        	activarProceso3(getParameterByName('lvl2'));
 	        }
 	        
 	        
 	         //Asignando al menu superior los mismos atributos de despliegue que los botones inferiores dentro del content.
 			$("#menuSupPlanificacion").attr("onclick",""+ $("#procesoPlanificacionInstitucional").attr("onclick")); 
 			$("#menuSupControl").attr("onclick",""+ $("#procesoControlGestion").attr("onclick"));
 			$("#menuSupEvaluacion").attr("onclick",""+ $("#evaluacionGestion").attr("onclick"));
 			
 			var planificacion =$("#procesoPlanificacionInstitucional").attr("onclick");
 			var control =  $("#procesoControlGestion").attr("onclick");
 			var evaluacion = $("#evaluacionGestion").attr("onclick");
 			
 			
 			
 	        
 		}
	});
 }else{
 	$('.menusProcesos').hide();
 }
}
function cambiarPeriodo(){
	//parent.window.location.href = parent.window.location.href+"?periodo="+$("#selectPeriodo").val();
	
	
	window.location.href="?periodo="+$("#selectPeriodo option:selected").text();;
	
	
	//window.location.href = window.location.href+"?periodo="+$("#selectPeriodo option:selected").text();
}

function activarProceso2(idContenedor){
	$(".menusTerceros").hide();
	$(".menusSecundarios").hide();
	$("#"+idContenedor).show();
	$("#contenidoProcesosTercero").hide();
	$("#contenidoProcesosSecundarios").hide().show('slow');	
	
}

function activarProceso3(idContenedor){
	$(".menusTerceros").hide();
	$("#"+idContenedor).show();
	$("#contenidoProcesosTercero").hide().show('slow');	
	
}	

function getParameterByName(name)
{
  name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
  var regexS = "[\\?&]" + name + "=([^&#]*)";
  var regex = new RegExp(regexS);
  var results = regex.exec(window.location.search);
  if(results == null)
    return "";
  else
    return decodeURIComponent(results[1].replace(/\+/g, " "));
}


