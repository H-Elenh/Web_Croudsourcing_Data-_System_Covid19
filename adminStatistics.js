	//set background color plugin
	const plugin = { 
		beforeDraw: (chart) => {
			const ctx = chart.canvas.getContext('2d');
			ctx.save();
			ctx.globalCompositeOperation = 'destination-over';
			ctx.fillStyle = 'rgb(255, 242, 254)';
			ctx.fillRect(0, 0, chart.width, chart.height);
			ctx.restore();
		}	
	}; 
	
	$(document).ready(function(){ 
	
	//Total visits by point of interest type
		$.ajax({
			type:"POST",
			url:"totalPerType.php",
			dataType: "json",
			cache: false,
			success:function(response){
				var types = [];
				var count = [];
				for(var i in response){        
					types.push(response[i].type_in_search);
					count.push(parseInt(response[i].search_type)); //convert it to integer      
				}

							   
				const ctx = document.getElementById('total_per_type').getContext('2d');
				const Charts = new Chart(ctx, {
					type: 'bar',
					data: {
						labels: types, //initiated above, placed on x axis
						datasets: [{
							label: 'visits',
							data: count, //initiated above, placed on x axis
							backgroundColor: [
								'rgba(114, 238, 144, 0.5)',
								'rgba(242, 240, 184, 0.5)',
								'rgba(246, 207, 250, 0.5)',
								'rgba(176, 189, 245, 0.5)',
								'rgba(196, 237, 245, 0.5)',
								'rgba(236, 202, 170, 0.5)'
							],
							borderColor: [
								'rgba(114, 238, 144, 1)',
								'rgba(242, 240, 184, 1)',
								'rgba(246, 207, 250, 1)',
								'rgba(176, 189, 245, 1)',
								'rgba(196, 237, 245, 1)',
								'rgba(236, 202, 170, 1)'
							],
							borderWidth: 1
						}]
					},
					options: {
						scales: {
							y: {
								beginAtZero: true
							}
						}
					},
					plugins: [plugin]//defined above
				});
			}
		})//end total visits by poi type request

		//Total visits only by positive cases by poi type request
		$.ajax({
			type:"POST",
			url:"positivePerType.php",
			dataType: "json",
			cache: false,
			success:function(response){
				var types = [];
				var count = [];
				for(var i in response){        
					types.push(response[i].type_in_search);
					count.push(parseInt(response[i].search_type));
				}

							   
				const ctx = document.getElementById('positive_per_type').getContext('2d');
				const Charts = new Chart(ctx, {
					type: 'bar',
					data: {
						labels: types,
						datasets: [{
							label: 'visits',
							data: count,
							backgroundColor: [
								'rgba(114, 238, 144, 0.5)',
								'rgba(242, 240, 184, 0.5)',
								'rgba(246, 207, 250, 0.5)',
								'rgba(176, 189, 245, 0.5)',
								'rgba(196, 237, 245, 0.5)',
								'rgba(236, 202, 170, 0.5)'
							],
							borderColor: [
								'rgba(114, 238, 144, 1)',
								'rgba(242, 240, 184, 1)',
								'rgba(246, 207, 250, 1)',
								'rgba(176, 189, 245, 1)',
								'rgba(196, 237, 245, 1)',
								'rgba(236, 202, 170, 1)'
							],
							borderWidth: 1
						}]
					},
					options: {
						scales: {
							y: {
								beginAtZero: true
							}
						}
					},
					plugins: [plugin] //defined above
				});
			}
		})// end Total visits only by positive cases by poi type request 

});