<?php
namespace fletour\model\frontend;

class Comment {
    private $commentId;
    private $commentsUserId;
    private $commentAuthor;
    private $commentBlogPostId;
    private $commentContents;
    private $commentReport;
    private $commentDateFr;
    private $startingCommentId;
    private $userId;
    private $userPseudo;
    private $answerId;
    private $answerContents;
    private $countWithoutAnswer;

 
    //setters
    public function setCommentId($id)
    {
        $id = (int) $id;
        if ($id > 0) {$this->commentId = $id;}
    }
    public function setCommentsUserId($id)
    {
        $id = (int) $id;
        if ($id > 0) {$this->commentsUserId = $id;}
    }
    public function setCommentAuthor ($pseudo)
    {
        if (is_string($pseudo)) { $this->commentAuthor = $pseudo;}
    }
    public function setCommentBlogPostId($id)
    {
        $id = (int) $id;
        if ($id > 0) {$this->commentBlogPostId = $id;}
    }
    public function setCommentContents ($text)
    {
        if (is_string($text)) { $this->commentContents = $text;}
    }
    public function setCommentReport  ($report)
    {
        if (is_string($report)) { $this->commentReport = $report;}
    }
    public function setCommentDateFr ($date)
    {
        $this->commentDateFr = $date;
    }
    public function setStartingCommentId ($id)
    {
        $id = (int) $id;
        if ($id > 0) {$this->startingCommentId = $id;}
    }
    public function SetUserId ($id)
    {
        $id = (int) $id;
        if ($id > 0) {$this->userId = $id;}
    }
    public function setUserPseudo ($text)
    {
        if (is_string($text)) { $this->userPseudo = $text;}
    }
    public function setAnswerId ($id)
    {
        $id = (int) $id;
        if ($id > 0) {$this->answerId = $id;}
    }
    public function setAnswerContents ($text)
    {
        if (is_string($text)) { $this->answerContents = $text;}
    }
 
    
    //getters
    public function getCommentId()
    {
        return $this->commentId;
    }
    public function getCommentsUserId()
    {
        return $this->commentsUserId;
    }
    public function getCommentAuthor()
    {
        return $this->commentAuthor;
    }
    public function getCommentBlogPostId()
    {
        return $this->commentBlogPostId;
    }
    public function getCommentContents()
    {
        return $this->commentContents;
    }
    public function getCommentReport()
    {
        return $this->commentReport;
    }

    public function getCommentDateFr()
    {
        return $this->commentDateFr;
    }
    public function getStartingCommentId()
    {
        return $this->startingCommentId;
    }
    public function getUserId(){
        return $this->userId;
    }
    public function getUserPseudo(){
       return $this->userPseudo;
    }
    public function getAnswerId(){
        return $this->answerId;
    }
    public function getAnswerContents(){
       return $this->answerContents;
    } 
    public function getCountWithoutAnswer(){
        return $this->countWithoutAnswer;
     }  
}