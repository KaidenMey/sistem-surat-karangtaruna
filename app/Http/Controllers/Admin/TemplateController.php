<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Template;
use Illuminate\Support\Facades\Storage;
use App\Traits\LogsActivity;

class TemplateController extends Controller
{
    use LogsActivity;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        // Admin hanya melihat template admin, bukan system template
        $templates = Template::where('type', 'admin')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
        return view('admin.templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.templates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:docx|max:10240', // 10MB max, hanya DOCX
            'form_fields' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $template = new Template();
        $template->name = $validated['name'];
        $template->description = $validated['description'] ?? null;
        $template->type = 'admin'; // Template yang dibuat admin
        
        // Parse form_fields dari JSON
        if ($request->filled('form_fields')) {
            $formFields = json_decode($request->form_fields, true);
            $template->form_fields = is_array($formFields) ? $formFields : null;
        }
        
        $template->is_active = $request->has('is_active');

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('templates', $fileName, 'public');
            $template->file_path = $filePath;
        }

        $template->save();

        $this->logActivity('create_template', 'Template', $template->id, "Created template: {$template->name}");

        return redirect()->route('admin.templates.index')
            ->with('success', 'Template berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $template = Template::findOrFail($id);
        return view('admin.templates.show', compact('template'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $template = Template::findOrFail($id);
        
        // Prevent editing of system templates
        if ($template->isSystemTemplate()) {
            return redirect()->route('admin.templates.index')
                ->with('error', 'Template sistem tidak dapat diedit.');
        }
        
        return view('admin.templates.edit', compact('template'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $template = Template::findOrFail($id);
        
        // Prevent updating of system templates
        if ($template->isSystemTemplate()) {
            return redirect()->route('admin.templates.index')
                ->with('error', 'Template sistem tidak dapat diubah.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:docx|max:10240',
            'form_fields' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $template->name = $validated['name'];
        $template->description = $validated['description'] ?? null;
        
        // Parse form_fields dari JSON
        if ($request->filled('form_fields')) {
            $formFields = json_decode($request->form_fields, true);
            $template->form_fields = is_array($formFields) ? $formFields : null;
        }
        
        $template->is_active = $request->has('is_active');

        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($template->file_path && Storage::disk('public')->exists($template->file_path)) {
                Storage::disk('public')->delete($template->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('templates', $fileName, 'public');
            $template->file_path = $filePath;
        }

        $template->save();

        $this->logActivity('update_template', 'Template', $template->id, "Updated template: {$template->name}");

        return redirect()->route('admin.templates.index')
            ->with('success', 'Template berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $template = Template::findOrFail($id);
        $templateName = $template->name;

        // Delete file if exists
        if ($template->file_path && Storage::disk('public')->exists($template->file_path)) {
            Storage::disk('public')->delete($template->file_path);
        }

        $this->logActivity('delete_template', 'Template', $template->id, "Deleted template: {$templateName}");

        $template->delete();

        return redirect()->route('admin.templates.index')
            ->with('success', 'Template berhasil dihapus.');
    }
}
