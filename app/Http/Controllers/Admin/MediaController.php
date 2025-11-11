<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    /**
     * Upload an image for TinyMCE
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:5120', // 5MB max
        ]);

        $file = $request->file('file');
        $path = $file->store('blog-images', 'public');
        $url = Storage::url($path);

        return response()->json([
            'location' => $url
        ]);
    }

    /**
     * Upload an image and attach to blog post (for Media Library)
     */
    public function uploadBlogImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120', // 5MB max
            'blog_post_id' => 'nullable|exists:blog_posts,id'
        ]);

        $file = $request->file('image');
        
        // If blog post ID is provided, attach to that post
        if ($request->blog_post_id) {
            $blogPost = BlogPost::findOrFail($request->blog_post_id);
            $media = $blogPost->addMedia($file)->toMediaCollection('images');
        } else {
            // Otherwise, just store in public storage
            $path = $file->store('blog-images', 'public');
            $url = Storage::url($path);
            
            return response()->json([
                'success' => true,
                'url' => $url,
                'filename' => $file->getClientOriginalName()
            ]);
        }

        return response()->json([
            'success' => true,
            'url' => $media->getUrl(),
            'filename' => $media->file_name,
            'id' => $media->id
        ]);
    }

    /**
     * Delete an uploaded image
     */
    public function deleteImage(Request $request)
    {
        $request->validate([
            'path' => 'required|string'
        ]);

        $path = str_replace('/storage/', '', $request->path);
        
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'File not found'], 404);
    }
}
