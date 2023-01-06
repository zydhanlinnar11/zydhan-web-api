<?php

namespace Modules\Guestbook\Http\Controllers;

use App\Models\Guestbook;
use Database\Factories\GuestbookFactory;
use Illuminate\Routing\Controller;
use Modules\Guestbook\Http\Requests\StoreGuestbookRequest;

class GuestbookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $guestbooks = Guestbook::with('user')
                        ->orderByDesc('created_at')
                        ->get();
        $data = [];
        /** @var Guestbook $guestbook */
        foreach($guestbooks as $guestbook) {
            $data[] = [
                'id' => $guestbook->getId(),
                'user' => $guestbook->getUser()->getName(),
                'content' => $guestbook->getContent(),
                'createdAt' => $guestbook->getCreatedAt(),
            ];
        }

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Modules\Guestbook\Http\Requests\StoreGuestbookRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreGuestbookRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        GuestbookFactory::createNewGuestbook(
            userId: $user->getId(),
            content: $request->getGuestbookContent()
        );

        return response()->json([], 201);
    }
}
