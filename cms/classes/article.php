<?php
class Article
{
  public $id = null;
  public $publicationDate = null;
  public $title = null;
  public $summary = null;
  public $content = null;

  public function __construct($data=array()) {
    if(isset($data['id'])) $this->id=(int) $data['id'];
    if(isset($data['publicationDate'])) $this->publicationDate=(int) $data['publicationDate'];
    if(isset($data['title'])) $this->title=preg_replace("/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['title']);
    if(isset($data['summary'])) $this->summary=preg_replace("/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['summary']);
  }

  /**
  * Устанавливаем свойств с помощью значений формы редактирования записи в заданном массиве
  * @param assoc Значения записи формы
  */
  public function storeFormValues($params)
  {
    //save all parameters from class constructor
    $this->__construct($params);

    //decompose and save publication date
    if(isset($params['publicationDate'])) {
      $publicationDate = explode('-', $params['publicationDate']);
      if(count($publicationDate) == 3) {
        list($y,$m,$d) = $publicationDate;
        $this->publicationDate = mktime(0,0,0,$m,$d,$y);
      }
    }
  }

  /**
  * Возвращаем объект статьи, соответствующий заданному ID статьи
  *
  * @param int ID статьи
  * @return Article|false Объект статьи или false, если запись не найдена или возникли проблемы
  */
  public static function getById($id) {
    $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $sql = "select *, UNIX_TIMESTAMP(publicationDate) AS publicationDAte from articles where id = :id";
    $st = $conn->prepare($sql);
    $st->bindValue(":id", $id, PDO::PARAM_INT);
    $st->execute();
    $row = $st->fetch();
    $conn = null;
    if($row) return new Article($row);
  }
}
?>