<?php
namespace fletour\Blog\model;

require_once("model/Manager.php");

class CommentManager extends Manager
{
    public function getComments($postId)
    {
        $db = $this->dbConnect();
    
        $comments = $db->prepare('SELECT c.comment_id, c.id_user, c.author, c.id_blog_post, c.contents_comment, c.report, DATE_FORMAT(c.comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr, u.id_user, u.pseudo_user 
        FROM comments c 
        INNER JOIN user u 
        ON c.id_user = u.id_user
        WHERE id_blog_post = ? ORDER BY comment_date DESC');
        $comments->execute(array($postId));
        
        return $comments;
    }


    public function addComment($idUser, $author, $postId, $comment)
    {   
        $db = $this->dbConnect();
        
        $comments = $db->prepare('INSERT INTO comments(id_user, author, id_blog_post, contents_comment, comment_date) VALUES(?, ?, ?, ?, NOW())');
        if ($idUser === "2")
        {
            $affectedLines = $comments->execute(array($idUser, $author, $postId,  $comment));
        }
        else
        {   
            $author="";
            $affectedLines = $comments->execute(array($idUser, $author, $postId,  $comment));
        }
        

        return $affectedLines;
    }

    public function getOneComment($id)
    {
        $db = $this->dbConnect();

        $req = $db->prepare('SELECT id, comment FROM comments WHERE id = ?');
        $req->execute(array($id));
        $oneComment = $req->fetch();
        return $oneComment;
    }

    public function updateCom($id, $comment)
    {                
        $db = $this->dbConnect();

        $req = $db->prepare("UPDATE comments SET comment = ? WHERE comment_id = ?");
        $affectedLines =$req->execute(array($comment, $id));

        return $affectedLines;
    } 

    public function updateReport($comment_id)
    {                
        $db = $this->dbConnect();

        $req = $db->prepare("UPDATE comments SET report = 1 WHERE comment_id = ?");
        $affectedLines =$req->execute(array($comment_id));

        return $affectedLines;
    }
}