$(document).ready(function(){ //as soon as page loads

			var our_location = [38.24766514517526,21.73640339999747]; //maizonos kai ag. Nik
			var map = L.map('map').setView( our_location, 14); //14 is ~ 5km radius, which is our desired radius

			L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
			}).addTo(map); //map
			
			locationFetch(); //get locations from database and show as markers

		//Creating our popups
			var greenIcon = L.icon({
			iconUrl: 'pin-green.png', 
			
			iconSize: [15, 25], 
			iconAnchor: [0,0], 
			popupAnchor: [10,0] 
			});

			var orangeIcon = L.icon({
			iconUrl: 'pin-orange.png', 
			
			iconSize: [15, 25], 
			iconAnchor: [0,0], 
			popupAnchor: [10,0] 
			});
			
			
			var redIcon = L.icon({
			iconUrl: 'pin-red.png', 
			
			iconSize: [15, 25], 
			iconAnchor: [0,0], 
			popupAnchor: [10,0] 
			});

//set radius
			var startFrom = L.marker(our_location).addTo(map).bindPopup('Current Location.'); 		
			var radius = 5000; 
			
								

			function locationFetch(){
					
					$("#poiSearch").click(function() { 
					   
					   var input = $("#poi").val(); 
					   var date_now = $("#temp_date").val();		   
					   var time_now = $("#temp_time").val();
					   var day = $("#day").val();
						
						if(input !=""){ //if user has given input:
						
							$.ajax({ //Ajax request
								type: "POST",
								url: "getData.php", //execution file
								data:{input: input, time_now: time_now, day: day },
								dataType: "json",
								cache: false, //stops AJAX request cache in all browsers
								success: function(response) { //successful response:
									
									if(!response.errors && response.result) { 
										for (let i = 0; i < response.result.length; i++) { //check rows from results --> dataArray in getData.php encoded
											
											//check if poi is inside visible radius
											if(startFrom.getLatLng().distanceTo([parseFloat(response.result[i][1]) , parseFloat(response.result[i][2])]).toFixed(0) < radius){
												
												//Green marker position
												if(parseInt(response.result[i][3]) < 33){
												
															L.marker([parseFloat(response.result[i][1]) , parseFloat(response.result[i][2])] , {icon: greenIcon}).addTo(map).bindPopup(response.result[i][7]+
															"<br>Traffic +1h:"+response.result[i][4]+
															"<br>Traffic +2h:"+response.result[i][5]+
															"<br>Current popularity:"+response.result[i][6]+
															"<br>"+'<input type="text" id="traffic_now" name="traffic_now" placeholder="estimated traffic"><br>'
															+'<button id="visit">Visit</button>').on("popupopen", () => { $("#visit").on("click", e => { 
															e.preventDefault();												
															
															var poi_id = response.result[i][8];												
															var poi_name = response.result[i][7];				
															var traffic_now = $("#traffic_now").val();
													
															$.ajax({
															// onClick "visit" button --> 2nd ajax request
																type: "POST",												
																url: "visitConfirmation.php",				  
																data:{poi_id: poi_id , poi_name: poi_name, traffic_now: traffic_now, date_now: date_now, time_now: time_now, input: input, day:day},					
																dataType: "json",					
																cache: false, 				   
																success: function(response){												
																	alert("Visit registered!");
																}
															}) //end AJAX request
				  
														});// end $("#visit").on("click"
													});	//end popup open											
												}// end if for green marker

												
												//Orange marker position
												else if(parseInt(response.result[i][3]) < 66){
													
															L.marker([parseFloat(response.result[i][1]) , parseFloat(response.result[i][2])] , {icon: orangeIcon}).addTo(map).bindPopup(response.result[i][7]+
															"<br>Traffic +1h:"+response.result[i][4]+
															"<br>Traffic +2h:"+response.result[i][5]+
															"<br>Current popularity:"+response.result[i][6]+
															"<br>"+'<input type="text" id="traffic_now" name="traffic_now" placeholder="estimated traffic now"><br>'
															+'<button id="visit">Visit</button>').on("popupopen", () => { $("#visit").on("click", e => { 
															e.preventDefault();
					   
															var poi_id = response.result[i][8];					
															var poi_name = response.result[i][7];							
															var traffic_now = $("#traffic_now").val();
							
															$.ajax({
															// onClick "visit" button --> 2nd ajax request
																type: "POST",								
																url: "visitConfirmation.php",								
																data:{poi_id: poi_id , poi_name: poi_name, traffic_now: traffic_now, date_now: date_now, time_now: time_now, input: input, day:day},
																dataType: "json",								
																cache: false, 									
																success: function(response){									
																	alert("Visit registered!");											
																	}
															}) //end AJAX request
							  
														});// end $("#visit").on("click"
													});//end Popupopen 													
												}
												
												//Red marker Position
												else{
													
														L.marker([parseFloat(response.result[i][1]) , parseFloat(response.result[i][2])] , {icon: redIcon}).addTo(map).bindPopup(response.result[i][7]+
														"<br>Traffic +1h:"+response.result[i][4]+
														"<br>Traffic +2h:"+response.result[i][5]+
														"<br>Current popularity:"+response.result[i][6]+"<br>"+
														'<input type="text" id="traffic_now" name="traffic_now" placeholder="estimated traffic now"><br>'+
														'<button id="visit">Visit</button>').on("popupopen", () => { $("#visit").on("click", e => { 
														e.preventDefault();
					
														var poi_id = response.result[i][8];			
														var poi_name = response.result[i][7];			
														var traffic_now = $("#traffic_now").val();
					
															$.ajax({
															// onClick "visit" button --> 2nd ajax request
																type: "POST",
																url: "visitConfirmation.php",
																data:{poi_id: poi_id , poi_name: poi_name, traffic_now: traffic_now, date_now: date_now, time_now: time_now, input: input, day:day},
																dataType: "json",
																cache: false,				
																success: function(response){
																	alert("Visit registered!");
																}
															})//end AJAX request
				  
														});// end $("#visit").on("click"
													});	// end popup open											
												} //end red marker	
											} //end check if poi in radius 
										}//end for loop 
									}//end response error result
									
									else {
										$.each(response.errors, function( index, value) { 
										//if errors appear:
											$('input[name*='+index+']').addClass('error').after('<div class="errormessage">'+value+'</div>')
										});
									}

							}// end succsefull response check
							})//end AJAX request
							
						} //end input check
						
						else{ //if no input						
							alert('Cannot proceed withoun an input');
						}
					})//end onClick Go button
				}//end locationFetch()			
			
		}); //end (document).ready(function()