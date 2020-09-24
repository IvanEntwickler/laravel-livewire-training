<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Comments extends Component
{
    use WithPagination;
    use WithFileUploads;

    // protected $listeners = ['fileUpload'=>'handleFileUpload'];
    public $newComment;
    public $image;

    // public function handleFileUpload($imageData){
    //     $this->image = $imageData;
    // }
    // updated lifecycle fires when component is updated
    // delivers real-time data
    public function updated($field)
    {
        $this->validateOnly($field, [
            'newComment'=>'required|max:255'
        ]);
    }

    // validates, creates and then push it to the collection
    public function addComment()
    {

        $this->validate([
            'newComment'=>'required|max:255',
            'image'=>'image'
        ]);
        $this->image->storeAs('images', $this->image->getClientOriginalName());
        Comment::create([
            'body'=>$this->newComment,
            'image_path'=>$this->image->getClientOriginalName(),
            'user_id'=>1
        ]);
        $this->newComment = "";
        $this->image = null;
        session()->flash('comment-created', 'Comment was created');

    }

    // deletes comment by Id in database and in the view
    public function deleteComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $comment->delete();
        session()->flash('comment-deleted', 'Comment was deleted');
    }
    public function render()
    {
        return view('livewire.comments', [
            'comments'=>Comment::latest()->paginate(2)
            ]);
    }
}
