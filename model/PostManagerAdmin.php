<?php
namespace fletour\model;

class PostManagerAdmin extends Manager
{
    public function saveNewPost($blogPostId, $blogPostTitle, $textPost)
    {
        $db = $this->dbConnect();
        if ($_POST['blogPostId'] != 0)
        {

            $post = $db->prepare('UPDATE blog_post SET blogPostTitle = ?, blogPostContents = ? WHERE blogPostId = ?');
            $affectedLines = $post->execute(array($blogPostTitle, $textPost, $blogPostId));
        }
        else
        {   
            $post = $db->prepare('INSERT INTO blog_post(blogPostTitle, blogPostContents, blogPostUpdateDate) VALUES(?,?, NOW())');
            $affectedLines = $post->execute(array($blogPostTitle,$textPost));
        }
        
        return $affectedLines;
    }

    public function deletePost($id) {
        $db = $this->dbConnect();

        $post = $db->prepare('UPDATE blog_post SET blogPostStatus = ? WHERE blogPostId = ?');
        $affectedLines = $post->execute(array('inTrash',$id));

        return $affectedLines;
    }

    public function unDeletePost($id) {
        $db = $this->dbConnect();

        $post = $db->prepare('UPDATE blog_post SET blogPostStatus = ? WHERE blogPostId = ?');
        $affectedLines = $post->execute(array('inProgress',$id));

        return $affectedLines;
    }
    
    public function modifyPostStatus($id) {
        $db = $this->dbConnect();

        $post = $db->prepare('UPDATE blog_post SET blogPostStatus = ? WHERE blogPostId = ?');
        $affectedLines = $post->execute(array('inRead',$id));

        return $affectedLines;
    }


    public function lastPost() {
        $db = $this->dbConnect();
        $req = $db->query('SELECT blogPostId FROM blog_post ORDER BY blogPostId DESC LIMIT 1');
        $theLastPost = $req->fetch();
        
        return $theLastPost;
    }

    public function updateBlogPostId($id, $newId) {
        $db = $this->dbConnect();

        $post = $db->prepare('UPDATE blog_post SET blogPostId = ? WHERE blogPostId = ?');
        $affectedLines = $post->execute(array($newId,$id));

        return $affectedLines;
    }

    public function updateIncrementingBlogPost() {
        $db = $this->dbConnect();
        $req = $db->query('SELECT blogPostId FROM blog_post ORDER BY blogPostId DESC LIMIT 1');
        $theLastPost = $req->fetch();
        $newIncrement = $theLastPost['blogPostId'] + 1;
       
        $post = $db->query('ALTER TABLE blog_post AUTO_INCREMENT='.$newIncrement.'');
    }

    public function erasePost($id) {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM blog_post WHERE blogPostId = ?');
        $affectedLines = $req->execute(array($id));
        return $affectedLines;
    }
}