<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        

        User::Create([
            'name' => 'Cipto Wirawan',
            'username' => 'ciptowirawan',
            'email' => 'ciptowirawan.CW@gmail.com',
            'password' => bcrypt('password')
        ]);

        User::Create([
            'name' => 'Elvina',
            'username' => 'elvina',
            'email' => 'Elvina@gmail.com',
            'password' => bcrypt('12345')
        ]);

        User::factory(3)->create();

        Category::Create([
            'name' => 'Web Programming',
            'slug' => 'web-programming'
        ]);

        Category::Create([
            'name' => 'Web Design',
            'slug' => 'web-design'
        ]);

        Category::Create([
            'name' => 'Personal',
            'slug' => 'personal'
        ]);

        Post::factory(20)->create();

//         Post::Create([
//             'title' => 'Judul Pertama',
//             'slug' => 'judul-pertama',
//             'excerpt' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit.',
//             'body' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quis fugiat aut officiis, ducimus iusto odit distinctio iste non beatae delectus quos dicta error provident, eos officia autem est unde hic nisi ipsum voluptatibus saepe. Quos, quisquam perferendis ducimus vel voluptatum atque reiciendis, iusto laboriosam porro qui consequuntur delectus nam quia. Eum rerum soluta eaque, ut non ullam eligendi assumenda, ipsum odit natus vitae, et porro quam autem aliquam harum eos temporibus aspernatur provident esse itaque. Eaque doloribus incidunt, nisi, in deserunt ratione quasi aliquid hic beatae facere rem optio deleniti ipsum, accusantium dolore non? Impedit eos nesciunt optio quis delectus!',
//             'category_id' => 1,
//             'user_id' => 1       
//      ]);

//         Post::Create([
//             'title' => 'Judul Ke Dua',
//             'slug' => 'judul-ke-dua',
//             'excerpt' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit.',
//             'body' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quis fugiat aut officiis, ducimus iusto odit distinctio iste non beatae delectus quos dicta error provident, eos officia autem est unde hic nisi ipsum voluptatibus saepe. Quos, quisquam perferendis ducimus vel voluptatum atque reiciendis, iusto laboriosam porro qui consequuntur delectus nam quia. Eum rerum soluta eaque, ut non ullam eligendi assumenda, ipsum odit natus vitae, et porro quam autem aliquam harum eos temporibus aspernatur provident esse itaque. Eaque doloribus incidunt, nisi, in deserunt ratione quasi aliquid hic beatae facere rem optio deleniti ipsum, accusantium dolore non? Impedit eos nesciunt optio quis delectus!',
//             'category_id' => 1,
//             'user_id' => 1       
//  ]);

    // Post::Create([
    //     'title' => 'Judul Ke Tiga',
    //     'slug' => 'judul-ke-tiga',
    //     'excerpt' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit.',
    //     'body' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quis fugiat aut officiis, ducimus iusto odit distinctio iste non beatae delectus quos dicta error provident, eos officia autem est unde hic nisi ipsum voluptatibus saepe. Quos, quisquam perferendis ducimus vel voluptatum atque reiciendis, iusto laboriosam porro qui consequuntur delectus nam quia. Eum rerum soluta eaque, ut non ullam eligendi assumenda, ipsum odit natus vitae, et porro quam autem aliquam harum eos temporibus aspernatur provident esse itaque. Eaque doloribus incidunt, nisi, in deserunt ratione quasi aliquid hic beatae facere rem optio deleniti ipsum, accusantium dolore non? Impedit eos nesciunt optio quis delectus!',
    //     'category_id' => 2,
    //     'user_id' => 1       
    // ]);

    // Post::Create([
    //     'title' => 'Judul Ke Empat',
    //     'slug' => 'judul-ke-empat',
    //     'excerpt' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit.',
    //     'body' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quis fugiat aut officiis, ducimus iusto odit distinctio iste non beatae delectus quos dicta error provident, eos officia autem est unde hic nisi ipsum voluptatibus saepe. Quos, quisquam perferendis ducimus vel voluptatum atque reiciendis, iusto laboriosam porro qui consequuntur delectus nam quia. Eum rerum soluta eaque, ut non ullam eligendi assumenda, ipsum odit natus vitae, et porro quam autem aliquam harum eos temporibus aspernatur provident esse itaque. Eaque doloribus incidunt, nisi, in deserunt ratione quasi aliquid hic beatae facere rem optio deleniti ipsum, accusantium dolore non? Impedit eos nesciunt optio quis delectus!',
    //     'category_id' => 2,
    //     'user_id' => 2       
    // ]);

    }
}
