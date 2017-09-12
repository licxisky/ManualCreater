<?php

namespace App\Http\Controllers;

use App\System;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Sklcc\Csteaching;

class ManualController extends Controller
{
    protected $menus;

    public function __construct()
    {
        $menus_type = \App\Manual::whereNull('manual_parent_id');
        if(session('mn_userrole') == System::ADMIN_ID)
        {
            $this->menus = $menus_type->get();
        }
        else
        {
            $this->menus = $menus_type->where('manual_authority', false)->get();
        }
    }

    public static function to($id)
    {
        if(!is_numeric($id)) abort(404);
        return redirect($id.'/'.Csteaching::encrypt([$id]));
    }

    public function index()
    {
        $manual = \App\Manual::whereNull('manual_parent_id')->first();
        if(!$manual)
            return view('manual.index');
        return redirect($manual->id.'/'.Csteaching::encrypt([$manual->id]));
    }

    public function manual(\App\Manual $manual, $secret, Request $request)
    {
        if(Csteaching::encrypt([$manual->id]) != $secret)
            abort(404,'目标页面不存在');

        if($manual->manual_authority)
            if(session('mn_userrole') != System::ADMIN_ID)
                abort(404, '很抱歉，您无权访问此页面');

        $breadcrumbarray = $this->getBreadCrumbArray($manual);
        $rootid = $breadcrumbarray[0]['id'];
        $manual->manual_secret = Csteaching::encrypt([$manual->id]);

        $data = [
            'manual' => $manual,
            'breadcrumbarray' => $breadcrumbarray,
            'rootid' => $rootid,
            'type' => $request->has('type') ? $request->get('type') : '',
            'menus' => $this->menus,
            'url' => $manual->id
        ];
        foreach ($data['menus'] as &$value)
            $value->manual_secret = Csteaching::encrypt([$value->id]);

        if(session('mn_userrole') != System::ADMIN_ID)
            $data['type'] = '';

        switch ($manual->manual_type)
        {
            case 1: // 目录
                $data['manual']->load(['manuals' => function($query) {
                    if(session('mn_userrole') != System::ADMIN_ID)
                        $query->orderBy('manual_sort', 'asc')
                            ->where('manual_authority', false);
                    else
                        $query->orderBy('manual_sort', 'asc');
                }]);
                foreach ($data['manual']->manuals as &$value)
                    $value->manual_secret = Csteaching::encrypt([$value->id]);
                return view('manual.list', $data);
            case 2: // 说明
                return view('manual.detail', $data);
            default:
                abort(404, '目标页面不存在...');
        }

    }

    public function add(Request $request)
    {
        $manual = new \App\Manual();
        $manual->manual_title = $request->get('title');
        $manual->manual_type = $request->get('type');
        $manual->manual_authority = $request->get('authority');
        $manual->manual_parent_id = $request->get('parentid');
        $manual->manual_sort = \App\Manual::where('manual_parent_id', $request->get('parentid'))->count() + 1;
        $manual->save();

        return back();
    }

    public function up(\App\Manual $manual)
    {
        $brother = $manual->parent->manuals()
            ->where('manual_sort', '<', $manual->manual_sort)
            ->orderBy('manual_sort', 'desc')
            ->orderBy('id', 'desc')
            ->first();

        if(!$brother)
            abort(404, '已经到顶啦');

        $temp_sort = $manual->manual_sort;
        $manual->manual_sort = $brother->manual_sort;
        $brother->manual_sort = $temp_sort;

        $manual->save();
        $brother->save();

        return back();
    }

    public function down(\App\Manual $manual)
    {
        $brother = $manual->parent->manuals()
            ->where('manual_sort', '>', $manual->manual_sort)
            ->orderBy('manual_sort', 'asc')
            ->orderBy('id', 'asc')
            ->first();

        if(!$brother)
            abort(404, '已经到底啦');

        $temp_sort = $manual->manual_sort;
        $manual->manual_sort = $brother->manual_sort;
        $brother->manual_sort = $temp_sort;

        $manual->save();
        $brother->save();

        return back();
    }

    public function edit(\App\Manual $manual, Request $request)
    {
        $manual->manual_title = $request->has('title') ? $request->get('title') : $manual->manual_title;
        $manual->manual_authority = $request->has('authority') ? $request->get('authority') : $manual->manual_authority;
        $manual->manual_description = $request->has('description') ? $request->get('description') : $manual->manual_description;
        $manual->save();
        if($request->has('description'))
            return redirect($manual->id.'/'.Csteaching::encrypt([$manual->id]));
        else
            return back();
    }

    public function delete(\App\Manual $manual)
    {
        $manual->delete();
        return back();
    }

    public function str($manual)
    {
        return redirect($manual[0]->id);
    }

    public function imageUpload(Request $request)
    {
        if(!$request->hasFile('upload'))
            return json_encode([
                'uploaded' =>  0,
                'fileName' => '',
                'url' => '',
                'error' => [
                    'message' => '参数错误',
                    'number' => 404
                ]
            ]);

        $file = $request->file('upload');

        if(!$file->isValid())
            return json_encode([
                'uploaded' =>  0,
                'fileName' => '',
                'url' => '',
                'error' => [
                    'message' => '文件上传失败',
                    'number' => 503
                ]
            ]);

        $extension = $file->getClientOriginalExtension();
        if(!in_array(strtolower($extension), \App\System::IMAGE_EXTENSION))
            return json_encode([
                'uploaded' =>  0,
                'fileName' => '',
                'url' => '',
                'error' => [
                    'message' => '文件类型错误',
                    'number' => 403
                ]
            ]);

        $fileNmae = $this->upload($file, 'image');
        return json_encode([
            'uploaded' =>  1,
            'fileName' => $fileNmae,
            'url' => asset('image/'.$fileNmae)
        ]);
    }

    private function upload($file, $type)
    {
        $path = public_path($type);

        if(!is_dir($path))
            mkdir($path, 0777, true);

        $fileName = md5(time().$file->getClientOriginalName()).'.'.$file->getClientOriginalExtension();

        $path = $file->move($path, $fileName)->getRealPath();

        return $fileName;
    }

    private function getBreadCrumbArray(\App\Manual $manual)
    {
        $breadcrumbarray = [];

        $breadcrumbarray[] = [
            'id' => $manual->id,
            'title' => $manual->manual_title,
            'class' => 'active',
            'secret' => Csteaching::encrypt([$manual->id])
        ];

        while($manual->manual_parent_id != null)
        {
            $manual = $manual->parent;
            $breadcrumbarray[] = [
                'id' => $manual->id,
                'title' => $manual->manual_title,
                'class' => '',
                'secret' => Csteaching::encrypt([$manual->id])
            ];
        }

        return array_reverse($breadcrumbarray);
    }
}
