<div>
    <form>
        <div class="form-group">
            <input type="search" class="form-control" name="search" wire:model.debounce.500ms="search" />
        </div>

        <button class="btn btn-primary" wire:click.prevent="changeOrder">Changer l'ordre</button>
    </form>

    <ul>
        @foreach($articles as $article )
        <li>
            {{ $article->title }}
            <button class="btn btn-danger btn-sm" wire:click.prevent="confirmDelete({{ $article->id }})">Suprimer</button>
        </li>
        @endforeach
    </ul>

    @if( $articleToDelete !== null )
        <div class="alert alert-danger">
            Êtes vous sûr de vouloir supprimer cet article ?
            <div class="text-center">
                <button class="btn btn-danger" wire:click.prevent="delete({{ $articleToDelete }})">Supprimer</button>
                <button class="btn btn-info" wire:click.prevent="cancelDelete">Annuler</button>
            </div>
        </div>
    @endif

    {{ $articles->links() }}

    <form wire:submit.prevent="submit" autocomplete="off">
        <div class="form-group">
            <label class="form-label">Commentaire</label>
            <textarea class="form-control" wire:model.debounce.500ms="comment"></textarea>
            @error('comment')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <label class="form-label">Votre email</label>
            <input type="email" class="form-control" wire:model.debounce.500ms="email" />
            @error('email')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success">Soumettre le commentaire</button>
        </div>
    </form>
</div>

@section('scripts')
    <script>
        Livewire.on('cancelEvent', () => window.alert('OK !'));
    </script>
@endsection
