<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Storage;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimetypes:application/pdf|max:12288',
            'pedido_id' => 'required|integer|exists:pedidos,id',
        ]);
        //Primeiro deleta o arquivo anterior, caso exista
        $file_old = File::where('pedido_id',$request->pedido_id)->first();
        if($file_old){
            Storage::delete($file_old->path);
            $file_old->delete();
        }
        //Depois faz upload de novo arquivo
        $file = new File;
        $file->pedido_id = $request->pedido_id;
        $file->original_name = $request->file('file')->getClientOriginalName();
        $file->path = $request->file('file')->store('.');
        $file->save();
        return back();
    }

    public function show(File $file)
    {
        return Storage::download($file->path, $file->original_name);
    }

    public function destroy(File $file)
    {
        Storage::delete($file->path);
        $file->delete();
        return back();
    }
}
