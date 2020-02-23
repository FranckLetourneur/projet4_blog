<?php
namespace fletour\model\backend;

class PostManagerBackEnd {
       
    protected $db;

    public function __construct(\PDO $db) {
        $this->db = $db;
    }

    public function saveNewPost($blogPostId, $blogPostTitle, $textPost)
    {
        if ($_POST['blogPostId'] != 0)
        {

            $post = $this->db->prepare('UPDATE blog_post SET blogPostTitle = ?, blogPostContents = ? WHERE blogPostId = ?');
            $affectedLines = $post->execute(array($blogPostTitle, $textPost, $blogPostId));
        }
        else
        {   
            $post = $this->db->prepare('INSERT INTO blog_post(blogPostTitle, blogPostContents, blogPostUpdateDate) VALUES(?,?, NOW())');
            $affectedLines = $post->execute(array($blogPostTitle,$textPost));
        }
        
        return $affectedLines;
    }

    public function lastPost() {
        $req = $this->db->query('SELECT blogPostId FROM blog_post ORDER BY blogPostId DESC LIMIT 1');

        $theLastPost = $req->fetch();
       
        return $theLastPost;
    }

    public function deletePost($id) {
        $req = $this->db->prepare('UPDATE blog_post SET blogPostStatus = ? WHERE blogPostId = ?');
        $affectedLines = $req->execute(array('inTrash',$id));
        return $affectedLines;
    }

    public function unDeletePost($id) {
        $post = $this->db->prepare('UPDATE blog_post SET blogPostStatus = ? WHERE blogPostId = ?');
        $affectedLines = $post->execute(array('inProgress',$id));

        return $affectedLines;
    }

    public function modifyPostStatus($id) {
        $req = $this->db->query("SELECT blogPostStatus FROM blog_post WHERE blogPostId = $id");
        $status = $req->fetch();

        if ($status['blogPostStatus'] === 'inProgress')
        {
            $post = $this->db->query("UPDATE blog_post SET blogPostStatus = 'inRead' WHERE blogPostId = $id");
        }
        elseif ($status['blogPostStatus'] === 'inRead')
        {
            $post = $this->db->query("UPDATE blog_post SET blogPostStatus = 'inProgress' WHERE blogPostId = $id");
        }
    
        $affectedLines = $post->execute(array('inRead',$id));

        return $affectedLines;
    }

    public function updateBlogPostId($id, $newId) {
        $post = $this->db->prepare('UPDATE blog_post SET blogPostId = ? WHERE blogPostId = ?');
        $affectedLines = $post->execute(array($newId,$id));

        return $affectedLines;
    }

    public function updateIncrementingBlogPost() {
        $req = $this->db->query('SELECT blogPostId FROM blog_post ORDER BY blogPostId DESC LIMIT 1');
        $theLastPost = $req->fetch();
        $newIncrement = $theLastPost['blogPostId'] + 1;
       
        $post = $this->db->query('ALTER TABLE blog_post AUTO_INCREMENT='.$newIncrement.'');
    }

    public function erasePost($id) {
        $req = $this->db->prepare('DELETE FROM blog_post WHERE blogPostId = ?');
        $affectedLines = $req->execute(array($id));
        return $affectedLines;
    }
}