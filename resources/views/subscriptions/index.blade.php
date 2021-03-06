<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div id="show-errors" style="display: none">

                    </div>
                    <p>Assinando o {{$plan->name}}</p>
                  <form action="{{route('subscriptions.store')}}" method="post" id="form" >
                      @csrf
                      <input type="hidden" name="stripe_id" value="{{$plan->stripe_id}}">
                      <div class="col-span-6 col-md-12 py-2">
                   
                        <input type="text" name="card-holder-name" id="card-holder-name" placeholder="Dono do Cartão" class="form-control ">
                       </div>
                       <div class="col-span-6 sm:col-span-4 py-2">
                            <div id="card-element"></div>
                        </div>
                    <button type="submit" id="card-button"  data-secret="{{$intent->client_secret}}" class="btn btn-success" >Enviar</button>


                  </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
   const stripe =  Stripe("{{config('cashier.key')}}");
   const elements = stripe.elements();
   const cardElement = elements.create('card');
   cardElement.mount('#card-element')

   //super script
   const form = document.getElementById('form');
   const cardHolderName = document.getElementById('card-holder-name');
   const cardButton = document.getElementById('card-button');
   const clientSecret = cardButton.dataset.secret
   const showErrors = document.getElementById('show-errors')

   form.addEventListener('submit', async (e)  =>{
       e.preventDefault();

       
       cardButton.classList.add('cursor-not-allowed')
       cardButton.firstChild.data = 'Validando'

       showErrors.innerText = ''
       showErrors.style.display = 'none'
      



     const {setupIntent, error} =  await  stripe.confirmCardSetup(
           clientSecret, {
            payment_method:{
               card:cardElement,
               billing_details: {
                   name: cardHolderName.value
                }
            }
        }
    );

       if (error) {           
         if(error.type == 'validation_error')

         showErrors.style.display = 'block' 
         showErrors.innerText = (error.type == 'validation_error' ? error.message :  'Dados invalidos , verifique novamente')
         cardButton.classList.remove('cursor-not-allowed')
         return;

       }

       let token = document.createElement('input')
       token.setAttribute('type','hidden')
       token.setAttribute('name','token')
       token.setAttribute('value',setupIntent.payment_method)
       form.appendChild(token)
      
       form.submit();
       


   })

</script>