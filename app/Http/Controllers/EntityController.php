<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class EntityController extends Controller
{
    public function extractEntities(Request $request)
    {
        $url = $request->input('url');
        
        // Log the URL received
        Log::info('URL Received: ' . $url);

        // Ruta correcta del script Python
        $scriptPath = base_path('scripts/extract_entities.py');
        $process = new Process(['python', $scriptPath, $url]);

        try {
            $process->mustRun();
            $output = $process->getOutput();
            Log::info('Process Output: ' . $output);

            $data = json_decode($output, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('JSON decode error: ' . json_last_error_msg());
            }

            return response()->json($data);
        } catch (ProcessFailedException $exception) {
            Log::error('Error during script execution: ' . $exception->getMessage());
            return response()->json(['error' => 'Error processing URL'], 500);
        } catch (\Exception $exception) {
            Log::error('General error: ' . $exception->getMessage());
            return response()->json(['error' => 'Error processing URL'], 500);
        }
    }
}
