<div x-data="{open:false}">
    <div>
        @auth
            @if($inWishlist)
                <button wire:click.prevent="unwish">
                    <x-icons.wishlist class="fill-black h-6 w-6" />
                </button>
            @else
                <button wire:click.prevent="wish">
                    <x-icons.wishlist class="fill-black h-6 w-6" />
                </button>
            @endif
        @else
            <button x-on:click.prevent="window.livewire.emitTo('modals.login', 'show')">
                <x-icons.wishlist class="fill-black h-6 w-6" />
            </button>
        @endauth
    </div>
</div>
