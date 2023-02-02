<?php 
declare(strict_types=1);
session_start();

spl_autoload_register(function ($class) {
    include __DIR__ . '/class/'.$class.'.php';
});
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Завдання 1</title>
	
	<style>
	#basic-addon2
	{
		cursor: pointer;	
	}
	
	
	.search_bar
	{
		justify-content: space-between;
		align-items: center;	
	}
	
	#search_results
	{
		min-height: 3rem;
	}
	
	.graf_entry
	{
		background-color: green;
		display: inline-block;
		margin-right: 3px;
		position: relative;
		min-width: 30px;
	}
	
	.graf_val
	{
		transform: rotate(270deg);
		position: absolute;
		bottom: 40px;
		left: -45px;
		white-space: nowrap;
		font-weight: 700;	
	}
	
	</style>
	
  </head>
  <body>
    <div class="container mt-2">
	
		<h1>Завдання: перегляд курсу</h1>
		
		<div class="d-flex search_bar"> 
			<div class="input-group mb-2  pt-2">
			  <input type="date"  class="form-control" id="startDate" placeholder="Пошук дати" aria-describedby="basic-addon2">
			  <span class="input-group-text" id="basic-addon2"  onclick="search(document.getElementById(`startDate`).value)">Пошук</span>
			</div>
			
			<div class="ms-2">
				<button class="btn btn-success"  data-bs-toggle="modal" data-bs-target="#exampleModal">+</button>
			</div>
		</div>
		
		<div id="search_results"></div>
		
		<div id="all_results" class="mt-3">
			 <ul class="nav nav-tabs" id="myTab" role="tablist">
			  <li class="nav-item" role="presentation">
				<button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Таблиця</button>
			  </li>
			  <li class="nav-item" role="presentation">
				<button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Графік</button>
			  </li>			  
			</ul>
			
			<div class="tab-content" id="myTabContent">
			  <div class="tab-pane fade show active pt-3 ps-2" id="home" role="tabpanel" aria-labelledby="home-tab">
			  
				<?php
				if(@$_SESSION['data'])
				{
					$sorted = (new ArrayClass($_SESSION['data']))->sort();
					
					foreach($sorted as $key=>$value)
					{
						echo '<b>'.$key.'</b>: '.$value.'<br>';  		
					}
				}
				
				?>
			  
			  
			  </div>
			  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
				<div class="graf pt-3">
				<?php
				if(@$_SESSION['data'])
				{
					$sorted = (new ArrayClass($_SESSION['data']))->sort();
					
					foreach($sorted as $key=>$value)
					{
						echo '<div class="graf_entry" style="min-height: '.$value * 7 .'px;"><p class="graf_val">'.$key.' - '.$value.'</p></div>';  		
					}
				}
				
				?>
				 </div>
			  
			  
			  </div> 			
			</div>
		
		
		</div>
	
	</div>

    
	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Додати запис</h5>
			<button type="button" id="close_modal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		  </div>
		  <div class="modal-body">
			<div class="d-flex search_bar">
				<input type="date"  class="form-control" id="startDateSearch" placeholder="Додати дату">
				<input type="text" class="form-control" id="add_kurs" name="add_kurs" placeholder="Курс">
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-primary" onclick="saveKurs()">Зберегти</button>
		  </div>
		</div>
	  </div>
	</div>




	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
	</script>
	
	<script src="https://code.jquery.com/jquery-3.6.3.js"
	  integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
	  crossorigin="anonymous">
	</script>
	
	<script>
	
	function saveKurs()
	{
		let date = document.querySelector('#startDateSearch').value;
		let curs = document.querySelector('#add_kurs').value;
		
		if(!curs||!date) { alert("Необхідно заповнити поле Курс і Дата!"); } else {
		
		let entry = {
			'curs' : curs,
			'date' : date
		}		
		
		let result = document.getElementById('home'); 
		let graf   = document.getElementById('profile');		
		
		$.post('workers/add_kurs.php',
		   {arr: entry},
			function(response){
			
			console.log(response);
			
			let arr_result = JSON.parse(response);			
			
			
			
			if(arr_result['status']==='ok')
				{
				let out='';
				let grafik='<div class="graf pt-3">';
				
				let entries = Object.entries(arr_result['arr']);
				
				entries.forEach(elem => 
				
					{
						out= out + '<b>' +   elem[0] + '</b>: ' +  elem[1] + '<br>';
						
						
						grafik = grafik + '<div class="graf_entry" style="min-height: ' +  (elem[1]*7) + 'px;"><p class="graf_val">' + elem[1] + ' - '+ elem[0] +'</p></div>'; 
						
					}
				
				);		
					result.innerHTML=out;
					graf.innerHTML=grafik + '</div>';	
					document.getElementById('close_modal').click();
					
					
				} 
			}
		);
		}
	}
	
	function search(elem)
	{
		 if(!elem) {
			alert("Дата не вибрана!");	
		 } else {
			let result = document.getElementById('search_results');  
			
			let entry = {'elem' : elem}
			
			$.post('workers/search.php',
			   {arr: entry},
				function(response){
					result.innerHTML=response;
				});
		 }
	}
	
	</script>
  </body>
</html>
