<?php
require_once('header.php');
?>


    <div class="container" style="text-align: left"> 
        
        <h2>Add</h2>
        <form name="addMovie" class="requires-validation" novalidate action="#" method="POST">
            <div class="form-group row">
                <label for="title" class="col-sm-2 col-form-label">Title</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="title" placeholder="Title" required>
                </div>
                <div class="invalid-feedback">Please enter a movie title.</div>                
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Format</label>
                <label class="mr-3">
                    <input type="radio" class="mr-1" name="format"> Streaming
                </label>
                <label class="mr-3">
                    <input type="radio" class="mr-1" name="format"> DVD
                </label>
                <label class="mr-3">
                    <input type="radio" class="mr-1" name="format"> VHS
                </label>
            </div>
            <div class="form-group row">
                <label for="length" class="col-sm-2 col-form-label">Length</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" id="length" placeholder="Length" required>
                    <div class="invalid-feedback">Please enter a movie Length.</div>                        
                </div>
            </div>
            <div class="form-group row">
                <label for="released" class="col-sm-2 col-form-label">Year Released</label>
                <div class="col-sm-2">
                    <select id="released" class="form-control">
                        <option>Select</option>
                        <option>2019</option>
                        <option>2018</option>
                        <option>2017</option>
                        <option>2016</option>
                        <option>2015</option>                                                                                                
                    </select>
                    <div class="invalid-feedback">Please select a Release Year.</div>                     
                </div>
            </div>   
            <div class="form-group row">
                <label for="rating" class="col-sm-2 col-form-label">Rating</label>
                <div class="col-sm-1">
                    <input type="text" class="form-control" id="rating" placeholder="Rating" required>
                    <div class="invalid-feedback">Please rate the movie.</div>                      
                </div>
            </div>                     
            <div class="form-group row">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-outline-primary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Movie</button>
                </div>
            </div>                                
        </form>
    </div>
    <!-- content -->
    </body>
</html>
