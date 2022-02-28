<?php

namespace Modules\Blog\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use InvalidArgumentException;
use Modules\Auth\Facade\Auth;
use Modules\Blog\Domain\Models\Value\CommentId;
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
     * @param string $id
     * @return Response
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user($request);
        if(!$user) {
            abort(401);
        }
        
        try {
            $comment = $this->commentRepository->findById(new CommentId($id));
            if(!$comment) {
                abort(404);
            }
        } catch(InvalidArgumentException $e) {
            abort(404);
        }

        if (!$comment->getUserId()->equals($user->getUserId())) {
            abort(403);
        }

        $comment_content = $request->validate(['comment' => 'required'])['comment'];
        try {
            $comment->editComment($comment_content);
            $this->commentRepository->save($comment);

            return response()->json(['status' => 'success', 'data' => null]);
        } catch (\Exception $e) {
            if(env('APP_DEBUG') == 'true') {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
            return response()->json(['status' => 'error', 'message' => 'Internal server error']);
        } 
    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @param string $id
     * @return Response
     */
    public function destroy(Request $request, string $id)
    {
        $user = Auth::user($request);
        if(!$user) {
            abort(401);
        }
        
        try {
            $comment = $this->commentRepository->findById(new CommentId($id));
            if(!$comment) {
                abort(404);
            }
        } catch(InvalidArgumentException $e) {
            abort(404);
        }

        if (!$comment->getUserId()->equals($user->getUserId()) && !$user->isAdmin()) {
            abort(403);
        }

        try {
            $this->commentRepository->delete($comment);

            return response()->json(['status' => 'success', 'data' => null]);
        } catch (\Exception $e) {
            if(env('APP_DEBUG') == 'true') {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
            return response()->json(['status' => 'error', 'message' => 'Internal server error']);
        } 
    }
}
