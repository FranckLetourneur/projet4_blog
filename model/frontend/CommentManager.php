<?php
namespace fletour\model\frontend;

class CommentManager {
    
    protected $db;

    public function __construct(\PDO $db) {
        $this->db = $db;
    }

    public function getComments($postId)
    {
        $req = $this->db->prepare('SELECT c.commentId, c.commentsUserId, c.commentAuthor, c.commentBlogPostId, c.commentContents, c.commentReport, 
            DATE_FORMAT(c.commentDate, \'%d/%m/%Y à %Hh%imin%ss\') AS commentDateFr, c.startingCommentId, u.userId, u.userPseudo, 
            (SELECT commentId FROM comments WHERE startingCommentId = c.commentId) AS answerId,
            (SELECT commentContents FROM comments WHERE startingCommentId = c.commentId) AS answerContents,
            (SELECT COUNT(*) FROM comments WHERE startingCommentId = 0) as countWithoutAnswer 
            FROM comments c 
            INNER JOIN user u 
            ON c.commentsUserId = u.userId
            WHERE commentBlogPostId = ? AND startingCommentId = 0
            ORDER BY commentDate DESC');

        $req->bindParam(1, $postId, \PDO::PARAM_INT);
        $req->execute(array($postId));

        $req->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, Comment::class);

        $comments = $req->fetchAll();

        return $comments;
    }

    public function addComment($userId, $commentAuthor, $postId, $comment, $startingCommentId )
    {   
               
        $comments = $this->db->prepare('INSERT INTO comments(commentsUserId, commentAuthor, commentBlogPostId, commentContents, commentDate, startingCommentId) VALUES(?, ?, ?, ?, NOW(), ?)');
        if ($userId === "2")                                                            
        {
            $affectedLines = $comments->execute(array($userId, $commentAuthor, $postId,  $comment, $startingCommentId ));
        }
        else
        {   
            $commentAuthor="";
            $affectedLines = $comments->execute(array($userId, $commentAuthor, $postId,  $comment, $startingCommentId ));
        }

        return $affectedLines;
    }

    public function updateCommentReport($commentId)
    {                
        $req = $this->db->prepare("UPDATE comments SET commentReport = 'reported' WHERE commentId = ?");
        $affectedLines =$req->execute(array($commentId));

        return $affectedLines;
    }
    
}