<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('header.php');
require_once('../models/Movies_model.php');
require_once('../helpers/view_helpers.php');

$movies = new Movies_model();
$data = [];

if (isGetRequest()) {
    
    $sort = filter_input(INPUT_GET, 'sort', FILTER_SANITIZE_NUMBER_INT);
    $orderBy = $sort ? $sort : 1;
    $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
    $offset = $page ? $page : 1;
    $limit = filter_input(INPUT_GET, 'limit', FILTER_SANITIZE_NUMBER_INT);
    $records = $limit ? $limit : 10;

    $data = $movies->list($orderBy, $offset, $records);
}

?>
    <div class="container-fluid" style="padding-top:95px;"> 
        <div class="table-wrapper">
        <div class="row">
            <div class="col-sm-6">
				<h2>Movies</h2>
            </div>   
            <div class="col-sm-6">
                <div class="float-right">
				    <a href="add.php" class="btn btn-primary"><i class="material-icons">&#xE147;</i> <span>Add Movie</span></a>
                </div>
            </div>                 
        </div>
        
        <table class="table table-striped table-hover movies">
            <thead class="thead-dark">
                <tr>
                    <th class="sort" data-sort="1">Title <i class="fa fa-sort"></i></th>
                    <th class="sort" data-sort="2">Format <i class="fa fa-sort"></i></th>
                    <th class="sort" data-sort="3">Run Length <i class="fa fa-sort"></i></th>
                    <th class="sort" data-sort="4">Released <i class="fa fa-sort"></i></th>
                    <th class="sort" data-sort="5">Rating <i class="fa fa-sort"></i></th>  
                    <th>Actions</th>                  
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                    <tr>
                    <?php foreach ($row as $key=>$value):
                        if ($key == 'id'){
                            $id = $value;
                            continue;
                        }
                        $output = "";   
                        if ($key == 'run_length') {
                            $output = formatRunLength($value);
                        } else if ($key == 'rating') {
                            $output = formatRatingStars($value);
                        } else {
                            $output = $value;
                        }

                    ?>
                         <td><?= $output ?></td>
                     <?php endforeach;?>
                     <!-- Actions -->
                     <td>
                        <a href="view.php?id=<?=$id?>" class="view" title="View" data-toggle="tooltip"><i class="material-icons">&#xE417;</i></a>
                        <a href="edit.php?id=<?=$id?>" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                        <a href="#deleteMovieModal" class="delete" title="Delete" data-toggle="modal" data-row-id=<?=$id?>><i class="material-icons">&#xE872;</i></a>                        </td>                         
                     </td>
                    </tr>
                <?php endforeach;?>          
            </tbody>
        </table>

        </div>
    </div>
    <!-- content -->
	<div id="deleteMovieModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form>
					<div class="modal-header">						
						<h4 class="modal-title">Delete Movie</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">					
						<p>Are you sure you want to delete this movie?</p>
						<p class="text-warning"><small>This action cannot be undone.</small></p>
					</div>
					<div class="modal-footer actions">
                        <input type="hidden" name="movie_id" value=""/>
						<input type="button" class="btn btn-outline-primary" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-primary" value="Delete Movie">
					</div>
				</form>
			</div>
		</div>
	</div>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.movies')
                .on('click', '.sort', onSortClick);

            $('#deleteMovieModal')
                .on('show.bs.modal', function(e) {
                    var id = $(e.relatedTarget).data('row-id');
                    $(e.currentTarget).find('input[name="movie_id"]').val(id);
                })
                .on('submit', function(e){
                    e.preventDefault();
                    $.ajax({
                        method: "POST",
                        url: "delete.php",
                        data: {
                            id: $(e.currentTarget).find('input[name="movie_id"]').val()
                        }
                    })
                    .done(function (response) {
                        console.log(response);
                        if (response.success) {
                            window.location('list.php');
                        }
                        $('#deleteMovieModal').modal('hide');                       
                    }); 
                });

            function onSortClick(e) {
                window.location.href = "list.php?sort="+$(e.currentTarget).data('sort');
            }
            
        });
    </script>  
    </body>
</html>