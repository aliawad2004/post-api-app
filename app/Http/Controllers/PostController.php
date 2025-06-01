<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Repositories\PostRepositoryInterface;
use Symfony\Component\HttpFoundation\Response as HttpStatus; 

class PostController extends Controller
{
    protected $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    
    public function index()
    {
        $posts = $this->postRepository->all();
        return response()->json(['success' => true, 'data' => $posts], HttpStatus::HTTP_OK);
    }

    
    public function store(StorePostRequest $request)
    {
        $post = $this->postRepository->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Post created successfully!',
            'data' => $post
        ], HttpStatus::HTTP_CREATED);
    }

   
    public function show(string $id)
    {
        $post = $this->postRepository->find($id);

        if (!$post) {
            return response()->json(['success' => false, 'message' => 'The post is not available'], HttpStatus::HTTP_NOT_FOUND);
        }

        return response()->json(['success' => true, 'data' => $post], HttpStatus::HTTP_OK);
    }

   
    public function update(UpdatePostRequest $request, string $id)
    {
        $updated = $this->postRepository->update($id, $request->validated());

        if (!$updated) {
            return response()->json(['success' => false, 'message' => 'The post does not exist or no changes have been made.'], HttpStatus::HTTP_NOT_FOUND);
        }

        $post = $this->postRepository->find($id); 
        return response()->json([
            'success' => true,
            'message' => 'Post updated successfully!',
            'data' => $post
        ], HttpStatus::HTTP_OK);
    }

  
    public function destroy(string $id)
    {
        $deleted = $this->postRepository->delete($id);

        if (!$deleted) {
            return response()->json(['success' => false, 'message' => 'The post is not available'], HttpStatus::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully!'
        ], HttpStatus::HTTP_NO_CONTENT);
    }
}