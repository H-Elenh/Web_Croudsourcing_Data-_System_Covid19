$(document).ready(function(){
 
	$(document).on('click','a[data-role=update]',function(){
	//click update: add values to modal input fields
	
	//get values from  POI table - id and children(all based on their data-target value)
		var id = $(this).data('id');
		console.log(id);
		var name = $('#'+id).children('td[data-target=name]').text();
		var address = $('#'+id).children('td[data-target=address]').text();
		var types = $('#'+id).children('td[data-target=types]').text();
		var coords = $('#'+id).children('td[data-target=coords]').text();
		var rating = $('#'+id).children('td[data-target=rating]').text();
		var rating_n = $('#'+id).children('td[data-target=rating_n]').text();
		var populartimes = $('#'+id).children('td[data-target=populartimes]').text();
		var curr_popularity = $('#'+id).children('td[data-target=curr_popularity]').text();
		
		//add values to modal input fields 
		$('#name').val(name);
		$('#address').val(address);
		$('#types').val(types);
		$('#coords').val(coords);
		$('#rating').val(rating);
		$('#rating_n').val(rating_n);
		$('#populartimes').val(populartimes);
		$('#current_pop').val(curr_popularity);
		$('#poiId').val(id); //hidden
		$('#popupBox').modal('toggle'); //toggle the modal        
	});

	//fetch data from modal's input fields
	$('#save').click(function(){
		var id = $('#poiId').val();
		console.log(id);
		var name = $('#name').val();
		var address = $('#address').val();
		var types = $('#types').val();
		var coords = $('#coords').val();
		var rating = $('#rating').val();
		var rating_n = $('#rating_n').val();
		var populartimes = $('#populartimes').val();
		var current_pop = $('#current_pop').val();

		$.ajax({//edit poi table values
			type:"POST",
			url:"poi_update.php",
			data:{id: id , name: name , address: address , types:types, coords:coords, rating:rating, rating_n:rating_n, populartimes:populartimes, current_pop: current_pop},
			success: function(response){
				$('#'+id).children('td[data-target=name]').text(name);
				$('#'+id).children('td[data-target=address]').text(address);
				$('#'+id).children('td[data-target=types]').text(types);
				$('#'+id).children('td[data-target=coords]').text(coords);
				$('#'+id).children('td[data-target=rating]').text(rating);
				$('#'+id).children('td[data-target=rating_n]').text(rating_n);
				$('#'+id).children('td[data-target=populartimes]').text(populartimes);
				$('#'+id).children('td[data-target=curr_popularity]').text(current_pop);
				$('#popupBox').modal('toggle');
			}
		})

	});
});
