<?php
namespace fletour\model;

class PostManagerAdmin extends Manager
{
    public function saveNewPost($blogPostTitle, $textPost)
    {
        $db = $this->dbConnect();
        $post = $db->prepare('INSERT INTO blog_post(blogPostTitle, blogPostContents, blogPostUpdateDate) VALUES(?,?, NOW())');
        $affectedLines = $post->execute(array($blogPostTitle,$textPost));
        return $affectedLines;
    }


    

}