<?php

namespace App\Services;

use App\Models\Comment;

class CommentService extends BaseService
{
    protected $movieService;
    protected $showService;
    protected $episodeService;

	public function __construct(MovieService $movieService, ShowService $showService, EpisodeService $episodeService)
	{
        $this->movieService = $movieService;
        $this->showService = $showService;
        $this->episodeService = $episodeService;
	}

	public function getAll()
	{
        $comments = Comment::all();
        $data = [];
        foreach ($comments as $comment) {
            array_push($data, $this->getDetail($comment->id));
        }
        return $data;
	}

	public function getById($id)
	{
		return Comment::find($id);
    }
    
    public function getDetail($id)
    {
        $comment = Comment::find($id);
        $c_type = $comment->content_type;
        $c_id = $comment->content_id;
        if ($c_type == 'movie') 
            $content = $this->movieService->getById($c_id);
        else if ($c_type == 'show')
            $content = $this->showService->getById($c_id);
        else if ($c_type == 'episode')
            $content = $this->episodeService->getById($c_id);
        if (!$content)
            return null;
        $comment->title = $content->title ? $content->title : $content->name;
        $comment->author = $comment->author_record->profile;
        return $comment;
    }
    
    public function getByCTInfo($c_type, $c_id)
    {
        $comments = Comment::where(['content_type' => $c_type, 'content_id' => $c_id])->get();
        $data = [];
        foreach ($comments as $comment) {
            if ($detail = $this->getDetail($comment->id))
                array_push($data, $detail);
        }
        return $data;
    }
	public function create($data)
	{
		return Comment::create($data);
	}

	public function update($id, $data)
	{
		$category = $this->getById($id);
		return $category->update($data);
	}

	public function delete($id)
	{
		$category = $this->getById($id);
		return $category->delete();
	}

	public function search()
	{

	}
}
