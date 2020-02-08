var StorageHelpers = (function(){
 return {

	setItem : function(pKey,pVal){
		localStorage.setItem(pKey,pVal);
		return true;
	}
	,
	getItem : function(pKey){
		return localStorage.getItem(pKey);
	}
	,
	removeItem : function(pKey){
		localStorage.removeItem(pKey);
		return true;
	}
 }
}());