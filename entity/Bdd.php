<?php
namespace Entity;
use PDO;
require_once __DIR__.'/../vendor/autoload.php';

class Bdd
{
  private static $pdo;

  public static function getDatabaseConnect(){
    if(self::$pdo != NULL){
      return self::$pdo;
    }

    try {
      self::$pdo = new \PDO(
        'mysql:host=localhost;dbname=youtaites;',
        'root',
        'root',
        [
          PDO::ATTR_ERRMODE             => PDO::ERRMODE_WARNING,
          PDO::MYSQL_ATTR_INIT_COMMAND  => 'SET NAMES utf8',
        ]
      );
      return self::$pdo;
    } catch (Exception $e) {
      die('Erreur : ' . $e->getMessage());
    }
  }

  public static function getUser($log){
    $stmt = self::getDatabaseConnect()->prepare("SELECT * FROM users WHERE pseudo_user = :log");
    $stmt->execute(['log' => $log]);
    $userSQL = $stmt->fetch();
    $user = new User($userSQL['id_user'],$userSQL['pseudo_user'],$userSQL['password_user'],$userSQL['description_user'],$userSQL['picture_user'],$userSQL['mail_user'],$userSQL['website_user']);
    return $user;
  }

  public static function getUserByMail($mail){
    $stmt = self::getDatabaseConnect()->prepare("SELECT * FROM users WHERE mail_user = :mail");
    $stmt->execute(['mail' => $mail]);
    $userSQL = $stmt->fetch();
    $user = new User($userSQL['id_user'],$userSQL['pseudo_user'],$userSQL['password_user'],$userSQL['description_user'],$userSQL['picture_user'],$userSQL['mail_user'],$userSQL['website_user']);
    return $user;
  }
}
