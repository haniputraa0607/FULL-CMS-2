<?php

namespace Modules\SpinTheWheel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Lib\MyHelper;

class WebviewSpinTheWheelController extends Controller
{   
    // get spin prize temp and spin items
    public function index($user_phone)
    {
        // spin the wheel color
        $colors = [
            "#E53935",  // red
            "#FFEB3B",  // yellow
            "#61d800",  // green
            "#673AB7",  // purple
            "#42A5F5",  // blue
            "#F06292"   // pink
        ];

        $data['user_phone'] = $user_phone;
        
        $data['spin_items'] = null;
        $data['spin_count'] = 0;
        $data['spin_point'] = 0;
        $data['spin_prize'] = 0;
        $data['spin_items_id'] = 0;
        $segments = [];     // contain prize for wheel segment
        $segment_titles = [];   // contain prize title for legend in view

        $spin_items = MyHelper::post('spinthewheel/items', ["phone"=>$user_phone] );
        // dd($spin_items);

        if (isset($spin_items['status']) && $spin_items['status'] == "success") {
            $spin_items_temp    = $spin_items['result']['spin_items'];
            $data['spin_count'] = count($spin_items['result']['spin_items']);
            $data['spin_point'] = $spin_items['result']['spin_point'];
            $data['spin_prize'] = $spin_items['result']['spin_prize'];
            
            // set data for spin (number segment)
            $spin_array = [];

            foreach ($spin_items_temp as $key => $item) {
                array_push($spin_array, $item['id_deals']);
                
                if ($key > 5) {
                    $key = ($key % 5);
                }
                $color = $colors[$key];

                $array = [
                    'strokeStyle' => '#fff',
                    'fillStyle' => $color,
                    'text' => str_limit($item['deals']['deals_title'], 7),
                ];
                array_push($segments, $array);
                array_push($segment_titles, $item['deals']['deals_title']);
            }

            $data['spin_items_id']    = json_encode($spin_array);
            $data['spin_items']       = json_encode($segments);
            $data['spin_item_titles'] = json_encode($segment_titles);
        }
        elseif (isset($spin_items['messages'])) {
            $data['errors'] = $spin_items['messages'];
        }

        return view('spinthewheel::webview/spin-the-wheel', $data);
    }

    // ajax for claim spin prize and calculate user point
    public function spin($user_phone)
    {
        $result = MyHelper::post('spinthewheel/spin', ["phone"=>$user_phone] );
        
        if (isset($result['status']) && $result['status'] == "success") {
            return $result;
        }

        return "";
    }

}
