<?php
session_start();

include "config/config.php";

include "config/db.class.php";

include "config/functions.php";

if(isset($_POST["action"])){
  if($_POST["action"] == "delete"){
    delete();
  }
}

function delete(){
  $id = $_POST["id"];

  DB::update('Classes',['ClassStatus' => 0], 'ClassID=%i', $id);
  echo 1;
}
