<template>
    <section class="cardapio">
        <div class="cardapio__item">
            <div class="row px-3">
                <div class="col-md-3 col-lg-5">
                    <div class="cardapio__image mb-3" style="background-image: url('/assets/img/hero-02.jpg')"></div>
                </div>
                <div class="col-md-9 col-lg-7">
                    <div>
                        <h5 class="cardapio__title text-uppercase">Feijoada da Vivien</h5>
                        <div class="cardapio__desc">Saborosa feijoada feita com carnes e embutidos de qualidade acompanha arroz branco, farofa, couve refogada e laranja.Saborosa feijoada feita com carnes e embutidos de qualidade acompanha arroz branco, farofa, couve refogada e laranja.</div>
                        <span class="cardapio__serve badge badge-primary">Serve 1</span>
                        <span class="cardapio__serve badge badge-default">Sex, Sab, Dom</span>
                    </div>
                </div>
            </div>
            <div class="row no-gutters">
                <div class="col-md-12 px-0">
                    <div class="cardapio__footer d-flex justify-content-between align-items-center flex-wrap mt-3">
                        <div class="cardapio__price">R$ 35,00</div>
                        <button class="btn btn-outline-primary text-uppercase" @click="showDays = !showDays">Agendar</button>
                       
                        <div class="cardapio__time">11h30 às 18h00</div>
                    </div>
                    <transition name="slide-fade">
                        <div class="cardapio__days" v-show="showDays">
                            <li v-for="weekDay in weekDays" class="text-uppercase" @click="selectTime(weekDay)">{{ weekDay }}</li>
                        </div>
                    </transition>

                </div>
            </div>

            <sweet-modal blocking ref="modalTime">
                <div class="text-uppercase mb-3">Você receberá o pedido no seu endereço</div>

                <div class="card mb-3">
                    <div class="card-block">
                        <h6 class="card-title text-uppercase">Endereço</h6>
                        <p class="card-text"><small>Estrada Francisco da Cruz Nunes 1234, Piratininga - Niterói/RJ</small></p>
                        <a href="#" class="btn btn-outline-secondary btn-sm">Trocar endereço</a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-block">
                        <h6 class="card-title text-uppercase">Informe o horário</h6>
                        <h4 class="card-text">19:30 &#8226; 20:00</h4>
                    </div>
                </div>
                
                <button slot="button" class="btn btn-submit-orange" @click="closeModalAndSubmit()">Continuar</button>

            </sweet-modal>


        </div>
    </section>
</template>

<script>

    export default {
        data() {
            return {
                showDays: false,
                weekDays: [],
                selectedDay: ""
            }
        },
        watch: {
            selectedDay(theDay) {
                this.selectedDay = theDay;

                // Todo: get fulldate from click to use into the cart.
            }
        },
        methods: {
            calculateWeekDaysArray() {
                this.weekDays = [
                    this.$moment().format('ddd'),
                    this.$moment().add(1, 'days').format('ddd'),
                    this.$moment().add(2, 'days').format('ddd'),
                    this.$moment().add(3, 'days').format('ddd'),
                    this.$moment().add(4, 'days').format('ddd'),
                    this.$moment().add(5, 'days').format('ddd'),
                    this.$moment().add(6, 'days').format('ddd')
                ]

                this.weekDays[0] = "HOJE";

                console.log(this.weekDays);

                // Todo: usar https://github.com/phoenixwong/vue2-timepicker no painel para selecionar os horários.

               // alert(this.$moment().add(1, 'days').format('ddd'));
               // console.log(this.$moment().format('dddd'));
            },
            selectTime(weekday) {
                this.selectedDay = weekday;
                this.$refs.modalTime.open()
            },
            closeModalAndSubmit(ref) {
                this.$refs.modalTime.close()
                //add to the cart
            }
        },
        mounted() {
            this.calculateWeekDaysArray();
        }

    }
</script>

<style>
/* Enter and leave animations can use different */
/* durations and timing functions.              */
.slide-fade-enter-active {
  transition: all .3s ease;
}
.slide-fade-leave-active {
  transition: all .3s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-fade-enter, .slide-fade-leave-to
/* .slide-fade-leave-active for <2.1.8 */ {
  transform: translateY(20px);
  opacity: 0;
}
</style>