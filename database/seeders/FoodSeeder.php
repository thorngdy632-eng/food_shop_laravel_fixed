<?php

namespace Database\Seeders;

use App\Models\Food;
use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
    public function run(): void
    {
        $foods = [
            ['name' => 'Chocolate Cake',       'category' => 'dessert', 'image' => 'assets/Dessert/Chocolate.jpg',     'price' => 6.99,  'description' => 'នំសូកូឡា មានរសជាតិផ្អែមឆ្ងាញ់',                         'rating' => 4.8, 'reviews' => 120, 'badge' => 'ថ្មី'],
            ['name' => 'អាម៉ុក ត្រី',            'category' => 'khmer',   'image' => 'assets/Khmer_food/Amok.jpg',      'price' => 9.99,  'description' => 'ម្ហូបជាតិដ៏ល្បី — ត្រីស្ងោរក្នុងខ្ទិ៍ គ្រឿង ស្លឹកក្រូចសើច និងម្ទេស។', 'rating' => 4.9, 'reviews' => 480, 'badge' => 'ម្ហូបជាតិ'],
            ['name' => 'បាយសាច់ជ្រូក',          'category' => 'khmer',   'image' => 'assets/Khmer_food/Bay.jpg',       'price' => 7.50,  'description' => 'បាយសក្តៅៗ ជាមួយសាច់ជ្រូកអាំងទន់ៗ និងជ្រក់ត្រសក់',             'rating' => 4.8, 'reviews' => 390, 'badge' => 'ពេញនិយម'],
            ['name' => 'ភីហ្សា ម៉ាហ្គារីតា',      'category' => 'pizza',   'image' => 'assets/Pizza/Margherita.jpg',     'price' => 12.99, 'description' => 'ទឹកប៉េងប៉ោះ San Marzano ឈីស mozzarella ស្រស់ និងស្លឹក basil។', 'rating' => 4.8, 'reviews' => 320, 'badge' => 'ពេញនិយម'],
            ['name' => 'បឺហ្គឺ Smash ពីរជាន់',   'category' => 'burger',  'image' => 'assets/Burger/Cheeseburger.jpg',   'price' => 13.99, 'description' => 'សាច់គោ smash ពីរជាន់ ឈីស American ត្រសក់ និងទឹកជ្រលក់ពិសេស។', 'rating' => 4.9, 'reviews' => 512, 'badge' => 'លក់ដាច់'],
            ['name' => 'រ៉ាម៉ែន Tonkotsu',       'category' => 'noodles', 'image' => 'assets/Boiled_noodle/Glassnoodles.jpg', 'price' => 14.50, 'description' => 'ស៊ុបឆ្អឹងជ្រូកដ៏ឈ្ងុយឆ្ងាញ់ សាច់ជ្រូកបំពង និងស៊ុតជ័រពងទា។',  'rating' => 4.9, 'reviews' => 430, 'badge' => 'គេចូលចិត្ត'],
            ['name' => 'រ៉ូល Salmon Dragon',      'category' => 'sushi',   'image' => 'assets/Sushi/Salmonnigiri.jpg',    'price' => 18.99, 'description' => 'បង្គា tempura ខាងក្នុង ស្រោបដោយសាច់ត្រី salmon ស្រស់ និង avocado។', 'rating' => 4.9, 'reviews' => 295, 'badge' => 'ថ្មី'],
            ['name' => 'កាហ្វេត្រជាក់',           'category' => 'drinks',  'image' => 'assets/Drink/Icedcoffee.jpg',     'price' => 4.99,  'description' => 'គ្រាប់កាហ្វេលីងថ្មីៗ រសជាតិដិតឈ្ងុយ រលោង ជួយឱ្យស្បែកកាយស្រស់ស្រាយ។', 'rating' => 4.9, 'reviews' => 520, 'badge' => 'លក់ដាច់'],
        ];

        foreach ($foods as $food) {
            Food::create($food);
        }
    }
}
