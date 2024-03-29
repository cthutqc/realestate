<div x-data="{open:false}">
    <div
        x-show="open"
        x-transition:enter="transition-all-600ms"
        x-transition:enter-start="translate-left-100%"
        x-transition:enter-end="translate-0"
        x-transition:leave="transition-all-600ms"
        x-transition:leave-start="translate-0"
        x-transition:leave-end="translate-left-100%"
        x-trap.noscroll.inert="open"
        class="offcanvas offcanvas-left fixed left-0 inset-y-0 block bg-white w-3/4 shadow-lg sm:w-[400px] py-20 px-2 md:px-10 z-[999]"
    >
        @if($offCanvasItem)
            <div>
                <button @click="open = false" class="absolute top-2 w-8 h-8 right-4 modal-close text-xl"><x-icons.close class="w-8 h-8"/></button>
                @include('items.item', ['item' => $offCanvasItem])
            </div>
        @endif
    </div>
    <div x-data="{itemMap: null}"
         wire:ignore
         x-init="
         document.addEventListener('DOMContentLoaded', function() {
             ymaps.load('https://api-maps.yandex.ru/2.1/?lang=ru_RU')
                          .then(ymaps => {
                            const itemMap = new ymaps.Map($refs.container, {
                                center: [54.735152, 55.958736],
                                zoom: 10,
                                controls: []
                            })
                            let objectManager = new ymaps.ObjectManager({ clusterize: true });
                            let objects = [];
                            @foreach($items as $item)
                                objects.push({
                                    type: 'Feature',
                                    id: {{$item->id}},
                                    geometry: {
                                        type: 'Point',
                                        coordinates: [{{$item->latitude}}, {{$item->longitude}}]
                                    },
                                    options: {
                                        preset: 'islands#dotIcon',
                                        iconColor: '#EF4444',
                                    }
                                });
                            @endforeach

                            objectManager.add(objects);
                            itemMap.geoObjects.add(objectManager);

                            itemMap.geoObjects.events.add('click', function (e) {
                                let objectId = e.get('objectId');
                                open = true;
                                $wire.call('showOffCanvasItem', objectId);
                                itemMap.panTo(objectManager.objects.getById(objectId).geometry.coordinates, {useMapMargin: true});
                            });
                          }).catch(error => console.log('Failed to load Yandex Maps', error));
         });"
    >
        <div id="map" class="w-full h-screen relative" x-ref="container">
            <div class="absolute top-2 right-2 z-10 flex">
                <div class="relative rounded-l-md bg-white w-full lg:w-max whitespace-nowrap">
                    <button class="flex items-center p-3 px-10 m-auto">
                        <x-icons.filter class="h-4 w-auto" />
                        <span>Фильтр</span>
                    </button>
                </div>
                <a href="/categories/{{$this->selected['category']['slug']}}"
                   class="w-full lg:w-max relative p-4 bg-slate-800 rounded-r-md space-x-1 text-white flex items-center border-y border-slate-800 justify-center whitespace-nowrap"
                >
                    <x-icons.lists class="h-5 w-auto fill-white" />
                    <span>Списком</span>
                </a>
            </div>
        </div>
    </div>
</div>
