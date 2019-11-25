<?php
require_once('header.php');
require_once('../models/Movies_model.php');
require_once('../helpers/view_helpers.php');

$data = [];
if (!isGetRequest()) {
    header("Location: /");
}   

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$id) {
    header("Location: /");
}
$movies = new Movies_model();
$data = $movies->get($id);
if (!$data) {
    header("Location: /");
}

?>
    <div class="container" style="padding-top:95px;"> 
        <div class="view-wrapper">   
        <h2>View Movie</h2>
        <form name="addMovie" class="requires-validation" novalidate action="add.php" method="POST">
            <div class="form-group row">
                <label for="title" class="col-sm-2 col-form-label">Title</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control-plaintext" id="title" name="title" placeholder="Title"  value="<?=$data['title']?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="format" class="col-sm-2 col-form-label">Format</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control-plaintext" id="title" name="title" placeholder="Title"  value="<?=$data['delivery_format']?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="length" class="col-sm-2 col-form-label">Length</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control-plaintext" id="length" name="length" placeholder="Length"  value="<?=formatRunLength($data['run_length'])?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="released" class="col-sm-2 col-form-label">Year Released</label>
                <div class="col-sm-2">
                    <input type="text" id="released" name="released" class="form-control-plaintext" value="<?=$data['release_year']?>">
                </div>
            </div>   
            <div class="form-group row">
                <label for="rating" class="col-sm-2 col-form-label">Rating</label>
                <div class="col-sm-1">
                    <?= formatRatingStars($data["rating"])?>
                </div>
            </div>                     
            <div class="form-group row">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-primary" name="action" value="edit">Edit Movie</button>
                </div>
            </div>                                
        </form>
        </div>
    </div>    
    </body>
</html>    