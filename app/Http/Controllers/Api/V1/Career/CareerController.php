<?php

namespace App\Http\Controllers\Api\V1\Career;

use App\Models\Career;
use App\Mail\CareerMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\CareerManagement\CareerResource;

class CareerController extends Controller
{
    public function index() {
        $careers = CareerResource::collection(Career::with('position', 'department')->orderBy('id', 'desc')->get());

        return response()->json([
            'status' => 'success',
            'careers' => $careers
        ]);
    }

    public function show(Career $career) {
        return response()->json([
            'status' => 'success',
            'career' => new CareerResource($career->load('position', 'department'))
        ]);
    }

    public function submitCareer(Request $request, Career $career) {

        $request->validate([
            'cv' => 'required|mimes:pdf|max:10000'
        ]);

        $mailData = [
            'cv' => $request->file('cv'),
            'position' => $career->position->name,
        ];

        Mail::to('hr@greenitmm.com')->send(new CareerMail($mailData));

        return response()->json([
            'ok' => true,
            'message' => 'Successfully submitted your CV',
        ]);
    }
}
