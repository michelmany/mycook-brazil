<template>
    <section class="cardapio">

        <vue-loading v-show="loading" type="bubbles" color="#F95700" :size="{ width: '50px', height: '50px' }" key="1"></vue-loading>

        <transition-group name="fade">
            <div class="cardapio__item" v-for="(item, index) in items" :key="index">
                <div class="row px-3">
                    <div class="col-md-3 col-lg-5">
                        <div class="cardapio__image mb-3" style="background-image: url('/assets/img/hero-02.jpg')"></div>
                    </div>
                    <div class="col-md-9 col-lg-7">
                        <div>
                            <h5 class="cardapio__title text-uppercase">{{ item.name }}</h5>
                            <div class="cardapio__desc">{{ item.desc }}</div>
                            <span class="cardapio__serve badge badge-primary">Serve {{ item.serve }}</span>
                            <!-- To do: Pegar os dias que tem times setados e mostrar no span abaixo -->
                            <span class="cardapio__serve badge badge-default">Sex, Sab, Dom</span>
                        </div>
                    </div>
                </div>
                <div class="row no-gutters">
                    <div class="col-md-12 px-0">
                        <div class="cardapio__footer d-flex justify-content-between align-items-center flex-wrap mt-3">
                            <div class="cardapio__price">R$ {{ item.price }}</div>
                            <button class="btn btn-outline-primary text-uppercase" @click="openDays(index, $event)">{{ btnLabel }}</button>
                           
                            <!-- To do: Pegar os times de todos os dias (start_time and end_time) e mostrar na div abaixo o menor e o maior horário -->
                            <div class="cardapio__time">11h30 às 18h00</div>
                        </div>
                        <transition name="slide-fade" mode="in-out">
                            <div class="cardapio__days" v-show="index == itemIndex" v-if="showDays">
                                <li v-for="weekDay in item.extras" class="text-uppercase" @click="selectDate(weekDay)">{{ weekDay.date }}</li>
                            </div>
                        </transition>

                    </div>
                </div>
            </div>

            <div v-if="items.length == 0" :key="1">
                <div class="alert alert-warning" role="alert">
                    Nenhum produto cadastrado no cardápio!
                </div>
            </div>
        </transition-group>
            
        <sweet-modal ref="modalTime">
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
                    <h4 class="card-text">
                    <!-- <i class="fa fa-arrow-circle-o-left"></i> -->
                    
                    <div class="form-group">
                        <select class="form-control" id="exampleSelect1" v-model="selectedTime">
                            <option disabled value="">Clique para selecionar</option>
                            <option v-for="times in product.times">{{ formatTime(times) }} ~ {{  formatTimeMore30(times) }}</option>
                            <!-- <option v-for="times in product.times">{{ moment(times) }} ~ {{  moment30more(times) }}</option> -->
                        </select>
                    </div>
                    <!-- <i class="fa fa-arrow-circle-o-right"></i> -->
                    </h4>
                </div>
            </div>
            
            <button slot="button" class="btn btn-submit-orange" @click="closeModalAndSubmit()">Continuar</button>
        </sweet-modal>

    </section>
</template>

<script>

    import vueLoading from 'vue-loading-template'
    import Moment from 'moment';
    import { extendMoment } from 'moment-range';
    const moment = extendMoment(Moment);
    import { HttpService } from '../../services/httpService';
    let httpService = new HttpService();

    export default {
        data() {
            return {
                btnLabel: "Adicionar",
                loading: false,
                showDays: false,
                itemIndex: '',
                weekDays: [],
                now: '',
                selectedTime: '',
                selectedDay: '',
                items: {
                },
                product: {
                    times: []
                }
            }
        },
        props: ["chefId"],
        watch: {
            weekDays(theDay) {

                // Todo: get fulldate from click to use into the cart.
            }
        },
        methods: {
            getProducts() {
                this.loading = true;

                setTimeout(() => {
                    axios.get('/get-products/' + this.chefId)
                    .then((res) => {
                        this.loading = false
                        this.items = res.data
                        // console.log(res.data)

                        this.orderingWeekDays()
                    })
                }, 500);

            },
            getTimes() {

            },
            setNow() {
                this.now = moment().unix()
            },
            openDays(index, event) {
                this.itemIndex = index
                this.showDays = true
                // console.log(event)
            },
            calculateWeekDaysArray() {
                const weekRange = moment.range(moment(), moment().add(6, 'days'));
                const ArrayWeek = Array.from(weekRange.by('days'))
                this.weekDays = ArrayWeek.map(d => d.format('ddd'))
                this.weekDays[0] = "HOJE";

                // Todo: usar https://github.com/phoenixwong/vue2-timepicker no painel para selecionar os horários.

            },
            selectDate(weekday) {
                this.selectedDay = weekday
                this.setNow()

                // O array do banco tem que chegar aqui
                this.filterFromNow(['2017-07-20 10:00','2017-07-20 20:00', '2017-07-20 21:00'], weekday)

                // console.log(this.selectedDay.times)

                this.$refs.modalTime.open()
                this.selectedTime = ""
            },
            closeModalAndSubmit(ref) {
                this.$refs.modalTime.close()

                //add to the cart
            },
            orderingWeekDays() {

                    this.items.forEach( (item, index) => {
                        if (this.items[index].extras.length > 0) {

                            // Pegando o array com extras de cada produto
                            let thisExtraItems = this.items[index].extras

                            // Crio um array com os dias da semana, com o primeiro dia sendo o dia atual (Hoje)                             
                            const weekRange = moment.range(moment(), moment().add(6, 'days'));
                            const ArrayWeek = Array.from(weekRange.by('days'))
                            let ArrayWeekFinal = ArrayWeek.map(d => d.format('ddd'))

                            // Ordeno meu array com os extras de acordo com a ordem do array com os dias da semana
                            thisExtraItems.sort(function(a,b) { 
                                return ArrayWeekFinal.indexOf(a.date) > ArrayWeekFinal.indexOf(b.date); 
                            });
                            // console.log(thisExtraItems)

                        }
                    })

            },
            filterFromNow(times, weekday) {

                console.log("Agora são: " + moment(this.now).format('HH[H]mm'))
                console.log("Dia selecionado: " + weekday)
                console.log(times)
                console.log("NOW " + this.now)

                if (weekday == "HOJE") {
                    this.product.times = []
                    for (let i = 0 ; i < times.length ; i++){
                        console.log(moment(times[i]).unix())
                        if (moment(times[i]).unix() > this.now)
                           this.product.times.push(times[i])
                    }
                } else {
                    this.product.times = times
                }
            },
            formatTime(time) {
                return moment(time).format('HH[h]mm')
            },
            formatTimeMore30(timeSelected) {
                return moment(timeSelected).add(30, 'm').format('HH[h]mm')
                // console.log(date)
            }

        },
        mounted() {

            this.getProducts()

        },
        created() {
            this.setNow()
            this.calculateWeekDaysArray()
            // console.log(this.chef.times)


            // Chega aqui do Banco o valor de start e de end do dia selecionado pelo user
            const timesTest = moment.range('2017-07-20 10:00', '2017-07-20 21:00')
            const times = Array.from(timesTest.by('hours'))

            this.product.times = times.map(m => m.format('YYYY-MM-DD HH:mm'))

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