<div class="flex justify-center">
    <div class="w-6/12">
        <h1 class="my-10 text-3xl">Comments</h1>
        {{-- <section>
            @if($image)
            <img src="{{ $image }}" width="200">
            @endif
            <input
            type="file"
            id='image'
            wire:change="$emit('fileChoosen')"
            >
        </section> --}}
        @error('newComment')
        <span class="text-red-500 text-xs">
            {{ $message }}
        </span>
        @enderror
        <div>
            @if(session()->has('comment-deleted'))
                <span class="p-3 bg-red-300 text-red-800 rounded shadow-sm">
                    {{ session('comment-deleted') }}
                </span>
            @endif
            @if(session()->has('comment-created'))
                <span class="p-3 bg-green-300 text-green-800 rounded shadow-sm">
                    {{ session('comment-created') }}
                </span>
            @endif
        </div>
        <form
        class="my-4 flex-column"
        wire:submit.prevent="addComment">
        @if ($image)
            Image Preview:
            <img src="{{ $image->temporaryUrl() }}" width="200">
        @endif
            <input
            type="file"
            wire:model="image">
            <input
            type="text"
            class="w-full rounded border shadow p-2 mr-2 my-2
            @error('newComment') border-red-500 @enderror"
            placeholder="What's in your mind."
            wire:model.debounce.500ms="newComment">
            <div class="py-2">
                <button
                type="submit"
                class="p-2 bg-blue-500 w-20 rounded shadow text-white"
                >Add</button>
            </div>
        </form>
        @foreach($comments as $comment)
        <div class="rounded border shadow p-3 my-2">
            <div class="flex-column justify-start my-2">
                <p class="font-bold text-lg">From: {{$comment->user->name}}</p>
                @if($comment->image_path)
                <div class="rounded border shadow p-3 my-2">
                    <img src="{{ 'images/'.$comment->image_path}}" width="200">
                </div>
                @endif
                <p class="mx-3 py-1 text-xs text-gray-500 font-semibold">
                    {{$comment->created_at->diffForHumans()}}
                </p>

            </div>
            <form
            class="flex justify-end my-2"
            wire:submit.prevent="deleteComment({{ $comment->id }})">
                <button
                class="bg-red-500 w-10 rounded shadow hover:opacity-75 "
                type="submit"
                >x</button>
            </form>
            <div class="rounded border shadow p-3 my-2">
            <p class="text-gray-800">{{$comment->body}}</p>
            </div>
        </div>
        @endforeach
        <div>
            {{ $comments->links() }}
        </div>
    </div>
</div>
{{-- <script>
    window.livewire.on('fileChoosen', () => {
        let inputFileField = document.getElementById('image');
        let file = inputFileField.files[0];
        let reader = new FileReader();
        reader.onloadend = () => {
            window.livewire.emit('fileUpload', reader.result)
        };
        reader.readAsDataURL(file);
    });
</script> --}}
