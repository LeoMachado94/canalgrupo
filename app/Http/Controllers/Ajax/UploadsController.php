<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\ClippingFile;
use App\Repositories\ClippingRepository;
use App\Repositories\VehicleRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class UploadsController extends Controller
{
    protected $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ClippingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function clippingFileStore(Request $request)
    {
        $request->validate([
            'file' => ['file', 'required','max:300000'],
            'clipping_id' => ['required', 'integer', 'exists:clippings,id']
        ]);

        // Handle file Upload
        if($request->hasFile('file')){
            // Get filename with the extension
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('file')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('file')->storeAs(
                'clippings/'.$request->clipping_id,
                $fileNameToStore,
                ['disk' => 'spaces']
            );

            try {
                $clipping = $this->repository->find($request->get('clipping_id'));
                $file = new ClippingFile();
                $file->clipping_id = $request->get('clipping_id');
                $file->path = $path;
                $file->name = $fileNameToStore;
                $file->extension = $extension;

                $clipping->files()->save($file);
                return response()->json([
                    'success' => true,
                    'message' => 'Arquivo salvo com sucesso!',
                    'file' => $file
                ]);
            } catch (ModelNotFoundException $exception) {
                return response()->json([
                    'success' => false,
                    'message' => $exception->getMessage()
                ]);
            }
        }
    }

    public function clippingFileDestroy(Request $request, $id)
    {
        try {
            $file = ClippingFile::find($id);
            Storage::disk('public')->delete($file->path);
            ClippingFile::destroy($id);
            return response()->json([
                'success' => true,
                'message' => 'Arquivo removido com Sucesso!'
            ]);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Arquivo não encontrado!'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }
}
