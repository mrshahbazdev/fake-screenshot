<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'username' => 'admin',
            'email' => 'admin@quickreceipt.com',
            'password' => 'password',
            'subscription_status' => 'active',
            'subscription_end' => now()->addYear(),
            'role' => 'admin',
        ]);

        // Sample pages matching the original sidebar entries
        $pages = [
            ['name' => 'firstPage', 'thumbnail' => 'view1.8191750aab4d260792d7.png'],
            ['name' => 'secondPage', 'thumbnail' => 'view2.e333d383ff5863a08d35.png'],
            ['name' => 'thirdPage', 'thumbnail' => 'view3.00e85829ec35c45a9fbd.png'],
            ['name' => 'fourthPage', 'thumbnail' => 'view4.28270cf3019093b79d20.png'],
            ['name' => 'fifthPage', 'thumbnail' => 'view5.6d39b8e19bfb23a61833.png'],
            ['name' => 'sixthPage', 'thumbnail' => 'view6.080ba31d037c6cef1981.png'],
            ['name' => 'seventhPage', 'thumbnail' => 'view7.53cc9d541b356969bf2c.png'],
            ['name' => 'eighthPage', 'thumbnail' => 'view8.a48bcff884bd1ebc69d9.png'],
            ['name' => 'ninthPage', 'thumbnail' => 'view9.0e35389472f66ab093b8.png'],
            ['name' => 'tenthPage', 'thumbnail' => 'view10.812207978d73a556c020.png'],
            ['name' => 'eleventhPage', 'thumbnail' => 'view11.f52f89733bb217125c80.png'],
            ['name' => 'twelvethPage', 'thumbnail' => 'view12.1659f5191f89b5756c40.png'],
            ['name' => 'thirteenPage', 'thumbnail' => 'view13.223a2599fe7f6609b1f1.png'],
            ['name' => 'fourteenPage', 'thumbnail' => 'view14.36aba66d0650fa5183f4.png'],
            ['name' => 'fifteenPage', 'thumbnail' => 'view15.ac906eb41a751ab0294f.png'],
            ['name' => 'sixteenthPage', 'thumbnail' => 'view16.6f704ab4151ee2e45ee5.png'],
            ['name' => 'seventeenthPage', 'thumbnail' => 'view17.a4fd1967b4d1b1a91812.png'],
            ['name' => 'eighteenthPage', 'thumbnail' => 'view18.bd12754202da2b4ced60.png'],
            ['name' => 'nineteenthPage', 'thumbnail' => 'view19.bfc9a46a2ed7ebe575db.png'],
            ['name' => 'twentyPage', 'thumbnail' => 'view20.034446579e56bc090060.png'],
            ['name' => 'twentyOnePage', 'thumbnail' => 'view21.91e2570972f682a1a6f8.png'],
            ['name' => 'twentyTwoPage', 'thumbnail' => 'view22.84cb0eee1e9594f9ce54.png'],
            ['name' => 'twentyThreePage', 'thumbnail' => 'view23.5b40dc01652b8ce629ad.png'],
            ['name' => 'twentyFourPage', 'thumbnail' => 'view24.ec8e2838e7553f2bd93a.png'],
            ['name' => 'twentyFivePage', 'thumbnail' => 'view25.8375a32f45f64ec82304.png'],
            ['name' => 'twentySixPage', 'thumbnail' => 'view26.b4a51e27bbcd627f04e8.png'],
            ['name' => 'twentySevenPage', 'thumbnail' => 'view27.5636a13c2e46487413ef.png'],
            ['name' => 'twentyEightPage', 'thumbnail' => 'view28.48e4019120e891953d18.png'],
            ['name' => 'twentyNinePage', 'thumbnail' => 'view29.e536fbcfec93d366c953.png'],
            ['name' => 'thirtyPage', 'thumbnail' => 'view30.37973f79615d0868634b.png'],
            ['name' => 'thirtyOnePage', 'thumbnail' => 'view31.28e5d1b98f775e8398b5.png'],
            ['name' => 'thirtyTwoPage', 'thumbnail' => 'view32.b83782a4d6c15423e907.jpg'],
            ['name' => 'thirtyThreePage', 'thumbnail' => 'view33.f07be24002f2889216b8.png'],
            ['name' => 'thirtyFourPage', 'thumbnail' => 'view34.66f61b529f4a8f232e6c.png'],
            ['name' => 'thirtyFivePage', 'thumbnail' => 'view35.4c8cba14b8295e3a4a38.png'],
            ['name' => 'thirtySixPage', 'thumbnail' => 'view36.4aa8215e5aef77287725.png'],
            ['name' => 'thirtySevenPage', 'thumbnail' => 'view37.3a4f9cac675b0cd7b2e5.png'],
            ['name' => 'thirtyEightPage', 'thumbnail' => 'view38.f22827a4cc17eac5c264.png'],
            ['name' => 'thirtyNinePage', 'thumbnail' => 'view39.c2033d4cd32652dee8a1.png'],
            ['name' => 'fourtyPage', 'thumbnail' => 'view40.d63c62a2de548a1236fa.png'],
            ['name' => 'fourtyOnePage', 'thumbnail' => 'view41.b1b4dafdb433ba937bfe.png'],
            ['name' => 'fourtyTwoPage', 'thumbnail' => 'view42.63abefefa2cbabf46de4.png'],
            ['name' => 'fourtyThreePage', 'thumbnail' => 'view43.4ed05ac7eba2c7fcf0dc.png'],
            ['name' => 'fourtyFourPage', 'thumbnail' => 'view44.0be982496953ca2cbccc.png'],
            ['name' => 'fourtyFivePage', 'thumbnail' => 'view45.f4f3c3103d6e0ccefb65.png'],
            ['name' => 'fourtySixPage', 'thumbnail' => 'view46.eee0ee06dba543cdf64e.png'],
            ['name' => 'fourtySevenPage', 'thumbnail' => 'view47.80314b79b93c158746d5.png'],
            ['name' => 'fourtyEightPage', 'thumbnail' => 'view48.d571ab4b985758d79e75.png'],
            ['name' => 'fourtyNinePage', 'thumbnail' => 'view49.3e72143c4d1f05c50a3f.png'],
            ['name' => 'fiftyPage', 'thumbnail' => 'view50.329cebe9508a5195c04f.png'],
            ['name' => 'fiftyOnePage', 'thumbnail' => 'view51.6cf20a221d2a72b9d60f.png'],
            ['name' => 'fiftyTwoPage', 'thumbnail' => 'view52.83ecf66c9025d3d81ada.png'],
        ];

        foreach ($pages as $page) {
            Page::create([
                'name' => $page['name'],
                'data' => '<div style="padding:20px;text-align:center;"><h2>Template: ' . $page['name'] . '</h2><p>This template content is loaded from the database. Import your original page data to see the full receipt template.</p></div>',
                'script' => '',
                'sidebar' => '<div style="padding:10px;"><p style="color:#999;">Controls will appear here when template data is imported.</p></div>',
                'thumbnail' => $page['thumbnail'],
            ]);
        }
    }
}
