<?php
namespace fletour\model\frontend;

class BlogPost {
    private $blogPostId;
    private $blogPostTitle;
    private $blogPostContents;
    private $creationDateFr;
    private $blogPostStatus;

 /*  public function __construct(array $data)
    {  
        $this->hydrate($data);        

    }

    public function hydrate(array $data)
    {        
        foreach ($data as $key => $value)
        {
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method))
            {
                $this->$method($value);
            }
        }
    }*/
    //setters
    public function setBlogPostId($id)
    {
        $id = (int) $id;
        if ($id > 0) {$this->blogPostId = $id;}
    }
    public function setBlogPostTitle($title)
    {
        if (is_string($title)) { $this->blogPostTitle = $title;}
    }
    public function setBlogPostContents($contents)
    {
        if (is_string($contents)) { $this->blogPostContents = $contents;}
    }
    public function setCreationDateFr($date)
    {
        $this->creationDateFr = $date;
    }
    public function setBlogPostStatus($status)
    {
        $this->blogPostStatus = $status;
    }

    //getters
    public function getBlogPostId()
    {
        return $this->blogPostId;
    }
    public function getBlogPostTitle()
    {
        return $this->blogPostTitle;
    }
    public function getBlogPostContents()
    {
        return $this->blogPostContents;
    }
    public function getCreationDateFr()
    {
        return $this->creationDateFr;
    }
    public function getBlogPostStatus()
    {
        return $this->blogPostStatus;
    }
    
}