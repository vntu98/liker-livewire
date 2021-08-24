<?php

namespace App\Http\Livewire;

use App\Events\PostLiked;
use Livewire\Component;

class Post extends Component
{
    public $post;

    public function getListeners()
    {
        return [
            'echo:posts.' . $this->post->id . ',PostLiked' => 'refershPost',
            'echo:users.' . $this->post->user->id . ',ProfilePhotoUpdated' => 'refershPost',
        ];
    }

    public function storeLike()
    {
        $like = $this->post->likes()->make();
        $like->user()->associate(auth()->user());

        $like->save();

        broadcast(new PostLiked($this->post));
    }

    public function refershPost($post)
    {
        $this->post = $this->post->fresh();
    }

    public function render()
    {
        return view('livewire.post');
    }
}
