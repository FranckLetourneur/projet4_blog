<?php
namespace fletour\model\backend;

class CommentManagerBackEnd {
       
    protected $db;

    public function __construct(\PDO $db) {
        $this->db = $db;
    }

    public function getComments()
    {
        $req = $this->db->query('SELECT c.commentId, c.commentsUserId, c.commentAuthor, c.commentBlogPostId, c.commentContents, c.commentReport, 
            DATE_FORMAT(c.commentDate, \'%d/%m/%Y à %Hh%imin\') AS commentDateFr, c.startingCommentId, u.userId, u.userPseudo, 
            (SELECT commentId FROM comments WHERE startingCommentId = c.commentId) AS answerId,
            (SELECT commentContents FROM comments WHERE startingCommentId = c.commentId) AS answerContents
            FROM comments c 
            INNER JOIN user u 
            ON c.commentsUserId = u.userId
            ORDER BY commentBlogPostId, commentReport, commentDate DESC ');

        $req->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, \fletour\model\frontend\Comment::class);

        $comments = $req->fetchAll();
        return $comments;
    }

    public function updatecommentReport($id)
    {                
        $req = $this->db->prepare("UPDATE comments SET commentReport = 'valid' WHERE commentId = ?");
        $affectedLines =$req->execute(array($id));

        return $affectedLines;
    }

    public function getOneComment($id)
    {
        $req = $this->db->prepare('SELECT *,
            (SELECT commentId FROM comments WHERE startingCommentId = c.commentId) AS answerId,
            (SELECT commentContents FROM comments WHERE startingCommentId = c.commentId) AS answerContents
            FROM comments c
            WHERE commentId = ?');
        $req->bindParam(1, $id, \PDO::PARAM_INT);
        $req->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, \fletour\model\frontend\Comment::class);
    
        $req->execute();
        $oneComment = $req->fetch();
        return $oneComment;
    }

    public function commentUpdateBdd($id, $content)
    {
        $req = $this->db->prepare("UPDATE comments SET commentContents = ? WHERE commentId = ?");
        $affectedLines =$req->execute(array($content, $id));

        return $affectedLines;
    }

    public function commentDelete($id)
    {
        $req = $this->db->prepare('DELETE FROM comments WHERE commentId = ?');
        $affectedLines = $req->execute(array($id));
        return $affectedLines;
  
    }

}