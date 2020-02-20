<?php
namespace fletour\model\frontend;

class CommentManager extends Manager
{
    public function getComments($postId)
    {
        $db = $this->dbConnect();

        $req = $db->prepare('SELECT c.commentId, c.commentsUserId, c.commentAuthor, c.commentBlogPostId, c.commentContents, c.commentReport, 
            DATE_FORMAT(c.commentDate, \'%d/%m/%Y à %Hh%imin%ss\') AS commentDate_fr, c.startingCommentId, u.userId, u.userPseudo, 
            (SELECT commentId FROM comments WHERE startingCommentId = c.commentId) AS answerId,
            (SELECT commentContents FROM comments WHERE startingCommentId = c.commentId) AS answerContents,
            (SELECT COUNT(*) FROM comments WHERE startingCommentId = 0) as countWithoutAnswer 
            FROM comments c 
            INNER JOIN user u 
            ON c.commentsUserId = u.userId
            WHERE commentBlogPostId = ? AND startingCommentId = 0
            ORDER BY commentDate DESC');
        $req->execute(array($postId));
        
        $comments = $req->fetchAll();

        return $comments;
    }

    public function addComment($userId, $commentAuthor, $postId, $comment, $startingCommentId )
    {   
        $db = $this->dbConnect();
               
        $comments = $db->prepare('INSERT INTO comments(commentsUserId, commentAuthor, commentBlogPostId, commentContents, commentDate, startingCommentId) VALUES(?, ?, ?, ?, NOW(), ?)');
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
        $db = $this->dbConnect();

        $req = $db->prepare("UPDATE comments SET commentReport = 'reported' WHERE commentId = ?");
        $affectedLines =$req->execute(array($commentId));

        return $affectedLines;
    }

    public function updateComment($id, $comment)
    {                
        $db = $this->dbConnect();

        $req = $db->prepare("UPDATE comments SET comment = ? WHERE commentId = ?");
        $affectedLines =$req->execute(array($comment, $id));

        return $affectedLines;
    } 
}