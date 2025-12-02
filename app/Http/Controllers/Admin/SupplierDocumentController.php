<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupplierDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SupplierDocumentController extends Controller
{
    public function download(SupplierDocument $supplierDocument)
    {
        $media = $supplierDocument->getFirstMedia('document');
        
        if (!$media) {
            abort(404, 'Document not found');
        }
        
        $path = $media->getPath();
        
        if (!file_exists($path)) {
            abort(404, 'File not found');
        }
        
        return response()->download($path, $media->file_name);
    }
}

