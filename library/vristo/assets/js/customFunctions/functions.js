/**
 * Para enviar a ID via POST, 'vlr' pode ser um vetor
 * Ex.:
 * $arrayVlr = "'".$param_0.",".$param_1."'";
 * $arrayVlr = $param_0;				
*/
function nextPage(url, vlr, target){
	console.log("🚀 ~ nextPage ~ nextPage:")
	var num_indice = 0;
	vlr = ''+vlr+'';		
	var array_vlr = new Array();

	if(vlr.indexOf(',') != -1){ // Mais que 1 parametro
		array_vlr = vlr.split(',');
		num_indice = total_indice(array_vlr);
	}else{						// Apenas 1 parametro
		array_vlr[0] = vlr;
		num_indice = 1;
	}

	var div_fnp = document.createElement("div");
	div_fnp.setAttribute("id", "form_next_page");	
	document.body.appendChild(div_fnp);
		
	var div_princ = document.getElementById('form_next_page');

	var formulario = document.createElement("form");
	formulario.setAttribute("id", "EnviaParam");
	formulario.setAttribute("method", "POST");
	formulario.setAttribute("action", url);	
	if(target == '_blank'){
		formulario.setAttribute("target", target);
	}
	div_princ.appendChild(formulario);	
	
	for(var i=0; i< num_indice; i++){
		var form_enviaPar = document.getElementById("EnviaParam");
		var parametro = document.createElement("input");
		parametro.setAttribute("type", "hidden");
		parametro.setAttribute("name", "param_"+i);
		parametro.setAttribute("id",   "param_"+i);	
		parametro.setAttribute("value", array_vlr[i]);	
		form_enviaPar.appendChild(parametro);		
	}
	
	// Envia o formulário
	document.getElementById("EnviaParam").action = url;
	document.forms["EnviaParam"].submit();
}

function toast(title, color, time) {
	console.log("🚀 ~ toast")
	const toast = window.Swal.mixin({
		toast: true,
		position: 'bottom-end',
		showConfirmButton: false,
		timer: time,
		showCloseButton: true,
		showConfirmButton: false,

		customClass: {
			popup: `color-${color}`
		},
	});
	toast.fire({
		title: title,
	});
}