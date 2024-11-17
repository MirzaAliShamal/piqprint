<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\UserSession;
use Illuminate\Http\Request;
use App\Events\PhotoUploaded;
use App\Models\UserSessionPhoto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function end($uniqueId)
    {
        $session = UserSession::where('uniqueId', $uniqueId)->update([
            'status' => 0,
        ]);

        return redirect()->route('home');
    }

    public function photos($uniqueId)
    {
        $session = UserSession::where('uniqueId', $uniqueId)->first();
        $photos = $session->photos;

        return view('app.photos', get_defined_vars());
    }

    public function upload(Request $request, $uniqueId)
    {
        try {
            $request->validate([
                'photos' => 'required|array',
                'photos.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240'
            ]);

            $uploadedFiles = [];
            $failedFiles = [];

            $session = UserSession::where('uniqueId', $uniqueId)->first();

            foreach ($request->file('photos') as $photo) {
                try {
                    // Generate a unique filename with original extension
                    $filename = uniqid() . '_' . time() . '.' . $photo->getClientOriginalExtension();

                    // Store the file in the public disk
                    $path = $photo->storeAs('uploads/'.$uniqueId, $filename, 'public');

                    if ($path) {
                        $uploadedFiles[] = [
                            'user_session_id' => $session->id,
                            'original_name' => $photo->getClientOriginalName(),
                            'filename' => $filename,
                            'path' => $path,
                            'url' => Storage::disk('public')->url($path),
                            'size' => $photo->getSize(),
                            'mime_type' => $photo->getMimeType(),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                    } else {
                        $failedFiles[] = $photo->getClientOriginalName();
                    }
                } catch (\Exception $e) {
                    $failedFiles[] = $photo->getClientOriginalName();
                }
            }

            // Prepare the response
            $response = [
                'success' => true,
                'message' => count($uploadedFiles) . ' files uploaded successfully'
            ];

            if (!empty($uploadedFiles)) {
                UserSessionPhoto::insert($uploadedFiles);

                broadcast(new PhotoUploaded($uniqueId))->toOthers();
                $response['uploaded_files'] = $uploadedFiles;
            }

            if (!empty($failedFiles)) {
                $response['failed_files'] = $failedFiles;
                $response['message'] .= ', ' . count($failedFiles) . ' files failed';
            }

            return response()->json($response);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing the upload',
                'error' => config('app.debug') ? $e->getMessage() : 'Server Error'
            ], 500);
        }
    }

    public function photo($uniqueId, $photoId)
    {
        $photo = UserSessionPhoto::find($photoId);
        return view('app.photo', get_defined_vars());
    }

    public function edited(Request $request, $uniqueId, $photoId)
    {
        try {
            $request->validate([
                'currentImagePath' => 'required|string',
                'photo' => 'required|mimes:jpeg,png,jpg,gif|max:10240'
            ]);

            // Get the current image path and check if it exists
            $currentImagePath = $request->currentImagePath;
            if (!Storage::disk('public')->exists($currentImagePath)) {
                throw new \Exception('Original image not found');
            }

            // Get the original filename components
            $pathInfo = pathinfo($currentImagePath);
            $originalFilename = $pathInfo['filename'];  // filename without extension
            $originalDirectory = $pathInfo['dirname'];  // directory path


            $photo = $request->file('photo');

            // Generate new filename keeping the original name pattern
            // but adding a timestamp to prevent caching issues
            $filename = uniqid() . '_' . time() . '.' . ($photo->getClientOriginalExtension() ?: 'jpg');

            // Delete the old file
            Storage::disk('public')->delete($currentImagePath);

            // Store the new file
            $path = $photo->storeAs(
                $originalDirectory,  // Keep it in the same directory
                $filename,
                'public'  // Use public disk
            );

            UserSessionPhoto::find($photoId)->update([
                'original_name' => $photo->getClientOriginalName(),
                'filename' => $filename,
                'path' => $path,
                'url' => Storage::disk('public')->url($path),
                'size' => $photo->getSize(),
                'mime_type' => $photo->getMimeType(),
            ]);
            $uploaded = [
                'path' => $path,
                'url' => Storage::disk('public')->url($path),
                'size' => $photo->getSize(),
                'mime_type' => $photo->getMimeType(),
                'originalPath' => $currentImagePath,
            ];

            // Prepare the response
            $response = [
                'success' => true,
                'message' => 'Image uploaded successfully',
                'uploaded' => $uploaded,
            ];

            return response()->json($response);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing the upload',
                'error' => config('app.debug') ? $e->getMessage() : 'Server Error'
            ], 500);
        }
    }

    public function checkout($uniqueId)
    {
        $session = UserSession::where('uniqueId', $uniqueId)->first();
        $photos = $session->photos;

        return view('app.checkout', get_defined_vars());
    }
}
