var ViewHelpers = (function(){
 return {

	showProgressBar : function(pHolder){
		$("#"+pHolder).html('<div class="progress"><div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%"><span class="progress-text">0% Complete</span></div></div>')
	}
	,
	hideProgressBar : function(pHolder){
		$("#"+pHolder).html('');
	} 
	,
	updateProgressBar : function(pHolder,pWidth,pText){
		if(typeof pWidth !== 'undefined' && pWidth > 0){
			pWidth = parseInt(pWidth);
		}
		else{
			pWidth = 0;
		}
		if(typeof pText !== 'undefined' && pText !==""){
			pText = pText;
		}
		else{
			pText = "";
		}
		
		$("#"+pHolder+' .progress-bar').css('width',pWidth+'%');
		$("#"+pHolder+' .progress-bar').attr("aria-valuenow",pWidth);
		if(pText !=""){
			$("#"+pHolder+' .progress-text').text(pText);
		}
	}
	,
	showAppLoader : function(){
		$("#app_loader").show();
	}
	,
	hideAppLoader : function(){
		$("#app_loader").hide();
	}
	,
	showSpinner : function(pHolder){
		$("#"+pHolder).show();
	}
	,
	hideSpinner : function(pHolder){
		$("#"+pHolder).hide();
	}
	,
	notify : function(pType,pMessage){
		if(pType && pMessage){
			//pType = warn / success / info / error
			$.notify(pMessage,pType);
			//$.notify(pMessage,{autoHide:false, clickToHide: true, hideDuration:2000});
		}	
	}
	,
	notifyCustom : function(pTitle,pMessage){
		
		// NOTE : create custom css class as livemsg and design as per your need
		
		if(pTitle!==undefined && pTitle!="" && pMessage!==undefined && pMessage!=""){
			if(screen.width < 600){
				$(".notifyjs-livemsg-base").parent().parent().parent().css({"top":"150px","right":"0px","max-height": "100vh","overflow": "auto","bottom": "150px"});	
			}
			else{
				$(".notifyjs-livemsg-base").parent().parent().parent().css({"bottom":"0px","right":"0px","max-height": "500px","overflow": "auto","margin-top": "20px !important"});	
			}
			$.notify.addStyle('livemsg', {
								  html: 
									"<div>" +
									  "<div class='clearfix'>" +
										"<div class='body'>"+
											"<div class='left'><h2><img src='/images/comment.png'/></h2></div>"+
											"<div class='right'>"+
												"<span class='livemsg-close'>x</span>" +
												"<div class='title' data-notify-html='title'/>" +
												"<div class='content' data-notify-html='content'/>" +
											"</div>" +	
										"</div>" +	
									  "</div>" +
									"</div>"
							});
							
			$.notify({title:pTitle,content:pMessage},{style:'livemsg',autoHide:false,clickToHide: false,position:'bottom right',showDuration:1000,hideDuration:1000});
			//listen for click events from this style
			$(document).on('click', '.notifyjs-livemsg-base .livemsg-close', function() {
			  //programmatically trigger propogating hide event
			  $(this).trigger('notify-hide');
			});
		}
		else{
			$(".notifyjs-wrapper").remove();
		}
	}
	,
	formatDate : function(pDate,pFormat ='DD/MM/YY HH:mm'){
		var retval = '';
		if(pDate && pDate!=null && pDate!=""){
			retval = moment(pDate).format(pFormat);
		}
		return retval;
	}
	,
	formatDateMDY : function(pDate,pFormat ='MM/DD/YY HH:mm'){
		var retval = '';
		if(pDate && pDate!=null && pDate!=""){
			retval = moment(pDate).format(pFormat);
		}
		return retval;
	}
 }
}());