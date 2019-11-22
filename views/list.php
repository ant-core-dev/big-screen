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
        <div class="row">
            <div class="col-sm-6">
				<h2>Movies</h2>
			</div>        
        </div>
        
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>Title</th>
                    <th>Format</th>
                    <th>Run Length</th>
                    <th>Released</th>
                    <th>Rating</th>                    
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
                    </tr>
                <?php endforeach;?>          
            </tbody>
        </table>


    </div>
    <!-- content -->

    </body>
</html>