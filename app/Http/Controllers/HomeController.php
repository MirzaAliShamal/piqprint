<?php

namespace App\Http\Controllers;

use App\Models\UserSession;
use Illuminate\Support\Str;
use App\Events\SessionStart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
    public function index()
    {
        return view('app.index', get_defined_vars());
    }

    public function generateQr()
    {
        $uniqueId = Str::uuid();
        $url = route('session', $uniqueId);

        $qrImage = QrCode::size(300)->generate($url)->toHtml();

        return response()->json([
            'qr' => $qrImage,
            'uniqueId' => $uniqueId,
            'url' => $url,
        ]);
    }

    public function session($uniqueId)
    {
        $session = UserSession::where('uniqueId', $uniqueId)->first();

        if (!$session) {
            $session = UserSession::create([
                'uniqueId' => $uniqueId,
                'url' => route('session', $uniqueId),
                'status' => 1,
            ]);

            broadcast(new SessionStart($uniqueId))->toOthers();
        }

        if ($session->status == 1) {
            return view('app.uploading', get_defined_vars());
        } else {
            abort(404);
        }
    }
}
