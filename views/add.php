<?php
require_once('header.php');
require_once('../models/Movies_model.php');

$origin = "/";

function isPostRequest() {
    return filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST';
}

// TODO: Handle Bool Input
function sanitize($variable, $field) {
    $filter = $field['validation']['filters'];
    $sanitized = filter_input(INPUT_POST, $variable, $filter);  
    if ($sanitized == NULL) {
        return false;
    }
    return $sanitized;
}

function validate(&$fields) {
    $isValid = true;

    $field_list = (array_keys($fields));
    foreach($field_list as $field) {
        $current_field = $fields[$field];
        $sanitized_field = sanitize($field, $current_field);

        if ($current_field['required'] && !$sanitized_field) {
            $fields[$field]['error'] = ucfirst($field) . ' is a required field.';

        } else if (in_array('max_length', $current_field['validation'])) {

            if (strlen($sanitized_field) > $current_field['validation']['max_length']) {
                $fields[$field]['error'] = ucfirst($field) . ' must be less than ' . $current_field['validation']['max_length'] . 'characters.';   
            }

        } else if (in_array('values', $current_field['validation'])) {
            
            if (!in_array($sanitized_field, $current_field['validation']['values'])) {
                $fields[$field]['error'] =  ucfirst($field) . ' can be either ' . implode(",", $current_field['validation']['values']).".";
            }

        } else if (in_array('range', $current_field['validation'])) {
            if (!((int) $sanitized_field >= $current_field['validation']['range'][0] 
                && (int) $sanitized_field <= $current_field['validation']['range'][1])) {
                $fields[$field]['error'] = ucfirst($field) . ' must be a value between  '. $current_field['validation']['range'][0] . ' and ' . $current_field['validation']['range'][1]; 
            }
        } else {
            $fields[$field]["valid"] = true;
            $fields[$field]["sanitized"] = $sanitized_field;
            $fields[$field]["raw"] = $_POST[$field];
        }

        if ($isValid && !$fields[$field]["valid"]) {
            $isValid = false;
        }
    }
    return $isValid;
}

if (isPostRequest()) {

/*     $redirect =  filter_input(INPUT_POST, 'origin');

    if (filter_input(INPUT_POST, 'action') == 'cancel') {
        header($redirect);
    } 
*/

    $fields = [
        'title' => [
            'required'  => true,
            'validation' => [
                'filters'   => FILTER_SANITIZE_STRING,
                'max_length'=> 50
            ],
            'raw'       => NULL,
            'sanitized' => NULL,
            'valid'     => false,
            'error'     => NULL
        ],
        'format' => [
            'required'  => true,            
            'validation' => [
                'filters'   => FILTER_SANITIZE_STRING,
                'values'    => ['DVD','VHS','Streaming']
            ],
            'raw'       => NULL,
            'sanitized' => NULL,
            'valid'     => false,
            'error'     => NULL            
        ],
        'length' => [
            'required'  => true,            
            'validation' => [
                'filters'   => FILTER_SANITIZE_NUMBER_INT,
                'range'     => [0, 500]
            ],
            'raw'       => NULL,
            'sanitized' => NULL,
            'valid'     => false,
            'error'     => NULL            
        ],
        'released' => [
            'required'  => true,
            'validation' => [
                'filters'   => FILTER_SANITIZE_NUMBER_INT,
                'range'     => [1800, 2100]
            ],
            'raw'       => NULL,
            'sanitized' => NULL,
            'valid'     => false,
            'error'     => NULL            
        ],
        'rating' => [
            'required'  => true,            
            'validation' => [
                'filters'   => FILTER_SANITIZE_NUMBER_INT,
                'range'     => [1,5]
            ],
            'raw'       => NULL,
            'sanitized' => NULL,
            'valid'     => false,
            'error'     => NULL            
        ],                        
    ];    

    $isValid = validate($fields);

    if ($isValid) {
        $data = [
            'title' => $fields['title']['sanitized'],
            'delivery_format' => $fields['format']['sanitized'],
            'run_length' => $fields['length']['sanitized'],
            'release_year' => $fields['released']['sanitized'],
            'rating' => $fields['rating']['sanitized']
        ];

        $movies = new Movies_model();
        $result = $movies->persist($data);
    }
}

?>


    <div class="container" style="padding-top:95px;"> 
        <div class="view-wrapper">        
        <h2>Add Movie</h2>
        <form name="addMovie" class="requires-validation" novalidate action="add.php" method="POST">
            <div class="form-group row">
                <label for="title" class="col-sm-2 col-form-label">Title</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="title" name="title" placeholder="Title" required>
                </div>
                <div class="invalid-feedback">Please enter a movie title.</div>                
            </div>
            <div class="form-group row">
                <label for="format" class="col-sm-2 col-form-label">Format</label>
                <label class="mr-3">
                    <input type="radio" class="mr-1" name="format" value="Streaming"> Streaming
                </label>
                <label class="mr-3">
                    <input type="radio" class="mr-1" name="format" value="DVD"> DVD
                </label>
                <label class="mr-3">
                    <input type="radio" class="mr-1" name="format" value="VHS"> VHS
                </label>
            </div>
            <div class="form-group row">
                <label for="length" class="col-sm-2 col-form-label">Length</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" id="length" name="length" placeholder="Length" required>
                    <div class="invalid-feedback">Please enter a movie Length.</div>                        
                </div>
            </div>
            <div class="form-group row">
                <label for="released" class="col-sm-2 col-form-label">Year Released</label>
                <div class="col-sm-2">
                    <input type="text" id="released" name="released" class="form-control" required>
                    <div class="invalid-feedback">Please enter a Release Year.</div>                     
                </div>
            </div>   
            <div class="form-group row">
                <label for="rating" class="col-sm-2 col-form-label">Rating</label>
                <div class="col-sm-1">
                    <input type="text" class="form-control" id="rating" name="rating" placeholder="Rating" required>
                    <div class="invalid-feedback">Please rate the movie.</div>                      
                </div>
            </div>                     
            <div class="form-group row">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-outline-primary" name="action" value="cancel">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="action" value="add">Add Movie</button>
                </div>
            </div>                                
        </form>
        </div>
    </div>
    <!-- content -->
    </body>
</html>
