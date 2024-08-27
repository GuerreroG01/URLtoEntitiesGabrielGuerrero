<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class EntityController extends Controller
{
    public function extractEntities(Request $request)
    {
        $url = $request->input('url');

        try {
            $process = new Process(['python', base_path('scripts/extract_entities.py'), $url]);
            $process->run();

            if (!$process->isSuccessful()) {
                return response()->json([
                    'error' => 'Error ejecutando el script',
                    'output' => $process->getErrorOutput()
                ], 500);
            }
            $result = json_decode($process->getOutput(), true);
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}