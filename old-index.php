<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>A Simple MongoDB and PHP CRUD Application</title>
		  
		<!-- CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">		
		<link rel="stylesheet" href="css/alertify.core.css">
		<link rel="stylesheet" href="css/alertify.bootstrap3.css">			
		<link rel="stylesheet" href="css/app.css">
		<!-- JS -->
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/bootstrap.js"></script>
		<script type="text/javascript" src="js/alertify.min.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">	
					<h3>A Simple MongoDB and PHP CRUD Application</h3>					
				</div>
			</div>
			<hr>
		  	<div class="row">
			  	<div class="col-md-6 col-md-offset-3">	
				  	<div class="well">
				  	  <input type="text" class="form-control input-lg" name="title" id="title" placeholder="Title" autocomplete="off">
				  	  <input type="text" class="form-control input-lg" name="author" id="author" placeholder="Author" autocomplete="off">
				  	  <button type="button" class="btn btn-primary btn-block btn-lg" onclick="save();">Save</button>
				    </div>  
			    </div>  
	  	  	</div>
	  	  
	  	  <div class="row">
	  	  	<div class="col-md-6 col-md-offset-3">
			<table class="table">
				
			</table>
			</div>	
	  	  </div>
	  	
		  	<!-- Edit Modal -->
			<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			        <h4 class="modal-title" id="myModalLabel">Edit</h4>
			      </div>
			      <div class="modal-body">
			        <div class="">
			        	<input type="hidden" name="_id" id="edit_id">
			  	  		<input type="text" class="form-control input-lg" name="title" id="editTitle" placeholder="Title" autocomplete="off">
			  	  		<input type="text" class="form-control input-lg" name="author" id="editAuthor" placeholder="Author" autocomplete="off">
			    	</div> 
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        <button type="button" class="btn btn-primary" onclick="update();">Update</button>
			      </div>
			    </div>
			  </div>
			</div>
    	</div>	

    	<script type="text/javascript">
    		window.onload = function() {
				read();
			};

    		function read(){
				$.ajax({
					url: 'read.php',
					type: 'GET',
					dataType: 'JSON',
					success: function(data){
						for(var i in data){
							$('.table').prepend('<tr><td class="_id hidden">'+data[i]['_id']['$id']+'</td><td class="title">'+data[i].title+'</td><td class="author">'+data[i].author+'</td><td><button type="button" class="edit btn btn-primary pull-right">Edit</button></td><td><button type="button" class="delete btn btn-danger pull-right">Delete</button></td></tr>');
						}					
					}
				});	
    		}
    		function save(){
				var title = $('#title').val();
				var author = $('#author').val();
				$.ajax({
					url: 'save.php',
					type: 'POST',
					dataType: 'JSON',
					data: {title:title,author:author},
					success: function(data){
						console.log(data);
						$('.table').prepend('<tr><td class="_id hidden">'+data['_id']['$id']+'</td><td class="title">'+data['title']+'</td><td class="author">'+data['author']+'</td><td><button type="button" class="edit btn btn-primary pull-right">Edit</button></td><td><button type="button" class="delete btn btn-danger pull-right">Delete</button></td></tr>');
						$('#title,#author').val('');
						alertify.success(data['title']+' Saved Successfully');
					}
				});
    		}
    		$("body").keydown(function(event){
			    if(event.keyCode == 13){
			       save();
			    }
			});

			//edit guest details
			var $edit_row =''; 
			$(".table").on("click", ".edit", function() {
				$edit_row = $(this).closest("tr"); 
				var _id = $(this).closest("tr").find("._id").text();
				var title = $(this).closest("tr").find(".title").text();
				var author = $(this).closest("tr").find(".author").text();
				$('#edit_id').val(_id);
				$('#editTitle').val(title);
				$('#editAuthor').val(author);				
				$('#editModal').modal('show');
			});

			//edit guest details
			$(".table").on("click", ".delete", function() {
				var $this = $(this);
				var _id = $this.closest("tr").find("._id").text();
				
				$.ajax({
					url: 'delete.php',
					type: 'POST',
					dataType: 'JSON',
					data: {_id:_id},
					success: function(data){
						if(data['ok'] == 1){
							alertify.error('Removed');
							$this.closest("tr").remove();							
						}
					}
				});
			});

			function update(){
				var _id = $('#edit_id').val();
				var title = $('#editTitle').val();
				var author = $('#editAuthor').val();	
				$.ajax({
					url: 'update.php',
					type: 'POST',
					dataType: 'JSON',
					data: {_id:_id,title:title,author:author},
					success: function(data){
						$('#editModal').modal('hide');
						$('#title,#author').val('');
						alertify.success(data['title']+' Saved Successfully');		
						$edit_row.addClass('alert alert-success');
						$edit_row.closest("tr").find(".title").text(title);
						$edit_row.closest("tr").find(".author").text(author);
						removeActive($edit_row);
					}
				});
			}

			function removeActive($row){
				setTimeout(function(){
					$row.removeClass('alert alert-success');
				},1500);
					
			}
    	</script>	
	</body>
</html>