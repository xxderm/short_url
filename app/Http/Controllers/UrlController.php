<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUrlRequest;
use App\Models\Url;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    private function generateUniqueCode(): string 
    {
        do {
            $code = Str::random(6);
        } while (Url::query()->where('code', $code)->exists());

        return $code;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUrlRequest $request): JsonResponse
    {
        $data = $request->validated();

        $url = $data['url'];

        $link = Url::query()
            ->where('url', $url)
            ->first();

        if (!$link) {
            $link = Url::query()->create([
                'url' => $url,
                'code' => $this->generateUniqueCode(),
                'clicks' => 0,
            ]);
        }

        return response()->json([
            'code' => $link->code,
            'short_url' => url($link->code),
        ]);
    }

    public function redirect(string $code): RedirectResponse|JsonResponse
    {
        $link = Url::query()
            ->where('code', $code)
            ->first();

        if (!$link) {
            return response()->json([
                'message' => 'Link not found',
            ], 404);
        }

        $link->increment('clicks');

        return redirect()->away($link->url, 302);
    }

    public function stats(string $code): JsonResponse
    {
        $link = Url::query()
            ->where('code', $code)
            ->first();

        if (!$link) {
            return response()->json([
                'message' => 'Link not found',
            ], 404);
        }

        return response()->json([
            'url' => $link->url,
            'code' => $link->code,
            'clicks' => $link->clicks,
            'created_at' => $link->created_at->toISOString(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Url $url)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Url $url)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Url $url)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Url $url)
    {
        //
    }
}
