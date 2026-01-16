<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        \DB::table('settings')->truncate();

        \DB::table('settings')->insert([
            0 => [
                'id' => 1,
                'name' => 'about_ar',
                'slug_ar' => 'من نحن باللغة العربية',
                'slug_en' => 'About Us In Arabic',
                'value' =>
                    'وريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص الشكلي منذ القرن الخامس عشر عندما قامت مطبعة مجهولة برص مجموعة من الأحرف بشكل عشوائي أخذتها من نص، لتكوّن كتيّب بمثابة دليل أو مرجع شكلي لهذه الأحرف. خمسة قرون من الزمن لم تقضي على هذا النص، بل انه حتى صار مستخدماً وبشكله الأصلي في الطباعة والتنضيد الإلكتروني. انتشر بشكل كبير في ستينيّات هذا القرن مع إصدار رقائق "ليتراسيت" (Letraset) البلاستيكية تحوي مقاطع من هذا النص، وعاد لينتشر مرة أخرى مؤخراَ مع ظهور برامج النشر الإلكتروني مثل "ألدوس بايج مايكر" (Aldus PageMaker) والتي حوت أيضاً على نسخ من نص لوريم إيبسوم.',
                'input_type' => 2,
                'category' => 1,
                'created_at' => '2020-06-14 18:24:54',
                'updated_at' => '2020-06-14 18:24:54',
            ],
            1 => [
                'id' => 2,
                'name' => 'about_en',
                'slug_ar' => 'من نحن باللغة الانجليزية',
                'slug_en' => 'About Us In English',
                'value' =>
                    'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum',
                'input_type' => 2,
                'category' => 1,
                'created_at' => '2020-06-14 18:24:54',
                'updated_at' => '2020-06-14 18:24:54',
            ],
            2 => [
                'id' => 3,
                'name' => 'policy_ar',
                'slug_ar' => 'الشروط والاحكام باللغة العربية',
                'slug_en' => 'privacy policy In Arabic',
                'value' =>
                    'وريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص الشكلي منذ القرن الخامس عشر عندما قامت مطبعة مجهولة برص مجموعة من الأحرف بشكل عشوائي أخذتها من نص، لتكوّن كتيّب بمثابة دليل أو مرجع شكلي لهذه الأحرف. خمسة قرون من الزمن لم تقضي على هذا النص، بل انه حتى صار مستخدماً وبشكله الأصلي في الطباعة والتنضيد الإلكتروني. انتشر بشكل كبير في ستينيّات هذا القرن مع إصدار رقائق "ليتراسيت" (Letraset) البلاستيكية تحوي مقاطع من هذا النص، وعاد لينتشر مرة أخرى مؤخراَ مع ظهور برامج النشر الإلكتروني مثل "ألدوس بايج مايكر" (Aldus PageMaker) والتي حوت أيضاً على نسخ من نص لوريم إيبسوم.',
                'input_type' => 2,
                'category' => 1,
                'created_at' => '2020-06-14 18:24:54',
                'updated_at' => '2020-06-14 18:24:54',
            ],
            3 => [
                'id' => 4,
                'name' => 'policy_en',
                'slug_ar' => 'الشروط والاحكام باللغة الانجليزية',
                'slug_en' => 'Privacy Policy In English',
                'value' =>
                    'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum',
                'input_type' => 2,
                'category' => 1,
                'created_at' => '2020-06-14 18:24:54',
                'updated_at' => '2020-06-14 18:24:54',
            ],
            4 => [
                'id' => 5,
                'name' => 'contact_ar',
                'slug_ar' => 'تواصل معنا باللغة العربية',
                'slug_en' => 'Contact Us In Arabic',
                'value' =>
                    'وريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص الشكلي منذ القرن الخامس عشر عندما قامت مطبعة مجهولة برص مجموعة من الأحرف بشكل عشوائي أخذتها من نص، لتكوّن كتيّب بمثابة دليل أو مرجع شكلي لهذه الأحرف. خمسة قرون من الزمن لم تقضي على هذا النص، بل انه حتى صار مستخدماً وبشكله الأصلي في الطباعة والتنضيد الإلكتروني. انتشر بشكل كبير في ستينيّات هذا القرن مع إصدار رقائق "ليتراسيت" (Letraset) البلاستيكية تحوي مقاطع من هذا النص، وعاد لينتشر مرة أخرى مؤخراَ مع ظهور برامج النشر الإلكتروني مثل "ألدوس بايج مايكر" (Aldus PageMaker) والتي حوت أيضاً على نسخ من نص لوريم إيبسوم.',
                'input_type' => 2,
                'category' => 1,
                'created_at' => '2020-06-14 18:24:54',
                'updated_at' => '2020-06-14 18:24:54',
            ],
            5 => [
                'id' => 6,
                'name' => 'contact_en',
                'slug_ar' => 'تواصل معنا باللغة الانجليزية',
                'slug_en' => 'Contact Us In English',
                'value' =>
                    'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum',
                'input_type' => 2,
                'category' => 1,
                'created_at' => '2020-06-14 18:24:54',
                'updated_at' => '2020-06-14 18:24:54',
            ],

            6 => [
                'id' => 7,
                'name' => 'calls_site_percentage',
                'slug_ar' => 'عمولة المكالمات ',
                'slug_en' => 'Call Site Percentage',
                'value' => 20,
                'input_type' => 1,
                'category' => 1,
                'created_at' => '2020-06-14 18:24:54',
                'updated_at' => '2020-06-14 18:24:54',
            ],

            7 => [
                'id' => 8,
                'name' => 'chat_package_site_percentage',
                'slug_ar' => 'عمولة اشتراك الباقات ',
                'slug_en' => 'chat Site Percentage',
                'value' => 10,
                'input_type' => 1,
                'category' => 1,
                'created_at' => '2020-06-14 18:24:54',
                'updated_at' => '2020-06-14 18:24:54',
            ],
            8 => [
                'id' => 9,
                'name' => 'schedule_period',
                'slug_ar' => 'الفترة المتاحة للحجز',
                'slug_en' => 'sechedule Period',
                'value' => 5,
                'input_type' => 1,
                'category' => 1,
                'created_at' => '2020-06-14 18:24:54',
                'updated_at' => '2020-06-14 18:24:54',
            ],
            9 => [
                'id' => 11,
                'name' => 'terms_of_use_ar',
                'slug_ar' => 'شروط الاستخدام بالعربية',
                'slug_en' => 'terms_of_use_ar',
                'value' => '<p>
                شروط الاستخدام هي اتفاقية يجب على المستخدم الموافقة عليها
                والالتزام بها من أجل استخدام موقع ويب أو خدمة. شروط الاستخدام
                (TOU) يمكن أن تذهب بالعديد من الأسماء الأخرى ، بما في ذلك شروط
                الخدمة (TOS) والبنود والشروط. غالبًا ما يتم عرض شروط الاستخدام على
                مواقع التجارة الإلكترونية ومواقع التواصل الاجتماعي ، ولكنها لا
                تقتصر على تلك الأنواع من المواقع ويجب استخدامها مع أي موقع ويب
                يخزن الشخصية المعلومات من أي نوع. شروط الاستخدام المشروعة هي أ
                اتفاق ملزم قانونًا وخاضعًا للتغيير أيضًا يجب أن يلاحظ في إخلاء
                المسؤولية. يجب أن تحتوي مواقع الويب دائمًا على امتداد شروط
                الاستخدام المتعلقة بنشاط المستخدم والحسابات والمنتجات و تقنية.
            </p>
            <h3>اتفاقيات التفاف المتصفح</h3>
            <p>
                اتفاقية التفاف المتصفح هي اتفاقية لها شروط الاتفاقية على موقع
                الويب نفسه ومتصل بالصفحة الرئيسية لـ المنتج عن طريق ارتباط تشعبي.
                الارتباط التشعبي يؤدي إلى صفحة ويب أخرى التي سيكون لها شروط وأحكام
                الاتفاقية مفصلة. مع هذا النوع من الإعداد ، لا تظهر المصطلحات ولا
                تظهر تتطلب اتخاذ إجراء من قبل المستخدم للمتابعة. الذي - التي يعني
                أن المستخدم لا يوافق بنشاط على الشروط المرتبطة على الصفحة. هذا
                يسبب مشكلة لأن مستخدم صفحة الويب يجب أن تنقر بنشاط على الارتباط
                التشعبي حتى تتمكن من الوصول إلى ملف شروط الاستخدام والتعرف عليها.
                هذه طريقة مختلفة عن ضمان موافقة المستخدم على الشروط ويمكن أن يؤدي
                ذلك إلى إمكانات مشكلات لأن موقع الويب لا يتطلب من المستخدم أن يأخذ
                أيًا منها عمل
            </p>
            <h3>اتفاقيات Clickwrap</h3>
            <p>
                تختلف اتفاقية التفاف النقر لأنها مصممة من أجل تأكد من أن المستخدم
                لديه فرصة للاطلاع على شروط الاستخدام وأنهم يجب أيضًا الموافقة
                بنشاط على الشروط من أجل الموافقة. هذه يميل إلى أن يتم إنشاؤه من
                خلال سلسلة من النوافذ المنبثقة على موقع الويب. مع هذا النوع من
                الاتفاق ، يتم وضع الشروط بنشاط في أمام المستخدم لذلك يتعين عليهم
                مراجعتها والموافقة عليها ، والتي يعني أن موقع الويب الخاص بك محمي
                بشكل أفضل نتيجة لذلك. هذا ايضا يعني أنه نظرًا لأنه يجب الموافقة
                على الشروط قبل اتخاذ أي إجراء التي يأخذها المستخدم ، يمكنهم الصمود
                بشكل أفضل من الناحية القانونية إذا كانوا من أي وقت مضى. من بين
                الاثنين ، تعد اتفاقيات التفاف النقرات أكثر أمانًا وأكثر قابلية
                للتنفيذ
            </p>',
                'input_type' => 2,
                'category' => 1,
                'created_at' => '2020-06-14 18:24:54',
                'updated_at' => '2020-06-14 18:24:54',
            ],
            10 => [
                'id' => 12,
                'name' => 'terms_of_user_en',
                'slug_ar' => 'شروط الاستخدام بالانجليزية',
                'slug_en' => 'terms_of_use_en',
                'value' => ' <p>
                A terms of use is an agreement that a user must agree to and abide
                by in order to use a website or service. Terms of use (TOU) can go
                by many other names, including terms of service (TOS) and terms
                and conditions. Terms of use are often seen on e-commerce websites
                and social media websites, but it is not limited to those types of
                websites and should be used with any website that stores personal
                information of any kind. A terms of use that is legitimate is a
                legally binding agreement and is also subject to change, which
                should be noted in the disclaimer. Websites should always have a
                terms of use regarding user activity, accounts, products, and
                technology.
            </p>
            <h3>Browsewrap Agreements</h3>
            <p>
                A browsewrap agreement is one that has the terms of the agreement
                on the website itself and are connected to the main page of the
                product by a hyperlink. The hyperlink leads to another webpage
                that will have the terms and conditions of the agreement detailed.
                With this type of setup, the terms do not pop up and do not
                require an action be taken by the user in order to continue. That
                means that the user is not actively agreeing to the terms linked
                to the page. This causes an issue because the user of the webpage
                must actively click on the hyperlink in order to even access the
                terms of use and become aware of them. This is a different way of
                ensuring the user agrees to the terms and it can lead to potential
                issues because the website is not requiring the user to take any
                action
            </p>
            <h3>Clickwrap Agreements</h3>
            <p>
                A clickwrap agreement is different because it is designed to
                ensure that the user has a chance to see the terms of use and they
                must also actively agree to the terms in order to agree. This
                tends to be set up through a series of pop-ups on the website.
                With this type of agreement, the terms are actively placed in
                front of the user so they have to review and agree to them, which
                means that your website is better protected as a result. This also
                means that since the terms must be agreed to prior to any action
                being taken by the user, they can hold up better legally if they
                are ever needed. Of the two, clickwrap agreements are more secure
                and more enforceable
            </p>',
                'input_type' => 2,
                'category' => 1,
                'created_at' => '2020-06-14 18:24:54',
                'updated_at' => '2020-06-14 18:24:54',
            ],
        ]);
    }
}
