<?php

class Article
{
  // public $id = null;
  public $publicationDate = null;
  public $title = null;
  public $summary = null;
  public $content = null;

  public function __construct($data=array()) {
    if(isset($data['id'])) $this->id=(int) $data['id'];
    if(isset($data['publicationDate'])) $this->publicationDate=(int) $data['publicationDate'];
    if(isset($data['title'])) $this->title=preg_replace("/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['title']);
    if(isset($data['summary'])) $this->summary=preg_replace("/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['summary']);
    if(isset($data['content'])) $this->content=preg_replace("/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['content']);
  }

  public function storeFormValues($params)
  {
    $this->__construct($params);

    if(isset($params['publicationDate'])) {
      $publicationDate = explode('-', $params['publicationDate']);
      if(count($publicationDate) == 3) {
        list($y,$m,$d) = $publicationDate;
        $this->publicationDate = mktime(0,0,0,$m,$d,$y);
      }
    }
  }

  /**
  * @param int ID статьи
  * @return Article|false Объект статьи или false, если запись не найдена или возникли проблемы
  */

  public static function getById($id) {
    $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $sql = "select *, UNIX_TIMESTAMP(publicationDate) AS publicationDate from articles where id = :id";
    $st = $conn->prepare($sql);
    $st->bindValue(":id", $id, PDO::PARAM_INT);
    $st->execute();
    $row = $st->fetch();
    $conn = null;
    if($row) return new Article($row);
  }

  /**
	* @param int Optional Количество строк (по умолчанию все)
	* @param string Optional Столбец по которому производится сортировка  статей (по умолчанию "publicationDate DESC")
	* @return Array|false Двух элементный массив: results => массив, список объектов статей; totalRows => общее количество статей
  */

  public static function getList($numRows=1000000, $order='publicationDate DESC') {
    $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $sql = "select sql_calc_found_rows *, unix_timestamp(publicationDate) as publicationDate from articles limit :numRows";
    $st = $conn->prepare($sql);
    $st->bindValue(":numRows", $numRows, PDO::PARAM_INT);
    $st->execute();

    $list = array();
    while($row = $st->fetch()) {
      $article = new Article($row);
      $list[] = $article;
    }

    $sql = "SELECT FOUND_ROWS() AS totalRows";
    $totalRows = $conn->query($sql)->fetch();
    $conn = null;
    return(array("results"=>$list, "totalRows"=>$totalRows[0]));
  }

  public function insert() {
    //проверяем, есть ли ID у объекта статьи
    // if(is_null($this->id)) {
    //   trigger_error("Article::insert(): Attempt to insert an object that already has its ID set to $this->id) ",E_USER_ERROR);
    // }

    //вставляем статью
    $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $sql = "INSERT INTO articles (title, summary, content, publicationDate) VALUES (:title, :summary, :content, FROM_UNIXTIME(:publicationDate))";
    $st = $conn->prepare($sql);

    $st->bindValue(":title", $this->title, PDO::PARAM_STR);
    $st->bindValue(":summary", $this->summary, PDO::PARAM_STR);
    $st->bindValue(":content", $this->content, PDO::PARAM_STR);
    $st->bindValue(":punlicationDate", $this->publicationDate, PDO::PARAM_INT);
    $st->execute();
    $this->id = $conn->lastInsertId();
    $conn = null;
  }

  public function update() {
    // if(is_null($this->id)) {
    //   trigger_error("Article::update(): Попытка редактирования объекта без ID . ", E_USER_ERROR);
    // }
    $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    // $sql = "UPDATE articles SET id=NULL, title=:title, summary=:summary, content=:content, publicationDate=FROM_UNIXTIME(:publicationDate)";
    $sql = "UPDATE articles SET title=:title, summary=:summary, content=:content";
    $st = $conn->prepare($sql);
    
    // $st->bindValue(":punlicationDate", $this->publicationDate, PDO::PARAM_INT);
    $st->bindValue(":title", $this->title, PDO::PARAM_STR);
    $st->bindValue(":summary", $this->summary, PDO::PARAM_STR);
    $st->bindValue(":content", $this->content, PDO::PARAM_STR);
    $st->execute();
    $conn = null;
  }

  public function delete() {
    if(is_null($this->id)) {
      trigger_error("Article::delete(): Попытка удаления объекта без ID .", E_USER_ERROR);
    }
    $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $sql = "DELETE * FROM articles WHERE id=:id LIMIT 1";
    $st = $conn->prepare($sql);
    $st->bindValue(":id", $this->id, PDO::PARAM_INT);
    $st->execute();
    $conn = null;
  }
}
?>