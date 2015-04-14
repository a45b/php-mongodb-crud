<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />   
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>A Simple MongoDB and PHP CRUD Application</title>

	<link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="plugins/alertify/css/alertify.core.css">
	<link rel="stylesheet" href="plugins/alertify/css/alertify.bootstrap.css">


	<script type="text/javascript" src="plugins/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="plugins/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="plugins/alertify/js/alertify.min.js"></script>

</head>
<body>
	<header>
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12 text-center">						
					<div class="page-header">
					  <h3>A Simple MongoDB and PHP CRUD Application</h3>					
					</div>
				</div>
			</div>			
    	</div>
	</header>
    <div class="container-fluid">    	
    	<div class="row">		  
		  <div class="col-lg-offset-3 col-lg-6">
		    <div class="input-group">
		      <input type="text" class="form-control" id="search-input" placeholder="Search for...">
		      <span class="input-group-btn">
		        <button class="btn btn-default" type="button" id="search-btn" onclick="search();">Go!</button>
		      </span>
		    </div>
		    <a class="pull-left" role="button" href="#" id="all-list-btn" onclick="allList();"><i class="fa fa-list"></i> All List</a>
		    <a class="pull-right" role="button" href="#" id="all-list-btn" data-toggle="modal" data-target="#newModal"><i class="fa fa-plus"></i> Add New</a>		    
		  </div>
		</div>
		<hr>
		<div class="row">
	  	  	<div class="col-md-8 col-md-offset-2">
				<table class="table table-bordered" id="list-table">
					<thead>
						<tr>
							<th>Title</th>
							<th>Author</th>
							<th class="text-center">Edit</th>
							<th class="text-center">Delete</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>	
	  	</div>
    </div>

    <!-- Save Modal -->
	<div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="newModalLabel">New</h4>
	      </div>
	      <div class="modal-body">
	      	<div class="form-group">
			    <label>Title</label>
			    <input type="email" class="form-control" name="title" id="title" autocomplete="off">
			</div>

	  	  	<div class="form-group">
	  	  		<input type="text" class="form-control" name="author" id="author" autocomplete="off">
	    	</div> 
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary" onclick="save();">Save</button>
	      </div>
	    </div>
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
	      		<input type="hidden" name="_id" id="edit_id">
	      	<div class="form-group">
			    <label>Title</label>
			    <input type="email" class="form-control" name="title" id="editTitle" autocomplete="off">
			</div>

	  	  	<div class="form-group">
	  	  		<input type="text" class="form-control" name="author" id="editAuthor" autocomplete="off">
	    	</div> 
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary" onclick="update();">Update</button>
	      </div>
	    </div>
	  </div>
	</div>
   	<script type="text/javascript">
		window.onload = function() {
			read();
		};

		function allList(){
			read();
			$('#search-input').val('');
		}

		function search(){
			var search_string = $('#search-input').val();
			$.ajax({
				url: 'search.php',
				type: 'GET',
				dataType: 'JSON',
				data: {'search_string': search_string},
				success: function(data){
					$('#list-table tbody').empty();
					$('#search-input').val('');
					if (data.length) {
						for(var i in data){
							$('#list-table tbody').prepend('<tr><td class="_id hidden">'+data[i]['_id']['$id']+'</td><td class="title">'+data[i].title+'</td><td class="author">'+data[i].author+'</td><td class="text-center"><button type="button" class="edit btn btn-link btn-xs btn-block pull-right"><span class="text-primary"><i class="fa fa-pencil"></i> Edit</span></button></td><td class="text-center"><button type="button" class="delete btn btn-link btn-xs btn-block pull-right"><span class="text-danger"><i class="fa fa-trash"></i> Delete</span></button></td></tr>');
						}				
					}
					else{
						$('#list-table tbody').prepend('<tr class="danger"><td colspan="4">No Record Found</td></tr>');
					}	
				}
			});	
		}

		function read(){
			$.ajax({
				url: 'read.php',
				type: 'GET',
				dataType: 'JSON',
				success: function(data){
					$('#list-table tbody').empty();
					if (data.length) {
						for(var i in data){
							$('#list-table tbody').prepend('<tr><td class="_id hidden">'+data[i]['_id']['$id']+'</td><td class="title">'+data[i].title+'</td><td class="author">'+data[i].author+'</td><td class="text-center"><button type="button" class="edit btn btn-link btn-xs btn-block pull-right"><span class="text-primary"><i class="fa fa-pencil"></i> Edit</span></button></td><td class="text-center"><button type="button" class="delete btn btn-link btn-xs btn-block pull-right"><span class="text-danger"><i class="fa fa-trash"></i> Delete</span></button></td></tr>');
						}					
					}
					else{
						alert(1);
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
					$('#title, #author').val('');
					$('#newModal').modal('hide');
					if(data == 0){
						alertify.error('Error! Duplicate Entry');
					}
					else{						
						$('#list-table tbody').prepend('<tr><td class="_id hidden">'+data['_id']['$id']+'</td><td class="title">'+data['title']+'</td><td class="author">'+data['author']+'</td><td class="text-center"><button type="button" class="edit btn btn-link btn-xs btn-block pull-right"><span class="text-primary"><i class="fa fa-pencil"></i> Edit</span></button></td><td class="text-center"><button type="button" class="delete btn btn-link btn-xs btn-block pull-right"><span class="text-danger"><i class="fa fa-trash"></i> Delete</span></button></td></tr>');
						alertify.success('Saved Successfully');
						$('#list-table tbody tr').first().addClass('alert alert-success');
						removeActive($('#list-table tbody tr').first());
					}
				}
			});
		}    		

		//edit guest details
		var $edit_row =''; 
		$("#list-table tbody").on("click", ".edit", function() {
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
					if(data == 0){
						alertify.error('Error! Duplicate Entry');
					}
					else{
						alertify.success('Updated Successfully');						
						$edit_row.addClass('alert alert-success');
						$edit_row.closest("tr").find(".title").text(title);
						$edit_row.closest("tr").find(".author").text(author);
						removeActive($edit_row);
					}
				}
			});
		}

		//delete
		$("#list-table tbody").on("click", ".delete", function() {
			var $this = $(this);
			var _id = $this.closest("tr").find("._id").text();
			
			$.ajax({
				url: 'delete.php',
				type: 'POST',
				dataType: 'JSON',
				data: {_id:_id},
				success: function(data){
					if(data['ok'] == 1){
						alertify.error('Deleted Successfully');
						$this.closest("tr").remove();							
					}
				}
			});
		});

		function removeActive($row){
			setTimeout(function(){
				$row.removeClass('alert alert-success');
			},1500);
				
		}
	</script>
</body>
</html>