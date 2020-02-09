<?php
    ini_set('display_errors', 0);

    print_r(get_house_photo("34.309366", "61.768044"));


    function get_house_photo($lat, $long)
    {
        $url = 'https://yandex.ru/maps/18/petrozavodsk/house/https://avatars.mds.yandex.net/get-ugc/754543/2a0000015f59740edbdb43759e4349850cc3/M ==/gallery/?ll=34.309366%2C61.768044&photos%5Bpoint%5D=34.309366%2C61.768044&z=16'; // корректная ссылка зайцева
        //  $url = '1qbQ==/?ll=34.335496%2C61.806601&photos%5Bpoint%5D=34.335496%2C61.806601&z=16'; // корректная ссылка зайцева
        //$url = "http://photo/2.html"; // корректная ссылка зайцева
        //   $url = 'https://yandex.ru/maps/18/petrozavodsk/house/ulitsa_drevlyanka_10/Z00YdQZiSE0CQFhrfXt2cX1qbQ==/gallery/?ll=34.335496%2C61.806601&photos%5Bpoint%5D=34.335496%2C61.806601&z=16'; // корректная ссылка зайцева
        // $url = 'https://yandex.ru/maps/18/petrozavodsk/house/Z00YdQRlTUwAQFhrfXRxd3pjZA==/gallery/?ll=' . $lat . '%2' . $long . '&photos%5Bpoint%5D=' . $lat . '%2C' . $long . '&z=16';
        //  $url = 'https://yandex.ru/maps/18/petrozavodsk/?ll=34.312185%2C61.770199&mode=search&photos%5Bpoint%5D=34.312185%2C61.770199&sll=34.322750%2C61.783086&sspn=0.037851%2C0.009917&text=%D0%B4%D1%80%D0%B5%D0%B2%D0%BB%D1%8F%D0%BD%D0%BA%D0%B0%2010&z=16';
        //   $url = 'https://yandex.ru/maps/18/petrozavodsk/?ll=' . $lat . '%2C' . $long . '&mode=search&photos%5Bpoint%5D=' . $lat . '%2C' . $long . '&sll=' . $lat . '%2C' . $long . '&sspn=0.037851%2C0.009917&text=%D0%B4%D1%80%D0%B5%D0%B2%D0%BB%D1%8F%D0%BD%D0%BA%D0%B0%2010&z=16';
        // echo $url;
        // echo '<br>';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     //   $result = curl_exec($ch);
        $last_url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        die($last_url);

        // echo $result;
        // die("d");
        @$dom = new DOMDocument();
        @$dom->loadHTML($result);

        $xpath = new DOMXPath($dom);
        $nodeList = $xpath->query("//div");
        $srcArrray = array();

        foreach ($nodeList as $node) {
            if ($node->getAttribute('class') == "app") {
                //  $child = $node->children(); //почему с14n() получает только одну
                //  echo $child;
                $child = $node->c14n(); //почему с14n() получает только одну
           //     echo $child;
                $html = new domDocument();
                $html->loadHTML($child);

                $images = $html->getElementsByTagName('img');

                foreach ($images as $image) {
                    $srcArrray[] = $image->getAttribute('src');
                }


            }
        }
//  оставляем только элементы с индексами с 12 по 16
        for ($i = 0; $i < 12; $i++) {
            unset($srcArrray[$i]);
        }

        return $srcArrray;
    }

