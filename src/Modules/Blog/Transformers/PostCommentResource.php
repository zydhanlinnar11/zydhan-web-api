<?php

namespace Modules\Blog\Transformers;

use DateTimeZone;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;
use Modules\Blog\Domain\Models\Entity\Comment;

class PostCommentResource extends JsonResource
{
    /**
     * Constructor.
     *
     * @param  \Modules\Blog\Domain\Models\Entity\Comment[] $comments
     * @param  \Modules\Auth\Domain\Repositories\UserRepositoryInterface $userRepository
     */
    public function __construct(
        private $comments,
        private UserRepositoryInterface $userRepository
    ) { }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $arr = [];

        foreach($this->comments as $comment) {
            $user = $this->userRepository->findById($comment->getUserId());

            array_push($arr, [
                'id' => $comment->getId()->toString(),
                'comment' => $comment->getComment(),
                'createdAt' => $comment->getCreatedAt()->setTimezone(new DateTimeZone('Asia/Jakarta'))->format('l, F d, Y'),
                'user_name' => $user->getName(),
            ]);
        }

        return $arr;
    }
}
