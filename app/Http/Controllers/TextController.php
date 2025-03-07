<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TextController extends Controller
{
    public function processText(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
            'operations' => 'required|array',
            'operations.*' => 'in:reverse,uppercase,remove_spaces'
        ]);

        $originalText = $request->input('text');
        $processedText = $originalText;

        foreach ($request->input('operations') as $operation) {
            switch ($operation) {
                case 'reverse':
                    $processedText = strrev($processedText);
                    break;
                case 'uppercase':
                    $processedText = strtoupper($processedText);
                    break;
                case 'remove_spaces':
                    $processedText = str_replace(' ', '', $processedText);
                    break;
            }
        }

        return response()->json([
            'original_text' => $originalText,
            'processed_text' => $processedText
        ]);
    }
}
