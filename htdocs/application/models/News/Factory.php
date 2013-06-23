<?php
/**
 * @class News_Factory
 */
class News_Factory
{
    
    /**
     * Creates new News object
     * 
     * @param User $user Owner of news.
     * @param array $data Array of valid data.
     * @return Address
     */
    public static function create(User $user, array $data)
    {
        $news = new News();
        
        $news->title = $data[FieldIdEnum::NEWS_TITLE];
        $news->description = $data[FieldIdEnum::NEWS_DESCRIPTION];
        $news->User = $user;
        
        return $news;
    }
}
