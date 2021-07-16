<template>

       <form class="form mt-10" action="#" @submit.prevent="sendContact" >
                <div class="form__row">
                    <div class="form__input-group">
                        <div class="form__label-group">
                            <p><label for="name" class="">Nome <abbr title="Obrigatório">*</abbr></label>
                            </p>
                        </div><input v-model="FormData.name" id="name" autocomplete="false" tabindex="0" class="form__input">
                    </div>
                </div>
                <div class="form__row">
                    <div class="form__input-group">
                        <div class="form__label-group">
                            <p><label for="email" class="">Email <abbr title="Obrigatório">*</abbr></label>
                            </p>
                        </div><input v-model="FormData.email" id="email" name="email" autocomplete="false" tabindex="0"
                            class="form__input" required>
                    </div>
                </div>
                <div class="form__row">
                    <div class="form__input-group">
                        <div class="form__label-group">
                            <p><label class="subject" >Assunto 
                                <abbr title="Obrigatório">*</abbr>
                                </label>
                            </p>
                        </div><input v-model="FormData.subject" id="subject" name="subject" autocomplete="false" tabindex="0"
                            class="form__input" required>
                    </div>
                </div>

                <div class="form__row">
                    <div class="form__input-group">
                        <div class="form__label-group">
                            <p><label for="message" class="bg-white text-gray-600 px-1">Mensagem <abbr
                                        title="Obrigatório">*</abbr></label></p>
                        </div><textarea v-model="FormData.message" id="message" name="message" class="form__input" rows="4"
                            required></textarea>
                    </div>
                </div>
                <div class="mt-6 pt-3 text-center">
                    <button 
                        type="submit"
                        :disabled="preloader"
                        class="button button--filled button--primary">
                        <span v-if="preloader">Enviando...</span>
                        <span v-else>Enviar.</span>
                        </button>
                </div>
                <div v-if="messageSuccess" class="alert-success">{{messageSuccess}}</div>
                <div v-if="messageFail"  class="alert-danger">{{messageFail}}</div>
            </form>
    

</template>
<script>



export default ({
    data() {
        return {
            preloader: false,
            FormData: {
                name:'',
                email:'',
                subject:'',
                message:'',

            },
            messageSuccess: "",
            messageFail: "",
           

        }
    },

    methods: {
        sendContact() {
            this.messageSuccess = '';
            this.messageFail = '';

            this.preloader = true
            axios.post('/api/contact', this.FormData)
            .then(response=> this.messageSuccess = "Contato enviado com sucesso")
            .catch(error => this.messageFail= "Contato falhou ao enviar")
            .finally(()=>{
                this.preloader = false
                this.reset()

            } )

        }
    },
  
})
</script>
