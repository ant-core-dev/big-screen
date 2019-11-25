<?php

function isGetRequest() {
    return filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'GET';
}

function isPostRequest() {
    return filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST';
}

function sanitize($variable, $field) {
    $filter = $field['validation']['filters'];
    $sanitized = filter_input(INPUT_POST, $variable, $filter);  
    if ($sanitized == NULL) {
        return false;
    }
    return $sanitized;
}

function formatRatingStars($rating = 0) {
    if ($rating == 0) {
        return "(No Ratings)";
    }
    
    $html = "";
    while ($rating > 0) {
        $rating--;
        $html.='<span class="float-right"><i class="text-warning fa fa-star"></i></span>';
    } 
    return $html;   
}

function formatRunLength($runLength = 0) {
    return sprintf("%d min", $runLength);
}