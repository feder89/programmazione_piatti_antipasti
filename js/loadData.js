var primi= new Array();
var secondi = new Array();
var contentId=new Array();
var primiId=new Array();
var secondiId=new Array();
$(document).ready(function(){

    loadData();

	setInterval(loadData, 5000);
    
	
});

function reload(){
	setTimeout("location.reload(true);", 60000);
}

window.onload=reload();

function loadData(){
	var inCorso=0;
	$.ajax({
        type: "GET",
        url: "ajax/ottieni_piatti_in_produzione_in_corso.ajax.php",
        dataType:"json",
        timeout: 4000,
        success:function(response){
            if (response) {
            if(response.length > 0){
            	inCorso=response[0].idprg;
            	loadDataNext(inCorso);
            }
            	
                showDataInCorso(response, inCorso);
            }
            else {
                // Process the expected results...
            }
        }

    });
}

function loadDataNext(indice){
	var idx =(parseInt(indice,10));
	$.ajax({
        type: "GET",
        url: "ajax/ottieni_piatti_in_produzione_next.ajax.php",
        dataType:"json",
        timeout: 4000,
        data:{
        	index: idx
        },
        success:function(response){
            if (response) {

                showDataNext(response, idx+1);
            }
            else {
                // Process the expected results...
            }
        }

    });
}

function showData(data){
	var array=_.groupBy(data, 'idprg');
	var gets=new Array();
	$.each(array, function(index, arr) {
		var idDiv = 'schedule-'+index;
		gets.push(idDiv);
		if(_.includes(contentId, idDiv)){			
			setOldDiv(idDiv,arr, index);
		}else{
			setNewDiv( arr, idDiv, index);
			contentId.push(idDiv);
		}		
	});

	var toRemove = _.difference(contentId, gets); 
	deleteDone(toRemove);
}

function showDataInCorso(data, nCombine){
	$('#combine-incorso').empty();
	$('#antipasto-incorso').empty();
	$('#dolce-incorso').empty();
	if(data.length > 0){
		$('#combine-incorso').append('COMBINE N. '+nCombine);
	}
	
					
	$.each(data, function(idx, value){	
			var field = '<p>  '+value.nr+'  '+value.portata.substring(0,20)+'</p>';
			if(value.portata.indexOf('GF') > -1){
				field = '<p>  '+value.nr+'  '+'<span class="gluten-free">GF</span>'+value.portata.substring(2,22)+'</p>';
			}	
			$('#'+value.cat+'-incorso').append(field);			
	});
}

function showDataNext(data, nCombine){
	$('#combine-next').empty();
	$('#antipasto-next').empty();
	$('#dolce-next').empty();
	if(data.length > 0){
		var comb = data[0].idprg;
		$('#combine-next').append('COMBINE N. '+comb);
	}
					
	$.each(data, function(idx, value){	
			var field = '<p>  '+value.nr+'  '+value.portata.substring(0,20)+'</p>';
			if(value.portata.indexOf('GF') > -1){
				field = '<p>  '+value.nr+'  '+'<span class="gluten-free">GF</span>'+value.portata.substring(2,22)+'</p>';
			}	
			$('#'+value.cat+'-next').append(field);			
	});
}

function setOldDiv( divId, data, nCombine){
	$('#antipasto-'+divId).empty();
	$('#dolce-'+divId).empty();
	$.each(data, function(idx, value){
		var field = '<p>  '+value.nr+'  '+value.portata.substring(0,20)+'</p>';
		if(value.portata.indexOf('GF') > -1){
			field = '<p>  '+value.nr+'  '+'<span class="gluten-free">GF</span>'+value.portata.substring(2,22)+'</p>';
		}
		$('#'+value.cat+'-'+divId).append(field);

	});
}

function setNewDiv( data, idDiv, nCombine){
	var _class = getColorClass();
	$('#content').append('<div class=" col-12 combine">'+'COMBINE N. '+nCombine+'</div>'
					+'<div class="col-6" id="dolce-'+idDiv+'"></div>'
      				+'<div class="col-6" id="antipasto-'+idDiv+'"></div>'
      				);
					
	$.each(data, function(idx, value){	
			var field = '<p>  '+value.nr+'  '+value.portata.substring(0,20)+'</p>';
			if(value.portata.indexOf('GF') > -1){
				field = '<p>  '+value.nr+'  '+'<span class="gluten-free">GF</span>'+value.portata.substring(2,22)+'</p>';
			}	
			$('#'+value.cat+'-'+idDiv).append(field);			
	});
}

function deleteDone(data){
	$.each(data, function(index, value){
		$('#'+value).remove();
	});
	_.remove(contentId, data);
}

var color=[
	'red',
	'blue',
	'yellow',
	'gray',
	'green',
	'purple',
	'lightblue'
];

function getColorClass(){
	var _class=color[0];
	color.push(color.shift());
	return _class;
}