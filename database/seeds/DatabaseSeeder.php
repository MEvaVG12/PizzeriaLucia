<?php

use Illuminate\Database\Seeder;
use App\Type;
use App\Ingredient;
use App\Product;
use App\ProductType;
use App\Promotion;
use App\PromotionDetail;
use App\Stock;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        self::seedProducts();
    }

    public function seedProducts(){
        $t1 = new Type();
        $t1->name ='Básicos';
        $t1->save();

        $i1 = new Ingredient();
        $i1->name = 'Prepizza';
        $i1->type()->associate($t1);
        $i1->save();

        $i2 = new Ingredient();
        $i2->name = 'Muzarella';
        $i2->type()->associate($t1);
        $i2->save();

        $pt1 = new ProductType();
        $pt1->name ='Pizza';
        $pt1->save();

        $pt2 = new ProductType();
        $pt2->name ='Empanada';
        $pt2->save();

        $i3 = new Ingredient();
        $i3->name = 'Oregano';
        $i3->type()->associate($t1);
        $i3->save();

        $i4 = new Ingredient();
        $i4->name = 'Aceitunas';
        $i4->type()->associate($t1);
        $i4->save();

        $i5 = new Ingredient();
        $i5->name = 'Salsa';
        $i5->type()->associate($t1);
        $i5->save();

        $p6 = new Product();
        $p6->name = 'Muzarella';
        $p6->price =  100.00;
        $p6->productType()->associate($pt1);
        $p6->save();


        $p6->ingredients()->attach($i1);
        $i1->products()->attach($p6);
        $p6->save();
        $i1->save();

        $p7 = new Product();
        $p7->name = 'Dulces';
        $p7->price =  180.00;
        $p7->productType()->associate($pt2);
        $p7->save();

        $pr1 = new Promotion();
        $pr1->name = 'Promo 1';
        $pr1->price = 200;
        $pr1->save();

        $d1 = new PromotionDetail();
        $d1->amount=2;
        $d1->product()->associate($p7);
        $d1->promotion()->associate($pr1);
        $d1->save();

        $s = new Stock();
        $s->amount=30;
        $s->ingredient()->associate($i1);
        $s->save();
    }
}
