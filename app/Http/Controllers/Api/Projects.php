<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\projectsModel;
use Illuminate\Support\Carbon;

class Projects extends Controller
{
    public function index(){
        if(true){
        $projects =  projectsModel::all();
        if(isset($projects)){
            return response()->json([
                'state' => 1,
                'projects' =>$projects,

            ], 200);
        }else{
            return response()->json([
                'state' => 0,
                'msg' => '',
            ], 404);
        }
        }
    }

    public function createProject(Request $request){
       
        $createProject = projectsModel::create([
            'projects_name' => 'service my car',
            'created_by'    =>  100,
            'date_created'  => Carbon::now(),
        ]);
        
        if($createProject){
            return 'project created successfully';
        }
    }

    public function editProject(Request $request, $id) {
        $getProject = projectsModel::findorfail($id);
        $validate = $request->validate([
            'project_name' => '',
            'created_by' => '',
            'date_created' => '',
        ]);

        if($validate){
            $getProject->update([
                'project_name' => '',
            'created_by' => '',
            'date_created' => '',
            ]);

            return response()->json([
                'state' => 1,
                'msg' => 'project updated sucessfully',
            ], 200);

        }else{

            return response()->json([
                'state' => 0,
                'msg' => ' updated Failed ',
            ], 200);
        }

    }

    public function getTransactions(){

    }
}
