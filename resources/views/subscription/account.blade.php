<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Minhas Assinatura') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                   @if (Auth::user()->subscription('default'))
                        @if (Auth::user()->subscription('default')->onGracePeriod())
                            <a href="{{route('subscriptions.resume')}}" class="btn btn-success">Reativar Assinatura</a>
                        @else              
                            <a href="{{route('subscriptions.cancel')}}" class="btn btn-danger">Cancelar Assinatura</a>
                        @endif
                   
                   @else
                   [Não é assinante]
                   @endif
            </div>
        </div>
    </div>

    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Preço</th>
                                <th>Download</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                            <tr>
                                <td>{{$invoice->date()->toFormattedDateString()}}</td>
                                <td>{{$invoice->total()}}</td>
                                <td>
                                    <a href="{{route('subscriptions.invoice.download',$invoice->id)}}" class="btn btn-info">Download</a>
                                </td>
                               
                            </tr>
                                
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
