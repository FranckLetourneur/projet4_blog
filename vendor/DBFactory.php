<?php
namespace fletour\vendor;

class DBFactory
{
    public static function getMysqlConnexionWithPDO()
    {
        try
        {
            //$db = new \PDO('mysql:host=localhost;dbname=francghk_blog_jforteroche;charset=utf8', 'francghk_Jean_Forteroche', 'hGxLL7SmEHPJFw9');
            $db = new \PDO('mysql:host=localhost;dbname=blog_jforteroche;charset=utf8', 'root', 'root');
            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $db;
        }
        catch(Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        }
    }

}