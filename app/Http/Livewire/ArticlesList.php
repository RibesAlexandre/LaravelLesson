<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Livewire\Component;
use Livewire\WithPagination;

class ArticlesList extends Component
{
    use WithPagination;

    public string $sortBy = 'created_at';

    public string $sortOrder = 'DESC';

    public string $search = '';

    public string $comment = '';

    public string $email = '';

    protected $queryString = [
        'search'    =>  ['except' => '']
    ];

    public array $rules = [
        'comment'   =>  ['required', 'min:3'],
        'email'     =>  ['required', 'email', 'min:5']
    ];

    protected string $paginationTheme = 'bootstrap';

    public bool $deleteConfirm = false;

    public ?int $articleToDelete = null;

    public function changeOrder()
    {
        $this->sortOrder = $this->sortOrder === 'ASC' ? 'DESC' : 'ASC';
        $this->emitTo('alert', 'onAlert', [
            'message'   =>  'Ordre changé',
            'order'     =>  $this->sortOrder,
        ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        $articlesQuery = Article::with('user')
            ->orderBy($this->sortBy, $this->sortOrder);

        if( $this->search !== '') {
            $articlesQuery->where('title', 'LIKE', '%' . $this->search . '%');
        }

        $articles = $articlesQuery->paginate(5);
        return view('livewire.articles-list', compact('articles'));
    }

    public function submit()
    {
        $this->validate();
        $this->emitTo('alert', 'onAlert', [
            'type'      =>  'warning',
            'message'   =>  'Commentaire validé',
        ]);
        $this->reset(['email', 'comment']);
    }

    public function confirmDelete($id)
    {
        $this->articleToDelete = $id;
    }

    public function cancelDelete()
    {
        $this->reset('articleToDelete');
        $this->emitTo('alert', 'onAlert', [
            'type'      =>  'warning',
            'message'   =>  'Suppression annulé',
        ]);
        $this->emit('cancelEvent');
    }

    public function delete($id)
    {
        $article = Article::find($id);
        if( !$article ) {
            $this->emitTo('alert', 'onAlert', [
                'type'      =>  'danger',
                'message'   =>  "L'article n'existe pas"
            ]);

            return;
        }

        $article->delete();
        $this->emitTo('alert', 'onAlert', [
            'type'      =>  'success',
            'message'   =>  "L'article a été suprimé"
        ]);
        $this->reset('articleToDelete');
    }
}
