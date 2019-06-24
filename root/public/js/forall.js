function insDataFunction(fSend, uData, tSend, functionDisp) {
	if(!(functionDisp in {null: null, undefined: undefined})) {
		let formData = new FormData();
		if(Array.isArray(fSend)) {
			if(Array.isArray(fSend[0]) && Array.isArray(fSend[1])) {
				for(var i = 0; i < fSend[0].length; i++) {
					formData.append(fSend[0][i], fSend[1][i]);
				}
			}
		}
    	let _curArr = [];
		jQuery.ajax({
	        type: tSend,
	        enctype: 'multipart/form-data',
	        url: uData,
	        data: formData,
	        processData: false,
	        contentType: false,
	        cache: false,
	        success: function(text) {
	        	try {
	        		_curArr = JSON.parse(text);
	        	} catch(err) {
	        		_curArr = [];
	        		insErrMsg(err, "danger", null);
	        	}
        		functionDisp.functionProcess(_curArr);
	        },
	        error: function(e) {
	        	functionDisp.functionProcess([]);
	            insErrMsg("ERROR: " + e, "danger", null);
	        }
	    });
	}
}
function insErrMsg(errClr, errMsg, errId) {
	let _div = document.getElementById(errId);
	if(!(_div in {null: null, undefined: undefined})) {
		_div.innerHTML =  '<div class="alert alert-'+errClr+' alert-dismissible" role="alert">'+ //  fade show
		  '<strong>Message:</strong> '+errMsg+''+
		  '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
		    '<span aria-hidden="true">&times;</span>'+
		  '</button>'+
		'</div>';
	} else {
		console.log([errClr, errMsg]);
	}
}
function checkFields(arrFields) {
  let retBool = true;
  if(Array.isArray(arrFields)) {
    for(let i = 0; i < arrFields.length; i++) {
      if(arrFields[i] == undefined || arrFields[i] == null) {
        retBool = false;
      }
    }
  } else {
    retBool = false;
  }
  return retBool;
}
function addNewRow(elId, insRow) {
  	let dom = document.getElementById(elId);
  	if(checkFields([dom])) {
    	dom.innerHTML += insRow;
  	}
}
function deleteCurrentRow(eDom) {
	if(checkFields([eDom])) {
	    eDom.parentNode.removeChild(eDom);
	}
}
function giveTotal(inName, idIns) {
	let inNameArr = ((Array.isArray(inName)) ? inName : [inName]), nTotal = 0, insDom = document.getElementById(idIns);
	inNameArr.forEach(function(a, b, c) {
		let dom = document.getElementsByName(a);
		if(checkFields([dom])) {
		  	for(let i = 0; i < dom.length; i++) {
		    	let cTotal = parseFloat(dom[i].value);
		    	nTotal = nTotal + ((isNaN(cTotal)) ? 0 : cTotal);
		  	}
		}
	});
	if(checkFields([insDom])) { if(insDom.tagName.toUpperCase() == "INPUT") { insDom.value = nTotal.toFixed(2); } else { insDom.innerHTML = nTotal.toFixed(2); } }
}
function checkLineAmount(inName, chkName, defName) {
	let inNameArr = ((Array.isArray(inName)) ? inName : [inName]), chkNameArr = ((Array.isArray(chkName)) ? chkName : [chkName]), defNameArr = ((Array.isArray(defName)) ? defName : [defName]);
	let setAmount = function(eDom, amnt) {
		if(checkFields([eDom])) { if(eDom.tagName.toUpperCase() == "INPUT") { eDom.value = amnt; } else { eDom.innerHTML = amnt; } }
	};
	for(let i = 0; i < inNameArr.length; i++) {
		let dom = document.getElementsByName(inNameArr[i]);
		if(checkFields([dom])) { for(let j = 0; j < dom.length; j++) {
			if(checkFields([defNameArr[i]])) { let defDom = document.getElementsByName(defNameArr[i])[j]; if(checkFields([defDom])) {
				let cAmount = ((dom[j].value == "" || dom[j].value == null) ? "0.00" : dom[j].value), amountLess = parseFloat(defDom.value) - parseFloat(cAmount);
				if(amountLess < 0) { setAmount(dom[j], (parseFloat(defDom.value)).toFixed(2)); if(checkFields([document.getElementsByName(chkNameArr[i])[j]])) { setAmount(document.getElementsByName(chkNameArr[i])[j], (parseFloat("0.00")).toFixed(2)); } } else { setAmount(dom[j], (parseFloat(dom[j].value)).toFixed(2)); if(checkFields([document.getElementsByName(chkNameArr[i])[j]])) { setAmount(document.getElementsByName(chkNameArr[i])[j], (amountLess).toFixed(2)); } }
			} else { setAmount(dom[j], "0.00"); } } else { setAmount(dom[j], "0.00"); }
		} }
	}
}