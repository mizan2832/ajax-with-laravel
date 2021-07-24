<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use DataTables;
use Validator;
class StudentController extends Controller
{
    public function index()
    {
        return view('welcome');
    }


    public function getStudents(Request $request)
    {
        if ($request->ajax()) {
            $data = Student::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm" id='.$row->id.' >Edit</a> <a href="#" class="delete btn btn-danger btn-sm" id="'.$row->id.'">Delete</a>';
                    return $actionBtn;
                })
                ->addColumn('checkbox', '<input type="checkbox" name="student_checkbox[]" class="student_checkbox" value="{{$id}}" />')
                ->rawColumns(['checkbox','action'])
                ->make(true);
        }
    }
    function postData(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'username'  => 'required',
            'phone'  => 'required',
            'dob'  => 'required',
        ]);

        $error_array = array();
        $success_output = '';
        if ($validation->fails())
        {
            foreach($validation->messages()->getMessages() as $field_name => $messages)
            {
                $error_array[] = $messages;
            }
        }
        else
        {
            if($request->get('button_action') == "insert")
            {
                $student = new Student([
                    'name'    =>  $request->get('name'),
                    'email'     =>  $request->get('email'),
                    'username'     =>  $request->get('username'),
                    'phone'     =>  $request->get('phone'),
                    'dob'     =>  $request->get('dob'),
                ]);

                
                $student->save();
                $success_output = '<div class="alert alert-success">Data Inserted</div>';


            }
            if($request->get('button_action') == 'update')
            {
                $student = Student::find($request->get('student_id'));
                $student->name = $request->get('name');
                $student->email = $request->get('email');
                $student->username = $request->get('username');
                $student->phone = $request->get('phone');
                $student->dob = $request->get('dob');
                $student->save();
                $success_output = '<div class="alert alert-success">Data Updated</div>';
            }
        }
        $output = array(
            'error'     =>  $error_array,
            'success'   =>  $success_output
        );
        echo json_encode($output);
    }
    function fetchdata(Request $request)
    {
        $id = $request->input('id');
        $student = Student::find($id);
        $output = array(
            'name'    =>  $student->name,
            'email'     =>  $student->email,
            'username'     =>  $student->username,
            'phone'     =>  $student->phone,
            'dob'     =>  $student->dob
        );
        echo json_encode($output);
    }

    function removedata(Request $request)
    {
        $student = Student::find($request->input('id'));
        if($student->delete())
        {
            echo 'Data Deleted';
        }
    }

    function massremove(Request $request)
    {
        $student_id_array = $request->input('id');
        $student = Student::whereIn('id', $student_id_array);
        if($student->delete())
        {
            echo 'Data Deleted';
        }
    }
}