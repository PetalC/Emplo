<?php

namespace App\Livewire\Application;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class MediaPreview extends Component
{
    use WithFileUploads;

    public $mediaItems;
    
    public function mount($mediaItems)
    {
        $this->mediaItems = $mediaItems;
    }

    public function render() {
        return view('livewire.application.media-preview');
    }
}

// ----------- media file types -----
// $mediaItems = [
//     ['type' => 'image', 'filename' => 'School1.png', 'path' => "assets/app/school-2-bg.png"],
//     ['type' => 'pdf', 'filename' => 'test-pdf.pdf', 'path' => 'assets/app/test-pdf.pdf'],
//     ['type' => 'image', 'filename' => 'School2.png', 'path' => 'assets/app/school-3-bg.png'],
//     ['type' => 'image', 'filename' => 'School3.png', 'path' => 'assets/app/school-4-bg.png'],
//     ['type' => 'pdf', 'filename' => 'test-pdf1.pdf', 'path' => 'assets/app/test-pdf.pdf'],
//     ['type' => 'doc', 'filename' => 'test-doc.docx', 'path' => 'assets/app/test-doc.docx'],
//     // Add more media items as needed
// ];