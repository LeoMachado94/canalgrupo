<?php

namespace App\Http\Controllers;

use App\Repositories\ClippingRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ExternalAccessController extends Controller
{
    protected $clippingRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ClippingRepository $clippingRepository)
    {
        $this->clippingRepository = $clippingRepository;
    }

    /**
     * Show clipping external access.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function clippingShow(Request $request, $slug)
    {
        $clipping = $this->clippingRepository->findWhere(['slug' => $slug])->first();
        if (empty($clipping)) {
            throw new ModelNotFoundException();
        }

        $clipping_data['videos'] = $clipping->files->whereIn('extension', ['mp4', 'mkv', 'avi']);
        $clipping_data['images'] = $clipping->files->whereIn('extension', ['png', 'jpeg', 'jpg', 'gif']);
        $clipping_data['audios'] = $clipping->files->whereIn('extension', ['mp3', 'ogg', 'wma']);
        $clipping_data['docs'] = $clipping->files->whereIn('extension', ['pdf', 'doc', 'docx', 'xlsx', 'xls', 'ppt', 'pptx', 'txt']);
        $clipping_data['last_read'] = $clipping->lastRead();

        // Update Last Read
        $clipping->last_read = date('Y-m-d H:i:s');
        $clipping->saveWithoutEvents();

        return view('clippings.show-external', compact('clipping', 'clipping_data'));
    }
}
