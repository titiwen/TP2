<?php
namespace App\Model;

use App\Helpers\Text;
use DateTime;

class Post{
    private $id;
    private $name;
    private $slug;
    private $content;
    private $created_at;
    private $categories = [];

    public function getID(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return htmlentities($this->name);
    }

    public function getExcerpt(): ?string
    {
        if($this->content === null){
            return null;
        }
        return nl2br(htmlentities(Text::excerpt($this->content, POST_LIMIT) . '...'));
    }

    public function getCreatedAt(): DateTime
    {
        return new DateTime($this->created_at);
    }

    public function getSlug(): ?string
    {
        return htmlentities($this->slug);
    }

    public function getFormattedContent(): ?string
    {
        return nl2br(htmlentities($this->content));
    }

}