<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Auth\Facade\Auth;
use Modules\Blog\Domain\Models\Entity\Comment;
use Modules\Blog\Domain\Repositories\CommentRepositoryInterface;

class CommentController extends Controller
{
    public function __construct(
        private CommentRepositoryInterface $commentRepository
    ) { }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Comment $comment
     * @return Response
     */
    public function update(Request $request, Comment $comment)
    {
        $user = Auth::user($request);

        if (!$comment->getUserId()->equals($user->getUserId())) {
            abort(403);
        }

        $comment_content = $request->validate(['comment' => 'required'])['comment'];
        $comment->editComment($comment_content);
        $this->commentRepository->save($comment);

        return response()->json(null);
    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @param Comment $comment
     * @return Response
     */
    public function destroy(Request $request, Comment $comment)
    {
        $user = Auth::user($request);

        if (!$comment->getUserId()->equals($user->getUserId()) && !$user->isAdmin()) {
            abort(403);
        }
        $this->commentRepository->delete($comment);

        return response()->json(null);
    }
}
