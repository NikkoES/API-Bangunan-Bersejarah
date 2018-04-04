<?php

use Slim\Http\Request;
use Slim\Http\Response;

function getConnect(){
    require_once 'include/dbHandler.php';
    $db = new dbHandler();
    return $db;
}

// Routes

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

//-------------------- CRUD DAERAH -------------------------

//menampilkan list semua daerah berdasarkan provinsi
$app->get("/daerah/{id_provinsi}", function (Request $request, Response $response, $args){
    $id = $args["id_provinsi"];
    $sql = "SELECT * FROM tb_daerah WHERE id_provinsi=:id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([":id" => $id]);
    $result = $stmt->fetchAll();
    return $response->withJson(["status" => "success", "data" => $result], 200);
});

//menambahkan daerah
$app->post("/daerah/", function (Request $request, Response $response){

    $daerah = $request->getParsedBody();

    $sql = "INSERT INTO tb_daerah (nama_daerah, id_provinsi) VALUE (:nama_daerah, :id_provinsi)";
    $stmt = $this->db->prepare($sql);

    $data = [
        ":nama_daerah" => $daerah["nama_daerah"],
        ":id_provinsi" => $daerah["id_provinsi"]
    ];

    if($stmt->execute($data))
       return $response->withJson(["status" => "success", "data" => "1"], 200);
    
    return $response->withJson(["status" => "failed", "data" => "0"], 200);
});

//mengedit daerah
$app->put("/daerah/{id}", function (Request $request, Response $response, $args){
    $id = $args["id"];
    $daerah = $request->getParsedBody();
    $sql = "UPDATE tb_daerah SET nama_daerah=:nama_daerah, id_provinsi=:id_provinsi WHERE id_daerah=:id";
    $stmt = $this->db->prepare($sql);
    
    $data = [
        ":id" => $id,
        ":nama_daerah" => $daerah["nama_daerah"],
        ":id_provinsi" => $daerah["id_provinsi"]
    ];

    if($stmt->execute($data))
       return $response->withJson(["status" => "success", "data" => "1"], 200);
    
    return $response->withJson(["status" => "failed", "data" => "0"], 200);
});

//menghapus daerah
$app->delete("/daerah/{id}", function (Request $request, Response $response, $args){
    $id = $args["id"];
    $sql = "DELETE FROM tb_daerah WHERE id_daerah=:id";
    $stmt = $this->db->prepare($sql);
    
    $data = [
        ":id" => $id
    ];

    if($stmt->execute($data))
       return $response->withJson(["status" => "success", "data" => "1"], 200);
    
    return $response->withJson(["status" => "failed", "data" => "0"], 200);
});

//-------------------- END CRUD DAERAH -------------------------


//-------------------- CRUD BANGUNAN -------------------------

//menampilkan list semua bangunan berdasarkan provinsi
$app->get("/bangunan/{id_provinsi}", function (Request $request, Response $response, $args){
    $id = $args["id_provinsi"];
    $sql = "SELECT * FROM tb_bangunan WHERE id_provinsi=:id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([":id" => $id]);
    $result = $stmt->fetchAll();
    return $response->withJson(["status" => "success", "data" => $result], 200);
});


//menampilkan list bangunan berdasarkan daerah dan provinsi
$app->get("/bangunan/{id_provinsi}/{id_daerah}", function (Request $request, Response $response, $args){
    $id_provinsi = $args["id_provinsi"];
    $id_daerah = $args["id_daerah"];
    $sql = "SELECT * FROM tb_bangunan WHERE id_provinsi=:id_provinsi AND id_daerah=:id_daerah";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([":id_provinsi" => $id_provinsi, ":id_daerah" => $id_daerah]);
    $result = $stmt->fetchAll();
    return $response->withJson(["status" => "success", "data" => $result], 200);
});

//menambahkan bangunan
$app->post("/bangunan/", function (Request $request, Response $response){

    $bangunan = $request->getParsedBody();

    $sql = "INSERT INTO tb_bangunan (nama_bangunan, sejarah_bangunan, image_bangunan, id_provinsi, id_daerah) VALUE (:nama_bangunan, :sejarah_bangunan, :image_bangunan, :id_provinsi, :id_daerah)";
    $stmt = $this->db->prepare($sql);

    $data = [
        ":nama_bangunan" => $bangunan["nama_bangunan"],
        ":sejarah_bangunan" => $bangunan["sejarah_bangunan"],
        ":image_bangunan" => $bangunan["image_bangunan"],
        ":id_provinsi" => $bangunan["id_provinsi"],
        ":id_daerah" => $bangunan["id_daerah"]
    ];

    if($stmt->execute($data))
       return $response->withJson(["status" => "success", "data" => "1"], 200);
    
    return $response->withJson(["status" => "failed", "data" => "0"], 200);
});

//mengedit bangunan
$app->put("/bangunan/{id}", function (Request $request, Response $response, $args){
    $id = $args["id"];
    $bangunan = $request->getParsedBody();
    $sql = "UPDATE tb_bangunan SET nama_bangunan=:nama_bangunan, sejarah_bangunan=:sejarah_bangunan, image_bangunan=:image_bangunan, id_provinsi=:id_provinsi, id_daerah=:id_daerah WHERE id_bangunan=:id";
    $stmt = $this->db->prepare($sql);
    
    $data = [
        ":id" => $id,
        ":nama_bangunan" => $bangunan["nama_bangunan"],
        ":sejarah_bangunan" => $bangunan["sejarah_bangunan"],
        ":image_bangunan" => $bangunan["image_bangunan"],
        ":id_provinsi" => $bangunan["id_provinsi"],
        ":id_daerah" => $bangunan["id_daerah"]
    ];

    if($stmt->execute($data))
       return $response->withJson(["status" => "success", "data" => "1"], 200);
    
    return $response->withJson(["status" => "failed", "data" => "0"], 200);
});

//menghapus bangunan
$app->delete("/bangunan/{id}", function (Request $request, Response $response, $args){
    $id = $args["id"];
    $sql = "DELETE FROM tb_bangunan WHERE id_bangunan=:id";
    $stmt = $this->db->prepare($sql);
    
    $data = [
        ":id" => $id
    ];

    if($stmt->execute($data))
       return $response->withJson(["status" => "success", "data" => "1"], 200);
    
    return $response->withJson(["status" => "failed", "data" => "0"], 200);
});

//-------------------- END CRUD BANGUNAN -------------------------