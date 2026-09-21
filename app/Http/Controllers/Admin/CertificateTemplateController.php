<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CertificateTemplate;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateTemplateController extends Controller
{
    public function index()
    {
        $templates = CertificateTemplate::with('creator')
            ->withCount('activities')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.certificates.templates.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.certificates.templates.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'background_image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'signature_image'  => 'nullable|image|mimes:png|max:2048', // Transparent PNG
            'signatory_name'   => 'nullable|string|max:255',
            'signatory_title'  => 'nullable|string|max:255',

            'name_x'           => 'required|integer|min:0|max:100',
            'name_y'           => 'required|integer|min:0|max:100',
            'name_font_size'   => 'required|integer|min:10|max:72',
            'name_color'       => 'required|string|max:7',

            'title_x'          => 'required|integer|min:0|max:100',
            'title_y'          => 'required|integer|min:0|max:100',
            'title_font_size'  => 'required|integer|min:10|max:72',
            'title_color'      => 'required|string|max:7',

            'date_x'           => 'required|integer|min:0|max:100',
            'date_y'           => 'required|integer|min:0|max:100',
            'date_font_size'   => 'required|integer|min:10|max:72',
            'date_color'       => 'required|string|max:7',

            'sig_x'            => 'required|integer|min:0|max:100',
            'sig_y'            => 'required|integer|min:0|max:100',
        ]);

        $imagePath = $request->file('background_image')->store('certificate_templates', 'public');

        $signaturePath = null;
        if ($request->hasFile('signature_image')) {
            $signaturePath = $request->file('signature_image')->store('certificate_signatures', 'public');
        }

        $layoutSettings = [
            'recipient_name' => [
                'x'         => (int) $validated['name_x'],
                'y'         => (int) $validated['name_y'],
                'font_size' => (int) $validated['name_font_size'],
                'color'     => $validated['name_color'],
            ],
            'activity_title' => [
                'x'         => (int) $validated['title_x'],
                'y'         => (int) $validated['title_y'],
                'font_size' => (int) $validated['title_font_size'],
                'color'     => $validated['title_color'],
            ],
            'issue_date'     => [
                'x'         => (int) $validated['date_x'],
                'y'         => (int) $validated['date_y'],
                'font_size' => (int) $validated['date_font_size'],
                'color'     => $validated['date_color'],
            ],
            'signatory'      => [
                'x'         => (int) $validated['sig_x'],
                'y'         => (int) $validated['sig_y'],
            ],
        ];

        $template = CertificateTemplate::create([
            'title'                 => $validated['title'],
            'background_image_path' => $imagePath,
            'signature_image_path'  => $signaturePath,
            'layout_settings'       => $layoutSettings,
            'signatory_name'        => $validated['signatory_name'],
            'signatory_title'       => $validated['signatory_title'],
            'created_by'            => auth()->id(),
        ]);

        ActivityLog::record('Created Certificate Template', "Created template: \"{$template->title}\".");

        return redirect()->route('admin.certificates.templates.index')
            ->with('success', 'Certificate template created successfully!');
    }

    public function edit(CertificateTemplate $template)
    {
        return view('admin.certificates.templates.edit', compact('template'));
    }

    public function update(Request $request, CertificateTemplate $template)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'signature_image'  => 'nullable|image|mimes:png|max:2048',
            'signatory_name'   => 'nullable|string|max:255',
            'signatory_title'  => 'nullable|string|max:255',

            'name_x'           => 'required|integer|min:0|max:100',
            'name_y'           => 'required|integer|min:0|max:100',
            'name_font_size'   => 'required|integer|min:10|max:72',
            'name_color'       => 'required|string|max:7',

            'title_x'          => 'required|integer|min:0|max:100',
            'title_y'          => 'required|integer|min:0|max:100',
            'title_font_size'  => 'required|integer|min:10|max:72',
            'title_color'      => 'required|string|max:7',

            'date_x'           => 'required|integer|min:0|max:100',
            'date_y'           => 'required|integer|min:0|max:100',
            'date_font_size'   => 'required|integer|min:10|max:72',
            'date_color'       => 'required|string|max:7',

            'sig_x'            => 'required|integer|min:0|max:100',
            'sig_y'            => 'required|integer|min:0|max:100',
        ]);

        if ($request->hasFile('background_image')) {
            if ($template->background_image_path) {
                Storage::disk('public')->delete($template->background_image_path);
            }
            $template->background_image_path = $request->file('background_image')->store('certificate_templates', 'public');
        }

        if ($request->hasFile('signature_image')) {
            if ($template->signature_image_path) {
                Storage::disk('public')->delete($template->signature_image_path);
            }
            $template->signature_image_path = $request->file('signature_image')->store('certificate_signatures', 'public');
        }

        $layoutSettings = [
            'recipient_name' => [
                'x'         => (int) $validated['name_x'],
                'y'         => (int) $validated['name_y'],
                'font_size' => (int) $validated['name_font_size'],
                'color'     => $validated['name_color'],
            ],
            'activity_title' => [
                'x'         => (int) $validated['title_x'],
                'y'         => (int) $validated['title_y'],
                'font_size' => (int) $validated['title_font_size'],
                'color'     => $validated['title_color'],
            ],
            'issue_date'     => [
                'x'         => (int) $validated['date_x'],
                'y'         => (int) $validated['date_y'],
                'font_size' => (int) $validated['date_font_size'],
                'color'     => $validated['date_color'],
            ],
            'signatory'      => [
                'x'         => (int) $validated['sig_x'],
                'y'         => (int) $validated['sig_y'],
            ],
        ];

        $template->update([
            'title'           => $validated['title'],
            'layout_settings' => $layoutSettings,
            'signatory_name'  => $validated['signatory_name'],
            'signatory_title' => $validated['signatory_title'],
        ]);

        ActivityLog::record('Updated Certificate Template', "Updated template: \"{$template->title}\".");

        return redirect()->route('admin.certificates.templates.index')
            ->with('success', 'Certificate template updated successfully!');
    }

    public function destroy(CertificateTemplate $template)
    {
        if ($template->activities()->count() > 0) {
            return back()->with('error', 'Cannot delete this template because it is assigned to one or more activities.');
        }

        if ($template->background_image_path) {
            Storage::disk('public')->delete($template->background_image_path);
        }
        if ($template->signature_image_path) {
            Storage::disk('public')->delete($template->signature_image_path);
        }

        $title = $template->title;
        $template->delete();

        ActivityLog::record('Deleted Certificate Template', "Deleted template: \"{$title}\".");

        return redirect()->route('admin.certificates.templates.index')
            ->with('success', 'Certificate template deleted successfully!');
    }
}
