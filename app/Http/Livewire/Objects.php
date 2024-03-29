<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use App\Repositories\ItemRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Objects extends Component
{
    public ?Category $category = null;
    public ?User $user = null;
    public $amount;
    public $isBot;
    public $totalItems;
    private $itemRepository;

    public $selected;

    protected $listeners = ['setSelected'];

    public function setSelected($selected)
    {
        $this->selected = $selected;
    }

    public function boot()
    {
        $this->itemRepository = App::make(ItemRepository::class);
    }

    public function mount($isBot = false):void
    {
        $this->isBot = $isBot;
        $this->isBot ? $this->amount = 16 : $this->amount = 32;

        if($this->category) {
            if(Session::has('filter'))
                $this->selected = Session::pull('filter');
            else
                $this->selected['category'] = $this->category->toArray();
        }

        if($this->user)
            $this->selected['user'] = $this->user->toArray();
    }

    public function render()
    {
        $this->totalItems = $this->itemRepository->getItemsCount($this->selected);

        $items = $this->itemRepository->getItems($this->amount, $this->selected);

        $this->selected['min_price'] = $items->min('price');

        $this->selected['max_price'] = $items->max('price');

        return view('livewire.objects', [
            'items' => $items,
        ]);
    }

    public function load()
    {
        $this->amount += 32;
    }
}
