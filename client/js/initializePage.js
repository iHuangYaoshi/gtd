$('document').ready(function(){
	$('#application').initialize_Gtd();
});

$.fn.initialize_Gtd = function(){

	$('.date-field',this).enable_DateField();
	$('.basic-table',this).enable_TableSort();
	$('.basic-table-container',this).enable_QuickSearch();
	$('.js-swappable-btn',this).enable_Swappable();
	$('.js-hideable-btn',this).enable_Hideable();
	$('.multiple-buttons-btn',this).enable_MultipleButtons();
	$('input[name=ajax_target_id]',this).enable_Ajax();
	$('input[name=auto_submit]',this).enable_AutoSubmit();

	return this;
}

$.fn.slideFadeIn = function(speed, easing, callback) {
	return this.animate({opacity: 'show', height: 'show'}, speed, easing, callback);  
}

$.fn.slideFadeOut = function(speed, easing, callback) {        	
	return this.animate({opacity: 'hide', height: 'hide'}, speed, easing, callback);  
}

$.fn.enable_DateField= function(){
	$(this).datepicker({ dateFormat: 'yy-mm-dd'});
 	 return this;
}

$.fn.enable_TableSort = function (){
	$(this).tablesorter({widgets: ['zebra']});
	return this;
}

$.fn.enable_QuickSearch = function (){
	$(this).each( function() {
		rows = $(this)
				.children('.basic-table')
				.children('tbody')
				.children('tr');
		selector = 	$(this)
					.children('.quicksearch')
					.children('form')
					.children('.qs-input');
		selector.quicksearch(rows);
	});
	return this;
}

$.fn.enable_Swappable = function (){
	$(this).each( function(){
		$(this).click( function(){
			$(this).siblings('.swappable-item').toggle();
		})
	});
	return this;
}

$.fn.enable_MultipleButtons= function (){
	
	$(this).each( function(){
		$(this).click( function(){
			item = $('[data-id=' + $(this).attr('data-id') + ']', '.multiple-buttons-targets');
			if (item.css('display')=='none'){
				item.siblings().hide();
				item.show();	
			}else{
				item.hide();
			}
		})
	});
	return this;
}


$.fn.enable_Hideable = function (){
	$(this).each( function(){
		$(this).click( function(){
			item = $(this).siblings('.hideable-item');
			if ( item.css('display') == 'none' ){
				item.slideFadeIn(180,'easeOutCubic');
			} else {
				item.slideFadeOut(180,'easeInCubic');
			}
		})
	});
	return this;
}

$.fn.enable_MultiSelect = function(){
	$(this).multiSelect({oneOrMoreSelected: '*'});
	return this;
}

$.fn.enable_AutoSubmit = function(){

	$(this).each( function(){
		auto_submit_input_name = '[name='+$(this).val()+']';
    	form = $( this ).parents('form');
		$('.submit-container',form).hide();
		$(auto_submit_input_name,form).change(function(){
			$(form).submit();
		});
	});
}

$.fn.enable_Ajax = function(){
	var selector = this;
	var ajax_target_id = '#'+$(this).val();
 
	initializeSubmitButtons( );

	function initializeSubmitButtons( ){
            $( selector ).parents('form').submit( function(){
			form = this;
			getGraphData();
			return false;
		});
	}
    function getGraphData(){
		showLoaderGraphic();
		$.ajax({
			type: 'GET',
			url: 'index.php',
			data: serializeFormData(),
			success: function(JSONtext){
				loadView(JSONtext);
//				initializeSubmitButtons();
				$( ajax_target_id ).initialize_Gtd();
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
			  hideLoaderGraphic();
			  log('ajax request failed');
			}
		});
    }
    function loadView( html ){
        $(ajax_target_id).html( html );
        hideLoaderGraphic();
    }
    function serializeFormData() {
        var sel, serializedData = "";
        if (!form) return false;
		$( ':input', form).each(function(){
			serializedData += $(this).attr('name') + "=" + $(this).val() + "&";
		});
        selectBoxes = form.getElementsByTagName("select");
        if( selectBoxes) {
            total = selectBoxes.length;
        } else {
            total = 0;
        }
        for ( i=0; i<total; i++) {
            sel = selectBoxes[i];
            serializedData += sel.name + "=" + sel.options[sel.selectedIndex].value + "&";
        }
        return encodeURI( serializedData);
    }
    function showLoaderGraphic() {
        $('.loader').html('<div style="margin: 25% 44%">'+
            '<div style="text-align:center; width:50px"><img src="/img/ajax-loader.gif" /></div>'+
            '<div style="color:#993333; text-align:center; width:50px; font-weight:bold">Loading</div>'+
            '</div>');
    }
    function hideLoaderGraphic() {
        $(' .loader').html('');
    }
    function url( param) {
        var regex = '[?&]' + param + '=([^&#]*)';
        var results = (new RegExp(regex)).exec(window.location.href);
        if(results) return results[1].replace('%20',' ');
        return false;
    }
	return this;
}