<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('header.php');
require_once('../models/Movies_model.php');

$movies = new Movies_model();
$data = $movies->list();

?>
    <br>
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
        
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Title <i class="fa fa-sort"></i></th>
                    <th>Format <i class="fa fa-sort"></i></th>
                    <th>Run Length <i class="fa fa-sort"></i></th>
                    <th>Released <i class="fa fa-sort"></i></th>
                    <th>Rating <i class="fa fa-sort"></i></th>  
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
                        if ($key == 'run_length') {
                            $output = sprintf("%d min", $value);
                        } else if ($key == 'rating') {
                                $output = "";
                                while ($value > 0) {
                                    $value--;
                                    $output.='<span class="float-right"><i class="text-warning fa fa-star"></i></span>';
                                }
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
                        <a href="#deleteMovieModal" class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>                        </td>                         
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
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-danger" value="Delete">
					</div>
				</form>
			</div>
		</div>
	</div>
    </body>
</html>