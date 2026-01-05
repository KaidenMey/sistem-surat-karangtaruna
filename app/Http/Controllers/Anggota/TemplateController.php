<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Template;

class TemplateController extends Controller
{
    /**
     * Display list of available templates
     */
    public function index()
    {
        // System templates (default)
        $systemTemplates = Template::where('is_active', true)
            ->where('type', 'system')
            ->orderBy('name', 'asc')
            ->get();

        // Admin templates (custom)
        $adminTemplates = Template::where('is_active', true)
            ->where('type', 'admin')
            ->orderBy('name', 'asc')
            ->get();

        return view('anggota.templates.index', compact('systemTemplates', 'adminTemplates'));
    }

    /**
     * Show template details
     */
    public function show($id)
    {
        $template = Template::where('is_active', true)->findOrFail($id);
        return view('anggota.templates.show', compact('template'));
    }
}
