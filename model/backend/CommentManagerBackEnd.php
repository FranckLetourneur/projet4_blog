<?php
namespace fletour\model\backend;

class CommentManagerBackEnd extends \fletour\model\frontend\Manager
{
    public function getComments()
    {
        $db = $this->dbConnect();
        
        $req = $db->query('SELECT c.commentId, c.commentsUserId, c.commentAuthor, c.commentBlogPostId, c.commentContents, c.commentReport, 
            DATE_FORMAT(c.commentDate, \'%d/%m/%Y à %Hh%imin%ss\') AS commentDate_fr, c.startingCommentId, u.userId, u.userPseudo, 
            (SELECT commentId FROM comments WHERE startingCommentId = c.commentId) AS answerId,
            (SELECT commentContents FROM comments WHERE startingCommentId = c.commentId) AS answerContents
            FROM comments c 
            INNER JOIN user u 
            ON c.commentsUserId = u.userId
            ORDER BY commentBlogPostId, commentReport, commentDate DESC ');

        $comments = $req->fetchAll();
        return $comments;
    }

    public function updatecommentReport($id)
    {                
        $db = $this->dbConnect();

        $req = $db->prepare("UPDATE comments SET commentReport = 'valid' WHERE commentId = ?");
        $affectedLines =$req->execute(array($id));

        return $affectedLines;
    }

    public function getOneComment($id)
    {
        $db = $this->dbConnect();

        $req = $db->prepare('SELECT *,
            (SELECT commentId FROM comments WHERE startingCommentId = c.commentId) AS answerId,
            (SELECT commentContents FROM comments WHERE startingCommentId = c.commentId) AS answerContents
            FROM comments c
            WHERE commentId = ?');
        $req->execute(array($id));
        $oneComment = $req->fetch();
        return $oneComment;
    }

    public function commentUpdateBdd($id, $content)
    {
        $db = $this->dbConnect();

        $req = $db->prepare("UPDATE comments SET commentContents = ? WHERE commentId = ?");
        $affectedLines =$req->execute(array($content, $id));

        return $affectedLines;
    }

    public function commentDelete($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM comments WHERE commentId = ?');
        $affectedLines = $req->execute(array($id));
        return $affectedLines;
  
    }

}
