<?php

use Illuminate\Database\Seeder;
use App\Type;
use App\Ingredient;
use App\Product;
use App\Promotion;

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
        $this->command->info('Tabla catálogo inicializada con datos!');
    }

    public function seedProducts(){
        $t1 = new Type();
        $t1->name ='Básicos';
        $t1->save();

        $i1 = new Ingredient();
        $i1->name = 'Prepizza';
        //$i1->type()->attach($t1->id);
        $i1->type()->save($t1);
        $i1->save();

        $i2 = new Ingredient();
        $i2->name = 'Muzarella';
        //$i2->type()->attach($t1->id);
        $i2->type()->save($t1);
        $i2->save();

        $i3 = new Ingredient();
        $i3->name = 'Oregano';
        //$i3->type()->attach($t1->id);
        $i1->type()->save($t1);
        $i3->save();

        $i4 = new Ingredient();
        $i4->name = 'Aceitunas';
        //$i4->type()->attach($t1->id);
        $i1->type()->save($t1);
        $i4->save();

        $i5 = new Ingredient();
        $i5->name = 'Salsa';
        //$i5->type()->attach($t1->id);
        $i1->type()->save($t1);
        $i5->save();

        $p6 = new Product();
        $p6->name = 'Muzarella';
        $p6->price =  100.00;
        $p6->save();

        $p7 = new Product();
        $p7->name = 'Dulces';
        $p7->price =  180.00;
        $p7->save();

        $pr1 = new Promotion();
        $pr1->name = 'Promo 1';
        $pr1->products()->attach($p6->id);
        $pr1->products()->attach($p7->id);
        $pr1->price = 200;
        $pr1->save();

    }
}
