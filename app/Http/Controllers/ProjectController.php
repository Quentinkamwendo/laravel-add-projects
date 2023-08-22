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
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    use HttpResponses;

    public function index()
    {
        $paginatedData = Project::paginate(3);
        return ProjectResource::collection(
            $paginatedData,
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

        // if(isset($formFields['image'])) {
        //     // $formFields['image'] = $request->file('image')->store('images', 'public');
        //     $relativePath = $this->saveImage($formFields['image']);
        //     $formFields['image'] = $relativePath;
        // }
        // $imagePath = $request->file('image')->store('project_images', 'public');
        $imageData = base64_decode($request->input('image'));
        $imageName = uniqid().'.png';
        file_put_contents(storage_path('app/public/'.$imageName), $imageData);


        $project = Project::create([
            'user_id' => Auth::user()->id,
            'project_name' => $request->input('project_name'),
            'description' => $request->input("description"),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'image' => $imageName,
        ]);
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
