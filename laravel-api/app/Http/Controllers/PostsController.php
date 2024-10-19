<?php

namespace App\Http\Controllers;

use App\Models\UserPost;
use App\Services\LikeManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostsController extends Controller
{
    public function getPosts(): JsonResponse
    {
        $userId = Auth::user()->getAuthIdentifier();

        $userPosts = UserPost::where('user_posts.user_id', $userId)
            ->leftJoin('likes_posts', function ($join) use ($userId) {
                $join->on('user_posts.id', '=', 'likes_posts.post_id');
                $join->where('likes_posts.user_id', $userId);
            })
            ->select('user_posts.*', 'likes_posts.post_id as is_liked')
            ->orderBy('user_posts.created_at', 'DESC')
            ->paginate(4);

        return new JsonResponse($userPosts);
    }

    public function getAllPosts(): JsonResponse
    {
        $userId = Auth::user()->getAuthIdentifier();

        $query = UserPost::with('user')
            ->with('user.profile')
            ->select('user_posts.*', 'likes_posts.post_id as is_liked');

        if ($userId) {
            $query->leftJoin('likes_posts', function ($join) use ($userId) {
                $join->on('user_posts.id', '=', 'likes_posts.post_id');
                $join->where('likes_posts.user_id', $userId);
            })
            ->addSelect('likes_posts.post_id as is_liked');
        }

        $allPosts = $query->orderBy('user_posts.created_at', 'DESC')->paginate(5);

        return new JsonResponse($allPosts);
    }

    public function createPost(Request $request): Response
    {
        $request->validate([
            'text' => 'required|string|min:1|max:500'
        ]);

        $user = Auth::user()->getAuthIdentifier();

        $userPost = new UserPost();
        $userPost->text = $request->text;
        $userPost->user_id = $user;

        $userPost->save();

        return new Response(Response::HTTP_NO_CONTENT);
    }

    public function deletePost(string $id): Response
    {
        $userPost = UserPost::find($id);

        $userPost->delete();

        return Response(Response::HTTP_NO_CONTENT);
    }

    public function updatePost(string $id, Request $request): Response
    {
        $request->validate([
            'text' => 'required|string|min:1|max:500'
        ]);

        $userPost = UserPost::find($id);
        $userPost->text = $request->input('text');

        $userPost->save();

        return Response(Response::HTTP_NO_CONTENT);
    }

    public function toggleLike(string $id): JsonResponse
    {
        $userId = Auth::user()->getAuthIdentifier();
        $post = UserPost::find($id);

        if (!$post) {
            throw new NotFoundHttpException();
        }

        $likeManager = new LikeManager($userId);
        $isLiked = $likeManager->isPostLiked($post);

        if ($isLiked) {
            $likeManager->unlikePost($post);

            return new JsonResponse(['isLiked' => false]);
        }

        $likeManager->likePost($post);

        return new JsonResponse(['isLiked' => true]);
    }
}
