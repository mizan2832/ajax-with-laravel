<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class CountryController extends Controller
{
    function index()
    {
        return view('autocomplete');
    }

    function action(Request $request)
    {if($request->get('query'))
        {
         $query = $request->get('query');
         $data = DB::table('countries')
           ->where('name', 'LIKE', "%{$query}%")
           ->get();
         $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
         foreach($data as $row)
         {
          $output .= '
          <li><a href="#">'.$row->name.'</a></li>
          ';
         }
         $output .= '</ul>';
         echo $output;
        }
    }
}
