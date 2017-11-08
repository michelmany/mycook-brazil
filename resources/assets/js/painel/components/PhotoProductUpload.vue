<template>
    <div id="boxAvatarPreview">

        <img v-if="this.url === null"
        class="rounded"
        id="photoPreview"
        src="/assets/img/no-image-products.jpg" 
        @click="chooseFile()"
        :class="{'pointer': file === null}">

        <img v-else
        class="rounded" 
        id="photoPreview"
        :src="this.url" 
        @click="chooseFile()" 
        :class="{'pointer': file === null}">

        <input id="sender" type="button" value="Clique para enviar" v-if="file !== null" class="btn btn-primary pointer" @click="sendFile()">
        <input type="file" id="fileUpload" @change="selectedFile($event)">
    </div>
</template>

<script>
    export default {
        props: [
        'photoUrl'
        ],
        data: function () {
            return {
                file: null
            }
        },
        computed: {
            url: function () {
                return this.photoUrl;
            }
        },
        methods: {
            chooseFile: function () {
                document.getElementById("fileUpload").click()
                this.$bus.$emit('product_image choose')
            },
            selectedFile: function ($event) {
                if ($event.target.files.length > 0) {
                    this.file = $event.target.files[0];

                    let reader = new FileReader()
                    reader.onload = function (e) {
                        document.getElementById("photoPreview").setAttribute('src', e.target.result);
                    }
                    reader.readAsDataURL(this.file);
                }
            },
            sendFile() {
                let url = '/api/admin/v1/products/photo/' + this.$route.params['id'];
                let formData = new FormData();
                formData.append('photo', this.file);

                document.getElementById("sender").setAttribute('disabled', true)
                document.getElementById("sender").setAttribute('value', 'Enviando...')

                window.axios.post(url, formData, {headers: {"Content-Type": "multipart/form-data"}})
                .then(() => {
                    document.getElementById("sender").setAttribute('value', 'Enviado!');
                    toastr.success('Imagem enviada com sucesso!');

                    setTimeout(() => {
                        this.file = null;
                        document.getElementById("sender").setAttribute('disabled', false);
                        document.getElementById("sender").setAttribute('value', 'Enviar');
                    }, 500);
                        //this.file = null;
                });
            }
        }
    }
</script>

<style scoped lang="scss">
    #fileUpload {
        display: none;
    }

    #boxAvatarPreview {
        position: relative;
        height: 145px;
        line-height: 145px;
        overflow: hidden;
        text-align: center;
        width: 342.5px;
        max-width: 100%;
        background-color: #F8F8F8;
        @media screen and (min-width: 375px) {
            height: 200px;
            line-height: 200px;
        }
    }

    #boxAvatarPreview:after {
        display: block;
        content: 'Imagem Produto';
        position: absolute;
        left: 10px;
        top: 10px;
        line-height: initial;
        padding: 10px;
        background-color: rgba(0, 0, 0, 0.7);
        color: #fff;
        opacity: 0;
    }

    #boxAvatarPreview:hover::after {
        opacity: 1;
    }

    #photoPreview {
        width: 342.5px;
        height: auto;
        margin:-100% 0;
        max-width: 100%;
    }

    #sender {
        position: absolute;
        right: 15px;
        bottom: 15px;
    }

    .pointer {
        cursor: pointer;
    }
</style>