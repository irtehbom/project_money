<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Classes\Media;
use App\Helpers\HelperFunctions;

class FileManagerController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
        $this->storage = new Storage();
        $this->media = new Media();
        $this->helpers = new helperFunctions;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function all_view() {

        $all = $this->media->all();
        
        return view('/file_manager/all', [
            "all" => $all
        ]);
    }
    
    public function update(Request $request) {
        
          $input = $request->all();
          $image = $this->media->where('id', $input["image_id"])->first();
          $image->altTag = $input["altTag"];
          $image->save();
         
    }
    
    public function delete(Request $request) {
        
          $input = $request->all();
          $image = $this->media->where('id', $input["image_id"])->first();
          $image->delete();
          
          
          Storage::disk('media')->delete($input["file_name"]);
          
          return redirect('file_manager_all');
         
    }

    public function add_view() {
        return view('/file_manager/add');
    }

    public function add(Request $request) {

        $input = $request->all();

        if (isset($input['_token'])) {
            unset($input['_token']);
        }

        $file = $input['file'];
        $altTag = $input['altTag'];

        $extension = $file->getClientOriginalExtension();

        $this->media->mimeType = $file->getClientMimeType();
        $this->media->originalName = str_replace(' ', '', $file->getClientOriginalName());
        $this->media->filename = $file->getFilename() . '.' . $extension;
        $this->media->altTag = $altTag;

        $exists = Storage::disk('media')->exists($this->media->originalName);

        if ($exists) {
            $editFileName = $this->helpers->file_ext_strip($this->media->originalName);
            $editFileName = $editFileName . '_' . $this->helpers->gen_uuid();
            $this->media->originalName = $editFileName . '.' . $extension;
        }

        $this->media->path = '/storage/app/public/' . $this->media->originalName;



        $path = Storage::putFileAs(
                        'public', $file, $this->media->originalName
        );

        $this->media->save();
    }

}
