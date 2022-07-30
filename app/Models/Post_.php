<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post 
{
    // use HasFactory;
    private static $blog_posts = [
        [
            "title" => "Judul Post Pertama",
            "slug" => "judul-post-pertama",
            "author" => "Cipto Wirawan",
            "body" => "Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quasi voluptatem reiciendis tenetur ullam, ut amet fugit, fugiat eum beatae repudiandae laborum porro, praesentium iusto excepturi ad temporibus? Cum, dicta explicabo blanditiis libero consequatur debitis odio eligendi facilis enim, dolore necessitatibus, aperiam aliquid. Dolores, corporis voluptatibus voluptatum assumenda eius hic exercitationem est atque praesentium error maxime rem ipsa perspiciatis voluptatem in ipsam ad dignissimos obcaecati doloribus ipsum architecto delectus sit voluptate. Culpa aliquid magnam neque incidunt, dignissimos amet cum expedita deserunt?"
        ],
        [
            "title" => "Judul Post Wirawan",
            "slug" => "judul-post-kedua",
            "author" => "Pala Bapa",
            "body" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vitae ipsum harum quae explicabo obcaecati, exercitationem cum ipsa, quidem rem magni eum tenetur pariatur incidunt corrupti? Minus assumenda hic quis iste quibusdam, in vitae ipsam, aliquid ex quia excepturi, laborum nihil cupiditate. Eveniet molestias odit adipisci porro perspiciatis illum, mollitia dolores necessitatibus fugiat repellat dolor laborum ab, aspernatur voluptate veniam aut sint commodi et quos perferendis nostrum veritatis tempore consequatur? Necessitatibus ex vel ratione autem enim praesentium quas ab temporibus. Commodi recusandae, at error harum a adipisci magni non exercitationem, tempora officia temporibus, facere quod nisi eos explicabo sequi ut eligendi?"
        ]
    ];  
    
    public static function all () 
    {
        return collect(self::$blog_posts);
    }

    public static function find($slug)
    {
        $posts = static::all();
        return $posts->firstWhere('slug', $slug);
    }
}