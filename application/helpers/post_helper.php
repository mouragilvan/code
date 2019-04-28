<?php 

function post($data=""){
  if($data != ""){
       $post = json_decode(file_get_contents("php://input"), true);
       return $post[$data];
  }
  return  json_decode(file_get_contents("php://input"), true);
}