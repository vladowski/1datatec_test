<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessSubmission;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\DTO\SubmissionDTO;

class SubmitController extends Controller
{
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            $submissionDTO = new SubmissionDTO(
                $request->name,
                $request->email,
                $request->message
            );

            ProcessSubmission::dispatch($submissionDTO);

            return response()->json(['success' => 'Message saved'], 200);
        } catch (Exception $exception) {
            return response()->json(['error' => 'Service Unavailable. Please try again later.'], 503)
                ->header('Retry-After', 60);
        }
    }
}
