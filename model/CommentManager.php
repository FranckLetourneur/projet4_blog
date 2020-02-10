<?php
namespace fletour\model;

class CommentManager extends Manager
{
    public function getComments($postId)
    {
        $db = $this->dbConnect();
    
        $comments = $db->prepare('SELECT c.commentId, c.commentsUserId, c.commentAuthor, c.commentBlogPostId, c.commentContents, c.commentReport, DATE_FORMAT(c.commentDate, \'%d/%m/%Y à %Hh%imin%ss\') AS commentDate_fr, u.userId, u.userPseudo 
        FROM comments c 
        INNER JOIN user u 
        ON c.commentsUserId = u.userId
        WHERE commentBlogPostId = ? ORDER BY commentDate DESC');
        $comments->execute(array($postId));
        
        return $comments;
    }


    public function addComment($userId, $commentAuthor, $postId, $comment)
    {   
        $db = $this->dbConnect();
               
        $comments = $db->prepare('INSERT INTO comments(commentsUserId, commentAuthor, commentBlogPostId, commentContents, commentDate) VALUES(?, ?, ?, ?, NOW())');
        if ($userId === "2")
        {
            $affectedLines = $comments->execute(array($userId, $commentAuthor, $postId,  $comment));
        }
        else
        {   
            $commentAuthor="";
            $affectedLines = $comments->execute(array($userId, $commentAuthor, $postId,  $comment));
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

        $req = $db->prepare("UPDATE comments SET comment = ? WHERE commentId = ?");
        $affectedLines =$req->execute(array($comment, $id));

        return $affectedLines;
    } 

    public function updatecommentReport($commentId)
    {                
        $db = $this->dbConnect();

        $req = $db->prepare("UPDATE comments SET commentReport = 1 WHERE commentId = ?");
        $affectedLines =$req->execute(array($commentId));

        return $affectedLines;
    }
}