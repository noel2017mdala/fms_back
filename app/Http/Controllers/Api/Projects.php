<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\projectsModel;
use Illuminate\Support\Carbon;

class Projects extends Controller
{
    public function index(){
        if(auth()->user()){
        $projects =  projectsModel::limit(2)->get();
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

    public function listProjects(int $id){
        if(auth()->user()){
            $projects =  projectsModel::where('created_by', $id)->get();
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
        
        if(auth()->user()){
        $createProject = projectsModel::create([
            'projects_name' =>$request->userinput['project_name'],
            'created_by'    =>  $request->id,
            'date_created'  => Carbon::now(),
        ]);
        
        if($createProject){
            return response()->json([
                'state' => 1,
                'msg' => 'project created succcessfully', 
            ], 200);
        }else{
            return response()->json([
                'state' => 0,
                'msg' => 'failed to create a project', 
            ], 401);
        }
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

    public function deletsProject($id){
        if(auth()->user()){
            $getProject = projectsModel::find($id);
            $getProject->delete();
            return response()->json([
                'state' => 1,
                'msg' => 'project deleted succssfully',
            ], 200);
        }else{
            return response()->json([
                'state' => 0,
                'msg' => 'page not found',
            ], 401);
        }
    }

    public function projectTransactions(){
        $transaction = projectsModel::find(1);
        return $transaction->transactions;
    }
}
