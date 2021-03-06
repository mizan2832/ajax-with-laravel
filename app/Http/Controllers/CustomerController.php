<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
class CustomerController extends Controller
{
    function index()
    {
        return view('live_search');
    }
    function action(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');

            if($query != '')
            {
                $data = DB::table('customers')->where('name','like','%'.$query.'%')
                ->orWhere('address','like','%'.$query.'%')
                ->orWhere('city','like','%'.$query.'%')
                ->orWhere('postal_code','like','%'.$query.'%')
                ->orWhere('country','like','%'.$query.'%')
                ->orderBy('id','desc')
                ->get();
            }
            else{
                $data = DB::table('customers')->orderBy('id','desc')
                ->get();

            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach ($data as $row) {
                    $output .= '
                        <tr>
                            <td>'.$row->name.'</td>
                            <td>'.$row->address.'</td>
                            <td>'.$row->city.'</td>
                            <td>'.$row->postal_code.'</td>
                            <td>'.$row->country.'</td>
                        </tr>      
                    ';
                }
            }
            else
            {
             $output = '
             <tr>
              <td align="center" colspan="5">No Data Found</td>
             </tr>
             ';
            }

            $data = array(
                'table_data' => $output,
                'total_data' => $total_row
            );
            echo json_encode($data);
        }
    }
}
