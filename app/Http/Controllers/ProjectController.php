<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;

class ProjectController extends Controller
{
    use HttpResponses;

    public function index()
    {
        return ProjectResource::collection(
            Project::where('user_id', Auth::user()->id)->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $formFields = $request->validated($request->all());
        // $formFields = ([
        //     'user_id' => Auth::user()->id,
        //     'project_name' => $request->project_name,
        //     'description' => $request->description,
        //     'start_date' => $request->start_date,
        //     'end_date' => $request->end_date
        // ]);
        // $project = new Project;
        // $project->user_id = Auth::user()->id;
        // $project->project_name = $request->project_name;
        // $project->description = $request->description;
        // $project->start_date = $request->start_date;
        // $project->end_date = $request->end_date;

        // if ($request->hasFile('image')) {
        //     $image = $request->file('image');
        //     $path = $image->store('project_images', "public");
        //     $project->image = $path;
        // }
        // $project->save();
        // return response()->json($project, 201);

        if(isset($formFields['image'])) {
            // $formFields['image'] = $request->file('image')->store('images', 'public');
            $relativePath = $this->saveImage($formFields['image']);
            $formFields['image'] = $relativePath;
        }

        $project = Project::create($formFields);
         return new ProjectResource($project);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return $this->isNotAuthorized($project) ? $this->isNotAuthorized($project) : new ProjectResource($project);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        if(Auth::user()->id !== $project->user_id) {
            return $this->error('', 'You are not authorize to make this request', 403);
        }
        if($request->hasFile('image')) {
            $project['image'] = $request->file('image')->store('images', 'public');
        }
        $project->update($request->all());
        return new ProjectResource($project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        return $this->isNotAuthorized($project) ? $this->isNotAuthorized($project) : $project->delete();
    }

    private function isNotAuthorized($project) {
        if(Auth::user()->id !== $project->user_id) {
            return $this->error('', 'You are not authorize to make this request', 403);
        }
    }

    private function saveImage($image) {
        if (preg_match('/^data:image\/(\w+);base64,/', $image, $type)) {
            $image = substr($image, strpos($image, ',') + 1);
            $type = strtolower($type[1]);
            if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                throw new Exception('invalid image type');
            }
            $image = str_replace(' ', '+', $image);
            $image = base64_decode($image);
            if ($image === false) {
                throw new Exception('base64_decode failed');
            }
        } else {
            throw new Exception('did not match data URI with image data');
        }
        $dir = 'images/';
        $file = Str::random().'.'.$type;
        $absolutePath = public_path($dir);
        $relativePath = $dir.$file;
        if (!File::exists($absolutePath)) {
            File::makeDirectory($absolutePath, 0755, true);
        }
        file_put_contents($relativePath, $image);
        return $relativePath;
    }
}
