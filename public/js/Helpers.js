var Helpers = (function(){
 return {
    
	getParameterByName : function(name, url) {
		if (!url) url = window.location.href;
		name = name.replace(/[\[\]]/g, "\\$&");
		var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
			results = regex.exec(url);
		if (!results) return null;
		if (!results[2]) return '';
		return decodeURIComponent(results[2].replace(/\+/g, " "));
	},
	getUrlVars : function (){
		var vars = [], hash;
		var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
		for(var i = 0; i < hashes.length; i++)
		{
			hash = hashes[i].split('=');
			if(hash.length>1){
				vars.push({'name' : hash[0], 'value' : hash[1]});
			}
		}
		return vars;
	}
	,
	getUrlVar : function (pVars,pVar){
		var retVal = '';
		if(typeof pVars !== 'undefined' && pVars!==null && pVars.length > 0)
		for(i=0;i< pVars.length;i++) { 
			if(pVars[i].name == pVar){
				retVal = pVars[i].value;
				break; 
			}
		}
		return retVal;
	}
	,
	setUrlVar : function (pVars,pKey,pValue){
		var retVal = '';
		if(typeof pVars !=='undefined' && pVars!==null && pVars.length > 0){
			
			if(this.isUrlVarExist(pVars,pKey) === true){
				for(i=0;i< pVars.length;i++) { 
					if(pVars[i].name == pKey){
						pVars[i] = {'name' : pKey ,'value' : pValue};
						break; 
					}
				}
			}
			else{
				pVars.push({'name' : pKey, 'value' : pValue});
			}
		}
		else{
			pVars.push({'name' : pKey, 'value' : pValue});
		}
		return pVars;
	}
	,
	isUrlVarExist : function (pVars,pKey){
		var retVal = false;
		if(typeof pVars!=='undefined' && pVars!==""){
			for(i=0;i< pVars.length;i++) { 
				if(pVars[i].name == pKey){
					retVal = true;
					break; 
				}
			}
		}
		return retVal;
	}
	,
	getBaseUrl : function (){
		return window.location.pathname;
	}
	,
	convertArrayToQueryString : function (pVars){
		var strArray = [];
		for(i=0;i< pVars.length;i++) { 
			if(typeof pVars[i].name !== 'undefined' && pVars[i].name !== '' && typeof pVars[i].value !== 'undefined' && pVars[i].value !== ''){
				strArray.push(pVars[i].name + "=" + pVars[i].value); 
			}
		}
		return strArray.join("&");
	}
	,
	createFullURL : function (pUrl,pQueryString){
		if(pQueryString!==undefined && pQueryString!==null && pQueryString!==""){
			pQueryString = "?"+pQueryString;
			pUrl = pUrl+pQueryString;
		}
		return pUrl;
	}
	,
	redirectTo : function (pUrl){
		if(pUrl && pUrl!==""){
			//alert(pUrl);
			window.location.href = pUrl;
		}
		else{
			window.location.href = window.location.href;
		}
		return true;
	}
	,
	
	callAjax : function(pUrl,pType,pData,pDataType,callback){
		
		if(typeof pDataType == 'undefined' || pDataType == ''){
			pDataType = 'json';
		}
		
		jQuery.ajax({
			xhr: function() {
				var xhr = jQuery.ajaxSettings.xhr();
				xhr.upload.onprogress = function(e) {
					if (typeof callback == "function"){
						var percentComplete = parseInt((e.loaded / e.total)*100);
						callback('progress',percentComplete);
					}	
				};
				xhr.addEventListener("progress", function(e){
					if (typeof callback == "function"){
						if (e.lengthComputable) {
							var percentComplete = parseInt((e.loaded / e.total)*100);
							callback('progress',percentComplete);
						}
					}	
				}, false);
				return xhr;
			},
			url: pUrl,
			data: pData,
			type: pType,
			headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },
			beforeSend: function(xhr){
			   xhr.withCredentials = true;
			},
			crossDomain: true,
			dataType: pDataType,
			success: function(data) {
				if (typeof callback == "function"){
					callback('success',data);
				}
			},
			complete: function(){
				if (typeof callback == "function"){
					callback('complete');
				}
			}
		}).fail(function(xhr, status, error) {
			if (typeof callback == "function"){
				callback('fail',error);
			}	
		});
	},
	displayLog : function(pContent){
		if(typeof pContent !=='undefined' && pContent!==null && pContent!==""){
			console.log(pContent);
		}
		return true;
	}
	,
 }
}());