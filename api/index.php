<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$app = new \Slim\App;

$app->get('/stu','getStuList');
$app->post('/add_stu','addStu');
$app->put('/stu/:id','updateStu');
$app->delete('/stu/:id','deleteStu');

$app->run();


function connectDb() {
  $dbms='mysql';     //type
  $host='localhost'; //host
  $dbName='anslim';    //database
  $user='root';      //user
  $pass='12345';          //password
  try {
      $dbh = new PDO("mysql:host=$host;dbname=$dbName", $user, $pass);
      $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
      return $dbh;
  } catch (PDOException $e) {
      die ("Error!: " . $e->getMessage() . "<br/>");
  }
}


function getStuList() {
  $sql = "select * from stuinfo order by id";
  try {
    $db = connectDb();
    $data = $db->query($sql);

    $students = $data->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    echo '{"book": ' . json_encode($students) .'}';
  } catch(PDOExceptoin $e) {
    echo '{"error":{"msg":'. $e->getMessage() .'}}';
  }
}


function addStu() {
  $request = $app->request;
  $stuInfo = json_decode($request->getBody());
  $sql = "insert into stuinfo (name, number , phone ,address) values(:name,:number,:phone,:address)";
  try {
    $db = connectDb();
    $data = $db->prepare($sql);
    $data -> bindParam("name", $stuInfo->name);
    $data -> bindParam("number", $stuInfo->number);
    $data -> bindParam("phone", $stuInfo->phone);
    $data -> bindParam("address", $stuInfo->address);
    $data->execute();
    $stuInfo->id = $db->lastInsertId();
    $db = null;
    echo json_encode($stuInfo);
  } catch(PDOException $e) {
    echo echo '{"error":{"msg":'. $e->getMessage() .'}}';
  }
}

function updateStu($id) {
  $request = $app->request;
  $newStuInfo = json_encode($request->getBody());
  $sql = "update stuinfo set name=:name, number=:number, phone=:phone, address=:address where id=:id";
  try {
    $db = connectDb();
    $data = $db -> prepare($sql);
    $data -> bindParam("name",$newStuInfo->name);
    $data -> bindParam("number",$newStuInfo->number);
    $data -> bindParam("phone",$newStuInfo->phone);
    $data -> bindParam("address",$newStuInfo->address);
    $data -> bindParam("id",$id);
    $data -> execute();
    $db = null;
    echo json_encode($newStuInfo);
  } catch(PDOException $e) {
    echo '{"error":{"msg":'. $e->getMessage() .'}}';
  }
}

function deleteStu($id) {
  $sql = "delete from stuinfo where id = ".$id;
  try {
    $db = connectDb();
    $data = $db -> query($sql);
    $students = $data -> fetchAll(PDO::FETCH_OBJ);
    $db = null;
    echo json_encode($students);
  } catch (PDOException $e) {
    echo '{"error":{"msg":'. $e->getMessage() .'}}';
  }
}
