<template>
    <div id="boxAvatarPreview">
        <img v-if="this.url"
        class="rounded"
        id="avatarPreview"
        src="/assets/img/not-found-avatar.png"
        :src="this.url"
        @click="chooseFile()"
        :class="{'pointer': file === null}">

        <img v-else
        class="rounded"
        id="avatarPreview"
        src="/assets/img/not-found-avatar.png"
        @click="chooseFile()"
        :class="{'pointer': file === null}">

        <input id="sender" type="button" value="enviar" v-if="file !== null" class="btn btn-primary pointer" @click="sendFile()">
        <input type="file" id="fileUpload" @change="selectedFile($event)">
    </div>
</template>

<script>
    export default {
        props: [
        'photoUrl',
        'actionUrl'
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
                this.$bus.$emit('avatar choose')
            },
            selectedFile: function ($event) {
                if ($event.target.files.length > 0) {
                    this.file = $event.target.files[0];

                    let reader = new FileReader()
                    reader.onload = function (e) {
                        document.getElementById("avatarPreview").setAttribute('src', e.target.result);
                    }
                    let readAsDataUrl = reader.readAsDataURL(this.file);
                    this.$bus.$emit('avatar select', readAsDataUrl)
                }
            },
            sendFile() {
                let url = this.actionUrl ? this.actionUrl : '/api/admin/v1/users/avatar/' + this.$route.params['id'];
                let formData = new FormData();
                formData.append('avatar', this.file);

                document.getElementById("sender").setAttribute('disabled', true)
                document.getElementById("sender").setAttribute('value', 'Enviando...')

                window.axios.post(url, formData, {headers: {"Content-Type": "multipart/form-data"}})
                .then(() => {
                    document.getElementById("sender").setAttribute('value', 'Enviado!');

                    setTimeout(() => {
                        this.file = null;
                        document.getElementById("sender").setAttribute('disabled', false);
                        document.getElementById("sender").setAttribute('value', 'Enviar');
                    }, 500);
                    this.$bus.$emit('avatar send', formData)
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
        height:200px;
        line-height:200px;
        overflow:hidden;
        text-align:center;
        width:200px;
        background-color: #F8F8F8;
    }

    #boxAvatarPreview:after {
        display: block;
        content: 'Enviar foto';
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

    #avatarPreview {
        width: 200px;
        height: auto;
        margin:-100% 0;
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