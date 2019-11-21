<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('header.php');
require_once('../models/Movies_model.php');

//$movies = new Movies_model();
//$data = $movies->list();
$data = ['data'=>'required']

?>
    <!--TODO: Add Content -->
    <div class="container-fluid"> 
        <h2>Movies</h2>
        <?php
            //print_r($data);        
        ?>
        <br/>
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
                <tr>
                    <td>John Wick</td>
                    <td>Streaming</td>
                    <td>1 Hour 25 Minutes</td>
                    <td>2017</td>
                    <td>            
                        <span class="float-right"><i class="text-warning fa fa-star"></i></span>
                        <span class="float-right"><i class="text-warning fa fa-star"></i></span>
        	            <span class="float-right"><i class="text-warning fa fa-star"></i></span>
                        <span class="float-right"><i class="text-warning fa fa-star"></i></span>
                        <span class="float-right"><i class="text-warning fa fa-star"></i></span>                        
                    </td>
                </tr>
                <tr>
                    <td>John Wick II</td>
                    <td>Streaming</td>
                    <td>2 Hours</td>
                    <td>2018</td>
                    <td>
                        <span class="float-right"><i class="text-warning fa fa-star"></i></span>
                        <span class="float-right"><i class="text-warning fa fa-star"></i></span>
        	            <span class="float-right"><i class="text-warning fa fa-star"></i></span>
                        <span class="float-right"><i class="text-warning fa fa-star"></i></span>                        
                    </td>
                </tr>
                <tr>
                    <td>Avengers</td>
                    <td>DVD</td>
                    <td>3 Hours</td>
                    <td>2018</td>                    
                    <td>
                    <span class="float-right"><i class="text-warning fa fa-star"></i></span>
                    <span class="float-right"><i class="text-warning fa fa-star"></i></span>
                    <span class="float-right"><i class="text-warning fa fa-star"></i></span>
                    <span class="float-right"><i class="text-warning fa fa-star"></i></span>                                                                                    
                    </td>
                </tr>            
            </tbody>
        </table>


    </div>
    <!-- content -->

    </body>
</html>