<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categories')->delete();
        
        \DB::table('categories')->insert(array (
            0 => 
            array (
                'id' => '1',
                'name_ar' => 'طب الأسرة',
                'name_en' => 'General Medicine',
                'image' => '/assets/categories/4wmVVLywfdRuHM4eMNE2DxsGFjkow8e2QOWz8pfP.svg',
                'deleted_at' => NULL,
                'created_at' => '2021-07-16 13:47:34',
                'updated_at' => '2022-04-25 15:31:17',
            ),
            1 => 
            array (
                'id' => '2',
                'name_ar' => 'جراحة الأطفال',
                'name_en' => 'Pediatric surgery',
                'image' => '/assets/categories/efMLOtXIYDywVN6pGAmOFa3CZScFRAgEOtftAeAZ.svg',
                'deleted_at' => NULL,
                'created_at' => '2021-07-16 13:47:34',
                'updated_at' => '2022-04-25 15:22:49',
            ),
            2 => 
            array (
                'id' => '3',
                'name_ar' => 'الأسنان',
                'name_en' => 'Dentistry',
                'image' => '/assets/categories/hY29vC3q8fghDuZTEhm8BGGoIniYWXRilHozzEK9.svg',
                'deleted_at' => NULL,
                'created_at' => '2021-07-16 13:47:35',
                'updated_at' => '2022-04-25 15:14:32',
            ),
            3 => 
            array (
                'id' => '4',
                'name_ar' => 'القلب',
                'name_en' => 'Cardiology',
                'image' => '/assets/categories/8NS7QLMsw84VGaDAqLTxdUoUg6LuoGfXYXiL6FJx.svg',
                'deleted_at' => NULL,
                'created_at' => '2021-07-16 13:47:35',
                'updated_at' => '2022-04-25 15:15:20',
            ),
            4 => 
            array (
                'id' => '5',
            'name_ar' => 'الأمراض النفسية ( للبالغين)',
                'name_en' => 'Psychiatry',
                'image' => '/assets/categories/c7PVQD1KRNKyf7z01DjQHGStSNwltJGXAOfptvVK.svg',
                'deleted_at' => NULL,
                'created_at' => '2021-07-16 13:47:35',
                'updated_at' => '2022-04-25 15:30:52',
            ),
            5 => 
            array (
                'id' => '6',
                'name_ar' => 'العيون',
                'name_en' => 'Ophthalmology',
                'image' => '/assets/categories/3Op5Gu57PK1XWzfn1gfD6xyhO09dhlKhc3dQvrYH.svg',
                'deleted_at' => NULL,
                'created_at' => '2021-07-16 13:47:35',
                'updated_at' => '2022-04-25 15:21:16',
            ),
            6 => 
            array (
                'id' => '7',
                'name_ar' => 'جلدية',
                'name_en' => 'Dermatology',
                'image' => '/assets/categories/JI9WUcjc61Lm3FhEYTeh7O7yh5mS3oGrhl0lirsP.svg',
                'deleted_at' => NULL,
                'created_at' => '2021-07-16 13:47:35',
                'updated_at' => '2022-04-25 15:32:37',
            ),
            7 => 
            array (
                'id' => '8',
            'name_ar' => 'الأمراض النفسية ( للأطفال )',
                'name_en' => 'Child psychiatry',
                'image' => '/assets/categories/BtizGGUcQZiq4VnsvrFQOG1SBjwEiTLbJZBXwtB7.svg',
                'deleted_at' => NULL,
                'created_at' => '2021-07-16 13:47:35',
                'updated_at' => '2022-04-25 15:33:46',
            ),
            8 => 
            array (
                'id' => '9',
                'name_ar' => 'الباطنة',
                'name_en' => 'Internal medicine',
                'image' => '/assets/categories/7QzzitLAuxaKmAhkERvt9TJ1i0z11qy80o5wZ3dp.svg',
                'deleted_at' => NULL,
                'created_at' => '2021-07-16 13:47:35',
                'updated_at' => '2022-04-25 15:34:32',
            ),
            9 => 
            array (
                'id' => '10',
                'name_ar' => 'تغذية',
                'name_en' => 'nutrition therapy',
                'image' => '/assets/categories/D3rM8KBmJnKipjFr0SfdPAabiaReJVwF9WZU44cP.svg',
                'deleted_at' => NULL,
                'created_at' => '2021-07-16 13:47:35',
                'updated_at' => '2022-04-25 15:35:02',
            ),
            10 => 
            array (
                'id' => '18',
                'name_ar' => 'العظام',
                'name_en' => 'Orthopedics',
                'image' => '/assets/categories/Q0kxd73AD6dCWokWVcvvgvcAaCUvB0hbTtX29aCu.svg',
                'deleted_at' => NULL,
                'created_at' => '2022-04-25 15:16:57',
                'updated_at' => '2022-04-25 15:17:37',
            ),
            11 => 
            array (
                'id' => '19',
                'name_ar' => 'الأعصاب',
                'name_en' => 'Neurology',
                'image' => '/assets/categories/aciuyKJm6lp1zg149IuqFGvf2Foad1xlZEGjHd48.svg',
                'deleted_at' => NULL,
                'created_at' => '2022-04-25 15:18:16',
                'updated_at' => '2022-04-25 15:18:16',
            ),
            12 => 
            array (
                'id' => '20',
                'name_ar' => 'الأنف والأذن',
                'name_en' => 'Otorhinolaryngology',
                'image' => '/assets/categories/5hLuYxJKv2Jt4ZfkWXBBEQebDPajDEYfc5ElXEjM.svg',
                'deleted_at' => NULL,
                'created_at' => '2022-04-25 15:18:57',
                'updated_at' => '2022-04-25 15:18:57',
            ),
            13 => 
            array (
                'id' => '21',
                'name_ar' => 'نساء وتوليد',
                'name_en' => 'Gynaecology',
                'image' => '/assets/categories/yvAIAJ4JbheYt3PrW0ed3QEM2t6MxrL47TgZdHPG.svg',
                'deleted_at' => NULL,
                'created_at' => '2022-04-25 15:21:58',
                'updated_at' => '2022-04-25 15:21:58',
            ),
        ));
        
        
    }
}